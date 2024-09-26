

<?php $__env->startSection('title', '所属組織一覧 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>所属組織一覧</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <a href="<?php echo e(route('organization.create')); ?>" class="btn btn-primary mb-2 float-right">新規作成</a>
                        <table class="organization-table">
                            <tr>
                                <th class="organization-id-td">ID</th>
                                <th class="organization-name-td">組織名</th>
                                <th class="organization-create-td">作成日</th>
                                <th class="organization-edit-td"></th>
                            </tr>
                        <?php $__currentLoopData = $Usersorganizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Usersorganization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="organization-id-td"><?php echo e($Usersorganization->id); ?></td>
                            <td class="organization-name-td"><?php echo e($Usersorganization->name); ?></td>
                            <td class="organization-create-td"><?php echo e($Usersorganization->created_at); ?></td>
                            
                            <td class="organization-edit-td">
                                <a href="<?php echo e(route('organization.edit', $Usersorganization->id)); ?>" class="btn btn-primary">編集</a>
                                <form action="<?php echo e(route('organization.destroy', $Usersorganization->id)); ?>" method="POST" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
                                </form>
                            </td>
                            
                        </tr>
                        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>

                    </div>


                    <div class="pagination justify-content-center">
                        <?php echo e($Usersorganizations->links()); ?>

                    </div>


                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script> console.log('ページごとJSの記述'); </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/organization/index.blade.php ENDPATH**/ ?>