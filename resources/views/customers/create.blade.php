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
                <ul class="list-group">
                    <li class="list-group-item list-group-item-action">
                        作成者<span class="text-danger">*</span>
                        <select type="text" class="form-control required" name="user_id" required>
                            <option value="">作成者を選んで下さい</option>
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
                        <select type="text" class="form-control" name="industry" required>
                            <option value="">業種を選んで下さい</option>
                            @foreach( config('options.industry') as $key => $val )
                                <option value="{{ $key }}" {{ old('industry') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        会社規模
                        <select type="text" class="form-control" name="company_size">
                            <option value="">会社規模を選んで下さい</option>
                            @foreach( config('options.company_size') as $key => $val )
                                <option value="{{ $key }}" {{ old('company_size') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        事業展開地域
                        <select type="text" class="form-control" name="business_development_area" >
                            <option value="">事業展開地域を選んで下さい</option>
                            @foreach( config('options.business_development_area') as $key => $val )
                                <option value="{{ $key }}" {{ old('business_development_area') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        取引拡大可能性
                        <select type="text" class="form-control" name="business_expansion_potential">
                            <option value="">取引拡大可能性を選んで下さい</option>
                            @foreach( config('options.business_expansion_potential') as $key => $val )
                                <option value="{{ $key }}" {{ old('business_expansion_potential') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        社歴
                        <select type="text" class="form-control" name="company_history">
                            <option value="">社歴を選んで下さい</option>
                            @foreach( config('options.company_history') as $key => $val )
                                <option value="{{ $key }}" {{ old('company_history') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        信頼性
                        <select type="text" class="form-control" name="reliability">
                            <option value="">信頼性を選んで下さい</option>
                            @foreach( config('options.reliability') as $key => $val )
                                <option value="{{ $key }}" {{ old('reliability') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        支店
                        <input class="form-control" type="text" name="branch" value="{{ old('branch') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        所属部署
                        <input class="form-control" type="text" name="department" value="{{ old('department') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        顧客担当者名
                        <input class="form-control" type="text" name="manager_name" value="{{ old('manager_name') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        住所<span class="text-danger"></span>
                        <input class="form-control" type="text" name="address" value="{{ old('address') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        電話番号<span class="text-danger"></span>
                        <input class="form-control" type="text" name="phone" value="{{ old('phone') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        メールアドレス
                        <input class="form-control" type="text" name="email" value="{{ old('email') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        FAX
                        <input class="form-control" type="text" name="fax" value="{{ old('fax') }}">
                    </li>
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
