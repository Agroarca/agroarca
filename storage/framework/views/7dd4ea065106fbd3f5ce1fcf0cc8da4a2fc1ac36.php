<?php if (isset($component)) { $__componentOriginal829a229d00ad4f9951f1189b47f2b82eec3c9266 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Site::class, []); ?>
<?php $component->withName('site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <div class="auth login container">
        <div class="form">
            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                <h2>Entrar:</h2>
                <div>
                    <?php if($errors->any()): ?>
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="email">E-mail:</label>
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required>
                </div>
                <div>
                    <label for="password">Senha:</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                </div>
                <div>
                    <label for="remember_me" class="check-label">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Manter conectado?</span>
                    </label>
                </div>

                <div class="botoes">
                    <button type="submit" class="btn">Entrar</button>

                    <?php if(Route::has('password.request')): ?>
                        <a class="link" href="<?php echo e(route('password.request')); ?>">Esqueceu sua Senha?</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <div class="form register">
            <form method="POST" action="<?php echo e(route('register')); ?>">
                <?php echo csrf_field(); ?>
                <h2>Registrar:</h2>
                <div>
                    <?php if($errors->any()): ?>
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="nome">Nome:</label>
                    <input id="nome" type="text" name="nome" value="<?php echo e(old('nome')); ?>" required>
                </div>
                <div>
                    <label for="email">E-mail:</label>
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required>
                </div>
                <div>
                    <label for="cpf_cnpj">Cpf ou Cnpj:</label>
                    <input id="cpf_cnpj" type="text" name="cpf_cnpj" value="<?php echo e(old('cpf_cnpj')); ?>" required>
                </div>
                <div>
                    <label for="celular">Celular:</label>
                    <input id="celular" type="text" name="celular" value="<?php echo e(old('celular')); ?>" required>
                </div>
                <div>
                    <label for="password">Senha:</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password">
                </div>
                <div>
                    <label for="password_confirmation">Confirmar Senha:</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>

                <div class="botoes">
                    <button class="btn" type="submit">Registrar</button>
                </div>
            </form>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal829a229d00ad4f9951f1189b47f2b82eec3c9266)): ?>
<?php $component = $__componentOriginal829a229d00ad4f9951f1189b47f2b82eec3c9266; ?>
<?php unset($__componentOriginal829a229d00ad4f9951f1189b47f2b82eec3c9266); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/agroarca/resources/views/auth/login.blade.php ENDPATH**/ ?>