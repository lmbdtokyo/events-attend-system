<!DOCTYPE html>
<html>
<head>
    <title><?php echo e($eventUser->approval == 1 ? 'アカウントが承認されました' : 'アカウントが承認されませんでした'); ?></title>
</head>
<body>
    <p><?php echo e($eventUser->name); ?>様</p>
    <p>運営事務局より<?php echo e($eventUser->approval == 1 ? 'アカウントが承認されました。' : 'アカウントが承認されませんでした。'); ?></p>
    
<!-- Start Generation Here -->
<?php if($eventUser->approval == 1): ?>
    <p>マイページにアクセスするには、以下のリンクをクリックしてください:</p>
    <p><a href="<?php echo e(route('eventuser.mypage', ['event' => $eventUser->event_id])); ?>">ログインページ</a></p>
<?php endif; ?>
<!-- End Generation Here -->

<!-- Start Generation Here -->
<p><?php echo e(config('app.name')); ?></p>

</body>
</html><?php /**PATH /data/resources/views/emails/approval_status_changed.blade.php ENDPATH**/ ?>