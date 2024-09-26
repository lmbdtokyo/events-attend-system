<!DOCTYPE html>
<html>
<head>
    <title><?php echo e($eventFinishMail->title); ?></title>
</head>
<body>
    <p><?php echo e($eventuser->name); ?>様</p>
    <p>「<?php echo e($event->name); ?>」への来場登録が完了しました。</p>

    <p><?php echo $eventFinishMail->text; ?></p>

    <h3>登録情報</h3>
    <ul>
        <li>フリガナ: <?php echo e($eventuser->furigana); ?></li>
        <li>会社名: <?php echo e($eventuser->company); ?></li>
        <li>部署: <?php echo e($eventuser->division); ?></li>
        <li>役職: <?php echo e($eventuser->post); ?></li>
        <li>郵便番号: <?php echo e($eventuser->postal_code); ?></li>
        <li>住所: <?php echo e($eventuser->address1); ?> <?php echo e($eventuser->address2); ?> <?php echo e($eventuser->address3); ?></li>
        <li>電話番号: <?php echo e($eventuser->tel); ?></li>
        <li>生年月日: <?php echo e($eventuser->birth); ?></li>
        <li>セクション: <?php echo e($eventuser->section); ?></li>
        <li>ログインID: <?php echo e($eventuser->login_id); ?></li>
        <li>メールアドレス: <?php echo e($eventuser->mail); ?></li>
        <li>パスワード: <?php echo e($password); ?></li>
    </ul>
    <p>来場証はマイページからダウンロード・印刷できます。以下のリンクからログインしてください。</p>
    <a href="<?php echo e(url('/events/' . $event->id . '/mypage')); ?>">マイページにアクセス</a>
</body>
</html><?php /**PATH /data/resources/views/emails/registration_complete.blade.php ENDPATH**/ ?>