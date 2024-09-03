@extends('adminlte::page')

@section('title', '所属組織一覧 | イベント来場管理システム')

@section('content_header')
    <h1>所属組織一覧</h1>
@stop

@section('content')
    
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <a href="{{ route('organization.create') }}" class="btn btn-primary mb-2 float-right">新規作成</a>
                        <table class="organization-table">
                            <tr>
                                <th class="organization-id-td">ID</th>
                                <th class="organization-name-td">組織名</th>
                                <th class="organization-create-td">作成日</th>
                                <th class="organization-edit-td"></th>
                            </tr>
                        @foreach($Usersorganizations as $Usersorganization)
                        <tr>
                            <td class="organization-id-td">{{ $Usersorganization->id }}</td>
                            <td class="organization-name-td">{{ $Usersorganization->name }}</td>
                            <td class="organization-create-td">{{ $Usersorganization->created_at }}</td>
                            
                            <td class="organization-edit-td">
                                <a href="{{ route('organization.edit', $Usersorganization->id) }}" class="btn btn-primary">編集</a>
                                <form action="{{ route('organization.destroy', $Usersorganization->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
                                </form>
                            </td>
                            
                        </tr>
                        
                        @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('css')
    {{-- ページごとCSSの指定
    <link rel="stylesheet" href="/css/xxx.css">
    --}}
@stop

@section('js')
    <script> console.log('ページごとJSの記述'); </script>
@stop