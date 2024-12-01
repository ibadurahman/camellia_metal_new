
<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Change Request</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.workorder.changeUpdate', $workorder)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" value="<?php echo e($workorder->id); ?>" name="workorder_id" />
                                <?php if($errors->any()): ?>
                                    <?php echo implode('', $errors->all('<div>:message</div>')); ?>

                                <?php endif; ?>
                                <div class="form-group">
                                    <label for="">WO Number</label>
                                    <input name="wo_number" type="text"
                                        class="form-control <?php $__errorArgs = ['wo_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Workorder Number"
                                        value="<?php echo e($workorder->wo_number ?? old('wo_number')); ?>">
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
                                    <label for="">Supplier</label>
                                    <select id="supplier-cmbbx" name="bb_supplier"
                                        class="form-control select2 <?php $__errorArgs = ['bb_supplier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($supplier->name); ?>"
                                                <?php if($supplier->name == $workorder->bb_supplier): ?> selected <?php endif; ?>>
                                                <?php echo e($supplier->name); ?></option>
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
                                    <label for="">Grade</label>
                                    <input id="supplier-grade" name="bb_grade" type="text"
                                        class="form-control <?php $__errorArgs = ['bb_grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="(Bahan Baku) Grade"
                                        value="<?php echo e($workorder->bb_grade ?? old('bb_grade')); ?>">
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
                                    <label for="">Diameter</label>
                                    <div class="row">
                                        <div class="col-11">
                                            <input id="supplier-diameter" name="bb_diameter" type="text"
                                                class="form-control <?php $__errorArgs = ['bb_diameter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="(Bahan Baku) Diameter"
                                                value="<?php echo e($workorder->bb_diameter ?? old('bb_diameter')); ?>">
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
                                        <div class="col-1">
                                            <label for="">mm</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Qty</label>
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
                                                placeholder="(Bahan Baku) Qty PCS"
                                                value="<?php echo e($workorder->bb_qty_pcs ?? old('bb_qty_pcs')); ?>">
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
                                                placeholder="(Bahan Baku) Qty COIL"
                                                value="<?php echo e($workorder->bb_qty_coil ?? old('bb_qty_coil')); ?>">
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
                                    <label for="">Bundle</label>
                                    <input id="supplier-qty-bundle" name="bb_qty_bundle" type="text"
                                        class="form-control <?php $__errorArgs = ['bb_qty_bundle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Qty (Bundle)"
                                        value="<?php echo e($workorder->bb_qty_bundle ?? old('bb_qty_bundle')); ?>">
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
                                    <label for="">Customer</label>
                                    <select id="customer-cmbbx" name="fg_customer"
                                        class="form-control select2 <?php $__errorArgs = ['fg_customer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($customer->name); ?>"
                                                <?php if($customer->name == $workorder->fg_customer): ?> selected <?php endif; ?>>
                                                <?php echo e($customer->name); ?></option>
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
                                    <label for="">Standar Kelurusan</label>
                                    <input id="customer-straight-standard" name="straightness_standard" type="text"
                                        class="form-control <?php $__errorArgs = ['straightness_standard'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Standar Kelurusan"
                                        value="<?php echo e($workorder->straightness_standard ?? old('straightness_standard')); ?>">
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
                                    <label for="">Size</label>
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
                                                placeholder="(Finish Good) Size"
                                                value="<?php echo e($workorder->fg_size_1 ?? old('fg_size_1')); ?>">
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
                                                placeholder="(Finish Good) Size"
                                                value="<?php echo e($workorder->fg_size_2 ?? old('fg_size_2')); ?>">
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
                                    <label for="">Tolerance (+mm) </label>
                                    <input id="customer-tolerance-plus" name="tolerance_plus" type="text"
                                        class="form-control <?php $__errorArgs = ['tolerance_plus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Tolerance (+mm)"
                                        value="<?php echo e($workorder->tolerance_plus ?? old('tolerance_plus')); ?>">
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
                                    <label for="">Tolerance (-mm)</label>
                                    <input id="customer-tolerance" name="tolerance_minus" type="text"
                                        class="form-control <?php $__errorArgs = ['tolerance_minus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Tolerance (-)"
                                        value="<?php echo e($workorder->tolerance_minus ?? old('tolerance_minus')); ?>">
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
                                    <label for="">Reduction Rate (%)</label>
                                    <input id="customer-reduc-rate" name="fg_reduction_rate" type="text"
                                        class="form-control <?php $__errorArgs = ['fg_reduction_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="(Finish Good) Reduction Rate"
                                        value="<?php echo e($workorder->fg_reduction_rate ?? old('fg_reduction_rate')); ?>">
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
                                    <label for="">Shape</label>
                                    <select name="fg_shape" id="customer-shape"
                                        class="form-control <?php $__errorArgs = ['fg_shape'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option id="shape-round" value="Round"
                                            <?php if($workorder->fg_shape == 'Round'): ?> selected <?php endif; ?>>Round</option>
                                        <option id="shape-square" value="Square"
                                            <?php if($workorder->fg_shape == 'Square'): ?> selected <?php endif; ?>>Square</option>
                                        <option id="shape-hexagon" value="Hexagon"
                                            <?php if($workorder->fg_shape == 'Hexagon'): ?> selected <?php endif; ?>>Hexagon</option>
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
                                    <label for="">Kg per Bundle</label>
                                    <input id="kg-per-bundle" name="fg_qty_kg" type="text"
                                        class="form-control <?php $__errorArgs = ['fg_qty_kg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="(Finish Good) Kg per bundle"
                                        value="<?php echo e($workorder->fg_qty_kg ?? old('fg_qty_kg')); ?>">
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
                                    <label for="">Pcs per Bundle</label>
                                    <input id="pcs-per-bundle" name="fg_qty_pcs" type="text"
                                        class="form-control <?php $__errorArgs = ['fg_qty_pcs'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="(Finish Good) Pcs per bundle"
                                        value="<?php echo e($workorder->fg_qty_pcs ?? old('fg_qty_pcs')); ?>">
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
                                    <input type="radio" id="Chamfer_Yes" name="chamfer" value="Yes"
                                        <?php if($workorder->chamfer == 'Yes'): ?> checked <?php endif; ?>> Yes
                                    <br>
                                    <input type="radio" id="Chamfer_No" name="chamfer" value="No"
                                        <?php if($workorder->chamfer == 'No'): ?> checked <?php endif; ?>> No
                                    <br>
                                    <input type="radio" id="Chamfer_Satu_Sisi" name="chamfer" value="Satu Sisi"
                                        <?php if($workorder->chamfer == 'Satu Sisi'): ?> checked <?php endif; ?>> Satu Sisi
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
                                    <label for="">Color</label>
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
                                        <option disabled selected value> -- select color -- </option>
                                        <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($color->id); ?>"
                                                <?php if($color->id == $workorder->color): ?> selected <?php endif; ?>><?php echo e($color->name); ?>

                                            </option>
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
                                    <label for="">Machine</label>
                                    <select name="machine_id" class="form-control" id="">
                                        <?php $__currentLoopData = $machines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $machine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($machine->id); ?>"
                                                <?php if($machine->id == $workorder->machine_id): ?> selected <?php endif; ?>>
                                                <?php echo e($machine->name); ?>

                                            </option>
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
unset($__errorArgs, $__bag); ?>" placeholder="Catatan"
                                        cols="30" rows="10"><?php echo e($workorder->remarks ?? old('remarks')); ?></textarea>
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
                                        placeholder="Keterangan pada label produksi(kosongkan jika tidak dibutuhkan)" cols="30" rows="1"><?php echo e($workorder->label_remarks ?? old('label_remarks')); ?></textarea>
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
                                
                                <input type="hidden" value="<?php echo e($workorder->wo_order_num); ?>" name="wo_order_num" />
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

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('plugins/select2/js/select2.full.min.js')); ?>"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            $('#customer-size-1').on('keyup', function() {
                recalculate();
            });
            $('#supplier-diameter').on('keyup', function() {
                recalculate();
            });
            $('#kg-per-bundle').on('keyup', function() {
                recalculate();
            });

            $('#customer-shape').on('change', function() {
                recalculate();
            })

            function recalculate() {
                $('#customer-tolerance').val("-" + addTolerance($('#customer-size-1').val()));
                $('#customer-tolerance-plus').val("+" + addTolerancePlus($('#customer-size-1').val()));
                $('#customer-reduc-rate').val(calculateReducRate($('#supplier-diameter').val(), $(
                    '#customer-size-1').val()));
                $('#pcs-per-bundle').val(calculatePcsPerBundle($('#kg-per-bundle').val(), $('#customer-shape')
                .val()));
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
                        result = weightVal / diameter / diameter / panjang / response * 1000;
                        $('#pcs-per-bundle').val(result.toFixed(2));
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
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\admin\workorder\change_form.blade.php ENDPATH**/ ?>