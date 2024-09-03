@extends('adminlte::page')

@section('title', '管理ユーザー一覧 | イベント来場管理システム')

@section('content_header')
    <h1>管理ユーザー一覧</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('user.create') }}" class="btn btn-success mb-2 float-right">新規作成</a>
            <table id="users-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名前</th>
                        <th>メールアドレス</th>
                        <th>所属組織</th>
                        <th>権限</th>
                        <th>種別</th>
                        <th>作成日</th>
                        <th>アクション</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach ($organizations as $organization)
                                    @if ($organization->id == $user->organization)
                                        {{ $organization->name }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($auths as $auth)
                                    @if ($auth->id == $user->auth)
                                        {{ $auth->name }}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $user->type }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                @if ($user->type !== 'master')
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm">編集</a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(function () {
            $('#users-table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@stop
