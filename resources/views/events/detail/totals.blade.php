@extends('adminlte::page')

@section('title', '申込来場者集計 | イベント来場管理システム')

@section('content_header')
    <h1>申込来場者集計</h1>
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

                    const dailyData = @json($eventUsers->groupBy(function ($date) {
                        return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d');
                    })->map->count()->sortKeys());

                    const weeklyData = @json($eventUsers->groupBy(function ($date) {
                        return \Carbon\Carbon::parse($date->created_at)->format('o-W');
                    })->map->count()->sortKeys());

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

            <div class="form-group" style="max-width: 320px;">
                <label for="dateSelect"><b>日付を選択</b></label>
                <select id="dateSelect" class="form-control">
                    @forelse ($availableDates as $d)
                        <option value="{{ $d }}">{{ $d }}</option>
                    @empty
                        <option value="">対象日なし</option>
                    @endforelse
                </select>
            </div>

            <canvas id="entryExitChart" width="400" height="200"></canvas>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const eventRecords = @json($eventRecords);
                    const availableDates = @json($availableDates);

                    // 日付ごとに時間別（0〜23時）の入退場件数を集計
                    const emptyHours = () => ({ entry: new Array(24).fill(0), exit: new Array(24).fill(0) });
                    const hourlyByDate = {};
                    availableDates.forEach(d => { hourlyByDate[d] = emptyHours(); });
                    eventRecords.forEach(record => {
                        const m = moment(record.created_at);
                        const date = m.format('YYYY-MM-DD');
                        const hour = m.hour();
                        if (!hourlyByDate[date]) hourlyByDate[date] = emptyHours();
                        if (record.entry_exit === 1) hourlyByDate[date].entry[hour] += 1;
                        else if (record.entry_exit === 2) hourlyByDate[date].exit[hour] += 1;
                    });

                    const labels = Array.from({ length: 24 }, (_, i) => i + '時');
                    const initialDate = availableDates[0] || null;
                    const initial = initialDate ? hourlyByDate[initialDate] : emptyHours();

                    const ctx = document.getElementById('entryExitChart').getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: '入場者数',
                                data: initial.entry,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                            }, {
                                label: '退場者数',
                                data: initial.exit,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                fill: true,
                            }]
                        },
                        options: {
                            scales: {
                                x: { title: { display: true, text: '時間帯' } },
                                y: { beginAtZero: true, ticks: { precision: 0 } }
                            }
                        }
                    });

                    const select = document.getElementById('dateSelect');
                    if (select) {
                        select.addEventListener('change', function () {
                            const data = hourlyByDate[this.value] || emptyHours();
                            chart.data.datasets[0].data = data.entry;
                            chart.data.datasets[1].data = data.exit;
                            chart.update();
                        });
                    }
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

            {{-- 登録ユーザー／QRユーザー別の内訳 --}}
            @php $total = $totals[0] ?? []; @endphp
            <h3 style="margin-top:30px; font-size:1.1rem;">入退場の内訳（登録ユーザー／QRユーザー）</h3>
            <table class="total-table table table-bordered" style="margin-top:10px;">
                <thead>
                    <tr>
                        <th>区分</th>
                        <th>入場数</th>
                        <th>退場数</th>
                        <th>現在会場にいる人数</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>登録ユーザー</td>
                        <td>{{ number_format($total['registered_entry_count'] ?? 0) }}</td>
                        <td>{{ number_format($total['registered_exit_count'] ?? 0) }}</td>
                        <td>{{ number_format($total['in_venue_registered'] ?? 0) }}</td>
                    </tr>
                    <tr>
                        <td>QRユーザー</td>
                        <td>{{ number_format($total['qr_entry_count'] ?? 0) }}</td>
                        <td>{{ number_format($total['qr_exit_count'] ?? 0) }}</td>
                        <td>{{ number_format($total['in_venue_qr'] ?? 0) }}</td>
                    </tr>
                    <tr style="font-weight:bold;">
                        <td>合計</td>
                        <td>{{ number_format($total['entry_count'] ?? 0) }}</td>
                        <td>{{ number_format($total['exit_count'] ?? 0) }}</td>
                        <td>{{ number_format(($total['in_venue_registered'] ?? 0) + ($total['in_venue_qr'] ?? 0)) }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

@endsection
