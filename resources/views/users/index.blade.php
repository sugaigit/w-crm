@extends('layouts.app')
@section('content')
                    <div class="card-header w-50 m-auto">顧客</div>
                    <table class="table table-bordered table-hover w-50 m-auto">
                        <thead>
                        <tr style="background-color: lightgray">
                            <td>氏名</td>
                            <td>所属会社</td>
                            <td>役職</td>
                            <td>メール</td>
                        </tr>
                        </thead>
                        @foreach($users as $user)  {{-- Controllerから渡された users を foreach で回す --}}
                            <tr>
                                <td>{{ $user->name }}</td> {{-- 各要素を表示 --}}
                                <td>{{ $user->company_id }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        @endforeach
                    </table>
@endsection
