@extends('adminlte::page')

@section('title', '申込者一覧 | イベント来場管理システム')

@section('content_header')
    <h1>申込者一覧</h1>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('event.users', $event) }}" class="mb-4">
                <div class="row g-2 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label">検索（名前・会社名・メールアドレス）</label>
                        <input type="text" name="search" class="form-control" placeholder="名前、会社名、メールアドレスで検索" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">検索</button>
                        @if(request('search'))
                            <a href="{{ route('event.users', $event) }}" class="btn btn-secondary">クリア</a>
                        @endif
                    </div>
                </div>
            </form>

            <p class="mb-3">
                <strong>トータル: {{ number_format($totalCount) }}名</strong>
                @if(request('search'))
                    <span class="text-muted">（検索結果: {{ number_format($totalCount) }}名）</span>
                @endif
                <a href="{{ route('event.users.export', array_merge(['event' => $event], request()->only('search'))) }}" class="btn btn-success btn-sm ml-2">CSVダウンロード</a>
            </p>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>名前</th>
                            <th>フリガナ</th>
                            <th>会社名</th>
                            <th>部署</th>
                            <th>役職</th>
                            <th>メールアドレス</th>
                            <th>受付区分</th>
                            <th>登録日</th>
                            <th>PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eventUsers as $eventUser)
                            <tr>
                                <td>{{ $eventUser->id }}</td>
                                <td>
                                    @if(optional($authUser)->type === 'master')
                                        <a href="{{ route('event.users.edit', [$event, $eventUser]) }}">{{ $eventUser->name }}</a>
                                    @else
                                        {{ $eventUser->name }}
                                    @endif
                                </td>
                                <td>{{ $eventUser->furigana }}</td>
                                <td>{{ $eventUser->company }}</td>
                                <td>{{ $eventUser->division }}</td>
                                <td>{{ $eventUser->post }}</td>
                                <td>{{ $eventUser->mail }}</td>
                                <td>
                                    @isset($eventSections[$eventUser->section])
                                        {{ $eventSections[$eventUser->section]->name }}
                                    @else
                                        -
                                    @endisset
                                </td>
                                <td>{{ \Carbon\Carbon::parse($eventUser->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    @if($eventUser->pdf_name && $eventUser->qr)
                                        <a href="{{ asset('storage/pdfs/' . $eventUser->qr . '.pdf') }}" target="_blank" class="btn btn-sm btn-outline-primary">PDF</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">申込者がいません</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $eventUsers->links() }}
            </div>
        </div>
    </div>
@endsection
