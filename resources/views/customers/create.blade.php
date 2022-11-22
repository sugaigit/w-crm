@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                    <div class="card-header">顧客新規登録</div>
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-action">
                                営業担当：
                                <select type="text" class="form-control" name="user_id">
                                    <option value="">営業担当を選んで下さい</option>
                                    @foreach( $users as $user )
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                取扱会社種別：
                                <select type="text" class="form-control" name="company_type">
                                    @foreach(config('pref') as $key => $score)
                                    <option value="{{ $score }}">{{ $score }}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                取扱事業所：
                                <select type="text" class="form-control" name="handling_office">
                                    @foreach(config('handling_office') as $key => $score)
                                    <option value="{{ $score }}">{{ $score }}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                クライアント名：<input type="text" name="name" value="{{ old('name') }}">
                            </li>
                            <li class="list-group-item list-group-item-action">
                                クライアント名カナ：<input type="text" name="kana" value="{{ old('kana') }}">
                            </li>
                            <li class="list-group-item list-group-item-action">
                                住所：<input type="text" name="address" value="{{ old('address') }}">
                            </li>
                            <li class="list-group-item list-group-item-action">
                                電話番号：<input type="text" name="phone" value="{{ old('phone') }}">
                            </li>
                            <li class="list-group-item list-group-item-action">
                                FAX：<input type="text" name="fax" value="{{ old('fax') }}">
                            </li>
                            <li class="list-group-item list-group-item-action">
                                企業ランク：<input type="text" name="company_rank" value="{{ old('company_rank') }}">
                            </li>
                        </ul>

                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button class="btn btn-primary" type="submit">登録</button>
                        </div>

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

            <button class="btn btn-outline-secondary btn-lg" data-bs-toggle="button" autocomplete="off" type="submit" onClick="history.back()">
                前に戻る
            </button>

        </div>
    </div>

@endsection
