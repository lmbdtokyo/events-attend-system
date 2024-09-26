<!DOCTYPE html>
<html>
<head>
    <title>{{ $eventFinishMail->title }}</title>
</head>
<body>
    <p>{{ $eventuser->name }}様</p>
    <p>「{{ $event->name }}」への来場登録が完了しました。</p>

    <p>{!! $eventFinishMail->text !!}</p>

    <h3>登録情報</h3>
    <ul>
        <li>フリガナ: {{ $eventuser->furigana }}</li>
        <li>会社名: {{ $eventuser->company }}</li>
        <li>部署: {{ $eventuser->division }}</li>
        <li>役職: {{ $eventuser->post }}</li>
        <li>郵便番号: {{ $eventuser->postal_code }}</li>
        <li>住所: {{ $eventuser->address1 }} {{ $eventuser->address2 }} {{ $eventuser->address3 }}</li>
        <li>電話番号: {{ $eventuser->tel }}</li>
        <li>生年月日: {{ $eventuser->birth }}</li>
        <li>セクション: {{ $eventuser->section }}</li>
        <li>ログインID: {{ $eventuser->login_id }}</li>
        <li>メールアドレス: {{ $eventuser->mail }}</li>
        <li>パスワード: {{ $password }}</li>
    </ul>
    <p>来場証はマイページからダウンロード・印刷できます。以下のリンクからログインしてください。</p>
    <a href="{{ url('/events/' . $event->id . '/mypage') }}">マイページにアクセス</a>
</body>
</html>