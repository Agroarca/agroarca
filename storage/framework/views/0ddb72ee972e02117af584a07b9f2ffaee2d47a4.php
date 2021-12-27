<?php if (isset($component)) { $__componentOriginalf2fc25817978880b0a2470cd8db092f1b6fefc5b = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin::class, []); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h1>Usuarios</h1>
     <?php $__env->endSlot(); ?>

    <div class="card card-default">
        <div class="card-body table-responsive p-0">
            <table class="table table-stripped table-hover">
                <thead>
                    <th>Nome</th>
                    <th class="d-none d-md-table-cell">CPF ou CNPJ</th>
                    <th class="d-none d-md-table-cell">Tipo</th>
                    <th class="d-none d-md-table-cell">Celular</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($usuario->nome); ?></td>
                            <td class="d-none d-md-table-cell"><?php echo e($usuario->documento); ?></td>
                            <td class="d-none d-md-table-cell"><?php echo e($usuario->nomeTipoPessoa); ?></td>
                            <td class="d-none d-md-table-cell"><?php echo e($usuario->celularFormatado); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.cadastros.usuarios.editar', [$usuario->id])); ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php echo e($usuarios->links()); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf2fc25817978880b0a2470cd8db092f1b6fefc5b)): ?>
<?php $component = $__componentOriginalf2fc25817978880b0a2470cd8db092f1b6fefc5b; ?>
<?php unset($__componentOriginalf2fc25817978880b0a2470cd8db092f1b6fefc5b); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/agroarca/resources/views/admin/cadastros/usuarios/inicio.blade.php ENDPATH**/ ?>