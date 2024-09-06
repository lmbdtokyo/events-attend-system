@extends('adminlte::page')

@section('title', '新規組織作成 | イベント来場管理システム')

@section('content_header')
    <h1>新規組織作成</h1>
@stop

@section('content')

    
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
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

                        <form action="{{ route('organization.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">組織名</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="組織名を入力してください">
                            </div>
                            <button type="submit" class="btn btn-primary">作成</button>
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
