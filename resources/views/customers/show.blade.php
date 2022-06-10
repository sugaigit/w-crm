@extends('layouts.app')
@section('content')
    <div class="container">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>{{ $customer->client_name }}({{ $customer->id }})</h4>
                        <span class="ml-auto">
                            <form method="GET" action="{{ route('customers.edit',$customer, ['id' => $customer->id] ) }}">
                                <input type="submit" value="変更する" class="btn btn-info">
                            </form>
                            <form action="{{ url('customers/'.$customer->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn item-destroy">
                                  削除
                                </button>
                               </form>
                    </div>
                        </span>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-action">クライアントID：{{ $customer->id }}</li>
                        <li class="list-group-item list-group-item-action">取扱会社種別：{{ $customer->company_id }}</li>
                        <li class="list-group-item list-group-item-action">取扱事業所：{{ $customer->handling_office }}</li>
                        <li class="list-group-item list-group-item-action">クライアント名：{{ $customer->client_name }}</li>
                        <li class="list-group-item list-group-item-action">クライアントカナ：{{ $customer->client_name_kana }}</li>
                        <li class="list-group-item list-group-item-action">郵便番号：{{ $customer->postal }}</li>
                        <li class="list-group-item list-group-item-action">住所：{{ $customer->prefectures.$customer->municipalities.$customer->streetbunch }}</li>
                        <li class="list-group-item list-group-item-action">電話番号：{{ $customer->phone }}</li>
                        <li class="list-group-item list-group-item-action">FAX：{{ $customer->fax }}</li>
                        <li class="list-group-item list-group-item-action">WEBサイト：<a href="{{ $customer->website }}"target="_blank">{{ $customer->website }}</a></li>
                        <li class="list-group-item list-group-item-action">業種：{{ $customer->industry }}</li>
                        <li class="list-group-item list-group-item-action">備考：{{ $customer->remarks }}</li>
                        <li class="list-group-item list-group-item-action">流入経路：{{ $customer->inflowroute }}</li>
                        <li class="list-group-item list-group-item-action">Navi No：{{ $customer->navi_no }}</li>
                        <li class="list-group-item list-group-item-action">設立：{{ $customer->established }}</li>
                        <li class="list-group-item list-group-item-action">締日：{{ $customer->deadline }}</li>
                        <li class="list-group-item list-group-item-action">請求書必着日：{{ $customer->invoicemustarrivedate }}</li>
                        <li class="list-group-item list-group-item-action">支払い日：{{ $customer->paymentdate }}</li>
                        <li class="list-group-item list-group-item-action">企業ランク：{{ $customer->company_rank }}</li>
                        <li class="list-group-item list-group-item-action">作成日：{{ $customer->created_at }}</li>
                        <li class="list-group-item list-group-item-action">更新日：{{ $customer->updated_at }}</li>
                    </ul>
            </div>
        </div>
@endsection
