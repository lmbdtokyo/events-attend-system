


<?php $__env->startSection('title', '申込フォーム基本情報編集 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>申込フォーム基本情報編集</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<form method="POST" action="<?php echo e(route('eventbasic.update', $eventbasic->id)); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PATCH'); ?>

    <div class="card">
        <div class="card-body">

            <div>
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <table class="basic-table">
                <tr>
                    <th><label for="title">フォームのタイトル</label></th>
                    <td><input type="text" id="title" name="title" class="form-control" value="<?php echo e($eventbasic->title ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th><label for="image">画像</label></th>
                    <td>
                        <?php if($eventbasic->image): ?>
                            <img src="<?php echo e(asset('storage/images/' . basename($eventbasic->image))); ?>" alt="Event Image" style="max-width: 500px; margin:0px 0px 20px 0px;">
                        <?php else: ?>
                            <img src="<?php echo e(asset('images/no-image.png')); ?>" style="max-width: 500px; margin:0px 0px 20px 0px;" alt="Logo">
                        <?php endif; ?>
                        <input type="file" id="image" name="image" class="form-control">
                        <?php if($errors->has('image')): ?>
                            <span class="text-danger"><?php echo e($errors->first('image')); ?></span>
                        <?php endif; ?>
                        <p class="small" style="margin-top:10px;">推奨サイズ : 1280px x 400px 最大容量 : 5MB</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="limit">受付人数制限</label></th>
                    <td>
                        <input type="radio" id="limit_no" name="limit" value="0" <?php echo e($eventbasic->limit == 0 ? 'checked' : ''); ?>> しない
                        <input type="radio" id="limit_yes" name="limit" value="1" <?php echo e($eventbasic->limit == 1 ? 'checked' : ''); ?>> する
                    </td>
                </tr>
                <tr id="limit_number_row" style="display: <?php echo e($eventbasic->limit == 1 ? 'table-row' : 'none'); ?>">
                    <th><label for="limit_number">制限数</label></th>
                    <td><input type="number" id="limit_number" name="limit_number" class="form-control" value="<?php echo e($eventbasic->limit_number ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th><label for="start">申込受付開始日時:</label></th>
                    <td><input type="datetime-local" id="start" name="start" class="form-control" value="<?php echo e($eventbasic->start ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th><label for="end">申込受付終了日時:</label></th>
                    <td><input type="datetime-local" id="end" name="end" class="form-control" value="<?php echo e($eventbasic->end ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th><label for="overview_title">概要タイトル</label></th>
                    <td><input type="text" id="overview_title" name="overview_title" class="form-control" value="<?php echo e($eventbasic->overview_title ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th><label for="overview_text">概要テキスト</label></th>
                    <td><textarea id="overview_text" name="overview_text" class="form-control"><?php echo e($eventbasic->overview_text ?? ''); ?></textarea></td>
                </tr>
                <tr>
                    <th><label for="terms">利用規約</label></th>
                    <td><textarea id="terms" name="terms" class="form-control"><?php echo e($eventbasic->terms ?? ''); ?></textarea></td>
                </tr>
                <tr>
                    <th><label for="privacy">プライバシーポリシー</label></th>
                    <td><textarea id="privacy" name="privacy" class="form-control"><?php echo e($eventbasic->privacy ?? ''); ?></textarea></td>
                </tr>
            </table>

            <input type="hidden" name="event_id" value="<?php echo e($eventbasic->event_id); ?>">
            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">編集完了</button>
            </div>

        </div>
    </div>
    
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const limitNo = document.getElementById('limit_no');
        const limitYes = document.getElementById('limit_yes');
        const limitNumberRow = document.getElementById('limit_number_row');
    
        function toggleLimitNumberRow() {
            if (limitYes.checked) {
                limitNumberRow.style.display = 'table-row';
            } else {
                limitNumberRow.style.display = 'none';
            }
        }
    
        limitNo.addEventListener('change', toggleLimitNumberRow);
        limitYes.addEventListener('change', toggleLimitNumberRow);
    
        // 初期状態の設定
        toggleLimitNumberRow();


    });
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/edit.blade.php ENDPATH**/ ?>