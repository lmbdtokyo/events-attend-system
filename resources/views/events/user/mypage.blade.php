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
            color: #000;
        }

        h1{
            text-align: center;
        }

        h2{
            padding: 0.5em;/*文字周りの余白*/
            color: #010101;/*文字色*/
            background: #eaf3ff;/*背景色*/
            border-bottom: solid 3px #516ab6;/*下線*/
        }

        p {
            line-height: 1.6;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            
        }
        .qr-code img {
            display: block;
            margin: 0 auto;
        }
        .logout-button {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            width: 30%;
        }
    </style>
</head>
<body>
    <div class="container">

        @if ($eventmypagebasic->image)
            <div class="event-image">
                <img src="{{ Storage::url($eventmypagebasic->image) }}" alt="イベント画像" style="width: 100%; height: auto;">
            </div>
        @endif

        <h1>{{ $event->name }}マイページ</h1>
        <p>ようこそ、{{ $user->name }}さん</p>

        <h2>{{$eventmypagebasic->title}}</h2>

        <p>{{$eventmypagebasic->text}}</p>


        <h2>イベント情報</h2>
        <table>
            <tr>
                <th>イベント名</th>
                <td>{{ $event->name }}</td>
            </tr>
            <tr>
                <th>開催場所</th>
                <td>{{ $event->place }}</td>
            </tr>
            <tr>
                <th>開催日</th>
                <td>
                    <ul>
                        @php
                            $eventDates = json_decode($event->event_date);
                        @endphp
            
                        @foreach ($eventDates as $eventDate)
                            <li>
                                {{ $eventDate->date }}: {{ \Carbon\Carbon::parse($eventDate->starttime)->format('H:i') }} - {{ \Carbon\Carbon::parse($eventDate->endtime)->format('H:i') }}
                            </li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        </table>
        <h2>登録情報</h2>
        <table>
            <tr>
                <th>名前</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>ふりがな</th>
                <td>{{ $user->furigana }}</td>
            </tr>
            <tr>
                <th>会社名</th>
                <td>{{ $user->company }}</td>
            </tr>
            <tr>
                <th>部署</th>
                <td>{{ $user->division }}</td>
            </tr>
            <tr>
                <th>役職</th>
                <td>{{ $user->post }}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>{{ $user->mail }}</td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>{{ $user->tel }}</td>
            </tr>
            <tr>
                <th>住所</th>
                <td>{{ $user->address1 }} {{ $user->address2 }} {{ $user->address3 }}</td>
            </tr>
            <tr>
                <th>生年月日</th>
                <td>{{ $user->birth }}</td>
            </tr>
            <tr>
                <th>PDF</th>
                <td><a href="{{ Storage::url($user->pdf_name) }}" target="_blank" class="btn btn-primary">PDFを表示</a></td>
            </tr>
        </table>

        <h2>来場用QRコード</h2>
        <div class="qr-code">
            
            <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(200)->generate(config('app.url') . '/events/' . $event->id . '/qr/user/' . $user->qr)) }}" alt="QRコード">
        </div>
        <a href="{{ route('eventuser.logout', ['event' => $event->id]) }}" class="logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
        <form id="logout-form" action="{{ route('eventuser.logout',['event' => $event->id]) }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</body>
</html>
