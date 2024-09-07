@extends('adminlte::page')

@section('title', 'イベント情報編集 | イベント来場管理システム')

@section('content_header')
    <h1>イベント情報編集</h1>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h2 class="card-title event-title"><b>{{ $event->name }}</b></h2>
        </div>
        <div class="card-body">
            <form action="{{ route('events.update', $event->id) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="form-group">
                    <label for="name">イベント名</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $event->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="organization">開催組織</label>
                    <input type="text" class="form-control" id="organization" name="organization" value="{{ \App\Models\Usersorganization::find($event->organization)->name }}" readonly>
                </div>
                
                <div class="form-group">
                    <label for="place">開催場所</label>
                    <input type="text" class="form-control @error('place') is-invalid @enderror" id="place" name="place" value="{{ old('place', $event->place) }}" required>
                    @error('place')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>開催日時</label>
                    @php
                        $eventDates = old('event_date', json_decode($event->event_date, true));
                    @endphp
                    <div id="event-dates-container">
                        @foreach ($eventDates as $index => $date)
                            <div class="input-group mb-3 event-date-row">
                                <input type="date" class="form-control @error('event_date.'.$index.'.date') is-invalid @enderror" name="event_date[{{ $index }}][date]" value="{{ $date['date'] }}" required>
                                <input type="time" class="form-control @error('event_date.'.$index.'.starttime') is-invalid @enderror" name="event_date[{{ $index }}][starttime]" value="{{ \Carbon\Carbon::parse($date['starttime'])->format('H:i') }}" required>
                                <input type="time" class="form-control @error('event_date.'.$index.'.endtime') is-invalid @enderror" name="event_date[{{ $index }}][endtime]" value="{{ \Carbon\Carbon::parse($date['endtime'])->format('H:i') }}" required>
                                <button type="button" class="btn btn-danger remove-date">削除</button>
                            </div>
                            @error('event_date.'.$index.'.date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('event_date.'.$index.'.starttime')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('event_date.'.$index.'.endtime')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-success" id="add-date">日付を追加</button>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const container = document.getElementById('event-dates-container');
                        const addButton = document.getElementById('add-date');
                        let dateIndex = {{ count($eventDates) }};

                        addButton.addEventListener('click', function() {
                            const newRow = document.createElement('div');
                            newRow.className = 'input-group mb-3 event-date-row';
                            newRow.innerHTML = `
                                <input type="date" class="form-control" name="event_date[${dateIndex}][date]" required>
                                <input type="time" class="form-control" name="event_date[${dateIndex}][starttime]" required>
                                <input type="time" class="form-control" name="event_date[${dateIndex}][endtime]" required>
                                <button type="button" class="btn btn-danger remove-date">削除</button>
                            `;
                            container.appendChild(newRow);
                            dateIndex++;
                        });

                        container.addEventListener('click', function(e) {
                            if (e.target.classList.contains('remove-date')) {
                                e.target.closest('.event-date-row').remove();
                            }
                        });
                    });
                    </script>
                </div>
                
                <div class="form-group">
                    <label for="approval">承認</label>
                    <select class="form-control @error('approval') is-invalid @enderror" id="approval" name="approval">
                        <option value="0" {{ old('approval', $event->approval) == 0 ? 'selected' : '' }}>なし</option>
                        <option value="1" {{ old('approval', $event->approval) == 1 ? 'selected' : '' }}>あり</option>
                    </select>
                    @error('approval')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">更新</button>
                <a href="{{ route('events.index') }}" class="btn btn-secondary">キャンセル</a>
            </form>
        </div>
    </div>
@endsection
