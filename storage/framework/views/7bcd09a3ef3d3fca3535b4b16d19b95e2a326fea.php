>

<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php echo $__env->make('templates.partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bypass Workorder Initiated</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="initiated-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>WO Number</th>
                                        <th>Supplier</th>
                                        <th>Customer</th>
                                        <th>Workorder Status</th>
                                        <th>Machine</th>
                                        <th>Processed By</th>
                                        <th>Process Start</th>
                                        <th>Initiated By</th>
                                        <th>Force Close Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bypass Workorder History</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="history-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>WO Number</th>
                                        <th>Supplier</th>
                                        <th>Customer</th>
                                        <th>Workorder Status</th>
                                        <th>Machine</th>
                                        <th>Processed By</th>
                                        <th>Process Start</th>
                                        <th>Process End</th>
                                        <th>Initiated By</th>
                                        <th>Approved By</th>
                                        <th>Force Close Remarks</th>
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
    <form action="" method="POST" id="processForm">
        <?php echo csrf_field(); ?>
        <input type="submit" value="Process" style="display:none">
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(function() {
            generate_data()
        });

        function generate_data() {
            $('#initiated-table').DataTable().destroy()
            $('#initiated-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": '<?php echo e(route('bypass.initiated')); ?>',
                },
                columns: [
                    {data: 'wo_number'},
                    {data: 'bb_supplier'},
                    {data: 'fg_customer'},
                    {data: 'status_wo'},
                    {data: 'machine'},
                    {data: 'processed_by'},
                    {data: 'process_start'},
                    {data: 'initiated_by'},
                    {data: 'remarks'},
                    {data: 'action'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $('#history-table').DataTable().destroy()
            $('#history-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": '<?php echo e(route('bypass.history')); ?>',
                },
                columns: [
                    {data: 'wo_number'},
                    {data: 'bb_supplier'},
                    {data: 'fg_customer'},
                    {data: 'status_wo'},
                    {data: 'machine'},
                    {data: 'processed_by'},
                    {data: 'process_start'},
                    {data: 'process_end'},
                    {data: 'initiated_by'},
                    {data: 'approved_by'},
                    {data: 'remarks'},
                    {data: 'action'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\user\bypass\index.blade.php ENDPATH**/ ?>