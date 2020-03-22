@extends('layouts.master')

@section('title','Edit')

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
            Edit Asset
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
                    <a href="{{ route('assets.index') }}"><span class="btn btn-success">Back</span></a>
                </div>
            </div>
            <div class="box-body">
                <!--------------------------
                  | Your Page Content Here |
                  -------------------------->
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <form action="{{ route('assets.update',$asset->id) }}" enctype="multipart/form-data" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h3 class="modal-title text-center">Edit Asset</h3>
                                <!-- <h3 class="close pull-right" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </h3>-->
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('asset_code') ? ' has-error' : '' }}">
                                    <label for="exampleInputEmail1">Asset Code</label>
                                    <input type="text" class="form-control" placeholder="Enter name"
                                           name="asset_code" value="{{ $asset->asset_code }}">
                                </div>
                                <div class="form-group {{ $errors->has('asset_it_code') ? ' has-error' : '' }}">
                                    <label for="exampleInputEmail1">IT Asset Code</label>
                                    <input type="text" class="form-control" placeholder="Enter name"
                                           name="asset_it_code" value="{{ $asset->asset_it_code }}">
                                </div>
                                <div class="form-group {{ $errors->has('asset_description') ? ' has-error' : '' }}">
                                    <label for="exampleInputEmail1">Asset Description</label>
                                    <input type="text" class="form-control" placeholder="Enter name"
                                           name="asset_description" value="{{ $asset->asset_name }}">
                                </div>
                                <div class="form-group {{ $errors->has('asset_brand') ? ' has-error' : '' }}">
                                    <label>Brand</label>
                                    <select class="form-control" name="asset_brand" required style="width: 250px">
                                        <option value="" disabled selected>select Brand</option>
                                        @foreach($brands as $brand)
                                            <option
                                                value="{{ $brand->id }}"
                                                @if ($asset->brand_id == $brand->id) selected="selected" @endif> {{ $brand->brand_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group {{ $errors->has('asset_model') ? ' has-error' : '' }}">
                                    <label>Model</label>
                                    <select class="form-control" name="asset_model">
                                        <option value="2" disabled selected>select model</option>
                                        @foreach($assetModels as $model)
                                            <option
                                                value="{{ $model->id }}"
                                                @if ($asset->model_id == $model->id) selected="selected" @endif> {{ $model->model_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('asset_category') ? ' has-error' : '' }}">
                                    <label>Category</label>
                                    <select class="form-control" name="asset_category" required>
                                        <option value="" disabled selected>select Category</option>
                                        @foreach($categories as $category)
                                            <option
                                                value="{{ $category->id }}"
                                                @if ($asset->category_id == $category->id) selected="selected" @endif> {{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group {{ $errors->has('asset_serial') ? ' has-error' : '' }}">
                                    <label for="exampleInputEmail1">Serial No</label>
                                    <input type="text" class="form-control" placeholder="Enter name"
                                           name="asset_serial" value="{{ $asset->asset_serial }}">
                                </div>
                                <div class="form-group {{ $errors->has('asset_qty') ? ' has-error' : '' }}">
                                    <label for="exampleInputEmail1">QTY</label>
                                    <input type="text" class="form-control" placeholder="Enter name"
                                           name="asset_qty" value="{{ $asset->asset_qty }}">
                                </div>
                                <div class="form-group {{ $errors->has('asset_unit') ? ' has-error' : '' }}">
                                    <label>Asset Unit</label>
                                    <input type="text" class="form-control" placeholder="Enter name"
                                           name="asset_unit" value="{{ $asset->asset_unit }}">
                                </div>
                                <div class="form-group {{ $errors->has('asset_costcenter') ? ' has-error' : '' }}">
                                    <label>Cost Center</label>
                                    <select class="form-control" name="asset_costcenter" required>
                                        <option value="" disabled selected>select Cost Center</option>
                                        @foreach($costCenters as $costCenter)
                                            <option
                                                value="{{ $costCenter->id }}"
                                                @if ($asset->costcenter_id == $costCenter->id) selected="selected" @endif> {{ $costCenter->costcenter_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('asset_location') ? ' has-error' : '' }}">
                                    <label>Location</label>
                                    <select class="form-control" name="asset_location" required>
                                        <option value="" disabled selected>Select Location</option>
                                        @foreach($locations as $location)
                                            <option
                                                value="{{ $location->id }}"
                                                @if ($asset->location_id == $location->id) selected="selected" @endif> {{ $location->location_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group {{ $errors->has('asset_status') ? ' has-error' : '' }}">
                                    <label>Status</label>
                                    <select class="form-control js-example-basic-single" name="asset_status"
                                            required>
                                        <option value="" disabled selected>Select Status</option>
                                        @foreach($statuses as $status)
                                            <option
                                                value="{{ $status->id }}"
                                                @if ($asset->status_id == $status->id) selected="selected" @endif> {{ $status->status_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group {{ $errors->has('asset_remark') ? ' has-error' : '' }}">
                                    <label for="exampleInputEmail1">Asset Remark</label>
                                    <input type="text" class="form-control" placeholder="Enter name"
                                           name="asset_remark" value="{{ $asset->asset_remark }}">
                                </div>
                                <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                                    <label>Asset Images</label>
                                    <input type="file" class="form-control" name="image" >
                                    <span>the image has been allow maximum 10 MB</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <!-- include Javascript here if js file run only this page -->
    <script src="{{ asset('plugins/iCheck/icheck.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('plugins/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script>
        function deleteCategory(id) {
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
