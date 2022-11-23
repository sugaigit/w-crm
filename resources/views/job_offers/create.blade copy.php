@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                    <div class="card-header">求人情報新規登録</div>
                    <form action="{{ route('job_offers.store') }}" method="POST">
                        @csrf
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-action">
                                営業担当<span class="text-danger">*</span>：
                                <select type="text" class="form-control" name="user_id">
                                    <option value="">営業担当を選んで下さい</option>
                                    @foreach( $users as $user )
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                仕事番号：
                                <input type="text" name="job_number" value="{{ old('job_number') }}">
                            </li>
                            <li class="list-group-item list-group-item-action">
                                事業種別<span class="text-danger">*</span>：
                                <input type="text" name="business_type" value="{{ old('business_type') }}">
                            </li>
                            <li class="list-group-item list-group-item-action">
                                法人形態<span class="text-danger">*</span>：
                                <input type="text" name="corporate_type" value="{{ old('corporate_type') }}">
                            </li>
                            <li class="list-group-item list-group-item-action">
                                顧客<span class="text-danger">*</span>：
                                <select type="text" class="form-control" name="customer_id">
                                    <option value="">顧客を選んで下さい</option>
                                    @foreach( $customers as $customer )
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
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
