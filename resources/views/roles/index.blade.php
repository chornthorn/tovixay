@extends('layouts.master')

@section('title','Role')

@push('css')
    <!-- include css style here if css file run only this page -->
    <!-- iCheck -->
    <link href="{{ asset('plugins/iCheck/all.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/dist/sweetalert2.min.css') }}">
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Role & Permission
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Role</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <div class="box-title">
                    @can('role.create')
                    <a href="{{ route('role.create') }}"><span class="btn btn-success">Add New</span></a>
                    @endcan
                        <div class="box-title">
                            @can('role.create')
                                <a id="export"><span class="btn btn-warning">Export</span></a>
                            @endcan
                        </div>
                </div>
                <div class="box-tools pull-right">
                    <div class="box-tools pull-right mt-4">
                        <div class="input-group input-group-md" style="width: 300px">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-flat" type="button">Go</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover table-responsive text-nowrap">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Name</th>
                            <th class="text-center">Description</th>
                            <th class="text-center" width="20">View</th>
                            @can('role.update')
                                <th class="text-center" width="20">Edit</th>
                            @endcan
                            @can('role.delete')
                                <th class="text-center" width="20">Delete</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody id="ajax-append">
                        @foreach ($roles as $key => $role)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->description }}</td>
                                <td class="text-center">
                                    <a href="{{ route('role.users',$role->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                </td>
                                @can('role.update')
                                    <td class="text-center">
                                        <a href="{{ route('role.edit',$role->id) }}" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                    </td>
                                @endcan
                                @can('role.delete')
                                    <td class="text-center" width="15">
                                        <button class="btn btn-sm btn-danger" onclick="deleteRole('{{$role->id}}')"><span><i class="fa fa-trash"></i></span></button>
                                        <form id="delete-form-{{$role->id}}" action="{{ route('role.destroy',$role->id) }}" method="post" style="display: none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer with-border">
                <div class="box-title pull-right">
                    {{ $roles->links() }}
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <!-- include Javascript here if js file run only this page -->
    <script src="{{ asset('plugins/iCheck/icheck.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('plugins/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script>
        $('#export').click('on',function () {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you want to Export?',
                text: "The excel file will be download after completed!",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancel!',
                reverseButtons: true,
                confirmButtonText: 'Yes, Do it!',
            }).then((result) => {
                if (result.value) {
                    window.location.href = "{{ route('role.export') }}";
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    //
                }
            })
        })
        function deleteRole(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    //
                }
            })
        }
    </script>
@endpush
