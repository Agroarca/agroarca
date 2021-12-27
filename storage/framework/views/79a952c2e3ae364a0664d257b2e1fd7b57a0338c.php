<header>
    <div class="contact">
        <div class="container contact-container">
            <span class="phone"><i class="fas fa-phone-alt"></i>+55 54 9902-0345</span>
            <span class="mail"><i class="fas fa-envelope"></i>contato@agroarca.com.br</span>
        </div>
    </div>

    <div class="main container">
        <div class="logo-container">
            <img class="logo" src="<?php echo e(asset('img/logo.png')); ?>">
        </div>
        <div class="search-container">
            <input type="text" class="search">
        </div>
        <div class="arca-container">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <a class="profile-container" href="<?php echo e(route('dashboard')); ?>">
            <i class="fas fa-user"></i>
            Minha Conta
        </a>
    </div>

    <div class="menu-content">
        <?php if (isset($component)) { $__componentOriginala053075aa979d59fd7538c237d81f3e3585dd1d4 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Site\Menu::class, []); ?>
<?php $component->withName('site.menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala053075aa979d59fd7538c237d81f3e3585dd1d4)): ?>
<?php $component = $__componentOriginala053075aa979d59fd7538c237d81f3e3585dd1d4; ?>
<?php unset($__componentOriginala053075aa979d59fd7538c237d81f3e3585dd1d4); ?>
<?php endif; ?>
    </div>
</header>
<?php /**PATH /var/www/html/agroarca/resources/views/components/site/header.blade.php ENDPATH**/ ?>