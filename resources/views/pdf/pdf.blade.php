<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>QRコード</title>
    <style type="text/css">
        body{
            margin: 0px;
            padding: 0px;
        }
        /* 基本の文字 */
        @font-face {
            font-family: 'NotoSansJP';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/NotoSansJP-Regular.ttf') }}');
        }
        /* 全てのHTML要素に適用 */
        html, body, textarea, table {
            font-family: 'NotoSansJP', sans-serif;
        }

        .box{
            width: 100%;
            background: #000;
            padding:10px 0px;
            text-align: center;
            font-family: 'NotoSansJP', sans-serif;
            font-size: 1.5em;
            color: #FFF;
            box-sizing: border-box;
        }
    </style>
</head>
<body>


    <div style="width:40%; float:left; height:30%; margin:5%">
        <div class="box">会場へのご入場方法</div>
        <p>入場方法の画像を入れる予定</p>
    </div>
    <div style="width:40%; float:left; height:30%; margin:5%">
        @if ($eventpdfimage)
            <img src="data:image/png;base64,{{ $eventpdfimage }}" alt="Event PDF Image" style="max-width: 100%; height: auto;">
        @endif
    </div>
    <br style="clear: both;">
    <div>
    <div style="width:40%; float:left; height:40%; margin:5%">
        <div class="box">お客様情報</div>
        <p>名前: {{ $eventuser->name }}</p>
        <p>フリガナ: {{ $eventuser->furigana }}</p>
        <p>会社名: {{ $eventuser->company }}</p>
        <p>部署名: {{ $eventuser->division }}</p>
        <p>役職: {{ $eventuser->post }}</p>
    </div>
    <div style="width:40%; float:left; height:40%; margin:5%">
        <div style="padding: 10px 0px; font-size:1.5em; font-family: 'NotoSansJP', sans-serif; background:#ff0000; text-align:center; color:#fff;">受付区分名</div>
        <p>会社名: {{ $eventuser->company }}</p>
        <p>部署名: {{ $eventuser->division }}</p>
        <p>役職: {{ $eventuser->post }}</p>
    <div style="text-align: center; margin-top: 20px;">
        <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
    </div>
    </div>
    </div>


    {{-- <div style="width:40%; float:left; height:30%; margin:5%">
        <div class="box">会場へのご入場方法</div>
        <p>入場方法の画像を入れる予定</p>
    </div>
    <div style="width:40%; float:left; height:30%; margin:5%">
    @if ($eventpdfimage && $eventpdfimage->image)
        <img src="{{ Storage::url($eventpdfimage->image) }}" alt="Event PDF Image" style="max-width: 100%; height: auto;">
    @endif
    </div>
    <br style="clear: both;">
    <div>
    <div style="width:40%; float:left; height:40%; margin:5%">
        <div class="box">お客様情報</div>
        <p>名前: おなまえ</p>
        <p>フリガナ: フリガナ</p>
        <p>会社名: 会社名</p>
        <p>部署名: 部署名</p>
        <p>役職: 役職</p>
    </div>
    <div style="width:40%; float:left; height:40%; margin:5%">
        <div style="padding: 10px 0px; font-size:1.5em; font-family: 'NotoSansJP', sans-serif; background:#ff0000; text-align:center; color:#fff;">受付区分名</div>
        <p>会社名: 会社名</p>
        <p>部署名: 部署名</p>
        <p>役職: 役職</p>
    <div style="text-align: center; margin-top: 20px;">
        
    </div>
    </div>
    </div> --}}



</body>
</html>