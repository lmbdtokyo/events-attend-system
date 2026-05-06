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



            @if(!$hasAnyApplicants)

                <p>申込者がいません。</p>

            @else

                <ul class="nav nav-tabs" id="approvalTabs">

                    <li class="nav-item">

                        <a class="nav-link active" data-toggle="tab" href="#approval0">未承認</a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" data-toggle="tab" href="#approval1">承認済み</a>

                    </li>

                </ul>



                <div class="tab-content">

                    <div class="tab-pane fade show active" id="approval0">

                        @if($pendingUsers->isEmpty())

                            <p>未承認の申込者がいません。</p>

                        @else

                            <table class="table table-bordered table-hover">

                                <thead>

                                    <tr>

                                        <th>ID</th>

                                        <th>名前</th>

                                        <th>フリガナ</th>

                                        <th>会社名</th>

                                        <th>受付区分</th>

                                        <th>メールアドレス</th>

                                        <th>電話番号</th>

                                        <th>登録日</th>

                                        <th>承認</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($pendingUsers as $eventUser)

                                        <tr>

                                            <td>{{ $eventUser->id }}</td>

                                            <td>{{ $eventUser->name }}</td>

                                            <td>{{ $eventUser->furigana }}</td>

                                            <td>{{ $eventUser->company }}</td>

                                            <td>

                                                @isset($eventSections[$eventUser->section])

                                                    {{ $eventSections[$eventUser->section]->name }}

                                                @else

                                                    -

                                                @endisset

                                            </td>

                                            <td>{{ $eventUser->mail }}</td>

                                            <td>{{ $eventUser->tel ?: '-' }}</td>

                                            <td>{{ \Carbon\Carbon::parse($eventUser->created_at)->format('Y-m-d') }}</td>

                                            <td>

                                                <form action="{{ route('event.approval.update', [$event->id, $eventUser->id]) }}" method="POST">

                                                    @csrf

                                                    @method('PATCH')

                                                    <input type="hidden" name="eventuser_id" value="{{ $eventUser->id }}">

                                                    @foreach(['pending_page', 'approved_page'] as $_qp)

                                                        @if(request()->filled($_qp))

                                                            <input type="hidden" name="{{ $_qp }}" value="{{ request($_qp) }}">

                                                        @endif

                                                    @endforeach

                                                    <button type="submit" name="approval" value="1" class="btn btn-success btn-sm">承認</button>

                                                    <button type="submit" name="approval" value="2" class="btn btn-danger btn-sm">非承認</button>

                                                </form>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                            <div class="d-flex justify-content-center">

                                {{ $pendingUsers->links() }}

                            </div>

                        @endif

                    </div>

                    <div class="tab-pane fade" id="approval1">

                        @if($approvedUsers->isEmpty())

                            <p>承認済みの申込者がいません。</p>

                        @else

                            <table class="table table-bordered table-hover">

                                <thead>

                                    <tr>

                                        <th>ID</th>

                                        <th>名前</th>

                                        <th>フリガナ</th>

                                        <th>会社名</th>

                                        <th>受付区分</th>

                                        <th>メールアドレス</th>

                                        <th>電話番号</th>

                                        <th>登録日</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($approvedUsers as $eventUser)

                                        <tr>

                                            <td>{{ $eventUser->id }}</td>

                                            <td>{{ $eventUser->name }}</td>

                                            <td>{{ $eventUser->furigana }}</td>

                                            <td>{{ $eventUser->company }}</td>

                                            <td>

                                                @isset($eventSections[$eventUser->section])

                                                    {{ $eventSections[$eventUser->section]->name }}

                                                @else

                                                    -

                                                @endisset

                                            </td>

                                            <td>{{ $eventUser->mail }}</td>

                                            <td>{{ $eventUser->tel ?: '-' }}</td>

                                            <td>{{ \Carbon\Carbon::parse($eventUser->created_at)->format('Y-m-d') }}</td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                            <div class="d-flex justify-content-center">

                                {{ $approvedUsers->links() }}

                            </div>

                        @endif

                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection

