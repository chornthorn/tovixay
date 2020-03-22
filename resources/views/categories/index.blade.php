@extends('layouts.master')

@section('title','Category')

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
            Manage Category
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Category</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <div class="box-title">
                    @can('category.create')
                        <a data-toggle="modal" data-target="#add_category"><span class="btn btn-success">Add New</span></a>
                    @endcan
                </div>
                <div class="box-title">
                    @can('category.create')
                        <a id="export"><span class="btn btn-warning">Export</span></a>
                    @endcan
                </div>
                <div class="box-title">
                    @can('category.create')
                        <a data-toggle="modal" data-target="#import_category"><span class="btn btn-primary">Import</span></a>
                    @endcan
                </div>
                <div class="box-title">
                    @can('category.create')
                        <a href="{{ route('categories.pdf') }}"><span class="btn btn-primary">PDF</span></a>
                    @endcan
                </div>
                <div class="box-tools pull-right">
                    <div class="box-tools pull-right mt-4">
                        <form action="{{ route('categories.index') }}">
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
                        <th class="text-center" width="20">Category ID</th>
                        <th>Category Name</th>
                        <th>Modifies by</th>
                        <th>Status</th>
                        <th>Add On</th>
                        <th>Update On</th>
                        @can('category.update')
                            <th class="text-center" width="20">Edit</th>
                        @endcan
                        @can('category.delete')
                            <th class="text-center" width="20">Delete</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($categories) < 1)
                        <tr>
                            <td colspan="10" class="text-center">No Data</td>
                        </tr>
                     @else
                    @foreach($categories as $category)
                        <tr>
                            <th><input name="ids[]" value="{{ $category->id }}" type="checkbox" class="selectbox"></th>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td>{{ $category->user->name }}</td>
                            @if($category->category_status =='1')
                                <td class="text-center">Active</td>
                            @else
                                <td class="text-center">Deactive</td>
                            @endif
                            <td>{{ $category->created_at }}</td>
                            <td>{{ $category->updated_at }}</td>
                            @can('category.update')
                                <td class="text-center">
                                    <a href="{{ route('categories.edit',$category->id) }}" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                </td>
                            @endcan
                            @can('category.delete')
                                <td class="text-center" width="15">
                                    <button class="btn btn-sm btn-danger" onclick="deleteCategory('{{$category->id}}')">
                                        <span><i class="fa fa-trash"></i></span></button>
                                    <form id="delete-form-{{$category->id}}"
                                          action="{{ route('categories.destroy',$category->id) }}" method="post"
                                          style="display: none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
                </div>
            </div>
            <div class="box-footer with-border">
                <div class="box-title pull-right">
                    {{ $categories->appends(['search'=>$search])->links() }}
                </div>
            </div>
            <!-- /.box-body -->
            <!-- Modal -->
            <div id="add_category" class="modal fade" role="dialog">

                <div class="modal-dialog">

                    <!-- Modal content-->

                    <div class="modal-content">

                        <form role="form" method="POST" action="{{ route('categories.store') }}">
                        @csrf

                        <!--=====================================
                            HEADER
                            ======================================-->

                            <div class="modal-header" style="background: #3c8dbc; color: #fff">

                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                <h4 class="modal-title">Add Category</h4>

                            </div>

                            <!--=====================================
                            BODY
                            ======================================-->

                            <div class="modal-body">

                                <div class="box-body">

                                    <!-- input username -->

                                    <div class="form-group">

                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-tag"></i></span>

                                            <input value="{{old('category_name')}}" class="form-control input-lg"
                                                   type="text" name="category_name" placeholder="Enter Category Name"
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
            <div id="import_category" class="modal fade" role="dialog">

                <div class="modal-dialog">

                    <!-- Modal content-->

                    <div class="modal-content">

                        <form role="form" method="POST" action="{{ route('categories.import') }}" enctype="multipart/form-data">
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

                                    <div class="form-group {{ $errors->has('category_file') ? ' has-error' : '' }}">

                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-code"></i></span>

                                            <input value="{{old('category_file')}}" class="form-control input-lg"
                                                   type="file" name="category_file">
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
                    window.location.href = "{{ route('categories.export') }}";
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    //
                }
            })
        })

        function deleteCategory(id) {
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
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                confirmButtonText: 'Yes, delete it!',
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
