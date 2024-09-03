@extends('adminlte::page')

@section('title', '管理ユーザー編集 | イベント来場管理システム')

@section('content_header')
    <h1>管理ユーザー編集</h1>
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

            @if ($user->type == 'master')
                <div class="alert alert-danger">
                    マスターアカウントは編集できません。
                </div>
            @else
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">名前</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" placeholder="名前を入力">
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" placeholder="メールアドレスを入力">
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input type="password" name="password" class="form-control" id="password" value="{{ $user->password }}" placeholder="パスワードを入力">
                    </div>

                    <div class="form-group">
                        <label for="auth">権限</label>
                        <select name="auth" class="form-control" id="auth">
                            @foreach ($auths as $auth)
                                <option value="{{ $auth->id }}" {{ $user->auth == $auth->id ? 'selected' : '' }}>{{ $auth->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="organization">所属組織</label>
                        <select name="organization" class="form-control" id="organization">
                            @foreach ($organizations as $organization)
                                <option value="{{ $organization->id }}" {{ $user->organization == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="type" value="{{ $user->type }}">

                    <button type="submit" class="btn btn-primary">更新</button>
                </form>
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('ページごとJSの記述'); </script>
@stop
