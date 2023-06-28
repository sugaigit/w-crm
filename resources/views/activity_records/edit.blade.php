@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">活動記録編集</div>
                <form method="POST" action="{{ route('activity.update', $activityRecord->id) }}">
                @csrf
                <table class="table">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{ $activityRecord->id}}</td>
                        </tr>
                        <tr>
                            <th>日付<span class="text-danger">*</span></th>
                            <td>
                                @if (is_null(old('date')))
                                <input  type="date" class="form-control required" name="date" value="{{ isset($activityRecord->date) ? $activityRecord->date : '' }}" required>
                                @else
                                <input  type="date" class="form-control" name="date" value="{{ old('date') }}" required>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>項目<span class="text-danger">*</span></th>
                            <td>
                                <select type="text" class="form-control required" name="item" required>
                                    <option value="">項目を選んで下さい</option>
                                    @foreach( config('options.item') as $key => $item )
                                    <option value="{{ $key }}" {{ $key == $activityRecord->item ? 'selected' : '' }}>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>詳細</th>
                            <td>
                                @if (is_null(old('detail')))
                                <input  type="text" class="form-control required" name="detail" value="{{ isset($activityRecord->detail) ? $activityRecord->detail : '' }}" required>
                                @else
                                <input  type="text" class="form-control" name="detail" value="{{ old('detail') }}" required>
                                @endif
                            </td>
                        </tr>
                        <input  type="hidden" name="job_offer_id" value="{{ $activityRecordJobOfferId }}">
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

@section('js')
    <script type="text/javascript" src="{{ asset('/js/customer/edit.js') }}"></script>
@endsection