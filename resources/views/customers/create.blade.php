@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">顧客新規登録</div>
            {{-- todo: スタイルを整える --}}
            {{-- todo: バリデーションメッセージの日本語化 --}}
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <ul class="list-group">
                    {{-- <li class="list-group-item list-group-item-action">
                        営業担当<span class="text-danger">*</span>
                        <select type="text" class="form-control" name="user_id">
                            <option value="">営業担当を選んで下さい</option>
                            @foreach( $users as $user )
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </li> --}}
                    <li class="list-group-item list-group-item-action">
                        取扱会社種別<span class="text-danger">*</span>
                        <select type="text" class="form-control" name="handling_type">
                            <option value="">取扱会社種別を選んで下さい</option>
                            @foreach( config('options.handling_type') as $key => $val )
                                <option value="{{ $key }}" {{ old('handling_type') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        取扱事業所<span class="text-danger">*</span>
                        <select type="text" class="form-control" name="handling_office">
                            <option value="">取扱事業所を選んで下さい</option>
                            @foreach( config('options.handling_office') as $key => $val )
                                <option value="{{ $key }}" {{ old('handling_office') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        法人形態<span class="text-danger">*</span>
                        <select type="text" class="form-control" name="corporate_type">
                            <option value="">法人形態を選んで下さい</option>
                            @foreach( config('options.corporate_type') as $key => $val )
                                <option value="{{ $key }}" {{ old('corporate_type') == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        顧客名<span class="text-danger">*</span>
                        <input class="form-control" type="text" name="customer_name" value="{{ old('customer_name') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        顧客名（カナ）
                        <input class="form-control" type="text" name="customer_kana" value="{{ old('customer_kana') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        住所<span class="text-danger">*</span>
                        <input class="form-control" type="text" name="address" value="{{ old('address') }}">
                    </li>
                    <li class="list-group-item list-group-item-action">
                        電話番号<span class="text-danger">*</span>
                        <input class="form-control" type="text" name="phone" value="{{ old('phone') }}">
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
