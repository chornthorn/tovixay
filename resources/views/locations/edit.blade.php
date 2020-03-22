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
            Edit location
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
                    <a href="{{ route('locations.index') }}"><span class="btn btn-success">Back</span></a>
                </div>
            </div>
            <div class="box-body">
                <!--------------------------
                  | Your Page Content Here |
                  -------------------------->
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div></div>
                        <form action="{{ route('locations.update',$location->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">location Code</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control hidden" name="id"
                                           value="{{ $location->id }}">
                                    <input type="text" value="{{ $location->location_code }}" class="form-control"
                                           name="location_code" placeholder="Enter Code">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">location Name</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{ $location->location_name }}" class="form-control"
                                           name="location_name" placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">location Add By User</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{ $location->user->name }}" class="form-control"
                                           readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">location Add On</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{ $location->created_at }}" class="form-control"
                                           readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">location Update On</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{ $location->updated_at }}" class="form-control"
                                           name="category_update" readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">location Status</label>
                                <div class="col-sm-9">
                                    <select name="location_status" id="" class="form-control">
                                        <option value="" class="form-control" selected="" disabled="">Select Status
                                        </option>
                                        @if($location->location_status == '1')
                                            <option value="1" class="form-control" selected>Active</option>
                                            <option value="0" class="form-control">Deactive</option>
                                        @else
                                            <option value="1" class="form-control">Active</option>
                                            <option value="0" class="form-control" selected>Deactive</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 pull-right">
                                    <input type="submit" class="form-control btn btn-sm btn-success" name="update"
                                           value="Update">
                                </div>
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
