{{-- <button href="{{url('/operator/schedule/'.$model->id.'/process')}}" class="btn btn-success d-none process-{{$model->id}}" id="process-{{$model->id}}" @if ($model->machine->ip_address != request()->ip())
    disabled
@endif>Process</button> --}}
<button href="{{url('/operator/schedule/'.$model->id.'/process')}}" class="btn btn-success d-none process-{{$model->id}}" id="process-{{$model->id}}">Process</button>
{{-- @if ($model->machine->ip_address != request()->ip())
    <span class="text-danger">you have no rights to process this workorder</span>
@endif --}}

<script>
 $('button#process-{{$model->id}}').on('click', function(e){
     e.preventDefault();
     var href = $(this).attr('href');
     Swal.fire({
        title: 'Are you sure want to process this workorder?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, process it!'
        }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('processForm').action=href;
            document.getElementById('processForm').submit();
        }
    })
     
 });
</script>
