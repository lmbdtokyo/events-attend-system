<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite('resources/css/style.css')
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Zen Kaku Gothic New', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1, h2 {
            text-align: center;
            color: #007bff;
        }
        p {
            line-height: 1.6;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            background-color: #e9ecef;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .qr-code img {
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>マイページ</h1>
        <p>ようこそ、{{ $user->name }}さん</p>
        <h2>イベント情報</h2>
        <p>イベント名: {{ $event->name }}</p>
        <p>開催場所: {{ $event->place }}</p>
        <p>開催日</p>
        <ul>
            @php
                $eventDates = json_decode($event->event_date);
            @endphp

            @foreach ($eventDates as $eventDate)
                <li>
                    {{ $eventDate->date }}: {{ $eventDate->starttime }} - {{ $eventDate->endtime }}
                </li>
            @endforeach
        </ul>
        <h2>登録情報</h2>
        <p>名前: {{ $user->name }}</p>
        <p>ふりがな: {{ $user->furigana }}</p>
        <p>会社名: {{ $user->company }}</p>
        <p>部署: {{ $user->division }}</p>
        <p>役職: {{ $user->post }}</p>
        <p>メールアドレス: {{ $user->mail }}</p>
        <p>電話番号: {{ $user->tel }}</p>
        <p>住所: {{ $user->address1 }} {{ $user->address2 }} {{ $user->address3 }}</p>
        <p>生年月日: {{ $user->birth }}</p>
        <div class="qr-code">
            <p>QRコード:</p>
            <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(200)->generate($user->qr)) }}" alt="QRコード">
        </div>
    </div>
</body>
</html>
