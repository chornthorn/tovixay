@extends('layouts.master')

@section('title','asset | View')

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
            View asset
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">asset</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <div class="box-title">
                    @can('asset.create')
                        <a href="{{ route('assets.index') }}"><span class="btn btn-success">Back</span></a>
                    @endcan
                </div>
            </div>
            <div class="box-body">
                <!--------------------------
                  | Your Page Content Here |
                  -------------------------->
                <div class="container">
                    @foreach( $assets as $asset)

                    <div class="row bg-faded">
                        <div class="col-4 mx-auto text-center">

                            <img src="{{ Storage::disk('public')->url('assets/'.$asset->asset_image) }}" width="200" height="200"> <!-- center this image within the column -->
                        </div>
                        <br>
                        <table class="table">
                            <thead>
                            <tr>
                                <th width="300">Data Header</th>
                                <th>Data Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Asset Code</th>
                                <td>{{ $asset->asset_code }}</td>
                            </tr>
                            <tr>
                                <th>Asset IT Code</th>
                                <td>{{ $asset->asset_it_code }}</td>
                            </tr>
                            <tr>
                                <th>Asset description</th>
                                <td>{{ $asset->asset_name }}</td>
                            </tr>
                            <tr>
                                <th>Asset Serial</th>
                                <td>{{ $asset->asset_serial }}</td>
                            </tr>
                            <tr>
                                <th>QTY</th>
                                <td>{{ $asset->asset_qty }}</td>
                            </tr>
                            <tr>
                                <th>Asset Unit</th>
                                <td>{{ $asset->asset_unit }}</td>
                            </tr>
                            <tr>
                                <th>Asset Remark</th>

                                <td>{{ $asset->asset_remark }}</td>
                            </tr>
                            <tr>
                                <th>Brand</th>
                                <td>{{ $asset->brandName }}</td>
                            </tr>
                            <tr>
                                <th>Model</th>
                                <td>{{ $asset->modelName }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $asset->categoryName }}</td>
                            </tr>
                            <tr>
                                <th>Cost Center</th>
                                <td>{{ $asset->costcenterName }}</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <td>{{ $asset->locationName }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $asset->statusName }}</td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>{{ $asset->user_name }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ Carbon\Carbon::parse($asset->created_at)->format('M j, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ Carbon\Carbon::parse($asset->updated_at)->format('M j, Y') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <!-- include Javascript here if js file run only this page -->

@endpush
