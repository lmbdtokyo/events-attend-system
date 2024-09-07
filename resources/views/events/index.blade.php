@extends('adminlte::page')

@section('title', 'イベント一覧 | イベント来場管理システム')

@section('content_header')
    <h1>イベント一覧</h1>
@endsection

@section('content')

<div class="text-right">
    <a href="{{ route('events.create') }}" class="btn btn-success mb-3">イベント新規作成</a>
</div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

    
            @if(count($events) > 0)

            @foreach($events as $event)

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title event-title"><b><a href="{{ route('events.show', $event->id) }}">{{ $event->name }}</a></b></h2>
                </div>
                <div class="card-body">

                    <table class="event-table">
                        <tbody>
                            <tr>
                                <th>イベント情報</th>
                                <th>開催日</th>
                                <th>承認</th>
                                <th>アクション</th>
                                
                            </tr>
                            <tr>
                                <td>
                                    <ul class="event-info-ul">
                                        <li>開催組織: {{ \App\Models\Usersorganization::find($event->organization)->name }}</li>
                                        <li>開催場所: {{ $event->place }}</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="eventdate-ul">
                                    @php
                                        $eventDates = json_decode($event->event_date, true); // JSONをデコード
                                    @endphp
                                    @foreach ($eventDates as $date)
                                        <li>
                                            {{ $date['date'] }} {{ \Carbon\Carbon::parse($date['starttime'])->format('H:i') }}～{{ \Carbon\Carbon::parse($date['endtime'])->format('H:i') }}
                                        </li>
                                    @endforeach
                                    </ul>
                                </td>
                                <td>{{ $event->approval == 0 ? 'なし' : 'あり' }}</td>
                                <td>
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary btn-sm event-btn">　　編集　　</a><br>
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-info btn-sm event-btn">事前設定進捗</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                            
            @endforeach

            @else

                <p>イベントがありません。</p>

            @endif

            {{ $events->links() }}

@endsection


