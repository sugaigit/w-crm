@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="d-flex">  
            <a href="{{ route('customers.edit', $customer->id) }}">
                <button class="btn btn-primary mb-2" type="button">編集</button>
            </a>
            <form method="POST" action="{{ route('customers.hidden', $customer->id) }}">
                @csrf
                <button class="btn mx-3 {{ $customer->is_show == true ? 'btn-danger' : 'btn-success'}}" type="submit">
                    {{ $customer->is_show == true ? '非表示にする' : '表示にする'}}
                </button>
                <input type="hidden" name="hidden_flag" value={{ $customer->is_show == true ? '1' : '0'}}>
            </form>
        </div>
        <div class="card">
            <div class="card-header">顧客内容詳細</div>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{ $customer->id}}</td>
                        </tr>
                        <tr>
                            <th>作成者<span class="text-danger">*</span></th>
                            <td>
                                <select disabled type="text" class="form-control required" name="user_id" required>
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
                                <select disabled type="text" class="form-control required" name="handling_type" required>
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
                                <select disabled type="text" class="form-control required" name="handling_office" required>
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
                                <select disabled type="text" class="form-control required" name="corporate_type" required>
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
                                <input disabled type="text" class="form-control required" name="customer_name" value="{{ isset($customer->customer_name) ? $customer->customer_name : '' }}" required>
                            </td>
                        </tr>
                        <tr>
                            <th>顧客名（カナ）</th>
                            <td>
                                <input disabled type="text" class="form-control" name="customer_kana" value="{{ isset($customer->customer_kana) ? $customer->customer_kana : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>業種<span class="text-danger">*</span></th>
                            <td>
                                <select disabled type="text" class="form-control required" name="industry" required>
                                    <option value="">業種を選んで下さい</option>
                                    @foreach( config('options.industry') as $key => $industry )
                                    <option value="{{ $key }}" {{ $key == $customer->industry ? 'selected' : '' }}>{{ $industry }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>会社規模<span class="text-danger">*</span></th>
                            <td>
                                <select disabled type="text" class="form-control required" name="company_size" required>
                                    <option value="">会社規模を選んで下さい</option>
                                    @foreach( config('options.company_size') as $key => $company_size )
                                    <option value="{{ $key }}" {{ $key == $customer->company_size ? 'selected' : '' }}>{{ $company_size }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>事業展開地域<span class="text-danger">*</span></th>
                            <td>
                                <select disabled type="text" class="form-control required" name="business_development_area" required>
                                    <option value="">事業展開地域を選んで下さい</option>
                                    @foreach( config('options.business_development_area') as $key => $business_development_area )
                                    <option value="{{ $key }}" {{ $key == $customer->business_development_area ? 'selected' : '' }}>{{ $business_development_area }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>取引拡大可能性<span class="text-danger">*</span></th>
                            <td>
                                <select disabled type="text" class="form-control required" name="business_expansion_potential" required>
                                    <option value="">取引拡大可能性を選んで下さい</option>
                                    @foreach( config('options.business_expansion_potential') as $key => $business_expansion_potential )
                                    <option value="{{ $key }}" {{ $key == $customer->business_expansion_potential ? 'selected' : '' }}>{{ $business_expansion_potential }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>社歴<span class="text-danger">*</span></th>
                            <td>
                                <select disabled type="text" class="form-control required" name="company_history" required>
                                    <option value="">社歴を選んで下さい</option>
                                    @foreach( config('options.company_history') as $key => $company_history )
                                    <option value="{{ $key }}" {{ $key == $customer->company_history ? 'selected' : '' }}>{{ $company_history }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>信頼性<span class="text-danger">*</span></th>
                            <td>
                                <select disabled type="text" class="form-control required" name="reliability" required>
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
                                <input disabled type="text" class="form-control" name="branch" value="{{ isset($customer->branch) ? $customer->branch : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>所属部署</th>
                            <td>
                                <input disabled type="text" class="form-control" name="department" value="{{ isset($customer->department) ? $customer->department : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>顧客担当者名</th>
                            <td>
                                <input disabled type="text" class="form-control" name="manager_name" value="{{ isset($customer->manager_name) ? $customer->manager_name : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>顧客住所</th>
                            <td>
                                <input disabled type="text" class="form-control" name="address" value="{{ isset($customer->address) ? $customer->address : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>電話番号</th>
                            <td>
                                <input disabled type="text" class="form-control" name="phone" value="{{ isset($customer->phone) ? $customer->phone : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td>
                                <input disabled type="text" class="form-control" name="email" value="{{ isset($customer->email) ? $customer->email : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>FAX</th>
                            <td>
                                <input disabled type="text" class="form-control" name="fax" value="{{ isset($customer->fax) ? $customer->fax : '' }}">
                            </td>
                        </tr>
                        @for($i = 2; $i < 6; $i++)
                            @php
                                $branch = "branch_{$i}";
                                $department = "department_{$i}";
                                $manager_name = "manager_name_{$i}";
                                $address = "address_{$i}";
                                $phone = "phone_{$i}";
                                $email = "email_{$i}";
                                $fax = "fax_{$i}";
                            @endphp
                            @if(isset($customer->$branch))
                            <tr>
                                <th>支店-{{$i}}</th>
                                <td>
                                    <input disabled type="text" class="form-control" name="branch" value="{{ isset($customer->$branch) ? $customer->$branch : '' }}">
                                </td>
                            </tr>
                            @endif
                            @if(isset($customer->$department))
                            <tr>
                                <th>所属部署-{{$i}}</th>
                                <td>
                                    <input disabled type="text" class="form-control" name="department" value="{{ isset($customer->$department) ? $customer->$department : '' }}">
                                </td>
                            </tr>
                            @endif
                            @if(isset($customer->$manager_name))
                            <tr>
                                <th>顧客担当者名-{{$i}}</th>
                                <td>
                                    <input disabled type="text" class="form-control" name="manager_name" value="{{ isset($customer->$manager_name) ? $customer->$manager_name : '' }}">
                                </td>
                            </tr>
                            @endif
                            @if(isset($customer->$address))
                            <tr>
                                <th>顧客住所-{{$i}}</th>
                                <td>
                                    <input disabled type="text" class="form-control" name="address" value="{{ isset($customer->$address) ? $customer->$address : '' }}">
                                </td>
                            </tr>
                            @endif
                            @if(isset($customer->$phone))
                            <tr>
                                <th>電話番号-{{$i}}</th>
                                <td>
                                    <input disabled type="text" class="form-control" name="phone" value="{{ isset($customer->$phone) ? $customer->$phone : '' }}">
                                </td>
                            </tr>
                            @endif
                            @if(isset($customer->$email))
                            <tr>
                                <th>メールアドレス-{{$i}}</th>
                                <td>
                                    <input disabled type="text" class="form-control" name="email" value="{{ isset($customer->$email) ? $customer->$email : '' }}">
                                </td>
                            </tr>
                            @endif
                            @if(isset($customer->$fax))
                            <tr>
                                <th>FAX-{{$i}}</th>
                                <td>
                                    <input disabled type="text" class="form-control" name="fax" value="{{ isset($customer->$fax) ? $customer->$fax : '' }}">
                                </td>
                            </tr>
                            @endif
                        @endfor
                    </tbody>
                </table>

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