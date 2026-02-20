<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($event->name); ?> 登録情報編集</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/style.css'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Zen Kaku Gothic New', sans-serif; background: #f8f9fa; color: #333; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 50px auto; padding: 20px; background: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px; }
        h1, h2 { color: #000; }
        h2 { padding: 0.5em; color: #010101; background: #eaf3ff; border-bottom: solid 3px #516ab6; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .btn { padding: 10px 20px; color: #fff; background: #007bff; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #545b62; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo e($event->name); ?> 登録情報の編集</h1>
        <a href="<?php echo e(route('eventuser.mypage', ['event' => $event->id])); ?>" class="btn btn-secondary" style="margin-bottom: 20px;">← マイページに戻る</a>

        <?php if($errors->any()): ?>
            <ul style="color: red;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>

        <form action="<?php echo e(route('eventuser.mypage.update', ['event' => $event->id])); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <?php $es = optional($eventsetting); ?>

            <h2>基本情報</h2>
            <div class="form-group">
                <label for="name"><?php echo e($es->name_display_name ?? '名前'); ?> <span style="color:red">*</span></label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name', $eventuser->name)); ?>" required>
            </div>
            <div class="form-group">
                <label for="furigana"><?php echo e($es->furigana_display_name ?? 'フリガナ'); ?></label>
                <input type="text" id="furigana" name="furigana" value="<?php echo e(old('furigana', $eventuser->furigana)); ?>">
            </div>
            <div class="form-group">
                <label for="company"><?php echo e($es->company_display_name ?? '会社名'); ?></label>
                <input type="text" id="company" name="company" value="<?php echo e(old('company', $eventuser->company)); ?>">
            </div>
            <div class="form-group">
                <label for="division"><?php echo e($es->division_display_name ?? '部署'); ?></label>
                <input type="text" id="division" name="division" value="<?php echo e(old('division', $eventuser->division)); ?>">
            </div>
            <div class="form-group">
                <label for="post"><?php echo e($es->post_display_name ?? '役職'); ?></label>
                <input type="text" id="post" name="post" value="<?php echo e(old('post', $eventuser->post)); ?>">
            </div>

            <h2>連絡先・住所</h2>
            <div class="form-group">
                <label for="mail">メールアドレス <span style="color:red">*</span></label>
                <input type="email" id="mail" name="mail" value="<?php echo e(old('mail', $eventuser->mail)); ?>" required>
            </div>
            <div class="form-group">
                <label for="tel"><?php echo e($es->tel_display_name ?? '電話番号'); ?></label>
                <input type="text" id="tel" name="tel" value="<?php echo e(old('tel', $eventuser->tel)); ?>">
            </div>
            <div class="form-group">
                <label for="postal_code"><?php echo e($es->postal_code_display_name ?? '郵便番号'); ?></label>
                <input type="text" id="postal_code" name="postal_code" value="<?php echo e(old('postal_code', $eventuser->postal_code)); ?>">
            </div>
            <div class="form-group">
                <label for="address1"><?php echo e($es->address1_display_name ?? '住所1'); ?></label>
                <input type="text" id="address1" name="address1" value="<?php echo e(old('address1', $eventuser->address1)); ?>">
            </div>
            <div class="form-group">
                <label for="address2"><?php echo e($es->address2_display_name ?? '住所2'); ?></label>
                <input type="text" id="address2" name="address2" value="<?php echo e(old('address2', $eventuser->address2)); ?>">
            </div>
            <div class="form-group">
                <label for="address3"><?php echo e($es->address3_display_name ?? '住所3'); ?></label>
                <input type="text" id="address3" name="address3" value="<?php echo e(old('address3', $eventuser->address3)); ?>">
            </div>
            <div class="form-group">
                <label for="birth"><?php echo e($es->birth_display_name ?? '生年月日'); ?></label>
                <input type="date" id="birth" name="birth" value="<?php echo e(old('birth', $eventuser->birth)); ?>">
            </div>

            <?php if($eventsections->isNotEmpty()): ?>
                <div class="form-group">
                    <label for="section"><?php echo e($es->section_display_name ?? '受付区分'); ?></label>
                    <select id="section" name="section">
                        <option value="">選択してください</option>
                        <?php $__currentLoopData = $eventsections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($section->id); ?>" <?php echo e(old('section', $eventuser->section) == $section->id ? 'selected' : ''); ?>><?php echo e($section->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="password">パスワード変更（変更しない場合は空欄）</label>
                <input type="password" id="password" name="password" placeholder="8文字以上">
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn">保存</button>
                <a href="<?php echo e(route('eventuser.mypage', ['event' => $event->id])); ?>" class="btn btn-secondary">キャンセル</a>
            </div>
        </form>
    </div>
</body>
</html>
<?php /**PATH /data/resources/views/events/user/mypage_edit.blade.php ENDPATH**/ ?>