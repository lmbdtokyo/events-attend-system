@extends('adminlte::page')

@section('title', '来場者一覧 | イベント来場管理システム')

@section('content_header')
    <h1>申込者一覧</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
<div class="row">
    @if(request()->route('exit_entry') == 1)
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">入場記録</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 100px;">ID</th>
                            <th>名前</th>
                            <th>入場時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($eventEntries)
                            @foreach($eventEntries as $record)
                            <tr>
                                <td>{{ $eventUsers->find($record->applicant_id)->id ?? '' }}</td>
                                <td>{{ $eventUsers->find($record->applicant_id)->name ?? 'QRユーザー' }}</td>
                                <td>{{ $record->created_at }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $eventEntries->links() }}
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">退場記録</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 100px;">ID</th>
                            <th>名前</th>
                            <th>退場時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($eventEntries)
                            @foreach($eventEntries as $record)
                            <tr>
                                <td>{{ $eventUsers->find($record->applicant_id)->id ?? '' }}</td>
                                <td>{{ $eventUsers->find($record->applicant_id)->name ?? 'QRユーザー' }}</td>
                                <td>{{ $record->created_at }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $eventEntries->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
</div>
</div>
@endsection
