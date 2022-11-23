@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                    <div class="card-header">求人情報新規登録</div>
                    <form action="{{ route('job_offers.store') }}" method="POST">
                        @csrf
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>営業担当<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="user_id">
                                            <option value="">営業担当を選んで下さい</option>
                                            @foreach( $users as $user )
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>仕事番号</th>
                                    <td>
                                        <input type="text" class="form-control" name="job_number" value="{{ old('job_number') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>事業種別<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text"class="form-control" name="business_type" value="{{ old('business_type') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>法人形態<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" class="form-control" name="corporate_type" value="{{ old('corporate_type') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>顧客<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="customer_id">
                                            <option value="">顧客を選んで下さい</option>
                                            @foreach( $customers as $customer )
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>顧客<span class="text-danger">*</span></th>
                                    <td>
                                        <select type="text" class="form-control" name="customer_id">
                                            <option value="">顧客を選んで下さい</option>
                                            @foreach( $customers as $customer )
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                              {{-- <tr><th>フリガナ</th><td>{{ $user->kana }}</td></tr>
                              <tr><th>性別</th><td>{{ $sex }}</td></tr>
                              <tr><th>年齢</th><td>{{ $age }}歳</td></tr>
                              <tr><th>体重</th><td>{{ $user->weight }}kg</td></tr>
                              <tr><th>体脂肪率</th><td>{{ $user->fat }}%</td></tr>
                              <tr><th>除脂肪体重</th><td>{{ $lean_body_mass }}kg</td></tr>
                              <tr><th>身体活動レベル</th><td><input type="number" step="0.01" name="activity_level" value="{{ $user->activity_level }}"></td></tr>
                              <tr><th>推定エネルギー必要量</th><td>{{ $enr }} kcal/日</td></tr>
                              <tr>
                                <th>
                                  <div class="form-check">
                                    <input class="form-check-input " type="checkbox" value="1" name="protein_show" @if($user->protein_show) checked @endif>
                                    たんぱく質
                                  </div>
                                </th>
                                <td>
                                  <input type="number" step="0.01" name="protein"  value="{{ $user->protein }}" > g
                                </td>
                              </tr>
                              <tr><th>ユーザータイプ</th>
                                <td>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="general" type="radio" name="activity_type" value="0" @if($user->activity_type==0) checked @endif ><label class="form-check-label" for="general">一般</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="athlete" type="radio" name="activity_type" value="1" @if($user->activity_type==1) checked @endif ><label class="form-check-label" for="athlete">アスリート</label>
                                  </div>
                                </td>
                              </tr>
                              <tr><th>スタッフ</th>
                                <td>
                                  <select class="form-select" aria-label="Default select example" name="staff_id">
                                    <option value="">スタッフ名を選んで下さい</option>
                                    @foreach( $staffs as $staff )
                                    <option value="{{ $staff->id }}"  @if($user->staff_id==$staff->id) selected @endif>{{ $staff->name }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr> --}}
                            </tbody>
                          </table>
                        {{-- <ul class="list-group">
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
                        </ul> --}}

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
