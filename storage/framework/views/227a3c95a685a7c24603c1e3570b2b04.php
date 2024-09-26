新規ユーザー登録完了<br>
<br>
<?php echo e($user->name); ?> 様、管理者より新規ユーザー登録が完了しましたので以下の情報よりログインしてください。<br>
<br>
メールアドレス : <?php echo e($user->email); ?> <br>パスワード : <?php echo e($temporaryPassword); ?> <br>
<br>
ログインは以下より行ってください。<br>
<a href="<?php echo e(route('login')); ?>"><?php echo e(route('login')); ?></a><br>
ご不明な点がございましたら、管理者にお問い合わせください。<br>
<br>
※こちらのメールは送信専用のメールアドレスより送信しております。恐れ入りますが、直接ご返信しないようお願いいたします。<br>
<br>
<?php echo e(config('app.name')); ?><?php /**PATH /data/resources/views/emails/user-created.blade.php ENDPATH**/ ?>