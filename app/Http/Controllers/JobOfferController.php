<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOffer;
use App\Models\DraftJobOffer;
use App\Models\User;
use App\Models\Customer;
use App\Models\ActivityRecord;
use GuzzleHttp\Client;
use Auth;
use Carbon\Carbon;

use App\Http\Controllers\DraftJobOfferController;

use function Ramsey\Uuid\v1;

// use Slack;

class JobOfferController extends Controller
{
    public function index(Request $request)
    {
        $draftJobOffers = DraftJobOffer::all();
        $users = User::all();
        $customers = Customer::all();
        $perPage = $request->per_page ?? 30;

        // todo: 企業ランクを有効化する際に下のwhereNotInを復活させる
        $jobOffers = JobOffer::whereNotIn('rank', ['C', 'D'])
        ->when($request->userId, function ($query, $userId) {
            return $query->where('user_id', $userId);
        })
        ->when($request->customerName, function ($query, $customerName) {
            $customerId = Customer::where('customer_name', $customerName)->first()->id;
            return $query->where('customer_id', $customerId);
        })
        ->when($request->companyName, function ($query, $companyName) {
            return $query->where('company_name', 'like' , "%{$companyName}%");
        })
        ->when($request->jobNumber, function ($query, $jobNumber) {
            return $query->where('job_number', $jobNumber);
        })
        ->when($request->status, function ($query, $status) {
            return $query->whereIn('status', $status);
        })
        ->when($request->orderDateStart, function ($query, $orderDateStart) {
            return $query->whereDate('order_date', '>=', $orderDateStart);
        })
        ->when($request->orderDateEnd, function ($query, $orderDateEnd) {
            return $query->whereDate('order_date', '<=', $orderDateEnd);
        })
        ->when($request->keywords, function ($query, $keywords) {
            $smallSpaceKeywords = mb_convert_kana($keywords, 's');
            $keywords = explode(' ', $smallSpaceKeywords);

            // キーワードはAND、カラムはOR
            foreach($keywords as $keyword) {
                if (array_search($keyword, config('options.holiday'))) {
                    $keyword = array_search($keyword, config('options.holiday'));
                }
                if (array_search($keyword, config('options.long_vacation'))) {
                    $keyword = array_search($keyword, config('options.long_vacation'));
                }
                $query->where(function($query) use ($keyword){
                    $query->where('company_name', 'LIKE', "%{$keyword}%")
                        ->orWhere('company_address', 'LIKE', "%{$keyword}%")
                        ->orWhere('ordering_business', 'LIKE', "%{$keyword}%")
                        ->orWhere('order_details', 'LIKE', "%{$keyword}%")
                        ->orWhere('scheduled_period', 'LIKE', "%{$keyword}%")
                        ->orWhere('holiday', 'LIKE', "%{$keyword}%")
                        ->orWhere('long_vacation', 'LIKE', "%{$keyword}%")
                        ->orWhere('scheduled_period', 'LIKE', "%{$keyword}%");
                });
            }

            return $query;
        })
        ->orderBy('id', 'desc')
        ->paginate($perPage)
        ->withQueryString();

        return view('job_offers.index', [
            'jobOffers' => $jobOffers,
            'draftJobOffers' => $draftJobOffers,
            'users' => $users,
            'customers' => $customers,
        ]);
    }

