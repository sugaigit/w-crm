@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <ul>
                            @canany('viewAny', auth()->user())
                            <li><a href="{{ route('users.index') }}" style="text-decoration: none;">社員一覧</a></li>
                            @endcanany
                            <li><a href="{{ route('customers.index') }}" style="text-decoration: none;">顧客一覧</a></li>
                            <li><a href="{{ route('customers.create') }}" style="text-decoration: none;">顧客新規登録</a></li>
                            {{-- 認可の要件がわからないので一旦制限を書けずに作成 (2022/10/20)平岡 --}}
                            <li><a href="{{ route('job_offers.index') }}" style="text-decoration: none;">求人一覧</a></li>
                            <li><a href="{{ route('job_offers.create') }}" style="text-decoration: none;">求人新規登録</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
