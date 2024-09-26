@extends('adminlte::page')

@section('title', '申込者一覧 | イベント来場管理システム')

@section('content_header')
    <h1>申込者一覧</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名前</th>
                        <th>フリガナ</th>
                        <th>会社名</th>
                        <th>部署</th>
                        <th>役職</th>
                        <th>メールアドレス</th>
                        <th>電話番号</th>
                        <th>生年月日</th>
                        <th>セクション</th>
                        <th>ログインID</th>
                        <th>登録日</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eventUsers as $eventUser)
                        <tr>
                            <td>{{ $eventUser->id }}</td>
                            <td>{{ $eventUser->name }}</td>
                            <td>{{ $eventUser->furigana }}</td>
                            <td>{{ $eventUser->company }}</td>
                            <td>{{ $eventUser->division }}</td>
                            <td>{{ $eventUser->post }}</td>
                            <td>{{ $eventUser->mail }}</td>
                            <td>{{ $eventUser->tel }}</td>
                            <td>{{ $eventUser->birth }}</td>
                            <td>{{ $eventUser->section }}</td>
                            <td>{{ $eventUser->login_id }}</td>
                            <td>{{ \Carbon\Carbon::parse($eventUser->created_at)->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $eventUsers->links() }}
            </div>
        </div>
    </div>
@endsection
