<?php $__env->startSection('title', '新規組織作成 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>新規組織作成</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
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

                        <form action="<?php echo e(route('organization.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label for="name">組織名</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?php echo e(old('name')); ?>" placeholder="組織名を入力してください">
                            </div>
                            <button type="submit" class="btn btn-primary">作成</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script> console.log('ページごとJSの記述'); </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/organization/create.blade.php ENDPATH**/ ?>