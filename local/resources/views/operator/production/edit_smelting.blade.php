@extends('templates.default')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-tittle">Leburan</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('operator.production.updateSmelting', $workorder) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <table id="dataTable" class="table table-bordered table-hover mb-3">
                                    <thead>
                                        <tr>
                                            <th>WO Number</th>
                                            <th>No. Coil</th>
                                            <th>Weight (Kg)</th>
                                            <th>No. Leburan</th>
                                            <th>Area</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($smeltings as $smelt)
                                            <tr>
                                                <td><input type="hidden" name="wo_num[]"
                                                        value="{{ $smelt->workorder->wo_number }}" />
                                                    {{ $smelt->workorder->wo_number }}</td>
                                                <td><input type="hidden" name="coil_num[]"
                                                        value="{{ $smelt->coil_num }}" />
                                                    {{ $smelt->coil_num }}</td>
                                                <td><input type="text" name="weight[]" class="form-control"
                                                        value="{{ $smelt->weight }}" /></td>
                                                <td><input type="text" name="smelting_num[]" class="form-control"
                                                        value="{{ $smelt->smelting_num }}" /></td>
                                                <td><input type="text" name="area[]" class="form-control"
                                                        value="{{ $smelt->area }}" /></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-3">
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
