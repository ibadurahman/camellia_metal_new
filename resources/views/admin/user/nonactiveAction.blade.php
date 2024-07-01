<button dusk="activate_{{ $model->id }}" href="{{ route('admin.user.activate', $model) }}" class="btn btn-success"
    id="activate">Activate</button>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('button#activate').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, activate this account!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('activateForm').action = href;
                document.getElementById('activateForm').submit();

            }
        })
    });
</script>
