<?php
    $isEntry = ($exitEntry ?? request()->route('exit_entry')) == 1;
    $pageTitle = $isEntry ? '入場記録' : '退場記録';
?>

<?php $__env->startSection('title', $pageTitle . ' | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><?php echo e($pageTitle); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-3">
    <a href="<?php echo e(route('event.users', $event->id)); ?>" class="btn btn-sm btn-outline-dark">全申込者一覧</a>
    <a href="<?php echo e(route('event.records', ['event' => $event->id, 'exit_entry' => 1])); ?>"
       class="btn btn-sm <?php echo e($isEntry ? 'btn-primary' : 'btn-outline-primary'); ?>">入場記録</a>
    <a href="<?php echo e(route('event.records', ['event' => $event->id, 'exit_entry' => 2])); ?>"
       class="btn btn-sm <?php echo e($isEntry ? 'btn-outline-primary' : 'btn-primary'); ?>">退場記録</a>
    <a href="<?php echo e(route('event.in_venue', $event->id)); ?>" class="btn btn-sm btn-outline-info">現在会場にいる人</a>
    <a href="<?php echo e(route('events.exit_entry_totals', $event->id)); ?>" class="btn btn-sm btn-outline-secondary">集計</a>
</div>

<div class="card">
    <div class="card-body">

        
        <form method="GET" action="<?php echo e(route('event.records', ['event' => $event->id, 'exit_entry' => $isEntry ? 1 : 2])); ?>" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">日付</label>
                    <select name="date" class="form-control">
                        <option value="">すべての日付</option>
                        <?php $__currentLoopData = $availableDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($date); ?>" <?php echo e(($selectedDate ?? '') === $date ? 'selected' : ''); ?>><?php echo e($date); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <?php $labelText = implode('・', $searchLabels ?? ['ID','名前','フリガナ','会社名']); ?>
                    <label class="form-label">検索（<?php echo e($labelText); ?>）</label>
                    <input type="text" name="search" class="form-control" placeholder="スペース区切りで複合検索ができます（例：山田 <?php echo e(($eventsetting && !empty($eventsetting->company_display_name)) ? $eventsetting->company_display_name : '会社名'); ?>）" value="<?php echo e($search ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">検索</button>
                    <?php if(($search ?? '') !== '' || !empty($selectedDate)): ?>
                        <a href="<?php echo e(route('event.records', ['event' => $event->id, 'exit_entry' => $isEntry ? 1 : 2])); ?>" class="btn btn-secondary">クリア</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <p class="mb-3">
            <strong><?php echo e($isEntry ? '入場' : '退場'); ?>件数: <?php echo e(number_format($eventEntries->total())); ?>件</strong>
            <span class="text-muted ml-2">（登録ユーザー: <?php echo e(number_format($registeredCount ?? 0)); ?>件 ／ QRユーザー: <?php echo e(number_format($qrCount ?? 0)); ?>件）</span>
            <?php if(($search ?? '') !== '' || !empty($selectedDate)): ?>
                <span class="text-muted">※絞り込み結果</span>
            <?php endif; ?>
        </p>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <?php
                            $nameLabel = ($eventsetting && !empty($eventsetting->name_display_name)) ? $eventsetting->name_display_name : '名前';
                            $companyLabel = ($eventsetting && !empty($eventsetting->company_display_name)) ? $eventsetting->company_display_name : '会社名';
                        ?>
                        <th style="width: 100px;">ID</th>
                        <th><?php echo e($nameLabel); ?></th>
                        <th><?php echo e($companyLabel); ?></th>
                        <th style="width: 220px;"><?php echo e($isEntry ? '入場時間' : '退場時間'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $eventEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php $recordUser = $eventUsers->find($record->applicant_id); ?>
                        <tr>
                            <td><?php echo e(optional($recordUser)->id ?? ''); ?></td>
                            <td><?php echo e(optional($recordUser)->name ?? 'QRユーザー'); ?></td>
                            <td><?php echo e(optional($recordUser)->company ?? ''); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($record->created_at)->format('Y-m-d H:i:s')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">該当する記録はありません。</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            <?php echo e($eventEntries->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/records.blade.php ENDPATH**/ ?>