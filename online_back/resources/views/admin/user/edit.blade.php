@extends('layouts.main')

@section('header')
@endsection

@section('content')
    <div>
        <table class="table">
            <tbody>
            <tr>
                <th class="text-r" width="80">用户名：</th>
                <td> {{ $user->name}}</td>
            </tr>

            <tr>
                <th class="text-r">邮箱：</th>
                <td> {{ $user->email }}</td>
            </tr>
            <tr>
                <th class="text-r">角色：</th>
                <td>{{ $user->role->name }}</td>
            </tr>
            <tr>
                <th class="text-r">注册时间：</th>
                <td>{{ $user->created_at }}</td>
            </tr>
            <tr>
                <th class="text-r">积分：</th>
                <td>330</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection

@section('js')
@endsection
