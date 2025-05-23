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
                            Sorting by Machine
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <select name="" id="machine-selector" onchange="update_sorting()"
                                        class="form-control">
                                        @foreach ($machines as $machine)
                                            @if ($machine->ip_address == request()->ip())
                                                <option value="{{ $machine->id }}" selected>{{ $machine->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Waiting Process</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        {{-- <div class="card-body">
                            <a href="{{route('admin.workorder.create')}}" class="btn btn-primary">Add New Workorder</a>         
                        </div> --}}
                        <div class="card-body">
                            <table id="waiting-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>WO Number</th>
                                        <th>Supplier</th>
                                        <th>Grade</th>
                                        <th>Diameter (mm)</th>
                                        <th>Qty (kg / coil)</th>
                                        <th>Qty (bundle)</th>
                                        <th>Customer</th>
                                        <th>Straightness Std</th>
                                        <th>Shape</th>
                                        <th>Size (mm x mm)</th>
                                        <th>Diameter Tolerance (mm)</th>
                                        <th>Length Tolerance (mm)</th>
                                        <th>Reduction Rate (%)</th>
                                        <th>FG Qty (kg)</th>
                                        <th>FG Qty (pcs)</th>
                                        <th>Workorder Status</th>
                                        <th>Chamfer</th>
                                        <th>Color</th>
                                        <th>Machine</th>
                                        <th>Created By</th>
                                        <th>Created at</th>
                                        <th>Edited By</th>
                                        <th>Updated at</th>
                                        <th>Remarks</th>
                                        <th>Leburan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">On Process</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="onprocess-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        {{-- <th>Order Number</th> --}}
                                        <th>WO Number</th>
                                        <th>Supplier</th>
                                        <th>Grade</th>
                                        <th>Diameter (mm)</th>
                                        <th>Qty (kg / coil)</th>
                                        <th>Qty (bundle)</th>
                                        <th>Customer</th>
                                        <th>Straightness Std</th>
                                        <th>Shape</th>
                                        <th>Size (mm x mm)</th>
                                        <th>Diameter Tolerance (mm)</th>
                                        <th>Length Tolerance (mm)</th>
                                        <th>Reduction Rate (%)</th>
                                        <th>FG Qty (kg)</th>
                                        <th>FG Qty (pcs)</th>
                                        <th>Workorder Status</th>
                                        <th>Chamfer</th>
                                        <th>Color</th>
                                        <th>Machine</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Edited By</th>
                                        <th>Updated At</th>
                                        <th>Processed By</th>
                                        <th>Process Start</th>
                                        <th>Remarks</th>
                                        <th>Leburan</th>
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
    <form action="" method="POST" id="processForm">
        @csrf
        <input type="submit" value="Process" style="display:none">
    </form>
@endsection

@push('scripts')
    <script>
        $(function() {
            update_sorting()
        });

        function update_sorting() {
            $('#waiting-table').DataTable().destroy()
            $('#onprocess-table').DataTable().destroy()
            let waitingTable = $('#waiting-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": '{{ route('workorder.showWaiting') }}',
                    "data": {
                        "machine": $('#machine-selector').val()
                    }
                },
                columns: [{
                        data: 'wo_number'
                    },
                    {
                        data: 'bb_supplier'
                    },
                    {
                        data: 'bb_grade'
                    },
                    {
                        data: 'bb_diameter'
                    },
                    {
                        data: 'bb_qty_combine'
                    },
                    {
                        data: 'bb_qty_bundle'
                    },
                    {
                        data: 'fg_customer'
                    },
                    {
                        data: 'straightness_standard'
                    },
                    {
                        data: 'fg_shape'
                    },
                    {
                        data: 'fg_size_combine'
                    },
                    {
                        data: 'tolerance_combine'
                    },
                    {
                        data: 'length_tolerance_combine'
                    },
                    {
                        data: 'fg_reduction_rate'
                    },
                    {
                        data: 'fg_qty_kg'
                    },
                    {
                        data: 'fg_qty_pcs'
                    },
                    {
                        data: 'status_wo'
                    },
                    {
                        data: 'chamfer'
                    },
                    {
                        data: 'color'
                    },
                    {
                        data: 'machine'
                    },
                    {
                        data: 'created_by'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'edited_by'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: 'remarks'
                    },
                    {
                        data: 'smelting'
                    },
                    {
                        data: 'action'
                    }
                ],
                "paging": false,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
                //show button process on first row 
                "drawCallback": function(settings) {
                    var api = this.api();
                    //rows on click
                    api.$('tr').on('click', function() {
                        //check if this is the first row
                        let count = 0;
                        if (api.row(this).index() == 0) {
                            // remove d-none class on process button
                            // add interval 1 second
                            let looping = setInterval(() => {
                                if (count >= 2) {
                                    clearInterval(looping)
                                }
                                console.log($('#process-' + api.row(this).data().id))
                                $('.process-' + api.row(this).data().id).removeClass('d-none')
                                count++;
                            }, 1000);
                        }
                    });

                }
            })



            $('#onprocess-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": '{{ route('workorder.showOnProcess') }}',
                    "data": {
                        "machine": $('#machine-selector').val()
                    }
                },
                columns: [
                    // {data:'wo_order_num'},
                    {
                        data: 'wo_number'
                    },
                    {
                        data: 'bb_supplier'
                    },
                    {
                        data: 'bb_grade'
                    },
                    {
                        data: 'bb_diameter'
                    },
                    {
                        data: 'bb_qty_combine'
                    },
                    {
                        data: 'bb_qty_bundle'
                    },
                    {
                        data: 'fg_customer'
                    },
                    {
                        data: 'straightness_standard'
                    },
                    {
                        data: 'fg_shape'
                    },
                    {
                        data: 'fg_size_combine'
                    },
                    {
                        data: 'tolerance_combine'
                    },
                    {
                        data: 'length_tolerance_combine'
                    },
                    {
                        data: 'fg_reduction_rate'
                    },
                    {
                        data: 'fg_qty_kg'
                    },
                    {
                        data: 'fg_qty_pcs'
                    },
                    {
                        data: 'status_wo'
                    },
                    {
                        data: 'chamfer'
                    },
                    {
                        data: 'color'
                    },
                    {
                        data: 'machine'
                    },
                    {
                        data: 'created_by'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'edited_by'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: 'processed_by'
                    },
                    {
                        data: 'process_start'
                    },
                    {
                        data: 'remarks'
                    },
                    {
                        data: 'smelting'
                    },
                ],
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });

        }
    </script>
@endpush
