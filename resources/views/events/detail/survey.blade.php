@extends('adminlte::page')

@section('title', 'アンケート項目設定')

@section('content_header')
    <h1>アンケート項目設定</h1>
@stop

@section('content')

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

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
                        <h3 class="card-title">アンケート項目設定</h3>
                    </div>
                    <div class="card-body">
                    <form action="{{ route('eventsurvey.update', $event->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <table class="table table-bordered" id="survey-table">
                            <thead>
                                <tr>
                                    <th>質問</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($eventsurveys)
                                    @foreach($eventsurveys as $index => $question)
                                        <tr>
                                            <td><input type="text" name="qa[{{ $index }}]" class="form-control" value="{{ $question }}"></td>
                                            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">削除</button></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary" onclick="addRow()">追加</button>
                        <button type="submit" class="btn btn-success">保存</button>
                    </form>

                    <script>
                        function addRow() {
                            const table = document.getElementById('survey-table').getElementsByTagName('tbody')[0];
                            const rowCount = table.rows.length;
                            const row = table.insertRow(rowCount);
                            const cell1 = row.insertCell(0);
                            const cell2 = row.insertCell(1);

                            cell1.innerHTML = `<input type="text" name="qa[${rowCount}]" class="form-control">`;
                            cell2.innerHTML = `<button type="button" class="btn btn-danger" onclick="removeRow(this)">削除</button>`;
                        }

                        function removeRow(button) {
                            const row = button.parentNode.parentNode;
                            row.parentNode.removeChild(row);
                        }
                    </script>
                    </div>
                </div>

@stop
