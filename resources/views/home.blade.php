@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Tree') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <ul>

                            <div class="d-flex justify-content-evenly">

                                <div>
                                    <li>
                                        <a href="{{ route('customers.create') }}" style="text-decoration: none;">
                                            <button class="btn btn-outline-secondary btn-lg mb-2" type="button">
                                                顧客新規登録
                                            </button>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('customers.index') }}" style="text-decoration: none;">
                                            <button class="btn btn-secondary btn-lg mb-2" type="button">
                                                顧客一覧
                                            </button>
                                        </a>
                                    </li>
                                </div>

                                <div>
                                    <li>
                                        <a href="{{ route('job_offers.create') }}" style="text-decoration: none;">
                                            <button class="btn btn-outline-secondary btn-lg mb-2" type="button">
                                                求人新規登録
                                            </button>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('job_offers.index') }}" style="text-decoration: none;">
                                            <button class="btn btn-secondary btn-lg mb-2" type="button">
                                                求人一覧
                                            </button>
                                        </a>
                                    </li>
                                </div>

                                <div>
                                    <li>
                                        <a href="{{ route('draft.index') }}" style="text-decoration: none;">
                                            <button class="btn btn-outline-secondary btn-lg mb-2" type="button">
                                                求人下書き一覧
                                            </button>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('invalid_job_offers') }}" style="text-decoration: none;">
                                            <button class="btn btn-secondary btn-lg mb-2" type="button">
                                                ランク外求人一覧
                                            </button>
                                        </a>
                                    </li>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
ul {
    padding-left:0;
}

li {
    list-style:none;
}
</style>
