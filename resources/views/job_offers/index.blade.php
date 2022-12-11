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
                        <select type="text" class="form-control" name="userId">
                            <option value="">営業担当を選んで下さい</option>
                            @foreach( $users as $user )
                            <option value="{{ $user->id }}" @if (Request::input('userId') == $user->id) selected @endif>{{ $user->name }}</option>
                            @endforeach
                        </select>

                        <label for="clientInput" class="mt-3">就業先名称</label>
                        <input class="form-control mt-1" type="search" id="clientInput" placeholder="クライアント名を入力" name="companyName" value="{{ Request::input('companyName') }}">

                        <label for="jobNumberInput" class="mt-3">仕事番号</label>
                        <input class="form-control mt-1" type="search" id="jobNumberInput" placeholder="仕事番号を入力" name="jobNumber" value="{{ Request::input('jobNumber') }}">

                        <label for="statusInput" class="mt-3">ステータス</label>
                        <select type="text" class="form-control" name="status">
                            <option value="">作成ステータスを選んで下さい</option>
                            @foreach( config('options.status_edit') as $key => $status )
                            <option value="{{ $key }}" @if( $key == Request::input('status') ) selected @endif>{{ $status }}</option>
                            @endforeach
                        </select>

                        <label for="keywordsInput" class="mt-3">キーワード</label>
                        <input class="form-control mt-1" type="search" id="keywordsInput" placeholder="キーワードを入力" name="keywords" value="{{ Request::input('keywords') }}">

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
        <td>営業担当</td>
        <td>操作</td>
    </tr>
    </thead>

    @foreach($jobOffers as $jobOffer)
        <tr>
            <td>{{ $jobOffer->status != null ? config('options.status_edit')[$jobOffer->status] : '' }}</td>
            <td>{{ $jobOffer->job_number }}</td>
            <td>{{ $jobOffer->company_name }}</td>
            <td>{{ $jobOffer->user->name}}</td>
            <td><a href="{{ route('job_offers.edit', ['job_offer' => $jobOffer->id]) }}">編集</a></td>
        </tr>
    @endforeach
</table>

@endsection

