

<?php $__env->startSection('title', '来場証PDF用画像アップロード'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>来場証PDF用画像アップロード</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">画像アップロード</h3>
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

            <form action="<?php echo e(route('eventpdf.update', $event->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <div class="form-group">
                    <label for="pdf">画像</label>
                    <?php if($eventpdfimage && $eventpdfimage->image): ?>
                        <div class="mb-3">
                            <img src="<?php echo e(Storage::url($eventpdfimage->image)); ?>" alt="Uploaded Image" style="max-width: 100%; height: auto;">
                        </div>
                    <?php else: ?>
                        <div class="mb-3">
                            <img src="<?php echo e(asset('images/no-image-pdf.png')); ?>" alt="No Image Available" style="width: 500px; height: auto;">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" id="image" class="form-control" required>
                </div>
                <p class="small">推奨サイズ1447px x 2046px 最大サイズ：5MB</p>
                <button type="submit" class="btn btn-primary">アップロード</button>
            </form>
            
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/pdf.blade.php ENDPATH**/ ?>