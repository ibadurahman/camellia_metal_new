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
                            <form action="{{ route('operator.production.updateWo', $workorder) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="alert alert-primary text-center" role="alert">
                                    Bahan Baku
                                </div>
                                <div class="form-group">
                                    <label for="">Quantity (Kg / Coil) <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-5">
                                            <input id="supplier-qty-kg" name="bb_qty_pcs" type="text"
                                                class="form-control @error('bb_qty_pcs') is-invalid @enderror"
                                                placeholder="Qty (Kg)"
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
                                                placeholder="Qty (Coil)"
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
                                <div class="alert alert-primary text-center" role="alert">
                                    Finish good
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
                                    <div class="row">
                                        <input value="Update" type="submit" class="btn btn-primary">
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
