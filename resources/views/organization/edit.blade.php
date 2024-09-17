@extends('adminlte::page')

@section('title', '編集組織 | イベント来場管理システム')

@section('content_header')
    <h1>編集組織</h1>
@stop

@section('content')
    
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('organization.update', $organization->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="name">組織名</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="組織名を入力してください" value="{{ $organization->name }}">
                            </div>
                            <button type="submit" class="btn btn-primary">変更</button>
                        </form>
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
