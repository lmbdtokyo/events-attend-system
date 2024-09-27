

<?php $__env->startSection('title', '申込者承認 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>申込者承認</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">

            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php if($eventUsers->isEmpty()): ?>
                <p>申込者がいません。</p>
            <?php else: ?>
                <ul class="nav nav-tabs" id="approvalTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#approval0">未承認</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#approval1">承認済み</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#approval2">却下</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="approval0">
                        <?php if($eventUsers->where('approval', 0)->isEmpty()): ?>
                            <p>未承認の申込者がいません。</p>
                        <?php else: ?>
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
                                        <th>登録日</th>
                                        <th>承認</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $eventUsers->where('approval', 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($eventUser->id); ?></td>
                                            <td><?php echo e($eventUser->name); ?></td>
                                            <td><?php echo e($eventUser->furigana); ?></td>
                                            <td><?php echo e($eventUser->company); ?></td>
                                            <td><?php echo e($eventUser->division); ?></td>
                                            <td><?php echo e($eventUser->post); ?></td>
                                            <td><?php echo e($eventUser->mail); ?></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($eventUser->created_at)->format('Y-m-d')); ?></td>
                                            <td>
                                                <form action="<?php echo e(route('event.approval.update', [$event->id, $eventUser->id])); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <input type="hidden" name="eventuser_id" value="<?php echo e($eventUser->id); ?>">
                                                    <button type="submit" name="approval" value="1" class="btn btn-success btn-sm">承認</button>
                                                    <button type="submit" name="approval" value="2" class="btn btn-danger btn-sm">非承認</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade" id="approval1">
                        <?php if($eventUsers->where('approval', 1)->isEmpty()): ?>
                            <p>承認済みの申込者がいません。</p>
                        <?php else: ?>
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
                                        <th>登録日</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $eventUsers->where('approval', 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($eventUser->id); ?></td>
                                            <td><?php echo e($eventUser->name); ?></td>
                                            <td><?php echo e($eventUser->furigana); ?></td>
                                            <td><?php echo e($eventUser->company); ?></td>
                                            <td><?php echo e($eventUser->division); ?></td>
                                            <td><?php echo e($eventUser->post); ?></td>
                                            <td><?php echo e($eventUser->mail); ?></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($eventUser->created_at)->format('Y-m-d')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade" id="approval2">
                        <?php if($eventUsers->where('approval', 2)->isEmpty()): ?>
                            <p>却下された申込者がいません。</p>
                        <?php else: ?>
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
                                        <th>登録日</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $eventUsers->where('approval', 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($eventUser->id); ?></td>
                                            <td><?php echo e($eventUser->name); ?></td>
                                            <td><?php echo e($eventUser->furigana); ?></td>
                                            <td><?php echo e($eventUser->company); ?></td>
                                            <td><?php echo e($eventUser->division); ?></td>
                                            <td><?php echo e($eventUser->post); ?></td>
                                            <td><?php echo e($eventUser->mail); ?></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($eventUser->created_at)->format('Y-m-d')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="d-flex justify-content-center">
                <?php echo e($eventUsers->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/user/approval.blade.php ENDPATH**/ ?>