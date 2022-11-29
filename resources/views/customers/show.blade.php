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
                        <li class="list-group-item list-group-item-action">営業担当者：{{ $users->name }}</li>
                        <li class="list-group-item list-group-item-action">取扱会社種別：{{ $customer->company_type }}</li>
                        <li class="list-group-item list-group-item-action">取扱事業所：{{ $customer->handling_office }}</li>
                        <li class="list-group-item list-group-item-action">クライアント名：{{ $customer->name }}</li>
                        <li class="list-group-item list-group-item-action">クライアントカナ：{{ $customer->kana }}</li>
                        <li class="list-group-item list-group-item-action">住所：{{ $customer->address}}</li>
                        <li class="list-group-item list-group-item-action">電話番号：{{ $customer->phone }}</li>
                        <li class="list-group-item list-group-item-action">FAX：{{ $customer->fax }}</li>
                        {{-- <li class="list-group-item list-group-item-action">企業ランク：{{ $customer->company_rank }}</li> --}}
                        <li class="list-group-item list-group-item-action">作成日：{{ $customer->created_at }}</li>
                        <li class="list-group-item list-group-item-action">更新日：{{ $customer->updated_at }}</li>
                    </ul>
            </div>
        </div>
@endsection
