

<li class="nav-item adminlte-darkmode-widget">

    <a class="nav-link" href="#" role="button">
        <i class="<?php echo e($makeIconClass()); ?>"></i>
    </a>

</li>



<?php if (! $__env->hasRenderedOnce('f4a18660-1f83-46d4-941b-2f54b7c5f799')): $__env->markAsRenderedOnce('f4a18660-1f83-46d4-941b-2f54b7c5f799'); ?>
<?php $__env->startPush('js'); ?>
<script>

    $(() => {

        const body = document.querySelector('body');
        const widget = document.querySelector('li.adminlte-darkmode-widget');
        const widgetIcon = widget.querySelector('i');

        // Get the set of classes to be toggled on the widget icon.

        const iconClasses = [
            ...<?php echo json_encode($makeIconEnabledClass(), 15, 512) ?>,
            ...<?php echo json_encode($makeIconDisabledClass(), 15, 512) ?>
        ];

        // Add 'click' event listener for the darkmode widget.

        widget.addEventListener('click', () => {

            // Toggle dark-mode class on the body tag.

            body.classList.toggle('dark-mode');

            // Toggle the classes on the widget icon.

            iconClasses.forEach((c) => widgetIcon.classList.toggle(c));

            // Notify the server. The server will be in charge to persist
            // the dark mode configuration over multiple request.

            const fetchCfg = {
                headers: {'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'},
                method: 'POST',
            };

            fetch(
                "<?php echo e(route('adminlte.darkmode.toggle')); ?>",
                fetchCfg
            )
            .catch((error) => {
                console.log(
                    'Failed to notify server that dark mode was toggled',
                    error
                );
            });
        });
    })

</script>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/agroarca/vendor/jeroennoten/laravel-adminlte/src/../resources/views/components/layout/navbar-darkmode-widget.blade.php ENDPATH**/ ?>