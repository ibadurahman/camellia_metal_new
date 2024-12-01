
<button href="<?php echo e(url('/operator/schedule/'.$model->id.'/process')); ?>" class="btn btn-success d-none process-<?php echo e($model->id); ?>" id="process-<?php echo e($model->id); ?>">Process</button>


<script>
 $('button#process-<?php echo e($model->id); ?>').on('click', function(e){
     e.preventDefault();
     var href = $(this).attr('href');
     Swal.fire({
        title: 'Are you sure want to process this workorder?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, process it!'
        }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('processForm').action=href;
            document.getElementById('processForm').submit();
        }
    })
     
 });
</script>
<?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\operator\schedule\action.blade.php ENDPATH**/ ?>