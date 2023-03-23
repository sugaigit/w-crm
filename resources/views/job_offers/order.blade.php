@extends('layouts.app')
@section('content')
<div class="container">
	<div class="main container-fluid">
		<div class="row bg-light text-dark py-5">
			<div class="col-md-8 offset-md-2">
				<h1 class="text-center">起算日リスト</h1>
				<div class="d-flex justify-content">
					<form class="form-control" method="GET" action="{{ route('jobffer.order_date.index') }}">
						<h2 class="text-center">検索</h2>

						<label for="userInput">営業担当</label>
						<select type="text" class="form-control" name="userId">
							<option value="">営業担当を選んで下さい</option>
							@foreach( $users as $user )
							<option value="{{ $user->id }}" @if (Request::input('userId') == $user->id) selected @endif>{{ $user->name }}</option>
							@endforeach
						</select>

                        <label for="jobNumberInput" class="mt-3">仕事番号</label>
						<input class="form-control mt-1" type="search" id="jobNumberInput" placeholder="仕事番号を入力" name="jobNumber" value="{{ Request::input('jobNumber') }}">

                        <label for="companyNameInput" class="mt-3">就業先名称</label>
						<input class="form-control mt-1" type="search" id="companyNameInput" placeholder="就業先名称を入力" name="companyName" value="{{ Request::input('companyName') }}">

                        <label for="orderingBusinessInput" class="mt-3">発注業務</label>
						<input class="form-control mt-1" type="search" id="orderingBusinessInput" placeholder="就業先名称を入力" name="orderingBusiness" value="{{ Request::input('orderingBusiness') }}">

                        <label for="orderDateInput" class="mt-3">起算日</label>
						<input class="form-control mt-1" type="date" id="orderDateInput" placeholder="就業先名称を入力" name="orderDate" value="{{ Request::input('orderDate') }}">

						<label class="mt-3">求人掲載サイト</label>
                        <div class="d-flex justify-content-evenly">
                          @foreach( config('options.posting_site') as $key => $postingSite )
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="postingSite[]" value="{{ $key }}" {{ old('postingSite') == $key ? 'checked' : '' }} id="{{ 'postingSiteInput' . $key }}" @if(is_array(Request::input('postingSite')) && in_array($key,Request::input('postingSite'))) checked @endif>
                              <label class="form-check-label" for="{{ 'postingSiteInput' . $key }}">
                                {{ $postingSite }}
                              </label>
                            </div>
                          @endforeach
                        </div>

						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button class="btn btn-info m-2" type="submit">検索</button>
							<button class="btn btn-success m-2">
									<a href="{{ route('jobffer.order_date.index') }}" class="text-white text-decoration-none">クリア</a>
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
        <th>求人ID</th>
        <th>営業担当</th>
        <th>仕事番号</th>
        <th>就業先名称</th>
        <th>発注業務</th>
        <th>起算日</th>
        <th>求人掲載サイト</th>
        <th>操作</th>
    </tr>
    </thead>

    @foreach($jobOffers as $jobOffer)
        <tr>
            <td>{{ $jobOffer->id }}</td>
            <td>{{ $jobOffer->user->name}}</td>
            <td>{{ $jobOffer->job_number }}</td>
            <td>{{ $jobOffer->company_name }}</td>
            <td>{{ $jobOffer->ordering_business }}</td>
            <td>{{ $jobOffer->order_date }}</td>
            <td>{{ $jobOffer->posting_site != null ? config('options.posting_site')[$jobOffer->posting_site] : '' }}</td>
            <td>
                <div class="d-flex justify-content-around">
                    <a href="{{ route('job_offers.edit', [
                        'job_offer' => $jobOffer->id,
                        'from_order_date' => true,
                    ]) }}">
                        <button class="btn btn-primary" type="button">編集</button>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
</table>


@endsection


@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('js')
<script type="text/javascript" src="{{ asset('/js/common.js') }}"></script>
@endsection
