@extends('layouts.app')
@section('content')
<div class="container">
    <div class="main container-fluid">
        <div class="row bg-light text-dark py-5">
            <div class="col-md-8 offset-md-2">
                <div class="d-flex justify-content">
                    <form class="form-control" method="GET" action="{{ route('customers.index') }}">
                        <h2 class="text-center">検索</h2>
                        <input class="form-control mt-3" type="search" placeholder="顧客名を入力" name="clientsearch" value="@if (isset($clientsearch)) {{ $clientsearch }} @endif">
                        <input class="form-control mt-3" type="search" placeholder="電話番号を入力" name="phonesearch" value="@if (isset($phonesearch)) {{ $phonesearch }} @endif">

                        <select type="text" class="form-control mt-3" name="usersearch">
                            <option value="">作成者を選択</option>
                            @foreach( $users as $key => $user )
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>

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

<div class="card-header w-75 m-auto">
    <div class="p-2">顧客一覧（{{ request()->has('show_all') ? 'すべて' : '表示のみ' }}）</div>
    <div>
        {{-- @if (request()->has('show_all'))
            <a href="{{ route('customers.index') }}">
                <button class="btn btn-primary" type="button">表示を見る</button>
            <a>
        @else
            <a href="{{ route('customers.index', ['show_all' => 1]) }}">
                <button class="btn btn-primary" type="button">すべてを見る</button>
            <a>
        @endif --}}

        <select type="text" class="form-control mt-3" name="show_filter">
            <option value="show" {{ request()->query('show_filter') == 'show' ? 'selected' : '' }}>表示を見る</option>
            <option value="hidden" {{ request()->query('show_filter') == 'hidden' ? 'selected' : '' }}>非表示を見る</option>
            <option value="all" {{ request()->query('show_filter') == 'all' ? 'selected' : '' }}>すべてを見る</option>
        </select>
    </div>
</div>

<table class="table table-bordered table-hover w-75 m-auto">
    <thead>
        <tr class=m-auto style="background-color: lightgray">
            <th class="text-center">顧客ID</th>
            <th class="text-center">法人形態</th>
            <th class="text-center">顧客名</th>
            <th class="text-center">取扱会社種別</th>
            <th class="text-center">取扱事業所</th>
            <th class="text-center">業種</th>
            <th class="text-center">住所</th>
            <th class="text-center">作成者</th>
            <th class="text-center">操作</th>
        </tr>
    </thead>
    @foreach($customers as $customer)
    <tr>
        <td>{{ $customer->id }}</td>
        <td>{{ !empty($customer->corporate_type) ? config('options')['corporate_type'][$customer->corporate_type] :'' }}</td>
        <td>
            {{ $customer->customer_name }}
        </td>
        <td>{{ !empty($customer->handling_type) ? config('options')['handling_type'][$customer->handling_type] :'' }}</td>
        <td>{{ !empty($customer->handling_office) ? config('options')['handling_office'][$customer->handling_office] :'' }}</td>
        <td>{{ $customer->industry }}</td>
        <td>{{ $customer->address }}</td>
        <td>{{ $customer->user->name }}</td>
        <td>
            <div class="d-flex justify-content-around">
                <a href="{{ route('customers.edit', $customer->id) }}">
                    <button class="btn btn-primary" type="button">編集</button>
                </a>
                <form method="POST" action="{{ route('customers.hidden', $customer->id) }}">
                    @csrf
                    <button class="btn {{ $customer->is_show == true ? 'btn-danger' : 'btn-success'}}" type="submit">
                        {{ $customer->is_show == true ? '非表示にする' : '表示にする'}}
                    </button>
                    <input type="hidden" name="hidden_flag" value={{ $customer->is_show == true ? '1' : '0'}}>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</table>

<div class="d-flex justify-content-center mt-2">
    {{ $customers->links() }}
</div>


@endsection

@section('js')
  <script type="text/javascript" src="{{ asset('/js/common.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/customer/index.js') }}"></script>
@endsection
