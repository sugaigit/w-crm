@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">顧客内容編集</div>
                <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                @method('PUT')
                @csrf
                <table class="table">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{ $customer->id}}</td>
                        </tr>
                        <tr>
                            <th>作成者<span class="text-danger">*</span></th>
                            <td>
                                <select type="text" class="form-control" name="user_id">
                                    <option value="">営業担当を選んで下さい</option>
                                    @foreach( $users as $user )
                                        <option value="{{ $user->id }}" {{ $user->id == $customer->user->id ? 'selected' : '' }}> {{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>取扱会社種別<span class="text-danger">*</span></th>
                            <td>
                                <select type="text" class="form-control" name="handling_type">
                                    <option value="">取扱会社種別を選んで下さい</option>
                                    @foreach( config('options.handling_type') as $key => $handling_type )
                                    <option value="{{ $key }}" {{ $key == $customer->handling_type ? 'selected' : '' }}>{{ $handling_type }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>取扱事業所名<span class="text-danger">*</span></th>
                            <td>
                                <select type="text" class="form-control" name="handling_office">
                                    <option value="">取扱事業所名を選んで下さい</option>
                                    @foreach( config('options.handling_office') as $key => $handling_office )
                                    <option value="{{ $key }}" {{ $key == $customer->handling_office ? 'selected' : '' }}>{{ $handling_office }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>法人形態<span class="text-danger">*</span></th>
                            <td>
                                <select type="text" class="form-control" name="corporate_type">
                                    <option value="">法人形態を選んで下さい</option>
                                    @foreach( config('options.corporate_type') as $key => $corporate_type )
                                    <option value="{{ $key }}" {{ $key == $customer->corporate_type ? 'selected' : '' }}>{{ $corporate_type }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>顧客名<span class="text-danger">*</span></th>
                            <td>
                                <input type="text" class="form-control" name="customer_name" value="{{ isset($customer->customer_name) ? $customer->customer_name : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>顧客名（カナ）</th>
                            <td>
                                <input type="text" class="form-control" name="customer_kana" value="{{ isset($customer->customer_kana) ? $customer->customer_kana : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>所属部署</th>
                            <td>
                                <input type="text" class="form-control" name="department" value="{{ isset($customer->department) ? $customer->department : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>顧客担当者名</th>
                            <td>
                                <input type="text" class="form-control" name="manager_name" value="{{ isset($customer->manager_name) ? $customer->manager_name : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>顧客住所</th>
                            <td>
                                <input type="text" class="form-control" name="address" value="{{ isset($customer->address) ? $customer->address : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>電話番号</th>
                            <td>
                                <input type="text" class="form-control" name="phone" value="{{ isset($customer->phone) ? $customer->phone : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td>
                                <input type="text" class="form-control" name="email" value="{{ isset($customer->email) ? $customer->email : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <th>FAX</th>
                            <td>
                                <input type="text" class="form-control" name="fax" value="{{ isset($customer->fax) ? $customer->fax : '' }}">
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4 mb-3">
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>

            </form>

            @if( $errors->any() )
                <ul>
                    @foreach($errors->all() as $error)
                        <li class="text-danger">{{$error}}</li>
                    @endforeach
                </ul>
            @endif

        </div>
    </div>
</div>

@endsection
