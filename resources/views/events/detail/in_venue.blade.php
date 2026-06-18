@extends('adminlte::page')

@section('title', '現在会場にいる人 | イベント来場管理システム')

@section('content_header')
    <h1>現在会場にいる人</h1>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="mb-3">
    <a href="{{ route('event.records', ['event' => $event->id, 'exit_entry' => 1]) }}" class="btn btn-sm btn-outline-primary">入場記録</a>
    <a href="{{ route('event.records', ['event' => $event->id, 'exit_entry' => 2]) }}" class="btn btn-sm btn-outline-primary">退場記録</a>
    <a href="{{ route('event.in_venue', $event->id) }}" class="btn btn-sm btn-info">現在会場にいる人</a>
    <a href="{{ route('events.exit_entry_totals', $event->id) }}" class="btn btn-sm btn-outline-secondary">集計</a>
</div>

<div class="card">
    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="alert alert-info mb-2">
                    <strong>現在会場にいる人数</strong>
                    <span class="float-right">{{ number_format($registeredCount + $qrCount) }}名</span>
                </div>
                <small class="text-muted">
                    登録ユーザー {{ number_format($registeredCount) }}名 ／ QRユーザー {{ number_format($qrCount) }}名
                </small>
            </div>
        </div>

        {{-- 検索フォーム（ID・名前・フリガナ） --}}
        <form method="GET" action="{{ route('event.in_venue', $event->id) }}" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-8">
                    <label class="form-label">検索（ID・名前・フリガナ）</label>
                    <input type="text" name="search" class="form-control" placeholder="ID、名前、フリガナで検索" value="{{ $search ?? '' }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">検索</button>
                    @if(($search ?? '') !== '')
                        <a href="{{ route('event.in_venue', $event->id) }}" class="btn btn-secondary">クリア</a>
                    @endif
                </div>
            </div>
        </form>

        {{-- 登録ユーザー（入場中） --}}
        <h3 class="mt-2" style="font-size:1.1rem;">登録ユーザー（{{ number_format($inVenueUsers->count()) }}名）</h3>
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 100px;">ID</th>
                        <th>名前</th>
                        <th>フリガナ</th>
                        <th style="width: 220px;">最終入場時間</th>
                        <th style="width: 120px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inVenueUsers as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->furigana }}</td>
                            <td>
                                @if(isset($lastEntryByUser[$user->id]))
                                    {{ \Carbon\Carbon::parse($lastEntryByUser[$user->id])->format('Y-m-d H:i:s') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('event.in_venue.exit_user', ['event' => $event->id, 'eventuser' => $user->id]) }}"
                                      onsubmit="return confirm('{{ $user->name }} さんを退場にしますか？');" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">退場</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                {{ ($search ?? '') !== '' ? '該当するユーザーはいません。' : '現在会場にいる登録ユーザーはいません。' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- QRユーザー（入場中）。検索時は非表示 --}}
        @if(($search ?? '') === '')
            <h3 class="mt-2" style="font-size:1.1rem;">QRユーザー（{{ number_format($inVenueQrs->count()) }}名）</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>QR-ID</th>
                            <th style="width: 120px;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inVenueQrs as $qr)
                            <tr>
                                <td>{{ $qr->qr_id }}</td>
                                <td>
                                    <form method="POST" action="{{ route('event.in_venue.exit_qr', ['event' => $event->id, 'eventqr' => $qr->id]) }}"
                                          onsubmit="return confirm('QR（{{ $qr->qr_id }}）を退場にしますか？');" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">退場</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">現在会場にいるQRユーザーはいません。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</div>
@endsection
