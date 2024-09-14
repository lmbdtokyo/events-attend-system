@extends('adminlte::page')

@section('title', 'QRコード生成')

@section('content_header')
    <h1>空QRコード生成</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">QRコード生成フォーム</h3>
        </div>
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

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('eventsgenerateqr.store', $event->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="number">QRコード数</label>
                    <input type="number" name="number" id="number" class="form-control" required>
                </div>
                <div class="small" style="margin-bottom:30px;">
                    ※QRコードの生成は50件までです。※イベント来場数上限によってはより少ない場合もございます。
                </div>
                <button type="submit" class="btn btn-primary">生成</button>
            </form>
            
        </div>
    </div>
@stop
