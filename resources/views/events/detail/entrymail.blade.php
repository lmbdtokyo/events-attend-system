@extends('adminlte::page')

@section('title', '申込完了メール設定 | イベント来場管理システム')

@section('content_header')
    <h1>申込完了メール設定</h1>
@endsection

@section('content')
    <form action="{{ route('evententrymail.update', $event->id) }}" method="POST">
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
                    申込完了メールの設定を行います。<br>各項目に必要な情報を入力してください。
                </p>

                <table class="table table-bordered event-setting-table">
                    <tr>
                        <th>項目名</th>
                        <th>入力内容</th>
                    </tr>
                    <tr>
                        <td><label for="bcc">BCC</label></td>
                        <td>
                            <input type="text" id="bcc" name="bcc" class="form-control" value="{{ $evententrymail->bcc }}">
                            <p class="small">※BCCはカンマ区切りで複数のメールアドレスを入力できます。</p>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="title">メールタイトル</label></td>
                        <td><input type="text" id="title" name="title" class="form-control" value="{{ $evententrymail->title }}"></td>
                    </tr>
                    <tr>
                        <td><label for="text">メール本文</label></td>
                        <td><textarea id="text" name="text" class="form-control">{{ $evententrymail->text }}</textarea></td>
                    </tr>
                </table>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </div>
    </form>
@endsection
