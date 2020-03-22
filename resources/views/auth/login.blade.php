<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Pace style -->
    <link rel="stylesheet" href="{{ asset('plugins/pace/pace.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/toastr/build/toastr.min.css') }}">
    <style type="text/css">
        .login-form {
            width: 340px;
            margin: 150px auto;
        }
        .login-form form {
            margin-bottom: 15px;
            background: #f7f7f7;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }
        .login-form h2 {
            margin: 0 0 15px;
        }
        .form-control, .btn {
            min-height: 38px;
            border-radius: 2px;
        }
        .btn {
            font-size: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="login-form">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h2 class="text-center">Log in</h2>
        <div class="form-group">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Log in</button>
        </div>
        <div class="clearfix">
            <label class="pull-left checkbox-inline"><input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me</label>
            @if (Route::has('password.request'))
                <a class="pull-right" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>
    </form>
    <!-- jQuery 3 -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- PACE -->
    <script src="{{ asset('bower_components/PACE/pace.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/build/toastr.min.js') }}"></script>
    <script type="text/javascript">
        // To make Pace works on Ajax calls
        $(document).ajaxStart(function () {
            Pace.restart()
        })
    </script>
    <script>

            @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif

        @if($errors->any())

        @foreach($errors->all()  as $error)

        toastr.error('{{ $error }}');

        @endforeach

        @endif

    </script>
</div>
</body>
</html>
