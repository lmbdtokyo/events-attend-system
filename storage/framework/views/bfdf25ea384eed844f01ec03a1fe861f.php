<?php $__env->startSection('title', '管理ユーザー編集 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>管理ユーザー編集</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">

            <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                </div>
            <?php endif; ?>

            <?php if($user->type == 'master'): ?>
                <div class="alert alert-danger">
                    マスターアカウントは編集できません。
                </div>
            <?php else: ?>
                <form action="<?php echo e(route('user.update', $user->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <div class="form-group">
                        <label for="name">名前</label>
                        <input type="text" name="name" class="form-control" id="name" value="<?php echo e($user->name); ?>" placeholder="名前を入力">
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="email" name="email" class="form-control" id="email" value="<?php echo e($user->email); ?>" placeholder="メールアドレスを入力">
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input type="password" name="password" class="form-control" id="password" value="<?php echo e($user->password); ?>" placeholder="パスワードを入力">
                    </div>

                    <div class="form-group">
                        <label for="auth">権限</label>
                        <select name="auth" class="form-control" id="auth">
                            <?php $__currentLoopData = $auths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($auth->id); ?>" <?php echo e($user->auth == $auth->id ? 'selected' : ''); ?>><?php echo e($auth->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="organization">所属組織</label>
                        <select name="organization" class="form-control" id="organization">
                            <?php $__currentLoopData = $organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($organization->id); ?>" <?php echo e($user->organization == $organization->id ? 'selected' : ''); ?>><?php echo e($organization->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="<?php echo e($user->type); ?>">

                    <button type="submit" class="btn btn-primary">更新</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="/css/admin_custom.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script> console.log('ページごとJSの記述'); </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/user/edit.blade.php ENDPATH**/ ?>