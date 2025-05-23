@extends('templates.default')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add New Workorder</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.workorder.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">WO Number <span class="text-danger">*</span></label>
                                    <input name="wo_number" type="text"
                                        class="form-control @error('wo_number') is-invalid @enderror"
                                        placeholder="WO Number" value="{{ old('wo_number', $wo_num) }}">
                                    @error('wo_number')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="alert alert-primary text-center" role="alert">
                                    Bahan Baku
                                </div>
                                <div class="form-group">
                                    <label for="">Supplier <span class="text-danger">*</span></label>
                                    <select id="supplier-cmbbx" name="bb_supplier"
                                        class="form-control select2 @error('bb_supplier') is-invalid @enderror">
                                        <option disabled selected value> -- SELECT SUPPLIER -- </option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->name }}"
                                                @if (old('bb_supplier') === $supplier->name) selected @endif>{{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bb_supplier')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Grade <span class="text-danger">*</span></label>
                                    <input id="supplier-grade" name="bb_grade" type="text"
                                        class="form-control @error('bb_grade') is-invalid @enderror" placeholder="Grade"
                                        value="{{ old('bb_grade') }}">
                                    @error('bb_grade')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Diameter (mm) <span class="text-danger">*</span></label>
                                    <input id="supplier-diameter" name="bb_diameter" type="text"
                                        class="form-control @error('bb_diameter') is-invalid @enderror"
                                        placeholder="Diameter" value="{{ old('bb_diameter') }}">
                                    @error('bb_diameter')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Quantity (Kg / Coil) <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-5">
                                            <input id="supplier-qty-kg" name="bb_qty_pcs" type="text"
                                                class="form-control @error('bb_qty_pcs') is-invalid @enderror"
                                                placeholder="Qty (Kg)" value="{{ old('bb_qty_pcs') }}">
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
                                                placeholder="Qty (Coil)" value="{{ old('bb_qty_coil') }}">
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
                                    <label for="">Quantity (Bundle) <span class="text-danger">*</span></label>
                                    <input id="supplier-qty-bundle" name="bb_qty_bundle" type="text"
                                        class="form-control @error('bb_qty_bundle') is-invalid @enderror"
                                        placeholder="Quantity (Bundle)" value="{{ old('bb_qty_bundle') }}">
                                    @error('bb_qty_bundle')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="alert alert-primary text-center" role="alert">
                                    Finish good
                                </div>
                                <div class="form-group">
                                    <label for="">Customer <span class="text-danger">*</span></label>
                                    <select id="customer-cmbbx" name="fg_customer"
                                        class="form-control select2 @error('fg_customer') is-invalid @enderror"
                                        value="{{ old('fg_customer') }}">
                                        <option disabled selected value> -- SELECT CUSTOMER -- </option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->name }}"
                                                @if (old('fg_customer') === $customer->name) selected @endif>{{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('fg_customer')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Standar Kelurusan (mm) <span class="text-danger">*</span></label>
                                    <input id="customer-straight-standard" name="straightness_standard" type="text"
                                        class="form-control @error('straightness_standard') is-invalid @enderror"
                                        placeholder="Standar Kelurusan (mm)" value="{{ old('straightness_standard') }}">
                                    @error('straightness_standard')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Size (diameter(mm) x length(mm)) <span
                                            class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-5">
                                            <input id="customer-size-1" name="fg_size_1" type="text"
                                                class="form-control @error('fg_size_1') is-invalid @enderror"
                                                placeholder="Diameter (mm)" value="{{ old('fg_size_1') }}">
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
                                                placeholder="Length (mm)" value="{{ old('fg_size_2') }}">
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
                                            <label for="">Diameter Tolerance (+mm) <span class="text-danger">*</span></label>
                                            <input id="customer-tolerance-plus" name="tolerance_plus" type="text"
                                                class="form-control @error('tolerance_plus') is-invalid @enderror"
                                                placeholder="Diameter Tolerance (+mm)" value="{{ old('tolerance_plus') }}">
                                            @error('tolerance_plus')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="">Diameter Tolerance (-mm) <span class="text-danger">*</span></label>
                                            <input id="customer-tolerance" name="tolerance_minus" type="text"
                                                class="form-control @error('tolerance_minus') is-invalid @enderror"
                                                placeholder="Diameter Tolerance (-mm)" value="{{ old('tolerance_minus') }}">
                                            @error('tolerance_minus')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="">Length Tolerance (+mm) <span class="text-danger">*</span></label>
                                            <input id="length-tolerance-plus" name="length_tolerance_plus" type="text"
                                                class="form-control @error('length_tolerance_plus') is-invalid @enderror"
                                                placeholder="Length Tolerance (+mm)" value="{{ old('length_tolerance_plus') }}">
                                            @error('length_tolerance_plus')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="">Length Tolerance (-mm) <span class="text-danger">*</span></label>
                                            <input id="length-tolerance-minus" name="length_tolerance_minus" type="text"
                                                class="form-control @error('length_tolerance_minus') is-invalid @enderror"
                                                placeholder="Length Tolerance (-mm)" value="{{ old('length_tolerance_minus') }}">
                                            @error('length_tolerance_minus')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Reduction Rate (%) <span class="text-danger">*</span></label>
                                    <input id="customer-reduc-rate" name="fg_reduction_rate" type="text"
                                        class="form-control @error('fg_reduction_rate') is-invalid @enderror"
                                        placeholder="Reduction Rate (%)" value="{{ old('fg_reduction_rate') }}">
                                    @error('fg_reduction_rate')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Shape <span class="text-danger">*</span></label>
                                    <select name="fg_shape" id="customer-shape"
                                        class="form-control @error('fg_shape') is-invalid @enderror">
                                        <option disabled selected value> -- select shape -- </option>
                                        <option id="shape-round" value="Round"
                                            @if (old('fg_shape') === 'Round') selected @endif>Round</option>
                                        <option id="shape-square" value="Square"
                                            @if (old('fg_shape') === 'Square') selected @endif>Square</option>
                                        <option id="shape-hexagon" value="Hexagon"
                                            @if (old('fg_shape') === 'Hexagon') selected @endif>Hexagon</option>
                                    </select>
                                    @error('fg_shape')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Quantity per bundle (Kg) <span
                                            class="text-danger">*</span></label>
                                    <input id="kg-per-bundle" name="fg_qty_kg" type="text"
                                        class="form-control @error('fg_qty_kg') is-invalid @enderror"
                                        placeholder="Qty per bundle (Kg)" value="{{ old('fg_qty_kg') }}">
                                    @error('fg_qty_kg')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Quantity per Bundle (Pcs) <span
                                            class="text-danger">*</span></label>
                                    <input id="pcs-per-bundle" name="fg_qty_pcs" type="text"
                                        class="form-control @error('fg_qty_pcs') is-invalid @enderror"
                                        placeholder="Qty per bundle (Pcs)" value="{{ old('fg_qty_pcs') }}">
                                    @error('fg_qty_pcs')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Chamfer</label>
                                    <br>
                                    <input type="radio" id="Chamfer_Yes" name="chamfer" value="Yes"> Yes
                                    <br>
                                    <input type="radio" id="Chamfer_No" name="chamfer" value="No"> No
                                    <br>
                                    <input type="radio" id="Chamfer_Satu_Sisi" name="chamfer" value="Satu Sisi"> Satu
                                    Sisi
                                    @error('chamfer')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Color <span class="text-danger">*</span></label>
                                    <select id="color-cmbbx" name="color"
                                        class="form-control select2 @error('color') is-invalid @enderror"
                                        value="{{ old('color') }}">
                                        <option disabled selected value> -- SELECT COLOR -- </option>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('color')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Machine <span class="text-danger">*</span></label>
                                    <select name="machine_id" class="form-control" id="">
                                        @foreach ($machines as $machine)
                                            <option value="{{ $machine->id }}">{{ $machine->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('machine_id')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror"
                                        placeholder="Catatan untuk produksi" cols="30" rows="10">{{ old('remarks') }}</textarea>
                                    @error('remarks')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Label Remarks</label>
                                    <textarea name="label_remarks" class="form-control @error('label_remarks') is-invalid @enderror"
                                        placeholder="Keterangan pada label produksi(kosongkan jika tidak dibutuhkan)" cols="30" rows="1">{{ old('label_remarks') }}</textarea>
                                    @error('label_remarks')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <span class="text-muted help-block">Estimated Planned Output: <span
                                            id="estimated-qty-planned"></span> Pcs</span>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <input value="Add" type="submit" class="btn btn-primary">
                                    </div>
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

            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                },
                format: 'YYYY-MM-DD HH:mm:ss',
            });
            $('#customer-size-1').on('keyup', function() {
                recalculate();
            });
            $('#supplier-diameter').on('keyup', function() {
                localStorage.removeItem('customer-tolerance-plus');
                localStorage.removeItem('customer-tolerance');
                recalculate();
            });
            $('#kg-per-bundle').on('keyup', function() {
                recalculate();
            });
            $('#supplier-cmbbx').on('change', function() {
                localStorage.removeItem('customer-tolerance-plus');
                localStorage.removeItem('customer-tolerance');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.supplier.getSupplierData') }}",
                    data: {
                        name: $('#supplier-cmbbx').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#supplier-grade').val(response[0].grade);
                        $('#supplier-diameter').val(response[0].diameter);
                        $('#supplier-qty-kg').val(response[0].qty_kg);
                        $('#supplier-qty-coil').val(response[0].qty_coil);
                        $('#supplier-qty-bundle').val(response[0].qty_bundle);
                        recalculate();
                    }
                });
            });
            $('#customer-cmbbx').on('change', function() {
                localStorage.removeItem('customer-tolerance-plus');
                localStorage.removeItem('customer-tolerance');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.customer.getCustomerData') }}",
                    data: {
                        name: $('#customer-cmbbx').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#customer-straight-standard').val(response[0].straightness_standard);
                        $('#customer-size-1').val(response[0].size_1);
                        $('#customer-size-2').val(response[0].size_2);

                        if (response[0].shape == "Round") {
                            $('#shape-round').attr('selected', true)
                            $('#shape-square').attr('selected', false)
                            $('#shape-hexagon').attr('selected', false)
                        }
                        if (response[0].shape == "Square") {
                            $('#shape-round').attr('selected', false)
                            $('#shape-square').attr('selected', true)
                            $('#shape-hexagon').attr('selected', false)
                        }
                        if (response[0].shape == "Hexagon") {
                            $('#shape-round').attr('selected', false)
                            $('#shape-square').attr('selected', false)
                            $('#shape-hexagon').attr('selected', true)
                        }
                        recalculate();
                    }
                });
            });
            $('#customer-shape').on('change', function() {
                recalculate();
            })
            $('#color-cmbbx').on('change', function() {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.color.getColorData') }}",
                    data: {
                        name: $('#customer-cmbbx').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {}
                });
            });

            $('#customer-tolerance-plus').on('keyup', function() {
                //add lock value for the input from localStorage
                localStorage.setItem('customer-tolerance-plus', $('#customer-tolerance-plus').val());
            });

            $('#customer-tolerance').on('keyup', function() {
                //add lock value for the input from localStorage
                localStorage.setItem('customer-tolerance', $('#customer-tolerance').val());
            });

            function recalculate() {
                if (localStorage.getItem('customer-tolerance-plus') != null) {
                    $('#customer-tolerance-plus').val(localStorage.getItem('customer-tolerance-plus'));
                } else {
                    $('#customer-tolerance-plus').val("+" + addTolerancePlus($('#customer-size-1').val()));
                }
                if (localStorage.getItem('customer-tolerance') != null) {
                    $('#customer-tolerance').val(localStorage.getItem('customer-tolerance'));
                } else {
                    $('#customer-tolerance').val("-" + addTolerance($('#customer-size-1').val()));
                }
                $('#customer-reduc-rate').val(calculateReducRate($('#supplier-diameter').val(), $(
                    '#customer-size-1').val()));
                $('#pcs-per-bundle').val(calculatePcsPerBundle($('#kg-per-bundle').val(), $('#customer-shape')
                    .val()));
                $('#estimated-qty-planned').html(calculateQtyPlanned($('#supplier-qty-kg').val(), $(
                    '#customer-shape').val()));
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
                        result = Math.round(weightVal / diameter / diameter / panjang / response *
                            1000);
                        $('#pcs-per-bundle').val(result.toFixed(0));
                    }
                })
            }

            function calculateQtyPlanned(weightVal = 0, shape = null) {
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
                        result = Math.round(weightVal / diameter / diameter / panjang / response *
                            1000);
                        $('#estimated-qty-planned').html(result.toFixed(0));
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
        $(document).ready(function() {
            //reset to null
            localStorage.removeItem('customer-tolerance-plus');
            localStorage.removeItem('customer-tolerance');
        })
    </script>
@endpush
