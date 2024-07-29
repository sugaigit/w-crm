@extends('layouts.app')
@section('css')
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
@endsection
@section('content')
@if ($differentUserAlert)
    <div class="alert alert-danger d-flex justify-content-center">
        {{ session('AlertMsg') }}
    </div>
@endif
<div class="container">
  <div class="col-md-12">
    <form action="{{ route('job_offers.update', $jobOffer->id) }}" method="POST">
        <div class="d-flex justify-content-center mt-4 mb-1">
            <button hidden type="submit" onclick="submit()"></button>
        </div>
        @if (!$jobOffer->is_duplicated)
            {{-- @method('PUT') --}}
        @endif

        @csrf
        <input type="hidden" name="jobOfferId" value="{{ $jobOffer->id }}">
        <input class="btn btn-secondary mb-2 me-3" type="button" value="印刷" onclick="window.print();" />
        @if(!$isDraftJobOffer)
        {{-- <input class="btn btn-success mb-2" type="submit" value="複製" onclick="duplicate()" /> --}}
        <input class="btn btn-success mb-2 me-3" type="submit" name="duplicate" id="duplicate" value="複製">
        @else
        <input type="hidden" name="draftJobOfferId" value="{{ $jobOffer->id }}">
        @endif
        <div class="card mb-4">
            <div class="card-header">
                ▼派遣先/紹介先情報
            </div>

            <table class="table" style="width: 100%; table-layout: fixed;">
                <tbody>
                    <tr colspan="10">
                        <th colspan="1">営業担当<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select draft-require" name="user_id" required>
                            <option value="">営業担当を選んで下さい</option>
                            @foreach( $users as $user )
                                @if (is_null(old('user_id')))
                                <option value="{{ $user->id }}" {{ $user->id == $jobOffer->user->id ? 'selected' : '' }}> {{ $user->name }}</option>
                                @else
                                <option value="{{ $user->id }}" {{ $user->id == old('user_id') ? 'selected' : '' }}> {{ $user->name }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                        <th colspan="1">仕事番号</th>
                        <td colspan="4">
                            @if (is_null(old('job_number')))
                            <input type="text" class="form-control" name="job_number" value="{{ isset($jobOffer->job_number) ? $jobOffer->job_number : '' }}">
                            @else
                            <input type="text" class="form-control" name="job_number" value="{{ old('job_number') }}">
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">取扱会社種別<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select  required" name="handling_type" required>
                                <option value="">取扱会社種別を選んで下さい</option>
                                @foreach( config('options.handling_type') as $key => $handling_type )
                                    @if (is_null(old('handling_type')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->handling_type ? 'selected' : '' }}>{{ $handling_type }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('handling_type') ? 'selected' : '' }}>{{ $handling_type }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                        <th colspan="1">取扱事業所名<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select  required" name="handling_office" required>
                            <option value="">取扱事業所名を選んで下さい</option>
                            @foreach( config('options.handling_office') as $key => $handling_office )
                                @if (is_null(old('handling_office')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->handling_office ? 'selected' : '' }}>{{ $handling_office }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('handling_office') ? 'selected' : '' }}>{{ $handling_office }}</option>
                                @endif
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
                                    @if (is_null(old('customer_id')))
                                    <option value="{{ $customer->id }}" {{ $customer->id == $jobOffer->customer_id ? 'selected' : '' }}>{{ $customer->customer_name }}</option>
                                    @else
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->customer_name ? 'selected' : '' }}>{{ $customer->customer_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <th colspan="1">事業種別<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select  required" name="business_type" required>
                                <option value="">事業種別を選んで下さい</option>
                                @foreach( config('options.business_type') as $key => $business_type )
                                    @if (is_null(old('business_type')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->business_type ? 'selected' : '' }}>{{ $business_type }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('business_type') ? 'selected' : '' }}>{{ $business_type }}</option>
                                    @endif
                                @endforeach
                        </select>
                        </td>
                    </tr>

                    <tr colspan="10">
                        <th colspan="1">契約形態<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select class="select form-select required" name="type_contract" required>
                            <option value="">契約形態を選んで下さい</option>
                            @foreach( config('options.type_contract') as $key => $type_contract )
                                @if (is_null(old('type_contract')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->type_contract ? 'selected' : '' }}>{{ $type_contract }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('type_contract') ? 'selected' : '' }}>{{ $type_contract }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>

                        <th colspan="1">募集人数<span class="text-danger">*</span></th>
                        <td colspan="4">
                            @if (is_null(old('recruitment_number')))
                            <input type="text" class="form-control required" name="recruitment_number" value="{{ isset($jobOffer->recruitment_number) ? $jobOffer->recruitment_number : '' }}" required>
                            @else
                            <input type="text" class="form-control required" name="recruitment_number" value="{{ old('recruitment_number') }}" required>
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">就業先名称<span class="text-danger">*</span></th>
                        <td colspan="9">
                            @if (is_null(old('company_name')))
                            <input type="text" class="form-control draft-require" name="company_name" value="{{ isset($jobOffer->company_name) ? $jobOffer->company_name : '' }}" required>
                            @else
                            <input type="text" class="form-control required" name="company_name" value="{{ old('company_name') }}" required>
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">就業先住所<span class="text-danger">*</span></th>
                        <td colspan="9">
                            @if (is_null(old('company_address')))
                            <input type="text" class="form-control required" name="company_address" value="{{ isset($jobOffer->company_address) ? $jobOffer->company_address : '' }}" required>
                            @else
                            <input type="text" class="form-control required" name="company_address" value="{{ old('company_address') }}" required>
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">就業先備考</th>
                        <td colspan="9">
                            @if (is_null(old('company_others')))
                            <input type="text" maxlength="100" class="form-control" name="company_others" value="{{ isset($jobOffer->company_others) ? $jobOffer->company_others : '' }}">
                            @else
                            <input type="text" maxlength="100" class="form-control" name="company_others" value="{{ old('company_others') }}">
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">発注業務<span class="text-danger">*</span></th>
                        <td colspan="9">
                            @if (is_null(old('ordering_business')))
                            <input type="text" maxlength="100" class="form-control" name="ordering_business" value="{{ isset($jobOffer->ordering_business) ? $jobOffer->ordering_business : '' }}" required>
                            @else
                            <input type="text" maxlength="100" class="form-control" name="ordering_business" value="{{ old('ordering_business') }}" required>
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">発注業務詳細<span class="text-danger">*</span></th>
                        <td colspan="9">
                            @if (is_null(old('order_details')))
                            <textarea rows="15" class="form-control required" name="order_details" required> {{ isset($jobOffer->order_details) ? $jobOffer->order_details : '' }} </textarea>
                            @else
                            <textarea rows="15" class="form-control" name="order_details" required> {{ old('order_details') }}</textarea>
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">発注拠点数<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select required" name="number_of_ordering_bases" required>
                                <option value="">発注拠点数を選んで下さい</option>
                                @foreach( config('options.number_of_ordering_bases') as $key => $number_of_ordering_bases )
                                @if (is_null(old('number_of_ordering_bases')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->number_of_ordering_bases ? 'selected' : '' }}>{{ $number_of_ordering_bases }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('number_of_ordering_bases') ? 'selected' : '' }}>{{ $number_of_ordering_bases }}</option>
                                @endif
                                    @endforeach
                            </select>
                        </td>

                        <th colspan="1">発注人数<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select required" name="order_number" required>
                                <option value="">発注人数を選んで下さい</option>
                                @foreach( config('options.order_number') as $key => $order_number )
                                @if (is_null(old('order_number')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->order_number ? 'selected' : '' }}>{{ $order_number }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('order_number') ? 'selected' : '' }}>{{ $order_number }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">取引継続期間<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select required" name="transaction_duration" required>
                                <option value="">取引継続期間を選んで下さい</option>
                                @foreach( config('options.transaction_duration') as $key => $transaction_duration )
                                @if (is_null(old('transaction_duration')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->transaction_duration ? 'selected' : '' }}>{{ $transaction_duration }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('transaction_duration') ? 'selected' : '' }}>{{ $transaction_duration }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                        <th colspan="1">売上見込額<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select required" name="expected_sales" required>
                                <option value="">売上見込額を選んで下さい</option>
                                @foreach( config('options.expected_sales') as $key => $expected_sales )
                                @if (is_null(old('expected_sales')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->expected_sales ? 'selected' : '' }}>{{ $expected_sales }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('expected_sales') ? 'selected' : '' }}>{{ $expected_sales }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">利益率<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select required" name="profit_rate" required>
                                <option value="">利益率を選んで下さい</option>
                                @foreach( config('options.profit_rate') as $key => $profit_rate )
                                @if (is_null(old('profit_rate')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->profit_rate ? 'selected' : '' }}>{{ $profit_rate }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('profit_rate') ? 'selected' : '' }}>{{ $profit_rate }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                        <th colspan="1">特別事項<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select required" name="special_matters" required>
                                <option value="">特別事項を選んで下さい</option>
                                @foreach( config('options.special_matters') as $key => $special_matters )
                                @if (is_null(old('special_matters')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->special_matters ? 'selected' : '' }}>{{ $special_matters }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('special_matters') ? 'selected' : '' }}>{{ $special_matters }}</option>
                                    @endif
                                    @endforeach
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table only-not-introduced" style="width: 100%; table-layout: fixed;">
                <tbody>
                    <div class="card-header only-not-introduced">▼請求情報</div>
                    <tr colspan="10">
                        <th colspan="1">請求単価①<span class="text-danger">*</span></th>
                        <td colspan="4">
                            @if (is_null(old('invoice_unit_price_1')))
                            <input type="text" class="form-control required" name="invoice_unit_price_1" value="{{ isset($jobOffer->invoice_unit_price_1) ? $jobOffer->invoice_unit_price_1 : '' }}" required>
                            @else
                            <input type="text" class="form-control" name="invoice_unit_price_1" value="{{ old('invoice_unit_price_1') }}" required>
                            @endif
                        </td>

                        <th colspan="1">請求単位①<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select required" name="billing_unit_1" required>
                            <option value="">請求単位を選んで下さい</option>
                            @foreach( config('options.salary_term') as $key => $billing_unit_1 )
                                @if (is_null(old('billing_unit_1')))
                                <option value="{{ $key }}"  {{ $key == $jobOffer->billing_unit_1 ? 'selected' : '' }}>{{ $billing_unit_1 }}</option>
                                @else
                                <option value="{{ $key }}"  {{ $key == old('billing_unit_1') ? 'selected' : '' }}>{{ $billing_unit_1 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">利益率①<span class="text-danger">*</span></th>
                        <td colspan="4">
                            @if (is_null(old('profit_rate_1')))
                            <input type="text" class="form-control required" name="profit_rate_1" value="{{ isset($jobOffer->profit_rate_1) ? $jobOffer->profit_rate_1 : '' }}" required>
                            @else
                            <input type="text" class="form-control required" name="profit_rate_1" value="{{ old('profit_rate_1') }}" required>
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">請求情報①備考<br><i class="bi bi-plus-circle" id="open_billing_2"></i></th>
                        <td colspan="9">
                            @if (is_null(old('billing_information_1')))
                            <input type="text"class="form-control" maxlength="100" name="billing_information_1" value="{{ isset($jobOffer->billing_information_1) ? $jobOffer->billing_information_1 : '' }}">
                            @else
                            <input type="text"class="form-control" maxlength="100" name="billing_information_1" value="{{ old('billing_information_1') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="billing-2" colspan="10">
                        <th colspan="1">請求単価②</th>
                        <td colspan="4">
                            @if (is_null(old('invoice_unit_price_2')))
                            <input type="text" class="form-control" name="invoice_unit_price_2" value="{{ isset($jobOffer->invoice_unit_price_2) ? $jobOffer->invoice_unit_price_2 : '' }}">
                            @else
                            <input type="text" class="form-control" name="invoice_unit_price_2" value="{{ old('invoice_unit_price_2') }}">
                            @endif
                        </td>

                        <th colspan="1">請求単位②</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="billing_unit_2">
                            <option value="">請求単位を選んで下さい</option>
                            @foreach( config('options.salary_term') as $key => $billing_unit_2 )
                                @if (is_null(old('billing_unit_2')))
                                <option value="{{ $key }}"  {{ $key == $jobOffer->billing_unit_2 ? 'selected' : '' }}>{{ $billing_unit_2 }}</option>
                                @else
                                <option value="{{ $key }}"  {{ $key == old('billing_unit_2') ? 'selected' : '' }}>{{ $billing_unit_2 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="billing-2" colspan="10">
                        <th colspan="1">利益率②</th>
                        <td colspan="4">
                            @if (is_null(old('profit_rate_2')))
                            <input type="text" class="form-control" name="profit_rate_2" value="{{ isset($jobOffer->profit_rate_2) ? $jobOffer->profit_rate_2 : '' }}">
                            @else
                            <input type="text" class="form-control" name="profit_rate_2" value="{{ old('profit_rate_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="billing-2" colspan="10">
                        <th colspan="1">
                            請求情報②備考<br>
                            <i class="bi bi-dash-circle" id="close_billing_2"></i>
                            <i class="bi bi-plus-circle" id="open_billing_3"></i>
                        </th>
                        <td colspan="9">
                            @if (is_null(old('billing_information_2')))
                            <input type="text"class="form-control" maxlength="100" name="billing_information_2" value="{{ isset($jobOffer->billing_information_2) ? $jobOffer->billing_information_2 : '' }}">
                            @else
                            <input type="text"class="form-control" maxlength="100" name="billing_information_2" value="{{ old('billing_information_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="billing-3" colspan="10">
                        <th colspan="1">請求単価③</th>
                        <td colspan="4">
                            @if (is_null(old('invoice_unit_price_3')))
                            <input type="text" class="form-control" name="invoice_unit_price_3" value="{{ isset($jobOffer->invoice_unit_price_3) ? $jobOffer->invoice_unit_price_3 : '' }}">
                            @else
                            <input type="text" class="form-control" name="invoice_unit_price_3" value="{{ old('invoice_unit_price_3') }}">
                            @endif
                        </td>

                        <th colspan="1">請求単位③</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="billing_unit_3">
                            <option value="">請求単位を選んで下さい</option>
                            @foreach( config('options.salary_term') as $key => $billing_unit_3 )
                                @if (is_null(old('billing_unit_3')))
                                <option value="{{ $key }}"  {{ $key == $jobOffer->billing_unit_3 ? 'selected' : '' }}>{{ $billing_unit_3 }}</option>
                                @else
                                <option value="{{ $key }}"  {{ $key == old('billing_unit_3') ? 'selected' : '' }}>{{ $billing_unit_3 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="billing-3" colspan="10">
                        <th colspan="1">利益率③</th>
                        <td colspan="4">
                            @if (is_null(old('profit_rate_3')))
                            <input type="text" class="form-control" name="profit_rate_3" value="{{ isset($jobOffer->profit_rate_3) ? $jobOffer->profit_rate_3 : '' }}">
                            @else
                            <input type="text" class="form-control" name="profit_rate_3" value="{{ old('profit_rate_3') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="billing-3" colspan="10">
                        <th colspan="1">
                            請求情報③備考<br>
                            <i class="bi bi-dash-circle" id="close_billing_3"></i>
                        </th>
                        <td colspan="9">
                            @if (is_null(old('billing_information_3')))
                            <input type="text"class="form-control" maxlength="100" name="billing_information_3" value="{{ isset($jobOffer->billing_information_3) ? $jobOffer->billing_information_3 : '' }}">
                            @else
                            <input type="text"class="form-control" maxlength="100" name="billing_information_3" value="{{ old('billing_information_3') }}">
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table only-not-introduced" style="width: 100%; table-layout: fixed;">
                <tbody>
                    <div class="card-header only-not-introduced">▼支払情報</div>
                    <tr colspan="10">
                        <th colspan="1">雇用保険加入<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select required" name="employment_insurance" required>
                            <option value="">雇用保険の有無を選んで下さい</option>
                            @foreach( config('options.existence') as $key => $employment_insurance )
                                @if (is_null(old('billing_information_3')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->employment_insurance ? 'selected' : '' }}>{{ $employment_insurance }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('billing_information_3') ? 'selected' : '' }}>{{ $employment_insurance }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>

                        <th colspan="1">社会保険加入<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select required" name="social_insurance" required>
                            <option value="">社会保険の有無を選んで下さい</option>
                            @foreach( config('options.existence') as $key => $social_insurance )
                                @if (is_null(old('social_insurance')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->social_insurance ? 'selected' : '' }}>{{ $social_insurance }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('social_insurance') ? 'selected' : '' }}>{{ $social_insurance }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">支払単価①<span class="text-danger">*</span></th>
                        <td colspan="4">
                            @if (is_null(old('payment_unit_price_1')))
                            <input type="text" class="form-control required" name="payment_unit_price_1" value="{{ isset($jobOffer->payment_unit_price_1) ? $jobOffer->payment_unit_price_1 : '' }}" required>
                            @else
                            <input type="text" class="form-control" name="payment_unit_price_1" value="{{ old('payment_unit_price_1') }}" required>
                            @endif
                        </td>

                        <th colspan="1">支払単位①<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select required" name="payment_unit_1" required>
                                <option value="">交通費支払単位を選んで下さい</option>
                                @foreach( config('options.salary_term') as $key => $payment_unit_1 )
                                    @if (is_null(old('payment_unit_1')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->payment_unit_1 ? 'selected' : '' }}>{{ $payment_unit_1 }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('payment_unit_1') ? 'selected' : '' }}>{{ $payment_unit_1 }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">交通費①</th>
                        <td colspan="4">
                            @if (is_null(old('carfare_1')))
                            <input  type="text" class="form-control" name="carfare_1" value="{{ isset($jobOffer->carfare_1) ? $jobOffer->carfare_1 : '' }}">
                            @else
                            <input  type="text" class="form-control" name="carfare_1" value="{{ old('carfare_1') }}">
                            @endif
                        </td>

                        <th colspan="1">交通費支払単位①</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="carfare_payment_1">
                            <option value="">交通費支払単位を選んで下さい</option>
                            @foreach( config('options.payment_term') as $key => $carfare_payment_1 )
                                @if (is_null(old('carfare_payment_1')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->carfare_payment_1 ? 'selected' : '' }}>{{ $carfare_payment_1 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('carfare_payment_1') ? 'selected' : '' }}>{{ $carfare_payment_1 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">支払情報①備考<br><i class="bi bi-plus-circle" id="open_payment_2"></i></th>
                        <td colspan="9">
                            @if (is_null(old('carfare_payment_remarks_1')))
                            <input  type="text" class="form-control" name="carfare_payment_remarks_1" value="{{ isset($jobOffer->carfare_payment_remarks_1) ? $jobOffer->carfare_payment_remarks_1 : '' }}">
                            @else
                            <input  type="text" class="form-control" name="carfare_payment_remarks_1" value="{{ old('carfare_payment_remarks_1') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="payment-2" colspan="10">
                        <th colspan="1">雇用保険加入②</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="employment_insurance_2">
                            <option value="">雇用保険の有無を選んで下さい</option>
                            @foreach( config('options.existence') as $key => $employment_insurance_2 )
                                @if (is_null(old('employment_insurance_2')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->employment_insurance_2 ? 'selected' : '' }}>{{ $employment_insurance_2 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('employment_insurance_2') ? 'selected' : '' }}>{{ $employment_insurance_2 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>

                        <th colspan="1">社会保険加入②</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="social_insurance_2">
                            <option value="">社会保険の有無を選んで下さい</option>
                            @foreach( config('options.existence') as $key => $social_insurance_2 )
                                @if (is_null(old('social_insurance_2')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->social_insurance_2 ? 'selected' : '' }}>{{ $social_insurance_2 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('social_insurance_2') ? 'selected' : '' }}>{{ $social_insurance_2 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="payment-2" colspan="10">
                        <th colspan="1">支払単価②</th>
                        <td colspan="4">
                            @if (is_null(old('payment_unit_price_2')))
                            <input  type="text" class="form-control" name="payment_unit_price_2" value="{{ isset($jobOffer->payment_unit_price_2) ? $jobOffer->payment_unit_price_2 : '' }}">
                            @else
                            <input  type="text" class="form-control" name="payment_unit_price_2" value="{{ old('payment_unit_price_2') }}">
                            @endif
                        </td>

                        <th colspan="1">支払単位②</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="payment_unit_2">
                                <option value="">支払単位を選んで下さい</option>
                                @foreach( config('options.salary_term') as $key => $payment_unit_2 )
                                    @if (is_null(old('payment_unit_2')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->payment_unit_2 ? 'selected' : '' }}>{{ $payment_unit_2 }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('payment_unit_2') ? 'selected' : '' }}>{{ $payment_unit_2 }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="payment-2" colspan="10">
                        <th colspan="1">交通費②</th>
                        <td colspan="4">
                            @if (is_null(old('carfare_2')))
                            <input  type="text" class="form-control" name="carfare_2" value="{{ isset($jobOffer->carfare_2) ? $jobOffer->carfare_2 : '' }}">
                            @else
                            <input  type="text" class="form-control" name="carfare_2" value="{{ old('carfare_2') }}">
                            @endif
                        </td>

                        <th colspan="1">交通費支払単位②</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="carfare_payment_2">
                            <option value="">交通費支払単位を選んで下さい</option>
                            @foreach( config('options.payment_term') as $key => $carfare_payment_2 )
                                @if (is_null(old('carfare_payment_2')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->carfare_payment_2 ? 'selected' : '' }}>{{ $carfare_payment_2 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('carfare_payment_2') ? 'selected' : '' }}>{{ $carfare_payment_2 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="payment-2" colspan="10">
                        <th colspan="1">
                            支払情報②備考<br>
                            <i class="bi bi-dash-circle" id="close_payment_2"></i>
                            <i class="bi bi-plus-circle" id="open_payment_3"></i>
                        </th>
                        <td colspan="9">
                            @if (is_null(old('carfare_payment_remarks_2')))
                            <input  type="text" class="form-control" name="carfare_payment_remarks_2" value="{{ isset($jobOffer->carfare_payment_remarks_2) ? $jobOffer->carfare_payment_remarks_2 : '' }}">
                            @else
                            <input  type="text" class="form-control" name="carfare_payment_remarks_2" value="{{ old('carfare_payment_remarks_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="payment-3" colspan="10">
                        <th colspan="1">雇用保険加入③</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="employment_insurance_3" >
                            <option value="">雇用保険の有無を選んで下さい</option>
                            @foreach( config('options.existence') as $key => $employment_insurance_3 )
                                @if (is_null(old('employment_insurance_3')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->employment_insurance_3 ? 'selected' : '' }}>{{ $employment_insurance_3 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('employment_insurance_3') ? 'selected' : '' }}>{{ $employment_insurance_3 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>

                        <th colspan="1">社会保険加入③</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="social_insurance_3">
                            <option value="">社会保険の有無を選んで下さい</option>
                            @foreach( config('options.existence') as $key => $social_insurance_3 )
                                @if (is_null(old('social_insurance_3')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->social_insurance_3 ? 'selected' : '' }}>{{ $social_insurance_3 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('social_insurance_3') ? 'selected' : '' }}>{{ $social_insurance_3 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="payment-3" colspan="10">
                        <th colspan="1">支払単価③</th>
                        <td colspan="4">
                            @if (is_null(old('payment_unit_price_3')))
                            <input  type="text" class="form-control" name="payment_unit_price_3" value="{{ isset($jobOffer->payment_unit_price_3) ? $jobOffer->payment_unit_price_3 : '' }}">
                            @else
                            <input  type="text" class="form-control" name="payment_unit_price_3" value="{{ old('payment_unit_price_3') }}">
                            @endif
                        </td>

                        <th colspan="1">支払単位③</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="payment_unit_3">
                            <option value="">支払単位を選んで下さい</option>
                            @foreach( config('options.salary_term') as $key => $payment_unit_3 )
                                @if (is_null(old('payment_unit_3')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->payment_unit_3 ? 'selected' : '' }}>{{ $payment_unit_3 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('payment_unit_3') ? 'selected' : '' }}>{{ $payment_unit_3 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="payment-3" colspan="10">
                        <th colspan="1">交通費③</th>
                        <td colspan="4">
                            @if (is_null(old('carfare_3')))
                            <input  type="text" class="form-control" name="carfare_3" value="{{ isset($jobOffer->carfare_3) ? $jobOffer->carfare_3 : '' }}">
                            @else
                            <input  type="text" class="form-control" name="carfare_3" value="{{ old('carfare_3') }}">
                            @endif
                        </td>

                        <th colspan="1">交通費支払単位③</th>
                        <td colspan="4">
                        <select type="text" class="select form-select" name="carfare_payment_3">
                            <option value="">交通費支払単位を選んで下さい</option>
                            @foreach( config('options.payment_term') as $key => $carfare_payment_3 )
                                @if (is_null(old('carfare_payment_3')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->carfare_payment_3 ? 'selected' : '' }}>{{ $carfare_payment_3 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('carfare_payment_3') ? 'selected' : '' }}>{{ $carfare_payment_3 }}</option>
                                @endif
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
                            @if (is_null(old('carfare_payment_remarks_3')))
                            <input  type="text" class="form-control" name="carfare_payment_remarks_3" value="{{ isset($jobOffer->carfare_payment_remarks_3) ? $jobOffer->carfare_payment_remarks_3 : '' }}">
                            @else
                            <input  type="text" class="form-control" name="carfare_payment_remarks_3" value="{{ old('carfare_payment_remarks_3') }}">
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table" style="width: 100%; table-layout: fixed;">
                <tbody>
                    <div class="card-header">▼就業期間</div>
                    <tr colspan="10">
                        <th colspan="1">予定期間</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="scheduled_period">
                                <option value="">予定期間を選んで下さい</option>
                                @if (is_null(old('scheduled_period')))
                                    @foreach( config('options.scheduled_period') as $key => $scheduled_period )
                                        <option value="{{ $key }}" {{ $key == $jobOffer->scheduled_period ? 'selected' : '' }}>{{ $scheduled_period }}</option>
                                    @endforeach
                                @else
                                    @foreach( config('options.scheduled_period') as $key => $scheduled_period )
                                        <option value="{{ $key }}" {{ old('scheduled_period') == $key ? 'selected' : '' }}>{{ $scheduled_period }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </td>

                        <th colspan="1">終了予定日</th>
                        <td colspan="4">
                            @if (is_null(old('expected_end_date')))
                            <input  type="date" class="form-control" name="expected_end_date" value="{{ isset($jobOffer->expected_end_date) ? $jobOffer->expected_end_date : '' }}">
                            @else
                            <input  type="date" class="form-control" name="expected_end_date" value="{{ old('expected_end_date') }}">
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">期間備考</th>
                        <td colspan="9">
                            @if (is_null(old('period_remarks')))
                            <input  type="text" class="form-control" name="period_remarks" value="{{ isset($jobOffer->period_remarks) ? $jobOffer->period_remarks : '' }}">
                            @else
                            <input  type="text" class="form-control" name="period_remarks" value="{{ old('period_remarks') }}">
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table" style="width: 100%; table-layout: fixed;">
                <tbody>
                    <div class="card-header">▼休日・休暇</div>
                    <tr colspan="10">
                        <th colspan="1">休日<span class="text-danger">*</span></th>
                        <td colspan="9">
                            @foreach(config('options.holiday') as $index => $holiday)
                                <div class="form-check form-check-inline">
                                    @if (is_null(old('holiday')))
                                    <input class="form-check-input required" type="checkbox" id="{{ 'holidayInput' . $index }}" name="holiday[]" value="{{ $index }}" @if(is_array($jobOffer->holiday)) {{ in_array($index, $jobOffer->holiday) ? 'checked' : '' }} @endif>
                                    @else
                                    <input class="form-check-input required" type="checkbox" id="{{ 'holidayInput' . $index }}" name="holiday[]" value="{{ $index }}" @if(in_array($index, old('holiday'))) checked @endif>
                                    @endif
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
                                    @if (is_null(old('long_vacation')))
                                    <input class="form-check-input" type="checkbox" id="{{ 'longVacationInput' . $index }}" name="long_vacation[]" value="{{ $index }}" @if(is_array($jobOffer->long_vacation)) {{ in_array($index, $jobOffer->long_vacation) ? 'checked' : '' }} @endif>
                                    @else
                                    <input class="form-check-input" type="checkbox" id="{{ 'longVacationInput' . $index }}" name="long_vacation[]" value="{{ $index }}" @if(in_array($index, old('long_vacation'))) checked @endif>
                                    @endif
                                    <label class="form-check-label" for="{{ 'longVacationInput' . $index }}">{{ $longVacation }}</label>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">休日備考</th>
                        <td colspan="9">
                            @if (is_null(old('holiday_remarks')))
                            <textarea type="textarea" rows="1" class="form-control" name="holiday_remarks"> {{ isset($jobOffer->holiday_remarks) ? $jobOffer->holiday_remarks : '' }}</textarea>
                            @else
                            <textarea type="textarea" rows="1" class="form-control" name="holiday_remarks"> {{ old('holiday_remarks') }}</textarea>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table" style="width: 100%; table-layout: fixed;">
                <tbody>
                    <div class="card-header">▼就業時間</div>
                    <tr colspan="10">
                        <th colspan="1">勤務時間①<span class="text-danger">*</span></th>
                        <td colspan="4">
                            @if (is_null(old('working_hours_1')))
                            <input type="text" class="form-control required" name="working_hours_1" value="{{ isset($jobOffer->working_hours_1) ? $jobOffer->working_hours_1 : '' }}" required>
                            @else
                            <input type="text" class="form-control required" name="working_hours_1" value="{{ old('working_hours_1') }}" required>
                            @endif
                        </td>

                        <th colspan="1">実働時間①<span class="text-danger">*</span></th>
                        <td colspan="4">
                            @if (is_null(old('actual_working_hours_1')))
                            <input type="text" class="form-control required" name="actual_working_hours_1" value="{{ isset($jobOffer->actual_working_hours_1) ? $jobOffer->actual_working_hours_1 : '' }}" required>
                            @else
                            <input type="text" class="form-control required" name="actual_working_hours_1" value="{{ old('actual_working_hours_1') }}" required>
                            @endif
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
                            @if (is_null(old('break_time_1')))
                            <input type="text" class="form-control required" name="break_time_1" value="{{ isset($jobOffer->break_time_1) ? $jobOffer->break_time_1 : '' }}" required>
                            @else
                            <input type="text" class="form-control required" name="break_time_1" value="{{ old('break_time_1') }}" required>
                            @endif
                        </td>
                    </tr>
                    <tr class="working-2" colspan="10">
                        <th colspan="1">勤務時間②</th>
                        <td colspan="4">
                            @if (is_null(old('working_hours_2')))
                            <input type="text" class="form-control" name="working_hours_2" value="{{ isset($jobOffer->working_hours_2) ? $jobOffer->working_hours_2 : '' }}">
                            @else
                            <input type="text" class="form-control" name="working_hours_2" value="{{ old('working_hours_2') }}">
                            @endif
                        </td>

                        <th colspan="1">実働時間②</th>
                        <td colspan="4">
                            @if (is_null(old('working_hours_2')))
                            <input type="text" class="form-control" name="actual_working_hours_2" value="{{ isset($jobOffer->actual_working_hours_2) ? $jobOffer->actual_working_hours_2 : '' }}">
                            @else
                            <input type="text" class="form-control" name="actual_working_hours_2" value="{{ old('working_hours_2') }}">
                            @endif
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
                            @if (is_null(old('break_time_2')))
                            <input type="text" class="form-control" name="break_time_2" value="{{ isset($jobOffer->break_time_2) ? $jobOffer->break_time_2 : '' }}">
                            @else
                            <input type="text" class="form-control" name="break_time_2" value="{{ old('break_time_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="working-3" colspan="10">
                        <th colspan="1">勤務時間③</th>
                        <td colspan="4">
                            @if (is_null(old('working_hours_3')))
                            <input type="text" class="form-control" name="working_hours_3" value="{{ isset($jobOffer->working_hours_3) ? $jobOffer->working_hours_3 : '' }}">
                            @else
                            <input type="text" class="form-control" name="working_hours_3" value="{{ old('working_hours_3') }}">
                            @endif
                        </td>

                        <th colspan="1">実働時間③</th>
                        <td colspan="4">
                            @if (is_null(old('actual_working_hours_3')))
                            <input type="text" class="form-control" name="actual_working_hours_3" value="{{ isset($jobOffer->actual_working_hours_3) ? $jobOffer->actual_working_hours_3 : '' }}">
                            @else
                            <input type="text" class="form-control" name="actual_working_hours_3" value="{{ old('actual_working_hours_3') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="working-3" colspan="10">
                        <td colspan="5">
                            <br>
                            <i class="bi bi-dash-circle" id="close_working_3"></i>
                        </td>
                        <th colspan="1">
                            休憩時間③
                        </th>
                        <td colspan="4">
                            @if (is_null(old('break_time_3')))
                            <input type="text" class="form-control" name="break_time_3" value="{{ isset($jobOffer->break_time_3) ? $jobOffer->break_time_3 : '' }}">
                            @else
                            <input type="text" class="form-control" name="break_time_3" value="{{ old('break_time_3') }}">
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">残業(時間/月)<span class="text-danger">*</span></th>
                        <td colspan="4">
                            @if (is_null(old('overtime')))
                            <input  type="text" class="form-control required" name="overtime" value="{{ isset($jobOffer->overtime) ? $jobOffer->overtime : '' }}" required>
                            @else
                            <input  type="text" class="form-control required" name="overtime" value="{{ old('overtime') }}" required>
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">勤務時間備考</th>
                        <td colspan="9">
                            @if (is_null(old('working_hours_remarks')))
                            <textarea type="textarea" rows="5" class="form-control" name="working_hours_remarks"> {{ isset($jobOffer->working_hours_remarks) ? $jobOffer->working_hours_remarks : '' }}</textarea>
                            @else
                            <textarea type="textarea" rows="5" class="form-control" name="working_hours_remarks"> {{ old('working_hours_remarks') }}</textarea>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table" style="width: 100%; table-layout: fixed;">
                <tbody>
                    <div class="card-header">▼通勤・交通</div>
                    <tr colspan="10">
                        <th colspan="1">最寄り駅</th>
                        <td colspan="4">
                            @if (is_null(old('nearest_station')))
                            <input  type="text" class="form-control" name="nearest_station" value="{{ isset($jobOffer->nearest_station) ? $jobOffer->nearest_station : '' }}">
                            @else
                            <input  type="text" class="form-control" name="nearest_station" value="{{ old('nearest_station') }}">
                            @endif
                        </td>

                        <th colspan="1">駅からの所要時間</th>
                        <td colspan="4">
                            @if (is_null(old('travel_time_station')))
                            <input  type="text" class="form-control" name="travel_time_station" value="{{ isset($jobOffer->travel_time_station) ? $jobOffer->travel_time_station : '' }}">
                            @else
                            <input  type="text" class="form-control" name="travel_time_station" value="{{ old('travel_time_station') }}">
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">最寄りバス停</th>
                        <td colspan="4">
                            @if (is_null(old('nearest_bus_stop')))
                            <input type="text" class="form-control" name="nearest_bus_stop" value="{{ isset($jobOffer->nearest_bus_stop) ? $jobOffer->nearest_bus_stop : '' }}">
                            @else
                            <input type="text" class="form-control" name="nearest_bus_stop" value="{{ old('nearest_bus_stop') }}">
                            @endif
                        </td>

                        <th colspan="1">バス停からの所要時間</th>
                        <td colspan="4">
                            @if (is_null(old('travel_time_bus_stop')))
                            <input  type="text" class="form-control" name="travel_time_bus_stop" value="{{ isset($jobOffer->travel_time_bus_stop) ? $jobOffer->travel_time_bus_stop : '' }}">
                            @else
                            <input  type="text" class="form-control" name="travel_time_bus_stop" value="{{ old('travel_time_bus_stop') }}">
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">車通勤<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select required" name="commuting_by_car" required>
                            <option value="">車通勤の可否を選んで下さい</option>
                            @foreach( config('options.permission') as $key => $commuting_by_car )
                                @if (is_null(old('commuting_by_car')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->commuting_by_car ? 'selected' : '' }}>{{ $commuting_by_car }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('commuting_by_car') ? 'selected' : '' }}>{{ $commuting_by_car }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>

                        <th colspan="1">駐車場<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select required" name="parking" required>
                            <option value="">駐車場の有無を選んで下さい</option>
                            @foreach( config('options.parking') as $key => $parking )
                                @if (is_null(old('parking')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->parking ? 'selected' : '' }}>{{ $parking }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('parking') ? 'selected' : '' }}>{{ $parking }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">交通通勤備考</th>
                        <td colspan="9">
                            @if (is_null(old('traffic_commuting_remarks')))
                            <textarea type="textarea" rows="5" class="form-control" name="traffic_commuting_remarks"> {{ isset($jobOffer->traffic_commuting_remarks) ? $jobOffer->traffic_commuting_remarks : '' }}</textarea>
                            @else
                            <textarea type="textarea" rows="5" class="form-control" name="traffic_commuting_remarks"> {{ old('traffic_commuting_remarks') }}</textarea>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table" style="width: 100%; table-layout: fixed;">
                <tbody>
                    <div class="card-header">▼求める人材</div>
                    <tr colspan="10">
                        <th colspan="1">資格要件</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="qualification">
                                <option value="">資格要件を選んで下さい</option>
                                @foreach( config('options.requirement') as $key => $qualification )
                                    @if (is_null(old('qualification')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->qualification ? 'selected' : '' }}>{{ $qualification }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('qualification') ? 'selected' : '' }}>{{ $qualification }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">資格名</th>
                        <td colspan="9">
                            @if (is_null(old('qualification_content')))
                            <input  type="text" class="form-control" name="qualification_content" value="{{ isset( $jobOffer->qualification_content) ? $jobOffer->qualification_content : '' }}">
                            @else
                            <input  type="text" class="form-control" name="qualification_content" value="{{ old('qualification_content') }}">
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">経験要件</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="experience">
                                <option value="">経験要件を選んで下さい</option>
                                @foreach( config('options.requirement') as $key => $experience )
                                    @if (is_null(old('experience')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->experience ? 'selected' : '' }}>{{ $experience }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('experience') ? 'selected' : '' }}>{{ $experience }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">経験内容</th>
                        <td colspan="9">
                            @if (is_null(old('experience_content')))
                            <input  type="text" class="form-control" name="experience_content" value="{{ isset( $jobOffer->experience_content) ? $jobOffer->experience_content : '' }}">
                            @else
                            <input  type="text" class="form-control" name="experience_content" value="{{ old('experience_content') }}">
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">性別要件</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="sex">
                                <option value="">性別要件を選んで下さい</option>
                                @foreach( config('options.sex') as $key => $sex )
                                    @if (is_null(old('sex')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->sex ? 'selected' : '' }}>{{ $sex }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('sex') ? 'selected' : '' }}>{{ $sex }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                        <th colspan="1">年齢要件</th>
                        <td colspan="4">
                            @if (is_null(old('age')))
                            <input  type="text" class="form-control" name="age" value="{{ isset( $jobOffer->age) ? $jobOffer->age : '' }}" placeholder="（例）20代から40代">
                            @else
                            <input  type="text" class="form-control" name="age" value="{{ old('age') }}" placeholder="（例）20代から40代">
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table" style="width: 100%; table-layout: fixed;">
                <tbody>
                    <div class="card-header">▼職場環境、他</div>
                    <tr colspan="10">
                        <th colspan="1">屋内の受動喫煙対策の内容<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select type="text" class="select form-select required" name="counter_measures" required>
                                <option value="">屋内の受動喫煙対策を選んで下さい</option>
                                @foreach( config('options.counter_measures') as $key => $counter_measures )
                                    @if (is_null(old('counter_measures')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->counter_measures ? 'selected' : '' }}>{{ $counter_measures }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('counter_measures') ? 'selected' : '' }}>{{ $counter_measures }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">制服支給の有無</th>
                        <td colspan="4">
                            <select type="text" class="select form-select" name="uniform_supply">
                                <option value="">制服支給の有無を選んで下さい</option>
                                @foreach( config('options.uniform_supply') as $key => $uniformSupply )
                                    @if (is_null(old('uniform_supply')))
                                    <option value="{{ $key }}" {{ $key == $jobOffer->uniform_supply ? 'selected' : '' }}>{{ $uniformSupply }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('uniform_supply') ? 'selected' : '' }}>{{ $uniformSupply }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                        <th colspan="1">支給物</th>
                        <td colspan="4">
                            @if (is_null(old('supply')))
                            <input  type="text" class="form-control" name="supply" value="{{ isset( $jobOffer->supply) ? $jobOffer->supply : '' }}">
                            @else
                            <input  type="text" class="form-control" name="supply" value="{{ old('supply') }}">
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">服装</th>
                        <td colspan="4">
                            @if (is_null(old('clothes')))
                            <input  type="text" class="form-control" name="clothes" value="{{ isset( $jobOffer->clothes) ? $jobOffer->clothes : '' }}">
                            @else
                            <input  type="text" class="form-control" name="clothes" value="{{ old('clothes') }}">
                            @endif
                        </td>

                        <th colspan="1">その他髪色</th>
                        <td colspan="4">
                            @if (is_null(old('other_hair_colors')))
                            <input  type="text" class="form-control" name="other_hair_colors" value="{{ isset( $jobOffer->other_hair_colors) ? $jobOffer->other_hair_colors : '' }}">
                            @else
                            <input  type="text" class="form-control" name="other_hair_colors" value="{{ old('other_hair_colors') }}">
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">自身で準備するもの</th>
                        <td colspan="9">
                            @if (is_null(old('self_prepared')))
                            <input  type="text" class="form-control" name="self_prepared" value="{{ isset( $jobOffer->self_prepared) ? $jobOffer->self_prepared : '' }}">
                            @else
                            <input  type="text" class="form-control" name="self_prepared" value="{{ old('self_prepared') }}">
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">職場の雰囲気・備考</th>
                        <td colspan="9">
                            @if (is_null(old('remarks_workplace')))
                            <textarea type="textarea" rows="10" class="form-control" name="remarks_workplace">{{ isset( $jobOffer->remarks_workplace) ? $jobOffer->remarks_workplace : '' }}</textarea>
                            @else
                            <textarea type="textarea" rows="10" class="form-control" name="remarks_workplace">{{ old('remarks_workplace') }}</textarea>
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">男女比</th>
                        <td colspan="9">
                            @if (is_null(old('gender_ratio')))
                            <input  type="text" class="form-control" name="gender_ratio" value="{{ isset( $jobOffer->gender_ratio) ? $jobOffer->gender_ratio : '' }}" placeholder="6対4">
                            @else
                            <input  type="text" class="form-control" name="gender_ratio" value="{{ old('gender_ratio') }}" placeholder="6対4">
                            @endif
                        </td>
                    </tr>
                    <tr colspan="10">
                        <th colspan="1">年齢比率</th>
                        <td colspan="9">
                            @if (is_null(old('age_ratio')))
                            <input  type="text" class="form-control" name="age_ratio" value="{{ isset( $jobOffer->age_ratio) ? $jobOffer->age_ratio : '' }}" placeholder="20代 20%, 30代 50%, その他 30%">
                            @else
                            <input  type="text" class="form-control" name="age_ratio" value="{{ old('age_ratio') }}" placeholder="20代 20%, 30代 50%, その他 30%">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit" colspan="10">
                        <th colspan="2"><div class="text-center">人材紹介/紹介予定　採用後条件</div></th>
                    </tr>
                    <tr class="afterRecruit" colspan="10">
                        <th colspan="1">紹介後</th>
                        <td colspan="4">
                            @if (is_null(old('after_introduction')))
                            <input  type="text" class="form-control" name="after_introduction" value="{{ isset($jobOffer->after_introduction) ? $jobOffer->after_introduction : '' }}">
                            @else
                            <input  type="text" class="form-control" name="after_introduction" value="{{ old('after_introduction') }}">
                            @endif
                        </td>

                        <th colspan="1">直接雇用切替時期</th>
                        <td colspan="4">
                            @if (is_null(old('timing_of_switching')))
                            <input  type="text" class="form-control" name="timing_of_switching" value="{{ isset($jobOffer->timing_of_switching) ? $jobOffer->timing_of_switching : '' }}">
                            @else
                            <input  type="text" class="form-control" name="timing_of_switching" value="{{ old('timing_of_switching') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit" colspan="10">
                        <th colspan="1">月収例（下限）</th>
                        <td colspan="9">
                            @if (is_null(old('monthly_lower_limit')))
                            <input  type="text" class="form-control" name="monthly_lower_limit" value="{{ isset($jobOffer->monthly_lower_limit) ? $jobOffer->monthly_lower_limit : '' }}">
                            @else
                            <input  type="text" class="form-control" name="monthly_lower_limit" value="{{ old('monthly_lower_limit') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit" colspan="10">
                        <th colspan="1">月収例（上限）</th>
                        <td colspan="9">
                            @if (is_null(old('monthly_upper_limit')))
                            <input  type="text" class="form-control" name="monthly_upper_limit" value="{{ isset($jobOffer->monthly_upper_limit) ? $jobOffer->monthly_upper_limit : '' }}">
                            @else
                            <input  type="text" class="form-control" name="monthly_upper_limit" value="{{ old('monthly_upper_limit') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit" colspan="10">
                        <th colspan="1">年収例（下限）</th>
                        <td colspan="9">
                            @if (is_null(old('annual_lower_limit')))
                            <input  type="text" class="form-control" name="annual_lower_limit" value="{{ isset($jobOffer->annual_lower_limit) ? $jobOffer->annual_lower_limit : '' }}">
                            @else
                            <input  type="text" class="form-control" name="annual_lower_limit" value="{{ old('annual_lower_limit') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit" colspan="10">
                        <th colspan="1">年収例（上限）</th>
                        <td colspan="9">
                            @if (is_null(old('annual_upper_limit')))
                            <input  type="text" class="form-control" name="annual_upper_limit" value="{{ isset($jobOffer->annual_upper_limit) ? $jobOffer->annual_upper_limit : '' }}">
                            @else
                            <input  type="text" class="form-control" name="annual_upper_limit" value="{{ old('annual_upper_limit') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit" colspan="10">
                        <th colspan="1">賞与等・待遇</th>
                        <td colspan="9">
                            @if (is_null(old('bonuses_treatment')))
                            <textarea tabindex="-1"  type="text" class="form-control" name="bonuses_treatment" rows=5>{{ isset($jobOffer->bonuses_treatment) ? $jobOffer->bonuses_treatment : '' }}</textarea>
                            @else
                            <textarea tabindex="-1"  type="text" class="form-control" name="bonuses_treatment" rows=5>{{ old('bonuses_treatment') }}</textarea>
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit" colspan="10">
                        <th colspan="1">休日・休暇</th>
                        <td colspan="9">
                            @if (is_null(old('holidays_vacations')))
                            <textarea tabindex="-1"  type="text" class="form-control" name="holidays_vacations" rows=5>{{ isset($jobOffer->holidays_vacations) ? $jobOffer->holidays_vacations : '' }}</textarea>
                            @else
                            <textarea tabindex="-1"  type="text" class="form-control" name="holidays_vacations" rows=5>{{ old('holidays_vacations') }}</textarea>
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit" colspan="10">
                        <th colspan="1">その他</th>
                        <td colspan="9">
                            @if (is_null(old('introduction_others')))
                            <textarea tabindex="-1"  type="text" class="form-control" name="introduction_others" rows=5>{{ isset($jobOffer->introduction_others) ? $jobOffer->introduction_others : '' }}</textarea>
                            @else
                            <textarea tabindex="-1"  type="text" class="form-control" name="introduction_others" rows=5>{{ old('introduction_others') }}</textarea>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table" style="width: 100%; table-layout: fixed;">
                <tbody>
                    <div class="card-header">求人情報新規登録</div>
                    <tr colspan="10">
                        <th colspan="1">作成ステータス<span class="text-danger">*</span></th>
                        <td colspan="4">
                            <select id="statusInput" class="select form-select required" name="status" required>
                            <option value="">作成ステータスを選んで下さい</option>
                            @foreach( config('options.status_edit') as $key => $status )
                                @if (is_null(old('status')))
                                <option value="{{ $key }}" {{ $key == $jobOffer->status ? 'selected' : '' }}>{{ $status }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('status') ? 'selected' : '' }}>{{ $status }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                        <tr class="after-closed">
                            <th colspan="1">求人取り下げの理由</th>
                            <td  colspan="4">
                                <select type="text" class="select form-select" name="job_withdrawal">
                                    <option value="">求人取り下げの理由を選んで下さい</option>
                                    @foreach( config('options.job_withdrawal') as $key => $job_withdrawal )
                                        @if (is_null(old('status')))
                                            <option value="{{ $key }}" {{ $key == $jobOffer->job_withdrawal ? 'selected' : '' }}>{{ $job_withdrawal }}</option>
                                        @else
                                            <option value="{{ $key }}" {{ $key == old('job_withdrawal') ? 'selected' : '' }}>{{ $job_withdrawal }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </tr>
                </tbody>
            </table>

            @if(!$isDraftJobOffer)
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
                    <select type="text" class="select form-select" name="item">
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
            @endif

            <div class="d-flex justify-content-center mt-4 mb-1">
                <button class="btn btn-primary" type="submit">登録</button>
            </div>
            <div class="align-self-center mb-3">
                <input type="checkbox" id="send_slack_message" name="send_slack_message" checked>
                <label for="send_slack_message">変更内容をSlackに通知する</label>
            </div>

            @if($isDraftJobOffer)
                <div class="d-flex justify-content-center mt-4 mb-3">
                    <button class="btn btn-secondary" type="submit" formaction="{{ route('draft.update', $jobOffer->id) }}">下書き保存</button>
                </div>
            @endif

            @if($jobOffer->is_duplicated)
                <div class="d-flex justify-content-center mt-4 mb-3">
                    <button class="btn btn-secondary" type="submit" formaction="{{ route('draft.create') }}">下書き保存</button>
                </div>
            @endif
        </form>
    </div>

    @if( $errors->any() )
      <ul>
        @foreach($errors->all() as $error)
          <li class="text-danger">{{$error}}</li>
        @endforeach
      </ul>
    @endif


    @if(!$isDraftJobOffer)
    <div class="card mb-4">
      <div class="card-header">活動記録 一覧</div>
      <table class="table">
        <tbody>
          <tr>
            <th>日付</th>
            <th>項目</th>
            <th>詳細</th>
            <th>操作</th>
          </tr>
          @if(isset($activityRecords))
          @foreach($activityRecords as $activityRecord)
          <tr>
              <td>{{ $activityRecord->date }}</td>
              <td>{{ config('options.item')[$activityRecord->item] }}</td>
              <td>{{ $activityRecord->detail }}</td>
              <td>
                <a href="{{ route('activity.destroy', ['id' => $activityRecord->id, 'jobOfferId' => $jobOffer->id]) }}">
                    <button id="delete-activity-record" class="delete-btn btn btn-danger mb-2 me-3" type="button">削除</button>
                </a>
              </td>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>
    </div>
    @endif

    <a href="{{ route('job_offers.index') }}">
        <button class="btn btn-outline-secondary btn-lg" type="button">
            求人情報一覧に戻る
        </button>
    </a>

</div>
@endsection

@section('js')
  <script type="text/javascript" src="{{ asset('/js/job_offer/edit.js') }}"></script>
@endsection
