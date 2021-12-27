<?php if (isset($component)) { $__componentOriginalf2fc25817978880b0a2470cd8db092f1b6fefc5b = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin::class, []); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="row">
            <div class="col-sm-8">
                <h1>Marcas</h1>
            </div>
            <div class="col-sm-4 pt-3 pt-sm-0">
                <a href="<?php echo e(route('admin.estoque.marcas.criar')); ?>" class="btn btn-primary float-sm-right"><i class="fas fa-plus-circle pr-1"></i>Nova Marca</a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="card card-default">
        <div class="card-body table-responsive p-0">
            <table class="table table-stripped table-hover">
                <thead>
                    <th>Nome</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $marcas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($marca->nome); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.estoque.marcas.editar', [$marca->id])); ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="<?php echo e(route('admin.estoque.marcas.excluir', [$marca->id])); ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Excluir">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php echo e($marcas->links()); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf2fc25817978880b0a2470cd8db092f1b6fefc5b)): ?>
<?php $component = $__componentOriginalf2fc25817978880b0a2470cd8db092f1b6fefc5b; ?>
<?php unset($__componentOriginalf2fc25817978880b0a2470cd8db092f1b6fefc5b); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/agroarca/resources/views/admin/estoque/marcas/inicio.blade.php ENDPATH**/ ?>