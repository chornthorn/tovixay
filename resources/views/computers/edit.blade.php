@extends('layouts.master')

@section('title','Edit')

@push('css')
    <!-- include css style here if css file run only this page -->
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Computer Detail
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Computer</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <div class="box-title">
                    <a href="{{ route('computers.index') }}"><span class="btn btn-success">Back</span></a>
                </div>
            </div>
            <div class="box-body">
                <!--------------------------
                  | Your Page Content Here |
                  -------------------------->
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <form action="{{ route('computers.update',$computer->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h3 class="modal-title text-center">Edit Computer</h3>
                                <!-- <h3 class="close pull-right" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </h3>-->
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label for="exampleInputEmail1">Monitor Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Monitor Name" name="monitor_name" value="{{ $computer->monitor_item }}">
                                </div>
                                <div class="form-group ">
                                    <label for="exampleInputEmail1">Mainboard Name</label>
                                    <input type="text" class="form-control" placeholder="Enter name" name="mainboard_name" value="{{ $computer->mainboard_item }}">
                                </div>
                                <div class="form-group ">
                                    <label for="exampleInputEmail1">CD ROM</label>
                                    <input type="text" class="form-control" placeholder="Enter name" name="cd_rom" value="{{ $computer->cdrom_item }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label for="exampleInputEmail1">CPU Name</label>
                                    <input type="text" class="form-control" placeholder="Enter name" name="cpu" value="{{ $computer->cpu_item }}">
                                </div>
                                <div class="form-group ">
                                    <label for="exampleInputEmail1">Hard Disk</label>
                                    <input type="text" class="form-control" placeholder="Enter name" name="hard_disk" value="{{ $computer->harddisk_item }}">
                                </div>
                                <div class="form-group ">
                                    <label for="exampleInputEmail1">RAM</label>
                                    <input type="text" class="form-control" placeholder="Enter name" name="ram" value="{{ $computer->ram_item }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label for="exampleInputEmail1">Power Supply</label>
                                    <input type="text" class="form-control" placeholder="Enter name" name="power" value="{{ $computer->powersupply_item }}">
                                </div>
                                <div class="form-group ">
                                    <label for="exampleInputEmail1">Keyboard</label>
                                    <input type="text" class="form-control" placeholder="Enter name" name="keyboard" value="{{ $computer->keyboard_item }}">
                                </div>
                                <div class="form-group ">
                                    <label for="exampleInputEmail1">Mouse</label>
                                    <input type="text" class="form-control" placeholder="Enter name" name="mouse" value="{{ $computer->mouse_item }}">
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
@endpush
