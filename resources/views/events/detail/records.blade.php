@extends('adminlte::page')

@php
    $isEntry = ($exitEntry ?? request()->route('exit_entry')) == 1;
    $pageTitle = $isEntry ? '入場記録' : '退場記録';
@endphp

@section('title', $pageTitle . ' | イベント来場管理システム')

@section('content_header')
    <h1>{{ $pageTitle }}</h1>
@endsection

@section('content')
<div class="mb-3">
    <a href="{{ route('event.users', $event->id) }}" class="btn btn-sm btn-outline-dark">全申込者一覧</a>
    <a href="{{ route('event.records', ['event' => $event->id, 'exit_entry' => 1]) }}"
       class="btn btn-sm {{ $isEntry ? 'btn-primary' : 'btn-outline-primary' }}">入場記録</a>
    <a href="{{ route('event.records', ['event' => $event->id, 'exit_entry' => 2]) }}"
       class="btn btn-sm {{ $isEntry ? 'btn-outline-primary' : 'btn-primary' }}">退場記録</a>
    <a href="{{ route('event.in_venue', $event->id) }}" class="btn btn-sm btn-outline-info">現在会場にいる人</a>
    <a href="{{ route('events.exit_entry_totals', $event->id) }}" class="btn btn-sm btn-outline-secondary">集計</a>
</div>

<div class="card">
    <div class="card-body">

        {{-- 絞り込みフォーム（日付・検索） --}}
        <form method="GET" action="{{ route('event.records', ['event' => $event->id, 'exit_entry' => $isEntry ? 1 : 2]) }}" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">日付</label>
                    <select name="date" class="form-control">
                        <option value="">すべての日付</option>
                        @foreach($availableDates as $date)
                            <option value="{{ $date }}" {{ ($selectedDate ?? '') === $date ? 'selected' : '' }}>{{ $date }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    @php $labelText = implode('・', $searchLabels ?? ['ID','名前','フリガナ','会社名']); @endphp
                    <label class="form-label">検索（{{ $labelText }}）</label>
                    <input type="text" name="search" class="form-control" placeholder="スペース区切りで複合検索ができます（例：山田 {{ ($eventsetting && !empty($eventsetting->company_display_name)) ? $eventsetting->company_display_name : '会社名' }}）" value="{{ $search ?? '' }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">検索</button>
                    @if(($search ?? '') !== '' || !empty($selectedDate))
                        <a href="{{ route('event.records', ['event' => $event->id, 'exit_entry' => $isEntry ? 1 : 2]) }}" class="btn btn-secondary">クリア</a>
                    @endif
                </div>
            </div>
        </form>

        <p class="mb-3">
            <strong>{{ $isEntry ? '入場' : '退場' }}件数: {{ number_format($eventEntries->total()) }}件</strong>
            <span class="text-muted ml-2">（登録ユーザー: {{ number_format($registeredCount ?? 0) }}件 ／ QRユーザー: {{ number_format($qrCount ?? 0) }}件）</span>
            @if(($search ?? '') !== '' || !empty($selectedDate))
                <span class="text-muted">※絞り込み結果</span>
            @endif
        </p>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        @php
                            $nameLabel = ($eventsetting && !empty($eventsetting->name_display_name)) ? $eventsetting->name_display_name : '名前';
                            $companyLabel = ($eventsetting && !empty($eventsetting->company_display_name)) ? $eventsetting->company_display_name : '会社名';
                        @endphp
                        <th style="width: 100px;">ID</th>
                        <th>{{ $nameLabel }}</th>
                        <th>{{ $companyLabel }}</th>
                        <th style="width: 220px;">{{ $isEntry ? '入場時間' : '退場時間' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($eventEntries as $record)
                        @php $recordUser = $eventUsers->find($record->applicant_id); @endphp
                        <tr>
                            <td>{{ optional($recordUser)->id ?? '' }}</td>
                            <td>{{ optional($recordUser)->name ?? 'QRユーザー' }}</td>
                            <td>{{ optional($recordUser)->company ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->created_at)->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">該当する記録はありません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $eventEntries->links() }}
        </div>
    </div>
</div>
@endsection
