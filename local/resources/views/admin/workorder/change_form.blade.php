@extends('templates.default')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Change Request</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.workorder.changeUpdate', $workorder) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" value="{{ $workorder->id }}" name="workorder_id" />
                                @if ($errors->any())
                                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                                @endif
                                <div class="form-group">
                                    <label for="">WO Number</label>
                                    <input name="wo_number" type="text"
                                        class="form-control @error('wo_number') is-invalid @enderror"
                                        placeholder="Workorder Number"
                                        value="{{ $workorder->wo_number ?? old('wo_number') }}">
                                    @error('wo_number')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="alert alert-primary text-center" role="alert">
                                    Bahan Baku
                                </div>
                                <div class="form-group">
                                    <label for="">Supplier</label>
                                    <select id="supplier-cmbbx" name="bb_supplier"
                                        class="form-control select2 @error('bb_supplier') is-invalid @enderror">
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->name }}"
                                                @if ($supplier->name == $workorder->bb_supplier) selected @endif>
                                                {{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('bb_supplier')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Grade</label>
                                    <input id="supplier-grade" name="bb_grade" type="text"
                                        class="form-control @error('bb_grade') is-invalid @enderror"
                                        placeholder="(Bahan Baku) Grade"
                                        value="{{ $workorder->bb_grade ?? old('bb_grade') }}">
                                    @error('bb_grade')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Diameter</label>
                                    <div class="row">
                                        <div class="col-11">
                                            <input id="supplier-diameter" name="bb_diameter" type="text"
                                                class="form-control @error('bb_diameter') is-invalid @enderror"
                                                placeholder="(Bahan Baku) Diameter"
                                                value="{{ $workorder->bb_diameter ?? old('bb_diameter') }}">
                                            @error('bb_diameter')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-1">
                                            <label for="">mm</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Qty</label>
                                    <div class="row">
                                        <div class="col-5">
                                            <input id="supplier-qty-kg" name="bb_qty_pcs" type="text"
                                                class="form-control @error('bb_qty_pcs') is-invalid @enderror"
                                                placeholder="(Bahan Baku) Qty PCS"
                                                value="{{ $workorder->bb_qty_pcs ?? old('bb_qty_pcs') }}">
                                            @error('bb_qty_pcs')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-1">
                                            <label for="">Kg</label>
                                        </div>
                                        <div class="col-5">
                                            <input id="supplier-qty-coil" name="bb_qty_coil" type="text"
                                                class="form-control @error('bb_qty_coil') is-invalid @enderror"
                                                placeholder="(Bahan Baku) Qty COIL"
                                                value="{{ $workorder->bb_qty_coil ?? old('bb_qty_coil') }}">
                                            @error('bb_qty_coil')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-1">
                                            <label for="">Coil</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Bundle</label>
                                    <input id="supplier-qty-bundle" name="bb_qty_bundle" type="text"
                                        class="form-control @error('bb_qty_bundle') is-invalid @enderror"
                                        placeholder="Qty (Bundle)"
                                        value="{{ $workorder->bb_qty_bundle ?? old('bb_qty_bundle') }}">
                                    @error('bb_qty_bundle')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="alert alert-primary text-center" role="alert">
                                    Finish good
                                </div>
                                <div class="form-group">
                                    <label for="">Customer</label>
                                    <select id="customer-cmbbx" name="fg_customer"
                                        class="form-control select2 @error('fg_customer') is-invalid @enderror">
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->name }}"
                                                @if ($customer->name == $workorder->fg_customer) selected @endif>
                                                {{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('fg_customer')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Standar Kelurusan</label>
                                    <input id="customer-straight-standard" name="straightness_standard" type="text"
                                        class="form-control @error('straightness_standard') is-invalid @enderror"
                                        placeholder="Standar Kelurusan"
                                        value="{{ $workorder->straightness_standard ?? old('straightness_standard') }}">
                                    @error('straightness_standard')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Size</label>
                                    <div class="row">
                                        <div class="col-5">
                                            <input id="customer-size-1" name="fg_size_1" type="text"
                                                class="form-control @error('fg_size_1') is-invalid @enderror"
                                                placeholder="(Finish Good) Size"
                                                value="{{ $workorder->fg_size_1 ?? old('fg_size_1') }}">
                                            @error('fg_size_1')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-1">
                                            <label class="right" for="">X</label>
                                        </div>
                                        <div class="col-5">
                                            <input id="customer-size-2" name="fg_size_2" type="text"
                                                class="form-control @error('fg_size_2') is-invalid @enderror"
                                                placeholder="(Finish Good) Size"
                                                value="{{ $workorder->fg_size_2 ?? old('fg_size_2') }}">
                                            @error('fg_size_2')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-1">
                                            <label for="">mm</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="">Diameter Tolerance (+mm) </label>
                                            <input id="customer-tolerance-plus" name="tolerance_plus" type="text"
                                                class="form-control @error('tolerance_plus') is-invalid @enderror"
                                                placeholder="Diameter Tolerance (+mm)"
                                                value="{{ $workorder->tolerance_plus ?? old('tolerance_plus') }}">
                                            @error('tolerance_plus')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                             <label for="">Diameter Tolerance (-mm)</label>
                                            <input id="customer-tolerance" name="tolerance_minus" type="text"
                                                class="form-control @error('tolerance_minus') is-invalid @enderror"
                                                placeholder="Diameter Tolerance (-)"
                                                value="{{ $workorder->tolerance_minus ?? old('tolerance_minus') }}">
                                            @error('tolerance_minus')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="">Length Tolerance (+mm) </label>
                                            <input id="length-tolerance-plus" name="length_tolerance_plus" type="text"
                                                class="form-control @error('length tolerance_plus') is-invalid @enderror"
                                                placeholder="Length Tolerance (+mm)"
                                                value="{{ $workorder->length_tolerance_plus ?? old('length_tolerance_plus') }}">
                                            @error('length_tolerance_plus')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="">Length Tolerance (-mm)</label>
                                            <input id="length-tolerance" name="length_tolerance_minus" type="text"
                                                class="form-control @error('length_tolerance_minus') is-invalid @enderror"
                                                placeholder="Length Tolerance (-)"
                                                value="{{ $workorder->length_tolerance_minus ?? old('length_tolerance_minus') }}">
                                            @error('length_tolerance_minus')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Reduction Rate (%)</label>
                                    <input id="customer-reduc-rate" name="fg_reduction_rate" type="text"
                                        class="form-control @error('fg_reduction_rate') is-invalid @enderror"
                                        placeholder="(Finish Good) Reduction Rate"
                                        value="{{ $workorder->fg_reduction_rate ?? old('fg_reduction_rate') }}">
                                    @error('fg_reduction_rate')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Shape</label>
                                    <select name="fg_shape" id="customer-shape"
                                        class="form-control @error('fg_shape') is-invalid @enderror">
                                        <option id="shape-round" value="Round"
                                            @if ($workorder->fg_shape == 'Round') selected @endif>Round</option>
                                        <option id="shape-square" value="Square"
                                            @if ($workorder->fg_shape == 'Square') selected @endif>Square</option>
                                        <option id="shape-hexagon" value="Hexagon"
                                            @if ($workorder->fg_shape == 'Hexagon') selected @endif>Hexagon</option>
                                    </select>
                                    {{-- <input id="customer-shape" name="fg_shape" type="text" class="form-control @error('fg_shape') is-invalid @enderror" placeholder="(Finish Good) Shape" value="{{$workorder->fg_shape ?? old('fg_shape')}}"> --}}
                                    @error('fg_shape')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Kg per Bundle</label>
                                    <input id="kg-per-bundle" name="fg_qty_kg" type="text"
                                        class="form-control @error('fg_qty_kg') is-invalid @enderror"
                                        placeholder="(Finish Good) Kg per bundle"
                                        value="{{ $workorder->fg_qty_kg ?? old('fg_qty_kg') }}">
                                    @error('fg_qty_kg')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Pcs per Bundle</label>
                                    <input id="pcs-per-bundle" name="fg_qty_pcs" type="text"
                                        class="form-control @error('fg_qty_pcs') is-invalid @enderror"
                                        placeholder="(Finish Good) Pcs per bundle"
                                        value="{{ $workorder->fg_qty_pcs ?? old('fg_qty_pcs') }}">
                                    @error('fg_qty_pcs')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Chamfer</label>
                                    <br>
                                    <input type="radio" id="Chamfer_Yes" name="chamfer" value="Yes"
                                        @if ($workorder->chamfer == 'Yes') checked @endif> Yes
                                    <br>
                                    <input type="radio" id="Chamfer_No" name="chamfer" value="No"
                                        @if ($workorder->chamfer == 'No') checked @endif> No
                                    <br>
                                    <input type="radio" id="Chamfer_Satu_Sisi" name="chamfer" value="Satu Sisi"
                                        @if ($workorder->chamfer == 'Satu Sisi') checked @endif> Satu Sisi
                                    @error('chamfer')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Color</label>
                                    <select id="color-cmbbx" name="color"
                                        class="form-control select2 @error('color') is-invalid @enderror"
                                        value="{{ old('color') }}">
                                        <option disabled selected value> -- select color -- </option>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->id }}"
                                                @if ($color->id == $workorder->color) selected @endif>{{ $color->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('color')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Machine</label>
                                    <select name="machine_id" class="form-control" id="">
                                        @foreach ($machines as $machine)
                                            <option value="{{ $machine->id }}"
                                                @if ($machine->id == $workorder->machine_id) selected @endif>
                                                {{ $machine->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('machine_id')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" placeholder="Catatan"
                                        cols="30" rows="10">{{ $workorder->remarks ?? old('remarks') }}</textarea>
                                    @error('remarks')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Label Remarks</label>
                                    <textarea name="label_remarks" class="form-control @error('label_remarks') is-invalid @enderror"
                                        placeholder="Keterangan pada label produksi(kosongkan jika tidak dibutuhkan)" cols="30" rows="1">{{ $workorder->label_remarks ?? old('label_remarks') }}</textarea>
                                    @error('label_remarks')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <input type="hidden" value="{{ $workorder->wo_order_num }}" name="wo_order_num" />
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

@push('scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            $('#customer-size-1').on('keyup', function() {
                recalculate();
            });
            $('#supplier-diameter').on('keyup', function() {
                recalculate();
            });
            $('#kg-per-bundle').on('keyup', function() {
                recalculate();
            });

            $('#customer-shape').on('change', function() {
                recalculate();
            })

            function recalculate() {
                $('#customer-tolerance').val("-" + addTolerance($('#customer-size-1').val()));
                $('#customer-tolerance-plus').val("+" + addTolerancePlus($('#customer-size-1').val()));
                $('#customer-reduc-rate').val(calculateReducRate($('#supplier-diameter').val(), $(
                    '#customer-size-1').val()));
                $('#pcs-per-bundle').val(calculatePcsPerBundle($('#kg-per-bundle').val(), $('#customer-shape')
                .val()));
            }

            function calculateReducRate(dia_1 = 0, dia_2 = 0) {
                var result = (1 - ((dia_2 * dia_2) / (dia_1 * dia_1))) * 100;
                return result.toFixed(2);
            }

            function calculatePcsPerBundle(weightVal = 0, shape = null) {
                var diameter = $('#customer-size-1').val();
                var panjang = $('#customer-size-2').val();
                var result = 0;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.workorder.calculatePcsPerBundle') }}",
                    data: {
                        shape: shape,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        result = weightVal / diameter / diameter / panjang / response * 1000;
                        $('#pcs-per-bundle').val(result.toFixed(2));
                    }
                })
            }

            function addTolerance(diameter = 0) {
                var shape = $('#customer-shape').val();
                if (diameter >= 3.01 && diameter <= 6.00) {
                    if (shape == "Round") {
                        return 0.03;
                    }
                    return 0.075;
                }
                if (diameter >= 6.01 && diameter <= 10.00) {
                    if (shape == "Round") {
                        return 0.03;
                    }
                    return 0.090;
                }
                if (diameter >= 10.01 && diameter <= 18.00) {
                    if (shape == "Round") {
                        return 0.04;
                    }
                    return 0.110;
                }
                if (diameter >= 18.01 && diameter <= 30.00) {
                    if (shape == "Round") {
                        return 0.05;
                    }
                    return 0.130;
                }
                if (diameter >= 30.01 && diameter <= 40.00) {
                    if (shape == "Round") {
                        return 0.06;
                    }
                    return 0.160;
                }
            }

            function addTolerancePlus(diameter = 0) {
                var shape = $('#customer-shape').val();
                if (diameter >= 3.01 && diameter <= 6.00) {
                    if (shape == "Round") {
                        return 0.00;
                    }
                    return 0.00;
                }
                if (diameter >= 6.01 && diameter <= 10.00) {
                    if (shape == "Round") {
                        return 0.00;
                    }
                    return 0.00;
                }
                if (diameter >= 10.01 && diameter <= 18.00) {
                    if (shape == "Round") {
                        return 0.00;
                    }
                    return 0.00;
                }
                if (diameter >= 18.01 && diameter <= 30.00) {
                    if (shape == "Round") {
                        return 0.00;
                    }
                    return 0.00;
                }
                if (diameter >= 30.01 && diameter <= 40.00) {
                    if (shape == "Round") {
                        return 0.00;
                    }
                    return 0.00;
                }
            }
        });
    </script>
@endpush
