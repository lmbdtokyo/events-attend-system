<?php $__env->startSection('title', 'イベント一覧 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>イベント一覧</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="text-right">
    <a href="<?php echo e(route('events.create')); ?>" class="btn btn-success mb-3">イベント新規作成</a>
</div>

            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

    
            <?php if(count($events) > 0): ?>

            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title event-title"><b><a href="<?php echo e(route('events.show', $event->id)); ?>"><?php echo e($event->name); ?></a></b></h2>
                </div>
                <div class="card-body">

                    <table class="event-table">
                        <tbody>
                            <tr>
                                <th>イベント情報</th>
                                <th>開催日</th>
                                <th>承認</th>
                                <th>アクション</th>
                                
                            </tr>
                            <tr>
                                <td>
                                    <ul class="event-info-ul">
                                        <li>開催組織: <?php echo e(\App\Models\Usersorganization::find($event->organization)->name); ?></li>
                                        <li>開催場所: <?php echo e($event->place); ?></li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="eventdate-ul">
                                    <?php
                                        $eventDates = json_decode($event->event_date, true); // JSONをデコード
                                    ?>
                                    <?php $__currentLoopData = $eventDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <?php echo e($date['date']); ?> <?php echo e(\Carbon\Carbon::parse($date['starttime'])->format('H:i')); ?>～<?php echo e(\Carbon\Carbon::parse($date['endtime'])->format('H:i')); ?>

                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </td>
                                <td><?php echo e($event->approval == 0 ? 'なし' : 'あり'); ?></td>
                                <td>
                                    <a href="<?php echo e(route('events.show', $event->id)); ?>" class="btn btn-info btn-sm event-btn">　全体設定　</a>
                                    <a href="<?php echo e(route('events.edit', $event->id)); ?>" class="btn btn-primary btn-sm event-btn">基本情報編集</a><br>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php else: ?>

                <p>イベントがありません。</p>

            <?php endif; ?>

            <?php echo e($events->links()); ?>


<?php $__env->stopSection(); ?>



<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/index.blade.php ENDPATH**/ ?>