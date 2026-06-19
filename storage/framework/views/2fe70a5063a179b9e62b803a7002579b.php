<?php $__env->startSection('title', '現在会場にいる人 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>現在会場にいる人</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
<?php endif; ?>

<div class="mb-3">
    <a href="<?php echo e(route('event.users', $event->id)); ?>" class="btn btn-sm btn-outline-dark">全申込者一覧</a>
    <a href="<?php echo e(route('event.records', ['event' => $event->id, 'exit_entry' => 1])); ?>" class="btn btn-sm btn-outline-primary">入場記録</a>
    <a href="<?php echo e(route('event.records', ['event' => $event->id, 'exit_entry' => 2])); ?>" class="btn btn-sm btn-outline-primary">退場記録</a>
    <a href="<?php echo e(route('event.in_venue', $event->id)); ?>" class="btn btn-sm btn-info">現在会場にいる人</a>
    <a href="<?php echo e(route('events.exit_entry_totals', $event->id)); ?>" class="btn btn-sm btn-outline-secondary">集計</a>
</div>

<div class="card">
    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="alert alert-info mb-2">
                    <strong>現在会場にいる人数</strong>
                    <span class="float-right"><?php echo e(number_format($registeredCount + $qrCount)); ?>名</span>
                </div>
                <small class="text-muted">
                    登録ユーザー <?php echo e(number_format($registeredCount)); ?>名 ／ QRユーザー <?php echo e(number_format($qrCount)); ?>名
                </small>
            </div>
        </div>

        
        <form method="GET" action="<?php echo e(route('event.in_venue', $event->id)); ?>" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-8">
                    <?php $labelText = implode('・', $searchLabels ?? ['ID','名前','フリガナ','会社名']); ?>
                    <label class="form-label">検索（<?php echo e($labelText); ?>）</label>
                    <input type="text" name="search" class="form-control" placeholder="スペース区切りで複合検索ができます（例：山田 <?php echo e(($eventsetting && !empty($eventsetting->company_display_name)) ? $eventsetting->company_display_name : '会社名'); ?>）" value="<?php echo e($search ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">検索</button>
                    <?php if(($search ?? '') !== ''): ?>
                        <a href="<?php echo e(route('event.in_venue', $event->id)); ?>" class="btn btn-secondary">クリア</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        
        <h3 class="mt-2" style="font-size:1.1rem;">登録ユーザー（<?php echo e(number_format($inVenueUsers->count())); ?>名）</h3>
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <?php
                            $nameLabel = ($eventsetting && !empty($eventsetting->name_display_name)) ? $eventsetting->name_display_name : '名前';
                            $furiganaLabel = ($eventsetting && !empty($eventsetting->furigana_display_name)) ? $eventsetting->furigana_display_name : 'フリガナ';
                            $companyLabel = ($eventsetting && !empty($eventsetting->company_display_name)) ? $eventsetting->company_display_name : '会社名';
                        ?>
                        <th style="width: 100px;">ID</th>
                        <th><?php echo e($nameLabel); ?></th>
                        <th><?php echo e($furiganaLabel); ?></th>
                        <th><?php echo e($companyLabel); ?></th>
                        <th style="width: 220px;">最終入場時間</th>
                        <th style="width: 120px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $inVenueUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($user->id); ?></td>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->furigana); ?></td>
                            <td><?php echo e($user->company); ?></td>
                            <td>
                                <?php if(isset($lastEntryByUser[$user->id])): ?>
                                    <?php echo e(\Carbon\Carbon::parse($lastEntryByUser[$user->id])->format('Y-m-d H:i:s')); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <form method="POST" action="<?php echo e(route('event.in_venue.exit_user', ['event' => $event->id, 'eventuser' => $user->id])); ?>"
                                      onsubmit="return confirm('<?php echo e($user->name); ?> さんを退場にしますか？');" style="margin:0;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-danger">退場</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                <?php echo e(($search ?? '') !== '' ? '該当するユーザーはいません。' : '現在会場にいる登録ユーザーはいません。'); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if(($search ?? '') === ''): ?>
            <h3 class="mt-2" style="font-size:1.1rem;">QRユーザー（<?php echo e(number_format($inVenueQrs->count())); ?>名）</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>QR-ID</th>
                            <th style="width: 120px;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $inVenueQrs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($qr->qr_id); ?></td>
                                <td>
                                    <form method="POST" action="<?php echo e(route('event.in_venue.exit_qr', ['event' => $event->id, 'eventqr' => $qr->id])); ?>"
                                          onsubmit="return confirm('QR（<?php echo e($qr->qr_id); ?>）を退場にしますか？');" style="margin:0;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">退場</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="2" class="text-center text-muted">現在会場にいるQRユーザーはいません。</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/in_venue.blade.php ENDPATH**/ ?>