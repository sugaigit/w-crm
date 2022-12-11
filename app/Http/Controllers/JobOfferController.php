<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOffer;
use App\Models\User;
use App\Models\Customer;
use App\Models\ActivityRecord;

class JobOfferController extends Controller
{
    public function index(Request $request)
    {
        $jobOffers = JobOffer::all();

        return view('job_offers.index', [
            'jobOffers' => $jobOffers,
        ]);
    }

    public function create(Request $request)
    {
        $jobOffers = JobOffer::all();
        $users = User::all();
        $customers = Customer::all();
        $activityRecords = ActivityRecord::all();

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
        if(!$request->has('isUpdate')) { // 新規作成
            JobOffer::create($request->all());
            return redirect(route('job_offers.index'));
        }else { // 編集
            // 求人情報の更新処理
            $jobOffer = JobOffer::find($request->jobOfferId);
            
            $jobOffer->user_id= $request->input('user_id');
            $jobOffer->company_type= $request->input('company_type');
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
            $jobOffer->measures_existence= $request->input('measures_existence');
            $jobOffer->counter_measures= $request->input('counter_measures');
            $jobOffer->Invoice_unit_price_1= $request->input('Invoice_unit_price_1');
            $jobOffer->billing_unit_1= $request->input('billing_unit_1');
            $jobOffer->profit_rate_1= $request->input('profit_rate_1');
            $jobOffer->billing_information_1= $request->input('billing_information_1');
            $jobOffer->Invoice_unit_price_2= $request->input('Invoice_unit_price_2');
            $jobOffer->billing_unit_2= $request->input('billing_unit_2');
            $jobOffer->profit_rate_2= $request->input('profit_rate_2');
            $jobOffer->billing_information_2= $request->input('billing_information_2');
            $jobOffer->Invoice_unit_price_3= $request->input('Invoice_unit_price_3');
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
            $jobOffer->payment_unit_price_2= $request->input('payment_unit_price_2');
            $jobOffer->payment_unit_2= $request->input('payment_unit_2');
            $jobOffer->carfare_2= $request->input('carfare_2');
            $jobOffer->carfare_payment_2= $request->input('carfare_payment_2');
            $jobOffer->carfare_payment_remarks_2= $request->input('carfare_payment_remarks_2');
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
            $jobOffer->status= $request->input('status');
            $jobOffer->order_date= $request->input('order_date');

            $jobOffer->after_introduction= $request->input('after_introduction');
            $jobOffer->timing_of_switching= $request->input('timing_of_switching');
            $jobOffer->monthly_lower_limit= $request->input('monthly_lower_limit');
            $jobOffer->monthly_upper_limit= $request->input('monthly_upper_limit');
            $jobOffer->annual_lower_limit= $request->input('annual_lower_limit');
            $jobOffer->age_upper_limit= $request->input('age_upper_limit');
            $jobOffer->bonuses_treatment= $request->input('bonuses_treatment');
            $jobOffer->holidays_vacations= $request->input('holidays_vacations');
            $jobOffer->introduction_others= $request->input('introduction_others');

            $jobOffer->save();

            // 活動記録の登録処理
            ActivityRecord::create([
                'date' => $request->input('date'),
                'item' => $request->input('item'),
                'detail' => $request->input('detail'),
                'job_offer_id' => $request->input('job_offer_id'),
            ]);

            return redirect(route('job_offers.index'))->with('success', '更新しました');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $jobOffer = JobOffer::find($id);
        $users = User::all();
        $customers = Customer::all();
        $activityRecords = ActivityRecord::all();

        return view('job_offers.edit', [
            'jobOffer' => $jobOffer,
            'users' => $users,
            'customers' => $customers,
            'activityRecords' => $activityRecords,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * 
     */
    public function update(Request $request, $id)
    {
        dd('s');
        $jobOffer = JobOffer::find($id);
        // $customer->company_id =$request->input('company_id');
        // $customer->handling_office = $request->input('handling_office');
        // $customer->client_name = $request->input('client_name');
        // $customer->client_name_kana = $request->input('client_name_kana');
        // $customer->postal = $request->input('postal');
        // $customer->prefectures = $request->input('prefectures');
        // $customer->municipalities = $request->input('municipalities');
        // $customer->streetbunch = $request->input('streetbunch');
        // $customer->phone = $request->input('phone');
        // $customer->fax = $request->input('fax');
        // $customer->website = $request->input('website');
        // $customer->industry = $request->input('industry');
        // $customer->remarks = $request->input('remarks');
        // $customer->inflowroute = $request->input('inflowroute');
        // $customer->navi_no = $request->input('navi_no');
        // $customer->established = $request->input('established');
        // $customer->deadline = $request->input('deadline');
        // $customer->invoicemustarrivedate = $request->input('invoicemustarrivedate');
        // $customer->paymentdate = $request->input('paymentdate');
        // $customer->company_rank = $request->input('company_rank');

        $jobOffer->save();
      return redirect(route('job_offers.index'))->with('success', '更新しました');
    }

    public function show(Request $request, $id)
    {
        dd('showです');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $customer =Customer::findOrFail($id);
    //     $customer->delete();

    //     return redirect('/customers');
    // }
    // public function __invoke(Request $request)
    // {
    //     $customer = auth()->user();
    //     $this->authorize('viewAny', $customers);  // Policy をチェック
    //     $customers = \App\Models\Customers::get(); // 社員一覧を取得
    //     return view('customers.index', compact('customers')); // users.index.bldae を呼出し、 usersを渡す

    // }
}
