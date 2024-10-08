@extends('adminlte::page')

@section('title', '申込完了画面設定 | イベント来場管理システム')

@section('content_header')
    <h1>申込完了画面設定</h1>
@endsection

@section('content')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <form id="form" action="{{ route('eventfinish.update', $event->id) }}" method="POST">
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
                        <td>
                            <div id="draft_text_editor" style="height: 300px;"></div>
                            <input type="hidden" name="draft_text" id="draft_text">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="finish_text">申込完了用表示テキスト</label></td>
                        <td>
                            <div id="finish_text_editor" style="height: 300px;"></div>
                            <input type="hidden" name="finish_text" id="finish_text">
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
        var quillDraft = new Quill('#draft_text_editor', {
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

        var quillFinish = new Quill('#finish_text_editor', {
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

        @if(isset($eventfinish) && $eventfinish->draft_text)
            quillDraft.root.innerHTML = `{!! addslashes($eventfinish->draft_text) !!}`;
        @endif

        @if(isset($eventfinish) && $eventfinish->finish_text)
            quillFinish.root.innerHTML = `{!! addslashes($eventfinish->finish_text) !!}`;
        @endif

        document.querySelector('#form').onsubmit = function() {
            var draftContent = document.querySelector('#draft_text');
            draftContent.value = quillDraft.root.innerHTML;

            var finishContent = document.querySelector('#finish_text');
            finishContent.value = quillFinish.root.innerHTML;
        };
    </script>
@endsection
