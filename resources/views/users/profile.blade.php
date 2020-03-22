@extends('layouts.master')

@section('title','Update profile')

@push('css')
    <!-- include css style here if css file run only this page -->
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add Profile User
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">
            @foreach($user_profile as $profile)
                <!-- Profile Image -->
                <div class="box box-primary">

                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">

                        <h3 class="profile-username text-center">{{ $profile->name }}</h3>

                        <p class="text-muted text-center">{{ $profile->role_name }}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Register Date:</b> <a class="pull-right">{{ Carbon\Carbon::parse($profile->created_at)->format('M j, Y') }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Update Date:</b> <a class="pull-right">{{ Carbon\Carbon::parse($profile->updated_at)->format('M j, Y') }}</a>
                            </li>
                        </ul>

                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                    </div>
                    <!-- /.box-body -->

                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="false">Settings</a></li>
                        <li class=""><a href="#change_password" data-toggle="tab" aria-expanded="true">Change password</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal" method="post" action="{{ route('user.change.about') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input name="name" value="{{ $profile->name }}" type="text" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input readonly value="{{ $profile->email }}" type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Role</label>

                                    <div class="col-sm-10">
                                        <input readonly value="{{ $profile->role_name }}" type="text" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputExperience" class="col-sm-2 control-label">About</label>

                                    <div class="col-sm-10">
                                        <textarea name="about" class="form-control" id="inputExperience" placeholder="Write about you here!"> {{ $profile->about }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-success">Update Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="change_password">
                            <form class="form-horizontal" action="{{ route('user.update.password') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Current Password</label>

                                    <div class="col-sm-10">
                                        <input name="current_password"  type="password" class="form-control" id="inputName" placeholder="Current Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">New Password</label>

                                    <div class="col-sm-10">
                                        <input name="password" type="password" class="form-control" id="inputEmail" placeholder="New Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Confirm Password</label>

                                    <div class="col-sm-10">
                                        <input name="password_confirmation" type="password" class="form-control" id="inputName" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-success">Update Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
                @endforeach
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
@endsection

@push('js')
    <!-- include Javascript here if js file run only this page -->
@endpush
