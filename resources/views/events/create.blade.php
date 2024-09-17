@extends('adminlte::page')

@section('title', 'イベント新規作成 | イベント来場管理システム')

@section('content_header')
    <h1>イベント新規作成</h1>
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
            <h2 class="card-title event-title"><b>新規イベント</b></h2>
        </div>
        <div class="card-body">
            <form action="{{ route('events.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name">イベント名</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="organization">開催組織</label>
                    <select class="form-control @error('organization') is-invalid @enderror" id="organization" name="organization" required>
                        @if(Auth::user()->type == 'client')
                            <option value="{{ Auth::user()->organization }}" selected>{{ \App\Models\Usersorganization::find(Auth::user()->organization)->name }}</option>
                        @else
                            @foreach(\App\Models\Usersorganization::all() as $org)
                                <option value="{{ $org->id }}" {{ old('organization') == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('organization')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="place">開催場所</label>
                    <input type="text" class="form-control @error('place') is-invalid @enderror" id="place" name="place" value="{{ old('place') }}" required>
                    @error('place')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>開催日時</label>
                    <div id="event-dates-container">
                        <div class="input-group mb-3 event-date-row">
                            <input type="date" class="form-control @error('event_date.0.date') is-invalid @enderror" name="event_date[0][date]" required>
                            <input type="time" class="form-control @error('event_date.0.starttime') is-invalid @enderror" name="event_date[0][starttime]" required>
                            <input type="time" class="form-control @error('event_date.0.endtime') is-invalid @enderror" name="event_date[0][endtime]" required>
                            <button type="button" class="btn btn-danger remove-date">削除</button>
                        </div>
                        @error('event_date.0.date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('event_date.0.starttime')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('event_date.0.endtime')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="button" class="btn btn-success" id="add-date">日付を追加</button>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const container = document.getElementById('event-dates-container');
                        const addButton = document.getElementById('add-date');
                        let dateIndex = 1;

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
                        <option value="0" {{ old('approval') == 0 ? 'selected' : '' }}>なし</option>
                        <option value="1" {{ old('approval') == 1 ? 'selected' : '' }}>あり</option>
                    </select>
                    @error('approval')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">作成</button>
                <a href="{{ route('events.index') }}" class="btn btn-secondary">キャンセル</a>
            </form>
        </div>
    </div>
@endsection
