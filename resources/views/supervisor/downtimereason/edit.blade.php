@extends('templates.default')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add New Reason</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('downtimeReason.update', $downtimeReason)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Category</label>
                                    <select name="dt_category_id" class="form-control @error('dt_category_id') is-invalid @enderror" value="{{old('dt_category_id')}}">
                                        <option disabled selected value> -- select downtime category -- </option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}" @if (old('dt_category_id') == $category->id || $category->id == $downtimeReason->dt_category_id)
                                                selected
                                            @endif>{{$category->name}}</option>  
                                        @endforeach
                                    </select>
                                    @error('dt_category_id')
                                        <span class="text-danger help-block">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{old('name')??$downtimeReason->name}}">
                                    @error('name')
                                        <span class="text-danger help-block">{{$message}}</span>
                                    @enderror
                                </div>
                                
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
@endsection