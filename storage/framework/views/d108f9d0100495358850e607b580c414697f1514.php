<!DOCTYPE html>
<html lang="en">
    <?php echo $__env->make('templates.partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">
    <?php echo $__env->make('templates.partials.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('templates.partials.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('templates.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php echo $__env->make('templates.partials.content-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>
  </div>
  <!-- /.content-wrapper -->
  <?php echo $__env->make('templates.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php echo $__env->make('templates.partials.control-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<!-- ./wrapper -->
    <?php echo $__env->make('templates.partials.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html>
<?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views/templates/default.blade.php ENDPATH**/ ?>