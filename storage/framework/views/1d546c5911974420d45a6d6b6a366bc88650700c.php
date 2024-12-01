
<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Bundle Data</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('spvproduction.update', $production)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <?php if($errors->any()): ?>
                                    <?php echo implode('', $errors->all('<div>:message</div>')); ?>

                                <?php endif; ?>
                                <input hidden name="workorder_id" type="text" class="form-control"
                                    placeholder="Workorder Id"
                                    value="<?php echo e(old('workorder_id') ?? $production->workorder_id); ?>">
                                <div class="form-group">
                                    <label for="">Bundle Number</label>
                                    <select name="bundle_num"
                                        class="form-control <?php $__errorArgs = ['bundle_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="<?php echo e($production->bundle_num); ?>" selected><?php echo e($production->bundle_num); ?>

                                        </option>
                                    </select>
                                    <?php $__errorArgs = ['bundle_num'];
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
                                    <label for="">Coil Number</label>
                                    <select name="coil_num" class="form-control <?php $__errorArgs = ['coil_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">-- Select Coil Number --</option>
                                        <?php $__currentLoopData = $smeltings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $smelt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($smelt->id); ?>"
                                                <?php if($smelt->id == $production->coil_num || old('coil_num') == $smelt->id): ?> selected <?php endif; ?>>Coil Num :
                                                <?php echo e($smelt->coil_num); ?> - No. Leburan : <?php echo e($smelt->smelting_num); ?> - Berat
                                                : <?php echo e($smelt->weight); ?> Kg</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['coil_num'];
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
                                    <label for="">Dies Number</label>
                                    <input name="dies_num" type="text"
                                        class="form-control <?php $__errorArgs = ['dies_num'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Dies Number" value="<?php echo e(old('dies_num') ?? $production->dies_num); ?>">
                                    <?php $__errorArgs = ['dies_num'];
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
                                    <label for="">Diameter Ujung</label>
                                    <input name="diameter_ujung" type="text"
                                        class="form-control <?php $__errorArgs = ['diameter_ujung'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Diameter Ujung"
                                        value="<?php echo e(old('diameter_ujung') ?? $production->diameter_ujung); ?>">
                                    <?php $__errorArgs = ['diameter_ujung'];
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
                                    <label for="">Diameter Tengah</label>
                                    <input name="diameter_tengah" type="text"
                                        class="form-control <?php $__errorArgs = ['diameter_tengah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Diameter Tengah"
                                        value="<?php echo e(old('diameter_tengah') ?? $production->diameter_tengah); ?>">
                                    <?php $__errorArgs = ['diameter_tengah'];
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
                                    <label for="">Diameter Ekor</label>
                                    <input name="diameter_ekor" type="text"
                                        class="form-control <?php $__errorArgs = ['diameter_ekor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Diameter Ekor"
                                        value="<?php echo e(old('diameter_ekor') ?? $production->diameter_ekor); ?>">
                                    <?php $__errorArgs = ['diameter_ekor'];
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
                                    <label for="">Kelurusan Aktual</label>
                                    <input name="kelurusan_aktual" type="text"
                                        class="form-control <?php $__errorArgs = ['kelurusan_aktual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Kelurusan Aktual"
                                        value="<?php echo e(old('kelurusan_aktual') ?? $production->kelurusan_aktual); ?>">
                                    <?php $__errorArgs = ['kelurusan_aktual'];
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
                                    <label for="">Panjang Aktual</label>
                                    <input name="panjang_aktual" type="text"
                                        class="form-control <?php $__errorArgs = ['panjang_aktual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Panjang Aktual"
                                        value="<?php echo e(old('panjang_aktual') ?? $production->panjang_aktual); ?>">
                                    <?php $__errorArgs = ['panjang_aktual'];
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
                                    <label for="">Berat Finish Good</label>
                                    <input name="berat_fg" type="text"
                                        class="form-control <?php $__errorArgs = ['berat_fg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Berat Finish Good"
                                        value="<?php echo e(old('berat_fg') ?? $production->berat_fg); ?>">
                                    <?php $__errorArgs = ['berat_fg'];
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
                                    <label for="">Qty per bundle (Pcs)</label>
                                    <input name="pcs_per_bundle" type="text"
                                        class="form-control <?php $__errorArgs = ['pcs_per_bundle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Qty per bundle (Pcs)"
                                        value="<?php echo e(old('pcs_per_bundle') ?? $production->pcs_per_bundle); ?>">
                                    <?php $__errorArgs = ['pcs_per_bundle'];
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
                                    <label for="">Bundle Judgement</label>
                                    <select name="bundle_judgement" id="judgement-select"
                                        class="form-control <?php $__errorArgs = ['bundle_judgement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">-- Select Judgement --</option>
                                        <option value="good" <?php if($production->bundle_judgement == 'good'): ?> selected <?php endif; ?>>Good
                                        </option>
                                        <option value="notgood" <?php if($production->bundle_judgement == 'notgood'): ?> selected <?php endif; ?>>Not Good
                                        </option>
                                        <option value="waste" <?php if($production->bundle_judgement == 'waste'): ?> selected <?php endif; ?>>Waste
                                        </option>
                                    </select>
                                    <?php $__errorArgs = ['bundle_judgement'];
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
                                    <label for="">Visual</label>
                                    <select name="visual" id="visual-options"
                                        class="form-control <?php $__errorArgs = ['visual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    </select>
                                    <?php $__errorArgs = ['visual'];
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
                                    <input value="Apply" type="submit" class="btn btn-primary">
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
    <script>
        $(document).ready(function() {
            if ($('#judgement-select').val() == 'notgood') {
                // console.log('bad selected');
                $('#visual-options').html(
                    `<option disabled selected value="">-- Select Judgement --</option>
                <option value="PO" <?php if($production->visual === 'PO'): ?> selected <?php endif; ?>>PO</option>
                <option value="OT" <?php if($production->visual === 'OT'): ?> selected <?php endif; ?>>OT</option>
                <option value="IL" <?php if($production->visual === 'IL'): ?> selected <?php endif; ?>>IL</option>
                <option value="OS" <?php if($production->visual === 'OS'): ?> selected <?php endif; ?>>OS</option>
                <option value="LS" <?php if($production->visual === 'LS'): ?> selected <?php endif; ?>>LS</option>
                <option value="OVAL" <?php if($production->visual === 'OVAL'): ?> selected <?php endif; ?>>OVAL</option>
                <option value="TS" <?php if($production->visual === 'TS'): ?> selected <?php endif; ?>>TS</option>
                <option value="BM" <?php if($production->visual === 'BM'): ?> selected <?php endif; ?>>BM</option>
                <option value="CM" <?php if($production->visual === 'CM'): ?> selected <?php endif; ?>>CM</option>
                <option value="SP" <?php if($production->visual === 'SP'): ?> selected <?php endif; ?>>SP</option>
                <option value="MH" <?php if($production->visual === 'MH'): ?> selected <?php endif; ?>>MH</option>
                <option value="RUSTY" <?php if($production->visual === 'RUSTY'): ?> selected <?php endif; ?>>RUSTY</option>
                <option value="PIN HOLE" <?php if($production->visual === 'PIN HOLE'): ?> selected <?php endif; ?>>PIN HOLE</option>
                <option value="LS Material" <?php if($production->visual === 'LS Material'): ?> selected <?php endif; ?>>LS Material</option>`
                );
            }
            if ($('#judgement-select').val() == 'good') {
                // console.log('Good selected');
                $('#visual-options').html(
                    `<option disabled selected value="">-- Select Judgement --</option>
                    <option value="OK" <?php if($production->visual === 'OK'): ?> selected <?php endif; ?>>OK</option>
                    <option value="SP/OK" <?php if($production->visual === 'SP/OK'): ?> selected <?php endif; ?>>SP/OK</option>
                    <option value="BM/OK" <?php if($production->visual === 'BM/OK'): ?> selected <?php endif; ?>>BM/OK</option>
                    <option value="OT (Besar)/OK" <?php if($production->visual === 'OT (Besar)/OK'): ?> selected <?php endif; ?>>OT (Besar)/OK</option>
                    <option value="OT (Kecil)/OK" <?php if($production->visual === 'OT (Kecil)/OK'): ?> selected <?php endif; ?>>OT (Kecil)/OK</option>
                    <option value="IL/OK" <?php if($production->visual === 'IL/OK'): ?> selected <?php endif; ?>>IL/OK</option>
                    <option value="TS/OK" <?php if($production->visual === 'TS/OK'): ?> selected <?php endif; ?>>TS/OK</option>
                    <option value="LS/OK" <?php if($production->visual === 'LS/OK'): ?> selected <?php endif; ?>>LS/OK</option>
                    <option value="OVAL/OK" <?php if($production->visual === 'OVAL/OK'): ?> selected <?php endif; ?>>OVAL/OK</option>
                    <option value="LS Material/OK" <?php if($production->visual === 'LS Material/OK'): ?> selected <?php endif; ?>>LS Material/OK</option>`
                );
            }
            if ($('#judgement-select').val() == 'waste') {
                // console.log('Good selected');
                $('#visual-options').html(
                    '<option disabled selected value="">-- Select Judgement --</option>'
                );
            }
        })

        $('#judgement-select').on('change', function(event) {
            if ($('#judgement-select').val() == 'notgood') {
                // console.log('bad selected');
                $('#visual-options').html(
                    `<option disabled selected value="">-- Select Judgement --</option>
                <option value="PO">PO</option>
                <option value="OT">OT</option>
                <option value="IL">IL</option>
                <option value="OS">OS</option>
                <option value="LS">LS</option>
                <option value="OVAL">OVAL</option>
                <option value="TS">TS</option>
                <option value="BM">BM</option>
                <option value="CM">CM</option>
                <option value="SP">SP</option>
                <option value="MH">MH</option>
                <option value="RUSTY">RUSTY</option>
                <option value="PIN HOLE">PIN HOLE</option>
                <option value="LS Material">LS Material</option>`
                );
            }
            if ($('#judgement-select').val() == 'good') {
                // console.log('Good selected');
                $('#visual-options').html(
                    `<option disabled selected value="">-- Select Judgement --</option>
                <option value="OK">OK</option>
                <option value="SP/OK">SP/OK</option>
                <option value="BM/OK">BM/OK</option>
                <option value="OT (Besar)/OK">OT (Besar)/OK</option>
                <option value="OT (Kecil)/OK">OT (Kecil)/OK</option>
                <option value="IL/OK">IL/OK</option>
                <option value="TS/OK">TS/OK</option>
                <option value="LS/OK">LS/OK</option>
                <option value="OVAL/OK">OVAL/OK</option>
                <option value="LS Material/OK">LS Material/OK</option>`
                );
            }
            if ($('#judgement-select').val() == 'waste') {
                // console.log('Good selected');
                $('#visual-options').html(
                    '<option disabled selected value="">-- Select Judgement --</option>'
                );
            }
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\supervisor\production\edit.blade.php ENDPATH**/ ?>