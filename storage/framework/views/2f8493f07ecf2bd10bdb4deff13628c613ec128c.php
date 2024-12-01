<?php if(session('success')): ?>
    <div role="alert" class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<?php if(session('failed')): ?>
    <div role="alert" class="alert alert-danger alert-dismissible fade show">
        <?php echo e(session('failed')); ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\templates\partials\alerts.blade.php ENDPATH**/ ?>