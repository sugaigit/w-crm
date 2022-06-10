@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">顧客内容編集</div>
                    {{-- <form action="/customers" method="POST"> --}}
                     <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                        @method('PUT')
                        @csrf
                        <p>ID:{{ $customer->id}} <p>
                        <p>取扱会社種別：<input type="text" name="company_id" value="{{ $customer->company_id }}"></p>
                        <p>取扱事業所：<input type="text" name="handling_office" value="{{ $customer->handling_office }}"></p>
                        <p>クライアント名：<input type="text" name="client_name" value="{{ $customer->client_name }}"></p>
                        <p>クライアント名カナ：<input type="text" name="client_name_kana" value="{{ $customer->client_name_kana}}"></p>
                        <p>郵便番号：<input type="text" name="postal" value="{{$customer->postal }}"></p>
                        <p>都道府県：<input type="text" name="prefectures" value="{{ $customer->prefectures }}"></p>
                        <p>市区町村：<input type="text" name="municipalities" value="{{ $customer->municipalities}}"></p>
                        <p>町名番地：<input type="text" name="streetbunch" value="{{$customer->streetbunch }}"></p>
                        <p>電話番号：<input type="text" name="phone" value="{{ $customer->phone }}"></p>
                        <p>FAX：<input type="text" name="fax" value="{{ $customer->fax }}"></p>
                        <p>WEBサイト：<input type="text" name="website" value="{{ $customer->website }}"></p>
                        <p>業種：<input type="text" name="industry" value="{{ $customer->industry}}"></p>
                        <p>備考：<input type="text" name="remarks" value="{{$customer->remarks }}"></p>
                        <p>流入経路：<input type="text" name="inflowroute" value="{{ $customer->inflowroute }}"></p>
                        <p>Navi No：<input type="text" name="navi_no" value="{{ $customer->navi_no }}"></p>
                        <p>設立：<input type="text" name="established" value="{{ $customer->established }}"></p>
                        <p>締日：<input type="text" name="deadline" value="{{ $customer->deadline }}"></p>
                        <p>請求書必着日：<input type="text" name="invoicemustarrivedate" value="{{ $customer->invoicemustarrivedate }}"></p>
                        <p>支払日：<input type="text" name="paymentdate" value="{{ $customer->paymentdate }}"></p>
                        <p>企業ランク：<input type="text" name="company_rank" value="{{ $customer->company_rank }}"></p>
                        <p style="text-align: center"><button class="btn btn-primary" type="submit">更新する</button></p>
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

@endsection
