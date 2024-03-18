@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12">
        <form action="{{ route('job_offers.import_csv') }}" method="POST" enctype='multipart/form-data'>
            @csrf
            <div class="mb-2">
                <label for="csv_import">CSVインポート</label><br>
                <input type="file" id="csv_import" name="csv_import">
                <button id="csv_submit" type="submit" class="btn btn-primary" disabled>選択したCSVを反映する</button>
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
        <div class="card mb-4">
            <div class="card-header">
                    <div class="card-header">▼派遣先/紹介先情報</div>
                    <form action="{{ route('job_offers.store') }}" method="POST">
                        @csrf
                        <table class="table" style="width: 100%; table-layout: fixed;">
                            <tbody>
                                <tr colspan="10">
                                    <th colspan="1">営業担当<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select     draft-require bg-danger text-white" name="user_id" required>
                                            <option value="">営業担当を選んで下さい</option>
                                            @foreach( $users as $user )
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th colspan="1">仕事番号</th>
                                    <td colspan="4">
                                        <input type="text" class="form-control" name="job_number" value="{{ old('job_number') }}">
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">取扱会社種別<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select required" name="handling_type" required>
                                            <option value="">取扱会社種別を選んで下さい</option>
                                            @foreach( config('options.handling_type') as $key => $handling_type )
                                            <option value="{{ $key }}" {{ old('handling_type') == $key ? 'selected' : '' }}>{{ $handling_type }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th colspan="1">取扱事業所名<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select  required" name="handling_office" required>
                                            <option value="">取扱事業所名を選んで下さい</option>
                                            @foreach( config('options.handling_office') as $key => $handling_office )
                                            <option value="{{ $key }}" {{ old('handling_office') == $key ? 'selected' : '' }}>{{ $handling_office }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">顧客名<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select id="customerId" class="select2 form-select required" name="customer_id" required>
                                            <option value="">顧客を選択もしくは入力してください</option>
                                            @foreach( $customers as $customer )
                                            <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th colspan="1">事業種別<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select required" name="business_type" required>
                                            <option value="">事業種別を選んで下さい</option>
                                            @foreach( config('options.business_type') as $key => $business_type )
                                            <option value="{{ $key }}" {{ old('business_type') == $key ? 'selected' : '' }}>{{ $business_type }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">契約形態<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select required" name="type_contract" required>
                                            <option value="">契約形態を選んで下さい</option>
                                            @foreach( config('options.type_contract') as $key => $type_contract )
                                            <option value="{{ $key }}" {{ old('type_contract') == $key ? 'selected' : '' }}>{{ $type_contract }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th colspan="1">募集人数<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <input type="text" class="form-control required" name="recruitment_number" value="{{ old('recruitment_number') }}" required>
                                    </td>
                                </tr>

                                <tr colspan="10">
                                    <th colspan="1">就業先名称<span class="text-danger">*</span></th>
                                    <td colspan="9">
                                        <input type="text" class="form-control draft-require bg-danger text-white" name="company_name" value="{{ old('company_name') }}" required>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">就業先住所<span class="text-danger">*</span></th>
                                    <td colspan="9">
                                        <input type="text" class="form-control required" name="company_address" value="{{ old('company_address') }}" required>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">就業先備考</th>
                                    <td colspan="9">
                                        <input type="text" maxlength="100" class="form-control" name="company_others" value="{{ old('company_others') }}">
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">発注業務<span class="text-danger">*</span></th>
                                    <td colspan="9">
                                        <input type="text" maxlength="100" class="form-control required" name="ordering_business" value="{{ old('ordering_business') }}" required>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">発注業務詳細<span class="text-danger">*</span></th>
                                    <td colspan="9">
                                        <textarea rows="15" class="form-control required" name="order_details" required>{{ old('order_details')}}</textarea>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">発注拠点数<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="fselect form-select required" name="number_of_ordering_bases" required>
                                            <option value="">発注拠点数を選んで下さい</option>
                                            @foreach( config('options.number_of_ordering_bases') as $key => $number_of_ordering_bases )
                                                <option value="{{ $key }}" {{ old('number_of_ordering_bases') == $key ? 'selected' : '' }}>{{ $number_of_ordering_bases }}</option>
                                            @endforeach
                                        </select>
                                    </td>
									<th colspan="1">発注人数<span class="text-danger">*</span></th>
									<td colspan="4">
										<select type="text" class="select form-select required" name="order_number" required>
											<option value="">発注人数を選んで下さい</option>
											@foreach( config('options.order_number') as $key => $order_number )
												<option value="{{ $key }}" {{ old('order_number') == $key ? 'selected' : '' }}>{{ $order_number }}</option>
											@endforeach
										</select>
									</td>
								</tr>
								<tr colspan="10">
									<th colspan="1">取引継続期間<span class="text-danger">*</span></th>
									<td colspan="4">
										<select type="text" class="select form-select  required" name="transaction_duration" required>
											<option value="">取引継続期間を選んで下さい</option>
											@foreach( config('options.transaction_duration') as $key => $transaction_duration )
												<option value="{{ $key }}" {{ old('transaction_duration') == $key ? 'selected' : '' }}>{{ $transaction_duration }}</option>
											@endforeach
										</select>
									</td>
									<th colspan="1">売上見込額<span class="text-danger">*</span></th>
									<td colspan="4">
										<select type="text" class="select form-select  required" name="expected_sales" required>
											<option value="">売上見込額を選んで下さい</option>
											@foreach( config('options.expected_sales') as $key => $expected_sales )
												<option value="{{ $key }}" {{ old('expected_sales') == $key ? 'selected' : '' }}>{{ $expected_sales }}</option>
											@endforeach
										</select>
									</td>
								</tr>
								<tr colspan="10">
									<th colspan="1">利益率<span class="text-danger">*</span></th>
									<td colspan="4">
										<select type="text" class="select form-select  required" name="profit_rate" required>
											<option value="">利益率を選んで下さい</option>
											@foreach( config('options.profit_rate') as $key => $profit_rate )
												<option value="{{ $key }}" {{ old('profit_rate') == $key ? 'selected' : '' }}>{{ $profit_rate }}</option>
											@endforeach
										</select>
									</td>
									<th colspan="1">特別事項<span class="text-danger">*</span></th>
									<td colspan="4">
										<select type="text" class="select form-select required" name="special_matters" required>
											<option value="">特別事項を選んで下さい</option>
											@foreach( config('options.special_matters') as $key => $special_matters )
												<option value="{{ $key }}" {{ old('special_matters') == $key ? 'selected' : '' }}>{{ $special_matters }}</option>
											@endforeach
										</select>
									</td>
								</tr>
                            </table>
                            <table class="table only-not-introduced" style="width: 100%; table-layout: fixed;">
                                <div class="card-header only-not-introduced">▼請求情報</div>
                                <tr colspan="10">
                                    <th colspan="1">請求単価①<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <input type="text" class="form-control required" name="invoice_unit_price_1" value="{{ old('invoice_unit_price_1') }}" required>
                                    </td>
                                    <th colspan="1">請求単位①<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select required" name="billing_unit_1" required>
                                            <option value="">請求単位を選んで下さい</option>
                                            @foreach( config('options.salary_term') as $key => $billing_unit_1 )
                                                <option value="{{ $key }}" {{ old('billing_unit_1') == $key ? 'selected' : '' }}>{{ $billing_unit_1 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">利益率①<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <input type="text" class="form-control required" name="profit_rate_1" value="{{ old('profit_rate_1') }}" required>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">
                                        請求情報①備考<br>
                                        <i class="bi bi-plus-circle" id="open_billing_2"></i>
                                    </th>
                                    <td colspan="9">
                                        <input type="text"class="form-control" maxlength="100" name="billing_information_1" value="{{ old('billing_information_1') }}">
                                    </td>

                                </tr>
                                <tr class="billing-2" colspan="10">
                                    <th colspan="1">請求単価②</th>
                                    <td colspan="4">
                                        <input type="text" class="form-control" name="invoice_unit_price_2" value="{{ old('invoice_unit_price_2') }}">
                                    </td>
                                    <th colspan="1">請求単位②</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="billing_unit_2">
                                            <option value="">請求単位を選んで下さい</option>
                                            @foreach( config('options.salary_term') as $key => $billing_unit_2 )
                                                <option value="{{ $key }}" {{ old('billing_unit_2') == $key ? 'selected' : '' }}>{{ $billing_unit_2 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr class="billing-2" colspan="10">
                                    <th colspan="1">利益率②</th>
                                    <td colspan="4">
                                        <input type="text" class="form-control" name="profit_rate_2" value="{{ old('profit_rate_2') }}">
                                    </td>
                                </tr>
                                <tr class="billing-2" colspan="10">
                                    <th colspan="1">請求情報②備考<br>
                                        <i class="bi bi-dash-circle" id="close_billing_2"></i>
                                        <i class="bi bi-plus-circle" id="open_billing_3"></i>
                                    </th>
                                    <td colspan="9">
                                        <input type="text"class="form-control" maxlength="100" name="billing_information_2" value="{{ old('billing_information_2') }}">
                                    </td>
                                </tr>
                                <tr class="billing-3" colspan="10">
                                    <th colspan="1">請求単価③</th>
                                    <td colspan="4">
                                        <input type="text" class="form-control" name="invoice_unit_price_3" value="{{ old('invoice_unit_price_3') }}">
                                    </td>
                                    <th colspan="1">請求単位③</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="billing_unit_3">
                                            <option value="">請求単位を選んで下さい</option>
                                            @foreach( config('options.salary_term') as $key => $billing_unit_3 )
                                                <option value="{{ $key }}" {{ old('billing_unit_3') == $key ? 'selected' : '' }}>{{ $billing_unit_3 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr class="billing-3" colspan="10">
                                    <th colspan="1">利益率③</th>
                                    <td colspan="4">
                                        <input type="text" class="form-control" name="profit_rate_3" value="{{ old('profit_rate_3') }}">
                                    </td>
                                </tr>
                                <tr class="billing-3" colspan="10">
                                    <th colspan="1">
                                        請求情報③備考<br>
                                        <i class="bi bi-dash-circle" id="close_billing_3"></i>
                                    </th>
                                    <td colspan="9">
                                        <input type="text"class="form-control" maxlength="100" name="billing_information_3" value="{{ old('billing_information_3') }}">
                                    </td>
                                </tr>
                            </table>
                            <table class="table only-not-introduced" style="width: 100%; table-layout: fixed;">
                                <div class="card-header only-not-introduced">▼支払情報</div>
                                <tr colspan="10">
                                    <th colspan="1">雇用保険加入<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select  required" name="employment_insurance" required>
                                            <option value="">雇用保険の有無を選んで下さい</option>
                                            @foreach( config('options.existence') as $key => $employment_insurance )
                                                <option value="{{ $key }}" {{ old('employment_insurance') == $key ? 'selected' : '' }}>{{ $employment_insurance }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th colspan="1">社会保険加入<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select required" name="social_insurance" required>
                                            <option value="">社会保険の有無を選んで下さい</option>
                                            @foreach( config('options.existence') as $key => $social_insurance )
                                                <option value="{{ $key }}" {{ old('social_insurance') == $key ? 'selected' : '' }}>{{ $social_insurance }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">支払単価①<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control required" name="payment_unit_price_1" value="{{ old('payment_unit_price_1') }}" required>
                                    </td>
                                    <th colspan="1">支払単位①<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select required" name="payment_unit_1" required>
                                            <option value="">支払単位を選んで下さい</option>
                                            @foreach( config('options.salary_term') as $key => $payment_unit_1 )
                                                <option value="{{ $key }}" {{ old('payment_unit_1') == $key ? 'selected' : '' }}>{{ $payment_unit_1 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">交通費①</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="carfare_1" value="{{ old('carfare_1') }}">
                                    </td>
                                    <th colspan="1">交通費支払単位①</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="carfare_payment_1">
                                            <option value="">交通費支払単位を選んで下さい</option>
                                            @foreach( config('options.payment_term') as $key => $carfare_payment_1 )
                                                <option value="{{ $key }}" {{ old('carfare_payment_1') == $key ? 'selected' : '' }}>{{ $carfare_payment_1 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">
                                        支払情報①備考<br>
                                        <i class="bi bi-plus-circle" id="open_payment_2"></i>
                                    </th>
                                    <td colspan="9">
                                        <input  type="text" class="form-control" name="carfare_payment_remarks_1" value="{{ old('carfare_payment_remarks_1') }}">
                                    </td>
                                </tr>
                                <tr class="payment-2" colspan="10">
                                    <th colspan="1">雇用保険加入②</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="employment_insurance_2">
                                            <option value="">雇用保険の有無を選んで下さい</option>
                                            @foreach( config('options.existence') as $key => $employment_insurance_2 )
                                            <option value="{{ $key }}" {{ old('employment_insurance_2') == $key ? 'selected' : '' }}>{{ $employment_insurance_2 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th colspan="1">社会保険加入②</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="social_insurance_2">
                                            <option value="">社会保険の有無を選んで下さい</option>
                                            @foreach( config('options.existence') as $key => $social_insurance_2 )
                                            <option value="{{ $key }}" {{ old('social_insurance_2') == $key ? 'selected' : '' }}>{{ $social_insurance_2 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr class="payment-2" colspan="10">
                                    <th colspan="1">支払単価②</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="payment_unit_price_2" value="{{ old('payment_unit_price_2') }}">
                                    </td>
                                    <th colspan="1">支払単位②</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select" name="payment_unit_2">
                                            <option value="">支払単位を選んで下さい</option>
                                            @foreach( config('options.salary_term') as $key => $payment_unit_2 )
                                                <option value="{{ $key }}" {{ old('payment_unit_2') == $key ? 'selected' : '' }}>{{ $payment_unit_2 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr class="payment-2" colspan="10">
                                    <th colspan="1">交通費②</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="carfare_2" value="{{ old('carfare_2') }}">
                                    </td>
                                    <th colspan="1">交通費支払単位②</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select" name="carfare_payment_2">
                                            <option value="">交通費支払単位を選んで下さい</option>
                                            @foreach( config('options.payment_term') as $key => $carfare_payment_2 )
                                                <option value="{{ $key }}" {{ old('carfare_payment_2') == $key ? 'selected' : '' }}>{{ $carfare_payment_2 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr class="payment-2" colspan="10">
                                    <th colspan="1">
                                        支払情報②備考
                                        <br>
                                        <i class="bi bi-dash-circle" id="close_payment_2"></i>
                                        <i class="bi bi-plus-circle" id="open_payment_3"></i>
                                    </th>
                                    <td colspan="9">
                                        <input  type="text" class="form-control" name="carfare_payment_remarks_2" value="{{ old('carfare_payment_remarks_2') }}">
                                    </td>
                                </tr>
                                <tr class="payment-3" colspan="10">
                                    <th colspan="1">雇用保険加入③</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="employment_insurance_3">
                                            <option value="">雇用保険の有無を選んで下さい</option>
                                            @foreach( config('options.existence') as $key => $employment_insurance_3 )
                                            <option value="{{ $key }}" {{ old('employment_insurance_3') == $key ? 'selected' : '' }}>{{ $employment_insurance_3 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th colspan="1">社会保険加入③</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="social_insurance_3">
                                            <option value="">社会保険の有無を選んで下さい</option>
                                            @foreach( config('options.existence') as $key => $social_insurance_3 )
                                            <option value="{{ $key }}" {{ old('social_insurance_3') == $key ? 'selected' : '' }}>{{ $social_insurance_3 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr class="payment-3" colspan="10">
                                    <th colspan="1">支払単価③</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="payment_unit_price_3" value="{{ old('payment_unit_price_3') }}">
                                    </td>
                                    <th colspan="1">支払単位③</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="payment_unit_3">
                                            <option value="">支払単位を選んで下さい</option>
                                            @foreach( config('options.salary_term') as $key => $payment_unit_3 )
                                                <option value="{{ $key }}" {{ old('payment_unit_3') == $key ? 'selected' : '' }}>{{ $payment_unit_3 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr class="payment-3" colspan="10">
                                    <th colspan="1">交通費③</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="carfare_3" value="{{ old('carfare_3') }}">
                                    </td>
                                    <th colspan="1">交通費支払単位③</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="carfare_payment_3">
                                            <option value="">交通費支払単位を選んで下さい</option>
                                            @foreach( config('options.payment_term') as $key => $carfare_payment_3 )
                                                <option value="{{ $key }}" {{ old('carfare_payment_3') == $key ? 'selected' : '' }}>{{ $carfare_payment_3 }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr class="payment-3" colspan="10">
                                    <th colspan="1">
                                        支払情報③備考<br>
                                        <i class="bi bi-dash-circle" id="close_payment_3"></i>
                                    </th>
                                    <td colspan="9">
                                        <input  type="text" class="form-control" name="carfare_payment_remarks_3" value="{{ old('carfare_payment_remarks_3') }}">
                                    </td>
                                </tr>
                            </table>
                            <table class="table" style="width: 100%; table-layout: fixed;">
                                <div class="card-header">▼就業期間</div>
                                <tr colspan="10">
                                    <th colspan="1">予定期間</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="scheduled_period">
                                            <option value="">予定期間を選んで下さい</option>
                                            @foreach( config('options.scheduled_period') as $key => $scheduled_period )
                                                <option value="{{ $key }}" {{ old('scheduled_period') == $key ? 'selected' : '' }}>{{ $scheduled_period }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th colspan="1">終了予定日</th>
                                    <td colspan="4">
                                        <input  type="date" class="form-control" name="expected_end_date" value="{{ old('expected_end_date') }}">
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">期間備考</th>
                                    <td colspan="9">
                                        <input  type="text" class="form-control" name="period_remarks" value="{{ old('period_remarks') }}">
                                    </td>
                                </tr>
                            </table>
                            <table class="table" style="width: 100%; table-layout: fixed;">
                                <div class="card-header">▼休日・休暇</div>
                                <tr colspan="10">
                                    <th colspan="1">休日<span class="text-danger">*</span></th>
                                    <td colspan="9">
                                        @foreach(config('options.holiday') as $index => $holiday)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input required" type="checkbox" id="{{ 'holidayInput' . $index }}" name="holiday[]" value="{{ $index }}" {{ (is_array(old('holiday')) && array_keys(old('holiday'), $index)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ 'holidayInput' . $index }}">{{ $holiday }}</label>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">長期休暇</th>
                                    <td colspan="9">
                                        @foreach(config('options.long_vacation') as $index => $longVacation)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="{{ 'longVacationInput' . $index }}" name="long_vacation[]" value="{{ $index }}" {{ (is_array(old('long_vacation')) && array_keys(old('long_vacation'), $index)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ 'longVacationInput' . $index }}">{{ $longVacation }}</label>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">休日備考</th>
                                    <td colspan="9">
                                        <textarea rows="1" class="form-control" name="holiday_remarks">{{ old('holiday_remarks') }}</textarea>
                                    </td>
                                </tr>
                            </table>
                            <table class="table" style="width: 100%; table-layout: fixed;">
                                <div class="card-header">▼就業時間</div>
                                <tr colspan="10">
                                    <th colspan="1">勤務時間①<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <input  type="text" class="form-contro required" name="working_hours_1" value="{{ old('working_hours_1') }}" placeholder="8:00～17:00" required>
                                    </td>
                                    <th colspan="1">実働時間①<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control required" name="actual_working_hours_1" value="{{ old('actual_working_hours_1') }}" required>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <td colspan="5">
                                        <br><i class="bi bi-plus-circle" id="open_working_2"></i>
                                    </td>
                                    <th colspan="1">
                                        休憩時間①<span class="text-danger">*</span>
                                    </th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control required" name="break_time_1" value="{{ old('break_time_1') }}" required>
                                    </td>
                                </tr>
                                <tr class="working-2" colspan="10">
                                    <th colspan="1">勤務時間②</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="working_hours_2" value="{{ old('working_hours_2') }}">
                                    </td>
                                    <th colspan="1">実働時間②</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="actual_working_hours_2" value="{{ old('actual_working_hours_2') }}">
                                    </td>
                                </tr>
                                <tr class="working-2" colspan="10">
                                    <td colspan="5">
                                        <br>
                                        <i class="bi bi-dash-circle" id="close_working_2"></i>
                                        <i class="bi bi-plus-circle" id="open_working_3"></i>
                                    </td>
                                    <th colspan="1">
                                        休憩時間②
                                    </th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="break_time_2" value="{{ old('break_time_2') }}">
                                    </td>
                                </tr>
                                <tr class="working-3" colspan="10">
                                    <th colspan="1">勤務時間③</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="working_hours_3" value="{{ old('working_hours_3') }}">
                                    </td>
                                    <th colspan="1">実働時間③</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="actual_working_hours_3" value="{{ old('actual_working_hours_3') }}">
                                    </td>
                                </tr>
                                <tr class="working-3" colspan="10">
                                    <td colspan="5">
                                    <i class="bi bi-dash-circle" id="close_working_3"></i>
                                    </td>
                                    <th colspan="1">
                                        休憩時間③<br>
                                    </th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="break_time_3" value="{{ old('break_time_3') }}">
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">残業(時間/月)<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control required" name="overtime" value="{{ old('overtime') }}" required>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">勤務時間備考</th>
                                    <td colspan="9">
                                        <textarea rows="5" type="text" class="form-control" name="working_hours_remarks">{{ old('working_hours_remarks') }}</textarea>
                                    </td>
                                </tr>
                            </table>
                            <table class="table" style="width: 100%; table-layout: fixed;">
                                <div class="card-header">▼通勤・交通</div>
                                <tr colspan="10">
                                    <th colspan="1">最寄り駅</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="nearest_station" value="{{ old('nearest_station') }}">
                                    </td>
                                    <th colspan="1">駅からの所要時間</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="travel_time_station" value="{{ old('travel_time_station') }}">
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">最寄りバス停</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="nearest_bus_stop" value="{{ old('nearest_bus_stop') }}">
                                    </td>

                                    <th colspan="1">バス停からの所要時間</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="travel_time_bus_stop" value="{{ old('travel_time_bus_stop') }}">
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">車通勤<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select  required" name="commuting_by_car" required>
                                            <option value="">車通勤の可否を選んで下さい</option>
                                            @foreach( config('options.permission') as $key => $commuting_by_car )
                                                <option value="{{ $key }}" {{ old('commuting_by_car') == $key ? 'selected' : '' }}>{{ $commuting_by_car }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th colspan="1">駐車場<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select  required" name="parking" required>
                                            <option value="">駐車場の有無を選んで下さい</option>
                                            @foreach( config('options.parking') as $key => $parking )
                                                <option value="{{ $key }}" {{ old('parking') == $key ? 'selected' : '' }}>{{ $parking }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">交通通勤備考</th>
                                    <td colspan="9">
                                        <textarea rows="5" class="form-control" name="traffic_commuting_remarks" >{{ old('traffic_commuting_remarks') }}</textarea>
                                    </td>
                                </tr>
                            </table>
                            <table class="table" style="width: 100%; table-layout: fixed;">
                                <div class="card-header">▼求める人材</div>
                                <tr colspan="10">
                                    <th colspan="1">資格要件</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="qualification">
                                            <option value="">資格要件を選んで下さい</option>
                                            @foreach( config('options.requirement') as $key => $qualification )
                                            <option value="{{ $key }}" {{ old('qualification') == $key ? 'selected' : '' }}>{{ $qualification }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">資格名</th>
                                    <td colspan="9">
                                        <input  type="text" class="form-control" name="qualification_content" value="{{ old('qualification_content') }}">
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">経験要件</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="experience">
                                            <option value="">経験要件を選んで下さい</option>
                                            @foreach( config('options.requirement') as $key => $experience )
                                            <option value="{{ $key }}" {{ old('experience') == $key ? 'selected' : '' }}>{{ $experience }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">経験内容</th>
                                    <td colspan="9">
                                        <input  type="text" class="form-control" name="experience_content" value="{{ old('experience_content') }}">
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">性別要件</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="sex">
                                            <option value="">性別要件を選んで下さい</option>
                                            @foreach( config('options.sex') as $key => $sex )
                                            <option value="{{ $key }}" {{ old('sex') == $key ? 'selected' : '' }}>{{ $sex }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th colspan="1">年齢要件</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="age" value="{{ old('age') }}" placeholder="（例）20代から40代">
                                    </td>
                                </tr>
                            </table>
                            <table class="table" style="width: 100%; table-layout: fixed;">
                                <div class="card-header">▼職場環境、他</div>
                                <tr colspan="10">
                                    <th colspan="1">屋内の受動喫煙対策<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select  required" name="counter_measures" required>
                                            <option value="">屋内の受動喫煙対策を選んで下さい</option>
                                            @foreach( config('options.counter_measures') as $key => $counter_measures )
                                                <option value="{{ $key }}" {{ old('counter_measures') == $key ? 'selected' : '' }}>{{ $counter_measures }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">制服支給の有無</th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select " name="uniform_supply">
                                            <option value="">制服支給の有無を選んで下さい</option>
                                            @foreach( config('options.uniform_supply') as $key => $uniformSupply )
                                            <option value="{{ $key }}" {{ old('uniform_supply') == $key ? 'selected' : '' }}>{{ $uniformSupply }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th colspan="1">支給物</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="supply" value="{{ old('supply') }}">
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">服装</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="clothes" value="{{ old('clothes') }}">
                                    </td>
                                    <th colspan="1">その他髪色</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control" name="other_hair_colors" value="{{ old('other_hair_colors') }}">
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">自身で準備するもの</th>
                                    <td colspan="9">
                                        <input  type="text" class="form-control" name="self_prepared" value="{{ old('self_prepared') }}">
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">職場の雰囲気・備考</th>
                                    <td colspan="9">
                                        <textarea type="textarea" rows="10" class="form-control" name="remarks_workplace">{{ old('remarks_workplace') }}</textarea>
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">男女比</th>
                                    <td colspan="9">
                                        <input  type="text" class="form-control" name="gender_ratio" value="{{ old('gender_ratio') }}" placeholder="6対4">
                                    </td>
                                </tr>
                                <tr colspan="10">
                                    <th colspan="1">年齢比率</th>
                                    <td colspan="9">
                                        <input  type="text" class="form-control" name="age_ratio" value="{{ old('age_ratio') }}" placeholder="20代 20%, 30代 50%, その他 30%">
                                    </td>
                                </tr>
                                {{-- <tr colspan="10">
                                    <th colspan="1">求人取り下げの理由</th>
                                    <td>
                                        <select type="text" class="form-control" name="job_withdrawal">
                                            <option value="">求人取り下げの理由を選んで下さい</option>
                                            @foreach( config('options.job_withdrawal') as $key => $job_withdrawal )
                                                <option value="{{ $key }}" {{ old('job_withdrawal') == $key ? 'selected' : '' }}>{{ $job_withdrawal }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr> --}}
                                {{--<tr colspan="10">
                                    <th colspan="1">求人掲載サイト</th>
                                    <td>
                                        <select type="text" class="form-control" name="posting_site">
                                            <option value="">求人掲載サイトを選んで下さい</option>
                                            @foreach( config('options.posting_site') as $key => $posting_site )
                                            <option value="{{ $key }}" {{ old('posting_site') == $key ? 'selected' : '' }}>{{ $posting_site }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>--}}
                                <tr class="afterRecruit" colspan="10" >
                                    <th colspan="2"><div class="text-center bg-info">人材紹介/紹介予定　採用後条件</div></th>
                                </tr>
                                <tr class="afterRecruit" colspan="10">
                                    <th colspan="1">紹介後</th>
                                    <td colspan="4">
                                        <input type="text" class="form-control conditions" name="after_introduction" value="{{ old('after_introduction') }}">
                                    </td>
                                    <th colspan="1">直接雇用切替時期</th>
                                    <td colspan="4">
                                        <input  type="text" class="form-control conditions" name="timing_of_switching" value="{{ old('timing_of_switching') }}">
                                    </td>
                                </tr>
                                <tr class="afterRecruit" colspan="10">
                                    <th colspan="1">月収例（下限）</th>
                                    <td colspan="9">
                                        <input  type="text" class="form-control conditions" name="monthly_lower_limit" value="{{ old('monthly_lower_limit') }}">
                                    </td>
                                </tr>
                                <tr class="afterRecruit" colspan="10">
                                    <th colspan="1">月収例（上限）</th>
                                    <td colspan="9">
                                        <input  type="text" class="form-control conditions" name="monthly_upper_limit" value="{{ old('monthly_upper_limit') }}">
                                    </td>
                                </tr>
                                <tr class="afterRecruit" colspan="10">
                                    <th colspan="1">年収例（下限）</th>
                                    <td colspan="9">
                                        <input  type="text" class="form-control conditions" name="annual_lower_limit" value="{{ old('annual_lower_limit') }}">
                                    </td>
                                </tr>
                                <tr class="afterRecruit" colspan="10">
                                    <th colspan="1">年収例（上限）</th>
                                    <td colspan="9">
                                        <input  type="text" class="form-control conditions" name="annual_upper_limit" value="{{ old('annual_upper_limit') }}">
                                    </td>
                                </tr>
                                <tr class="afterRecruit" colspan="10">
                                    <th colspan="1">賞与等・待遇</th>
                                    <td colspan="9">
                                        <textarea class="form-control conditions" name="bonuses_treatment " rows=5>{{ old('bonuses_treatment') }}</textarea>
                                    </td>
                                </tr>
                                <tr class="afterRecruit" colspan="10">
                                    <th colspan="1">休日・休暇</th>
                                    <td colspan="9">
                                        <textarea class="form-control conditions" name="holidays_vacations" rows=5>{{ old('holidays_vacations') }}</textarea>
                                    </td>
                                </tr>
                                <tr class="afterRecruit" colspan="10">
                                    <th colspan="1">その他</th>
                                    <td colspan="9">
                                        <textarea rows="5" type="text" class="form-control conditions" name="introduction_others" rows=5>{{ old('introduction_others') }}</textarea>
                                    </td>
                                </tr>
                            </table>
                            <table class="table" style="width: 100%; table-layout: fixed;">
                                <div class="card-header">求人情報新規登録</div>
                                <tr colspan="10">
                                    <th colspan="1">作成ステータス<span class="text-danger">*</span></th>
                                    <td colspan="4">
                                        <select type="text" class="select form-select  required" name="status" required>
                                            <option value="">作成ステータスを選んで下さい</option>
                                            @foreach( config('options.status_create') as $key => $status )
                                                <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button id="submit-btn" class="btn btn-primary" type="submit">登録</button>
                        </div>

                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button id="draft_create_btn" class="btn btn-secondary" type="submit" formaction="{{ route('draft.create') }}">下書き保存</button>
                        </div>

                    </form>
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
    <script type="text/javascript" src="{{ asset('/js/job_offer/create.js') }}"></script>
@endsection
