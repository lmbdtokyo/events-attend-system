<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }} 新しいパスワード設定</title>
    @vite('resources/css/style.css')
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Zen Kaku Gothic New', sans-serif; background: #f8f9fa; min-height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0; }
        .container { max-width: 500px; padding: 20px; background: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .btn { display: block; width: 100%; padding: 10px; color: #fff; background: #007bff; border: none; border-radius: 5px; cursor: pointer; text-align: center; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>{{ $event->name }}<br>新しいパスワードを設定</h2>
        @if ($errors->any())
            <ul style="color:red;">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        @endif
        <form method="POST" action="{{ route('eventuser.password.reset', [$event, $token]) }}">
            @csrf
            <div class="form-group">
                <label for="password">新しいパスワード（8文字以上）</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">新しいパスワード（確認）</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn">パスワードを変更</button>
        </form>
    </div>
</body>
</html>