    public function showInvalids(Request $request)
    {
        $users = User::all();
        $perPage = $request->per_page ?? 30;

        $jobOffers = JobOffer::whereIn('rank', ['C', 'D'])
        ->when($request->userId, function ($query, $userId) {
            return $query->where('user_id', $userId);
        })
        ->when($request->companyName, function ($query, $companyName) {
            return $query->where('company_name', 'like' , "%{$companyName}%");
        })
        ->when($request->jobNumber, function ($query, $jobNumber) {
            return $query->where('job_number', $jobNumber);
        })
        ->when($request->status, function ($query, $status) {
            return $query->whereIn('status', $status);
        })
        ->when($request->orderDateStart, function ($query, $orderDateStart) {
            return $query->whereDate('order_date', '>=', $orderDateStart);
        })
        ->when($request->orderDateEnd, function ($query, $orderDateEnd) {
            return $query->whereDate('order_date', '<=', $orderDateEnd);
        })
        ->when($request->keywords, function ($query, $keywords) {
            $smallSpaceKeywords = mb_convert_kana($keywords, 's');
            $keywords = explode(' ', $smallSpaceKeywords);

            // キーワードはAND、カラムはOR
            foreach($keywords as $keyword) {
                if (array_search($keyword, config('options.holiday'))) {
                    $keyword = array_search($keyword, config('options.holiday'));
                }
                if (array_search($keyword, config('options.long_vacation'))) {
                    $keyword = array_search($keyword, config('options.long_vacation'));
                }
                $query->where(function($query) use ($keyword){
                    $query->where('company_name', 'LIKE', "%{$keyword}%")
                        ->orWhere('company_address', 'LIKE', "%{$keyword}%")
                        ->orWhere('ordering_business', 'LIKE', "%{$keyword}%")
                        ->orWhere('order_details', 'LIKE', "%{$keyword}%")
                        ->orWhere('scheduled_period', 'LIKE', "%{$keyword}%")
                        ->orWhere('holiday', 'LIKE', "%{$keyword}%")
                        ->orWhere('long_vacation', 'LIKE', "%{$keyword}%")
                        ->orWhere('scheduled_period', 'LIKE', "%{$keyword}%");
                });
            }

            return $query;
        })
        ->orderBy('id', 'desc')
        ->paginate($perPage)
        ->withQueryString();

        return view('invalid_job_offers.index', [
            'jobOffers' => $jobOffers,
            'users' => $users,
        ]);
    }

