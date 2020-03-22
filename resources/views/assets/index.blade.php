@extends('layouts.master')

@section('title','asset')

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
            Manage asset
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
                        <a data-toggle="modal" data-target="#add_asset"><span class="btn btn-success">Add New</span></a>
                    @endcan
                </div>
                <div class="box-title">
                    @can('asset.create')
                        <a id="export"><span class="btn btn-warning">Export</span></a>
                    @endcan
                </div>
                <div class="box-title">
                    @can('asset.create')
                        <a data-toggle="modal" data-target="#import"><span class="btn btn-primary">Import</span></a>
                    @endcan
                </div>
                <div class="box-tools pull-right">
                    <div class="box-tools pull-right mt-4">
                        <form action="{{ route('assets.index') }}">
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
                <!--------------------------
                  | Your Page Content Here |
                  -------------------------->
                <div class="table-responsive">
                    <table class="table table-hover table-responsive text-nowrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Asset Code</th>
                            <th>Asset Description</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Category</th>
                            <th>Cost Center</th>
                            <th>Location</th>
                            <th>Serial No.</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Remark</th>
                            <th>Create Date</th>
                            <th>Update Date</th>
                            <th width="10">View</th>
                            <th width="10">Edit</th>
                            <th width="10">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($assets as $asset)
                            <tr>
                                <td>{{ $asset->id }}</td>
                                <td>{{ $asset->asset_code }}</td>
                                <td>{{ $asset->asset_name }}</td>
                                <td>{{ $asset->brand->brand_name }}</td>
                                <td>{{ $asset->model->model_name }}</td>
                                <td>{{ $asset->category->category_name }}</td>
                                <td>{{ $asset->costcenter->costcenter_name}}</td>
                                <td>{{ $asset->location->location_name }}</td>
                                <td>{{ $asset->asset_serial }}</td>
                                <td>{{ $asset->status->status_name }}</td>
                                <td><img alt="" class="img-rounded" width="50px"
                                         height="50px" src="{{ Storage::disk('public')->url('assets/'.$asset->asset_image) }}" ></td>
                                <td>{{ $asset->asset_remark }}</td>
                                <td>{{ Carbon\Carbon::parse($asset->created_at)->format('M j, Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($asset->updated_at)->format('M j, Y') }}</td>
                                <td>
                                    <a href="{{ route('assets.view.detail',$asset->id) }}" class="btn btn-sm btn-primary"
                                       role="button"><span class="fa fa-eye"></span></a>
                                </td>
                                <td>
                                    <a href="{{ route('assets.edit',$asset->id) }}" class="btn btn-sm btn-success" role="button"><span
                                            class="fa fa-edit"></span></a>
                                </td>
                                @can('asset.delete')
                                    <td class="text-center" width="15">
                                        <button class="btn btn-sm btn-danger" onclick="deleteAsset('{{$asset->id}}')">
                                            <span><i class="fa fa-trash"></i></span></button>
                                        <form id="delete-form-{{$asset->id}}"
                                              action="{{ route('assets.destroy',$asset->id) }}" method="post"
                                              style="display: none">
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
                    {{ $assets->appends(['search'=>$search])->links() }}
                </div>
            </div>
            <!-- /.box-body -->
            <!-- Modal -->
            <div class="modal fade" id="add_asset" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form action="{{ route('assets.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h3 class="modal-title">Add New Asset</h3>
                                <!-- <h3 class="close pull-right" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </h3>-->
                            </div>
                            <div class="modal-body">
                                <div class="col-md-4">
                                    <div class="form-group {{ $errors->has('asset_code') ? ' has-error' : '' }}">
                                        <label for="exampleInputEmail1">Asset Code</label>
                                        <input type="text" class="form-control" placeholder="Enter name"
                                               name="asset_code" value="{{old('asset_code')}}">
                                    </div>
                                    <div class="form-group {{ $errors->has('asset_it_code') ? ' has-error' : '' }}">
                                        <label for="exampleInputEmail1">IT Asset Code</label>
                                        <input type="text" class="form-control" placeholder="Enter name"
                                               name="asset_it_code" value="{{old('asset_it_code')}}">
                                    </div>
                                    <div class="form-group {{ $errors->has('asset_description') ? ' has-error' : '' }}">
                                        <label for="exampleInputEmail1">Asset Description</label>
                                        <input type="text" class="form-control" placeholder="Enter name"
                                               name="asset_description" value="{{old('asset_description')}}">
                                    </div>
                                    <div class="form-group {{ $errors->has('asset_brand') ? ' has-error' : '' }}">
                                        <label>Brand</label>
                                        <select class="form-control" name="asset_brand" required style="width: 250px">
                                            <option value="" disabled selected>select Brand</option>
                                            @foreach($brands as $brand)
                                                <option
                                                    value="{{ $brand->id }}"
                                                    @if (old('asset_brand') == $brand->id) selected="selected" @endif> {{ $brand->brand_name }}</option>
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
                                                    @if (old('asset_model') == $model->id) selected="selected" @endif> {{ $model->model_name }}</option>
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
                                                    @if (old('asset_category') == $category->id) selected="selected" @endif> {{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group {{ $errors->has('asset_serial') ? ' has-error' : '' }}">
                                        <label for="exampleInputEmail1">Serial No</label>
                                        <input type="text" class="form-control" placeholder="Enter name"
                                               name="asset_serial" value="{{old('asset_serial')}}">
                                    </div>
                                    <div class="form-group {{ $errors->has('asset_qty') ? ' has-error' : '' }}">
                                        <label for="exampleInputEmail1">QTY</label>
                                        <input type="text" class="form-control" placeholder="Enter name"
                                               name="asset_qty" value="{{old('asset_qty')}}">
                                    </div>
                                    <div class="form-group {{ $errors->has('asset_unit') ? ' has-error' : '' }}">
                                        <label>Asset Unit</label>
                                        <input type="text" class="form-control" placeholder="Enter name"
                                               name="asset_unit" value="{{old('asset_unit')}}">
                                    </div>
                                    <div class="form-group {{ $errors->has('asset_costcenter') ? ' has-error' : '' }}">
                                        <label>Cost Center</label>
                                        <select class="form-control" name="asset_costcenter" required>
                                            <option value="" disabled selected>select Cost Center</option>
                                            @foreach($costCenters as $costCenter)
                                                <option
                                                    value="{{ $costCenter->id }}"
                                                    @if (old('asset_costcenter') == $costCenter->id) selected="selected" @endif> {{ $costCenter->costcenter_name }}</option>
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
                                                    @if (old('asset_location') == $location->id) selected="selected" @endif> {{ $location->location_name }}</option>
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
                                                    @if (old('asset_status') == $status->id) selected="selected" @endif> {{ $status->status_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group {{ $errors->has('asset_remark') ? ' has-error' : '' }}">
                                        <label for="exampleInputEmail1">Asset Remark</label>
                                        <input type="text" class="form-control" placeholder="Enter name"
                                               name="asset_remark" value="{{old('asset_remark')}}">
                                    </div>
                                    <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                                        <label>Asset Images</label>
                                        <input type="file" class="form-control" name="image" value="{{ old('image') }}">
                                        <span>the image has been allow maximum 10 MB</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="import" class="modal fade" role="dialog">

                <div class="modal-dialog">

                    <!-- Modal content-->

                    <div class="modal-content">

                        <form role="form" method="POST" action="{{ route('assets.import') }}" enctype="multipart/form-data">
                        @csrf

                        <!--=====================================
                            HEADER
                            ======================================-->

                            <div class="modal-header" style="background: #3c8dbc; color: #fff">

                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                <h4 class="modal-title">Add Excel file</h4>

                            </div>

                            <!--=====================================
                            BODY
                            ======================================-->

                            <div class="modal-body">

                                <div class="box-body">

                                    <!--Input name -->

                                    <div class="form-group {{ $errors->has('file_excel') ? ' has-error' : '' }}">

                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-code"></i></span>

                                            <input value="{{old('file_excel')}}" class="form-control input-lg"
                                                   type="file" name="file_excel">
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!--=====================================
                            FOOTER
                            ======================================-->

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close
                                </button>

                                <button type="submit" class="btn btn-primary" name="submit">Import</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
            <!--Model-->
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
                    window.location.href = "{{ route('assets.export') }}";
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    //
                }
            })
        })
        function deleteAsset(id) {
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

        $('.selectAll').click(function () {
            $('.selectbox').prop('checked', $(this).prop('checked'));
            $('.selectAll2').prop('checked', $(this).prop('checked'));
        });
        $('.selectAll2').click(function () {
            $('.selectbox').prop('checked', $(this).prop('checked'));
            $('.selectAll').prop('checked', $(this).prop('checked'));
        });
        $('.selectbox').change(function () {
            var total = $('.selectbox').length;
            var number = $('.selectbox:checked').length;
            if (total == number) {
                $('.selectAll').prop('checked', true);
                $('.selectAll2').prop('checked', true);
            } else {
                $('.selectAll').prop('checked', false);
                $('.selectAll2').prop('checked', false);
            }
        })
    </script>
@endpush
