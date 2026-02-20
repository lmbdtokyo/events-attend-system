<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>パスワード再設定</title>
</head>
<body>
    <p><?php echo e($eventuser->name); ?>様</p>
    <p>「<?php echo e($event->name); ?>」のパスワード再設定のリクエストを受け付けました。</p>
    <p>以下のリンクをクリックして、新しいパスワードを設定してください。</p>
    <p>（有効期限は60分です）</p>
    <p><a href="<?php echo e($resetUrl); ?>">パスワードを再設定する</a></p>
    <p>※このメールに心当たりがない場合は、破棄してください。</p>
</body>
</html>
<?php /**PATH /data/resources/views/emails/eventuser_password_reset.blade.php ENDPATH**/ ?>