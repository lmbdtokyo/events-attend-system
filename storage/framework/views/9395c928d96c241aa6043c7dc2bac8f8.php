<?php $__env->startSection('title', 'ダッシュボード | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><?php echo e(__('Dashboard')); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <p><?php echo e(__("You're logged in!")); ?></p>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script> console.log('ページごとJSの記述'); </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/dashboard.blade.php ENDPATH**/ ?>