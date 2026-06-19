<?php $__env->startSection('title', '申込者一覧 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>申込者一覧</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="<?php echo e(route('event.users', $event->id)); ?>" class="btn btn-sm btn-dark">全申込者一覧</a>
        <a href="<?php echo e(route('event.records', ['event' => $event->id, 'exit_entry' => 1])); ?>" class="btn btn-sm btn-outline-primary">入場記録</a>
        <a href="<?php echo e(route('event.records', ['event' => $event->id, 'exit_entry' => 2])); ?>" class="btn btn-sm btn-outline-primary">退場記録</a>
        <a href="<?php echo e(route('event.in_venue', $event->id)); ?>" class="btn btn-sm btn-outline-info">現在会場にいる人</a>
        <a href="<?php echo e(route('events.exit_entry_totals', $event->id)); ?>" class="btn btn-sm btn-outline-secondary">集計</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('event.users', $event)); ?>" class="mb-4">
                <div class="row g-2 align-items-end">
                    <div class="col-md-8">
                        <?php
                            $searchLabels = [];
                            $searchLabels[] = ($eventsetting && !empty($eventsetting->name_display_name)) ? $eventsetting->name_display_name : '名前';
                            if (!$eventsetting || $eventsetting->furigana_flg) {
                                $searchLabels[] = ($eventsetting && !empty($eventsetting->furigana_display_name)) ? $eventsetting->furigana_display_name : 'フリガナ';
                            }
                            if (!$eventsetting || $eventsetting->company_flg) {
                                $searchLabels[] = ($eventsetting && !empty($eventsetting->company_display_name)) ? $eventsetting->company_display_name : '会社名';
                            }
                            if (!$eventsetting || $eventsetting->division_flg) {
                                $searchLabels[] = ($eventsetting && !empty($eventsetting->division_display_name)) ? $eventsetting->division_display_name : '部署名';
                            }
                            if (!$eventsetting || $eventsetting->tel_flg) {
                                $searchLabels[] = ($eventsetting && !empty($eventsetting->tel_display_name)) ? $eventsetting->tel_display_name : '電話番号';
                            }
                            $searchLabelText = implode('・', $searchLabels);
                            $searchPlaceholder = 'スペース区切りで複数条件の絞り込み検索ができます（例：山田 営業部）';
                        ?>
                        <label class="form-label">検索（<?php echo e($searchLabelText); ?>）</label>
                        <input type="text" name="search" class="form-control" placeholder="<?php echo e($searchPlaceholder); ?>" value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">検索</button>
                        <?php if(request('search')): ?>
                            <a href="<?php echo e(route('event.users', $event)); ?>" class="btn btn-secondary">クリア</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

            <p class="mb-3">
                <strong>トータル: <?php echo e(number_format($totalCount)); ?>名</strong>
                <?php if(request('search')): ?>
                    <span class="text-muted">（検索結果: <?php echo e(number_format($totalCount)); ?>名）</span>
                <?php endif; ?>
                <a href="<?php echo e(route('event.users.export', array_merge(['event' => $event], request()->only('search')))); ?>" class="btn btn-success btn-sm ml-2">CSVダウンロード</a>
            </p>

            <div class="table-responsive">
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
                            <th>受付区分</th>
                            <th>登録日</th>
                            <th>PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $eventUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($eventUser->id); ?></td>
                                <td>
                                    <?php if(optional($authUser)->type === 'master'): ?>
                                        <a href="<?php echo e(route('event.users.edit', [$event, $eventUser])); ?>"><?php echo e($eventUser->name); ?></a>
                                    <?php else: ?>
                                        <?php echo e($eventUser->name); ?>

                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($eventUser->furigana); ?></td>
                                <td><?php echo e($eventUser->company); ?></td>
                                <td><?php echo e($eventUser->division); ?></td>
                                <td><?php echo e($eventUser->post); ?></td>
                                <td><?php echo e($eventUser->mail); ?></td>
                                <td><?php echo e($eventUser->tel ?: '-'); ?></td>
                                <td>
                                    <?php if(isset($eventSections[$eventUser->section])): ?>
                                        <?php echo e($eventSections[$eventUser->section]->name); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e(\Carbon\Carbon::parse($eventUser->created_at)->format('Y-m-d')); ?></td>
                                <td>
                                    <?php if($eventUser->pdf_name && $eventUser->qr): ?>
                                        <a href="<?php echo e(asset('storage/pdfs/' . $eventUser->qr . '.pdf')); ?>" target="_blank" class="btn btn-sm btn-outline-primary">PDF</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="11" class="text-center">申込者がいません</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <?php echo e($eventUsers->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/user.blade.php ENDPATH**/ ?>