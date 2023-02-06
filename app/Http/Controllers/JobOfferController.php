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
        $jobOffers = JobOffer::all();
        $draftJobOffers = DraftJobOffer::all();
        $users = User::all();

        foreach ($draftJobOffers as $index => $draftJobOffer){
            if (isset($draftJobOffer->user_id)) {
                foreach ($users as $user) {
                    if ($user->id == $draftJobOffer->user_id ){
                        $draftJobOffers[$index]['user_id'] = $user->name;
                    }
                }
            }
        }


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
            return $query->where('status', $status);
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
                    ->orWhere('long_vacation', 'LIKE', "%{$keyword}%");
                });
            }

            return $query;
        })
        ->get();

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
        if ($request->has('duplicate')) { // 複製ボタンが押されたときはstoreアクションが走る
            $request['company_name'] = $request['company_name'] . 'のコピー';

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
        ]);

        $saveData = $request->all();
        $saveData['holiday'] = json_encode($saveData['holiday']);
        if (isset($saveData['long_vacation'])) {
            $saveData['long_vacation'] = json_encode($saveData['long_vacation']);
        }

        $newJobOffer = JobOffer::create($saveData);

        $request->session()->flash('SucccessMsg', '登録しました');

        //Slack通知
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

        return redirect(route('job_offers.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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


        return view('job_offers.edit', [
            'jobOffer' => $jobOffer,
            'users' => $users,
            'customers' => $customers,
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
        if ($request->has('duplicate')) { // 複製ボタンが押されたときはstoreアクションが走る
            $this->store($request);
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
            ]);
            // $updatedStatus Slack通知の本文で使用する変数
            $updatedStatus = config('options.status_edit')[$request->input('status')];

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
            $jobOffer->age_upper_limit= $request->input('age_upper_limit');
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

            return redirect(route('job_offers.index'));
        }

    }

    public function destroy($id)
    {
        $jobOffer =jobOffer::findOrFail($id);
        $jobOffer->delete();

        \Session::flash('SucccessMsg', '削除しました');

        return redirect(route('job_offers.index'));
    }

}
