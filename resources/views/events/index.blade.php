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
                    <h3 class="card-title"><b>{{ $event->name }}</b></h3>
                </div>
                <div class="card-body">

                    <h2 class="text-lg font-medium text-gray-900">
                        開催日
                    </h2>
                    
                    <ul class="eventdate-ul">
                        @php
                            $eventDates = json_decode($event->event_date, true); // JSONをデコード
                        @endphp
                        @foreach ($eventDates as $date)
                            <li>
                                {{ $date['date'] }} {{ $date['starttime'] }}～{{ $date['endtime'] }}
                            </li>
                        @endforeach
                    </ul>


                    <table class="table">
                        <tbody>
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->name }}</td>
                                <td>{{ $event->organization }}</td>
                                <td>{{ $event->place }}</td>
                                <td>
                                    <ul>
                                        @php
                                            $eventDates = json_decode($event->event_date, true); // JSONをデコード
                                        @endphp
                                        @foreach ($eventDates as $date)
                                            <li>
                                                日付: {{ $date['date'] }}<br>
                                                開始: {{ $date['starttime'] }}<br>
                                                終了: {{ $date['endtime'] }}
                                            </li>
                                        @endforeach
                                    </ul>


                                </td>
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


