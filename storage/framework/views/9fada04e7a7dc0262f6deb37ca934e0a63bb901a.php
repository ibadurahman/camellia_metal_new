

<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php echo $__env->make('templates.partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Machine List</h3>
                        </div>
                        <div class="card-body">
                            <a href="<?php echo e(route('admin.machine.create')); ?>" class="btn btn-primary">Add Machine</a>         
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Line</th>
                                        <th>IP Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div> 
                    </div>          
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->   
    <form action="" method="POST" id="deleteForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field("DELETE"); ?>
        <input type="submit" value="Delete" style="display:none">
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(function () {
      $('#dataTable').DataTable({
        processing:true,
        serverSide:true,
        ajax:'<?php echo e(route('admin.machine.data')); ?>',
        columns:[
            {data:'DT_RowIndex',orderable:false, searchable:false},
            {data:'name'},
            {data:'line'},
            {data:'ip_address'},
            {data:'action'}
        ],
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\admin\machine\index.blade.php ENDPATH**/ ?>