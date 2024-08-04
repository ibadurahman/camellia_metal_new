<!DOCTYPE html>
<html lang="en">
    <?php echo $__env->make('auth.templates.partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <body class="hold-transition register-page">
        <?php echo $__env->yieldContent('content'); ?>

        <?php echo $__env->make('auth.templates.partials.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
</html>
<?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\local\resources\views/auth/templates/default.blade.php ENDPATH**/ ?>