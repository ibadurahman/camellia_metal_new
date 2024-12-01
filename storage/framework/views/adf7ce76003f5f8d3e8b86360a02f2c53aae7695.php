

<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php echo $__env->make('templates.partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="card">
                        <div class="card-header">
                            Sorting by Category
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <select name="" id="category-selector" onchange="update_sorting()" class="form-control">
                                        <option value="0">All</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Downtime Reason</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <a href="<?php echo e(route('downtimeReason.create')); ?>" class="btn btn-primary">Add New Reason</a>
                                </div>
                            </div>
                            <table id="reason-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        
										<th>Downtime Reason</th>
                                        <th>Downtime Category</th>
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
    
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(function () {
        update_sorting()
    });

    function update_sorting(){
        $('#reason-table').DataTable().destroy()
        $('#reason-table').DataTable({
            processing:true,
            serverSide:true,
            ajax:{
                "url"   :'<?php echo e(route('downtimeReason.loadData')); ?>',
                "data"  :{
                    "category":$('#category-selector').val()
                }
            },
            columns:[
                {data:'name'},
			    {data:'downtime_category'},
				{data:'action', orderable:false}
            ],
            "paging": false,
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
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\supervisor\downtimereason\index.blade.php ENDPATH**/ ?>