@extends('adminlte::page')

@section('title', '申込来場者集計 | イベント来場管理システム')

@section('content_header')
    <h1>申込来場者集</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><b>申込者集計</b></h2>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="chart">
                        <canvas id="dailyChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
                    const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');

                    const dailyData = @json($eventUsers->groupBy(function($date) {
                        return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d');
                    })->map->count());

                    const weeklyData = @json($eventUsers->groupBy(function($date) {
                        return \Carbon\Carbon::parse($date->created_at)->format('o-W');
                    })->map->count());

                    new Chart(dailyCtx, {
                        type: 'line',
                        data: {
                            labels: Object.keys(dailyData),
                            datasets: [{
                                label: '日別申込者数',
                                data: Object.values(dailyData),
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    type: 'time',
                                    time: {
                                        unit: 'day',
                                        parser: 'YYYY-MM-DD'
                                    }
                                }
                            }
                        }
                    });

                    new Chart(weeklyCtx, {
                        type: 'line',
                        data: {
                            labels: Object.keys(weeklyData),
                            datasets: [{
                                label: '週別申込者数',
                                data: Object.values(weeklyData),
                                borderColor: 'rgba(153, 102, 255, 1)',
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                fill: true,
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    type: 'time',
                                    time: {
                                        unit: 'week',
                                        parser: 'GGGG-[W]WW'
                                    }
                                }
                            }
                        }
                    });

                    // イベントの期間を表示
                    const eventStart = @json($eventBasic->start);
                    const eventEnd = @json($eventBasic->end);

                    const eventPeriod = document.createElement('p');
                    eventPeriod.textContent = `申込期間: ${eventStart} から ${eventEnd} まで`;
                    document.querySelector('.card-body').prepend(eventPeriod);
                });
            </script>

            <table class="total-table table table-bordered" style="margin-top:20px;">
                <thead>
                    <tr>
                        <th>申込者数</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($totals as $total)
                        <tr>
                            <td>
                                @if ($total['user_count'] != 0)
                                    <a href="{{ url('/events/' . $event->id . '/users') }}">{{ $total['user_count'] }}</a>
                                @else
                                    {{ $total['user_count'] }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><b>来場者集計</b></h2>
        </div>
        <div class="card-body">

            <canvas id="entryExitChart" width="400" height="200"></canvas>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const eventRecords = @json($eventRecords);

                    const entryData = [];
                    const exitData = [];

                    eventRecords.forEach(record => {
                        const date = moment(record.created_at).format('YYYY-MM-DD');
                        if (record.entry_exit === 1) {
                            const existingEntry = entryData.find(data => data.x === date);
                            if (existingEntry) {
                                existingEntry.y += 1;
                            } else {
                                entryData.push({ x: date, y: 1 });
                            }
                        } else if (record.entry_exit === 2) {
                            const existingExit = exitData.find(data => data.x === date);
                            if (existingExit) {
                                existingExit.y += 1;
                            } else {
                                exitData.push({ x: date, y: 1 });
                            }
                        }
                    });

                    const ctx = document.getElementById('entryExitChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            datasets: [{
                                label: '入場者数',
                                data: entryData,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                            }, {
                                label: '退場者数',
                                data: exitData,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                fill: true,
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    type: 'time',
                                    time: {
                                        unit: 'day',
                                        parser: 'YYYY-MM-DD'
                                    }
                                }
                            }
                        }
                    });
                });
            </script>

            <table class="total-table table table-bordered" style="margin-top:20px;">
                <thead>
                    <tr>
                        <th>入場数</th>
                        <th>退場数</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($totals as $total)
                        <tr>
                            <td><a href="{{ route('event.records', ['event' => $event->id, 'exit_entry' => 1]) }}">{{ $total['entry_count'] }}</a></td>
                            <td><a href="{{ route('event.records', ['event' => $event->id, 'exit_entry' => 2]) }}">{{ $total['exit_count'] }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection
