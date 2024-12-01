<a href="<?php echo e(route('admin.supplier.edit', $model)); ?>" class="btn btn-warning">Edit</a>
<button href="<?php echo e(route('admin.supplier.inactive', $model)); ?>" class="btn btn-danger" id="inactive">Inactive</button>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('button#inactive').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Inactive it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('inactiveForm').action = href;
                document.getElementById('inactiveForm').submit();

                Swal.fire(
                    'Inactived!',
                    'Your file has been inactived.',
                    'success'
                )
            }
        })

    });
</script>
<?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views/admin/supplier/action.blade.php ENDPATH**/ ?>