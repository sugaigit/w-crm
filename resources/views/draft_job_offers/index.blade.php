@extends('layouts.app')
@section('content')
<div class="container">
    <div class="main container-fluid">
        <div class="row bg-light text-dark py-5">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-center">求人情報下書き</h1>
                <div class="d-flex justify-content">
                    <form class="form-control" method="GET" action="{{ route('draft.index') }}">
                        <h2 class="text-center">検索</h2>

						<label for="userInput">営業担当</label>
						<select type="text" class="form-control" name="userId">
							<option value="">営業担当を選んで下さい</option>
							@foreach( $users as $user )
							<option value="{{ $user->id }}" @if (Request::input('userId') == $user->id) selected @endif>{{ $user->name }}</option>
							@endforeach
						</select>

                        <label for="companyNameInput" class="mt-3">キーワード（営業担当・就業先名称）</label>
                        <input class="form-control mt-1" type="search" id="companyNameInput" placeholder="営業担当・就業先名称を入力" name="companyName" value="{{ Request::input('companyName') }}">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-info m-2" type="submit">検索</button>
                            <button class="btn btn-success m-2">
                                <a href="{{ route('draft.index') }}" class="text-white text-decoration-none">クリア</a>
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
        <th>操作</th>
        <th>求人ID</th>
        <th>ステータス</th>
        <th>仕事番号</th>
        <th>就業先名称</th>
        <th>営業担当</th>
    </tr>
    </thead>
    @foreach($draftJobOffers as $draftJobOffer)
    <tr class="bg-light text-secondary">
        <td>
            <div class="d-flex justify-content-around">
                <a href="{{ route('draft.detail', $draftJobOffer->id) }}">
                    <button class="btn btn-primary" type="button">詳細</button>
                </a>
            </div>
        </td>
        <td>下書き</td>
        <td>{{ $draftJobOffer->status != null ? config('options.status_edit')[$draftJobOffer->status] : '' }}</td>
        <td>{{ $draftJobOffer->job_number }}</td>
        <td>{{ $draftJobOffer->company_name }}</td>
        <td>{{ $draftJobOffer->user->name }}</td>
    </tr>
    @endforeach
</table>

<div class="d-flex justify-content-center mt-2">
    {{ $draftJobOffers->links() }}
</div>

@endsection

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('js')
<script type="text/javascript" src="{{ asset('/js/common.js') }}"></script>
@endsection
