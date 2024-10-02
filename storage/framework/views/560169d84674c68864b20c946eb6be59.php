<?php $__env->startSection('title', '受付区分編集・追加 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>受付区分編集・追加</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
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

    
    <form action="<?php echo e(route('eventsection.update', $event->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>区分名</th>
                    <th>色</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="eventsection-table-body">
                <?php $__currentLoopData = $eventsections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventsection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><input type="text" name="eventsections[<?php echo e($eventsection->id); ?>][name]" class="form-control" value="<?php echo e($eventsection->name); ?>"></td>
                    <td><input type="color" name="eventsections[<?php echo e($eventsection->id); ?>][color]" class="form-control" value="<?php echo e($eventsection->color); ?>"></td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="removeRow(this)">削除</button>
                        <input type="hidden" name="eventsections[<?php echo e($eventsection->id); ?>][delete]" value="0">
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    
        <button type="button" class="btn btn-primary" onclick="addRow()">新しい行を追加</button>
        <button type="submit" class="btn btn-success">保存</button>
    </form>
    
    <script>
        function addRow() {
            const tableBody = document.getElementById('eventsection-table-body');
            const newRow = document.createElement('tr');
    
            newRow.innerHTML = `
                <td><input type="text" name="eventsections[new][name][]" class="form-control"></td>
                <td><input type="color" name="eventsections[new][color][]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">削除</button></td>
            `;
    
            tableBody.appendChild(newRow);
        }
    
        function removeRow(button) {
            const row = button.parentElement.parentElement;
            const deleteInput = row.querySelector('input[type="hidden"]');
            if (deleteInput) {
                deleteInput.value = '1';
                row.style.display = 'none';
            } else {
                row.remove();
            }
        }
    </script>
    


    </div>
</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/section.blade.php ENDPATH**/ ?>