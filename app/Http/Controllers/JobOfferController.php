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

// use Slack;

class JobOfferController extends Controller
{
    public function index(Request $request)
    {
        $draftJobOffers = DraftJobOffer::all();
        $users = User::all();
        $perPage = $request->per_page ?? 30;

        $jobOffers = JobOffer::when($request->userId, function ($query, $userId) {
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
        ->orderBy('created_at', 'desc')
        ->paginate($perPage)
        ->withQueryString();

        return view('job_offers.index', [
            'jobOffers' => $jobOffers,
            'draftJobOffers' => $draftJobOffers,
            'users' => $users,
        ]);
    }

    public function create(Request $request)
    {
        $jobOffers = JobOffer::all();
        $users = User::all();
        $customers = Customer::all();

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
            'carfare_1'=> ['required'],
            'carfare_payment_1'=> ['required'],
            'holiday'=> ['required'],
            'working_hours_1'=> ['required'],
            'actual_working_hours_1'=> ['required'],
            'break_time_1'=> ['required'],
            'overtime'=> ['required'],
            'commuting_by_car'=> ['required'],
            'order_date'=> ['required'],
            'status'=> ['required'],
            'parking'=> ['required'],
        ]);

        $saveData = $request->all();
        $saveData['holiday'] = json_encode($saveData['holiday']);
        if (isset($saveData['long_vacation'])) {
            $saveData['long_vacation'] = json_encode($saveData['long_vacation']);
        }

        $newJobOffer = JobOffer::create($saveData);

        $request->session()->flash('SucccessMsg', '登録しました');

        //Slack通知
        if (!$isDuplicated) {
            $path = route('job_offers.edit', ['job_offer' => $newJobOffer->id]);
            $status = config('options.status_edit')[$newJobOffer->status];
            $handlingType = config('options.handling_type')[$newJobOffer->handling_type];
            $handlingOffice = config('options.handling_office')[$newJobOffer->handling_office];

            $client = new Client();
            $content ="
```■{$status}
取扱会社種別：{$handlingType}
取扱事業所：{$handlingOffice}
営業担当：{$newJobOffer->user->name}
就業先名称と発注業務：{$newJobOffer->company_name}/{$newJobOffer->ordering_business}
お仕事番号：{$newJobOffer->job_number}
募集人数：{$newJobOffer->recruitment_number}人
予定期間：{$newJobOffer->scheduled_period}
詳細：{$path}```
";
            $response = $client->post(
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

        return redirect(route('job_offers.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $fromOrderDate = $request->query('from_order_date') ?? '';
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


        return view('job_offers.edit', [
            'jobOffer' => $jobOffer,
            'users' => $users,
            'customers' => $customers,
            'activityRecords' => $activityRecords,
            'isDraftJobOffer' => false,
            'differentUserAlert' => $differentUserAlert,
            'fromOrderDate' => $fromOrderDate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        if ($request->has('duplicate')) { // 複製ボタンが押されたときはstoreアクションが走る
            $this->store($request);
            return redirect(route('job_offers.index'));
        } elseif ($request->has('draftJobOfferId')) { // 下書きが登録された場合
            $this->store($request);
            DraftJobOffer::destroy($request->draftJobOfferId);
            return redirect(route('job_offers.index'));
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
                'carfare_1'=> ['required'],
                'carfare_payment_1'=> ['required'],
                'holiday'=> ['required'],
                'working_hours_1'=> ['required'],
                'actual_working_hours_1'=> ['required'],
                'break_time_1'=> ['required'],
                'overtime'=> ['required'],
                'commuting_by_car'=> ['required'],
                'order_date'=> ['required'],
                'status'=> ['required'],
                'parking'=> ['required'],
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
            $jobOffer->customer_id= $request->input('customer_id');
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
                $path = route('job_offers.edit', ['job_offer' => $request->jobOfferId]);
                $status = config('options.status_edit')[$request->input('status')];
                $handlingType = config('options.handling_type')[$request->input('handling_type')];
                $handlingOffice = config('options.handling_office')[$request->input('handling_office')];

                $client = new Client();
                $content ="
```■{$status}
取扱会社種別：{$handlingType}
取扱事業所：{$handlingOffice}
営業担当：{$jobOffer->user->name}
お仕事番号：{$request->input('job_number')}
就業先名称と発注業務：{$request->input('company_name')}/{$request->input('ordering_business')}
募集人数：{$request->input('recruitment_number')}人
予定期間：{$request->input('scheduled_period')}
詳細：{$path}```
";
                $response = $client->post(
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
            return redirect(empty($request->fromOrderDate) ? route('job_offers.index') : route('jobffer.order_date.index'));
        }

    }

    public function destroy($id)
    {
        $jobOffer =jobOffer::findOrFail($id);
        $jobOffer->delete();

        \Session::flash('SucccessMsg', '削除しました');

        return redirect(route('job_offers.index'));
    }

    public function showOrderDate(Request $request)
    {
        $draftJobOffers = DraftJobOffer::all();
        $users = User::all();
        $jobOffers = JobOffer::when($request->userId, function ($query, $userId) {
            return $query->where('user_id', $userId);
        })
        ->when($request->companyName, function ($query, $companyName) {
            return $query->where('company_name', 'like' , "%{$companyName}%");
        })
        ->when($request->jobNumber, function ($query, $jobNumber) {
            return $query->where('job_number', $jobNumber);
        })
        ->when($request->orderingBusiness, function ($query, $orderingBusiness) {
            return $query->where('ordering_business', $orderingBusiness);
        })
        ->when($request->orderDateStart, function ($query, $orderDateStart) {
            return $query->whereDate('order_date', '>=', $orderDateStart);
        })
        ->when($request->orderDateEnd, function ($query, $orderDateEnd) {
            return $query->whereDate('order_date', '<=', $orderDateEnd);
        })
        ->when($request->postingSite, function ($query, $postingSite) {
            return $query->whereIn('posting_site', $postingSite);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        return view('job_offers.order', [
            'jobOffers' => $jobOffers,
            'draftJobOffers' => $draftJobOffers,
            'users' => $users,
        ]);
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
        //Slack通知←どうする？todo: 要確認
        $users = User::all();
        $customers = Customer::all();
        // dd(config('options.handling_office'));
        $saveDataList = [];
        foreach ($file as $key => $line) {
            if ($key !== 0) {
                $saveDataList[] = [
                    'user_id' => $users->where('name', $line[0])->first()->id,
                    'handling_type' => strval(array_search($line[1], config('options.handling_type'))),
                    'job_number' => $line[2],
                    'handling_office' => strval(array_search($line[3], config('options.handling_office'))),
                    'business_type' => strval(array_search($line[4], config('options.business_type'))),
                    'customer_id' => $customers->where('customer_name', $line[5])->first()->id,
                    'type_contract' => strval(array_search($line[6], config('options.type_contract'))),
                    'recruitment_number' => intval($line[7]),
                    'company_name' => $line[8],
                    'company_address' => $line[9],
                    'company_others' => $line[10],
                    'ordering_business' => $line[11], // 発注業務
                    'order_details' => $line[12], // 発注業務詳細
                    'counter_measures' => $line[13], // 喫煙対策内容
                    'invoice_unit_price_1' => $line[14], // 請求単価①
                ];
dd($saveDataList);
                //
                //
                //
                //
                //     'new_reorder' =>
                //
                //
                //
                //
                //
                //
                //
                //     'invoice_unit_price_1' =>
                //     'billing_unit_1' =>
                //     'profit_rate_1' =>
                //     'billing_information_1' =>
                //     'invoice_unit_price_2' =>
                //     'billing_unit_2' =>
                //     'profit_rate_2' =>
                //     'billing_information_2' =>
                //     'invoice_unit_price_3' =>
                //     'billing_unit_3' =>
                //     'profit_rate_3' =>
                //     'billing_information_3' =>
                //     'employment_insurance' =>
                //     'social_insurance' =>
                //     'payment_unit_price_1' =>
                //     'payment_unit_1' =>
                //     'carfare_1' =>
                //     'carfare_payment_1' =>
                //     'carfare_payment_remarks_1' =>
                //     'employment_insurance_2' =>
                //     'social_insurance_2' =>
                //     'payment_unit_price_2' =>
                //     'payment_unit_2' =>
                //     'carfare_2' =>
                //     'carfare_payment_2' =>
                //     'carfare_payment_remarks_2' =>
                //     'employment_insurance_3' =>
                //     'social_insurance_3' =>
                //     'payment_unit_price_3' =>
                //     'payment_unit_3' =>
                //     'carfare_3' =>
                //     'carfare_payment_3' =>
                //     'carfare_payment_remarks_3' =>
                //     'scheduled_period' =>
                //     'expected_end_date' =>
                //     'period_remarks' =>
                //     'holiday' =>
                //     'long_vacation' =>
                //     'holiday_remarks' =>
                //     'working_hours_1' =>
                //     'actual_working_hours_1' =>
                //     'break_time_1' =>
                //     'overtime' =>
                //     'working_hours_remarks' =>
                //     'working_hours_2' =>
                //     'actual_working_hours_2' =>
                //     'break_time_2' =>
                //     'working_hours_3' =>
                //     'actual_working_hours_3' =>
                //     'break_time_3' =>
                //     'nearest_station' =>
                //     'travel_time_station' =>
                //     'nearest_bus_stop' =>
                //     'travel_time_bus_stop' =>
                //     'commuting_by_car' =>
                //     'traffic_commuting_remarks' =>
                //     'parking' =>
                //     'posting_site' =>
                //     'status' =>
                //     'job_withdrawal' =>
                //     'order_date' =>
                //     'qualification' =>
                //     'qualification_content' =>
                //     'experience' =>
                //     'experience_content' =>
                //     'sex' =>
                //     'age' =>
                //     'uniform_supply' =>
                //     'supply' =>
                //     'clothes' =>
                //     'other_hair_colors' =>
                //     'self_prepared' =>
                //     'remarks_workplace' =>
                //     'gender_ratio' =>
                //     'age_ratio' =>
                //     'after_introduction' =>
                //     'timing_of_switching' =>
                //     'monthly_lower_limit' =>
                //     'monthly_upper_limit' =>
                //     'annual_lower_limit' =>
                //     'annual_upper_limit' =>
                //     'bonuses_treatment' =>
                //     'holidays_vacations' =>
                //     'introduction_others' =>
                // ];
            }
        }
        // 一時ファイル削除
        unlink($filepath);
        // DB保存
        $saveData['holiday'] = json_encode($saveData['holiday']);
        if (isset($saveData['long_vacation'])) {
            $saveData['long_vacation'] = json_encode($saveData['long_vacation']);
        }

        $newJobOffer = JobOffer::insert($saveDataList);

        $request->session()->flash('SucccessMsg', '登録しました');

        return redirect(route('job_offers.index'));
    }

}

