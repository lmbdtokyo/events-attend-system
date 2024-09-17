@extends('adminlte::page')

@section('title', '申込完了画面設定 | イベント来場管理システム')

@section('content_header')
    <h1>申込完了画面設定</h1>
@endsection

@section('content')
    <form action="{{ route('eventfinish.update', $event->id) }}" method="POST">
        @csrf
        @method('PATCH')

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
                @if(session('success'))
                    <div class="alert alert-success">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <p>
                    申込完了画面の設定を行います。<br>各項目に必要な情報を入力してください。
                </p>

                <table class="table table-bordered event-setting-table">
                    <tr>
                        <th>項目名</th>
                        <th>入力内容</th>
                    </tr>
                    <tr>
                        <td><label for="draft_text">仮登録完了用表示テキスト</label></td>
                        <td><textarea id="draft_text" name="draft_text" class="form-control">{{ $eventfinish->draft_text }}</textarea></td>
                    </tr>
                    <tr>
                        <td><label for="finish_text">申込完了用表示テキスト</label></td>
                        <td><textarea id="finish_text" name="finish_text" class="form-control">{{ $eventfinish->finish_text }}</textarea></td>
                    </tr>
                </table>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </div>
    </form>
@endsection
