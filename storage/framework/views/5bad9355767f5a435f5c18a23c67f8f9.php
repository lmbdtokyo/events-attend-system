

<?php $__env->startSection('title', '申込者編集 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>申込者情報の編集</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <a href="<?php echo e(route('event.users', $event)); ?>" class="btn btn-secondary mb-3">&laquo; 申込者一覧へ戻る</a>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('event.users.update', [$event, $eventuser])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

                <?php
                    $es = optional($eventsetting);
                ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name"><?php echo e($es->name_display_name ?? '名前'); ?> <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo e(old('name', $eventuser->name)); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="furigana"><?php echo e($es->furigana_display_name ?? 'フリガナ'); ?></label>
                            <input type="text" id="furigana" name="furigana" class="form-control" value="<?php echo e(old('furigana', $eventuser->furigana)); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="company"><?php echo e($es->company_display_name ?? '会社名'); ?></label>
                    <input type="text" id="company" name="company" class="form-control" value="<?php echo e(old('company', $eventuser->company)); ?>">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="division"><?php echo e($es->division_display_name ?? '部署'); ?></label>
                            <input type="text" id="division" name="division" class="form-control" value="<?php echo e(old('division', $eventuser->division)); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="post"><?php echo e($es->post_display_name ?? '役職'); ?></label>
                            <input type="text" id="post" name="post" class="form-control" value="<?php echo e(old('post', $eventuser->post)); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="postal_code"><?php echo e($es->postal_code_display_name ?? '郵便番号'); ?></label>
                    <input type="text" id="postal_code" name="postal_code" class="form-control" value="<?php echo e(old('postal_code', $eventuser->postal_code)); ?>">
                </div>

                <div class="form-group">
                    <label for="address1"><?php echo e($es->address1_display_name ?? '住所1'); ?></label>
                    <input type="text" id="address1" name="address1" class="form-control" value="<?php echo e(old('address1', $eventuser->address1)); ?>">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address2"><?php echo e($es->address2_display_name ?? '住所2'); ?></label>
                            <input type="text" id="address2" name="address2" class="form-control" value="<?php echo e(old('address2', $eventuser->address2)); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address3"><?php echo e($es->address3_display_name ?? '住所3'); ?></label>
                            <input type="text" id="address3" name="address3" class="form-control" value="<?php echo e(old('address3', $eventuser->address3)); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tel"><?php echo e($es->tel_display_name ?? '電話番号'); ?></label>
                            <input type="text" id="tel" name="tel" class="form-control" value="<?php echo e(old('tel', $eventuser->tel)); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birth"><?php echo e($es->birth_display_name ?? '生年月日'); ?></label>
                            <input type="date" id="birth" name="birth" class="form-control" value="<?php echo e(old('birth', $eventuser->birth)); ?>">
                        </div>
                    </div>
                </div>

                <?php if($eventsections->isNotEmpty()): ?>
                    <div class="form-group">
                        <label for="section"><?php echo e($es->section_display_name ?? '受付区分'); ?></label>
                        <select id="section" name="section" class="form-control">
                            <option value="">選択してください</option>
                            <?php $__currentLoopData = $eventsections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($section->id); ?>" <?php echo e(old('section', $eventuser->section) == $section->id ? 'selected' : ''); ?>><?php echo e($section->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="mail">メールアドレス <span class="text-danger">*</span></label>
                    <input type="email" id="mail" name="mail" class="form-control" value="<?php echo e(old('mail', $eventuser->mail)); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">パスワード変更（変更しない場合は空欄）</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="8文字以上">
                </div>

                <div class="form-group">
                    <label for="approval">承認ステータス</label>
                    <select id="approval" name="approval" class="form-control">
                        <option value="0" <?php echo e(old('approval', $eventuser->approval) == 0 ? 'selected' : ''); ?>>下書き</option>
                        <option value="1" <?php echo e(old('approval', $eventuser->approval) == 1 ? 'selected' : ''); ?>>承認済み</option>
                        <option value="2" <?php echo e(old('approval', $eventuser->approval) == 2 ? 'selected' : ''); ?>>却下</option>
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">更新</button>
                    <a href="<?php echo e(route('event.users', $event)); ?>" class="btn btn-secondary">キャンセル</a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/useredit.blade.php ENDPATH**/ ?>