    public function create(Request $request)
    {
        $jobOffers = JobOffer::all();
        $users = User::all();
        $customers = Customer::where('is_show', 1)->get();

        return view('job_offers.create', [
            'jobOffers' => $jobOffers,
            'users' => $users,
            'customers' => $customers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Slack通知を制御するフラグ false: 通知する true: 通知しない
        $isDuplicated = false;
        if ($request->has('duplicate')) { // 複製ボタンが押されたときはstoreアクションが走る
            $request['company_name'] = $request['company_name'] . 'のコピー';
            $isDuplicated = true;
        }
        $request->validate([
            'user_id' => ['required'],
            'handling_type' => ['required'],
            'handling_office'=> ['required'],
            'customer_id'=> ['required'],
            'type_contract'=> ['required'],
            'recruitment_number'=> ['required'],
            'company_name'=> ['required'],
            'company_address'=> ['required'],
            'ordering_business'=> ['required'],
            'order_details'=> ['required'],
            'invoice_unit_price_1'=> ['required'],
            'billing_unit_1'=> ['required'],
            'profit_rate_1'=> ['required'],
            'employment_insurance'=> ['required'],
            'social_insurance'=> ['required'],
            'payment_unit_price_1'=> ['required'],
            'payment_unit_1'=> ['required'],
            'holiday'=> ['required'],
            'working_hours_1'=> ['required'],
            'actual_working_hours_1'=> ['required'],
            'break_time_1'=> ['required'],
            'overtime'=> ['required'],
            'commuting_by_car'=> ['required'],
            'order_date'=> ['required'],
            'status'=> ['required'],
            'parking'=> ['required'],
            // 'number_of_ordering_bases' => ['required'],
            // 'order_number' => ['required'],
            // 'transaction_duration' => ['required'],
            // 'expected_sales' => ['required'],
            // 'profit_rate' => ['required'],
            // 'special_matters' => ['required'],
        ]);

        $saveData = $request->all();
        $customerId = Customer::where('customer_name', $saveData['customer_id'])->first()->id;
        $saveData['customer_id'] = $customerId;
        $saveData['holiday'] = json_encode($saveData['holiday']);
        if (isset($saveData['long_vacation'])) {
            $saveData['long_vacation'] = json_encode($saveData['long_vacation']);
        }
		// 企業ランク
        $customer = Customer::find($customerId);
		$customerRankPoint = $customer->getCustomerRankPoint();
		// 商談ランク
		$numberOfOrderingBasesPoint = config('points.numberOfOrderingBases')[intval($request->input('number_of_ordering_bases'))];
        $orderNumberPoint = config('points.orderNumber')[intval($request->input('order_number'))];
        $transactionDurationPoint = config('points.transactionDuration')[intval($request->input('transaction_duration'))];
        $expectedSalesPoint = config('points.expectedSales')[intval($request->input('expected_sales'))];
        $profitRatePoint = config('points.profitRate')[intval($request->input('profit_rate'))];
        $specialMattersPoint = config('points.specialMatters')[intval($request->input('special_matters'))];

        $negotiationPoint = $numberOfOrderingBasesPoint
            + $orderNumberPoint
            + $transactionDurationPoint
            + $expectedSalesPoint
            + $profitRatePoint
            + $specialMattersPoint;

		// 求人ランク
        $jobOfferRank = $customerRankPoint + $negotiationPoint;

        if ($jobOfferRank > 90) {
            $rank = 'SS';
        } elseif ($jobOfferRank > 80) {
            $rank = 'S';
        } elseif ($jobOfferRank > 70) {
            $rank = 'A';
        } elseif ($jobOfferRank > 50) {
            $rank = 'B';
        } elseif ($jobOfferRank > 20) {
            $rank = 'C';
        } else {
            $rank = 'D';
        }
        // todo: 企業ランクを有効化する際は以下の行のコメントを外す
        $saveData['rank'] = $rank;
        $newJobOffer = JobOffer::create($saveData);

        $request->session()->flash('SucccessMsg', '登録しました');

        //Slack通知
        if (!$isDuplicated) {
            $path = route('job_offers.detail', ['id' => $newJobOffer->id]);
            $status = config('options.status_edit')[$newJobOffer->status];
            $handlingType = config('options.handling_type')[$newJobOffer->handling_type];
            $handlingOffice = config('options.handling_office')[$newJobOffer->handling_office];
            $typeContract = config('options.type_contract')[$newJobOffer->type_contract];

            $client = new Client();

            if($status == '新規作成'){
                $content ="
■{$status}
取扱会社種別：{$handlingType}
取扱事業所：{$handlingOffice}
営業担当：{$newJobOffer->user->name}
就業先名称と発注業務：{$request->input('company_name')}/{$request->input('ordering_business')}
募集人数：{$request->input('recruitment_number')}人
予定期間：{$request->input('scheduled_period')}
契約形態：{$typeContract}
                ";
            } else if ($status == '再発注'){
                $content ="
■{$status}
取扱会社種別：{$handlingType}
取扱事業所：{$handlingOffice}
営業担当：{$newJobOffer->user->name}
お仕事番号：{$request->input('job_number')}
就業先名称と発注業務：{$request->input('company_name')}/{$request->input('ordering_business')}
募集人数：{$request->input('recruitment_number')}人
予定期間：{$request->input('scheduled_period')}
                ";
        }

            $client->post(
                config('slack.webhook_url'),
                [
                    'headers' => [
                        'Content-Type'	=>	'application/json',
                    ],
                    'json' => [
                        'text' => $content
                    ]
                ]
            );
        }
        // todo: 企業ランクを有効化する際は以下の行のコメントを外す
        if ($jobOfferRank < 51) {
			return redirect(route('invalid_job_offers.index'));
        }

        return redirect(route('job_offers.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $jobOffer = JobOffer::find($id);
        $jobOffer['holiday'] = json_decode($jobOffer['holiday']);
        if ($jobOffer['long_vacation']) {
            $jobOffer['long_vacation'] = json_decode($jobOffer['long_vacation']);
        }

        $users = User::all();
        $customers = Customer::where('is_show', 1)->get();
        $activityRecords = $jobOffer->activityRecords;

        $differentUserAlert = false;
        if (Auth::id() != $jobOffer->user->id) {
            $differentUserAlert = true;
            \Session::flash('AlertMsg', '警告：データーベースに登録されている営業担当とログインユーザーが一致しません');
        }

        $customerName = Customer::where('id', $jobOffer->customer_id)->first()->customer_name;
        return view('job_offers.edit', [
            'jobOffer' => $jobOffer,
            'users' => $users,
            'customers' => $customers,
            'customerName' => $customerName,
            'activityRecords' => $activityRecords,
            'isDraftJobOffer' => false,
            'differentUserAlert' => $differentUserAlert,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        $customerId = Customer::where('customer_name', $request->input('customer_id'))->first()->id;
        if ($request->has('duplicate')) { // 複製ボタンが押されたときはstoreアクションが走る
            $this->store($request);
            return redirect(route('job_offers.index'));
        } elseif ($request->has('draftJobOfferId')) { // 下書きが登録された場合
            DraftJobOffer::destroy($request->draftJobOfferId);
            return $this->store($request);
        } else {
            $request->validate([
                'user_id' => ['required'],
                'handling_type' => ['required'],
                'handling_office'=> ['required'],
                'customer_id'=> ['required'],
                'type_contract'=> ['required'],
                'recruitment_number'=> ['required'],
                'company_name'=> ['required'],
                'company_address'=> ['required'],
                'ordering_business'=> ['required'],
                'order_details'=> ['required'],
                'invoice_unit_price_1'=> ['required'],
                'billing_unit_1'=> ['required'],
                'profit_rate_1'=> ['required'],
                'employment_insurance'=> ['required'],
                'social_insurance'=> ['required'],
                'payment_unit_price_1'=> ['required'],
                'payment_unit_1'=> ['required'],
                'holiday'=> ['required'],
                'working_hours_1'=> ['required'],
                'actual_working_hours_1'=> ['required'],
                'break_time_1'=> ['required'],
                'overtime'=> ['required'],
                'commuting_by_car'=> ['required'],
                'order_date'=> ['required'],
                'status'=> ['required'],
                'parking'=> ['required'],
                // 'number_of_ordering_bases' => ['required'],
                // 'order_number' => ['required'],
                // 'transaction_duration' => ['required'],
                // 'expected_sales' => ['required'],
                // 'profit_rate' => ['required'],
                // 'special_matters' => ['required'],
            ]);

            // 求人情報の更新処理
            $jobOffer = JobOffer::find($request->jobOfferId);
            // Slack通知をするかしないか判定するためのフラグ
            $statusIsUpdated = false;

            if ($jobOffer->status != $request->input('status')) {
                $statusIsUpdated = true;
            }

            $jobOffer->user_id= $request->input('user_id');
            $jobOffer->handling_type= $request->input('handling_type');
            $jobOffer->job_number= $request->input('job_number');
            $jobOffer->handling_office= $request->input('handling_office');
            $jobOffer->business_type= $request->input('business_type');
            $jobOffer->customer_id= $customerId;
            $jobOffer->type_contract= $request->input('type_contract');
            $jobOffer->recruitment_number= $request->input('recruitment_number');
            $jobOffer->company_name= $request->input('company_name');
            $jobOffer->company_address= $request->input('company_address');
            $jobOffer->company_others= $request->input('company_others');
            $jobOffer->ordering_business= $request->input('ordering_business');
            $jobOffer->order_details= $request->input('order_details');
            $jobOffer->counter_measures= $request->input('counter_measures');
            $jobOffer->invoice_unit_price_1= $request->input('invoice_unit_price_1');
            $jobOffer->billing_unit_1= $request->input('billing_unit_1');
            $jobOffer->profit_rate_1= $request->input('profit_rate_1');
            $jobOffer->billing_information_1= $request->input('billing_information_1');
            $jobOffer->invoice_unit_price_2= $request->input('invoice_unit_price_2');
            $jobOffer->billing_unit_2= $request->input('billing_unit_2');
            $jobOffer->profit_rate_2= $request->input('profit_rate_2');
            $jobOffer->billing_information_2= $request->input('billing_information_2');
            $jobOffer->invoice_unit_price_3= $request->input('invoice_unit_price_3');
            $jobOffer->billing_unit_3= $request->input('billing_unit_3');
            $jobOffer->profit_rate_3= $request->input('profit_rate_3');
            $jobOffer->billing_information_3= $request->input('billing_information_3');
            $jobOffer->employment_insurance= $request->input('employment_insurance');
            $jobOffer->social_insurance= $request->input('social_insurance');
            $jobOffer->payment_unit_price_1= $request->input('payment_unit_price_1');
            $jobOffer->payment_unit_1= $request->input('payment_unit_1');
            $jobOffer->carfare_1= $request->input('carfare_1');
            $jobOffer->carfare_payment_1= $request->input('carfare_payment_1');
            $jobOffer->carfare_payment_remarks_1= $request->input('carfare_payment_remarks_1');
            $jobOffer->employment_insurance_2= $request->input('employment_insurance_2');
            $jobOffer->social_insurance_2= $request->input('social_insurance_2');
            $jobOffer->payment_unit_price_2= $request->input('payment_unit_price_2');
            $jobOffer->payment_unit_2= $request->input('payment_unit_2');
            $jobOffer->carfare_2= $request->input('carfare_2');
            $jobOffer->carfare_payment_2= $request->input('carfare_payment_2');
            $jobOffer->carfare_payment_remarks_2= $request->input('carfare_payment_remarks_2');
            $jobOffer->employment_insurance_3= $request->input('employment_insurance_3');
            $jobOffer->social_insurance_3= $request->input('social_insurance_3');
            $jobOffer->payment_unit_price_3= $request->input('payment_unit_price_3');
            $jobOffer->carfare_payment_3= $request->input('carfare_payment_3');
            $jobOffer->carfare_3= $request->input('carfare_3');
            $jobOffer->carfare_payment_remarks_3= $request->input('carfare_payment_remarks_3');
            $jobOffer->scheduled_period= $request->input('scheduled_period');
            $jobOffer->expected_end_date= $request->input('expected_end_date');
            $jobOffer->period_remarks= $request->input('period_remarks');
            $jobOffer->holiday= $request->input('holiday');
            $jobOffer->long_vacation= $request->input('long_vacation');
            $jobOffer->holiday_remarks= $request->input('holiday_remarks');
            $jobOffer->working_hours_1= $request->input('working_hours_1');
            $jobOffer->actual_working_hours_1= $request->input('actual_working_hours_1');
            $jobOffer->break_time_1= $request->input('break_time_1');
            $jobOffer->overtime= $request->input('overtime');
            $jobOffer->working_hours_remarks= $request->input('working_hours_remarks');
            $jobOffer->working_hours_2= $request->input('working_hours_2');
            $jobOffer->actual_working_hours_2= $request->input('actual_working_hours_2');
            $jobOffer->break_time_2= $request->input('break_time_2');
            $jobOffer->working_hours_3= $request->input('working_hours_3');
            $jobOffer->actual_working_hours_3= $request->input('actual_working_hours_3');
            $jobOffer->break_time_3= $request->input('break_time_3');
            $jobOffer->nearest_station= $request->input('nearest_station');
            $jobOffer->travel_time_station= $request->input('travel_time_station');
            $jobOffer->nearest_bus_stop= $request->input('nearest_bus_stop');
            $jobOffer->travel_time_bus_stop= $request->input('travel_time_bus_stop');
            $jobOffer->commuting_by_car= $request->input('commuting_by_car');
            $jobOffer->traffic_commuting_remarks= $request->input('traffic_commuting_remarks');
            $jobOffer->parking= $request->input('parking');
            $jobOffer->posting_site= $request->input('posting_site');
            $jobOffer->qualification= $request->input('qualification');
            $jobOffer->qualification_content= $request->input('qualification_content');
            $jobOffer->experience= $request->input('experience');
            $jobOffer->experience_content= $request->input('experience_content');
            $jobOffer->sex= $request->input('sex');
            $jobOffer->age= $request->input('age');
            $jobOffer->uniform_supply= $request->input('uniform_supply');
            $jobOffer->supply= $request->input('supply');
            $jobOffer->clothes= $request->input('clothes');
            $jobOffer->other_hair_colors= $request->input('other_hair_colors');
            $jobOffer->self_prepared= $request->input('self_prepared');
            $jobOffer->remarks_workplace= $request->input('remarks_workplace');
            $jobOffer->gender_ratio= $request->input('gender_ratio');
            $jobOffer->age_ratio= $request->input('age_ratio');
            $jobOffer->after_introduction= $request->input('after_introduction');
            $jobOffer->timing_of_switching= $request->input('timing_of_switching');
            $jobOffer->monthly_lower_limit= $request->input('monthly_lower_limit');
            $jobOffer->monthly_upper_limit= $request->input('monthly_upper_limit');
            $jobOffer->annual_lower_limit= $request->input('annual_lower_limit');
            $jobOffer->annual_upper_limit= $request->input('annual_upper_limit');
            $jobOffer->bonuses_treatment= $request->input('bonuses_treatment');
            $jobOffer->holidays_vacations= $request->input('holidays_vacations');
            $jobOffer->introduction_others= $request->input('introduction_others');
            $jobOffer->status= $request->input('status');
            $jobOffer->order_date= $request->input('order_date');
            $jobOffer->number_of_ordering_bases= $request->input('number_of_ordering_bases');
            $jobOffer->transaction_duration= $request->input('transaction_duration');
            $jobOffer->expected_sales= $request->input('expected_sales');
            $jobOffer->profit_rate= $request->input('profit_rate');
            $jobOffer->special_matters= $request->input('special_matters');
            $jobOffer->job_withdrawal = $request->input('job_withdrawal');

            $jobOffer->save();
            $request->session()->flash('SucccessMsg', '保存しました');

            // 活動記録の登録処理
            if( $request->filled(['date', 'item']) ) { // 活動記録が空の場合はレコードを作成しない
                ActivityRecord::create([
                    'date' => $request->input('date'),
                    'item' => $request->input('item'),
                    'detail' => $request->input('detail'),
                    'job_offer_id' => $request->input('job_offer_id'),
                ]);
            }

            //Slack通知
            if ($statusIsUpdated) {
                // $path = route('job_offers.detail', ['job_offer' => $request->jobOfferId]);
                $path = route('job_offers.detail', $request->jobOfferId);
                $status = config('options.status_edit')[$request->input('status')];
                $handlingType = config('options.handling_type')[$request->input('handling_type')];
                $handlingOffice = config('options.handling_office')[$request->input('handling_office')];
                $typeContract = config('options.type_contract')[$request->input('type_contract')];
                $jobwithDrawal = $request->input('job_withdrawal') ? config('options.job_withdrawal')[$request->input('job_withdrawal')] : "未記入";
                $client = new Client();

                if($status == '新規作成'){
                    $content ="
■{$status}
取扱会社種別：{$handlingType}
取扱事業所：{$handlingOffice}
営業担当：{$jobOffer->user->name}
就業先名称と発注業務：{$request->input('company_name')}/{$request->input('ordering_business')}
募集人数：{$request->input('recruitment_number')}人
予定期間：{$request->input('scheduled_period')}
契約形態：{$typeContract}
詳細：{$path}
                    ";
                } else if ($status == '再発注'){
                    $content ="
■{$status}
取扱会社種別：{$handlingType}
取扱事業所：{$handlingOffice}
営業担当：{$jobOffer->user->name}
お仕事番号：{$request->input('job_number')}
就業先名称と発注業務：{$request->input('company_name')}/{$request->input('ordering_business')}
募集人数：{$request->input('recruitment_number')}人
予定期間：{$request->input('scheduled_period')}
契約形態：{$typeContract}
詳細：{$path}
                    ";
                    } else if ($status == '更新/編集'){
                        $content ="
■{$status}
取扱事業所：{$handlingOffice}
営業担当：{$jobOffer->user->name}
お仕事番号：{$request->input('job_number')}
就業先名称と発注業務：{$request->input('company_name')}/{$request->input('ordering_business')}
詳細：{$path}
                        ";
                    } else if ($status == '案件終了'){
                        $content ="
■{$status}
取扱会社種別：{$handlingType}
取扱事業所：{$handlingOffice}
お仕事番号：{$request->input('job_number')}
就業先名称と発注業務：{$request->input('company_name')}/{$request->input('ordering_business')}
求人取り下げの理由：{$jobwithDrawal}
詳細：{$path}
                        ";
                    }
                $client->post(
                    config('slack.webhook_url'),
                    [
                        'headers' => [
                            'Content-Type'	=>	'application/json',
                        ],
                        'json' => [
                            'text' => $content
                        ]
                    ]
                );
            }
            return redirect(route('job_offers.detail', $jobOffer->id));
        }

    }

    public function destroy($id)
    {
        $jobOffer =jobOffer::findOrFail($id);
        $jobOffer->delete();

        \Session::flash('SucccessMsg', '削除しました');

        return redirect(route('job_offers.index'));
    }

    public function importCsv(Request $request)
    {// 1ファイルで複数レコードを保存できる仕様
        // CSV一時保存
        $tmp = mt_rand() . "." . $request->file('csv_import')->guessExtension();
        $request->file('csv_import')->move(public_path() . "/tmp", $tmp);
        $filepath = public_path() . "/tmp/" . $tmp;

        // CSVデータ取得
        $file = new \SplFileObject($filepath);
        $file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        // バリデーション（後々実装）
        $users = User::all();
        $customers = Customer::all();

        $hasErrors = false;
        $errorMsgs = [];
        $saveDataList = [];
        foreach ($file as $key => $line) {
            if ($key !== 0) {
                if (empty($line[0]) || empty($line[5])) {
                    continue;
                }
                // DB保存のためにデータ整形
                $_holidays = [
                    $line[56] == "TRUE" ? 'mon' : '',
                    $line[57] == "TRUE" ? 'tue' : '',
                    $line[58] == "TRUE" ? 'wed' : '',
                    $line[59] == "TRUE" ? 'thu' : '',
                    $line[60] == "TRUE" ? 'fri' : '',
                    $line[61] == "TRUE" ? 'sat' : '',
                    $line[62] == "TRUE" ? 'sun' : '',
                    $line[63] == "TRUE" ? 'holiday' : '',
                    $line[64] == "TRUE" ? 'shift' : '',
                ];
                $_holidays = array_filter($_holidays);
                $holidays = [];
                foreach ($_holidays as $holiday) {
                    $holidays[] = $holiday;
                }

                $_longVacations = [
                    $line[65] == "TRUE" ? 'goldenweek' : '',
                    $line[66] == "TRUE" ? 'newyears_holiday' : '',
                    $line[67] == "TRUE" ? 'obon' : '',
                ];
                $_longVacations = array_filter($_longVacations);
                $longVacations = [];
                foreach ($_longVacations as $longVacation) {
                    $longVacations[] = $longVacation;
                }

                // 営業担当バリデーション
                $user = $users->where('name', $line[0])->first();
                if (is_null($user)) {
                    $errorMsgs[] = "{$line[0]}という営業担当は登録されていません。";
                    $hasErrors = true;
                }

                // 顧客名バリデーション
                $customer = $customers->where('customer_name', $line[5])->first();
                if (is_null($customer)) {
                    $errorMsgs[] = "{$line[5]}という顧客名は登録されていません。";
                    $hasErrors = true;
                }

                $saveDataList[] = [
                    'user_id' => is_null($user) ? 0 : $user->id, // 営業担当
                    'handling_type' => strval(array_search($line[1], config('options.handling_type'))), // 取扱会社種別
                    'job_number' => $line[2], // 仕事番号
                    'handling_office' => strval(array_search($line[3], config('options.handling_office'))),
                    'business_type' => strval(array_search($line[4], config('options.business_type'))),
                    'customer_id' => is_null($customer) ? 0 : $customer->id, // 顧客名
                    'type_contract' => strval(array_search($line[6], config('options.type_contract'))),
                    'recruitment_number' => intval($line[7]),
                    'company_name' => $line[8],
                    'company_address' => $line[9],
                    'company_others' => $line[10], // 就業先備考
                    'number_of_ordering_bases' => strval(array_search($line[11], config('options.number_of_ordering_bases'))), // 発注拠点数
                    'order_number' => strval(array_search($line[12], config('options.order_number'))), // 発注人数
                    'transaction_duration' => strval(array_search($line[13], config('options.transaction_duration'))), // 取引継続期間
                    'expected_sales' => strval(array_search($line[14], config('options.expected_sales'))), // 売上見込額
                    'profit_rate' => strval(array_search($line[15], config('options.profit_rate'))), // 利益率
                    'special_matters' => strval(array_search($line[16], config('options.special_matters'))), // 特別事項
                    'ordering_business' => $line[17], // 発注業務
                    'order_details' => $line[18], // 発注業務詳細
                    'counter_measures' => strval(array_search($line[19], config('options.counter_measures'))), // 対策内容
                    'invoice_unit_price_1' => $line[20], // 請求単価①
                    'billing_unit_1' => strval(array_search($line[21], config('options.salary_term'))), // 請求単位①
                    'profit_rate_1' => $line[22], // 利益率①
                    'billing_information_1' => $line[23], // 請求情報①備考
                    'invoice_unit_price_2' => $line[24],
                    'billing_unit_2' => strval(array_search($line[25], config('options.salary_term'))),
                    'profit_rate_2' => $line[26],
                    'billing_information_2' => $line[27],
                    'invoice_unit_price_3' => $line[28],
                    'billing_unit_3' => strval(array_search($line[29], config('options.salary_term'))),
                    'profit_rate_3' => $line[30],
                    'billing_information_3' => $line[31],
                    'employment_insurance' => strval(array_search($line[32], config('options.existence'))),
                    'social_insurance' => strval(array_search($line[33], config('options.existence'))),
                    'payment_unit_price_1' => $line[34],
                    'payment_unit_1' => strval(array_search($line[35], config('options.salary_term'))),
                    'carfare_1' => $line[36],
                    'carfare_payment_1' => strval(array_search($line[37], config('options.payment_term'))),
                    'carfare_payment_remarks_1' => $line[38],
                    'employment_insurance_2' => strval(array_search($line[39], config('options.existence'))),
                    'social_insurance_2' => strval(array_search($line[40], config('options.existence'))),
                    'payment_unit_price_2' => $line[41],
                    'payment_unit_2' => strval(array_search($line[42], config('options.salary_term'))),
                    'carfare_2' => $line[43],
                    'carfare_payment_2' => strval(array_search($line[44], config('options.payment_term'))),
                    'carfare_payment_remarks_2' => $line[45],
                    'employment_insurance_3' => strval(array_search($line[46], config('options.existence'))),
                    'social_insurance_3' => strval(array_search($line[47], config('options.existence'))),
                    'payment_unit_price_3' => $line[48],
                    'payment_unit_3' => strval(array_search($line[49], config('options.salary_term'))),
                    'carfare_3' => $line[50],
                    'carfare_payment_3' => strval(array_search($line[51], config('options.payment_term'))),
                    'carfare_payment_remarks_3' => $line[52],
                    'scheduled_period' => strval(array_search($line[53], config('options.scheduled_period'))),
                    'expected_end_date' => Carbon::parse($line[54])->toDateString(),
                    'period_remarks' => $line[55],
                    'holiday' => json_encode($holidays),
                    'long_vacation' => json_encode($longVacations),
                    'holiday_remarks' => $line[68],
                    'working_hours_1' => $line[69],
                    'actual_working_hours_1' => $line[70],
                    'break_time_1' => $line[71],
                    'overtime' => $line[72],
                    'working_hours_remarks' => $line[73],
                    'working_hours_2' => $line[74],
                    'actual_working_hours_2' => $line[75],
                    'break_time_2' => $line[76],
                    'working_hours_3' => $line[77],
                    'actual_working_hours_3' => $line[78],
                    'break_time_3' => $line[79],
                    'nearest_station' => $line[80],
                    'travel_time_station' => $line[81],
                    'nearest_bus_stop' => $line[82],
                    'travel_time_bus_stop' => $line[83],
                    'commuting_by_car' => strval(array_search($line[84], config('options.permission'))),
                    'traffic_commuting_remarks' => $line[85],
                    'parking' => strval(array_search($line[86], config('options.parking'))),
                    'status' => strval(array_search($line[87], config('options.status_edit'))),
                    'job_withdrawal' => strval(array_search($line[88], config('options.job_withdrawal'))),
                    'posting_site' => strval(array_search($line[89], config('options.posting_site'))),
                    'order_date' => Carbon::parse($line[90])->toDateString(),
                    'qualification' => strval(array_search($line[91], config('options.requirement'))),
                    'qualification_content' => $line[92],
                    'experience' => strval(array_search($line[93], config('options.requirement'))),
                    'experience_content' => $line[94],
                    'sex' => strval(array_search($line[95], config('options.sex'))),
                    'age' => $line[96],
                    'uniform_supply' => strval(array_search($line[97], config('options.uniform_supply'))),
                    'supply' => $line[98],
                    'self_prepared' => $line[99],
                    'clothes' => $line[100],
                    'other_hair_colors' => $line[101],
                    'remarks_workplace' => $line[102],
                    'gender_ratio' => $line[103],
                    'age_ratio' => $line[104],
                    'after_introduction' => $line[105],
                    'timing_of_switching' => $line[106],
                    'monthly_lower_limit' => $line[107],
                    'monthly_upper_limit' => $line[108],
                    'annual_lower_limit' => $line[109],
                    'annual_upper_limit' => $line[110],
                    'bonuses_treatment' => $line[111],
                    'holidays_vacations' => $line[112],
                    'introduction_others' => $line[113],
                ];
            }
        }

        // 一時ファイル削除
        unlink($filepath);

        // エラー処理
        if ($hasErrors) {
            return back()->withInput()->withErrors($errorMsgs);
        }

        JobOffer::insert($saveDataList);
        $request->session()->flash('SucccessMsg', '登録しました');
        return redirect(route('job_offers.index'));
    }

    public function showDetail($id)
    {
        $jobOffer = JobOffer::find($id);
        $jobOffer['holiday'] = json_decode($jobOffer['holiday']);
        if ($jobOffer['long_vacation']) {
            $jobOffer['long_vacation'] = json_decode($jobOffer['long_vacation']);
        }

        $users = User::all();
        $customers = Customer::all();
        $activityRecords = $jobOffer->activityRecords;

        $differentUserAlert = false;
        if (Auth::id() != $jobOffer->user->id) {
            $differentUserAlert = true;
            \Session::flash('AlertMsg', '警告：データーベースに登録されている営業担当とログインユーザーが一致しません');
        }


        return view('job_offers.detail', [
            'jobOffer' => $jobOffer,
            'users' => $users,
            'customers' => $customers,
            'activityRecords' => $activityRecords,
            'isDraftJobOffer' => false,
            'differentUserAlert' => $differentUserAlert,
        ]);
    }

}

