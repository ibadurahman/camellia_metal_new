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
                            <h3 class="card-title">User Account List</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-12 d-flex justify-content-between">
                                <a href="{{ route('admin.user.create') }}" class="btn btn-primary">Add Account</a>
                                <a href="{{ route('admin.user.inactivated') }}" class="">See Inactivated Account</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Employee ID</th>
                                        <th>Role</th>
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
    <form action="" method="post" id="inactiveForm" hidden>
        @csrf
        @method('DELETE')
    </form>
    <form action="" method="POST" id="resetPasswordForm">
        @csrf
        <input type="text" name="user" value="{{ Auth::user() }}" style="display:none">
    </form>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.user.data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'employeeId'
                    },
                    {
                        data: 'role'
                    },
                    {
                        data: 'action'
                    }
                ],
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endpush
