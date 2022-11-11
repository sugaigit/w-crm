@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="title m-b-md text-center">
            <p><a href="{{ route('login') }}">ログインはこちら</a></p>
            <p><a href="{{ route('register') }}">新規登録はこちら</a></p>
        </div>
    </div>
@endsection
