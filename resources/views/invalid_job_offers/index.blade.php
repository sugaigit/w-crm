@extends('layouts.app')
@section('content')
<div class="container">
	<div class="main container-fluid">
		<div class="row bg-light text-dark py-5">
			<div class="col-md-8 offset-md-2">
				<h1 class="text-center">ランク外求人情報</h1>
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
						<input class="form-control mt-1" type="search" id="clientInput" placeholder="就業先名称を入力" name="companyName" value="{{ Request::input('companyName') }}">

						<label for="jobNumberInput" class="mt-3">仕事番号</label>
						<input class="form-control mt-1" type="search" id="jobNumberInput" placeholder="仕事番号を入力" name="jobNumber" value="{{ Request::input('jobNumber') }}">

						<label class="mt-3">ステータス</label>
                        <div class="d-flex justify-content-evenly">
                          @foreach( config('options.status_edit') as $key => $status )
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="status[]" value="{{ $key }}" {{ old('status') == $key ? 'checked' : '' }} id="{{ 'statusInput' . $key }}" @if(is_array(Request::input('status')) && in_array($key,Request::input('status'))) checked @endif>
                              <label class="form-check-label" for="{{ 'statusInput' . $key }}">
                                {{ $status }}
                              </label>
                            </div>
                          @endforeach
                        </div>

                        <label class="mt-3">起算日</label>
                        <div class="d-flex justify-content-evenly">
                            <label class="mt-3"></label>
                            <input class="form-control mt-1 w-25" type="date" id="orderDateStartInput" name="orderDateStart" value="{{ Request::input('orderDateStart') }}">
                            ～
                            <input class="form-control mt-1 w-25" type="date" id="orderDateEndInput" name="orderDateEnd" value="{{ Request::input('orderDateEnd') }}">
                        </div>

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
    <div class="card-header w-100">求人一覧</div>
    <table class="table table-bordered table-hover w-100">
        <thead>
        <tr class=m-auto style="background-color: lightgray">
            <th>求人ID</th>
            <th>ステータス</th>
            <th>求人ランク</th>
            <th>取扱会社種別</th>
            <th>取扱事業所名</th>
            <th>仕事番号</th>
            <th>顧客名</th>
            <th>就業先名称</th>
            <th>契約形態</th>
            <th>発注業務</th>
            <th>発注人数</th>
            <th>請求単価①</th>
            <th>支払単価①</th>
            <th>営業担当</th>
            <th>操作</th>
        </tr>
        </thead>

        @foreach($jobOffers as $jobOffer)
            <tr>
                <td>{{ $jobOffer->id }}</td>
                <td>{{ $jobOffer->status != null ? config('options.status_edit')[$jobOffer->status] : '' }}</td>
                <td>{{ $jobOffer->rank }}</td>
                <td>{{ $jobOffer->handling_type != null ? config('options.handling_type')[$jobOffer->handling_type] : '' }}</td>
                <td>{{ $jobOffer->handling_office != null ? config('options.handling_office')[$jobOffer->handling_office] : '' }}</td>
                <td>{{ $jobOffer->job_number}}</td>
                <td>{{ $jobOffer->customer->customer_name}}</td>
                <td>{{ $jobOffer->company_name }}</td>
                <td>{{ $jobOffer->type_contract != null ? config('options.type_contract')[$jobOffer->type_contract] : '' }}</td>
                <td>{{ $jobOffer->ordering_business }}</td>
                <td>{{ $jobOffer->order_number != null ? config('options.order_number')[$jobOffer->order_number] : '' }}</td>
                <td>{{ $jobOffer->invoice_unit_price_1 }}</td>
                <td>{{ $jobOffer->payment_unit_price_1 }}</td>
                <td>{{ $jobOffer->user->name }}</td>
                <td>
                    <div class="d-flex justify-content-around">
                        <a href="{{ route('job_offers.detail', $jobOffer->id) }}">
                            <button class="btn btn-primary" type="button">詳細</button>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
</div>

<div class="d-flex justify-content-center mt-2">
  {{ $jobOffers->links() }}
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
