
<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-tittle">Leburan</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('operator.production.updateSmelting', $workorder)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <table id="dataTable" class="table table-bordered table-hover mb-3">
                                    <thead>
                                        <tr>
                                            <th>WO Number</th>
                                            <th>No. Coil</th>
                                            <th>Weight (Kg)</th>
                                            <th>No. Leburan</th>
                                            <th>Area</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $smeltings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $smelt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><input type="hidden" name="wo_num[]"
                                                        value="<?php echo e($smelt->workorder->wo_number); ?>" />
                                                    <?php echo e($smelt->workorder->wo_number); ?></td>
                                                <td><input type="hidden" name="coil_num[]"
                                                        value="<?php echo e($smelt->coil_num); ?>" />
                                                    <?php echo e($smelt->coil_num); ?></td>
                                                <td><input type="text" name="weight[]" class="form-control"
                                                        value="<?php echo e($smelt->weight); ?>" /></td>
                                                <td><input type="text" name="smelting_num[]" class="form-control"
                                                        value="<?php echo e($smelt->smelting_num); ?>" /></td>
                                                <td><input type="text" name="area[]" class="form-control"
                                                        value="<?php echo e($smelt->area); ?>" /></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-3">
                                        <input value="Update" type="submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\operator\production\edit_smelting.blade.php ENDPATH**/ ?>