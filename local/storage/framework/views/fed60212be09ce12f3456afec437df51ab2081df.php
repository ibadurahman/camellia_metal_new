<?php if($model->machine->ip_address == request()->ip()): ?>
    <a href="<?php echo e(url('operator/production/' . $model->id . '/show')); ?>" class="btn btn-primary">Go To Report Page</a>
<?php else: ?>
    <?php if(auth()->user()->hasRole('supervisor|super-admin|owner')): ?>
        <a href="<?php echo e(url('operator/production/' . $model->id . '/show')); ?>" class="btn btn-success">Supervise</a>
    <?php else: ?>
        <span class="text-danger">you have no rights to process this workorder</span>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\local\resources\views/operator/production/action.blade.php ENDPATH**/ ?>