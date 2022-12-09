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
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>取扱会社種別<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="company_type">
                                            <option value="">取扱会社種別を選んで下さい</option>
                                            @foreach( config('company_type') as $key => $company_type )
                                            <option value="{{ $key }}">{{ $company_type }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th>仕事番号</th>
                                    <td>
                                        <input type="text" class="form-control" name="job_number" value="{{ old('job_number') }}">
                                    </td>
                                </tr> -->
                                <tr>
                                    <th>取扱事業所名<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="handling_office">
                                            <option value="">取扱事業所名を選んで下さい</option>
                                            @foreach( config('handling_office') as $key => $handling_office )
                                            <option value="{{ $key }}">{{ $handling_office }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>事業種別<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="business_type">
                                            <option value="">事業種別を選んで下さい</option>
                                            @foreach( config('business_type') as $key => $business_type )
                                            <option value="{{ $key }}">{{ $business_type }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>法人形態<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="corporate_type">
                                            <option value="">法人形態を選んで下さい</option>
                                            @foreach( config('corporate_type') as $key => $corporate_type )
                                            <option value="{{ $key }}">{{ $corporate_type }}</option>
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
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>契約形態<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="type_contract">
                                            <option value="">法人形態を選んで下さい</option>
                                            @foreach( config('type_contract') as $key => $type_contract )
                                            <option value="{{ $key }}">{{ $type_contract }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>新規/再発注<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="new_reorder">
                                            <option value="">新規/再発注を選んで下さい</option>
                                            @foreach( config('new_reorder') as $key => $new_reorder )
                                            <option value="{{ $key }}">{{ $new_reorder }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>募集人数<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="number" class="form-control" name="recruitment_number" value="{{ old('recruitment_number') }}">
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
                                    <th>屋内の受動喫煙対策の有無<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="measures_existence">
                                            <option value="">対策の有無を選んで下さい</option>
                                            @foreach( config('measures_existence') as $key => $measures_existence )
                                            <option value="{{ $key }}">{{ $measures_existence }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>屋内の受動喫煙対策の内容<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" class="form-control" name="counter_measures" value="{{ old('counter_measures') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>請求単価①<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="number" class="form-control" name="Invoice_unit_price_1" value="{{ old('Invoice_unit_price_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>請求単位①<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text"class="form-control" name="billing_unit_1" value="{{ old('billing_unit_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>利益率①<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" class="form-control" name="profit_rate_1" value="{{ old('profit_rate_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>請求情報①備考<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text"class="form-control" maxlength="100" name="billing_information_1" value="{{ old('billing_information_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>請求単価②</th>
                                    <td>
                                        <input type="text" class="form-control" name="Invoice_unit_price_2" value="{{ old('Invoice_unit_price_2') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>請求単位②</th>
                                    <td>
                                        <input type="text"class="form-control" name="billing_unit_2" value="{{ old('billing_unit_2') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>利益率②</th>
                                    <td>
                                        <input type="text" class="form-control" name="profit_rate_2" value="{{ old('profit_rate_2') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>請求情報②備考</th>
                                    <td>
                                        <input type="text"class="form-control" maxlength="100" name="billing_information_2" value="{{ old('billing_information_2') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>請求単価③</th>
                                    <td>
                                        <input type="text" class="form-control" name="Invoice_unit_price_3" value="{{ old('Invoice_unit_price_3') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>請求単位③</th>
                                    <td>
                                        <input type="text"class="form-control" name="billing_unit_3" value="{{ old('billing_unit_3') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>利益率③</th>
                                    <td>
                                        <input type="text" class="form-control" name="profit_rate_3" value="{{ old('profit_rate_3') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>請求情報③備考</th>
                                    <td>
                                        <input type="text"class="form-control" maxlength="100" name="billing_information_3" value="{{ old('billing_information_3') }}">
                                    </td>
                                </tr>
                                    <th>雇用保険加入<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text"class="form-control" maxlength="100" name="employment_insurance" value="{{ old('employment_insurance') }}">
                                    </td>
                                </tr>
                                </tr>
                                    <th>社会保険加入<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text"class="form-control" maxlength="100" name="social_insurance" value="{{ old('social_insurance') }}">
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
                                        <input type="text"class="form-control" name="payment_unit_1" value="{{ old('payment_unit_1') }}">
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
                                        <input  type="text" class="form-control" name="carfare_payment_1" value="{{ old('carfare_payment_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>支払情報①備考<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="carfare_payment_remarks_1" value="{{ old('carfare_payment_remarks_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>支払単価②</th>
                                    <td>
                                        <input  type="text" class="form-control" name="payment_unit_price_2" value="{{ old('payment_unit_price_2') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>支払単位②</th>
                                    <td>
                                        <input type="text"class="form-control" name="payment_unit_2" value="{{ old('payment_unit_2') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>交通費②</th>
                                    <td>
                                        <input  type="text" class="form-control" name="carfare_2" value="{{ old('carfare_2') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>交通費支払単位②</th>
                                    <td>
                                        <input  type="text" class="form-control" name="carfare_payment_2" value="{{ old('carfare_payment_2') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>支払情報②備考</th>
                                    <td>
                                        <input  type="text" class="form-control" name="carfare_payment_remarks_2" value="{{ old('carfare_payment_remarks_2') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>支払単価③</th>
                                    <td>
                                        <input  type="text" class="form-control" name="payment_unit_price_3" value="{{ old('payment_unit_price_3') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>支払単位③</th>
                                    <td>
                                        <input type="text"class="form-control" name="payment_unit_3" value="{{ old('payment_unit_3') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>交通費③</th>
                                    <td>
                                        <input  type="text" class="form-control" name="carfare_3" value="{{ old('carfare_3') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>交通費支払単位③</th>
                                    <td>
                                        <input  type="text" class="form-control" name="carfare_payment_3" value="{{ old('carfare_payment_3') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>支払情報③備考</th>
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
                                        <select type="text" class="form-control" name="holiday">
                                            <option value="">作成ステータスを選んで下さい</option>
                                            @foreach( config('holiday') as $key => $holiday )
                                            <option value="{{ $key }}">{{ $holiday }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>長期休暇<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="long_vacation" value="{{ old('long_vacation') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>休日備考</th>
                                    <td>
                                        <input  type="text" class="form-control" name="holiday_remarks" value="{{ old('holiday_remarks') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>勤務時間①<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="working_hours_1" value="{{ old('working_hours_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>実働時間①<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="actual_working_hours_1" value="{{ old('actual_working_hours_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>休憩時間①<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="break_time_1" value="{{ old('break_time_1') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>残業(時間/月)<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="overtime" value="{{ old('overtime') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>勤務時間備考<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="working_hours_remarks" value="{{ old('working_hours_remarks') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>勤務時間②</th>
                                    <td>
                                        <input  type="text" class="form-control" name="working_hours_2" value="{{ old('working_hours_2') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>実働時間②</th>
                                    <td>
                                        <input  type="text" class="form-control" name="actual_working_hours_2" value="{{ old('actual_working_hours_2') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>休憩時間②</th>
                                    <td>
                                        <input  type="text" class="form-control" name="break_time_2" value="{{ old('break_time_2') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>勤務時間③</th>
                                    <td>
                                        <input  type="text" class="form-control" name="working_hours_3" value="{{ old('working_hours_3') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>実働時間③</th>
                                    <td>
                                        <input  type="text" class="form-control" name="actual_working_hours_3" value="{{ old('actual_working_hours_3') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>休憩時間③</th>
                                    <td>
                                        <input  type="text" class="form-control" name="break_time_3" value="{{ old('break_time_3') }}">
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
                                    <th>車通勤（可能）<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="commuting_by_car" value="{{ old('commuting_by_car') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>交通通勤備考</th>
                                    <td>
                                        <input  type="text" class="form-control" name="traffic_commuting_remarks" value="{{ old('traffic_commuting_remarks') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>駐車場<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="text" class="form-control" name="parking" value="{{ old('parking') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>求人掲載サイト</th>
                                    <td>
                                        <select type="text" class="form-control" name="posting_site">
                                            <option value="">作成ステータスを選んで下さい</option>
                                            @foreach( config('posting_site') as $key => $posting_site )
                                            <option value="{{ $key }}">{{ $posting_site }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>作成ステータス</th>
                                    <td>
                                        <select type="text" class="form-control" name="status">
                                            <option value="">作成ステータスを選んで下さい</option>
                                            @foreach( config('status') as $key => $status )
                                            <option value="{{ $key }}">{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>発注日<span class="text-danger">*</span></th>
                                    <td>
                                        <input  type="date" class="form-control" name="order_date" value="{{ old('order_date') }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button class="btn btn-primary" type="submit">登録</button>
                        </div>

                    </form>

                    {{-- エラーを表示--}}
                    @if( $errors->any() )
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif

                </div>
            </div>

            <button class="btn btn-outline-secondary btn-lg" data-bs-toggle="button" autocomplete="off" type="submit" onClick="history.back()">
                前に戻る
            </button>

        </div>
    </div>
</div>
@endsection
