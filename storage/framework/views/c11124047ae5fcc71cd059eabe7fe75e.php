<?php $__env->startSection('title', '申込完了メール設定 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>申込完了メール設定</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <form id="form" action="<?php echo e(route('evententrymail.update', $event->id)); ?>" method="POST">
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
                    申込完了メールの設定を行います。<br>各項目に必要な情報を入力してください。
                </p>

                <table class="table table-bordered event-setting-table">
                    <tr>
                        <th>項目名</th>
                        <th>入力内容</th>
                    </tr>
                    <tr>
                        <td><label for="bcc">BCC</label></td>
                        <td>
                            <input type="text" id="bcc" name="bcc" class="form-control" value="<?php echo e($evententrymail->bcc); ?>">
                            <p class="small">※BCCはカンマ区切りで複数のメールアドレスを入力できます。</p>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="title">メールタイトル</label></td>
                        <td><input type="text" id="title" name="title" class="form-control" value="<?php echo e($evententrymail->title); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="text">メール本文</label></td>
                        <td>
                            <div id="text_editor" style="height: 300px;"></div>
                            <input type="hidden" name="text" id="text">
                        </td>
                    </tr>
                </table>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        var quillText = new Quill('#text_editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });

        <?php if(isset($evententrymail) && $evententrymail->text): ?>
            quillText.root.innerHTML = `<?php echo addslashes($evententrymail->text); ?>`;
        <?php endif; ?>

        document.querySelector('#form').onsubmit = function() {
            var textContent = document.querySelector('#text');
            textContent.value = quillText.root.innerHTML;
        };
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/entrymail.blade.php ENDPATH**/ ?>