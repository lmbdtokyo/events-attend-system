<!-- Start of Selection -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申込完了</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/style.css'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Zen Kaku Gothic New', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #000;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin: 15px 0px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo e($event->approval == 0 ? '登録完了' : '申込完了'); ?></h1>
        <p><?php echo $text; ?></p>
        <?php if($event->approval == 0): ?>
            <a href="<?php echo e(route('eventuser.mypage', $event->id)); ?>" class="btn">ログインしてマイページへ</a>
        <?php endif; ?>
    </div>
</body>
</html>
<!-- End of Selection -->
<?php /**PATH /data/resources/views/events/user/finish.blade.php ENDPATH**/ ?>