@extends('layouts.app')
@section('content')
                    <div class="card-header w-50 m-auto">ユーザー</div>
                    <table class="table table-bordered table-hover w-50 m-auto">
                        <thead>
                        <tr style="background-color: lightgray">
                            <td>氏名</td>
                            <td>メールアドレス</td>
                            {{-- <td>役職</td> --}}
                            {{-- <td>会員ID</td> --}}
                        </tr>
                        </thead>
                        @foreach($users as $user)  {{-- Controllerから渡された users を foreach で回す --}}
                            <tr>
                                <td>{{ $user->name }}</td> {{-- 各要素を表示 --}}
                                <td>{{ $user->email }}</td>
                                {{-- <td>{{ $user->jobs }}</td> --}}
                                {{-- <td>{{ $user->id }}</td> --}}
                            </tr>
                        @endforeach
                    </table>
@endsection
