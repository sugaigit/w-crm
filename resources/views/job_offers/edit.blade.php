@extends('layouts.app')
@section('content')
<div class="container">
  <div class="col-md-12">
  <form action="{{ route('job_offers.update', ['job_offer' => $jobOffer->id]) }}" method="POST">
    @method('PUT')
    @csrf
    <input type="hidden" name="jobOfferId" value="{{ $jobOffer->id }}">
    <input class="btn btn-secondary mb-2" type="button" value="印刷" onclick="window.print();" />
    <input class="btn btn-success mb-2" type="submit" value="複製" onclick="duplicate()" />
    <div class="card mb-4">
      <div class="card-header">
          求人情報編集
      </div>

        <table class="table">
            <tbody>
              <tr>
                <th>営業担当<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="user_id">
                    <option value="">営業担当を選んで下さい</option>
                    @foreach( $users as $user )
                      <option value="{{ $user->id }}" {{ $user->id == $jobOffer->user->id ? 'selected' : '' }}> {{ $user->name }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                  <th>取扱会社種別<span class="text-danger">*</span></th>
                  <td>
                    <select type="text" class="form-control" name="company_type">
                      <option value="">取扱会社種別を選んで下さい</option>
                      @foreach( config('options.company_type') as $key => $company_type )
                        <option value="{{ $key }}" {{ $key == $jobOffer->company_type ? 'selected' : '' }}>{{ $company_type }}</option>
                      @endforeach
                    </select>
                  </td>
              </tr>
              <tr>
                <th>仕事番号</th>
                <td>
                  <input type="text" class="form-control" name="job_number" value="{{ isset($jobOffer->job_number) ? $jobOffer->job_number : '' }}">
                </td>
              </tr>
              <tr>
                <th>取扱事業所名<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="handling_office">
                    <option value="">取扱事業所名を選んで下さい</option>
                    @foreach( config('options.handling_office') as $key => $handling_office )
                      <option value="{{ $key }}" {{ $key == $jobOffer->handling_office ? 'selected' : '' }}>{{ $handling_office }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>事業種別<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="business_type">
                    <option value="">事業種別を選んで下さい</option>
                    @foreach( config('options.business_type') as $key => $business_type )
                      <option value="{{ $key }}" {{ $key == $jobOffer->business_type ? 'selected' : '' }}>{{ $business_type }}</option>
                    @endforeach
                </select>
                </td>
              </tr>
              <tr>
                <th>顧客<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="customer_id">
                    <option value="">顧客を選んで下さい</option>
                    @foreach( $customers as $customer )
                      <option value="{{ $customer->id }}" {{ $customer->id == $jobOffer->customer_id ? 'selected' : '' }}>{{ $customer->name }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>契約形態<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="type_contract">
                    <option value="">法人形態を選んで下さい</option>
                    @foreach( config('options.type_contract') as $key => $type_contract )
                      <option value="{{ $key }}" {{ $key == $jobOffer->type_contract ? 'selected' : '' }}>{{ $type_contract }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>募集人数<span class="text-danger">*</span></th>
                <td>
                  <input type="text" class="form-control" name="recruitment_number" value="{{ isset($jobOffer->recruitment_number) ? $jobOffer->recruitment_number : '' }}">
                </td>
              </tr>
              <tr>
                <th>就業先名称<span class="text-danger">*</span></th>
                <td>
                  <input type="text" class="form-control" name="company_name" value="{{ isset($jobOffer->company_name) ? $jobOffer->company_name : '' }}">
                </td>
              </tr>
              <tr>
                <th>就業先住所<span class="text-danger">*</span></th>
                <td>
                  <input type="text" class="form-control" name="company_address" value="{{ isset($jobOffer->company_address) ? $jobOffer->company_address : '' }}">
                </td>
              </tr>
              <tr>
                <th>就業先備考</th>
                <td>
                  <input type="text" maxlength="100" class="form-control" name="company_others" value="{{ isset($jobOffer->company_others) ? $jobOffer->company_others : '' }}">
                </td>
              </tr>
              <tr>
                <th>発注業務<span class="text-danger">*</span></th>
                <td>
                  <input type="text" maxlength="100" class="form-control" name="ordering_business" value="{{ isset($jobOffer->ordering_business) ? $jobOffer->ordering_business : '' }}">
                </td>
              </tr>
              <tr>
                <th>発注業務詳細<span class="text-danger">*</span></th>
                <td>
                  <input type="text" maxlength="100" class="form-control" name="order_details" value="{{ isset($jobOffer->order_details) ? $jobOffer->order_details : '' }}">
                </td>
              </tr>
              <tr>
                <th>屋内の受動喫煙対策の有無<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="measures_existence">
                    <option value="">対策の有無を選んで下さい</option>
                    @foreach( config('options.existence') as $key => $measures_existence )
                      <option value="{{ $key }}" {{ $key == $jobOffer->measures_existence ? 'selected' : '' }}>{{ $measures_existence }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>屋内の受動喫煙対策の内容<span class="text-danger">*</span></th>
                <td>
                  <input type="text" class="form-control" name="counter_measures" value="{{ isset($jobOffer->counter_measures) ? $jobOffer->counter_measures : '' }}">
                </td>
              </tr>
              <tr>
                <th>請求単価①<span class="text-danger">*</span></th>
                <td>
                  <input type="text" class="form-control" name="Invoice_unit_price_1" value="{{ isset($jobOffer->Invoice_unit_price_1) ? $jobOffer->Invoice_unit_price_1 : '' }}">
                </td>
              </tr>
              <tr>
                <th>請求単位①<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="billing_unit_1">
                    <option value="">請求単位を選んで下さい</option>
                    @foreach( config('options.salary_term') as $key => $billing_unit_1 )
                      <option value="{{ $key }}"  {{ $key == $jobOffer->billing_unit_1 ? 'selected' : '' }}>{{ $billing_unit_1 }}</option>
                    @endforeach
                  <select>
                </td>
              </tr>
              <tr>
                <th>利益率①<span class="text-danger">*</span></th>
                <td>
                  <input type="text" class="form-control" name="profit_rate_1" value="{{ isset($jobOffer->profit_rate_1) ? $jobOffer->profit_rate_1 : '' }}">
                </td>
              </tr>
              <tr>
                <th>請求情報①備考<br><i class="bi bi-plus-circle" id="open_billing_2"></i></th>
                <td>
                  <input type="text"class="form-control" maxlength="100" name="billing_information_1" value="{{ isset($jobOffer->billing_information_1) ? $jobOffer->billing_information_1 : '' }}">
                </td>
              </tr>
              <tr class="billing-2">
                <th>請求単価②</th>
                <td>
                  <input type="text" class="form-control" name="Invoice_unit_price_2" value="{{ isset($jobOffer->Invoice_unit_price_2) ? $jobOffer->Invoice_unit_price_2 : '' }}">
                </td>
              </tr>
              <tr class="billing-2">
                <th>請求単位②</th>
                <td>
                  <select type="text" class="form-control" name="billing_unit_2">
                    <option value="">請求単位を選んで下さい</option>
                    @foreach( config('options.salary_term') as $key => $billing_unit_2 )
                      <option value="{{ $key }}"  {{ $key == $jobOffer->billing_unit_2 ? 'selected' : '' }}>{{ $billing_unit_2 }}</option>
                    @endforeach
                  <select>
                </td>
              </tr>
              <tr class="billing-2">
                <th>利益率②</th>
                <td>
                  <input type="text" class="form-control" name="profit_rate_2" value="{{ isset($jobOffer->profit_rate_2) ? $jobOffer->profit_rate_2 : '' }}">
                </td>
              </tr>
              <tr class="billing-2">
                <th>請求情報②備考<br><i class="bi bi-plus-circle" id="open_billing_3"></i></th>
                <td>
                  <input type="text"class="form-control" maxlength="100" name="billing_information_2" value="{{ isset($jobOffer->billing_information_2) ? $jobOffer->billing_information_2 : '' }}">
                </td>
              </tr>
              <tr class="billing-3">
                <th>請求単価③</th>
                <td>
                  <input type="text" class="form-control" name="Invoice_unit_price_3" value="{{ isset($jobOffer->Invoice_unit_price_3) ? $jobOffer->Invoice_unit_price_3 : '' }}">
                </td>
              </tr>
              <tr class="billing-3">
                <th>請求単位③</th>
                <td>
                  <select type="text" class="form-control" name="billing_unit_3">
                    <option value="">請求単位を選んで下さい</option>
                    @foreach( config('options.salary_term') as $key => $billing_unit_3 )
                      <option value="{{ $key }}"  {{ $key == $jobOffer->billing_unit_3 ? 'selected' : '' }}>{{ $billing_unit_3 }}</option>
                    @endforeach
                  <select>
                </td>
              </tr>
              <tr class="billing-3">
                <th>利益率③</th>
                <td>
                  <input type="text" class="form-control" name="profit_rate_3" value="{{ isset($jobOffer->profit_rate_3) ? $jobOffer->profit_rate_3 : '' }}">
                </td>
              </tr>
              <tr class="billing-3">
                <th>請求情報③備考</th>
                <td>
                  <input type="text"class="form-control" maxlength="100" name="billing_information_3" value="{{ isset($jobOffer->billing_information_3) ? $jobOffer->billing_information_3 : '' }}">
                </td>
              </tr>
                <th>雇用保険加入<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="employment_insurance">
                    <option value="">雇用保険の有無を選んで下さい</option>
                    @foreach( config('options.existence') as $key => $employment_insurance )
                      <option value="{{ $key }}" {{ $key == $jobOffer->employment_insurance ? 'selected' : '' }}>{{ $employment_insurance }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              </tr>
                <th>社会保険加入<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="social_insurance">
                    <option value="">雇用保険の有無を選んで下さい</option>
                    @foreach( config('options.existence') as $key => $social_insurance )
                      <option value="{{ $key }}" {{ $key == $jobOffer->social_insurance ? 'selected' : '' }}>{{ $social_insurance }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>支払単価①<span class="text-danger">*</span></th>
                <td>
                  <input  type="text" class="form-control" name="payment_unit_price_1" value="{{ isset($jobOffer->payment_unit_price_1) ? $jobOffer->payment_unit_price_1 : '' }}">
                </td>
              </tr>
              <tr>
                <th>支払単位①<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="payment_unit_1">
                    <option value="">支払単位を選んで下さい</option>
                    @foreach( config('options.salary_term') as $key => $payment_unit_1 )
                      <option value="{{ $key }}" {{ $key == $jobOffer->payment_unit_1 ? 'selected' : '' }}>{{ $payment_unit_1 }}</option>
                    @endforeach
                  <select>
                </td>
              </tr>
              <tr>
                <th>交通費①<span class="text-danger">*</span></th>
                <td>
                  <input  type="text" class="form-control" name="carfare_1" value="{{ isset($jobOffer->carfare_1) ? $jobOffer->carfare_1 : '' }}">
                </td>
              </tr>
              <tr>
                <th>交通費支払単位①<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="carfare_payment_1">
                    <option value="">交通費支払単位を選んで下さい</option>
                    @foreach( config('options.payment_term') as $key => $carfare_payment_1 )
                      <option value="{{ $key }}" {{ $key == $jobOffer->carfare_payment_1 ? 'selected' : '' }}>{{ $carfare_payment_1 }}</option>
                    @endforeach
                  <select>
                </td>
              </tr>
              <tr>
                <th>支払情報①備考<br><i class="bi bi-plus-circle" id="open_payment_2"></i></th>
                <td>
                  <input  type="text" class="form-control" name="carfare_payment_remarks_1" value="{{ isset($jobOffer->carfare_payment_remarks_1) ? $jobOffer->carfare_payment_remarks_1 : '' }}">
                </td>
              </tr>
              <tr class="payment-2">
                <th>支払単価②</th>
                <td>
                  <input  type="text" class="form-control" name="payment_unit_price_2" value="{{ isset($jobOffer->payment_unit_price_2) ? $jobOffer->payment_unit_price_2 : '' }}">
                </td>
              </tr>
              <tr class="payment-2">
                <th>支払単位②</th>
                <td>
                  <input type="text"class="form-control" name="payment_unit_2" value="{{ isset($jobOffer->payment_unit_2) ? $jobOffer->payment_unit_2 : '' }}">
                </td>
              </tr>
              <tr class="payment-2">
                <th>交通費②</th>
                <td>
                  <input  type="text" class="form-control" name="carfare_2" value="{{ isset($jobOffer->carfare_2) ? $jobOffer->carfare_2 : '' }}">
                </td>
              </tr>
              <tr class="payment-2">
                <th>交通費支払単位②</th>
                <td>
                  <select type="text" class="form-control" name="carfare_payment_2">
                    <option value="">交通費支払単位を選んで下さい</option>
                    @foreach( config('options.payment_term') as $key => $carfare_payment_2 )
                      <option value="{{ $key }}" {{ $key == $jobOffer->carfare_payment_2 ? 'selected' : '' }}>{{ $carfare_payment_2 }}</option>
                    @endforeach
                  <select>
                </td>
              </tr>
              <tr class="payment-2">
                <th>支払情報②備考<br><i class="bi bi-plus-circle" id="open_payment_3"></i></th>
                <td>
                  <input  type="text" class="form-control" name="carfare_payment_remarks_2" value="{{ isset($jobOffer->carfare_payment_remarks_2) ? $jobOffer->carfare_payment_remarks_2 : '' }}">
                </td>
              </tr>
              <tr class="payment-3">
                <th>支払単価③</th>
                <td>
                  <input  type="text" class="form-control" name="payment_unit_price_3" value="{{ isset($jobOffer->payment_unit_price_3) ? $jobOffer->payment_unit_price_3 : '' }}">
                </td>
              </tr>
              <tr class="payment-3">
                <th>支払単位③</th>
                <td>
                  <select type="text" class="form-control" name="carfare_payment_3">
                    <option value="">交通費支払単位を選んで下さい</option>
                    @foreach( config('options.payment_term') as $key => $carfare_payment_3 )
                      <option value="{{ $key }}" {{ $key == $jobOffer->carfare_payment_3 ? 'selected' : '' }}>{{ $carfare_payment_3 }}</option>
                    @endforeach
                  <select>
                </td>
              </tr>
              <tr class="payment-3">
                <th>交通費③</th>
                <td>
                  <input  type="text" class="form-control" name="carfare_3" value="{{ isset($jobOffer->carfare_3) ? $jobOffer->carfare_3 : '' }}">
                </td>
              </tr>
              <tr class="payment-3">
                <th>交通費支払単位③</th>
                <td>
                  <input  type="text" class="form-control" name="carfare_payment_3" value="{{ isset($jobOffer->carfare_payment_3) ? $jobOffer->carfare_payment_3 : '' }}">
                </td>
              </tr>
              <tr class="payment-3">
                <th>支払情報③備考</th>
                <td>
                  <input  type="text" class="form-control" name="carfare_payment_remarks_3" value="{{ isset($jobOffer->carfare_payment_remarks_3) ? $jobOffer->carfare_payment_remarks_3 : '' }}">
                </td>
              </tr>
              <tr>
                <th>予定期間</th>
                <td>
                  <input  type="text" class="form-control" name="scheduled_period" value="{{ isset($jobOffer->scheduled_period) ? $jobOffer->scheduled_period : '' }}">
                </td>
              </tr>
              <tr>
                <th>終了予定日</th>
                <td>
                  <input  type="date" class="form-control" name="expected_end_date" value="{{ isset($jobOffer->expected_end_date) ? $jobOffer->expected_end_date : '' }}">
                </td>
              </tr>
              <tr>
                <th>期間備考</th>
                <td>
                  <input  type="text" class="form-control" name="period_remarks" value="{{ isset($jobOffer->period_remarks) ? $jobOffer->period_remarks : '' }}">
                </td>
              </tr>
              <tr>
                <th>休日<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="holiday">
                    <option value="">休日を選んで下さい</option>
                    @foreach( config('options.holiday') as $holiday )
                      <option value="{{ $holiday }}" {{ $holiday == $jobOffer->holiday ? 'selected' : '' }}>{{ $holiday }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>長期休暇<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="long_vacation">
                    <option value="">長期休暇の有無を選んで下さい</option>
                    @foreach( config('options.existence') as $key => $long_vacation )
                      <option value="{{ $key }}" {{ $key == $jobOffer->long_vacation ? 'selected' : '' }}>{{ $long_vacation }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>休日備考</th>
                <td>
                  <input  type="text" class="form-control" name="holiday_remarks" value="{{ isset($jobOffer->holiday_remarks) ? $jobOffer->holiday_remarks : '' }}">
                </td>
              </tr>
              <tr>
                <th>勤務時間①<span class="text-danger">*</span></th>
                <td>
                  <input type="text" class="form-control" name="working_hours_1" value="{{ isset($jobOffer->working_hours_1) ? $jobOffer->working_hours_1 : '' }}">
                </td>
              </tr>
              <tr>
                <th>実働時間①<span class="text-danger">*</span></th>
                <td>
                  <input type="text" class="form-control" name="actual_working_hours_1" value="{{ isset($jobOffer->actual_working_hours_1) ? $jobOffer->actual_working_hours_1 : '' }}">
                </td>
              </tr>
              <tr>
                <th>
                  休憩時間①<span class="text-danger">*</span>
                  <br><i class="bi bi-plus-circle" id="open_working_2"></i>
                </th>
                <td>
                  <input type="text" class="form-control" name="break_time_1" value="{{ isset($jobOffer->break_time_1) ? $jobOffer->break_time_1 : '' }}">
                </td>
              </tr>
              <tr class="working-2">
                <th>勤務時間②</th>
                <td>
                  <input type="text" class="form-control" name="working_hours_2" value="{{ isset($jobOffer->working_hours_2) ? $jobOffer->working_hours_2 : '' }}">
                </td>
              </tr>
              <tr class="working-2">
                <th>実働時間②</th>
                <td>
                  <input type="text" class="form-control" name="actual_working_hours_2" value="{{ isset($jobOffer->actual_working_hours_2) ? $jobOffer->actual_working_hours_2 : '' }}">
                </td>
              </tr>
              <tr class="working-2">
                <th>休憩時間②<br><i class="bi bi-plus-circle" id="open_working_3"></i></th>
                <td>
                  <input type="text" class="form-control" name="break_time_2" value="{{ isset($jobOffer->break_time_2) ? $jobOffer->break_time_2 : '' }}">
                </td>
              </tr>
              <tr class="working-3">
                <th>勤務時間③</th>
                <td>
                  <input type="text" class="form-control" name="working_hours_3" value="{{ isset($jobOffer->working_hours_3) ? $jobOffer->working_hours_3 : '' }}">
                </td>
              </tr>
              <tr class="working-3">
                <th>実働時間③</th>
                <td>
                  <input type="text" class="form-control" name="actual_working_hours_3" value="{{ isset($jobOffer->actual_working_hours_3) ? $jobOffer->actual_working_hours_3 : '' }}">
                </td>
              </tr>
              <tr class="working-3">
                <th>休憩時間③</th>
                <td>
                  <input type="text" class="form-control" name="break_time_3" value="{{ isset($jobOffer->break_time_3) ? $jobOffer->break_time_3 : '' }}">
                </td>
              </tr>
              <tr>
                <th>残業(時間/月)<span class="text-danger">*</span></th>
                <td>
                  <input  type="text" class="form-control" name="overtime" value="{{ isset($jobOffer->overtime) ? $jobOffer->overtime : '' }}">
                </td>
              </tr>
              <tr>
                <th>勤務時間備考</th>
                <td>
                  <input  type="text" class="form-control" name="working_hours_remarks" value="{{ isset($jobOffer->working_hours_remarks) ? $jobOffer->working_hours_remarks : '' }}">
                </td>
              </tr>
              <tr>
                <th>最寄り駅</th>
                <td>
                  <input  type="text" class="form-control" name="nearest_station" value="{{ isset($jobOffer->nearest_station) ? $jobOffer->nearest_station : '' }}">
                </td>
              </tr>
              <tr>
                <th>駅からの所要時間</th>
                <td>
                  <input  type="text" class="form-control" name="travel_time_station" value="{{ isset($jobOffer->travel_time_station) ? $jobOffer->travel_time_station : '' }}">
                </td>
              </tr>
              <tr>
                <th>最寄りバス停</th>
                <td>
                  <input  type="text" class="form-control" name="nearest_bus_stop" value="{{ isset($jobOffer->nearest_bus_stop) ? $jobOffer->nearest_bus_stop : '' }}">
                </td>
              </tr>
              <tr>
                <th>バス停からの所要時間</th>
                <td>
                  <input  type="text" class="form-control" name="travel_time_bus_stop" value="{{ isset($jobOffer->travel_time_bus_stop) ? $jobOffer->travel_time_bus_stop : '' }}">
                </td>
              </tr>
              <tr>
                <th>車通勤（可能）<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="commuting_by_car">
                    <option value="">車通勤の可否を選んで下さい</option>
                    @foreach( config('options.permission') as $key => $commuting_by_car )
                      <option value="{{ $key }}" {{ $key == $jobOffer->commuting_by_car ? 'selected' : '' }}>{{ $commuting_by_car }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>交通通勤備考</th>
                <td>
                  <input  type="text" class="form-control" name="traffic_commuting_remarks" value="{{ isset($jobOffer->traffic_commuting_remarks) ? $jobOffer->traffic_commuting_remarks : '' }}">
                </td>
              </tr>
              <tr>
                <th>駐車場<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="parking">
                    <option value="">駐車場の有無を選んで下さい</option>
                    @foreach( config('options.parking') as $key => $parking )
                      <option value="{{ $key }}" {{ $key == $jobOffer->parking ? 'selected' : '' }}>{{ $parking }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>求人掲載サイト</th>
                <td>
                  <select type="text" class="form-control" name="posting_site">
                    <option value="">求人掲載サイトを選んで下さい</option>
                    @foreach( config('options.posting_site') as $key => $posting_site )
                      <option value="{{ $key }}" {{ $key == $jobOffer->posting_site ? 'selected' : '' }}>{{ $posting_site }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>作成ステータス<span class="text-danger">*</span></th>
                <td>
                  <select type="text" class="form-control" name="status">
                    <option value="">作成ステータスを選んで下さい</option>
                    @foreach( config('options.status_edit') as $key => $status )
                      <option value="{{ $key }}" {{ $key == $jobOffer->status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>発注日<span class="text-danger">*</span></th>
                <td>
                  <input  type="date" class="form-control" name="order_date" value="{{ isset($jobOffer->order_date) ? $jobOffer->order_date : '' }}">
                </td>
              </tr>
            <tr class="afterRecruit">
              <th>紹介後</th>
              <td>
                <input  type="text" class="form-control" name="after_introduction" value="{{ isset($jobOffer->after_introduction) ? $jobOffer->after_introduction : '' }}">
              </td>
            </tr>
            <tr class="afterRecruit">
              <th>直接雇用切替時期</th>
              <td>
                <input  type="text" class="form-control" name="timing_of_switching" value="{{ isset($jobOffer->timing_of_switching) ? $jobOffer->timing_of_switching : '' }}">
              </td>
            </tr>
            <tr class="afterRecruit">
              <th>月収例（下限）</th>
              <td>
                <input  type="text" class="form-control" name="monthly_lower_limit" value="{{ isset($jobOffer->monthly_lower_limit) ? $jobOffer->monthly_lower_limit : '' }}">
              </td>
            </tr>
            <tr class="afterRecruit">
              <th>月収例（上限）</th>
              <td>
                <input  type="text" class="form-control" name="monthly_upper_limit" value="{{ isset($jobOffer->monthly_upper_limit) ? $jobOffer->monthly_upper_limit : '' }}">
              </td>
            </tr>
            <tr class="afterRecruit">
              <th>年収例（下限）</th>
              <td>
                <input  type="text" class="form-control" name="annual_lower_limit" value="{{ isset($jobOffer->annual_lower_limit) ? $jobOffer->annual_lower_limit : '' }}">
              </td>
            </tr>
            <tr class="afterRecruit">
              <th>年齢（上限）</th>
              <td>
                <input  type="text" class="form-control" name="age_upper_limit" value="{{ isset($jobOffer->age_upper_limit) ? $jobOffer->age_upper_limit : '' }}">
              </td>
            </tr>
            <tr class="afterRecruit">
              <th>賞与等・待遇</th>
              <td>
                <input  type="text" class="form-control" name="bonuses_treatment" value="{{ isset($jobOffer->bonuses_treatment) ? $jobOffer->bonuses_treatment : '' }}">
              </td>
            </tr>
            <tr class="afterRecruit">
              <th>休日・休暇</th>
              <td>
                <input  type="text" class="form-control" name="holidays_vacations" value="{{ isset($jobOffer->holidays_vacations) ? $jobOffer->holidays_vacations : '' }}">
              </td>
            </tr>
            <tr class="afterRecruit">
              <th>その他</th>
              <td>
                <input  type="text" class="form-control" name="introduction_others" value="{{ isset($jobOffer->introduction_others) ? $jobOffer->introduction_others : '' }}">
              </td>
            </tr>
          </tbody>
        </table>

        <div class="card-header">活動記録 登録</div>
        <table class="table">
          <tbody>
            <tr>
              <th>日付</th>
              <td><input  type="date" class="form-control" name="date" value="{{ today()->format('Y-m-d') }}"></td>
            </tr>
            <tr>
              <th>項目</th>
              <td>
                <select type="text" class="form-control" name="item">
                  <option value="">項目を選んで下さい</option>
                  @foreach( config('options.item') as $key => $item )
                    <option value="{{ $key }}">{{ $item }}</option>
                  @endforeach
                </select>
              </td>
            </tr>
            <tr>
              <th>詳細</th>
              <td><input  type="text" class="form-control" name="detail"></td>
            </tr>
            <input  type="hidden" name="job_offer_id" value="{{ $jobOffer->id }}">
          </tbody>
        </table>

        <div class="d-flex justify-content-center mt-4 mb-3">
          <button class="btn btn-primary" type="submit">保存</button>
        </div>
      </form>
    </div>

    @if( $errors->any() )
      <ul>
        @foreach($errors->all() as $error)
          <li>{{$error}}</li>
        @endforeach
      </ul>
    @endif


    <div class="card mb-4">
      <div class="card-header">活動記録 一覧</div>
      <table class="table">
        <tbody>
          <tr>
            <th>日付</th>
            <th>項目</th>
            <th>詳細</th>
          </tr>
          @foreach($activityRecords as $activityRecord)
          <tr>
              <td>{{ $activityRecord->date }}</td>
              <td>{{ config('options.item')[$activityRecord->item] }}</td>
              <td>{{ $activityRecord->detail }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>

  <button class="btn btn-outline-secondary btn-lg" data-bs-toggle="button" autocomplete="off" type="submit" onClick="history.back()">
    求人情報一覧に戻る
  </button>

</div>
@endsection

@section('js')
  <script type="text/javascript" src="/js/job_offer/edit.js"></script>
@endsection
