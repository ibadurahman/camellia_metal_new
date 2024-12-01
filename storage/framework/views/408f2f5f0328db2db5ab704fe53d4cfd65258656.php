

<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add New Workorder</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.workorder.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label for="">WO Number <span class="text-danger">*</span></label>
                                    <input name="wo_number" type="text"
                                        class="form-control <?php $__errorArgs = ['wo_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="WO Number" value="<?php echo e(old('wo_number', $wo_num)); ?>">
                                    <?php $__errorArgs = ['wo_number'];
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
                                <div class="alert alert-primary text-center" role="alert">
                                    Bahan Baku
                                </div>
                                <div class="form-group">
                                    <label for="">Supplier <span class="text-danger">*</span></label>
                                    <select id="supplier-cmbbx" name="bb_supplier"
                                        class="form-control select2 <?php $__errorArgs = ['bb_supplier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option disabled selected value> -- SELECT SUPPLIER -- </option>
                                        <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($supplier->name); ?>"
                                                <?php if(old('bb_supplier') === $supplier->name): ?> selected <?php endif; ?>><?php echo e($supplier->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['bb_supplier'];
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
                                    <label for="">Grade <span class="text-danger">*</span></label>
                                    <input id="supplier-grade" name="bb_grade" type="text"
                                        class="form-control <?php $__errorArgs = ['bb_grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Grade"
                                        value="<?php echo e(old('bb_grade')); ?>">
                                    <?php $__errorArgs = ['bb_grade'];
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
                                    <label for="">Diameter (mm) <span class="text-danger">*</span></label>
                                    <input id="supplier-diameter" name="bb_diameter" type="text"
                                        class="form-control <?php $__errorArgs = ['bb_diameter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Diameter" value="<?php echo e(old('bb_diameter')); ?>">
                                    <?php $__errorArgs = ['bb_diameter'];
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
                                    <label for="">Quantity (Kg / Coil) <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-5">
                                            <input id="supplier-qty-kg" name="bb_qty_pcs" type="text"
                                                class="form-control <?php $__errorArgs = ['bb_qty_pcs'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Qty (Kg)" value="<?php echo e(old('bb_qty_pcs')); ?>">
                                            <?php $__errorArgs = ['bb_qty_pcs'];
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
                                        <div class="col-1">
                                            <label for="">Kg</label>
                                        </div>
                                        <div class="col-5">
                                            <input id="supplier-qty-coil" name="bb_qty_coil" type="text"
                                                class="form-control <?php $__errorArgs = ['bb_qty_coil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Qty (Coil)" value="<?php echo e(old('bb_qty_coil')); ?>">
                                            <?php $__errorArgs = ['bb_qty_coil'];
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
                                        <div class="col-1">
                                            <label for="">Coil</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Quantity (Bundle) <span class="text-danger">*</span></label>
                                    <input id="supplier-qty-bundle" name="bb_qty_bundle" type="text"
                                        class="form-control <?php $__errorArgs = ['bb_qty_bundle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Quantity (Bundle)" value="<?php echo e(old('bb_qty_bundle')); ?>">
                                    <?php $__errorArgs = ['bb_qty_bundle'];
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
                                <div class="alert alert-primary text-center" role="alert">
                                    Finish good
                                </div>
                                <div class="form-group">
                                    <label for="">Customer <span class="text-danger">*</span></label>
                                    <select id="customer-cmbbx" name="fg_customer"
                                        class="form-control select2 <?php $__errorArgs = ['fg_customer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('fg_customer')); ?>">
                                        <option disabled selected value> -- SELECT CUSTOMER -- </option>
                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($customer->name); ?>"
                                                <?php if(old('fg_customer') === $customer->name): ?> selected <?php endif; ?>><?php echo e($customer->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['fg_customer'];
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
                                    <label for="">Standar Kelurusan (mm) <span class="text-danger">*</span></label>
                                    <input id="customer-straight-standard" name="straightness_standard" type="text"
                                        class="form-control <?php $__errorArgs = ['straightness_standard'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Standar Kelurusan (mm)" value="<?php echo e(old('straightness_standard')); ?>">
                                    <?php $__errorArgs = ['straightness_standard'];
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
                                    <label for="">Size (diameter(mm) x length(mm)) <span
                                            class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-5">
                                            <input id="customer-size-1" name="fg_size_1" type="text"
                                                class="form-control <?php $__errorArgs = ['fg_size_1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Diameter (mm)" value="<?php echo e(old('fg_size_1')); ?>">
                                            <?php $__errorArgs = ['fg_size_1'];
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
                                        <div class="col-1">
                                            <label class="right" for="">X</label>
                                        </div>
                                        <div class="col-5">
                                            <input id="customer-size-2" name="fg_size_2" type="text"
                                                class="form-control <?php $__errorArgs = ['fg_size_2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Length (mm)" value="<?php echo e(old('fg_size_2')); ?>">
                                            <?php $__errorArgs = ['fg_size_2'];
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
                                        <div class="col-1">
                                            <label for="">mm</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Tolerance (+mm) <span class="text-danger">*</span></label>
                                    <input id="customer-tolerance-plus" name="tolerance_plus" type="text"
                                        class="form-control <?php $__errorArgs = ['tolerance_plus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Tolerance (+mm)" value="<?php echo e(old('tolerance_plus')); ?>">
                                    <?php $__errorArgs = ['tolerance_plus'];
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
                                    <label for="">Tolerance (-mm) <span class="text-danger">*</span></label>
                                    <input id="customer-tolerance" name="tolerance_minus" type="text"
                                        class="form-control <?php $__errorArgs = ['tolerance_minus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Tolerance (-mm)" value="<?php echo e(old('tolerance_minus')); ?>">
                                    <?php $__errorArgs = ['tolerance_minus'];
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
                                    <label for="">Reduction Rate (%) <span class="text-danger">*</span></label>
                                    <input id="customer-reduc-rate" name="fg_reduction_rate" type="text"
                                        class="form-control <?php $__errorArgs = ['fg_reduction_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Reduction Rate (%)" value="<?php echo e(old('fg_reduction_rate')); ?>">
                                    <?php $__errorArgs = ['fg_reduction_rate'];
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
                                    <label for="">Shape <span class="text-danger">*</span></label>
                                    <select name="fg_shape" id="customer-shape"
                                        class="form-control <?php $__errorArgs = ['fg_shape'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option disabled selected value> -- select shape -- </option>
                                        <option id="shape-round" value="Round"
                                            <?php if(old('fg_shape') === 'Round'): ?> selected <?php endif; ?>>Round</option>
                                        <option id="shape-square" value="Square"
                                            <?php if(old('fg_shape') === 'Square'): ?> selected <?php endif; ?>>Square</option>
                                        <option id="shape-hexagon" value="Hexagon"
                                            <?php if(old('fg_shape') === 'Hexagon'): ?> selected <?php endif; ?>>Hexagon</option>
                                    </select>
                                    <?php $__errorArgs = ['fg_shape'];
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
                                    <label for="">Quantity per bundle (Kg) <span
                                            class="text-danger">*</span></label>
                                    <input id="kg-per-bundle" name="fg_qty_kg" type="text"
                                        class="form-control <?php $__errorArgs = ['fg_qty_kg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Qty per bundle (Kg)" value="<?php echo e(old('fg_qty_kg')); ?>">
                                    <?php $__errorArgs = ['fg_qty_kg'];
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
                                    <label for="">Quantity per Bundle (Pcs) <span
                                            class="text-danger">*</span></label>
                                    <input id="pcs-per-bundle" name="fg_qty_pcs" type="text"
                                        class="form-control <?php $__errorArgs = ['fg_qty_pcs'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Qty per bundle (Pcs)" value="<?php echo e(old('fg_qty_pcs')); ?>">
                                    <?php $__errorArgs = ['fg_qty_pcs'];
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
                                    <label for="">Chamfer</label>
                                    <br>
                                    <input type="radio" id="Chamfer_Yes" name="chamfer" value="Yes"> Yes
                                    <br>
                                    <input type="radio" id="Chamfer_No" name="chamfer" value="No"> No
                                    <br>
                                    <input type="radio" id="Chamfer_Satu_Sisi" name="chamfer" value="Satu Sisi"> Satu
                                    Sisi
                                    <?php $__errorArgs = ['chamfer'];
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
                                    <label for="">Color <span class="text-danger">*</span></label>
                                    <select id="color-cmbbx" name="color"
                                        class="form-control select2 <?php $__errorArgs = ['color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('color')); ?>">
                                        <option disabled selected value> -- SELECT COLOR -- </option>
                                        <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($color->id); ?>"><?php echo e($color->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['color'];
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
                                    <label for="">Machine <span class="text-danger">*</span></label>
                                    <select name="machine_id" class="form-control" id="">
                                        <?php $__currentLoopData = $machines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $machine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($machine->id); ?>"><?php echo e($machine->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['machine_id'];
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
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" class="form-control <?php $__errorArgs = ['remarks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Catatan untuk produksi" cols="30" rows="10"><?php echo e(old('remarks')); ?></textarea>
                                    <?php $__errorArgs = ['remarks'];
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
                                    <label for="">Label Remarks</label>
                                    <textarea name="label_remarks" class="form-control <?php $__errorArgs = ['label_remarks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Keterangan pada label produksi(kosongkan jika tidak dibutuhkan)" cols="30" rows="1"><?php echo e(old('label_remarks')); ?></textarea>
                                    <?php $__errorArgs = ['label_remarks'];
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
                                    <span class="text-muted help-block">Estimated Planned Output: <span
                                            id="estimated-qty-planned"></span> Pcs</span>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <input value="Add" type="submit" class="btn btn-primary">
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

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('plugins/select2/js/select2.full.min.js')); ?>"></script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                },
                format: 'YYYY-MM-DD HH:mm:ss',
            });
            $('#customer-size-1').on('keyup', function() {
                recalculate();
            });
            $('#supplier-diameter').on('keyup', function() {
                localStorage.removeItem('customer-tolerance-plus');
                localStorage.removeItem('customer-tolerance');
                recalculate();
            });
            $('#kg-per-bundle').on('keyup', function() {
                recalculate();
            });
            $('#supplier-cmbbx').on('change', function() {
                localStorage.removeItem('customer-tolerance-plus');
                localStorage.removeItem('customer-tolerance');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo e(route('admin.supplier.getSupplierData')); ?>",
                    data: {
                        name: $('#supplier-cmbbx').val(),
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        $('#supplier-grade').val(response[0].grade);
                        $('#supplier-diameter').val(response[0].diameter);
                        $('#supplier-qty-kg').val(response[0].qty_kg);
                        $('#supplier-qty-coil').val(response[0].qty_coil);
                        $('#supplier-qty-bundle').val(response[0].qty_bundle);
                        recalculate();
                    }
                });
            });
            $('#customer-cmbbx').on('change', function() {
                localStorage.removeItem('customer-tolerance-plus');
                localStorage.removeItem('customer-tolerance');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo e(route('admin.customer.getCustomerData')); ?>",
                    data: {
                        name: $('#customer-cmbbx').val(),
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        $('#customer-straight-standard').val(response[0].straightness_standard);
                        $('#customer-size-1').val(response[0].size_1);
                        $('#customer-size-2').val(response[0].size_2);

                        if (response[0].shape == "Round") {
                            $('#shape-round').attr('selected', true)
                            $('#shape-square').attr('selected', false)
                            $('#shape-hexagon').attr('selected', false)
                        }
                        if (response[0].shape == "Square") {
                            $('#shape-round').attr('selected', false)
                            $('#shape-square').attr('selected', true)
                            $('#shape-hexagon').attr('selected', false)
                        }
                        if (response[0].shape == "Hexagon") {
                            $('#shape-round').attr('selected', false)
                            $('#shape-square').attr('selected', false)
                            $('#shape-hexagon').attr('selected', true)
                        }
                        recalculate();
                    }
                });
            });
            $('#customer-shape').on('change', function() {
                recalculate();
            })
            $('#color-cmbbx').on('change', function() {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo e(route('admin.color.getColorData')); ?>",
                    data: {
                        name: $('#customer-cmbbx').val(),
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {}
                });
            });

            $('#customer-tolerance-plus').on('keyup', function() {
                //add lock value for the input from localStorage
                localStorage.setItem('customer-tolerance-plus', $('#customer-tolerance-plus').val());
            });

            $('#customer-tolerance').on('keyup', function() {
                //add lock value for the input from localStorage
                localStorage.setItem('customer-tolerance', $('#customer-tolerance').val());
            });

            function recalculate() {
                if (localStorage.getItem('customer-tolerance-plus') != null) {
                    $('#customer-tolerance-plus').val(localStorage.getItem('customer-tolerance-plus'));
                } else {
                    $('#customer-tolerance-plus').val("+" + addTolerancePlus($('#customer-size-1').val()));
                }
                if (localStorage.getItem('customer-tolerance') != null) {
                    $('#customer-tolerance').val(localStorage.getItem('customer-tolerance'));
                } else {
                    $('#customer-tolerance').val("-" + addTolerance($('#customer-size-1').val()));
                }
                $('#customer-reduc-rate').val(calculateReducRate($('#supplier-diameter').val(), $(
                    '#customer-size-1').val()));
                $('#pcs-per-bundle').val(calculatePcsPerBundle($('#kg-per-bundle').val(), $('#customer-shape')
                    .val()));
                $('#estimated-qty-planned').html(calculateQtyPlanned($('#supplier-qty-kg').val(), $(
                    '#customer-shape').val()));
            }

            function calculateReducRate(dia_1 = 0, dia_2 = 0) {
                var result = (1 - ((dia_2 * dia_2) / (dia_1 * dia_1))) * 100;
                return result.toFixed(2);
            }

            function calculatePcsPerBundle(weightVal = 0, shape = null) {
                var diameter = $('#customer-size-1').val();
                var panjang = $('#customer-size-2').val();
                var result = 0;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo e(route('admin.workorder.calculatePcsPerBundle')); ?>",
                    data: {
                        shape: shape,
                        _token: "<?php echo e(csrf_token()); ?>"
                    },
                    success: function(response) {
                        result = Math.round(weightVal / diameter / diameter / panjang / response *
                            1000);
                        $('#pcs-per-bundle').val(result.toFixed(0));
                    }
                })
            }

            function calculateQtyPlanned(weightVal = 0, shape = null) {
                var diameter = $('#customer-size-1').val();
                var panjang = $('#customer-size-2').val();
                var result = 0;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo e(route('admin.workorder.calculatePcsPerBundle')); ?>",
                    data: {
                        shape: shape,
                        _token: "<?php echo e(csrf_token()); ?>"
                    },
                    success: function(response) {
                        result = Math.round(weightVal / diameter / diameter / panjang / response *
                            1000);
                        $('#estimated-qty-planned').html(result.toFixed(0));
                    }
                })
            }

            function addTolerance(diameter = 0) {
                var shape = $('#customer-shape').val();
                if (diameter >= 3.01 && diameter <= 6.00) {
                    if (shape == "Round") {
                        return 0.03;
                    }
                    return 0.075;
                }
                if (diameter >= 6.01 && diameter <= 10.00) {
                    if (shape == "Round") {
                        return 0.03;
                    }
                    return 0.090;
                }
                if (diameter >= 10.01 && diameter <= 18.00) {
                    if (shape == "Round") {
                        return 0.04;
                    }
                    return 0.110;
                }
                if (diameter >= 18.01 && diameter <= 30.00) {
                    if (shape == "Round") {
                        return 0.05;
                    }
                    return 0.130;
                }
                if (diameter >= 30.01 && diameter <= 40.00) {
                    if (shape == "Round") {
                        return 0.06;
                    }
                    return 0.160;
                }
            }

            function addTolerancePlus(diameter = 0) {
                var shape = $('#customer-shape').val();
                if (diameter >= 3.01 && diameter <= 6.00) {
                    if (shape == "Round") {
                        return 0.00;
                    }
                    return 0.00;
                }
                if (diameter >= 6.01 && diameter <= 10.00) {
                    if (shape == "Round") {
                        return 0.00;
                    }
                    return 0.00;
                }
                if (diameter >= 10.01 && diameter <= 18.00) {
                    if (shape == "Round") {
                        return 0.00;
                    }
                    return 0.00;
                }
                if (diameter >= 18.01 && diameter <= 30.00) {
                    if (shape == "Round") {
                        return 0.00;
                    }
                    return 0.00;
                }
                if (diameter >= 30.01 && diameter <= 40.00) {
                    if (shape == "Round") {
                        return 0.00;
                    }
                    return 0.00;
                }
            }

        });
        $(document).ready(function() {
            //reset to null
            localStorage.removeItem('customer-tolerance-plus');
            localStorage.removeItem('customer-tolerance');
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\admin\workorder\create.blade.php ENDPATH**/ ?>