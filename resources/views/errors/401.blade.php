@extends('layouts.master')

@section('title','Dashboard')

@push('css')

@endpush

@section('content')

    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow"> 401</h2>
            <br>
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! This action is unauthorized..</h3>

                <p>
                    You! Don't have permission to access this action <br>
                    <a href="{{ url('/') }}">Return to dashboard</a> or try contact to Administration.
                </p>

                <form class="search-form">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">

                        <div class="input-group-btn">
                            <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.input-group -->
                </form>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>

@endsection

@push('js')


@endpush
