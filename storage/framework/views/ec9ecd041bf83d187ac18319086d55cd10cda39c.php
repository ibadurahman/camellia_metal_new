<button href="<?php echo e(route('admin.smelting.deleteChange', $model)); ?>" class="btn btn-danger" id="delete">Delete</button>
<button class="btn btn-warning" id="edit-<?php echo e($model->id); ?>" value="<?php echo e($model); ?>">Edit</button>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('button#delete').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure want to delete?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').action = href;
                document.getElementById('deleteForm').submit();

                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                );
            }
        })

    });

    $('button#edit-<?php echo e($model->id); ?>').on('click', function(e) {
        e.preventDefault();
        var data = $(this).val();
        var data = JSON.parse(data);
        var href = $(this).attr('href');

        Swal.fire({
            title: `${data.workorder.wo_number} - Coil ${data.coil_num}`,
            html: `<div class="form-group">
                    <label for="" class="float-left">Weight (Kg)</label>
                    <input id="smelt-weight" name="weight" type="text" class="form-control" placeholder="Weight (Kg)" value="${data.weight}">
                </div>
                <div class="form-group">
                    <label for="" class="float-left">Smelting Number</label>
                    <input id="smelt-num" name="smelting_num" type="text" class="form-control" placeholder="No. Leburan" value="${data.smelting_num}">
                </div>
                <div class="form-group">
                    <label for="" class="float-left">Area</label>
                    <input id="smelt-area" name="area" type="text" class="form-control" placeholder="Area" value="${data.area}">
                </div>`,
            showCancelButton: true,
            confirmButtonText: 'Update',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                const weight = Swal.getPopup().querySelector('#smelt-weight').value;
                const smeltingNum = Swal.getPopup().querySelector('#smelt-num').value;
                const area = Swal.getPopup().querySelector('#smelt-area').value;
                if (!weight || !smeltingNum || !area) {
                    Swal.showValidationMessage(`Column can't be empty!`)
                }

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: `<?php echo e(route('admin.smelting.updateChange', $model)); ?>`,
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        _method: 'PUT',
                        weight: weight,
                        smelting_num: smeltingNum,
                        area: area,
                    },
                    error: function(error) {
                        Swal.showValidationMessage(
                            `Request failed: ${data}`
                        )
                    }
                }).then(function(response) {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return {
                        weight: weight,
                        smelting_num: smeltingNum,
                        area: area,
                    }
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                //autoclose modal
                Swal.fire({
                    title: 'Success!',
                    text: 'Data has been updated.',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    location.reload();
                });
            }
        })
    });
</script>
<?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\admin\smelting\actionChange.blade.php ENDPATH**/ ?>