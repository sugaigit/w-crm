@extends('layouts.app')
@section('content')
@if ($differentUserAlert)
    <div class="alert alert-danger d-flex justify-content-center">
        {{ session('AlertMsg') }}
    </div>
@endif
<div class="container">
  <div class="col-md-12">
    <form action="{{ route('job_offers.update', ['job_offer' => $draftJobOffer->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <input style="pointer-events: none;" tabindex="-1" type="hidden" name="jobOfferId" value="{{ $draftJobOffer->id }}">
        <a href="{{ route('draft.edit', $draftJobOffer->id) }}">
            <button class="btn btn-primary mb-2 me-3" type="button">編集</button>
        </a>
        <a href="{{ route('draft.destroy', $draftJobOffer->id) }}">
            <button id="delete" class="delete-btn btn btn-danger mb-2" type="button">削除</button>
        </a>
        <input style="pointer-events: none;" tabindex="-1" type="hidden" name="draftJobOfferId" value="{{ $draftJobOffer->id }}">
        <div class="card mb-4">
            <div class="card-header">
                求人情報編集
            </div>

            <table class="table">
                <tbody>
                    <tr>
                        <th>営業担当<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control draft-require" name="user_id" required>
                            <option value="">営業担当を選んで下さい</option>
                            @foreach( $users as $user )
                                @if (is_null(old('user_id')))
                                <option value="{{ $user->id }}" {{ $user->id == $draftJobOffer->user->id ? 'selected' : '' }}> {{ $user->name }}</option>
                                @else
                                <option value="{{ $user->id }}" {{ $user->id == old('user_id') ? 'selected' : '' }}> {{ $user->name }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>取扱会社種別<span class="text-danger">*</span></th>
                        <td>
                        <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="handling_type" >
                            <option value="">取扱会社種別を選んで下さい</option>
                            @foreach( config('options.handling_type') as $key => $handling_type )
                                @if (is_null(old('handling_type')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->handling_type ? 'selected' : '' }}>{{ $handling_type }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('handling_type') ? 'selected' : '' }}>{{ $handling_type }}</option>
                                @endif
                            @endforeach
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <th>仕事番号</th>
                        <td>
                            @if (is_null(old('job_number')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="job_number" value="{{ isset($draftJobOffer->job_number) ? $draftJobOffer->job_number : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="job_number" value="{{ old('job_number') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>取扱事業所名<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="handling_office" >
                            <option value="">取扱事業所名を選んで下さい</option>
                            @foreach( config('options.handling_office') as $key => $handling_office )
                                @if (is_null(old('handling_office')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->handling_office ? 'selected' : '' }}>{{ $handling_office }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('handling_office') ? 'selected' : '' }}>{{ $handling_office }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>事業種別<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="business_type" >
                            <option value="">事業種別を選んで下さい</option>
                            @foreach( config('options.business_type') as $key => $business_type )
                                @if (is_null(old('business_type')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->business_type ? 'selected' : '' }}>{{ $business_type }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('business_type') ? 'selected' : '' }}>{{ $business_type }}</option>
                                @endif
                            @endforeach
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <th>顧客名<span class="text-danger">*</span></th>
                        <td>
                            <input class="form-control required" name="customer_id" list="customer_list" placeholder="顧客名を選んで下さい" style="pointer-events: none;" tabindex="-1" type="text" value={{ $customerName }}>
                            <datalist id="customer_list">
                                @foreach( $customers as $customer )
                                    @if (is_null(old('customer_id')))
                                    <option value="{{ $customer->customer_name }}" {{$customer->id == $draftJobOffer->customer_id ? 'selected' : '' }}>
                                    @else
                                    <option value="{{ $customer->customer_name }}" {{ old('customer_id') == $customer->customer_name ? 'selected' : '' }}>
                                    @endif
                                @endforeach
                            </datalist>
                        </td>
                    </tr>
                    <tr>
                        <th>契約形態<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="type_contract" >
                            <option value="">契約形態を選んで下さい</option>
                            @foreach( config('options.type_contract') as $key => $type_contract )
                                @if (is_null(old('type_contract')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->type_contract ? 'selected' : '' }}>{{ $type_contract }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('type_contract') ? 'selected' : '' }}>{{ $type_contract }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>募集人数<span class="text-danger">*</span></th>
                        <td>
                            @if (is_null(old('recruitment_number')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="recruitment_number" value="{{ $draftJobOffer->recruitment_number!=0 ? $draftJobOffer->recruitment_number : '' }}" >
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="recruitment_number" value="{{ old('recruitment_number') }}" >
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>就業先名称<span class="text-danger">*</span></th>
                        <td>
                            @if (is_null(old('company_name')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="company_name" value="{{ isset($draftJobOffer->company_name) ? $draftJobOffer->company_name : '' }}" required>
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="company_name" value="{{ old('company_name') }}" required>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>就業先住所<span class="text-danger">*</span></th>
                        <td>
                            @if (is_null(old('company_address')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="company_address" value="{{ isset($draftJobOffer->company_address) ? $draftJobOffer->company_address : '' }}" >
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="company_address" value="{{ old('company_address') }}" >
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>就業先備考</th>
                        <td>
                            @if (is_null(old('company_others')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" maxlength="100" class="form-control" name="company_others" value="{{ isset($draftJobOffer->company_others) ? $draftJobOffer->company_others : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" maxlength="100" class="form-control" name="company_others" value="{{ old('company_others') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>発注業務<span class="text-danger">*</span></th>
                        <td>
                            @if (is_null(old('ordering_business')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" maxlength="100" class="form-control required" name="ordering_business" value="{{ isset($draftJobOffer->ordering_business) ? $draftJobOffer->ordering_business : '' }}" >
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" maxlength="100" class="form-control required" name="ordering_business" value="{{ old('ordering_business') }}" >
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>発注業務詳細<span class="text-danger">*</span></th>
                        <td>
                            @if (is_null(old('order_details')))
                            <textarea style="pointer-events: none;" tabindex="-1" rows="15" class="form-control required" name="order_details" value="{{ isset($draftJobOffer->order_details) ? $draftJobOffer->order_details : '' }}" >
                            @else
                            <textarea style="pointer-events: none;" tabindex="-1" rows="15" class="form-control required" name="order_details" value="{{ old('order_details') }}" >
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>発注拠点数<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="number_of_ordering_bases">
                                <option value="">発注拠点数を選んで下さい</option>
                                @foreach( config('options.number_of_ordering_bases') as $key => $number_of_ordering_bases )
                                    @if (is_null(old('number_of_ordering_bases')))
                                    <option value="{{ $key }}"  {{ $key == $draftJobOffer->number_of_ordering_bases ? 'selected' : '' }}>{{ $number_of_ordering_bases }}</option>
                                    @else
                                    <option value="{{ $key }}"  {{ $key == old('number_of_ordering_bases') ? 'selected' : '' }}>{{ $number_of_ordering_bases }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>発注人数<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="order_number">
                                <option value="">発注人数を選んで下さい</option>
                                @foreach( config('options.order_number') as $key => $order_number )
                                    @if (is_null(old('order_number')))
                                    <option value="{{ $key }}"  {{ $key == $draftJobOffer->order_number ? 'selected' : '' }}>{{ $order_number }}</option>
                                    @else
                                    <option value="{{ $key }}"  {{ $key == old('order_number') ? 'selected' : '' }}>{{ $order_number }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>取引継続期間<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="transaction_duration">
                                <option value="">取引継続期間を選んで下さい</option>
                                @foreach( config('options.transaction_duration') as $key => $transaction_duration )
                                    @if (is_null(old('transaction_duration')))
                                    <option value="{{ $key }}"  {{ $key == $draftJobOffer->transaction_duration ? 'selected' : '' }}>{{ $transaction_duration }}</option>
                                    @else
                                    <option value="{{ $key }}"  {{ $key == old('transaction_duration') ? 'selected' : '' }}>{{ $transaction_duration }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>売上見込額<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="expected_sales">
                                <option value="">売上見込額を選んで下さい</option>
                                @foreach( config('options.expected_sales') as $key => $expected_sales )
                                    @if (is_null(old('expected_sales')))
                                    <option value="{{ $key }}"  {{ $key == $draftJobOffer->expected_sales ? 'selected' : '' }}>{{ $expected_sales }}</option>
                                    @else
                                    <option value="{{ $key }}"  {{ $key == old('expected_sales') ? 'selected' : '' }}>{{ $expected_sales }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>利益率<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="profit_rate">
                                <option value="">利益率を選んで下さい</option>
                                @foreach( config('options.profit_rate') as $key => $profit_rate )
                                    @if (is_null(old('profit_rate')))
                                    <option value="{{ $key }}"  {{ $key == $draftJobOffer->profit_rate ? 'selected' : '' }}>{{ $profit_rate }}</option>
                                    @else
                                    <option value="{{ $key }}"  {{ $key == old('profit_rate') ? 'selected' : '' }}>{{ $profit_rate }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>特別事項<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="special_matters">
                                <option value="">特別事項を選んで下さい</option>
                                @foreach( config('options.special_matters') as $key => $special_matters )
                                    @if (is_null(old('special_matters')))
                                    <option value="{{ $key }}"  {{ $key == $draftJobOffer->special_matters ? 'selected' : '' }}>{{ $special_matters }}</option>
                                    @else
                                    <option value="{{ $key }}"  {{ $key == old('special_matters') ? 'selected' : '' }}>{{ $special_matters }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>屋内の受動喫煙対策の内容<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="counter_measures" >
                                <option value="">屋内の受動喫煙対策を選んで下さい</option>
                                @foreach( config('options.counter_measures') as $key => $counter_measures )
                                    @if (is_null(old('counter_measures')))
                                    <option value="{{ $key }}" {{ $key == $draftJobOffer->counter_measures ? 'selected' : '' }}>{{ $counter_measures }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('counter_measures') ? 'selected' : '' }}>{{ $counter_measures }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>請求単価①<span class="text-danger">*</span></th>
                        <td>
                            @if (is_null(old('invoice_unit_price_1')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="invoice_unit_price_1" value="{{ isset($draftJobOffer->invoice_unit_price_1) ? $draftJobOffer->invoice_unit_price_1 : '' }}" >
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="invoice_unit_price_1" value="{{ old('invoice_unit_price_1') }}" >
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>請求単位①<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="billing_unit_1" >
                            <option value="">請求単位を選んで下さい</option>
                            @foreach( config('options.salary_term') as $key => $billing_unit_1 )
                                @if (is_null(old('billing_unit_1')))
                                <option value="{{ $key }}"  {{ $key == $draftJobOffer->billing_unit_1 ? 'selected' : '' }}>{{ $billing_unit_1 }}</option>
                                @else
                                <option value="{{ $key }}"  {{ $key == old('billing_unit_1') ? 'selected' : '' }}>{{ $billing_unit_1 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>利益率①<span class="text-danger">*</span></th>
                        <td>
                            @if (is_null(old('profit_rate_1')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="profit_rate_1" value="{{ isset($draftJobOffer->profit_rate_1) ? $draftJobOffer->profit_rate_1 : '' }}" >
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="profit_rate_1" value="{{ old('profit_rate_1') }}" >
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>請求情報①備考<br><i class="bi bi-plus-circle" id="open_billing_2"></i></th>
                        <td>
                            @if (is_null(old('billing_information_1')))
                            <input style="pointer-events: none;" tabindex="-1" type="text"class="form-control" maxlength="100" name="billing_information_1" value="{{ isset($draftJobOffer->billing_information_1) ? $draftJobOffer->billing_information_1 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text"class="form-control" maxlength="100" name="billing_information_1" value="{{ old('billing_information_1') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="billing-2">
                        <th>請求単価②</th>
                        <td>
                            @if (is_null(old('invoice_unit_price_2')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="invoice_unit_price_2" value="{{ isset($draftJobOffer->invoice_unit_price_2) ? $draftJobOffer->invoice_unit_price_2 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="invoice_unit_price_2" value="{{ old('invoice_unit_price_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="billing-2">
                        <th>請求単位②</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="billing_unit_2">
                            <option value="">請求単位を選んで下さい</option>
                            @foreach( config('options.salary_term') as $key => $billing_unit_2 )
                                @if (is_null(old('billing_unit_2')))
                                <option value="{{ $key }}"  {{ $key == $draftJobOffer->billing_unit_2 ? 'selected' : '' }}>{{ $billing_unit_2 }}</option>
                                @else
                                <option value="{{ $key }}"  {{ $key == old('billing_unit_2') ? 'selected' : '' }}>{{ $billing_unit_2 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="billing-2">
                        <th>利益率②</th>
                        <td>
                            @if (is_null(old('profit_rate_2')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="profit_rate_2" value="{{ isset($draftJobOffer->profit_rate_2) ? $draftJobOffer->profit_rate_2 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="profit_rate_2" value="{{ old('profit_rate_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="billing-2">
                        <th>
                            請求情報②備考<br>
                            <i class="bi bi-dash-circle" id="close_billing_2"></i>
                            <i class="bi bi-plus-circle" id="open_billing_3"></i>
                        </th>
                        <td>
                            @if (is_null(old('billing_information_2')))
                            <input style="pointer-events: none;" tabindex="-1" type="text"class="form-control" maxlength="100" name="billing_information_2" value="{{ isset($draftJobOffer->billing_information_2) ? $draftJobOffer->billing_information_2 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text"class="form-control" maxlength="100" name="billing_information_2" value="{{ old('billing_information_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="billing-3">
                        <th>請求単価③</th>
                        <td>
                            @if (is_null(old('invoice_unit_price_3')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="invoice_unit_price_3" value="{{ isset($draftJobOffer->invoice_unit_price_3) ? $draftJobOffer->invoice_unit_price_3 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="invoice_unit_price_3" value="{{ old('invoice_unit_price_3') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="billing-3">
                        <th>請求単位③</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="billing_unit_3">
                            <option value="">請求単位を選んで下さい</option>
                            @foreach( config('options.salary_term') as $key => $billing_unit_3 )
                                @if (is_null(old('billing_unit_3')))
                                <option value="{{ $key }}"  {{ $key == $draftJobOffer->billing_unit_3 ? 'selected' : '' }}>{{ $billing_unit_3 }}</option>
                                @else
                                <option value="{{ $key }}"  {{ $key == old('billing_unit_3') ? 'selected' : '' }}>{{ $billing_unit_3 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="billing-3">
                        <th>利益率③</th>
                        <td>
                            @if (is_null(old('profit_rate_3')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="profit_rate_3" value="{{ isset($draftJobOffer->profit_rate_3) ? $draftJobOffer->profit_rate_3 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="profit_rate_3" value="{{ old('profit_rate_3') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="billing-3">
                        <th>
                            請求情報③備考<br>
                            <i class="bi bi-dash-circle" id="close_billing_3"></i>
                        </th>
                        <td>
                            @if (is_null(old('billing_information_3')))
                            <input style="pointer-events: none;" tabindex="-1" type="text"class="form-control" maxlength="100" name="billing_information_3" value="{{ isset($draftJobOffer->billing_information_3) ? $draftJobOffer->billing_information_3 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text"class="form-control" maxlength="100" name="billing_information_3" value="{{ old('billing_information_3') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                    <th>雇用保険加入<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="employment_insurance" >
                            <option value="">雇用保険の有無を選んで下さい</option>
                            @foreach( config('options.existence') as $key => $employment_insurance )
                                @if (is_null(old('billing_information_3')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->employment_insurance ? 'selected' : '' }}>{{ $employment_insurance }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('billing_information_3') ? 'selected' : '' }}>{{ $employment_insurance }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>社会保険加入<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="social_insurance" >
                            <option value="">社会保険の有無を選んで下さい</option>
                            @foreach( config('options.existence') as $key => $social_insurance )
                                @if (is_null(old('social_insurance')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->social_insurance ? 'selected' : '' }}>{{ $social_insurance }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('social_insurance') ? 'selected' : '' }}>{{ $social_insurance }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>支払単価①<span class="text-danger">*</span></th>
                        <td>
                            @if (is_null(old('payment_unit_price_1')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="payment_unit_price_1" value="{{ isset($draftJobOffer->payment_unit_price_1) ? $draftJobOffer->payment_unit_price_1 : '' }}" >
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="payment_unit_price_1" value="{{ old('payment_unit_price_1') }}" >
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>支払単位①<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="payment_unit_1" >
                            <option value="">支払単位を選んで下さい</option>
                            @foreach( config('options.salary_term') as $key => $payment_unit_1 )
                                @if (is_null(old('payment_unit_1')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->payment_unit_1 ? 'selected' : '' }}>{{ $payment_unit_1 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('payment_unit_1') ? 'selected' : '' }}>{{ $payment_unit_1 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>交通費①</th>
                        <td>
                            @if (is_null(old('carfare_1')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_1" value="{{ isset($draftJobOffer->carfare_1) ? $draftJobOffer->carfare_1 : '' }}" >
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_1" value="{{ old('carfare_1') }}" >
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>交通費支払単位①</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="carfare_payment_1" >
                            <option value="">交通費支払単位を選んで下さい</option>
                            @foreach( config('options.payment_term') as $key => $carfare_payment_1 )
                                @if (is_null(old('carfare_payment_1')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->carfare_payment_1 ? 'selected' : '' }}>{{ $carfare_payment_1 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('carfare_payment_1') ? 'selected' : '' }}>{{ $carfare_payment_1 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>支払情報①備考<br><i class="bi bi-plus-circle" id="open_payment_2"></i></th>
                        <td>
                            @if (is_null(old('carfare_payment_remarks_1')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_payment_remarks_1" value="{{ isset($draftJobOffer->carfare_payment_remarks_1) ? $draftJobOffer->carfare_payment_remarks_1 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_payment_remarks_1" value="{{ old('carfare_payment_remarks_1') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="payment-2">
                        <th>雇用保険加入②</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="employment_insurance_2" >
                            <option value="">雇用保険の有無を選んで下さい</option>
                            @foreach( config('options.existence') as $key => $employment_insurance_2 )
                                @if (is_null(old('employment_insurance_2')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->employment_insurance_2 ? 'selected' : '' }}>{{ $employment_insurance_2 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('employment_insurance_2') ? 'selected' : '' }}>{{ $employment_insurance_2 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="payment-2">
                        <th>社会保険加入②</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="social_insurance_2" >
                            <option value="">社会保険の有無を選んで下さい</option>
                            @foreach( config('options.existence') as $key => $social_insurance_2 )
                                @if (is_null(old('social_insurance_2')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->social_insurance_2 ? 'selected' : '' }}>{{ $social_insurance_2 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('social_insurance_2') ? 'selected' : '' }}>{{ $social_insurance_2 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="payment-2">
                        <th>支払単価②</th>
                        <td>
                            @if (is_null(old('payment_unit_price_2')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="payment_unit_price_2" value="{{ isset($draftJobOffer->payment_unit_price_2) ? $draftJobOffer->payment_unit_price_2 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="payment_unit_price_2" value="{{ old('payment_unit_price_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="payment-2">
                        <th>支払単位②</th>
                        <td>
                            @if (is_null(old('payment_unit_2')))
                            <input style="pointer-events: none;" tabindex="-1" type="text"class="form-control" name="payment_unit_2" value="{{ isset($draftJobOffer->payment_unit_2) ? $draftJobOffer->payment_unit_2 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text"class="form-control" name="payment_unit_2" value="{{ old('payment_unit_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="payment-2">
                        <th>交通費②</th>
                        <td>
                            @if (is_null(old('carfare_2')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_2" value="{{ isset($draftJobOffer->carfare_2) ? $draftJobOffer->carfare_2 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_2" value="{{ old('carfare_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="payment-2">
                        <th>交通費支払単位②</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="carfare_payment_2">
                            <option value="">交通費支払単位を選んで下さい</option>
                            @foreach( config('options.payment_term') as $key => $carfare_payment_2 )
                                @if (is_null(old('carfare_payment_2')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->carfare_payment_2 ? 'selected' : '' }}>{{ $carfare_payment_2 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('carfare_payment_2') ? 'selected' : '' }}>{{ $carfare_payment_2 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="payment-2">
                        <th>
                            支払情報②備考<br>
                            <i class="bi bi-dash-circle" id="close_payment_2"></i>
                            <i class="bi bi-plus-circle" id="open_payment_3"></i>
                        </th>
                        <td>
                            @if (is_null(old('carfare_payment_remarks_2')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_payment_remarks_2" value="{{ isset($draftJobOffer->carfare_payment_remarks_2) ? $draftJobOffer->carfare_payment_remarks_2 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_payment_remarks_2" value="{{ old('carfare_payment_remarks_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="payment-3">
                        <th>雇用保険加入③</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="employment_insurance_3" >
                            <option value="">雇用保険の有無を選んで下さい</option>
                            @foreach( config('options.existence') as $key => $employment_insurance_3 )
                                @if (is_null(old('employment_insurance_3')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->employment_insurance_3 ? 'selected' : '' }}>{{ $employment_insurance_3 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('employment_insurance_3') ? 'selected' : '' }}>{{ $employment_insurance_3 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="payment-3">
                        <th>社会保険加入③</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="social_insurance_3" >
                            <option value="">社会保険の有無を選んで下さい</option>
                            @foreach( config('options.existence') as $key => $social_insurance_3 )
                                @if (is_null(old('social_insurance_3')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->social_insurance_3 ? 'selected' : '' }}>{{ $social_insurance_3 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('social_insurance_3') ? 'selected' : '' }}>{{ $social_insurance_3 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="payment-3">
                        <th>支払単価③</th>
                        <td>
                            @if (is_null(old('payment_unit_price_3')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="payment_unit_price_3" value="{{ isset($draftJobOffer->payment_unit_price_3) ? $draftJobOffer->payment_unit_price_3 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="payment_unit_price_3" value="{{ old('payment_unit_price_3') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="payment-3">
                        <th>支払単位③</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="carfare_payment_3">
                            <option value="">交通費支払単位を選んで下さい</option>
                            @foreach( config('options.payment_term') as $key => $carfare_payment_3 )
                                @if (is_null(old('carfare_payment_3')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->carfare_payment_3 ? 'selected' : '' }}>{{ $carfare_payment_3 }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('carfare_payment_3') ? 'selected' : '' }}>{{ $carfare_payment_3 }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="payment-3">
                        <th>交通費③</th>
                        <td>
                            @if (is_null(old('carfare_3')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_3" value="{{ isset($draftJobOffer->carfare_3) ? $draftJobOffer->carfare_3 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_3" value="{{ old('carfare_3') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="payment-3">
                        <th>交通費支払単位③</th>
                        <td>
                            @if (is_null(old('carfare_payment_3')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_payment_3" value="{{ isset($draftJobOffer->carfare_payment_3) ? $draftJobOffer->carfare_payment_3 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_payment_3" value="{{ old('carfare_payment_3') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="payment-3">
                        <th>
                            支払情報③備考<br>
                            <i class="bi bi-dash-circle" id="close_payment_3"></i>
                        </th>
                        <td>
                            @if (is_null(old('carfare_payment_remarks_3')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_payment_remarks_3" value="{{ isset($draftJobOffer->carfare_payment_remarks_3) ? $draftJobOffer->carfare_payment_remarks_3 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="carfare_payment_remarks_3" value="{{ old('carfare_payment_remarks_3') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>予定期間</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="scheduled_period">
                                <option value="">予定期間を選んで下さい</option>
                                @if (is_null(old('scheduled_period')))
                                    @foreach( config('options.scheduled_period') as $key => $scheduled_period )
                                        <option value="{{ $key }}" {{ $key == $draftJobOffer->scheduled_period ? 'selected' : '' }}>{{ $scheduled_period }}</option>
                                    @endforeach
                                @else
                                    @foreach( config('options.scheduled_period') as $key => $scheduled_period )
                                        <option value="{{ $key }}" {{ old('scheduled_period') == $key ? 'selected' : '' }}>{{ $scheduled_period }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>終了予定日</th>
                        <td>
                            @if (is_null(old('expected_end_date')))
                            <input style="pointer-events: none;" tabindex="-1"  type="date" class="form-control" name="expected_end_date" value="{{ isset($draftJobOffer->expected_end_date) ? $draftJobOffer->expected_end_date : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="date" class="form-control" name="expected_end_date" value="{{ old('expected_end_date') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>期間備考</th>
                        <td>
                            @if (is_null(old('period_remarks')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="period_remarks" value="{{ isset($draftJobOffer->period_remarks) ? $draftJobOffer->period_remarks : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="period_remarks" value="{{ old('period_remarks') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>休日<span class="text-danger">*</span></th>
                        <td>
                            @foreach(config('options.holiday') as $index => $holiday)
                                <div class="form-check form-check-inline">
                                    @if (is_null(old('holiday')))
                                    <input style="pointer-events: none;" tabindex="-1" class="form-check-input require" type="checkbox" id="{{ 'holidayInput' . $index }}" name="holiday[]" value="{{ $index }}" @if(is_array($draftJobOffer->holiday)) {{ in_array($index, $draftJobOffer->holiday) ? 'checked' : '' }} @endif>
                                    @else
                                    <input style="pointer-events: none;" tabindex="-1" class="form-check-input require" type="checkbox" id="{{ 'holidayInput' . $index }}" name="holiday[]" value="{{ $index }}" @if(in_array($index, old('holiday'))) checked @endif>
                                    @endif
                                    <label class="form-check-label" for="{{ 'holidayInput' . $index }}">{{ $holiday }}</label>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>長期休暇</th>
                        <td>
                            @foreach(config('options.long_vacation') as $index => $longVacation)
                                <div class="form-check form-check-inline">
                                    @if (is_null(old('long_vacation')))
                                    <input style="pointer-events: none;" tabindex="-1" class="form-check-input" type="checkbox" id="{{ 'longVacationInput' . $index }}" name="long_vacation[]" value="{{ $index }}" @if(is_array($draftJobOffer->long_vacation)) {{ in_array($index, $draftJobOffer->long_vacation) ? 'checked' : '' }} @endif>
                                    @else
                                    <input style="pointer-events: none;" tabindex="-1" class="form-check-input" type="checkbox" id="{{ 'longVacationInput' . $index }}" name="long_vacation[]" value="{{ $index }}" @if(in_array($index, old('long_vacation'))) checked @endif>
                                    @endif
                                    <label class="form-check-label" for="{{ 'longVacationInput' . $index }}">{{ $longVacation }}</label>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>休日備考</th>
                        <td>
                            @if (is_null(old('holiday_remarks')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="holiday_remarks" value="{{ isset($draftJobOffer->holiday_remarks) ? $draftJobOffer->holiday_remarks : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="holiday_remarks" value="{{ old('holiday_remarks') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>勤務時間①<span class="text-danger">*</span></th>
                        <td>
                            @if (is_null(old('working_hours_1')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="working_hours_1" value="{{ isset($draftJobOffer->working_hours_1) ? $draftJobOffer->working_hours_1 : '' }}" >
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="working_hours_1" value="{{ old('working_hours_1') }}" >
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>実働時間①<span class="text-danger">*</span></th>
                        <td>
                            @if (is_null(old('actual_working_hours_1')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="actual_working_hours_1" value="{{ isset($draftJobOffer->actual_working_hours_1) ? $draftJobOffer->actual_working_hours_1 : '' }}" >
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="actual_working_hours_1" value="{{ old('actual_working_hours_1') }}" >
                            @endif
                        </td>
                        </tr>
                    <tr>
                        <th>
                            休憩時間①<span class="text-danger">*</span>
                            <br><i class="bi bi-plus-circle" id="open_working_2"></i>
                        </th>
                        <td>
                            @if (is_null(old('break_time_1')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="break_time_1" value="{{ isset($draftJobOffer->break_time_1) ? $draftJobOffer->break_time_1 : '' }}" >
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="break_time_1" value="{{ old('break_time_1') }}" >
                            @endif
                        </td>
                    </tr>
                    <tr class="working-2">
                        <th>勤務時間②</th>
                        <td>
                            @if (is_null(old('working_hours_2')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="working_hours_2" value="{{ isset($draftJobOffer->working_hours_2) ? $draftJobOffer->working_hours_2 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="working_hours_2" value="{{ old('working_hours_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="working-2">
                        <th>実働時間②</th>
                        <td>
                            @if (is_null(old('working_hours_2')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="actual_working_hours_2" value="{{ isset($draftJobOffer->actual_working_hours_2) ? $draftJobOffer->actual_working_hours_2 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="actual_working_hours_2" value="{{ old('working_hours_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="working-2">
                        <th>
                            休憩時間②<br>
                            <i class="bi bi-dash-circle" id="close_working_2"></i>
                            <i class="bi bi-plus-circle" id="open_working_3"></i>
                        </th>
                        <td>
                            @if (is_null(old('break_time_2')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="break_time_2" value="{{ isset($draftJobOffer->break_time_2) ? $draftJobOffer->break_time_2 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="break_time_2" value="{{ old('break_time_2') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="working-3">
                        <th>勤務時間③</th>
                        <td>
                            @if (is_null(old('working_hours_3')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="working_hours_3" value="{{ isset($draftJobOffer->working_hours_3) ? $draftJobOffer->working_hours_3 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="working_hours_3" value="{{ old('working_hours_3') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="working-3">
                        <th>実働時間③</th>
                        <td>
                            @if (is_null(old('actual_working_hours_3')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="actual_working_hours_3" value="{{ isset($draftJobOffer->actual_working_hours_3) ? $draftJobOffer->actual_working_hours_3 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="actual_working_hours_3" value="{{ old('actual_working_hours_3') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="working-3">
                        <th>
                            休憩時間③<br>
                            <i class="bi bi-dash-circle" id="close_working_3"></i>
                        </th>
                        <td>
                            @if (is_null(old('break_time_3')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="break_time_3" value="{{ isset($draftJobOffer->break_time_3) ? $draftJobOffer->break_time_3 : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="break_time_3" value="{{ old('break_time_3') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>残業(時間/月)<span class="text-danger">*</span></th>
                        <td>
                            @if (is_null(old('overtime')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control required" name="overtime" value="{{ isset($draftJobOffer->overtime) ? $draftJobOffer->overtime : '' }}" >
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control required" name="overtime" value="{{ old('overtime') }}" >
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>勤務時間備考</th>
                        <td>
                            @if (is_null(old('working_hours_remarks')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="working_hours_remarks" value="{{ isset($draftJobOffer->working_hours_remarks) ? $draftJobOffer->working_hours_remarks : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="working_hours_remarks" value="{{ old('working_hours_remarks') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>最寄り駅</th>
                        <td>
                            @if (is_null(old('nearest_station')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="nearest_station" value="{{ isset($draftJobOffer->nearest_station) ? $draftJobOffer->nearest_station : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="nearest_station" value="{{ old('nearest_station') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>駅からの所要時間</th>
                        <td>
                            @if (is_null(old('travel_time_station')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="travel_time_station" value="{{ isset($draftJobOffer->travel_time_station) ? $draftJobOffer->travel_time_station : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="travel_time_station" value="{{ old('travel_time_station') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>最寄りバス停</th>
                        <td>
                            @if (is_null(old('nearest_bus_stop')))
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="nearest_bus_stop" value="{{ isset($draftJobOffer->nearest_bus_stop) ? $draftJobOffer->nearest_bus_stop : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="nearest_bus_stop" value="{{ old('nearest_bus_stop') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>バス停からの所要時間</th>
                        <td>
                            @if (is_null(old('travel_time_bus_stop')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="travel_time_bus_stop" value="{{ isset($draftJobOffer->travel_time_bus_stop) ? $draftJobOffer->travel_time_bus_stop : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="travel_time_bus_stop" value="{{ old('travel_time_bus_stop') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>車通勤（可能）<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="commuting_by_car" >
                            <option value="">車通勤の可否を選んで下さい</option>
                            @foreach( config('options.permission') as $key => $commuting_by_car )
                                @if (is_null(old('commuting_by_car')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->commuting_by_car ? 'selected' : '' }}>{{ $commuting_by_car }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('commuting_by_car') ? 'selected' : '' }}>{{ $commuting_by_car }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>交通通勤備考</th>
                        <td>
                            @if (is_null(old('traffic_commuting_remarks')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="traffic_commuting_remarks" value="{{ isset($draftJobOffer->traffic_commuting_remarks) ? $draftJobOffer->traffic_commuting_remarks : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="traffic_commuting_remarks" value="{{ old('traffic_commuting_remarks') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>駐車場<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="parking" >
                            <option value="">駐車場の有無を選んで下さい</option>
                            @foreach( config('options.parking') as $key => $parking )
                                @if (is_null(old('parking')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->parking ? 'selected' : '' }}>{{ $parking }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('parking') ? 'selected' : '' }}>{{ $parking }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>資格要件</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="qualification">
                                <option value="">資格要件を選んで下さい</option>
                                @foreach( config('options.requirement') as $key => $qualification )
                                    @if (is_null(old('qualification')))
                                    <option value="{{ $key }}" {{ $key == $draftJobOffer->qualification ? 'selected' : '' }}>{{ $qualification }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('qualification') ? 'selected' : '' }}>{{ $qualification }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>資格名</th>
                        <td>
                            @if (is_null(old('qualification_content')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="qualification_content" value="{{ isset( $draftJobOffer->qualification_content) ? $draftJobOffer->qualification_content : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="qualification_content" value="{{ old('qualification_content') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>経験要件</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="experience">
                                <option value="">経験要件を選んで下さい</option>
                                @foreach( config('options.requirement') as $key => $experience )
                                    @if (is_null(old('experience')))
                                    <option value="{{ $key }}" {{ $key == $draftJobOffer->experience ? 'selected' : '' }}>{{ $experience }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('experience') ? 'selected' : '' }}>{{ $experience }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>経験内容</th>
                        <td>
                            @if (is_null(old('experience_content')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="experience_content" value="{{ isset( $draftJobOffer->experience_content) ? $draftJobOffer->experience_content : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="experience_content" value="{{ old('experience_content') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>性別要件</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="sex">
                                <option value="">性別要件を選んで下さい</option>
                                @foreach( config('options.sex') as $key => $sex )
                                    @if (is_null(old('sex')))
                                    <option value="{{ $key }}" {{ $key == $draftJobOffer->sex ? 'selected' : '' }}>{{ $sex }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('sex') ? 'selected' : '' }}>{{ $sex }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>年齢要件</th>
                        <td>
                            @if (is_null(old('age')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="age" value="{{ isset( $draftJobOffer->age) ? $draftJobOffer->age : '' }}" placeholder="（例）20代から40代">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="age" value="{{ old('age') }}" placeholder="（例）20代から40代">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>制服支給の有無</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="uniform_supply">
                                <option value="">制服支給の有無を選んで下さい</option>
                                @foreach( config('options.uniform_supply') as $key => $uniformSupply )
                                    @if (is_null(old('uniform_supply')))
                                    <option value="{{ $key }}" {{ $key == $draftJobOffer->uniformSupply ? 'selected' : '' }}>{{ $uniformSupply }}</option>
                                    @else
                                    <option value="{{ $key }}" {{ $key == old('uniform_supply') ? 'selected' : '' }}>{{ $uniformSupply }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>支給物</th>
                        <td>
                            @if (is_null(old('supply')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="supply" value="{{ isset( $draftJobOffer->supply) ? $draftJobOffer->supply : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="supply" value="{{ old('supply') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>自身で準備するもの</th>
                        <td>
                            @if (is_null(old('self_prepared')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="self_prepared" value="{{ isset( $draftJobOffer->self_prepared) ? $draftJobOffer->self_prepared : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="self_prepared" value="{{ old('self_prepared') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>服装</th>
                        <td>
                            @if (is_null(old('clothes')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="clothes" value="{{ isset( $draftJobOffer->clothes) ? $draftJobOffer->clothes : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="clothes" value="{{ old('clothes') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>その他髪色</th>
                        <td>
                            @if (is_null(old('other_hair_colors')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="other_hair_colors" value="{{ isset( $draftJobOffer->other_hair_colors) ? $draftJobOffer->other_hair_colors : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="other_hair_colors" value="{{ old('other_hair_colors') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>職場の雰囲気・備考</th>
                        <td>
                            @if (is_null(old('remarks_workplace')))
                            <textarea type="textarea" rows="3" class="form-control" name="remarks_workplace">{{ isset( $draftJobOffer->remarks_workplace) ? $draftJobOffer->remarks_workplace : '' }}</textarea>
                            @else
                            <textarea type="textarea" rows="3" class="form-control" name="remarks_workplace">{{ old('remarks_workplace') }}</textarea>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>男女比</th>
                        <td>
                            @if (is_null(old('gender_ratio')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="gender_ratio" value="{{ isset( $draftJobOffer->gender_ratio) ? $draftJobOffer->gender_ratio : '' }}" placeholder="6対4">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="gender_ratio" value="{{ old('gender_ratio') }}" placeholder="6対4">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>年齢比率</th>
                        <td>
                            @if (is_null(old('age_ratio')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="age_ratio" value="{{ isset( $draftJobOffer->age_ratio) ? $draftJobOffer->age_ratio : '' }}" placeholder="20代 20%, 30代 50%, その他 30%">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="age_ratio" value="{{ old('age_ratio') }}" placeholder="20代 20%, 30代 50%, その他 30%">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>作成ステータス<span class="text-danger">*</span></th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control required" name="status" >
                            <option value="">作成ステータスを選んで下さい</option>
                            @foreach( config('options.status_edit') as $key => $status )
                                @if (is_null(old('status')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->status ? 'selected' : '' }}>{{ $status }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('status') ? 'selected' : '' }}>{{ $status }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>求人取り下げの理由</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="job_withdrawal">
                                <option value="">求人取り下げの理由を選んで下さい</option>
                                @foreach( config('options.job_withdrawal') as $key => $job_withdrawal )
                                    @if (is_null(old('status')))
                                        <option value="{{ $key }}" {{ $key == $draftJobOffer->job_withdrawal ? 'selected' : '' }}>{{ $job_withdrawal }}</option>
                                    @else
                                        <option value="{{ $key }}" {{ $key == old('job_withdrawal') ? 'selected' : '' }}>{{ $job_withdrawal }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>求人掲載サイト</th>
                        <td>
                            <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="posting_site">
                            <option value="">求人掲載サイトを選んで下さい</option>
                            @foreach( config('options.posting_site') as $key => $posting_site )
                                @if (is_null(old('posting_site')))
                                <option value="{{ $key }}" {{ $key == $draftJobOffer->posting_site ? 'selected' : '' }}>{{ $posting_site }}</option>
                                @else
                                <option value="{{ $key }}" {{ $key == old('posting_site') ? 'selected' : '' }}>{{ $posting_site }}</option>
                                @endif
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>起算日<span class="text-danger">*</span></th>
                        <td>
                            @if (is_null(old('order_date')))
                            <input style="pointer-events: none;" tabindex="-1"  type="date" class="form-control required" name="order_date" value="{{ isset($draftJobOffer->order_date) ? $draftJobOffer->order_date : '' }}" >
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="date" class="form-control required" name="order_date" value="{{ old('order_date') }}" >
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit">
                        <th colspan="2"><div class="text-center">人材紹介/紹介予定　採用後条件</div></th>
                    </tr>
                    <tr class="afterRecruit">
                        <th>紹介後</th>
                        <td>
                            @if (is_null(old('after_introduction')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="after_introduction" value="{{ isset($draftJobOffer->after_introduction) ? $draftJobOffer->after_introduction : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="after_introduction" value="{{ old('after_introduction') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit">
                        <th>直接雇用切替時期</th>
                        <td>
                            @if (is_null(old('timing_of_switching')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="timing_of_switching" value="{{ isset($draftJobOffer->timing_of_switching) ? $draftJobOffer->timing_of_switching : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="timing_of_switching" value="{{ old('timing_of_switching') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit">
                        <th>月収例（下限）</th>
                        <td>
                            @if (is_null(old('monthly_lower_limit')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="monthly_lower_limit" value="{{ isset($draftJobOffer->monthly_lower_limit) ? $draftJobOffer->monthly_lower_limit : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="monthly_lower_limit" value="{{ old('monthly_lower_limit') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit">
                        <th>月収例（上限）</th>
                        <td>
                            @if (is_null(old('monthly_upper_limit')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="monthly_upper_limit" value="{{ isset($draftJobOffer->monthly_upper_limit) ? $draftJobOffer->monthly_upper_limit : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="monthly_upper_limit" value="{{ old('monthly_upper_limit') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit">
                        <th>年収例（下限）</th>
                        <td>
                            @if (is_null(old('annual_lower_limit')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="annual_lower_limit" value="{{ isset($draftJobOffer->annual_lower_limit) ? $draftJobOffer->annual_lower_limit : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="annual_lower_limit" value="{{ old('annual_lower_limit') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit">
                        <th>年収例（上限）</th>
                        <td>
                            @if (is_null(old('annual_upper_limit')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="annual_upper_limit" value="{{ isset($draftJobOffer->annual_upper_limit) ? $draftJobOffer->annual_upper_limit : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="annual_upper_limit" value="{{ old('annual_upper_limit') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit">
                        <th>賞与等・待遇</th>
                        <td>
                            @if (is_null(old('bonuses_treatment')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="bonuses_treatment" value="{{ isset($draftJobOffer->bonuses_treatment) ? $draftJobOffer->bonuses_treatment : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="bonuses_treatment" value="{{ old('bonuses_treatment') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit">
                        <th>休日・休暇</th>
                        <td>
                            @if (is_null(old('holidays_vacations')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="holidays_vacations" value="{{ isset($draftJobOffer->holidays_vacations) ? $draftJobOffer->holidays_vacations : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="holidays_vacations" value="{{ old('holidays_vacations') }}">
                            @endif
                        </td>
                    </tr>
                    <tr class="afterRecruit">
                        <th>その他</th>
                        <td>
                            @if (is_null(old('introduction_others')))
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="introduction_others" value="{{ isset($draftJobOffer->introduction_others) ? $draftJobOffer->introduction_others : '' }}">
                            @else
                            <input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="introduction_others" value="{{ old('introduction_others') }}">
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            @if(!$isDraftJobOffer)
            <div class="card-header">活動記録 登録</div>
            <table class="table">
                <tbody>
                <tr>
                    <th>日付</th>
                    <td><input style="pointer-events: none;" tabindex="-1"  type="date" class="form-control" name="date" value="{{ today()->format('Y-m-d') }}"></td>
                </tr>
                <tr>
                    <th>項目</th>
                    <td>
                    <select style="pointer-events: none;" tabindex="-1" type="text" class="form-control" name="item">
                        <option value="">項目を選んで下さい</option>
                        @foreach( config('options.item') as $key => $item )
                        <option value="{{ $key }}">{{ $item }}</option>
                        @endforeach
                    </select>
                    </td>
                </tr>
                <tr>
                    <th>詳細</th>
                    <td><input style="pointer-events: none;" tabindex="-1"  type="text" class="form-control" name="detail"></td>
                </tr>
                <input style="pointer-events: none;" tabindex="-1"  type="hidden" name="job_offer_id" value="{{ $draftJobOffer->id }}">
                </tbody>
            </table>
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
          </tr>
          @if(isset($activityRecords))
          @foreach($activityRecords as $activityRecord)
          <tr>
              <td>{{ $activityRecord->date }}</td>
              <td>{{ config('options.item')[$activityRecord->item] }}</td>
              <td>{{ $activityRecord->detail }}</td>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>
    </div>
    @endif

    <a href="{{ route('draft.index') }}">
        <button class="btn btn-outline-secondary btn-lg"type="button">
            求人情報下書き一覧に戻る
        </button>
    </a>

</div>
@endsection

@section('js')
  <script type="text/javascript" src="{{ asset('/js/job_offer/edit.js') }}"></script>
@endsection
