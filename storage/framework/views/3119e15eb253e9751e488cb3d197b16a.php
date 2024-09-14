

<?php $__env->startSection('title', 'QRコード生成'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>空QRコード生成</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">QRコード生成フォーム</h3>
        </div>
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
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('eventsgenerateqr.store', $event->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="number">QRコード数</label>
                    <input type="number" name="number" id="number" class="form-control" required>
                </div>
                <div class="small" style="margin-bottom:30px;">
                    ※QRコードの生成は50件までです。※イベント来場数上限によってはより少ない場合もございます。
                </div>
                <button type="submit" class="btn btn-primary">生成</button>
            </form>
            
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/qrcreate.blade.php ENDPATH**/ ?>