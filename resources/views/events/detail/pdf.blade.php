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
                    <input type="file" name="image" id="image" class="form-control" required>
                </div>
                <p class="small">推奨サイズ1447px x 2046px 最大サイズ：5MB</p>
                <button type="submit" class="btn btn-primary">アップロード</button>
            </form>
            
        </div>
    </div>
@stop

