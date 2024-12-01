

<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php echo $__env->make('templates.partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Nonactive Supplier List</h3>
                        </div>
                        <div class="card-body">
                            <a href="<?php echo e(route('admin.supplier.index')); ?>" class="">Back to Supplier List</a>
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
    <form action="" method="post" id="activateForm" hidden>
        <?php echo csrf_field(); ?>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '<?php echo e(route('admin.nonactivesupplier.data')); ?>',
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
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\admin\supplier\nonactive.blade.php ENDPATH**/ ?>