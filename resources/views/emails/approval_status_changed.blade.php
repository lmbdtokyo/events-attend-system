<!DOCTYPE html>
<html>
<head>
    <title>{{ $eventUser->approval == 1 ? 'アカウントが承認されました' : 'アカウントが承認されませんでした' }}</title>
</head>
<body>
    <p>{{ $eventUser->name }}様</p>
    <p>運営事務局より{{ $eventUser->approval == 1 ? 'アカウントが承認されました。' : 'アカウントが承認されませんでした。' }}</p>
    
<!-- Start Generation Here -->
@if($eventUser->approval == 1)
    <p>マイページにアクセスするには、以下のリンクをクリックしてください:</p>
    <p><a href="{{ route('eventuser.mypage', ['event' => $eventUser->event_id]) }}">ログインページ</a></p>
@endif
<!-- End Generation Here -->

<!-- Start Generation Here -->
<p>{{ config('app.name') }}</p>

</body>
</html>