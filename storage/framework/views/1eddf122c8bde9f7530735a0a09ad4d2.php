<?php $__env->startSection('title', '申込完了画面設定 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>申込完了画面設定</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('eventfinish.update', $event->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

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
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <p><?php echo e(session('success')); ?></p>
                    </div>
                <?php endif; ?>

                <p>
                    申込完了画面の設定を行います。<br>各項目に必要な情報を入力してください。
                </p>

                <table class="table table-bordered event-setting-table">
                    <tr>
                        <th>項目名</th>
                        <th>入力内容</th>
                    </tr>
                    <tr>
                        <td><label for="draft_text">仮登録完了用表示テキスト</label></td>
                        <td><textarea id="draft_text" name="draft_text" class="form-control"><?php echo e($eventfinish->draft_text); ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="finish_text">申込完了用表示テキスト</label></td>
                        <td><textarea id="finish_text" name="finish_text" class="form-control"><?php echo e($eventfinish->finish_text); ?></textarea></td>
                    </tr>
                </table>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/finish.blade.php ENDPATH**/ ?>