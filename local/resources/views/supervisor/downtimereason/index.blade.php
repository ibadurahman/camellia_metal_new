@extends('templates.default')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @include('templates.partials.alerts')
                    <div class="card">
                        <div class="card-header">
                            Sorting by Category
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <select name="" id="category-selector" onchange="update_sorting()" class="form-control">
                                        <option value="0">All</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Downtime Reason</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <a href="{{route('downtimeReason.create')}}" class="btn btn-primary">Add New Reason</a>
                                </div>
                            </div>
                            <table id="reason-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        {{-- <th>Order Number</th> --}}
										<th>Downtime Reason</th>
                                        <th>Downtime Category</th>
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
    
@endsection

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function () {
        update_sorting()
    });

    function update_sorting(){
        $('#reason-table').DataTable().destroy()
        $('#reason-table').DataTable({
            processing:true,
            serverSide:true,
            ajax:{
                "url"   :'{{route('downtimeReason.loadData')}}',
                "data"  :{
                    "category":$('#category-selector').val()
                }
            },
            columns:[
                {data:'name'},
			    {data:'downtime_category'},
				{data:'action', orderable:false}
            ],
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    }
</script>
@endpush 