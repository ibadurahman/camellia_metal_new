

<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php echo $__env->make('templates.partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Supplier List</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-12 d-flex justify-content-between">
                                <a href="<?php echo e(route('admin.supplier.create')); ?>" class="btn btn-primary">Add Supplier</a>
                                <a href="<?php echo e(route('admin.supplier.inactivated')); ?>" class="">See Inactivated
                                    Supplier</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Grade</th>
                                        <th>Diameter (mm)</th>
                                        <th>Qty (Kg)</th>
                                        <th>Qty (Coil)</th>
                                        <th>Qty (Bundle)</th>
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
    <form action="" method="post" id="inactiveForm" hidden>
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '<?php echo e(route('admin.supplier.data')); ?>',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'grade'
                    },
                    {
                        data: 'diameter'
                    },
                    {
                        data: 'qty_kg'
                    },
                    {
                        data: 'qty_coil'
                    },
                    {
                        data: 'qty_bundle'
                    },
                    {
                        data: 'action'
                    }
                ],
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views/admin/supplier/index.blade.php ENDPATH**/ ?>