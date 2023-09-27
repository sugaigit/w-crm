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
// use Slack;

class DraftJobOfferController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $perPage = $request->per_page ?? 30;

        $draftJobOffers = DraftJobOffer::when($request->userId, function ($query, $userId) {
            return $query->where('user_id', $userId);
        })
        ->when($request->companyName, function ($query, $companyName) {
            return $query->where('company_name', 'like' , "%{$companyName}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate($perPage)
        ->withQueryString();

        return view('draft_job_offers.index', [
            'draftJobOffers' => $draftJobOffers,
            'users' => $users,
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
        $request->validate([
            'user_id' => ['required'],
            'company_name'=> ['required'],
        ]);
        $saveData = $request->all();
        if (isset($saveData['holiday'])) {
            $saveData['holiday'] = json_encode($saveData['holiday']);
        }
        if (isset($saveData['long_vacation'])) {
            $saveData['long_vacation'] = json_encode($saveData['long_vacation']);
        }

        DraftJobOffer::create($saveData);

        $request->session()->flash('SucccessMsg', '下書き保存しました');

        return redirect(route('draft.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $draftJobOffer = DraftJobOffer::find($id);

        if (isset($draftJobOffer['holiday'])) {
            $draftJobOffer['holiday'] = json_decode($draftJobOffer['holiday']);
        }
        if (isset($draftJobOffer['long_vacation'])) {
            $draftJobOffer['long_vacation'] = json_decode($draftJobOffer['long_vacation']);
        }

        $users = User::all();
        $customers = Customer::where('is_show', 1)->get();
        $activityRecords = null;

        // $differentUserAlert = false;
        // if (Auth::id() != $jobOffer->user->id) {
        //     $differentUserAlert = true;
        //     \Session::flash('AlertMsg', '警告：データーベースに登録されている営業担当とログインユーザーが一致しません');
        // }

        $customerName = Customer::where('id', $draftJobOffer->customer_id)->first()->customer_name ?? '';

        return view('draft_job_offers.edit', [
            'jobOffer' => $draftJobOffer,
            'users' => $users,
            'customers' => $customers,
            'customerName' => $customerName,
            'isDraftJobOffer' => true,
            'differentUserAlert' => false,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        // 求人情報の更新処理
        $draftJobOffer = DraftJobOffer::find($id);

        $customerId = '';
        if (!empty($request->customer_id)) {
            $customerId = Customer::where('customer_name', $request->input('customer_id'))->first()->id;
        }

        $draftJobOffer->user_id= $request->input('user_id');
        $draftJobOffer->handling_type= $request->input('handling_type');
        $draftJobOffer->job_number= $request->input('job_number');
        $draftJobOffer->handling_office= $request->input('handling_office');
        $draftJobOffer->business_type= $request->input('business_type');
        $draftJobOffer->customer_id= $customerId;
        $draftJobOffer->type_contract= $request->input('type_contract');
        $draftJobOffer->recruitment_number= $request->input('recruitment_number');
        $draftJobOffer->company_name= $request->input('company_name');
        $draftJobOffer->company_address= $request->input('company_address');
        $draftJobOffer->company_others= $request->input('company_others');
        $draftJobOffer->ordering_business= $request->input('ordering_business');
        $draftJobOffer->order_details= $request->input('order_details');
        $draftJobOffer->counter_measures= $request->input('counter_measures');
        $draftJobOffer->invoice_unit_price_1= $request->input('invoice_unit_price_1');
        $draftJobOffer->billing_unit_1= $request->input('billing_unit_1');
        $draftJobOffer->profit_rate_1= $request->input('profit_rate_1');
        $draftJobOffer->billing_information_1= $request->input('billing_information_1');
        $draftJobOffer->invoice_unit_price_2= $request->input('invoice_unit_price_2');
        $draftJobOffer->billing_unit_2= $request->input('billing_unit_2');
        $draftJobOffer->profit_rate_2= $request->input('profit_rate_2');
        $draftJobOffer->billing_information_2= $request->input('billing_information_2');
        $draftJobOffer->invoice_unit_price_3= $request->input('invoice_unit_price_3');
        $draftJobOffer->billing_unit_3= $request->input('billing_unit_3');
        $draftJobOffer->profit_rate_3= $request->input('profit_rate_3');
        $draftJobOffer->billing_information_3= $request->input('billing_information_3');
        $draftJobOffer->employment_insurance= $request->input('employment_insurance');
        $draftJobOffer->social_insurance= $request->input('social_insurance');
        $draftJobOffer->payment_unit_price_1= $request->input('payment_unit_price_1');
        $draftJobOffer->payment_unit_1= $request->input('payment_unit_1');
        $draftJobOffer->carfare_1= $request->input('carfare_1');
        $draftJobOffer->carfare_payment_1= $request->input('carfare_payment_1');
        $draftJobOffer->carfare_payment_remarks_1= $request->input('carfare_payment_remarks_1');
        $draftJobOffer->employment_insurance_2= $request->input('employment_insurance_2');
        $draftJobOffer->social_insurance_2= $request->input('social_insurance_2');
        $draftJobOffer->payment_unit_price_2= $request->input('payment_unit_price_2');
        $draftJobOffer->payment_unit_2= $request->input('payment_unit_2');
        $draftJobOffer->carfare_2= $request->input('carfare_2');
        $draftJobOffer->carfare_payment_2= $request->input('carfare_payment_2');
        $draftJobOffer->carfare_payment_remarks_2= $request->input('carfare_payment_remarks_2');
        $draftJobOffer->employment_insurance_3= $request->input('employment_insurance_3');
        $draftJobOffer->social_insurance_3= $request->input('social_insurance_3');
        $draftJobOffer->payment_unit_price_3= $request->input('payment_unit_price_3');
        $draftJobOffer->carfare_payment_3= $request->input('carfare_payment_3');
        $draftJobOffer->carfare_3= $request->input('carfare_3');
        $draftJobOffer->carfare_payment_remarks_3= $request->input('carfare_payment_remarks_3');
        $draftJobOffer->scheduled_period= $request->input('scheduled_period');
        $draftJobOffer->expected_end_date= $request->input('expected_end_date');
        $draftJobOffer->period_remarks= $request->input('period_remarks');
        $draftJobOffer->holiday= $request->input('holiday');
        $draftJobOffer->long_vacation= $request->input('long_vacation');
        $draftJobOffer->holiday_remarks= $request->input('holiday_remarks');
        $draftJobOffer->working_hours_1= $request->input('working_hours_1');
        $draftJobOffer->actual_working_hours_1= $request->input('actual_working_hours_1');
        $draftJobOffer->break_time_1= $request->input('break_time_1');
        $draftJobOffer->overtime= $request->input('overtime');
        $draftJobOffer->working_hours_remarks= $request->input('working_hours_remarks');
        $draftJobOffer->working_hours_2= $request->input('working_hours_2');
        $draftJobOffer->actual_working_hours_2= $request->input('actual_working_hours_2');
        $draftJobOffer->break_time_2= $request->input('break_time_2');
        $draftJobOffer->working_hours_3= $request->input('working_hours_3');
        $draftJobOffer->actual_working_hours_3= $request->input('actual_working_hours_3');
        $draftJobOffer->break_time_3= $request->input('break_time_3');
        $draftJobOffer->nearest_station= $request->input('nearest_station');
        $draftJobOffer->travel_time_station= $request->input('travel_time_station');
        $draftJobOffer->nearest_bus_stop= $request->input('nearest_bus_stop');
        $draftJobOffer->travel_time_bus_stop= $request->input('travel_time_bus_stop');
        $draftJobOffer->commuting_by_car= $request->input('commuting_by_car');
        $draftJobOffer->traffic_commuting_remarks= $request->input('traffic_commuting_remarks');
        $draftJobOffer->parking= $request->input('parking');
        $draftJobOffer->posting_site= $request->input('posting_site');
        $draftJobOffer->qualification= $request->input('qualification');
        $draftJobOffer->qualification_content= $request->input('qualification_content');
        $draftJobOffer->experience= $request->input('experience');
        $draftJobOffer->experience_content= $request->input('experience_content');
        $draftJobOffer->sex= $request->input('sex');
        $draftJobOffer->age= $request->input('age');
        $draftJobOffer->uniform_supply= $request->input('uniform_supply');
        $draftJobOffer->supply= $request->input('supply');
        $draftJobOffer->clothes= $request->input('clothes');
        $draftJobOffer->other_hair_colors= $request->input('other_hair_colors');
        $draftJobOffer->self_prepared= $request->input('self_prepared');
        $draftJobOffer->remarks_workplace= $request->input('remarks_workplace');
        $draftJobOffer->gender_ratio= $request->input('gender_ratio');
        $draftJobOffer->age_ratio= $request->input('age_ratio');
        $draftJobOffer->after_introduction= $request->input('after_introduction');
        $draftJobOffer->timing_of_switching= $request->input('timing_of_switching');
        $draftJobOffer->monthly_lower_limit= $request->input('monthly_lower_limit');
        $draftJobOffer->monthly_upper_limit= $request->input('monthly_upper_limit');
        $draftJobOffer->annual_lower_limit= $request->input('annual_lower_limit');
        $draftJobOffer->annual_upper_limit= $request->input('annual_upper_limit');
        $draftJobOffer->bonuses_treatment= $request->input('bonuses_treatment');
        $draftJobOffer->holidays_vacations= $request->input('holidays_vacations');
        $draftJobOffer->introduction_others= $request->input('introduction_others');
        $draftJobOffer->status= $request->input('status');
        $draftJobOffer->order_date= $request->input('order_date');
        $draftJobOffer->number_of_ordering_bases= $request->input('number_of_ordering_bases');
        $draftJobOffer->order_number= $request->input('order_number');
        $draftJobOffer->transaction_duration= $request->input('transaction_duration');
        $draftJobOffer->expected_sales= $request->input('expected_sales');
        $draftJobOffer->profit_rate= $request->input('profit_rate');
        $draftJobOffer->special_matters= $request->input('special_matters');

        $draftJobOffer->save();
        $request->session()->flash('SucccessMsg', '下書き更新しました');

        return redirect(route('draft.detail', $draftJobOffer->id));
    }

    public function destroy($id)
    {
        $draftJobOffer = DraftJobOffer::findOrFail($id);
        $draftJobOffer->delete();

        \Session::flash('SucccessMsg', '削除しました');

        return redirect(route('draft.index'));
    }

    public function showDetail($id)
    {
        $draftJobOffer = DraftJobOffer::find($id);

        if (isset($draftJobOffer['holiday'])) {
            $draftJobOffer['holiday'] = json_decode($draftJobOffer['holiday']);
        }
        if (isset($draftJobOffer['long_vacation'])) {
            $draftJobOffer['long_vacation'] = json_decode($draftJobOffer['long_vacation']);
        }

        $users = User::all();
        $customers = Customer::all();

        $customerName = Customer::where('id', $draftJobOffer->customer_id)->first()->customer_name ?? '';
        // dd($customerName);
        return view('draft_job_offers.detail', [
            'draftJobOffer' => $draftJobOffer,
            'users' => $users,
            'customers' => $customers,
            'isDraftJobOffer' => true,
            'differentUserAlert' => false,
            'customerName' => $customerName,
        ]);
    }

}
