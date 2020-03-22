@extends('layouts.master')

@section('title','Computer Detail')

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
            Computer Detail
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">computer</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <div class="box-title">
                    @can('computer.view')
                        <a href="{{ route('computers.index') }}"><span class="btn btn-success">Back</span></a>
                    @endcan
                </div>
            </div>
            <div class="box-body">
                <!--------------------------
                  | Your Page Content Here |
                  -------------------------->
                <div class="row">
                    <div class="container">
                        @foreach( $computers as $computer)
                        <div class="row bg-faded">
                            <div class="col-4 mx-auto text-center">

                                <img src="{{ Storage::disk('public')->url('assets/'.$computer->asset_image) }}" width="200" height="200"> <!-- center this image within the column -->
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <thead>
                                    <tr>
                                        <th width="300">Asset Data</th>
                                        <th>Asset Detail</th>
                                        <th>Computer Data</th>
                                        <th>Computer Detail</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>Asset Code</th>
                                        <td>{{ $computer->asset_code }}</td>
                                        <th>Monitor</th>
                                        <td>{{ $computer->monitor_item }}</td>
                                    </tr>
                                    <tr>
                                        <th>Asset IT Code</th>
                                        <td>{{ $computer->asset_it_code }}</td>
                                        <th>Mainboard</th>
                                        <td>{{ $computer->mainboard_item }}</td>
                                    </tr>
                                    <tr>
                                        <th>Asset description</th>
                                        <td>{{ $computer->asset_name }}</td>
                                        <th>CPU</th>
                                        <td>{{ $computer->cpu_item }}</td>
                                    </tr>
                                    <tr>
                                        <th>Asset Serial</th>
                                        <td>{{ $computer->asset_serial }}</td>
                                        <th>Hard Disk</th>
                                        <td>{{ $computer->harddisk_item }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $computer->statusName }}</td>
                                        <th>RAM</th>
                                        <td>{{ $computer->ram_item }}</td>
                                    </tr>
                                    <tr>
                                        <th>Asset Unit</th>
                                        <td>{{ $computer->asset_unit }}</td>
                                        <th>Power Supply</th>
                                        <td>{{ $computer->powersupply_item }}</td>
                                    </tr>
                                    <tr>
                                        <th>Asset Remark</th>
                                        <td>{{ $computer->asset_remark }}</td>
                                        <th>Keyboard</th>
                                        <td>{{ $computer->keyboard_item }}</td>
                                    </tr>
                                    <tr>
                                        <th>Brand</th>
                                        <td>{{ $computer->brandName }}</td>
                                        <th>Mouse</th>
                                        <td>{{ $computer->mouse_item }}</td>
                                    </tr>
                                    <tr>
                                        <th>Model</th>
                                        <td>{{ $computer->modelName }}</td>
                                        <th>CD ROM</th>
                                        <td>{{ $computer->cdrom_item }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td>{{ $computer->categoryName }}</td>
                                        <th>Status</th>
                                        <td>{{ $computer->statusName }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cost Center</th>
                                        <td>{{ $computer->costcenterName }}</td>
                                        <th>Created At</th>
                                        <td>{{ Carbon\Carbon::parse($computer->created_at)->format('M j, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Location</th>
                                        <td>{{ $computer->locationName }}</td>
                                        <th>Updated At</th>
                                        <td>{{ Carbon\Carbon::parse($computer->updated_at)->format('M j, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created By</th>
                                        <td>{{ $computer->userName }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ Carbon\Carbon::parse($computer->created_at)->format('M j, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ Carbon\Carbon::parse($computer->updated_at)->format('M j, Y') }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- /.box-body -->

        </div>
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <!-- include Javascript here if js file run only this page -->

@endpush
