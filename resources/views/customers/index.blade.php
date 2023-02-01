@extends('layouts.app')
@section('content')
<div class="container">
    <div class="main container-fluid">
        <div class="row bg-light text-dark py-5">
            <div class="col-md-8 offset-md-2">
                <div class="d-flex justify-content">
                    <form class="form-control" method="GET" action="{{ route('customers.index') }}">
                        <h2 class="text-center">検索</h2>
                        <input class="form-control mt-3" id="floatingInput" type="search" placeholder="クライアント名を入力" name="clientsearch" value="@if (isset($clientsearch)) {{ $clientsearch }} @endif">
                        <input class="form-control mt-3" id="floatingInput" type="search" placeholder="電話番号を入力" name="phonesearch" value="@if (isset($phonesearch)) {{ $phonesearch }} @endif">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-info m-2" type="submit">検索</button>
                            <button class="btn btn-success m-2">
                                <a href="{{ route('customers.index') }}" class="text-white text-decoration-none">
                                    クリア
                                </a>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-header w-75 m-auto">顧客一覧</div>
<table class="table table-bordered table-hover w-75 m-auto">
    <thead>
        <tr class=m-auto style="background-color: lightgray">
            <th class="text-center">顧客ID</th>
            <th class="text-center">顧客名</th>
            <th class="text-center">取扱会社種別</th>
            <th class="text-center">取扱事業所</th>
            <th class="text-center">住所</th>
            <th class="text-center">電話番号</th>
            <th class="text-center">操作</th>
        </tr>
    </thead>
    @foreach($customers as $customer)
    <tr>
        <td>{{ $customer->id }}</td>
        <td>
            {{ $customer->customer_name }}
        </td>
        <td>{{ isset($customer->handling_type) ? config('options')['handling_type'][$customer->handling_type] :'' }}</td>
        <td>{{ isset($customer->handling_office) ? config('options')['handling_office'][$customer->handling_office] :'' }}</td>
        <td>{{ $customer->address }}</td>
        <td>{{ $customer->phone }}</td>
        <td>
            <div class="d-flex justify-content-around">
                <a href="{{ route('customers.edit', $customer->id) }}">
                    <button class="btn btn-primary" type="button">編集</button>
                </a>
                <form method="POST" action="{{ route('customers.destroy', $customer->id) }}">
                    @method('DELETE')
                    @csrf
                    <button class="delete-btn btn btn-danger" type="submit">削除</button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</table>

{{--  pagenation link -------------------------------------------------------------------------------       --}}
<table width="100%">
    <tr>
        @if($customers->lastPage() > 1)
            <td width="120px"><a href="{{ $customers->url(0) }}">最初のページへ</a></td>
            <td width="120px">
                @if($customers->previousPageUrl())
                    <a href="{{ $customers->previousPageUrl() }}">前のページへ</a>
                @endif
            </td>
            <td width="120px" style="text-align: center">{{ $customers->currentPage() }}
                / {{ $customers->lastPage() }}</td>
            <td width="120px">
                @if($customers->nextPageUrl())
                    <a href="{{ $customers->nextPageUrl() }}">次のページへ</a>
                @endif
            </td>
            <td width="120px"><a href="{{ $customers->url($customers->lastPage()) }}">最後のページへ</a>
            </td>

        @endif
    </tr>
</table>
{{--  End of pagenation link -------------------------------------------------------------------------       --}}

@endsection

@section('js')
  <script type="text/javascript" src="{{ asset('/js/common.js') }}"></script>
@endsection
