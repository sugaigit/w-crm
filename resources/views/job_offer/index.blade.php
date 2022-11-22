@extends('layouts.app')
@section('content')
<div class="container">
    <div class="main container-fluid">
        <div class="row bg-light text-dark py-5">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-center">求人情報</h1>
                <div class="d-flex justify-content">
                    <form class="form-control" method="GET" action="{{ route('job_offers.index') }}">
                        <h2 class="text-center">検索</h2>

                        <label for="userInput">営業担当</label>
                        {{-- todo: プルダウンにする --}}
                        <input class="form-control mt-1" id="userInput" type="search" placeholder="営業担当名を入力" name="userName" value="@if (isset($userName)) {{ $userName }} @endif">

                        <label for="clientInput" class="mt-3">就業先名称</label>
                        <input class="form-control mt-1" type="search" id="clientInput" placeholder="クライアント名を入力" name="companyName" value="@if (isset($companyName)) {{ $companyName }} @endif">

                        <label for="jobNumberInput" class="mt-3">仕事番号</label>
                        <input class="form-control mt-1" type="search" id="jobNumberInput" placeholder="仕事番号を入力" name="jobNumber" value="@if (isset($jobNumber)) {{ $jobNumber }} @endif">

                        <label for="keywordInput" class="mt-3">キーワード(未実装)</label>
                        <input class="form-control mt-1" type="search" id="keywordInput" placeholder="キーワードを入力" name="keyword" value="@if (isset($keyword)) {{ $keyword }} @endif">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-info m-2" type="submit">検索</button>
                            <button class="btn btn-success m-2">
                                <a href="{{ route('job_offers.index') }}" class="text-white text-decoration-none">クリア</a>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card-header w-75 m-auto">求人一覧</div>
<table class="table table-bordered table-hover w-75 m-auto">
    <thead>
    <tr class=m-auto style="background-color: lightgray">
        <td>ステータス</td>
        <td>仕事番号</td>
        <td>就業先名称</td>
        <td>仕事番号</td>
        <td>営業担当</td>
    </tr>
    </thead>

    {{-- @foreach($customers as $customer)
        <tr>
            <td>{{ $customer->id }}</td>
            <td>
                <a href="{{ route('customers.edit', $customer->id) }}">
                    {{ $customer->client_name }}
                </a>
            </td>
            <td>{{ $customer->company_id }}</td>
            <td>{{ $customer->handling_office }}</td>
            <td>{{ $customer->postal }}</td>
            <td>{{ $customer->prefectures.$customer->municipalities.$customer->streetbunch}}</td>
            <td>{{ $customer->phone }}</td>
        </tr>
    @endforeach --}}
</table>
{{--  pagenation link -------------------------------------------------------------------------------       --}}
{{-- <table width="100%">
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
</table> --}}
{{--  End of pagenation link -------------------------------------------------------------------------       --}}
@endsection

