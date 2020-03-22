@extends('layouts.master')

@section('title','Role Users')

@push('css')
    <!-- include css style here if css file run only this page -->
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css')}}">
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Role : {{ $role->name }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home')}}"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="{{ route('role.index')}}"> Role</a></li>
            <li class="active">Users</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-default color-palette-box">
            <div class="box-body">
                <table id="myTable" class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roleUsers as $roleUser)
                        <tr>
                            <td>{{ $roleUser->id }}</td>
                            <td>{{ $roleUser->name }}</td>
                            <td>{{ $roleUser->email }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <!-- include Javascript here if js file run only this page -->
@endpush
