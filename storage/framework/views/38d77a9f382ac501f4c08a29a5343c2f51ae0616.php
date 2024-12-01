

<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Workorder Data</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" id="search-form" class="" role="form">
                                <div class="form-row">
                                    <div class="form-group">
                                        <div class="input-group date" id="reservationdatetime1" data-target-input="nearest">
                                            <label style="padding-right: 10px ">Search Data From :</label>
                                            <input name="report_date_1" type="text"
                                                class="form-control datetimepicker-input <?php $__errorArgs = ['report_date_1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                data-target="#reservationdatetime1" value="<?php echo e(old('report_date_1')); ?>" />
                                            <div class="input-group-append" data-target="#reservationdatetime1"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group date" id="reservationdatetime2" data-target-input="nearest">
                                            <label style="padding-left: 10px; padding-right: 10px ">To :</label>
                                            <input name="report_date_2" type="text"
                                                class="form-control datetimepicker-input <?php $__errorArgs = ['report_date_2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                data-target="#reservationdatetime2" value="<?php echo e(old('report_date_2')); ?>" />
                                            <div class="input-group-append" data-target="#reservationdatetime2"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label style="padding-right: 10px ">Workorder Number : </label>
                                            <input name="wo_number" type="text"
                                                class="form-control <?php $__errorArgs = ['wo_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                value="<?php echo e(old('wo_number')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label style="padding-right: 10px; padding-left: 10px;">Machine : </label>
                                            <select name="machine_id" id="machine-selector" onchange=""
                                                class="form-control">
                                                <option value="0">All</option>
                                                <?php $__currentLoopData = $machines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $machine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($machine->id); ?>"><?php echo e($machine->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label style="padding-right: 10px; padding-left: 10px;">Status : </label>
                                            <select name="status" id="status-selector" onchange="" class="form-control">
                                                <option value="">All</option>
                                                <option value="draft">Draft</option>
                                                <option value="waiting">Waiting</option>
                                                <option value="on process">On Process</option>
                                                <option value="on check">On Check</option>
                                                <option value="closed">Closed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mb-0">
                                    <div class="col-6">
                                        <button style="padding-left: 10px; padding-right: 10px" type="submit"
                                            class="btn btn-primary">Search</button>
                                        <button id="clear-button"
                                            style="margin-left: 10px; padding-left: 10px; padding-right: 10px"
                                            class="btn btn-danger">Clear Search</button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button id="report-download-button"
                                            style="margin-left: 10px; padding-left: 10px; padding-right: 10px"
                                            class="btn btn-success">Download All Report</button>
                                    </div>
                                </div>
                            </form>
                            <br><br>
                            <table id="dataTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>WO Number</th>
                                        <th>Machine</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Status WO</th>
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
        $(function() {
            $('#reservationdatetime1').datetimepicker({
                format: 'YYYY-MM-DD',
            });
            $('#reservationdatetime2').datetimepicker({
                format: 'YYYY-MM-DD',
            });

            var oTable = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    method: 'GET',
                    url: '<?php echo e(route('workorder.ajaxRequestAll')); ?>',
                    data: function(d) {
                        d.report_date_1 = $('input[name=report_date_1]').val();
                        d.report_date_2 = $('input[name=report_date_2]').val();
                        d.machine_id = $('select[name=machine_id]').val();
                        d.status = $('select[name=status]').val();
                        d.wo_number = $('input[name=wo_number]').val();
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'wo_number'
                    },
                    {
                        data: 'machine'
                    },
                    {
                        data: 'process_start'
                    },
                    {
                        data: 'process_end'
                    },
                    {
                        data: 'status_wo'
                    },
                    {
                        data: 'action'
                    }
                ],
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                oTable.draw();
            });

            $('#clear-button').on('click', function(e) {
                e.preventDefault();
                $('input[name=report_date_1]').val('');
                $('input[name=report_date_2]').val('');
                $('input[name=wo_number]').val('');
                $('input[name=status]').val('');
                $('#search-form').submit();
            });

            $('#report-download-button').on('click', function(e) {
                e.preventDefault();

                var report_date_1 = $('input[name=report_date_1]').val();
                var report_date_2 = $('input[name=report_date_2]').val();
                var machine_id = $('select[name=machine_id]').val();
                var status = $('select[name=status]').val();
                var wo_number = $('input[name=wo_number]').val();

                $.ajax({
                    method: 'POST',
                    url: '<?php echo e(route('workorder.batchDownload')); ?>',
                    data: {
                        report_date_1: report_date_1,
                        report_date_2: report_date_2,
                        machine_id: machine_id,
                        status: status,
                        wo_number: wo_number,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Downloading..',
                            html: 'Please wait.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                                //get download status
                                // var interval = setInterval(function() {
                                //     console.log('get download status')
                                //     $.ajax({
                                //         method: 'GET',
                                //         url: '',
                                //         success: function(response) {
                                //             if (response.status.total_wo == response.status.total_generated) {
                                //                 clearInterval(interval);
                                //                 Swal.close();
                                //             }
                                //             console.log(response);
                                //         },
                                //         error: function(response) {
                                //             console.log(response);
                                //         },
                                //     });
                                // }, 1000);
                                
                            },
                        })
                    },
                    error: function(response) {
                        console.log(response);
                    },
                }).done(function(response) {
                    swal.fire({
                        icon: 'success',
                        html: '<h5>Success! your reports will download automatically.</h5>',
                    });
                    window.location.href = `${window.location.origin}/workorder/downloadFile/${response.filename}`
                });
            })
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\user\workorder\index.blade.php ENDPATH**/ ?>