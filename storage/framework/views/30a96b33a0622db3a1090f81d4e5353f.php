<?php $__env->startSection('title', 'イベント詳細 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title event-title"><b><?php echo e($event->name); ?></b></h2>
        </div>
        <div class="card-body">

            <h2 class="text-lg font-medium text-gray-900">事前設定進捗</h2>
            
            <div class="row">
                <div class="col-md-6">
                    <table class="event-progress-table table table-bordered">
                        <tbody>
                            <tr>
                                <td style="width: 15%; vertical-align: middle; text-align:center;">
                                    <?php if($eventProgressData[0]->form_basic_flg == 0): ?>
                                        <b class="redText">未設定</b>
                                    <?php else: ?>
                                        <b class="greenText">設定済</b>
                                    <?php endif; ?>
                                </td>
                                <td style="width: 65%; vertical-align: middle;">申込フォーム基本設定</th>
                                <td style="width: 20%; text-align: center;">
                                    <a href="" class="btn btn-primary">編集</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%; vertical-align: middle; text-align:center;">
                                    <?php if($eventProgressData[0]->form_setting_flg == 0): ?>
                                        <b class="redText">未設定</b>
                                    <?php else: ?>
                                        <b class="greenText">設定済</b>
                                    <?php endif; ?>
                                </td>
                                <td style="width: 65%; vertical-align: middle;">申込フォーム項目設定</th>
                                <td style="width: 20%; text-align: center;">
                                    <a href="" class="btn btn-primary">編集</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%; vertical-align: middle; text-align:center;">
                                    <?php if($eventProgressData[0]->mypage_basic_flg == 0): ?>
                                        <b class="redText">未設定</b>
                                    <?php else: ?>
                                        <b class="greenText">設定済</b>
                                    <?php endif; ?>
                                </td>
                                <td style="width: 65%; vertical-align: middle;">マイページ基本設定</th>
                                <td style="width: 20%; text-align: center;">
                                    <a href="" class="btn btn-primary">編集</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="event-progress-table table table-bordered">
                        <tbody>
                            <tr>
                                <td style="width: 15%; vertical-align: middle; text-align:center;">
                                    <?php if($eventProgressData[0]->finish_mail_flg == 0): ?>
                                        <b class="redText">未設定</b>
                                    <?php else: ?>
                                        <b class="greenText">設定済</b>
                                    <?php endif; ?>
                                </td>
                                <td style="width: 65%; vertical-align: middle;">申込完了メール</th>
                                <td style="width: 20%; text-align: center;">
                                    <a href="" class="btn btn-primary">編集</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%; vertical-align: middle; text-align:center;">
                                    <?php if($eventProgressData[0]->entry_mail_flg == 0): ?>
                                        <b class="redText">未設定</b>
                                    <?php else: ?>
                                        <b class="greenText">設定済</b>
                                    <?php endif; ?>
                                </td>
                                <td style="width: 65%; vertical-align: middle;">入場時本人メール設定</th>
                                <td style="width: 20%; text-align: center;">
                                    <a href="" class="btn btn-primary">編集</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%; vertical-align: middle; text-align:center;">
                                    <?php if($eventProgressData[0]->exit_mail_flg == 0): ?>
                                        <b class="redText">未設定</b>
                                    <?php else: ?>
                                        <b class="greenText">設定済</b>
                                    <?php endif; ?>
                                </td>
                                <td style="width: 65%; vertical-align: middle;">退場時本人メール設定</th>
                                <td style="width: 20%; text-align: center;">
                                    <a href="" class="btn btn-primary">編集</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>



            <h2 class="text-lg font-medium text-gray-900" style="margin-top: 30px;">イベント基本情報</h2>

            <table class="event-detail-table table table-bordered">
                <tbody>
                    <tr>
                        <th>開催組織</th>
                        <td><?php echo e(\App\Models\Usersorganization::find($event->organization)->name); ?></td>
                    </tr>
                    <tr>
                        <th>開催場所</th>
                        <td><?php echo e($event->place); ?></td>
                    </tr>
                    <tr>
                        <th>開催日時</th>
                        <td>
                            <ul class="list-unstyled">
                            <?php $__currentLoopData = json_decode($event->event_date, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <?php echo e($date['date']); ?> <?php echo e(\Carbon\Carbon::parse($date['starttime'])->format('H:i')); ?>～<?php echo e(\Carbon\Carbon::parse($date['endtime'])->format('H:i')); ?>

                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th>承認</th>
                        <td><?php echo e($event->approval == 0 ? 'なし' : 'あり'); ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4">
                <a href="<?php echo e(route('events.edit', $event->id)); ?>" class="btn btn-primary">基本情報編集</a>
                <a href="<?php echo e(route('events.index')); ?>" class="btn btn-secondary">戻る</a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/show.blade.php ENDPATH**/ ?>