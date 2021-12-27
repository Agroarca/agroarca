<?php if (isset($component)) { $__componentOriginal829a229d00ad4f9951f1189b47f2b82eec3c9266 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Site::class, []); ?>
<?php $component->withName('site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal829a229d00ad4f9951f1189b47f2b82eec3c9266)): ?>
<?php $component = $__componentOriginal829a229d00ad4f9951f1189b47f2b82eec3c9266; ?>
<?php unset($__componentOriginal829a229d00ad4f9951f1189b47f2b82eec3c9266); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/agroarca/resources/views/teste.blade.php ENDPATH**/ ?>