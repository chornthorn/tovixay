@extends('layouts.master')

@section('title','Report | Active')

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
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Monthly Recap Report</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-wrench"></i></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-12" id="chart1">
                            {!! $chart1 !!}
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./box-body -->

                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
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
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
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
                                <td>{{ $asset->created_at }}</td>
                                <td>{{ $asset->updated_at }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary"
                                       role="button"><span class="fa fa-eye"></span></a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-success" role="button"><span
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
