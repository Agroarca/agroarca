<html>
    <head>
        <link href="<?php echo e(mix('css/vendor.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(mix('css/site.css')); ?>" rel="stylesheet">
    </head>
    <body>
        <div class="reference"></div>
        <?php if (isset($component)) { $__componentOriginalf7f7436f0d0498c8bcfc14ed22899299ccbf0743 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Site\Header::class, []); ?>
<?php $component->withName('site.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7f7436f0d0498c8bcfc14ed22899299ccbf0743)): ?>
<?php $component = $__componentOriginalf7f7436f0d0498c8bcfc14ed22899299ccbf0743; ?>
<?php unset($__componentOriginalf7f7436f0d0498c8bcfc14ed22899299ccbf0743); ?>
<?php endif; ?>

        <?php echo e($slot); ?>

    </body>
</html>
<?php /**PATH /var/www/html/agroarca/resources/views/layouts/site.blade.php ENDPATH**/ ?>