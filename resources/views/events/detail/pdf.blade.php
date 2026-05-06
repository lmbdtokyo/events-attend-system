@extends('adminlte::page')

@section('title', '来場証PDF用画像アップロード')

@section('content_header')
    <h1>来場証PDF用画像アップロード</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">画像アップロード</h3>
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

            <form action="{{ route('eventpdf.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="pdf">画像</label>
                    @if ($eventpdfimage && $eventpdfimage->image)
                        <div class="mb-3">
                            <img src="{{ Storage::url($eventpdfimage->image) }}" alt="Uploaded Image" style="max-width: 100%; height: auto;">
                        </div>
                    @else
                        <div class="mb-3">
                            <img src="{{ asset('images/no-image-pdf.png') }}" alt="No Image Available" style="width: 500px; height: auto;">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control">
                </div>
                <p class="small">推奨サイズ1447px x 2046px 最大サイズ：5MB（変更する場合のみ選択）</p>

                <hr>
                <h4 class="mb-3">空QRコードPDFの受付区分表示</h4>
                <div class="form-group">
                    <label for="empty_qr_section_label">バナー文言</label>
                    <input type="text"
                           name="empty_qr_section_label"
                           id="empty_qr_section_label"
                           class="form-control @error('empty_qr_section_label') is-invalid @enderror"
                           value="{{ old('empty_qr_section_label', $eventpdfimage->empty_qr_section_label ?? '受付区分名') }}"
                           placeholder="受付区分名"
                           maxlength="100">
                    @error('empty_qr_section_label')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="empty_qr_section_bg_color">バナー背景色（文字色は白固定）</label>
                    <input type="color"
                           name="empty_qr_section_bg_color"
                           id="empty_qr_section_bg_color"
                           class="form-control @error('empty_qr_section_bg_color') is-invalid @enderror"
                           value="{{ old('empty_qr_section_bg_color', $eventpdfimage->empty_qr_section_bg_color ?? '#ff0000') }}">
                    @error('empty_qr_section_bg_color')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">保存</button>
            </form>
            
        </div>
    </div>
@stop

