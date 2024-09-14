@extends('adminlte::page')

@section('title', 'QRコード生成イベント一覧')

@section('content_header')
    <h1>空QRコード生成履歴一覧</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">空QRコード生成履歴</h3>
            <div class="card-tools">
                <a href="{{ route('eventsgenerateqr.create', $event->id) }}" class="btn btn-primary">QRコード新規作成</a>
            </div>
        </div>
        <div class="card-body">
            @if ($eventGenerateQRs->isEmpty())
                <p>空QRコード生成履歴がありません。</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>作成日</th>
                            <th>QRコード数</th>
                            <th>PDFパス</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($eventGenerateQRs as $eventGenerateQR)
                            <tr>
                                <td>{{ $eventGenerateQR->created_at->format('Y-m-d') }}</td>
                                <td>{{ $eventGenerateQR->number }}</td>
                                <td><a href="{{ url($eventGenerateQR->pdf_path) }}" target="_blank">{{ $eventGenerateQR->pdf_path }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card-footer">
            {{ $eventGenerateQRs->links() }}
        </div>
    </div>
@stop