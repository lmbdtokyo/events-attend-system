@extends('adminlte::page')

@section('title', '申込者承認 | イベント来場管理システム')

@section('content_header')
    <h1>申込者承認</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

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

            @if($eventUsers->isEmpty())
                <p>申込者がいません。</p>
            @else
                <ul class="nav nav-tabs" id="approvalTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#approval0">未承認</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#approval1">承認済み</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#approval2">却下</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="approval0">
                        @if($eventUsers->where('approval', 0)->isEmpty())
                            <p>未承認の申込者がいません。</p>
                        @else
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
                                        <th>登録日</th>
                                        <th>承認</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($eventUsers->where('approval', 0) as $eventUser)
                                        <tr>
                                            <td>{{ $eventUser->id }}</td>
                                            <td>{{ $eventUser->name }}</td>
                                            <td>{{ $eventUser->furigana }}</td>
                                            <td>{{ $eventUser->company }}</td>
                                            <td>{{ $eventUser->division }}</td>
                                            <td>{{ $eventUser->post }}</td>
                                            <td>{{ $eventUser->mail }}</td>
                                            <td>{{ \Carbon\Carbon::parse($eventUser->created_at)->format('Y-m-d') }}</td>
                                            <td>
                                                <form action="{{ route('event.approval.update', [$event->id, $eventUser->id]) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="eventuser_id" value="{{ $eventUser->id }}">
                                                    <button type="submit" name="approval" value="1" class="btn btn-success btn-sm">承認</button>
                                                    <button type="submit" name="approval" value="2" class="btn btn-danger btn-sm">非承認</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="approval1">
                        @if($eventUsers->where('approval', 1)->isEmpty())
                            <p>承認済みの申込者がいません。</p>
                        @else
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
                                        <th>登録日</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($eventUsers->where('approval', 1) as $eventUser)
                                        <tr>
                                            <td>{{ $eventUser->id }}</td>
                                            <td>{{ $eventUser->name }}</td>
                                            <td>{{ $eventUser->furigana }}</td>
                                            <td>{{ $eventUser->company }}</td>
                                            <td>{{ $eventUser->division }}</td>
                                            <td>{{ $eventUser->post }}</td>
                                            <td>{{ $eventUser->mail }}</td>
                                            <td>{{ \Carbon\Carbon::parse($eventUser->created_at)->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="approval2">
                        @if($eventUsers->where('approval', 2)->isEmpty())
                            <p>却下された申込者がいません。</p>
                        @else
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
                                        <th>登録日</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($eventUsers->where('approval', 2) as $eventUser)
                                        <tr>
                                            <td>{{ $eventUser->id }}</td>
                                            <td>{{ $eventUser->name }}</td>
                                            <td>{{ $eventUser->furigana }}</td>
                                            <td>{{ $eventUser->company }}</td>
                                            <td>{{ $eventUser->division }}</td>
                                            <td>{{ $eventUser->post }}</td>
                                            <td>{{ $eventUser->mail }}</td>
                                            <td>{{ \Carbon\Carbon::parse($eventUser->created_at)->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            @endif
            <div class="d-flex justify-content-center">
                {{ $eventUsers->links() }}
            </div>
        </div>
    </div>
@endsection
