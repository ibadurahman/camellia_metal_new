

<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php echo $__env->make('templates.partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="card">
                        <div class="card-header">
                            Sorting by Machine
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <select name="" id="machine-selector" onchange="update_sorting()" class="form-control">
                                        <option value="0">All</option>
                                        <?php $__currentLoopData = $machines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $machine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($machine->id); ?>"><?php echo e($machine->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">On Check</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="oncheck-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        
										<th>WO Number</th>
                                        <th>Supplier</th>
                                        <th>Grade</th>
                                        <th>Diameter (mm)</th>
                                        <th>Qty (kg / coil)</th>
                                        <th>Qty (bundle)</th>
                                        <th>Customer</th>
                                        <th>Straightness Std</th>
                                        <th>Size (mm x mm)</th>
                                        <th>Diameter Tolerance (mm)</th>
                                        <th>Length Tolerance (mm)</th>
                                        <th>Reduction Rate (%)</th>
                                        <th>Shape</th>
                                        <th>FG Qty (kg)</th>
                                        <th>FG Qty (pcs)</th>
                                        <th>Workorder Status</th>
                                        <th>Chamfer</th>
                                        <th>Color</th>
                                        <th>Machine</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Edited By</th>
                                        <th>Updated At</th>
                                        <th>Processed By</th>
                                        <th>Process Start</th>
                                        <th>Remarks</th>
                                        <th>Procuction Remarks</th>
                                        <th>Leburan</th>
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
        update_sorting()
    });
    function update_sorting(){
        $('#oncheck-table').DataTable().destroy()
        $('#oncheck-table').DataTable({
            processing:true,
            serverSide:true,
            ajax:{
                "url"   :'<?php echo e(route('spvproduction.showOnCheck')); ?>',
                "data"  :{
                    "machine":$('#machine-selector').val()
                }
            },
            columns:[
                // {data:'wo_order_num'},
			    {data:'wo_number'},
                {data:'bb_supplier'},
                {data:'bb_grade'},
                {data:'bb_diameter'},
                {data:'bb_qty_combine'},
                {data:'bb_qty_bundle'},
                {data:'fg_customer'},
                {data:'straightness_standard'},
                {data:'fg_size_combine'},
                {data:'tolerance_combine'},
                {data:'length_tolerance_combine'},
                {data:'fg_reduction_rate'},
                {data:'fg_shape'},
                {data:'fg_qty_kg'},
                {data:'fg_qty_pcs'},
                {data:'status_wo'},
                {data:'chamfer'},
                {data:'color'},
                {data:'machine'},
                {data:'created_by'},
                {data:'created_at'},
                {data:'edited_by'},
                {data:'updated_at'},
                {data:'processed_by'},
                {data:'process_start'},
                {data:'remarks'},
                {data:'production_remarks'},
                {data:'smelting'},
				{data:'action'}
            ],
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    }
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views/supervisor/production/index.blade.php ENDPATH**/ ?>