@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">顧客内容編集</div>
                <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                @method('PUT')
                @csrf
                <table class="table">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{ $customer->id}}</td>
                        </tr>
                        <tr>
                            <th>作成者<span class="text-danger">*</span></th>
                            <td>
                                <select type="text" class="form-control required" name="user_id" required>
                                    <option value="">営業担当を選んで下さい</option>
                                    @foreach( $users as $user )
                                        <option value="{{ $user->id }}" {{ $user->id == $customer->user->id ? 'selected' : '' }}> {{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>取扱会社種別<span class="text-danger">*</span></th>
                            <td>
                                <select type="text" class="form-control required" name="handling_type" required>
                                    <option value="">取扱会社種別を選んで下さい</option>
                                    @foreach( config('options.handling_type') as $key => $handling_type )
                                    <option value="{{ $key }}" {{ $key == $customer->handling_type ? 'selected' : '' }}>{{ $handling_type }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>取扱事業所名<span class="text-danger">*</span></th>
                            <td>
                                <select type="text" class="form-control required" name="handling_office" required>
                                    <option value="">取扱事業所名を選んで下さい</option>
                                    @foreach( config('options.handling_office') as $key => $handling_office )
                                    <option value="{{ $key }}" {{ $key == $customer->handling_office ? 'selected' : '' }}>{{ $handling_office }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>法人形態<span class="text-danger">*</span></th>
                            <td>
                                <select type="text" class="form-control required" name="corporate_type" required>
                                    <option value="">法人形態を選んで下さい</option>
                                    @foreach( config('options.corporate_type') as $key => $corporate_type )
                                    <option value="{{ $key }}" {{ $key == $customer->corporate_type ? 'selected' : '' }}>{{ $corporate_type }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>顧客名<span class="text-danger">*</span></th>
                            <td>
                                <input type="text" class="form-control required" name="customer_name" value="{{ isset($customer->customer_name) ? $customer->customer_name : '' }}" required>
                            </td>
                        </tr>
                        <tr>
                            <th>顧客名（カナ）</th>
                            <td>
                                <input type="text" class="form-control" name="customer_kana" value="{{ isset($customer->customer_kana) ? $customer->customer_kana : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>業種<span class="text-danger">*</span></th>
                            <td>
                                <select type="text" class="form-control required" name="industry" required>
                                    <option value="">業種を選んで下さい</option>
                                    @foreach( config('options.industry') as $key => $industry )
                                    <option value="{{ $key }}" {{ $key == $customer->industry ? 'selected' : '' }}>{{ $industry }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>会社規模</th>
                            <td>
                                <select type="text" class="form-control " name="company_size" >
                                    <option value="">会社規模を選んで下さい</option>
                                    @foreach( config('options.company_size') as $key => $company_size )
                                    <option value="{{ $key }}" {{ $key == $customer->company_size ? 'selected' : '' }}>{{ $company_size }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>事業展開地域</th>
                            <td>
                                <select type="text" class="form-control " name="business_development_area" >
                                    <option value="">事業展開地域を選んで下さい</option>
                                    @foreach( config('options.business_development_area') as $key => $business_development_area )
                                    <option value="{{ $key }}" {{ $key == $customer->business_development_area ? 'selected' : '' }}>{{ $business_development_area }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>取引拡大可能性</th>
                            <td>
                                <select type="text" class="form-control" name="business_expansion_potential" >
                                    <option value="">取引拡大可能性を選んで下さい</option>
                                    @foreach( config('options.business_expansion_potential') as $key => $business_expansion_potential )
                                    <option value="{{ $key }}" {{ $key == $customer->business_expansion_potential ? 'selected' : '' }}>{{ $business_expansion_potential }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>社歴</th>
                            <td>
                                <select type="text" class="form-control" name="company_history" >
                                    <option value="">社歴を選んで下さい</option>
                                    @foreach( config('options.company_history') as $key => $company_history )
                                    <option value="{{ $key }}" {{ $key == $customer->company_history ? 'selected' : '' }}>{{ $company_history }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>信頼性</th>
                            <td>
                                <select type="text" class="form-control" name="reliability" >
                                    <option value="">信頼性を選んで下さい</option>
                                    @foreach( config('options.reliability') as $key => $reliability )
                                    <option value="{{ $key }}" {{ $key == $customer->reliability ? 'selected' : '' }}>{{ $reliability }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>支店</th>
                            <td>
                                <input type="text" class="form-control" name="branch" value="{{ isset($customer->branch) ? $customer->branch : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>所属部署</th>
                            <td>
                                <input type="text" class="form-control" name="department" value="{{ isset($customer->department) ? $customer->department : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>顧客担当者名</th>
                            <td>
                                <input type="text" class="form-control" name="manager_name" value="{{ isset($customer->manager_name) ? $customer->manager_name : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>顧客住所</th>
                            <td>
                                <input type="text" class="form-control" name="address" value="{{ isset($customer->address) ? $customer->address : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>電話番号</th>
                            <td>
                                <input type="text" class="form-control" name="phone" value="{{ isset($customer->phone) ? $customer->phone : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td>
                                <input type="text" class="form-control" name="email" value="{{ isset($customer->email) ? $customer->email : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>FAX</th>
                            <td>
                                <input type="text" class="form-control" name="fax" value="{{ isset($customer->fax) ? $customer->fax : '' }}">
                            </td>
                        </tr>
                        @for($i = 2; $i < 6; $i++)
                            <tr class="branch-{{$i}} branch-info-{{$i}}">
                                <th>支店-{{ $i }}</th>
                                <td>
                                    @php $branch = "branch_{$i}" @endphp
                                    <input type="text" class="form-control" name="{{ $branch }}" value="{{ isset($customer->$branch) ? $customer->$branch : '' }}">
                                </td>
                            </tr>
                            <tr class="department-{{$i}} branch-info-{{$i}}">
                                <th>所属部署-{{ $i }}</th>
                                <td>
                                    @php $department = "department_{$i}" @endphp
                                    <input type="text" class="form-control" name="{{ $department }}" value="{{ isset($customer->$department) ? $customer->$department : '' }}">
                                </td>
                            </tr>
                            <tr class="manager_name-{{$i}} branch-info-{{$i}}">
                                <th>顧客担当者名-{{ $i }}</th>
                                <td>
                                    @php $manager_name = "manager_name_{$i}" @endphp
                                    <input type="text" class="form-control" name="{{ $manager_name }}" value="{{ isset($customer->$manager_name) ? $customer->$manager_name : '' }}">
                                </td>
                            </tr>
                            <tr class="address-{{$i}} branch-info-{{$i}}">
                                <th>住所-{{ $i }}</th>
                                <td>
                                    @php $address = "address_{$i}" @endphp
                                    <input type="text" class="form-control" name="{{ $address }}" value="{{ isset($customer->$address) ? $customer->$address : '' }}">
                                </td>
                            </tr>
                            <tr class="phone-{{$i}} branch-info-{{$i}}">
                                <th>電話番号-{{ $i }}</th>
                                <td>
                                    @php $phone = "phone_{$i}" @endphp
                                    <input type="text" class="form-control" name="{{ $phone }}" value="{{ isset($customer->$phone) ? $customer->$phone : '' }}">
                                </td>
                            </tr>
                            <tr class="email-{{$i}} branch-info-{{$i}}">
                                <th>メールアドレス-{{ $i }}</th>
                                <td>
                                    @php $email = "email_{$i}" @endphp
                                    <input type="text" class="form-control" name="{{ $email }}" value="{{ isset($customer->$email) ? $customer->$email : '' }}">
                                </td>
                            </tr>
                            <tr class="fax-{{$i}} branch-info-{{$i}}">
                                <th>FAX-{{ $i }}</th>
                                <td>
                                    @php $fax = "fax_{$i}" @endphp
                                    <input type="text" class="form-control" name="{{ $fax }}" value="{{ isset($customer->$fax) ? $customer->$fax : '' }}">
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4 mb-3">
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>

            </form>

            @if( $errors->any() )
                <ul>
                    @foreach($errors->all() as $error)
                        <li class="text-danger">{{$error}}</li>
                    @endforeach
                </ul>
            @endif

        </div>
    </div>
</div>

@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('/js/customer/edit.js') }}"></script>
@endsection
