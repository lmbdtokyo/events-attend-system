@extends('adminlte::page')

@section('title', 'イベント一覧 | イベント来場管理システム')

@section('content_header')
    <h1>イベント一覧</h1>
@endsection

@section('content')
    
            @if(count($events) > 0)

            @foreach($events as $event)

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $event->name }}</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>タイトル</th>
                                <th>所属組織</th>
                                <th>開催場所</th>
                                <th>開催日</th>
                                <th>承認制</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->name }}</td>
                                <td>{{ $event->organization }}</td>
                                <td>{{ $event->place }}</td>
                                <td>{{ $event->event_date }}</td>
                                <td>{{ $event->approval }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                            
            @endforeach

            @else

                <p>イベントがありません。</p>

            @endif

@endsection


