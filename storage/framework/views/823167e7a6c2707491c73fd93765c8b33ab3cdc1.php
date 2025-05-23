

<?php $__env->startSection('content'); ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php echo $__env->make('templates.partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Draft</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <a href="<?php echo e(route('admin.workorder.create')); ?>" class="btn btn-primary">Add New Workorder</a>
                    </div>
                    <div class="card-body">
                        <table id="draft-table" class="table table-bordered table-hover">
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
                                    <th>Tolerance (mm)</th>
                                    <th>Reduction Rate (%)</th>
                                    <th>Shape</th>
                                    <th>FG Qty (kg)</th>
                                    <th>FG Qty bundle (pcs)</th>
                                    <th>Workorder Status</th>
                                    <th>Chamfer</th>
                                    <th>Color</th>
                                    <th>Machine</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Edited By</th>
                                    <th>Updated at</th>
                                    <th>Remarks</th>
                                    <th>Label Remarks</th>
                                    <th>Leburan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
                    <div class="card-body">
                        <table id="waiting-table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Machine</th>
                                    <th>WO Number</th>
                                    <th>Supplier</th>
                                    <th>Grade</th>
                                    <th>Diameter (mm)</th>
                                    <th>Qty (kg / coil)</th>
                                    <th>Qty (bundle)</th>
                                    <th>Customer</th>
                                    <th>Straightness Std</th>
                                    <th>Size (mm x mm)</th>
                                    <th>Tolerance (mm)</th>
                                    <th>Reduction Rate (%)</th>
                                    <th>Shape</th>
                                    <th>FG Qty (kg)</th>
                                    <th>FG Qty bundle (pcs)</th>
                                    <th>Workorder Status</th>
                                    <th>Chamfer</th>
                                    <th>Color</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Edited By</th>
                                    <th>Updated at</th>
                                    <th>Remarks</th>
                                    <th>Label Remarks</th>
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
                                    <th>Supplier</th>
                                    <th>Grade</th>
                                    <th>Diameter (mm)</th>
                                    <th>Qty (kg / coil)</th>
                                    <th>Qty (bundle)</th>
                                    <th>Customer</th>
                                    <th>Straightness Std</th>
                                    <th>Size (mm x mm)</th>
                                    <th>Tolerance (mm)</th>
                                    <th>Reduction Rate (%)</th>
                                    <th>Shape</th>
                                    <th>FG Qty (kg)</th>
                                    <th>FG Qty (pcs)</th>
                                    <th>Workorder Status</th>
                                    <th>Chamfer</th>
                                    <th>Color</th>
                                    <th>Machine</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Edited By</th>
                                    <th>Updated at</th>
                                    <th>Processed By</th>
                                    <th>Process Start</th>
                                    <th>Remarks</th>
                                    <th>Label Remarks</th>
                                    <th>Leburan</th>
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
    $(function() {
        update_sorting()
        $('#draft-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?php echo e(route("admin.workorder.datadraft")); ?>',
            columns: [{
                    data: 'wo_number'
                },
                {
                    data: 'bb_supplier'
                },
                {
                    data: 'bb_grade'
                },
                {
                    data: 'bb_diameter'
                },
                {
                    data: 'bb_qty_combine'
                },
                {
                    data: 'bb_qty_bundle'
                },
                {
                    data: 'fg_customer'
                },
                {
                    data: 'straightness_standard'
                },
                {
                    data: 'fg_size_combine'
                },
                {
                    data: 'tolerance_combine'
                },
                {
                    data: 'fg_reduction_rate'
                },
                {
                    data: 'fg_shape'
                },
                {
                    data: 'fg_qty_kg'
                },
                {
                    data: 'fg_qty_pcs'
                },
                {
                    data: 'status_wo'
                },
                {
                    data: 'chamfer'
                },
                {
                    data: 'color'
                },
                {
                    data: 'machine'
                },
                {
                    data: 'created_by'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'edited_by'
                },
                {
                    data: 'updated_at'
                },
                {
                    data: 'remarks'
                },
                {
                    data: 'label_remarks'
                },
                {
                    data: 'smelting'
                },
                {
                    data: 'action'
                },
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
        $("#waiting-table").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                Swal.fire({
                    title: 'Submit your account password',
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return fetch('<?php echo e(url("/admin/confirm-password")); ?>', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                                },
                                body: JSON.stringify({
                                    password: login
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(function(response) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Wrong Password',
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    location.reload();
                                });
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value.result) {
                        var order = [];
                        $('tr.workorder-row').each(function(index, element) {
                            order.push({
                                id: $(this).attr('id'),
                                position: index + 1
                            });
                        });

                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: '<?php echo e(route("admin.workorder.updateorder")); ?>',
                            data: {
                                order: order,
                                _token: '<?php echo e(csrf_token()); ?>'
                            },
                            error: function(response) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Failed update queue',
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    location.reload();
                                });
                                return;
                            }
                        });

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Order updated',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                            location.reload();
                        });
                    }
                })

            },
        });
        $('#onprocess-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?php echo e(route("admin.workorder.dataonprocess")); ?>',
            columns: [
                // {data:'wo_order_num'},
                {
                    data: 'wo_number'
                },
                {
                    data: 'bb_supplier'
                },
                {
                    data: 'bb_grade'
                },
                {
                    data: 'bb_diameter'
                },
                {
                    data: 'bb_qty_combine'
                },
                {
                    data: 'bb_qty_bundle'
                },
                {
                    data: 'fg_customer'
                },
                {
                    data: 'straightness_standard'
                },
                {
                    data: 'fg_size_combine'
                },
                {
                    data: 'tolerance_combine'
                },
                {
                    data: 'fg_reduction_rate'
                },
                {
                    data: 'fg_shape'
                },
                {
                    data: 'fg_qty_kg'
                },
                {
                    data: 'fg_qty_pcs'
                },
                {
                    data: 'status_wo'
                },
                {
                    data: 'chamfer'
                },
                {
                    data: 'color'
                },
                {
                    data: 'machine'
                },
                {
                    data: 'created_by'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'edited_by'
                },
                {
                    data: 'updated_at'
                },
                {
                    data: 'processed_by'
                },
                {
                    data: 'process_start'
                },
                {
                    data: 'remarks'
                },
                {
                    data: 'label_remarks'
                },
                {
                    data: 'smelting'
                },
                {
                    data: 'action'
                }
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

    function update_sorting(){
        $('#waiting-table').DataTable().destroy()
        $('#waiting-table').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                "url"   :'<?php echo e(route("admin.workorder.datawaiting")); ?>',
                "data"  :{
                    "machine":$('#machine-selector').val()
                }
            },
            columns: [{
                    data: 'wo_order_num'
                },
                {
                    data: 'machine'
                },
                {
                    data: 'wo_number'
                },
                {
                    data: 'bb_supplier'
                },
                {
                    data: 'bb_grade'
                },
                {
                    data: 'bb_diameter'
                },
                {
                    data: 'bb_qty_combine'
                },
                {
                    data: 'bb_qty_bundle'
                },
                {
                    data: 'fg_customer'
                },
                {
                    data: 'straightness_standard'
                },
                {
                    data: 'fg_size_combine'
                },
                {
                    data: 'tolerance_combine'
                },
                {
                    data: 'fg_reduction_rate'
                },
                {
                    data: 'fg_shape'
                },
                {
                    data: 'fg_qty_kg'
                },
                {
                    data: 'fg_qty_pcs'
                },
                {
                    data: 'status_wo'
                },
                {
                    data: 'chamfer'
                },
                {
                    data: 'color'
                },
                {
                    data: 'created_by'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'edited_by'
                },
                {
                    data: 'updated_at'
                },
                {
                    data: 'remarks'
                },
                {
                    data: 'label_remarks'
                },
                {
                    data: 'smelting'
                },
                {
                    data: 'action'
                },
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\admin\workorder\index.blade.php ENDPATH**/ ?>