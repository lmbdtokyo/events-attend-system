@extends('adminlte::page')

@section('title', 'ユーザー作成 | イベント来場管理システム')

@section('content_header')
    <h1>管理ユーザー作成</h1>

@stop

@section('content')
    <div class="card">
        <div class="card-body">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </div>
            @endif

            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">名前</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="名前を入力">
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="メールアドレスを入力">
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="パスワードを入力">
                    <p class="text-danger small">
                        ご注意: セキュリティ上、ここで設定したパスワードは一時的な利用に留めていただき、ユーザー様には初回ログイン後、速やかにパスワードを変更していただくようお伝えください。
                    </p>
                </div>

                <div class="form-group">
                    <label for="auth">権限</label>
                    <select name="auth" class="form-control" id="auth">
                        @foreach ($auths as $auth)
                            <option value="{{ $auth->id }}">{{ $auth->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="organization">所属組織</label>
                    <select name="organization" class="form-control" id="organization">
                        @foreach ($organizations as $organization)
                            <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="type" value="client">

                <button type="submit" class="btn btn-primary">作成</button>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('ページごとJSの記述'); </script>
@stop
