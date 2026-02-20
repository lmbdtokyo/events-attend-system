<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }} パスワード再設定</title>
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
        .btn-link { display: inline-block; margin-top: 15px; color: #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <h2>{{ $event->name }}<br>パスワード再設定</h2>
        <p>登録したメールアドレスを入力してください。パスワード再設定のリンクを送信します。</p>
        @if ($errors->any())
            <ul style="color:red;">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        @endif
        <form method="POST" action="{{ route('eventuser.password.forgot.send', $event) }}">
            @csrf
            <div class="form-group">
                <label for="mail">メールアドレス</label>
                <input type="email" id="mail" name="mail" value="{{ old('mail') }}" required>
            </div>
            <button type="submit" class="btn">送信</button>
        </form>
        <a href="{{ route('eventuser.login', $event) }}" class="btn-link">← ログインに戻る</a>
    </div>
</body>
</html>
