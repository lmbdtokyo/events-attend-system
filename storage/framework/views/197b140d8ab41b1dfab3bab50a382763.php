<?php $__env->startSection('title', 'イベント情報編集 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>イベント情報編集</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
            <h2 class="card-title event-title"><b><?php echo e($event->name); ?></b></h2>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('events.update', $event->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                
                <div class="form-group">
                    <label for="name">イベント名</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name', $event->name)); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="form-group">
                    <label for="organization">開催組織</label>
                    <input type="text" class="form-control" id="organization" name="organization" value="<?php echo e(\App\Models\Usersorganization::find($event->organization)->name); ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label for="place">開催場所</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['place'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="place" name="place" value="<?php echo e(old('place', $event->place)); ?>" required>
                    <?php $__errorArgs = ['place'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="form-group">
                    <label>開催日時</label>
                    <?php
                        $eventDates = old('event_date', json_decode($event->event_date, true));
                    ?>
                    <div id="event-dates-container">
                        <?php $__currentLoopData = $eventDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="input-group mb-3 event-date-row">
                                <input type="date" class="form-control <?php $__errorArgs = ['event_date.'.$index.'.date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="event_date[<?php echo e($index); ?>][date]" value="<?php echo e($date['date']); ?>" required>
                                <input type="time" class="form-control <?php $__errorArgs = ['event_date.'.$index.'.starttime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="event_date[<?php echo e($index); ?>][starttime]" value="<?php echo e(\Carbon\Carbon::parse($date['starttime'])->format('H:i')); ?>" required>
                                <input type="time" class="form-control <?php $__errorArgs = ['event_date.'.$index.'.endtime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="event_date[<?php echo e($index); ?>][endtime]" value="<?php echo e(\Carbon\Carbon::parse($date['endtime'])->format('H:i')); ?>" required>
                                <button type="button" class="btn btn-danger remove-date">削除</button>
                            </div>
                            <?php $__errorArgs = ['event_date.'.$index.'.date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php $__errorArgs = ['event_date.'.$index.'.starttime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php $__errorArgs = ['event_date.'.$index.'.endtime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <button type="button" class="btn btn-success" id="add-date">日付を追加</button>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const container = document.getElementById('event-dates-container');
                        const addButton = document.getElementById('add-date');
                        let dateIndex = <?php echo e(count($eventDates)); ?>;

                        addButton.addEventListener('click', function() {
                            const newRow = document.createElement('div');
                            newRow.className = 'input-group mb-3 event-date-row';
                            newRow.innerHTML = `
                                <input type="date" class="form-control" name="event_date[${dateIndex}][date]" required>
                                <input type="time" class="form-control" name="event_date[${dateIndex}][starttime]" required>
                                <input type="time" class="form-control" name="event_date[${dateIndex}][endtime]" required>
                                <button type="button" class="btn btn-danger remove-date">削除</button>
                            `;
                            container.appendChild(newRow);
                            dateIndex++;
                        });

                        container.addEventListener('click', function(e) {
                            if (e.target.classList.contains('remove-date')) {
                                e.target.closest('.event-date-row').remove();
                            }
                        });
                    });
                    </script>
                </div>
                
                <div class="form-group">
                    <label for="approval">承認</label>
                    <select class="form-control <?php $__errorArgs = ['approval'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="approval" name="approval">
                        <option value="0" <?php echo e(old('approval', $event->approval) == 0 ? 'selected' : ''); ?>>なし</option>
                        <option value="1" <?php echo e(old('approval', $event->approval) == 1 ? 'selected' : ''); ?>>あり</option>
                    </select>
                    <?php $__errorArgs = ['approval'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <button type="submit" class="btn btn-primary">更新</button>
                <a href="<?php echo e(route('events.index')); ?>" class="btn btn-secondary">キャンセル</a>
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('events.destroy', $event->id)); ?>" onsubmit="return confirm('ご注意：削除すると、申込・来場状況や設定した情報がすべて削除され、元に戻せません。本当に削除しますか？');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-danger">削除</button>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/edit.blade.php ENDPATH**/ ?>