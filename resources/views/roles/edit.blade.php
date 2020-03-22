@extends('layouts.master')

@section('title','Edit Role')

@push('css')
    <!-- include css style here if css file run only this page -->
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Role
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">role</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-default color-palette-box">
            <div class="box-body">
                <form action="{{ route('role.update',$role->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" value="{{ $role->name }}" name="name" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="name">Description</label>
                                <input type="text" class="form-control" value="{{ $role->description }}" name="description" placeholder="Enter Description">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Role</label>
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permissions as $permission)
                                    @if ($permission->for == 'role')
                                        <div class="checkbox icheck">
                                            <label>
                                                <input  type="checkbox" name="permission[]"
                                                        @foreach ($role->permissions as $role_permit)
                                                        @if ($role_permit->id == $permission->id)
                                                        checked
                                                        @endif
                                                        @endforeach value="{{ $permission->id }}" id="remember" class="form-control">  {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">User</label>
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permissions as $permission)
                                    @if ($permission->for == 'user')
                                        <div class="checkbox icheck">
                                            <label>
                                                <input
                                                    @foreach ($role->permissions as $role_permit)
                                                    @if ($role_permit->id == $permission->id)
                                                    checked
                                                    @endif
                                                    @endforeach
                                                    type="checkbox" name="permission[]" value="{{ $permission->id }}" id="remember" class="form-control">  {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Category</label>
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permissions as $permission)
                                    @if ($permission->for == 'category')
                                        <div class="checkbox icheck">
                                            <label>
                                                <input
                                                    @foreach ($role->permissions as $role_permit)
                                                    @if ($role_permit->id == $permission->id)
                                                    checked
                                                    @endif
                                                    @endforeach
                                                    type="checkbox" name="permission[]" value="{{ $permission->id }}" id="remember" class="form-control">  {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Brand</label>
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permissions as $permission)
                                    @if ($permission->for == 'brand')
                                        <div class="checkbox icheck">
                                            <label>
                                                <input type="checkbox" name="permission[]"
                                                       @foreach ($role->permissions as $role_permit)
                                                       @if ($role_permit->id == $permission->id)
                                                       checked
                                                       @endif
                                                       @endforeach
                                                       value="{{ $permission->id }}" id="remember" class="form-control">  {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Model</label>
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permissions as $permission)
                                    @if ($permission->for == 'model')
                                        <div class="checkbox icheck">
                                            <label>
                                                <input type="checkbox" name="permission[]"
                                                       @foreach ($role->permissions as $role_permit)
                                                       @if ($role_permit->id == $permission->id)
                                                       checked
                                                       @endif
                                                       @endforeach
                                                       value="{{ $permission->id }}" id="remember" class="form-control">  {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Status</label>
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permissions as $permission)
                                    @if ($permission->for == 'status')
                                        <div class="checkbox icheck">
                                            <label>
                                                <input type="checkbox" name="permission[]"
                                                       @foreach ($role->permissions as $role_permit)
                                                       @if ($role_permit->id == $permission->id)
                                                       checked
                                                       @endif
                                                       @endforeach
                                                       value="{{ $permission->id }}" id="remember" class="form-control">  {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Location</label>
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permissions as $permission)
                                    @if ($permission->for == 'location')
                                        <div class="checkbox icheck">
                                            <label>
                                                <input type="checkbox" name="permission[]"
                                                       @foreach ($role->permissions as $role_permit)
                                                       @if ($role_permit->id == $permission->id)
                                                       checked
                                                       @endif
                                                       @endforeach
                                                       value="{{ $permission->id }}" id="remember" class="form-control">  {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Cost Center</label>
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permissions as $permission)
                                    @if ($permission->for == 'cost')
                                        <div class="checkbox icheck">
                                            <label>
                                                <input type="checkbox" name="permission[]"
                                                       @foreach ($role->permissions as $role_permit)
                                                       @if ($role_permit->id == $permission->id)
                                                       checked
                                                       @endif
                                                       @endforeach
                                                       value="{{ $permission->id }}" id="remember" class="form-control">  {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Report</label>
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permissions as $permission)
                                    @if ($permission->for == 'report')
                                        <div class="checkbox icheck">
                                            <label>
                                                <input type="checkbox" name="permission[]"
                                                       @foreach ($role->permissions as $role_permit)
                                                       @if ($role_permit->id == $permission->id)
                                                       checked
                                                       @endif
                                                       @endforeach
                                                       value="{{ $permission->id }}" id="remember" class="form-control">  {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Asset</label>
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permissions as $permission)
                                    @if ($permission->for == 'asset')
                                        <div class="checkbox icheck">
                                            <label>
                                                <input type="checkbox" name="permission[]"
                                                       @foreach ($role->permissions as $role_permit)
                                                       @if ($role_permit->id == $permission->id)
                                                       checked
                                                       @endif
                                                       @endforeach
                                                       value="{{ $permission->id }}" id="remember" class="form-control">  {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Computer</label>
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permissions as $permission)
                                    @if ($permission->for == 'computer')
                                        <div class="checkbox icheck">
                                            <label>
                                                <input type="checkbox" name="permission[]"
                                                       @foreach ($role->permissions as $role_permit)
                                                       @if ($role_permit->id == $permission->id)
                                                       checked
                                                       @endif
                                                       @endforeach
                                                       value="{{ $permission->id }}" id="remember" class="form-control">  {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Print</label>
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permissions as $permission)
                                    @if ($permission->for == 'print')
                                        <div class="checkbox icheck">
                                            <label>
                                                <input type="checkbox" name="permission[]"
                                                       @foreach ($role->permissions as $role_permit)
                                                       @if ($role_permit->id == $permission->id)
                                                       checked
                                                       @endif
                                                       @endforeach
                                                       value="{{ $permission->id }}" id="remember" class="form-control">  {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Add" class="btn btn-success pull-right">
                </form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                footer
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <!-- include Javascript here if js file run only this page -->
    <!-- iCheck -->
    <script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
    </script>
@endpush
