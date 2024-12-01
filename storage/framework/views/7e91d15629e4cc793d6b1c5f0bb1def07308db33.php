
<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add New Reason</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('downtimeReason.update', $downtimeReason)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="form-group">
                                    <label for="">Category</label>
                                    <select name="dt_category_id" class="form-control <?php $__errorArgs = ['dt_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('dt_category_id')); ?>">
                                        <option disabled selected value> -- select downtime category -- </option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>" <?php if(old('dt_category_id') == $category->id || $category->id == $downtimeReason->dt_category_id): ?>
                                                selected
                                            <?php endif; ?>><?php echo e($category->name); ?></option>  
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['dt_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger help-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input name="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Name" value="<?php echo e(old('name')??$downtimeReason->name); ?>">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger help-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <div class="form-group">
                                    <input value="Update" type="submit" class="btn btn-primary">
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
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\supervisor\downtimereason\edit.blade.php ENDPATH**/ ?>