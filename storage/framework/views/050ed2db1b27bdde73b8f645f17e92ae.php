<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/style.css'); ?>
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
        <p>ようこそ、<?php echo e($user->name); ?>さん</p>
        <h2>イベント情報</h2>
        <p>イベント名: <?php echo e($event->name); ?></p>
        <p>開催場所: <?php echo e($event->place); ?></p>
        <p>開催日</p>
        <ul>
            <?php
                $eventDates = json_decode($event->event_date);
            ?>

            <?php $__currentLoopData = $eventDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <?php echo e($eventDate->date); ?>: <?php echo e($eventDate->starttime); ?> - <?php echo e($eventDate->endtime); ?>

                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <h2>登録情報</h2>
        <p>名前: <?php echo e($user->name); ?></p>
        <p>ふりがな: <?php echo e($user->furigana); ?></p>
        <p>会社名: <?php echo e($user->company); ?></p>
        <p>部署: <?php echo e($user->division); ?></p>
        <p>役職: <?php echo e($user->post); ?></p>
        <p>メールアドレス: <?php echo e($user->mail); ?></p>
        <p>電話番号: <?php echo e($user->tel); ?></p>
        <p>住所: <?php echo e($user->address1); ?> <?php echo e($user->address2); ?> <?php echo e($user->address3); ?></p>
        <p>生年月日: <?php echo e($user->birth); ?></p>
        <div class="qr-code">
            <p>QRコード:</p>
            <img src="data:image/png;base64,<?php echo e(base64_encode(QrCode::format('png')->size(200)->generate($user->qr))); ?>" alt="QRコード">
        </div>
    </div>
</body>
</html>
<?php /**PATH /data/resources/views/events/user/mypage.blade.php ENDPATH**/ ?>