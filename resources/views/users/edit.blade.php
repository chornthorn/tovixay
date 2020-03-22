@extends('layouts.master')

@section('title','Edit User')

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
            Edit User
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
                    <a href="{{ route('user.index') }}"><span class="btn btn-success">Back</span></a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit user form</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form class="form-horizontal" method="post" action="{{ route('user.update',$user->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="box-body">
                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="hidden" name="id" value="{{ $user->id}}">
                                            <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Enter name" value="{{ $user->name}}">
                                            <small class="text-danger">{{ $errors->first('name') }}</small>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                                        <div class="col-sm-10">
                                            <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" value="{{ $user->email}}">
                                            <small class="text-danger">{{ $errors->first('email') }}</small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label">Role</label>

                                        <div class="col-sm-10">
                                            <select name="role" id="" class="form-control" required>
                                                <option disabled selected> Select Role</option>
                                                @foreach($roles as $role)
                                                    <option
                                                            @foreach ($user->roles as $user_has_role)
                                                                @if ($user_has_role->id == $role->id)
                                                                selected="selected"
                                                                @endif
                                                            @endforeach value="{{ $role->id }}"> {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-info pull-right">Create</button>
                                </div>
                                <!-- /.box-footer -->
                            </form>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
            <div class="box-footer with-border">
                <div class="box-title pull-right">

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
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
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
