@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="title m-b-md text-center">
            <p><a href="{{ route('login') }}" class="btn_01">ログイン</a></p>
            <p><a href="{{ route('register') }}" class="btn_02">新規登録</a></p>
        </div>
    </div>
@endsection
