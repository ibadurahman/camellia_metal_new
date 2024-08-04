
<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Realtime Monitor</h3>
                            <!-- <h3><?php echo e(exec('getmac')); ?></h3> -->
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                    <tr>
                                        <th>Machine</th>
                                        <th>Workorder</th>
                                        <th>Size</th>
                                        <th>Customer</th>
                                        <th>Processed By</th>
                                        <th>Start</th>
                                        <th>Status</th>
                                        <th>Machine Speed</th>
                                        <th>Total Production</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $machines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($mc->name); ?></td>
                                            <td><a
                                                    href="<?php echo e(url('workorder/' . $data[$mc->name]['workorder_id'] . '/show')); ?>"><?php echo e($data[$mc->name]['wo_number']); ?></a>
                                            </td>
                                            <td><?php echo e($data[$mc->name]['size']); ?></td>
                                            <td><?php echo e($data[$mc->name]['customer']); ?></td>
                                            <td><?php echo e($data[$mc->name]['processedBy']); ?></td>
                                            <td><?php echo e($data[$mc->name]['start_time']); ?></td>
                                            <td
                                                class="<?php if($data[$mc->name]['status'] == 'on process'): ?> text-success <?php else: ?> text-danger <?php endif; ?>">
                                                <?php if($data[$mc->name]['status'] == 'on process'): ?>
                                                    Running
                                                <?php else: ?>
                                                    No Process
                                                <?php endif; ?>
                                            </td>
                                            <td id="<?php echo e($mc->id); ?>-current-speed">0 MPM</td>
                                            <td id="<?php echo e($mc->id); ?>-current-counter">0 PCS</td>
                                        </tr>
                                        <tr>
                                            <td colspan="9">
                                                <div class="card card-primary" id="<?php echo e($mc->id); ?>-card">
                                                    <div class="card-header">
                                                        <h3 class="card-title"><?php echo e($mc->name); ?> Speed Chart</h3>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool"
                                                                data-card-widget="collapse">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart">
                                                            <canvas id="<?php echo e($mc->id); ?>-speed-canvas"
                                                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                        </div>
                                                    </div>
                                                    <div class="<?php echo e($mc->id); ?>-speed-chart-load overlay">
                                                        <i class="fas fa-sync-alt fa-spin"></i>
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
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
            updateSpeedChart();
        });

        function updateSpeedChart() {
            // INIT Trigger
            var machines = []
            $.ajax({
                method: 'GET',
                url: '<?php echo e(route('realtime.getMachines')); ?>',
                dataType: 'json',
                success: function(response) {
                    machines = response
                    machines.forEach(mc => {
                        $.ajax({
                            method: 'GET',
                            url: '<?php echo e(route('realtime.speedChart')); ?>',
                            data: {
                                data: {
                                    workorder_id: mc.wo_onprocess,
                                    machine: mc
                                }
                            },
                            dataType: 'json',
                            success: function(response) {
                                var areaChartCanvas = $('#' + response.machine.id +
                                    '-speed-canvas').get(0).getContext(
                                    '2d');
                                var areaChartData = {
                                    labels: response['created_at'],
                                    datasets: [{
                                        label: 'Production Speed',
                                        backgroundColor: 'rgba(60,141,188,0.9)',
                                        borderColor: 'rgba(60,141,188,0.8)',
                                        pointRadius: false,
                                        pointColor: '#3b8bba',
                                        pointStrokeColor: 'rgba(60,141,188,1)',
                                        pointHighlightFill: '#fff',
                                        pointHighlightStroke: 'rgba(60,141,188,1)',
                                        data: response['speed']
                                    }, ]
                                }
                                var areaChartOptions = {
                                    maintainAspectRatio: false,
                                    responsive: true,
                                    legend: {
                                        display: false
                                    },
                                    scales: {
                                        xAxes: [{
                                            gridLines: {
                                                display: false,
                                            },
                                        }],
                                        yAxes: [{
                                            gridLines: {
                                                display: false,
                                            },
                                            ticks: {
                                                min: 0,
                                                beginAtZero: true,
                                                callback: function(value, index, values) {
                                                    if (Math.floor(value) === value) {
                                                        return value;
                                                    }
                                                }
                                            },
                                        }]
                                    }
                                }
                                // This will get the first returned node in the jQuery collection.
                                new Chart(areaChartCanvas, {
                                    type: 'line',
                                    data: areaChartData,
                                    options: areaChartOptions
                                })

                                if (response.created_at == null) {
                                    $('#' + response.machine.id + '-card').addClass(
                                        'collapsed-card')
                                }

                                $('#' + response.machine.id + '-current-speed').html(
                                    response.speed[0] + ' MPM')
                                $('#' + response.machine.id + '-current-counter').html(
                                    response.counter[0] + ' PCS')

                                $('.' + response.machine.id + '-speed-chart-load').hide()
                            }
                        });
                    });
                }
            });


        }

        let productionChannel = Echo.channel('channel-production-graph');
        productionChannel.listen('productionGraph', function(data) {
            updateSpeedChart(data);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\local\resources\views/user/home.blade.php ENDPATH**/ ?>