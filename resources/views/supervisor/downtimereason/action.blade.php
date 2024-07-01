<a href="{{route('downtimeReason.edit',$model)}}" class="btn btn-warning">Edit</a>
<a href="#" onclick="event.preventDefault(); document.getElementById('deleteForm-{{$model}}').submit()" class="btn btn-danger">Delete</a>
<form action="{{route('downtimeReason.delete',$model)}}" method="POST" id="deleteForm-{{$model}}">
    @csrf
    @method('DELETE')
</form>