<!DOCTYPE html>
<html>
<head>
    <title><?php echo e($eventUser->approval == 1 ? 'アカウント承認のお知らせ' : 'アカウント承認について'); ?></title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', Meiryo, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #e7f3ff;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
        .success-box {
            background-color: #d4edda;
            padding: 15px;
            border-left: 4px solid #28a745;
            margin: 20px 0;
        }
        .warning-box {
            background-color: #fff3cd;
            padding: 15px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
        .details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .details ul {
            list-style: none;
            padding: 0;
        }
        .details li {
            padding: 5px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .details li:last-child {
            border-bottom: none;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 0.9em;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin: 0; color: #007bff;"><?php echo e($event->name); ?></h2>
        <p style="margin: 5px 0 0 0; color: #6c757d;">アカウント承認通知</p>
    </div>

    <div class="content">
        <p><?php echo e($eventUser->name); ?> 様</p>

        <?php if($eventUser->approval == 1): ?>
            <div class="success-box">
                <strong>✓ アカウントが承認されました</strong>
                <p style="margin: 10px 0 0 0;">「<?php echo e($event->name); ?>」へのご参加申込が承認されました。<br>
                誠にありがとうございます。</p>
            </div>

            <div class="info-box">
                <h3 style="margin-top: 0;">次のステップ</h3>
                <p>以下のマイページにログインして、来場証の発行やイベント詳細をご確認ください。</p>
                <a href="<?php echo e(url('/events/' . $eventUser->event_id . '/mypage')); ?>" class="button">マイページにログイン</a>
            </div>

            <h3>イベント開催情報</h3>
            <div class="details">
                <ul>
                    <li><strong>イベント名：</strong><?php echo e($event->name); ?></li>
                    <li><strong>開催場所：</strong><?php echo e($event->place); ?></li>
                    <?php
                        $eventDates = json_decode($event->event_date);
                    ?>
                    <?php if($eventDates && count($eventDates) > 0): ?>
                        <li><strong>開催日時：</strong>
                            <ul style="padding-left: 20px; margin: 5px 0;">
                                <?php $__currentLoopData = $eventDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($date->date); ?> <?php echo e(\Carbon\Carbon::parse($date->starttime)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($date->endtime)->format('H:i')); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <h3>ご登録情報</h3>
            <div class="details">
                <ul>
                    <li><strong>お名前：</strong><?php echo e($eventUser->name); ?></li>
                    <?php if($eventUser->furigana): ?>
                        <li><strong>フリガナ：</strong><?php echo e($eventUser->furigana); ?></li>
                    <?php endif; ?>
                    <?php if($eventUser->company): ?>
                        <li><strong>会社名：</strong><?php echo e($eventUser->company); ?></li>
                    <?php endif; ?>
                    <?php if($eventUser->division): ?>
                        <li><strong>部署名：</strong><?php echo e($eventUser->division); ?></li>
                    <?php endif; ?>
                    <li><strong>メールアドレス：</strong><?php echo e($eventUser->mail); ?></li>
                    <li><strong>申込日時：</strong><?php echo e($eventUser->created_at->format('Y年m月d日 H:i')); ?></li>
                </ul>
            </div>

            <div class="info-box">
                <p><strong>マイページでできること：</strong></p>
                <ul>
                    <li>来場証（QRコード）のダウンロード・印刷</li>
                    <li>登録情報の確認</li>
                    <li>イベント詳細情報の確認</li>
                    <li>アンケート回答（該当する場合）</li>
                </ul>
            </div>

            <p>当日は来場証をご持参いただくとスムーズに受付ができます。</p>
        <?php else: ?>
            <div class="warning-box">
                <strong>アカウント承認について</strong>
                <p style="margin: 10px 0 0 0;">誠に申し訳ございませんが、「<?php echo e($event->name); ?>」へのご参加申込について、承認できない状況となりました。</p>
            </div>

            <h3>お申込み情報</h3>
            <div class="details">
                <ul>
                    <li><strong>イベント名：</strong><?php echo e($event->name); ?></li>
                    <li><strong>お名前：</strong><?php echo e($eventUser->name); ?></li>
                    <?php if($eventUser->company): ?>
                        <li><strong>会社名：</strong><?php echo e($eventUser->company); ?></li>
                    <?php endif; ?>
                    <li><strong>メールアドレス：</strong><?php echo e($eventUser->mail); ?></li>
                    <li><strong>申込日時：</strong><?php echo e($eventUser->created_at->format('Y年m月d日 H:i')); ?></li>
                </ul>
            </div>

            <p>ご不明な点やご質問がございましたら、下記の運営事務局までお問い合わせください。</p>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p><strong>【運営事務局】</strong></p>
        <p><?php echo e(config('app.name')); ?></p>
        <?php if(config('mail.from.address')): ?>
            <p>Email: <?php echo e(config('mail.from.address')); ?></p>
        <?php endif; ?>
        <p style="margin-top: 15px; font-size: 0.85em; color: #999;">
            このメールは「<?php echo e($event->name); ?>」にお申込みいただいた方に自動送信しています。<br>
            お心当たりのない場合は、お手数ですが運営事務局までご連絡ください。
        </p>
    </div>
</body>
</html><?php /**PATH /data/resources/views/emails/approval_status_changed.blade.php ENDPATH**/ ?>