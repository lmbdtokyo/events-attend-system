<?php $__env->startSection('title', 'QRコード生成イベント一覧'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>空QRコード生成履歴一覧</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">空QRコード生成履歴</h3>
            <div class="card-tools">
                <a href="<?php echo e(route('eventsgenerateqr.create', $event->id)); ?>" class="btn btn-primary">QRコード新規作成</a>
            </div>
        </div>
        <div class="card-body">
            <?php if($eventGenerateQRs->isEmpty()): ?>
                <p>空QRコード生成履歴がありません。</p>
            <?php else: ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>作成日</th>
                            <th>QRコード数</th>
                            <th>PDFパス</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $eventGenerateQRs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventGenerateQR): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($eventGenerateQR->created_at->format('Y-m-d')); ?></td>
                                <td><?php echo e($eventGenerateQR->number); ?></td>
                                <td><a href="<?php echo e(url($eventGenerateQR->pdf_path)); ?>" target="_blank"><?php echo e($eventGenerateQR->pdf_path); ?></a></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <div class="card-footer">
            <?php echo e($eventGenerateQRs->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/qrindex.blade.php ENDPATH**/ ?>