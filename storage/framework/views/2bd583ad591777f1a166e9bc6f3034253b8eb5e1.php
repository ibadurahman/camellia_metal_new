<button dusk="activate_<?php echo e($model->id); ?>" href="<?php echo e(route('admin.user.activate', $model)); ?>" class="btn btn-success"
    id="activate">Activate</button>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('button#activate').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, activate this account!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('activateForm').action = href;
                document.getElementById('activateForm').submit();

            }
        })
    });
</script>
<?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\admin\user\nonactiveAction.blade.php ENDPATH**/ ?>