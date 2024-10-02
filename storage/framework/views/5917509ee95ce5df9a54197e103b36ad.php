<?php $__env->startSection('title', '管理ユーザー一覧 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>管理ユーザー一覧</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <a href="<?php echo e(route('user.create')); ?>" class="btn btn-success mb-2 float-right">新規作成</a>
            <table id="users-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名前</th>
                        <th>メールアドレス</th>
                        <th>所属組織</th>
                        <th>権限</th>
                        <th>種別</th>
                        <th>作成日</th>
                        <th>アクション</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($user->id); ?></td>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td>
                                <?php $__currentLoopData = $organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($organization->id == $user->organization): ?>
                                        <?php echo e($organization->name); ?>

                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td>
                                <?php $__currentLoopData = $auths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($auth->id == $user->auth): ?>
                                        <?php echo e($auth->name); ?>

                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td><?php echo e($user->type); ?></td>
                            <td><?php echo e($user->created_at); ?></td>
                            <td>
                                <?php if($user->type !== 'master'): ?>
                                    <a href="<?php echo e(route('user.edit', $user->id)); ?>" class="btn btn-primary btn-sm">編集</a>
                                    <form action="<?php echo e(route('user.destroy', $user->id)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="pagination justify-content-center">
            <?php echo e($users->links()); ?>

        </div>

        <!-- /.card-body -->
    </div>
    <!-- /.card -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="/css/admin_custom.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(function () {
            $('#users-table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/user/index.blade.php ENDPATH**/ ?>