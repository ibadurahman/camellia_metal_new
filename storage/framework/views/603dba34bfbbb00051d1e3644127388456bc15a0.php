<a href="<?php echo e(route('admin.smelting.create',['id'=>$model])); ?>" class="btn btn-primary">Data Leburan</a>

<div class="card card-body">
    <table class="table-bordered table-hover">
        <thead>
            <tr>
                <th>No. Coil</th>
                <th>Berat</th>
                <th>No. Leburan</th>
                <th>Area</th>
            </tr>
        </thead>
        <tbody id="smelts-table-<?php echo e($model->id); ?>">
        </tbody>
    </table>
</div>

<script>
    // $('#smelts-table-<?php echo e($model->id); ?>').DataTable().clear().destroy();
    $.ajax({
        type: "GET",
        dataType: "json", 
        url: '<?php echo e(route('admin.smelting.data_wo')); ?>',
        data: {
            wo_id:'<?php echo e($model->id); ?>',
        },
        success: function(data) {
            var content = '';
            for(let i = 0; i < data.length; i++){
                content += '<tr><td>' + data[i].coil_num + '</td><td>' + data[i].weight + '</td><td>' + data[i].smelting_num + '</td><td>' + data[i].area + '</td></tr>';
            }
            $('tbody#smelts-table-<?php echo e($model->id); ?>').html(content);
        }
    });
</script>
<?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views/admin/workorder/smelting.blade.php ENDPATH**/ ?>