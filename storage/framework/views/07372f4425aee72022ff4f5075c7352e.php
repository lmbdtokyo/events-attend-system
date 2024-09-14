<?php $__env->startSection('title', 'マイページ基本設定 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>マイページ基本設定</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('eventmypagebasic.update', $event->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <div class="card">
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
                        <p><?php echo e(session('success')); ?></p>
                    </div>
                <?php endif; ?>

                <p>
                    マイページの基本設定を行います。<br>各項目に必要な情報を入力してください。
                </p>

                <table class="table table-bordered event-setting-table">
                    <tr>
                        <th>項目名</th>
                        <th>入力内容</th>
                    </tr>
                    <tr>
                        <td><label for="endtime">終了時間</label></td>
                        <td><input type="datetime-local" id="endtime" name="endtime" class="form-control" value="<?php echo e($eventmypagebasic->endtime); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="image">画像</label></td>
                        <td>
                            <?php if($eventmypagebasic->image): ?>
                                <div class="mt-2">
                                    <img src="<?php echo e(Storage::url($eventmypagebasic->image)); ?>" alt="マイページ画像" style="max-width: 350px; margin:0px 0px 20px 0px;">
                                </div>
                            <?php else: ?>
                                <img src="<?php echo e(asset('images/no-image.png')); ?>" style="max-width: 350px; margin:0px 0px 20px 0px;" alt="Logo">
                            <?php endif; ?>
                            <input type="file" id="image" name="image" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="title">お知らせタイトル</label></td>
                        <td><input type="text" id="title" name="title" class="form-control" value="<?php echo e($eventmypagebasic->title); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="text">お知らせ内容</label></td>
                        <td><textarea id="text" name="text" class="form-control"><?php echo e($eventmypagebasic->text); ?></textarea></td>
                    </tr>
                </table>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/mypagebasic.blade.php ENDPATH**/ ?>