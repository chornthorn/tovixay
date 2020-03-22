@extends('layouts.master')

@section('title','User')

@push('css')
    <!-- include css style here if css file run only this page -->
    <!-- iCheck -->
    <link href="{{ asset('plugins/iCheck/all.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/dist/sweetalert2.min.css') }}">
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User & Role
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
                    @can('user.create')
                        <a href="{{ route('user.create') }}"><span class="btn btn-success">Add New</span></a>
                    @endcan
                </div>
                <div class="box-tools pull-right">
                    <div class="box-tools pull-right mt-4">
                        <form action="{{ route('user.index') }}">
                            <div class="input-group input-group-md" style="width: 300px">
                                <input type="text" name="search" class="form-control" placeholder="Search..."
                                       value="{{ isset($search) ? $search : '' }}">
                                <span class="input-group-btn">
                                <button class="btn btn-info btn-flat" type="submit">Go</button>
                            </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover table-responsive text-nowrap">
                        <thead>
                        <tr>
                            <th class="text-center" width="20">ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            @can('user.update')
                                <th class="text-center" width="20">Edit</th>
                            @endcan
                            @can('user.delete')
                                <th class="text-center" width="20">Delete</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @if($users->count() < 1)
                            <td>No User</td>
                        @else
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    @can('user.update')
                                        <td class="text-center">
                                            <a href="{{ route('user.edit',$user->id) }}" class="btn btn-sm btn-success"><i
                                                    class="fa fa-edit"></i></a>
                                        </td>
                                    @endcan
                                    @can('user.delete')
                                        <td class="text-center" width="15">
                                            <button class="btn btn-sm btn-danger" onclick="deleteRole('{{$user->id}}')">
                                                <span><i class="fa fa-trash"></i></span></button>
                                            <form id="delete-form-{{$user->id}}"
                                                  action="{{ route('user.destroy',$user->id) }}" method="post"
                                                  style="display: none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer with-border">
                <div class="box-title pull-right">
                    {{ $users->links() }}
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
                    document.getElementById('delete-form-' + id).submit();
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
