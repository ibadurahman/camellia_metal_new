<a href="<?php echo e(route('downtimeReason.edit',$model)); ?>" class="btn btn-warning">Edit</a>
<a href="#" onclick="event.preventDefault(); document.getElementById('deleteForm-<?php echo e($model); ?>').submit()" class="btn btn-danger">Delete</a>
<form action="<?php echo e(route('downtimeReason.delete',$model)); ?>" method="POST" id="deleteForm-<?php echo e($model); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\supervisor\downtimereason\action.blade.php ENDPATH**/ ?>