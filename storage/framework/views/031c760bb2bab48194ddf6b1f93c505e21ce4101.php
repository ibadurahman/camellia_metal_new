

<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php echo $__env->make('templates.partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Waiting Process</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <table id="waiting-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Order Number</th>
                                        <th>WO Number</th>
                                        <th>Supplier</th>
                                        <th>Grade</th>
                                        <th>Diameter (mm)</th>
                                        <th>Qty (kg / coil)</th>
                                        <th>Customer</th>
                                        <th>Straightness Std (mm)</th>
                                        <th>Size (mm x mm)</th>
                                        <th>Tolerance (mm)</th>
                                        <th>Reduction Rate (%)</th>
                                        <th>Shape</th>
                                        <th>Kg per bundle (kg)</th>
                                        <th>Pcs per bundle (pcs)</th>
                                        
                                        <th>Workorder Status</th>
                                        <th>Machine</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Leburan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div> 
                    </div> 
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">On Process</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="onprocess-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        
                                        <th>WO Number</th>
                                        <th>BB Supplier</th>
                                        <th>BB Grade</th>
                                        <th>BB Diameter (mm)</th>
                                        <th>BB Qty (Kg / Coil)</th>
                                        <th>FG Customer</th>
                                        <th>FG Straightness Std (mm)</th>
                                        <th>FG Size (mm x mm)</th>
                                        <th>FG Tolerance (mm)</th>
                                        <th>FG Reduction Rate (%)</th>
                                        <th>FG Shape</th>
                                        <th>FG Kg per bundle (Kg)</th>
                                        <th>FG Pcs per bundle (Pcs)</th>
                                        <th>Workorder Status</th>
                                        <th>Machine</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
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
    $(function () {
        $('#waiting-table').DataTable({
            processing:true,
            serverSide:true,
            ajax:'<?php echo e(route('workorder.showWaiting')); ?>',
            columns:[
                {data:'wo_order_num'},
                {data:'wo_number'},
                {data:'bb_supplier'},
                {data:'bb_grade'},
                {data:'bb_diameter'},
                {data:'bb_qty_combine'},
                {data:'fg_customer'},
                {data:'straightness_standard'},
                {data:'fg_size_combine'},
                {data:'tolerance'},
                {data:'fg_reduction_rate'},
                {data:'fg_shape'},
                {data:'fg_qty_kg'},
                {data:'fg_qty_pcs'},
                {data:'status_wo'},
                {data:'machine'},
                {data:'user'},  
                {data:'created_at'},
                {data:'smelting'},
                {data:'action'}
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        $('#onprocess-table').DataTable({
            processing:true,
            serverSide:true,
            ajax:'<?php echo e(route('workorder.showOnProcess')); ?>',
            columns:[
                // {data:'wo_order_num'},
                {data:'wo_number'},
                {data:'bb_supplier'},
                {data:'bb_grade'},
                {data:'bb_diameter'},
                {data:'bb_qty_combine'},
                {data:'fg_customer'},
                {data:'straightness_standard'},
                {data:'fg_size_combine'},
                {data:'tolerance'},
                {data:'fg_reduction_rate'},
                {data:'fg_shape'},
                {data:'fg_qty_kg'},
                {data:'fg_qty_pcs'},
                // {data:'status_prod'},
                {data:'status_wo'},
                {data:'machine'},
                {data:'user'},  
                {data:'created_at'},
            ],
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\supervisor\schedule\index.blade.php ENDPATH**/ ?>