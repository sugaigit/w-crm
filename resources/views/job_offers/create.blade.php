@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                    <div class="card-header">求人情報新規登録</div>
                    <form action="{{ route('job_offers.store') }}" method="POST">
                        @csrf
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>営業担当<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="user_id">
                                            <option value="">営業担当を選んで下さい</option>
                                            @foreach( $users as $user )
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>取扱会社種別<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="handling_type">
                                            <option value="">取扱会社種別を選んで下さい</option>
                                            @foreach( config('options.handling_type') as $key => $handling_type )
                                            <option value="{{ $key }}" {{ old('handling_type') == $key ? 'selected' : '' }}>{{ $handling_type }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>仕事番号</th>
                                    <td>
                                        <input type="text" class="form-control" name="job_number" value="{{ old('job_number') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>取扱事業所名<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="handling_office">
                                            <option value="">取扱事業所名を選んで下さい</option>
                                            @foreach( config('options.handling_office') as $key => $handling_office )
                                            <option value="{{ $key }}" {{ old('handling_office') == $key ? 'selected' : '' }}>{{ $handling_office }}</option>
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
                                            <option value="{{ $key }}" {{ old('business_type') == $key ? 'selected' : '' }}>{{ $business_type }}</option>
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
                                            <option value="{{ $customer->id }}" {{ old('customer_id') == $key ? 'selected' : '' }}>{{ $customer->customer_name }}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>契約形態<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="type_contract">
                                            <option value="">契約形態を選んで下さい</option>
                                            @foreach( config('options.type_contract') as $key => $type_contract )
                                            <option value="{{ $key }}" {{ old('type_contract') == $key ? 'selected' : '' }}>{{ $type_contract }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>募集人数<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" class="form-control" name="recruitment_number" value="{{ old('recruitment_number') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>就業先名称<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>就業先住所<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" class="form-control" name="company_address" value="{{ old('company_address') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>就業先備考</th>
                                    <td>
                                        <input type="text" maxlength="100" class="form-control" name="company_others" value="{{ old('company_others') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>発注業務<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" maxlength="100" class="form-control" name="ordering_business" value="{{ old('ordering_business') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>発注業務詳細<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" maxlength="100" class="form-control" name="order_details" value="{{ old('order_details') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>屋内の受動喫煙対策<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="counter_measures">
                                            <option value="">屋内の受動喫煙対策を選んで下さい</option>
                                            @foreach( config('options.counter_measures') as $key => $counter_measures )
                                                <option value="{{ $key }}" {{ old('counter_measures') == $key ? 'selected' : '' }}>{{ $counter_measures }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>請求単価①<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" class="form-control" name="invoice_unit_price_1" value="{{ old('invoice_unit_price_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>請求単位①<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="billing_unit_1">
                                            <option value="">請求単位を選んで下さい</option>
                                            @foreach( config('options.salary_term') as $key => $billing_unit_1 )
                                                <option value="{{ $key }}" {{ old('billing_unit_1') == $key ? 'selected' : '' }}>{{ $billing_unit_1 }}</option>
                                            @endforeach
                                        <select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>利益率①<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" class="form-control" name="profit_rate_1" value="{{ old('profit_rate_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        請求情報①備考<br>
                                        <i class="bi bi-plus-circle" id="open_billing_2"></i>
                                    </th>
                                    <td>
                                        <input type="text"class="form-control" maxlength="100" name="billing_information_1" value="{{ old('billing_information_1') }}">
                                    </td>

                                </tr>
                                <tr class="billing-2">
                                    <th>請求単価②</th>
                                    <td>
                                        <input type="text" class="form-control" name="invoice_unit_price_2" value="{{ old('invoice_unit_price_2') }}">
                                    </td>
                                </tr>
                                <tr class="billing-2">
                                    <th>請求単位②</th>
                                    <td>
                                        <select type="text" class="form-control" name="billing_unit_2">
                                            <option value="">請求単位を選んで下さい</option>
                                            @foreach( config('options.salary_term') as $key => $billing_unit_2 )
                                                <option value="{{ $key }}">{{ $billing_unit_2 }}</option>
                                            @endforeach
                                        <select>
                                    </td>
                                </tr>
                                <tr class="billing-2">
                                    <th>利益率②</th>
                                    <td>
                                        <input type="text" class="form-control" name="profit_rate_2" value="{{ old('profit_rate_2') }}">
                                    </td>
                                </tr>
                                <tr class="billing-2">
                                    <th>請求情報②備考<br>
                                    <i class="bi bi-dash-circle" id="close_billing_2"></i>
                                    <i class="bi bi-plus-circle" id="open_billing_3"></i></th>
                                    <td>
                                        <input type="text"class="form-control" maxlength="100" name="billing_information_2" value="{{ old('billing_information_2') }}">
                                    </td>
                                </tr>
                                <tr class="billing-3">
                                    <th>請求単価③</th>
                                    <td>
                                        <input type="text" class="form-control" name="invoice_unit_price_3" value="{{ old('invoice_unit_price_3') }}">
                                    </td>
                                </tr>
                                <tr class="billing-3">
                                    <th>請求単位③</th>
                                    <td>
                                        <select type="text" class="form-control" name="billing_unit_3">
                                            <option value="">請求単位を選んで下さい</option>
                                            @foreach( config('options.salary_term') as $key => $billing_unit_3 )
                                                <option value="{{ $key }}">{{ $billing_unit_3 }}</option>
                                            @endforeach
                                        <select>
                                    </td>
                                </tr>
                                <tr class="billing-3">
                                    <th>利益率③</th>
                                    <td>
                                        <input type="text" class="form-control" name="profit_rate_3" value="{{ old('profit_rate_3') }}">
                                    </td>
                                </tr>
                                <tr class="billing-3">
                                    <th>
                                        請求情報③備考<br>
                                        <i class="bi bi-dash-circle" id="close_billing_3"></i>
                                    </th>
                                    <td>
                                        <input type="text"class="form-control" maxlength="100" name="billing_information_3" value="{{ old('billing_information_3') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>雇用保険加入<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="employment_insurance">
                                            <option value="">雇用保険の有無を選んで下さい</option>
                                            @foreach( config('options.existence') as $key => $employment_insurance )
                                                <option value="{{ $key }}" {{ old('employment_insurance') == $key ? 'selected' : '' }}>{{ $employment_insurance }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>社会保険加入<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="social_insurance">
                                            <option value="">社会保険の有無を選んで下さい</option>
                                            @foreach( config('options.existence') as $key => $social_insurance )
                                                <option value="{{ $key }}" {{ old('social_insurance') == $key ? 'selected' : '' }}>{{ $social_insurance }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>支払単価①<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="payment_unit_price_1" value="{{ old('payment_unit_price_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>支払単位①<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="payment_unit_1">
                                            <option value="">支払単位を選んで下さい</option>
                                            @foreach( config('options.salary_term') as $key => $payment_unit_1 )
                                                <option value="{{ $key }}" {{ old('payment_unit_1') == $key ? 'selected' : '' }}>{{ $payment_unit_1 }}</option>
                                            @endforeach
                                        <select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>交通費①<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="carfare_1" value="{{ old('carfare_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>交通費支払単位①<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="carfare_payment_1">
                                            <option value="">交通費支払単位を選んで下さい</option>
                                            @foreach( config('options.payment_term') as $key => $carfare_payment_1 )
                                                <option value="{{ $key }}" {{ old('carfare_payment_1') == $key ? 'selected' : '' }}>{{ $carfare_payment_1 }}</option>
                                            @endforeach
                                        <select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        支払情報①備考<br>
                                        <i class="bi bi-plus-circle" id="open_payment_2">
                                    </th>
                                    <td>
                                        <input  type="text" class="form-control" name="carfare_payment_remarks_1" value="{{ old('carfare_payment_remarks_1') }}">
                                    </td>
                                </tr>
                                <tr class="payment-2">
                                    <th>雇用保険加入②</th>
                                    <td>
                                        <select type="text" class="form-control" name="employment_insurance_2">
                                            <option value="">雇用保険の有無を選んで下さい</option>
                                            @foreach( config('options.existence') as $key => $employment_insurance_2 )
                                            <option value="{{ $key }}">{{ $employment_insurance_2 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr class="payment-2">
                                    <th>社会保険加入②</th>
                                    <td>
                                        <select type="text" class="form-control" name="social_insurance_2">
                                            <option value="">社会保険の有無を選んで下さい</option>
                                            @foreach( config('options.existence') as $key => $social_insurance_2 )
                                            <option value="{{ $key }}">{{ $social_insurance_2 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr class="payment-2">
                                    <th>支払単価②</th>
                                    <td>
                                        <input  type="text" class="form-control" name="payment_unit_price_2" value="{{ old('payment_unit_price_2') }}">
                                    </td>
                                </tr>
                                <tr class="payment-2">
                                    <th>支払単位②</th>
                                    <td>
                                        <select type="text" class="form-control" name="payment_unit_2">
                                            <option value="">支払単位を選んで下さい</option>
                                            @foreach( config('options.salary_term') as $key => $payment_unit_2 )
                                                <option value="{{ $key }}">{{ $payment_unit_2 }}</option>
                                            @endforeach
                                        <select>
                                    </td>
                                </tr>
                                <tr class="payment-2">
                                    <th>交通費②</th>
                                    <td>
                                        <input  type="text" class="form-control" name="carfare_2" value="{{ old('carfare_2') }}">
                                    </td>
                                </tr>
                                <tr class="payment-2">
                                    <th>交通費支払単位②</th>
                                    <td>
                                        <select type="text" class="form-control" name="carfare_payment_2">
                                            <option value="">交通費支払単位を選んで下さい</option>
                                            @foreach( config('options.payment_term') as $key => $carfare_payment_2 )
                                                <option value="{{ $key }}">{{ $carfare_payment_2 }}</option>
                                            @endforeach
                                        <select>
                                    </td>
                                </tr>
                                <tr class="payment-2">
                                    <th>
                                        支払情報②備考<br>
                                        <i class="bi bi-dash-circle" id="close_payment_2">
                                        <i class="bi bi-plus-circle" id="open_payment_3">
                                    </th>
                                    <td>
                                        <input  type="text" class="form-control" name="carfare_payment_remarks_2" value="{{ old('carfare_payment_remarks_2') }}">
                                    </td>
                                </tr>
                                <tr class="payment-3">
                                    <th>雇用保険加入③</th>
                                    <td>
                                        <select type="text" class="form-control" name="employment_insurance_3">
                                            <option value="">雇用保険の有無を選んで下さい</option>
                                            @foreach( config('options.existence') as $key => $employment_insurance_3 )
                                            <option value="{{ $key }}">{{ $employment_insurance_3 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr class="payment-3">
                                    <th>社会保険加入③</th>
                                    <td>
                                        <select type="text" class="form-control" name="social_insurance_3">
                                            <option value="">社会保険の有無を選んで下さい</option>
                                            @foreach( config('options.existence') as $key => $social_insurance_3 )
                                            <option value="{{ $key }}">{{ $social_insurance_3 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr class="payment-3">
                                    <th>支払単価③</th>
                                    <td>
                                        <input  type="text" class="form-control" name="payment_unit_price_3" value="{{ old('payment_unit_price_3') }}">
                                    </td>
                                </tr>
                                <tr class="payment-3">
                                    <th>支払単位③</th>
                                    <td>
                                        <select type="text" class="form-control" name="payment_unit_3">
                                            <option value="">支払単位を選んで下さい</option>
                                            @foreach( config('options.salary_term') as $key => $payment_unit_3 )
                                                <option value="{{ $key }}">{{ $payment_unit_3 }}</option>
                                            @endforeach
                                        <select>
                                    </td>
                                </tr>
                                <tr class="payment-3">
                                    <th>交通費③</th>
                                    <td>
                                        <input  type="text" class="form-control" name="carfare_3" value="{{ old('carfare_3') }}">
                                    </td>
                                </tr>
                                <tr class="payment-3">
                                    <th>交通費支払単位③</th>
                                    <td>
                                        <select type="text" class="form-control" name="carfare_payment_3">
                                            <option value="">交通費支払単位を選んで下さい</option>
                                            @foreach( config('options.payment_term') as $key => $carfare_payment_3 )
                                                <option value="{{ $key }}">{{ $carfare_payment_3 }}</option>
                                            @endforeach
                                        <select>
                                    </td>
                                </tr>
                                <tr class="payment-3">
                                    <th>
                                        支払情報③備考<br>
                                        <i class="bi bi-dash-circle" id="close_payment_3">
                                    </th>
                                    <td>
                                        <input  type="text" class="form-control" name="carfare_payment_remarks_3" value="{{ old('carfare_payment_remarks_3') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>予定期間</th>
                                    <td>
                                        <input  type="text" class="form-control" name="scheduled_period" value="{{ old('scheduled_period') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>終了予定日</th>
                                    <td>
                                        <input  type="date" class="form-control" name="expected_end_date" value="{{ old('expected_end_date') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>期間備考</th>
                                    <td>
                                        <input  type="text" class="form-control" name="period_remarks" value="{{ old('period_remarks') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>休日<span class="text-danger">*</span></th>
                                    <td>
                                        @foreach(config('options.holiday') as $index => $holiday)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="{{ 'holidayInput' . $index }}" name="holiday[]" value="{{ $index }}" {{ (is_array(old('holiday')) && array_keys(old('holiday'), $index)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ 'holidayInput' . $index }}">{{ $holiday }}</label>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>長期休暇<span class="text-danger">*</span></th>
                                    <td>
                                        @foreach(config('options.long_vacation') as $index => $longVacation)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="{{ 'longVacationInput' . $index }}" name="long_vacation[]" value="{{ $index }}" {{ (is_array(old('long_vacation')) && array_keys(old('long_vacation'), $index)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ 'longVacationInput' . $index }}">{{ $longVacation }}</label>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>休日備考</th>
                                    <td>
                                        <textarea rows="3" class="form-control" name="holiday_remarks">{{ old('holiday_remarks') }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>勤務時間①<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="working_hours_1" value="{{ old('working_hours_1') }}" placeholder="8:00～17:00">
                                    </td>
                                </tr>
                                <tr>
                                    <th>実働時間①<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="actual_working_hours_1" value="{{ old('actual_working_hours_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        休憩時間①<span class="text-danger">*</span>
                                        <br><i class="bi bi-plus-circle" id="open_working_2">
                                    </th>
                                    <td>
                                        <input  type="text" class="form-control" name="break_time_1" value="{{ old('break_time_1') }}">
                                    </td>
                                </tr>
                                <tr class="working-2">
                                    <th>勤務時間②</th>
                                    <td>
                                        <input  type="text" class="form-control" name="working_hours_2" value="{{ old('working_hours_2') }}">
                                    </td>
                                </tr>
                                <tr class="working-2">
                                    <th>実働時間②</th>
                                    <td>
                                        <input  type="text" class="form-control" name="actual_working_hours_2" value="{{ old('actual_working_hours_2') }}">
                                    </td>
                                </tr>
                                <tr class="working-2">
                                    <th>
                                        休憩時間②<br>
                                        <i class="bi bi-dash-circle" id="close_working_2"></i>
                                        <i class="bi bi-plus-circle" id="open_working_3">
                                    </th>
                                    <td>
                                        <input  type="text" class="form-control" name="break_time_2" value="{{ old('break_time_2') }}">
                                    </td>
                                </tr>
                                <tr class="working-3">
                                    <th>勤務時間③</th>
                                    <td>
                                        <input  type="text" class="form-control" name="working_hours_3" value="{{ old('working_hours_3') }}">
                                    </td>
                                </tr>
                                <tr class="working-3">
                                    <th>実働時間③</th>
                                    <td>
                                        <input  type="text" class="form-control" name="actual_working_hours_3" value="{{ old('actual_working_hours_3') }}">
                                    </td>
                                </tr>
                                <tr class="working-3">
                                    <th>
                                        休憩時間③<br>
                                        <i class="bi bi-dash-circle" id="close_working_3"></i>
                                    </th>
                                    <td>
                                        <input  type="text" class="form-control" name="break_time_3" value="{{ old('break_time_3') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>残業(時間/月)<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="overtime" value="{{ old('overtime') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>勤務時間備考</th>
                                    <td>
                                        <textarea rows="3" type="text" class="form-control" name="working_hours_remarks">{{ old('working_hours_remarks') }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>最寄り駅</th>
                                    <td>
                                        <input  type="text" class="form-control" name="nearest_station" value="{{ old('nearest_station') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>駅からの所要時間</th>
                                    <td>
                                        <input  type="text" class="form-control" name="travel_time_station" value="{{ old('travel_time_station') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>最寄りバス停</th>
                                    <td>
                                        <input  type="text" class="form-control" name="nearest_bus_stop" value="{{ old('nearest_bus_stop') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>バス停からの所要時間</th>
                                    <td>
                                        <input  type="text" class="form-control" name="travel_time_bus_stop" value="{{ old('travel_time_bus_stop') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>車通勤<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="commuting_by_car">
                                            <option value="">車通勤の可否を選んで下さい</option>
                                            @foreach( config('options.permission') as $key => $commuting_by_car )
                                                <option value="{{ $key }}" {{ old('commuting_by_car') == $key ? 'selected' : '' }}>{{ $commuting_by_car }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>交通通勤備考</th>
                                    <td>
                                        <textarea rows="3" class="form-control" name="traffic_commuting_remarks" >{{ old('traffic_commuting_remarks') }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>駐車場<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="parking">
                                            <option value="">駐車場の有無を選んで下さい</option>
                                            @foreach( config('options.parking') as $key => $parking )
                                                <option value="{{ $key }}" {{ old('parking') == $key ? 'selected' : '' }}>{{ $parking }}</option>
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
                                            <option value="{{ $key }}">{{ $posting_site }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>資格要件</th>
                                    <td>
                                        <select type="text" class="form-control" name="qualification">
                                            <option value="">資格要件を選んで下さい</option>
                                            @foreach( config('options.requirement') as $key => $qualification )
                                            <option value="{{ $key }}">{{ $qualification }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>資格名</th>
                                    <td>
                                        <input  type="text" class="form-control" name="qualification_content" value="{{ old('qualification_content') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>経験要件</th>
                                    <td>
                                        <select type="text" class="form-control" name="experience">
                                            <option value="">経験要件を選んで下さい</option>
                                            @foreach( config('options.requirement') as $key => $experience )
                                            <option value="{{ $key }}">{{ $experience }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>経験内容</th>
                                    <td>
                                        <input  type="text" class="form-control" name="experience_content" value="{{ old('experience_content') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>性別要件</th>
                                    <td>
                                        <select type="text" class="form-control" name="sex">
                                            <option value="">性別要件を選んで下さい</option>
                                            @foreach( config('options.sex') as $key => $sex )
                                            <option value="{{ $key }}">{{ $sex }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>年齢要件</th>
                                    <td>
                                        <input  type="text" class="form-control" name="age" value="{{ old('age') }}" placeholder="（例）20代から40代">
                                    </td>
                                </tr>
                                <tr>
                                    <th>制服支給の有無</th>
                                    <td>
                                        <select type="text" class="form-control" name="uniform_supply">
                                            <option value="">制服支給の有無を選んで下さい</option>
                                            @foreach( config('options.uniform_supply') as $key => $uniformSupply )
                                            <option value="{{ $key }}">{{ $uniformSupply }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>支給物</th>
                                    <td>
                                        <input  type="text" class="form-control" name="supply" value="{{ old('supply') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>服装</th>
                                    <td>
                                        <input  type="text" class="form-control" name="clothes" value="{{ old('clothes') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>その他髪色</th>
                                    <td>
                                        <input  type="text" class="form-control" name="other_hair_colors" value="{{ old('other_hair_colors') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>自身で準備するもの</th>
                                    <td>
                                        <input  type="text" class="form-control" name="self_prepared" value="{{ old('self_prepared') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>職場の雰囲気・備考</th>
                                    <td>
                                        <textarea type="textarea" rows="3" class="form-control" name="remarks_workplace">{{ old('remarks_workplace') }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>男女比</th>
                                    <td>
                                        <input  type="text" class="form-control" name="gender_ratio" value="{{ old('gender_ratio') }}" placeholder="6対4">
                                    </td>
                                </tr>
                                <tr>
                                    <th>年齢比率</th>
                                    <td>
                                        <input  type="text" class="form-control" name="age_ratio" value="{{ old('age_ratio') }}" placeholder="20代 20%, 30代 50%, その他 30%">
                                    </td>
                                </tr>
                                <tr class="afterRecruit">
                                    <th>紹介後</th>
                                    <td>
                                        <input  type="text" class="form-control" name="after_introduction" value="{{ old('after_introduction') }}">
                                    </td>
                                </tr>
                                <tr class="afterRecruit">
                                    <th>直接雇用切替時期</th>
                                    <td>
                                        <input  type="text" class="form-control" name="timing_of_switching" value="{{ old('timing_of_switching') }}">
                                    </td>
                                </tr>
                                <tr class="afterRecruit">
                                    <th>月収例（下限）</th>
                                    <td>
                                        <input  type="text" class="form-control" name="monthly_lower_limit" value="{{ old('monthly_lower_limit') }}">
                                    </td>
                                </tr>
                                <tr class="afterRecruit">
                                    <th>月収例（上限）</th>
                                    <td>
                                        <input  type="text" class="form-control" name="monthly_upper_limit" value="{{ old('monthly_upper_limit') }}">
                                    </td>
                                </tr>
                                <tr class="afterRecruit">
                                    <th>年収例（下限）</th>
                                    <td>
                                        <input  type="text" class="form-control" name="annual_lower_limit" value="{{ old('annual_lower_limit') }}">
                                    </td>
                                </tr>
                                <tr class="afterRecruit">
                                    <th>年齢（上限）</th>
                                    <td>
                                        <input  type="text" class="form-control" name="age_upper_limit" value="{{ old('age_upper_limit') }}">
                                    </td>
                                </tr>
                                <tr class="afterRecruit">
                                    <th>賞与等・待遇</th>
                                    <td>
                                        <input  type="text" class="form-control" name="bonuses_treatment" value="{{ old('bonuses_treatment') }}">
                                    </td>
                                </tr>
                                <tr class="afterRecruit">
                                    <th>休日・休暇</th>
                                    <td>
                                        <input  type="text" class="form-control" name="holidays_vacations" value="{{ old('holidays_vacations') }}">
                                    </td>
                                </tr>
                                <tr class="afterRecruit">
                                    <th>その他</th>
                                    <td>
                                        <textarea rows="3" type="text" class="form-control" name="introduction_others">{{ old('introduction_others') }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>作成ステータス<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="status">
                                            <option value="">作成ステータスを選んで下さい</option>
                                            @foreach( config('options.status_create') as $key => $status )
                                                <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>起算日<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="date" class="form-control" name="order_date" value="{{ old('order_date') }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button class="btn btn-primary" type="submit">登録</button>
                        </div>

                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button class="btn btn-secondary" type="submit" formaction="{{ route('draft.create') }}">下書き保存</button>
                        </div>

                    </form>

                    {{-- エラーを表示--}}
                    @if( $errors->any() )
                        <ul>
                            @foreach($errors->all() as $error)
                                <li class="text-danger">{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif

                </div>
            </div>

            <a href="{{ route('job_offers.index') }}">
                <button class="btn btn-outline-secondary btn-lg"type="button">
                    求人情報一覧に戻る
                </button>
            </a>

        </div>
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript" src="/js/job_offer/create.js"></script>
@endsection