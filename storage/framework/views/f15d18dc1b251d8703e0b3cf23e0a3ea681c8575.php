
<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="register-box">
                <div class="register-logo">
                    <a href="<?php echo e(url('/')); ?>"><b>Camellia Metal Indonesia</b></a>
                </div>
                <div class="card">
                    <div class="card-body register-card-body">
                        <p class="login-box-msg">Login Form</p>
                        <form action="<?php echo e(route('login')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php $__errorArgs = ['employeeId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger">
                                    <?php echo e($message); ?>

                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="input-group mb-3">
                                <input name="employeeId" type="text" class="form-control" placeholder="Employee Id" value="<?php echo e(old('employeeId')); ?>">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger">
                                    <?php echo e($message); ?>

                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="input-group mb-3">
                                <input name="password" type="password" class="form-control" placeholder="Password" value="<?php echo e(old('password')); ?>">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                                </div>
                            </div>
                            <a href="<?php echo e(route('register')); ?>" class="text-center">You are a new user?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\auth\login.blade.php ENDPATH**/ ?>