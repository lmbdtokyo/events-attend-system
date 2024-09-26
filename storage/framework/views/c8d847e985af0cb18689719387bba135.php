

<?php $__env->startSection('title', '来場者一覧 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>申込者一覧</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">
<div class="row">
    <?php if(request()->route('exit_entry') == 1): ?>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">入場記録</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 100px;">ID</th>
                            <th>名前</th>
                            <th>入場時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($eventEntries): ?>
                            <?php $__currentLoopData = $eventEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($eventUsers->find($record->applicant_id)->id ?? ''); ?></td>
                                <td><?php echo e($eventUsers->find($record->applicant_id)->name ?? 'QRユーザー'); ?></td>
                                <td><?php echo e($record->created_at); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <?php echo e($eventEntries->links()); ?>

                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">退場記録</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 100px;">ID</th>
                            <th>名前</th>
                            <th>退場時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($eventEntries): ?>
                            <?php $__currentLoopData = $eventEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($eventUsers->find($record->applicant_id)->id ?? ''); ?></td>
                                <td><?php echo e($eventUsers->find($record->applicant_id)->name ?? 'QRユーザー'); ?></td>
                                <td><?php echo e($record->created_at); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <?php echo e($eventEntries->links()); ?>

                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/records.blade.php ENDPATH**/ ?>