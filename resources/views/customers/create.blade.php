@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                    <div class="card-header">顧客新規登録</div>
                    <form action="{{ route('customers.store') }}" method="POST">
                        <ul class="list-group">
                        @csrf
                        <li class="list-group-item list-group-item-action">
                        取扱会社種別：
                        <select type="text" class="form-control" name="company_id">
                            @foreach(config('pref') as $key => $score)
                            <option value="{{ $score }}">{{ $score }}</option>
                            @endforeach
                        </select>
                        </li>
                        <li class="list-group-item list-group-item-action">
                        取扱事業所：
                        <select type="text" class="form-control" name="handling_office">
                            @foreach(config('handling_office') as $key => $score)
                            <option value="{{ $score }}">{{ $score }}</option>
                            @endforeach
                        </select>
                        </li>
                       <li class="list-group-item list-group-item-action">クライアント名：<input type="text" name="client_name" value="{{ old('client_name') }}"></li>
                        <li class="list-group-item list-group-item-action">クライアント名カナ：<input type="text" name="client_name_kana" value="{{ old('client_name_kana') }}"></li>
                        <li class="list-group-item list-group-item-action">郵便番号：<input type="text" name="postal" value="{{ old('postal') }}"></li>
                        <li class="list-group-item list-group-item-action">都道府県：<input type="text" name="prefectures" value="{{ old('prefectures') }}"></li>
                        <li class="list-group-item list-group-item-action">市区町村：<input type="text" name="municipalities" value="{{ old('municipalities') }}"></li>
                        <li class="list-group-item list-group-item-action">町名番地：<input type="text" name="streetbunch" value="{{ old('streetbunch') }}"></li>
                        <li class="list-group-item list-group-item-action">電話番号：<input type="text" name="phone" value="{{ old('phone') }}"></li>
                        <li class="list-group-item list-group-item-action">FAX：<input type="text" name="fax" value="{{ old('fax') }}"></li>
                        <li class="list-group-item list-group-item-action">WEBサイト：<input type="text" name="website" value="{{ old('website') }}"></li>
                        <li class="list-group-item list-group-item-action">業種：<input type="text" name="industry" value="{{ old('industry') }}"></li>
                        <li class="list-group-item list-group-item-action">備考：<input type="text" name="remarks" value="{{ old('remarks') }}"></li>
                        <li class="list-group-item list-group-item-action">流入経路：<input type="text" name="inflowroute" value="{{ old('inflowroute') }}"></li>
                        <li class="list-group-item list-group-item-action">Navi No：<input type="text" name="navi_no" value="{{ old('navi_no') }}"></li>
                        <li class="list-group-item list-group-item-action">設立：<input type="text" name="established" value="{{ old('established') }}"></li>
                        <li class="list-group-item list-group-item-action">締日：<input type="text" name="deadline" value="{{ old('deadline') }}"></li>
                        <li class="list-group-item list-group-item-action">請求書必着日：<input type="text" name="invoicemustarrivedate" value="{{ old('invoicemustarrivedate') }}"></li>
                        <li class="list-group-item list-group-item-action">支払日：<input type="text" name="paymentdate" value="{{ old('paymentdate') }}"></li>
                        <li class="list-group-item list-group-item-action">企業ランク：<input type="text" name="company_rank" value="{{ old('company_rank') }}"></li>
                        <p style="text-align: center"><button class="btn btn-primary" type="submit">　　登　録　　</button></p>
                    </ul>
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
        </div>
    </div>
    <button class="btn btn-outline-secondary btn-lg" data-bs-toggle="button" autocomplete="off" type="submit" onClick="history.back()">前に戻る</button>

@endsection
