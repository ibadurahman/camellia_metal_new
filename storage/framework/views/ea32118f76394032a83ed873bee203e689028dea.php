<a href="<?php echo e(route('admin.user.edit',$model)); ?>" class="btn btn-warning">Edit</a>
<button dusk="reset_<?php echo e($model->id); ?>" href="<?php echo e(route('admin.user.reset.password')); ?>" class="btn btn-success" id="reset-password">Reset Password</button>
<button dusk="inactive_<?php echo e($model->id); ?>" href="<?php echo e(route('admin.user.inactive',$model)); ?>" class="btn btn-danger" id="inactive">Inactive</button>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
 $('button#inactive').on('click', function(e){
     e.preventDefault();
     var href = $(this).attr('href');
     Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Non-activate this account!'
        }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('inactiveForm').action=href;
            document.getElementById('inactiveForm').submit();
        }
    })
 });
 $('button#reset-password').on('click', function(e){
     e.preventDefault();
     var href = $(this).attr('href');
     Swal.fire({
        title: 'Are you sure?',
        text: "This user password will be default(12345678), You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reset it!'
        }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('resetPasswordForm').action=href;
            document.getElementById('resetPasswordForm').submit();
            
            Swal.fire(
            'Updated!',
            'Password has been reset',
            'success'
            )
        }
    })
 });
</script><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\admin\user\action.blade.php ENDPATH**/ ?>