@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12">
        <form action="{{ route('customers.import_csv') }}" method="POST" enctype='multipart/form-data'>
            @csrf
            <div class="mb-2">
                <label for="csv_import">CSVインポート</label><br>
                <input type="file" id="csv_import" name="csv_import">
                <button id="csv_submit" type="submit" class="btn btn-primary">選択したCSVを反映する</button>
            </div>
        </form>
        @if (session('AlertMsg'))
            <div class="alert alert-danger d-flex justify-content-center">
                {{ session('AlertMsg') }}
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-header">顧客新規登録</div>
            {{-- todo: スタイルを整える --}}
            {{-- todo: バリデーションメッセージの日本語化 --}}
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <ul class="list-group" id="customerInput">
                    <li class="list-group-item list-group-item-action">
                        営業担当<span class="text-danger">*</span>
                        <select type="text" class="form-control required" name="user_id" required>
                            <option value="">営業担当を選んで下さい</option>
                            @foreach( $users as $user )
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        取扱会社種別<span class="text-danger">*</span>
                        <select type="text" class="form-control required" name="handling_type" required>
                            <option value="">取扱会社種別を選んで下さい</option>
                            @foreach( config('options.handling_type') as $key => $val )
                                <option value="{{ $key }}" {{ old('handling_type') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        取扱事業所<span class="text-danger">*</span>
                        <select type="text" class="form-control required" name="handling_office" required>
                            <option value="">取扱事業所を選んで下さい</option>
                            @foreach( config('options.handling_office') as $key => $val )
                                <option value="{{ $key }}" {{ old('handling_office') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        法人形態<span class="text-danger">*</span>
                        <select type="text" class="form-control required" name="corporate_type" required>
                            <option value="">法人形態を選んで下さい</option>
                            @foreach( config('options.corporate_type') as $key => $val )
                                <option value="{{ $key }}" {{ old('corporate_type') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        顧客名<span class="text-danger">*</span>
                        <input class="form-control required" type="text" name="customer_name" value="{{ old('customer_name') }}" required>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        顧客名（全角カナ）
                        <input class="form-control" type="text" name="customer_kana" value="{{ old('customer_kana') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        業種<span class="text-danger">*</span>
                        <select type="text" class="form-control required" name="industry" required>
                            <option value="">業種を選んで下さい</option>
                            @foreach( config('options.industry') as $key => $val )
                                <option value="{{ $key }}" {{ old('industry') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        会社規模<span class="text-danger">*</span>
                        <select type="text" class="form-control required" name="company_size" required>
                            <option value="">会社規模を選んで下さい</option>
                            @foreach( config('options.company_size') as $key => $val )
                                <option value="{{ $key }}" {{ old('company_size') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        事業展開地域<span class="text-danger">*</span>
                        <select type="text" class="form-control required" name="business_development_area" required>
                            <option value="">事業展開地域を選んで下さい</option>
                            @foreach( config('options.business_development_area') as $key => $val )
                                <option value="{{ $key }}" {{ old('business_development_area') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        取引拡大可能性<span class="text-danger">*</span>
                        <select type="text" class="form-control required" name="business_expansion_potential" required>
                            <option value="">取引拡大可能性を選んで下さい</option>
                            @foreach( config('options.business_expansion_potential') as $key => $val )
                                <option value="{{ $key }}" {{ old('business_expansion_potential') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        社歴<span class="text-danger">*</span>
                        <select type="text" class="form-control required" name="company_history" required>
                            <option value="">社歴を選んで下さい</option>
                            @foreach( config('options.company_history') as $key => $val )
                                <option value="{{ $key }}" {{ old('company_history') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        信頼性<span class="text-danger">*</span>
                        <select type="text" class="form-control required" name="reliability" required>
                            <option value="">信頼性を選んで下さい</option>
                            @foreach( config('options.reliability') as $key => $val )
                                <option value="{{ $key }}" {{ old('reliability') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        支店-1
                        <input class="form-control" type="text" name="branch" value="{{ old('branch') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        所属部署-1
                        <input class="form-control" type="text" name="department" value="{{ old('department') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        顧客担当者名-1
                        <input class="form-control" type="text" name="manager_name" value="{{ old('manager_name') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        住所-1<span class="text-danger"></span>
                        <input class="form-control" type="text" name="address" value="{{ old('address') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        電話番号-1<span class="text-danger"></span>
                        <input class="form-control" type="text" name="phone" value="{{ old('phone') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        メールアドレス-1
                        <input class="form-control" type="text" name="email" value="{{ old('email') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        FAX-1
                        <input class="form-control" type="text" name="fax" value="{{ old('fax') }}">
                        <i class="bi bi-plus-circle" id="open_branch_info_2"></i>
                    </li>
                    @for($i = 2; $i < 6; $i++)
                        <li class="list-group-item list-group-item-action branch-{{$i}} branch-info-{{$i}}">
                            支店-{{ $i }}
                            <input class="form-control" type="text" name="branch_{{$i}}" value="{{ old("branch_{$i}") }}">
                        </li>
                        <li class="list-group-item list-group-item-action department-{{$i}} branch-info-{{$i}}">
                            所属部署-{{ $i }}
                            <input class="form-control" type="text" name="department_{{$i}}" value="{{ old("department_{$i}") }}">
                        </li>
                        <li class="list-group-item list-group-item-action manager_name-{{$i}} branch-info-{{$i}}">
                            顧客担当者名-{{ $i }}
                            <input class="form-control" type="text" name="manager_name_{{$i}}" value="{{ old("manager_name_{$i}") }}">
                        </li>
                        <li class="list-group-item list-group-item-action address-{{$i}} branch-info-{{$i}}">
                            住所-{{ $i }}<span class="text-danger"></span>
                            <input class="form-control" type="text" name="address_{{$i}}" value="{{ old("address_{$i}") }}">
                        </li>
                        <li class="list-group-item list-group-item-action phone-{{$i}} branch-info-{{$i}}">
                            電話番号-{{ $i }}<span class="text-danger"></span>
                            <input class="form-control" type="text" name="phone_{{$i}}" value="{{ old("phone_{$i}") }}">
                        </li>
                        <li class="list-group-item list-group-item-action email-{{$i}} branch-info-{{$i}}">
                            メールアドレス-{{ $i }}
                            <input class="form-control" type="text" name="email_{{$i}}" value="{{ old("email_{$i}") }}">
                        </li>
                        <li class="list-group-item list-group-item-action fax-{{$i}} branch-info-{{$i}}">
                            FAX-{{ $i }}
                            <input class="form-control" type="text" name="fax_{{$i}}" value="{{ old("fax_{$i}") }}">
                            @if($i != 5)<i class="bi bi-plus-circle" id="open_branch_info_{{ $i+1 }}"></i>@endif
                            <i class="bi bi-dash-circle" id="close_branch_info_{{ $i }}"></i>
                        </li>
                    @endfor
                </ul>

                <div class="d-flex justify-content-center mt-4 mb-3">
                    <button class="btn btn-primary" type="submit">登録</button>
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
</div>

@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('/js/customer/create.js') }}"></script>
@endsection
