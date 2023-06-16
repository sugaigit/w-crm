@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="title m-b-md text-center">
            <p><a href="{{ route('login') }}">ログイン</a></p>
            <p><a href="{{ route('register') }}">新規登録</a></p>
        </div>
    </div>
@endsection
