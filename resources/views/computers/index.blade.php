@extends('layouts.master')

@section('title','Computer')

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
            Manage Computer
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
                    @can('computer.create')
                        <a data-toggle="modal" data-target="#add_computer"><span class="btn btn-success">Add New</span></a>
                    @endcan
                </div>
                <div class="box-title">
                    @can('computer.create')
                        <a id="export"><span class="btn btn-warning">Export</span></a>
                    @endcan
                </div>
                <div class="box-title">
                    @can('computer.create')
                        <a data-toggle="modal" data-target="#import"><span class="btn btn-primary">Import</span></a>
                    @endcan
                </div>
                <div class="box-tools pull-right">
                    <div class="box-tools pull-right mt-4">
                        <form action="{{ route('computers.index') }}">
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
                            <th>Asset Name</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Cost Center</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Modify</th>
                            <th width="15">View</th>
                            <th width="10">Edit</th>
                            <th width="15">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($computers as $computer)
                            <tr>
                                <td>{{ $computer->id }}</td>
                                <td>{{ $computer->asset_code }}</td>
                                <td>{{ $computer->asset_name }}</td>
                                <td>{{ $computer->brandName }}</td>
                                <td>{{ $computer->modelName }}</td>
                                <td>{{ $computer->costcenterName }}</td>
                                <td>{{ $computer->statusName }}</td>
                                <td>{{ $computer->locationName }}</td>
                                <td>{{ Carbon\Carbon::parse($computer->created_at)->format('M j, Y')}}</td>
                                <td>
                                    <a href="{{ route('computers.detail',$computer->id) }}"
                                       class="btn btn-sm btn-primary" role="button"><span class="fa fa-eye"></span></a>
                                </td>
                                <td>
                                    <a href="{{ route('computers.edit',$computer->id) }}" class="btn btn-sm btn-success" role="button"><span
                                            class="fa fa-edit"></span></a>
                                </td>
                                @can('computer.delete')
                                    <td class="text-center" width="15">
                                        <button class="btn btn-sm btn-danger" onclick="deleteComputer('{{$computer->id}}')">
                                            <span><i class="fa fa-trash"></i></span></button>
                                        <form id="delete-form-{{$computer->id}}"
                                              action="{{ route('computers.destroy',$computer->id) }}" method="post"
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
                    {{ $computers->appends(['search'=>$search])->links() }}
                </div>
            </div>
            <!-- /.box-body -->
            <!-- Modal -->
            <div class="modal fade" id="add_computer" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form action="{{ route('computers.store') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h3 class="modal-title">Add New Computer</h3>
                                <!-- <h3 class="close pull-right" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </h3>-->
                            </div>
                            <div class="modal-body">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Asset Code</label>
                                        <select class="form-control" name="asset_id" required style="width: 250px">
                                            <option value="" disabled selected>select Brand</option>
                                            @foreach($assets as $asset_it)
                                                <option
                                                    value="{{ $asset_it->id }}"
                                                    @if (old('asset_id') == $asset_it->id) selected="selected" @endif> {{ $asset_it->asset_code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Monitor Name</label>
                                        <input type="text" class="form-control" placeholder="Enter name"
                                               name="monitor_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mainboard Name</label>
                                        <input type="text" class="form-control" placeholder="Enter name"
                                               name="mainboard_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">CPU</label>
                                        <input type="text" class="form-control" placeholder="Enter name" name="cpu">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Hard Disk</label>
                                        <input type="text" class="form-control" placeholder="Enter name"
                                               name="hard_disk">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">RAM</label>
                                        <input type="text" class="form-control" placeholder="Enter name" name="ram">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Power Supply</label>
                                        <input type="text" class="form-control" placeholder="Enter name" name="power">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Keyboard</label>
                                        <input type="text" class="form-control" placeholder="Enter name"
                                               name="keyboard">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mouse</label>
                                        <input type="text" class="form-control" placeholder="Enter name" name="mouse">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">CD / ROM</label>
                                        <input type="text" class="form-control" placeholder="Enter name" name="cd_rom">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <br>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

                        <form role="form" method="POST" action="{{ route('assets.import') }}"
                              enctype="multipart/form-data">
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
        $('#export').click('on', function () {
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
                    window.location.href = "{{ route('computers.export') }}";
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    //
                }
            })
        })

        function deleteComputer(id) {
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
