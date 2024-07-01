@extends('templates.default')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add New Machine</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.machine.store')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{old('name')}}">
                                    @error('name')
                                        <span class="text-danger help-block">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Line</label>
                                    <select name="line_id" class="form-control @error('line_id') is-invalid @enderror" value="{{old('line_id')}}">
                                        <option disabled selected value> -- select Line -- </option>
                                        @foreach ($lines as $line)
                                            <option value="{{$line->id}}">{{$line->name}}</option>  
                                        @endforeach
                                    </select>
                                    @error('line_id')
                                        <span class="text-danger help-block">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">IP Address</label>
                                    <input name="ip_address" type="text" class="form-control @error('ip_address') is-invalid @enderror" placeholder="IP Address" value="{{old('ip_address')}}">
                                    @error('ip_address')
                                        <span class="text-danger help-block">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input value="Add" type="submit" class="btn btn-primary">
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