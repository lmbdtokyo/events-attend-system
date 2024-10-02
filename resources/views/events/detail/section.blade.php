
@extends('adminlte::page')

@section('title', '受付区分編集・追加 | イベント来場管理システム')

@section('content_header')
    <h1>受付区分編集・追加</h1>
@endsection

@section('content')
    
<div class="card">
    <div class="card-body">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    
    <form action="{{ route('eventsection.update', $event->id) }}" method="POST">
        @csrf
        @method('PATCH')
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>区分名</th>
                    <th>色</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="eventsection-table-body">
                @foreach($eventsections as $eventsection)
                <tr>
                    <td><input type="text" name="eventsections[{{ $eventsection->id }}][name]" class="form-control" value="{{ $eventsection->name }}"></td>
                    <td><input type="color" name="eventsections[{{ $eventsection->id }}][color]" class="form-control" value="{{ $eventsection->color }}"></td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="removeRow(this)">削除</button>
                        <input type="hidden" name="eventsections[{{ $eventsection->id }}][delete]" value="0">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    
        <button type="button" class="btn btn-primary" onclick="addRow()">新しい行を追加</button>
        <button type="submit" class="btn btn-success">保存</button>
    </form>
    
    <script>
        function addRow() {
            const tableBody = document.getElementById('eventsection-table-body');
            const newRow = document.createElement('tr');
    
            newRow.innerHTML = `
                <td><input type="text" name="eventsections[new][name][]" class="form-control"></td>
                <td><input type="color" name="eventsections[new][color][]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">削除</button></td>
            `;
    
            tableBody.appendChild(newRow);
        }
    
        function removeRow(button) {
            const row = button.parentElement.parentElement;
            const deleteInput = row.querySelector('input[type="hidden"]');
            if (deleteInput) {
                deleteInput.value = '1';
                row.style.display = 'none';
            } else {
                row.remove();
            }
        }
    </script>
    


    </div>
</div>

@endsection

