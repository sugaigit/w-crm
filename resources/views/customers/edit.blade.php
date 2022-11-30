@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">クライアント情報編集</div>
                    {{-- <form action="/customers" method="POST"> --}}
                     <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                        @method('PUT')
                        @csrf
                        <p>クライアントID:{{ $customer->id}} <p>
                        <p>取扱会社種別：<select type="text" class="form-control w-25" name="company_type" value="{{ $customer->company_type }}">
                            @foreach(config('pref') as $key => $score)
                            <option value="{{ $score }}">{{ $score }}</option>
                            @endforeach
                        </select>
                        </p>

                        <p>取扱事業所：<select type="text" class="form-control w-25" name="handling_office" value="{{ $customer->handling_office }}">
                            @foreach(config('handling_office') as $key => $score)
                            <option value="{{ $score }}">{{ $score }}</option>
                            @endforeach
                        </select>
                        </p>
                        <p>クライアント名：<input type="text" name="name" value="{{ $customer->name }}"></p>
                        <p>クライアント名カナ：<input type="text" name="kana" value="{{ $customer->kana}}"></p>
                        <p>営業担当者名：<?php $user = AUTH::user(); ?>{{ $user->name }}</p>
                        <p>住所：<input type="text" name="address" value="{{$customer->address }}"></p>
                        <p>電話番号：<input type="text" name="phone" value="{{ $customer->phone }}"></p>
                        <p>FAX：<input type="text" name="fax" value="{{ $customer->fax }}"></p>
                        {{-- <p>企業ランク：<input type="text" name="company_rank" value="{{ $customer->company_rank }}"></p> --}}
                        <p style="text-align: center"><button class="btn btn-primary" type="submit">更新する</button></p>
                    </form>
                    {{-- エラーを表示--}}
                    @if( $errors->any() )
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
