@extends('adminlte::page')

@section('title', '退場メール設定 | イベント来場管理システム')

@section('content_header')
    <h1>退場メール設定</h1>
@endsection

@section('content')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <form id="form" action="{{ route('eventexitmail.update', $event->id) }}" method="POST">
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
                    退場メールの設定を行います。<br>各項目に必要な情報を入力してください。
                </p>

                <table class="table table-bordered event-setting-table">
                    <tr>
                        <th>項目名</th>
                        <th>入力内容</th>
                    </tr>
                    <tr>
                        <td><label for="bcc">BCC</label></td>
                        <td>
                            <input type="text" id="bcc" name="bcc" class="form-control" value="{{ $eventexitmail->bcc }}">
                            <p class="small">※BCCはカンマ区切りで複数のメールアドレスを入力できます。</p>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="title">メールタイトル</label></td>
                        <td><input type="text" id="title" name="title" class="form-control" value="{{ $eventexitmail->title }}"></td>
                    </tr>
                    <tr>
                        <td><label for="text">メール本文</label></td>
                        <td>
                            <div id="text_editor" style="height: 300px;"></div>
                            <input type="hidden" name="text" id="text">
                        </td>
                    </tr>
                </table>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        var quillText = new Quill('#text_editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });

        @if(isset($eventexitmail) && $eventexitmail->text)
            quillText.root.innerHTML = `{!! addslashes($eventexitmail->text) !!}`;
        @endif

        document.querySelector('#form').onsubmit = function() {
            var textContent = document.querySelector('#text');
            textContent.value = quillText.root.innerHTML;
        };
    </script>
@endsection
