@extends('adminlte::page')

@section('title', 'イベント詳細 | イベント来場管理システム')

@section('content_header')
    <h1></h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title event-title"><b>{{ $event->name }}</b></h2>
        </div>
        <div class="card-body">

            <h2 class="text-lg font-medium text-gray-900">事前設定進捗</h2>

            
            
            <div class="row">
                <div class="col-md-6">
                    <table class="event-progress-table table table-bordered">
                        <tbody>
                            <tr>
                                <td style="width: 80%; vertical-align: middle;">申込フォーム基本設定</th>
                                <td style="width: 20%; text-align: center;">
                                    <a href="" class="btn btn-primary">編集</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 80%; vertical-align: middle;">申込フォーム項目設定</th>
                                <td style="width: 20%; text-align: center;">
                                    <a href="" class="btn btn-primary">編集</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 80%; vertical-align: middle;">マイページ基本設定</th>
                                <td style="width: 20%; text-align: center;">
                                    <a href="" class="btn btn-primary">編集</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="event-progress-table table table-bordered">
                        <tbody>
                            <tr>
                                <td style="width: 80%; vertical-align: middle;">申込完了メール</th>
                                <td style="width: 20%; text-align: center;">
                                    <a href="" class="btn btn-primary">編集</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 80%; vertical-align: middle;">入場時本人メール設定</th>
                                <td style="width: 20%; text-align: center;">
                                    <a href="" class="btn btn-primary">編集</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 80%; vertical-align: middle;">退場時本人メール設定</th>
                                <td style="width: 20%; text-align: center;">
                                    <a href="" class="btn btn-primary">編集</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>



            <h2 class="text-lg font-medium text-gray-900" style="margin-top: 50px;">イベント基本情報</h2>

            <table class="event-detail-table table table-bordered">
                <tbody>
                    <tr>
                        <th>開催組織</th>
                        <td>{{ \App\Models\Usersorganization::find($event->organization)->name }}</td>
                    </tr>
                    <tr>
                        <th>開催場所</th>
                        <td>{{ $event->place }}</td>
                    </tr>
                    <tr>
                        <th>開催日時</th>
                        <td>
                            <ul class="list-unstyled">
                            @foreach (json_decode($event->event_date, true) as $date)
                                <li>
                                    {{ $date['date'] }} {{ \Carbon\Carbon::parse($date['starttime'])->format('H:i') }}～{{ \Carbon\Carbon::parse($date['endtime'])->format('H:i') }}
                                </li>
                            @endforeach
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th>承認</th>
                        <td>{{ $event->approval == 0 ? 'なし' : 'あり' }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4">
                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary">基本情報編集</a>
                <a href="{{ route('events.index') }}" class="btn btn-secondary">戻る</a>
            </div>
        </div>
    </div>
@endsection
