<?php $__env->startSection('title', 'アンケート項目設定'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>アンケート項目設定</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">アンケート項目設定</h3>
                    </div>
                    <div class="card-body">
                    <form action="<?php echo e(route('eventsurvey.update', $event->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>

                        <table class="table table-bordered" id="survey-table">
                            <thead>
                                <tr>
                                    <th>質問</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($eventsurveys): ?>
                                    <?php $__currentLoopData = $eventsurveys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><input type="text" name="qa[<?php echo e($index); ?>]" class="form-control" value="<?php echo e($question); ?>"></td>
                                            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">削除</button></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary" onclick="addRow()">追加</button>
                        <button type="submit" class="btn btn-success">保存</button>
                    </form>

                    <script>
                        function addRow() {
                            const table = document.getElementById('survey-table').getElementsByTagName('tbody')[0];
                            const rowCount = table.rows.length;
                            const row = table.insertRow(rowCount);
                            const cell1 = row.insertCell(0);
                            const cell2 = row.insertCell(1);

                            cell1.innerHTML = `<input type="text" name="qa[${rowCount}]" class="form-control">`;
                            cell2.innerHTML = `<button type="button" class="btn btn-danger" onclick="removeRow(this)">削除</button>`;
                        }

                        function removeRow(button) {
                            const row = button.parentNode.parentNode;
                            row.parentNode.removeChild(row);
                        }
                    </script>
                    </div>
                </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/survey.blade.php ENDPATH**/ ?>