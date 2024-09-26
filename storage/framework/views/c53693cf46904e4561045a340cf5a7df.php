

<?php $__env->startSection('title', '申込者一覧 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>申込者一覧</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名前</th>
                        <th>フリガナ</th>
                        <th>会社名</th>
                        <th>部署</th>
                        <th>役職</th>
                        <th>メールアドレス</th>
                        <th>電話番号</th>
                        <th>生年月日</th>
                        <th>セクション</th>
                        <th>ログインID</th>
                        <th>登録日</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $eventUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($eventUser->id); ?></td>
                            <td><?php echo e($eventUser->name); ?></td>
                            <td><?php echo e($eventUser->furigana); ?></td>
                            <td><?php echo e($eventUser->company); ?></td>
                            <td><?php echo e($eventUser->division); ?></td>
                            <td><?php echo e($eventUser->post); ?></td>
                            <td><?php echo e($eventUser->mail); ?></td>
                            <td><?php echo e($eventUser->tel); ?></td>
                            <td><?php echo e($eventUser->birth); ?></td>
                            <td><?php echo e($eventUser->section); ?></td>
                            <td><?php echo e($eventUser->login_id); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($eventUser->created_at)->format('Y-m-d')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                <?php echo e($eventUsers->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/user.blade.php ENDPATH**/ ?>