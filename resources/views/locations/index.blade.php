@extends('layouts.master')

@section('title','location')

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
            Manage location
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">location</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <div class="box-title">
                    @can('location.create')
                        <a data-toggle="modal" data-target="#add_location"><span class="btn btn-success">Add New</span></a>
                    @endcan
                </div>
                <div class="box-title">
                    @can('location.create')
                        <a id="export"><span class="btn btn-warning">Export</span></a>
                    @endcan
                </div>
                <div class="box-title">
                    @can('location.create')
                        <a data-toggle="modal" data-target="#import"><span class="btn btn-primary">Import</span></a>
                    @endcan
                </div>
                <div class="box-tools pull-right">
                    <div class="box-tools pull-right mt-4">
                        <form action="{{ route('locations.index') }}">
                            <div class="input-group input-group-md" style="width: 300px">
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ isset($search) ? $search : '' }}">
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
                        <th><input type="checkbox" class="selectAll"></th>
                        <th class="text-center" width="20">ID</th>
                        <th>location Code</th>
                        <th>location Name</th>
                        <th>Modifies by</th>
                        <th>Status</th>
                        <th>Add On</th>
                        <th>Update On</th>
                        @can('location.update')
                            <th class="text-center" width="20">Edit</th>
                        @endcan
                        @can('location.delete')
                            <th class="text-center" width="20">Delete</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($locations as $location)
                        <tr>
                            <th><input name="ids[]" value="{{ $location->id }}" type="checkbox" class="selectbox"></th>
                            <td>{{ $location->id }}</td>
                            <td>{{ $location->location_code }}</td>
                            <td>{{ $location->location_name }}</td>
                            <td>{{ $location->user->name }}</td>
                            @if($location->location_status =='1')
                                <td class="text-center">Active</td>
                            @else
                                <td class="text-center">Deactive</td>
                            @endif
                            <td>{{ $location->created_at }}</td>
                            <td>{{ $location->updated_at }}</td>
                            @can('location.update')
                                <td class="text-center">
                                    <a href="{{ route('locations.edit',$location->id) }}" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                </td>
                            @endcan
                            @can('location.delete')
                                <td class="text-center" width="15">
                                    <button class="btn btn-sm btn-danger" onclick="deletelocation('{{$location->id}}')">
                                        <span><i class="fa fa-trash"></i></span></button>
                                    <form id="delete-form-{{$location->id}}"
                                          action="{{ route('locations.destroy',$location->id) }}" method="post"
                                          style="display: none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th><input type="checkbox" class="selectAll2"></th>
                        <th class="text-center" width="20">ID</th>
                        <th>location Code</th>
                        <th>location Name</th>
                        <th>Modifies by</th>
                        <th>Status</th>
                        <th>Add On</th>
                        <th>Update On</th>
                        @can('location.update')
                            <th class="text-center" width="20">Edit</th>
                        @endcan
                        @can('location.delete')
                            <th class="text-center" width="20">Delete</th>
                        @endcan
                    </tr>
                    </tfoot>
                </table>
                </div>
            </div>
            <div class="box-footer with-border">
                <div class="box-title pull-right">
                    {{ $locations->appends(['search'=>$search])->links() }}
                </div>
            </div>
            <!-- /.box-body -->
            <!-- Modal -->
            <div id="add_location" class="modal fade" role="dialog">

                <div class="modal-dialog">

                    <!-- Modal content-->

                    <div class="modal-content">

                        <form role="form" method="POST" action="{{ route('locations.store') }}">
                        @csrf

                        <!--=====================================
                            HEADER
                            ======================================-->

                            <div class="modal-header" style="background: #3c8dbc; color: #fff">

                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                <h4 class="modal-title">Add location</h4>

                            </div>

                            <!--=====================================
                            BODY
                            ======================================-->

                            <div class="modal-body">

                                <div class="box-body">

                                    <!--Input name -->

                                    <div class="form-group {{ $errors->has('location_code') ? ' has-error' : '' }}">

                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-code"></i></span>

                                            <input value="{{old('location_code')}}" class="form-control input-lg"
                                                   type="text" name="location_code" placeholder="Enter location Code"
                                                   required>
                                        </div>

                                    </div>

                                    <!-- input username -->

                                    <div class="form-group">

                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-tag"></i></span>

                                            <input value="{{old('location_name')}}" class="form-control input-lg"
                                                   type="text" name="location_name" placeholder="Enter location Name"
                                                   required>

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

                                <button type="submit" class="btn btn-primary" name="submit">Save</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
            <div id="import" class="modal fade" role="dialog">

                <div class="modal-dialog">

                    <!-- Modal content-->

                    <div class="modal-content">

                        <form role="form" method="POST" action="{{ route('locations.import') }}" enctype="multipart/form-data">
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
                    window.location.href = "{{ route('locations.export') }}";
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    //
                }
            })
        })

        function deletelocation(id) {
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
            $('.selectbox').prop('checked',$(this).prop('checked'));
            $('.selectAll2').prop('checked',$(this).prop('checked'));
        });
        $('.selectAll2').click(function () {
            $('.selectbox').prop('checked',$(this).prop('checked'));
            $('.selectAll').prop('checked',$(this).prop('checked'));
        });
        $('.selectbox').change(function () {
            var total = $('.selectbox').length;
            var number = $('.selectbox:checked').length;
            if (total == number){
                $('.selectAll').prop('checked',true);
                $('.selectAll2').prop('checked',true);
            }else {
                $('.selectAll').prop('checked',false);
                $('.selectAll2').prop('checked',false);
            }
        })
    </script>
@endpush
