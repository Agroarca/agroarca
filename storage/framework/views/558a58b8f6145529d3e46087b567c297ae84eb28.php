<?php $__env->startPush('css'); ?>
    <?php if(isset($css)): ?>
        <?php echo e($css); ?>

    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo e(mix('css/vendor.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(mix('css/style.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content_header'); ?>
    <?php if(isset($header)): ?>
        <?php echo e($header); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo e($slot); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(mix('js/app.js')); ?>"></script>
    <?php if(isset($js)): ?>
        <?php echo e($js); ?>

    <?php endif; ?>
<?php $__env->stopPush(); ?>


<?php if (! empty(trim($__env->yieldContent('InputMask')))): ?>
    <?php if (! $__env->hasRenderedOnce('bae891f4-7ff1-4bf1-97b9-d4d699d87762')): $__env->markAsRenderedOnce('bae891f4-7ff1-4bf1-97b9-d4d699d87762'); ?>
        <?php $__env->startPrepend('js'); ?>
            <script src="<?php echo e(mix('js/inputmask.js')); ?>"></script>
        <?php $__env->stopPrepend(); ?>
    <?php endif; ?>
<?php endif; ?>


<?php if (! empty(trim($__env->yieldContent('CropperJS')))): ?>
    <?php if (! $__env->hasRenderedOnce('8baca199-4160-40e8-a715-721f2674852a')): $__env->markAsRenderedOnce('8baca199-4160-40e8-a715-721f2674852a'); ?>
        <?php $__env->startPrepend('js'); ?>
            <script src="<?php echo e(mix('js/cropper.js')); ?>"></script>
        <?php $__env->stopPrepend(); ?>
    <?php endif; ?>
<?php endif; ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/agroarca/resources/views/layouts/admin.blade.php ENDPATH**/ ?>