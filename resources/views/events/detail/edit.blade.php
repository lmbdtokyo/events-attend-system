
@extends('adminlte::page')

@section('title', '申込フォーム基本情報編集 | イベント来場管理システム')

@section('content_header')
    <h1>申込フォーム基本情報編集</h1>
@endsection

@section('content')


<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>


<form id="form" method="POST" action="{{ route('eventbasic.update', $eventbasic->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="card">
        <div class="card-body">

            <div>
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
            </div>

            <table class="basic-table">
                <tr>
                    <th><label for="title">フォームのタイトル</label></th>
                    <td><input type="text" id="title" name="title" class="form-control" value="{{ $eventbasic->title ?? '' }}"></td>
                </tr>
                <tr>
                    <th><label for="image">画像</label></th>
                    <td>
                        @if ($eventbasic->image)
                            <img src="{{ asset('storage/images/' . basename($eventbasic->image)) }}" alt="Event Image" style="max-width: 500px; margin:0px 0px 20px 0px;">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" style="max-width: 500px; margin:0px 0px 20px 0px;" alt="Logo">
                        @endif
                        <input type="file" id="image" name="image" class="form-control">
                        @if ($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                        <p class="small" style="margin-top:10px;">推奨サイズ : 1280px x 400px 最大容量 : 5MB</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="limit">受付人数制限</label></th>
                    <td>
                        <input type="radio" id="limit_no" name="limit" value="0" {{ $eventbasic->limit == 0 ? 'checked' : '' }}> しない
                        <input type="radio" id="limit_yes" name="limit" value="1" {{ $eventbasic->limit == 1 ? 'checked' : '' }}> する
                    </td>
                </tr>
                <tr id="limit_number_row" style="display: {{ $eventbasic->limit == 1 ? 'table-row' : 'none' }}">
                    <th><label for="limit_number">制限数</label></th>
                    <td><input type="number" id="limit_number" name="limit_number" class="form-control" value="{{ $eventbasic->limit_number ?? '' }}"></td>
                </tr>
                <tr>
                    <th><label for="start">申込受付開始日時:</label></th>
                    <td><input type="datetime-local" id="start" name="start" class="form-control" value="{{ $eventbasic->start ?? '' }}"></td>
                </tr>
                <tr>
                    <th><label for="end">申込受付終了日時:</label></th>
                    <td><input type="datetime-local" id="end" name="end" class="form-control" value="{{ $eventbasic->end ?? '' }}"></td>
                </tr>
                <tr>
                    <th><label for="overview_title">概要タイトル</label></th>
                    <td><input type="text" id="overview_title" name="overview_title" class="form-control" value="{{ $eventbasic->overview_title ?? '' }}"></td>
                </tr>
                <tr>
                    <th><label for="overview_text">概要テキスト</label></th>
                    <td>
                        <div id="overview_text_form" style="height: 300px;"></div>
                        <input type="hidden" name="overview_text" id="overview_text">
                    </td>
                </tr>
                <tr>
                    <th><label for="terms">利用規約</label></th>
                    <td>
                        <div id="terms_form" style="height: 300px;"></div>
                        <input type="hidden" name="terms" id="terms">
                    </td>
                </tr>
                <tr>
                    <th><label for="privacy">プライバシーポリシー</label></th>
                    <td>
                        <div id="privacy_form" style="height: 300px;"></div>
                        <input type="hidden" name="privacy" id="privacy">
                    </td>
                </tr>
            </table>

            <input type="hidden" name="event_id" value="{{ $eventbasic->event_id }}">
            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">編集完了</button>
            </div>

        </div>
    </div>
    
</form>


<script>
    var quill = new Quill('#overview_text_form', {
        theme: 'snow', 
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3 , false] }],
                ['bold', 'italic', 'underline'],
                ['link'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['clean'] 
            ]
        }
    });

    var quillTerms = new Quill('#terms_form', {
                        theme: 'snow', 
                        modules: {
                            toolbar: [
                                [{ 'header': [1, 2, 3 , false] }],
                                ['bold', 'italic', 'underline'],
                                ['link'],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                ['clean'] 
                            ]
                        }
                    });



                    var quillPrivacy = new Quill('#privacy_form', {
                        theme: 'snow', 
                        modules: {
                            toolbar: [
                                [{ 'header': [1, 2, 3 , false] }],
                                ['bold', 'italic', 'underline'],
                                ['link'],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                ['clean'] 
                            ]
                        }
                    });

    @if(isset($eventbasic) && $eventbasic->overview_text)
        quill.root.innerHTML = `{!! addslashes($eventbasic->overview_text) !!}`;
        quillTerms.root.innerHTML = `{!! addslashes($eventbasic->terms) !!}`; 
        quillPrivacy.root.innerHTML = `{!! addslashes($eventbasic->privacy) !!}`; 
    @endif

                    document.querySelector('#form').onsubmit = function() {
                        var content = document.querySelector('#overview_text');
                        content.value = quill.root.innerHTML;

                        var termsContent = document.querySelector('#terms');
                        termsContent.value = quillTerms.root.innerHTML;

                        var privacyContent = document.querySelector('#privacy');
                        privacyContent.value = quillPrivacy.root.innerHTML;
                    };
                </script>


</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const limitNo = document.getElementById('limit_no');
        const limitYes = document.getElementById('limit_yes');
        const limitNumberRow = document.getElementById('limit_number_row');
    
        function toggleLimitNumberRow() {
            if (limitYes.checked) {
                limitNumberRow.style.display = 'table-row';
            } else {
                limitNumberRow.style.display = 'none';
            }
        }
    
        limitNo.addEventListener('change', toggleLimitNumberRow);
        limitYes.addEventListener('change', toggleLimitNumberRow);
    
        // 初期状態の設定
        toggleLimitNumberRow();


    });
    </script>

@endsection

