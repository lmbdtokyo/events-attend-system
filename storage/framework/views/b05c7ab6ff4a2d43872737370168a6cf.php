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
            src: url('<?php echo e(storage_path('fonts/NotoSansJP-Regular.ttf')); ?>');
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
        <?php if($eventpdfimage): ?>
            <img src="data:image/png;base64,<?php echo e($eventpdfimage); ?>" alt="Event PDF Image" style="max-width: 100%; height: auto;">
        <?php endif; ?>
    </div>
    <br style="clear: both;">
    <div>
    <div style="width:40%; float:left; height:40%; margin:5%">
        <div class="box">お客様情報</div>
        <p>名前: <?php echo e($eventuser->name); ?></p>
        <p>フリガナ: <?php echo e($eventuser->furigana); ?></p>
        <p>会社名: <?php echo e($eventuser->company); ?></p>
        <p>部署名: <?php echo e($eventuser->division); ?></p>
        <p>役職: <?php echo e($eventuser->post); ?></p>
    </div>
    <div style="width:40%; float:left; height:40%; margin:5%">
        <div style="padding: 10px 0px; font-size:1.5em; font-family: 'NotoSansJP', sans-serif; background:#ff0000; text-align:center; color:#fff;">受付区分名</div>
        <p>会社名: <?php echo e($eventuser->company); ?></p>
        <p>部署名: <?php echo e($eventuser->division); ?></p>
        <p>役職: <?php echo e($eventuser->post); ?></p>
    <div style="text-align: center; margin-top: 20px;">
        <img src="data:image/png;base64,<?php echo e(base64_encode($qrCode)); ?>" alt="QR Code">
    </div>
    </div>
    </div>


    



</body>
</html><?php /**PATH /data/resources/views/pdf/pdf.blade.php ENDPATH**/ ?>