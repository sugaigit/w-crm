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
                                <li><a href="{{ route('users.index') }}">社員一覧</a></li>
                            @endcanany
                            <li><a href="{{ route('customers.index') }}">顧客一覧</a></li>
                            <li><a href="{{ route('customers.create') }}">顧客新規登録</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
