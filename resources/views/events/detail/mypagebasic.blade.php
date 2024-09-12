@extends('adminlte::page')

@section('title', 'マイページ基本設定 | イベント来場管理システム')

@section('content_header')
    <h1>マイページ基本設定</h1>
@endsection

@section('content')
    <form action="{{ route('eventmypagebasic.update', $event->id) }}" method="POST" enctype="multipart/form-data">
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
                    マイページの基本設定を行います。<br>各項目に必要な情報を入力してください。
                </p>

                <table class="table table-bordered event-setting-table">
                    <tr>
                        <th>項目名</th>
                        <th>入力内容</th>
                    </tr>
                    <tr>
                        <td><label for="endtime">終了時間</label></td>
                        <td><input type="datetime-local" id="endtime" name="endtime" class="form-control" value="{{ $eventmypagebasic->endtime }}"></td>
                    </tr>
                    <tr>
                        <td><label for="image">画像</label></td>
                        <td>
                            @if ($eventmypagebasic->image)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($eventmypagebasic->image) }}" alt="マイページ画像" style="max-width: 350px; margin:0px 0px 20px 0px;">
                                </div>
                            @else
                                <img src="{{ asset('images/no-image.png') }}" style="max-width: 350px; margin:0px 0px 20px 0px;" alt="Logo">
                            @endif
                            <input type="file" id="image" name="image" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="title">お知らせタイトル</label></td>
                        <td><input type="text" id="title" name="title" class="form-control" value="{{ $eventmypagebasic->title }}"></td>
                    </tr>
                    <tr>
                        <td><label for="text">お知らせ内容</label></td>
                        <td><textarea id="text" name="text" class="form-control">{{ $eventmypagebasic->text }}</textarea></td>
                    </tr>
                </table>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </div>
    </form>
@endsection
