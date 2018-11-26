<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('admin.title')}} | {{ trans('admin.login') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css") }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/plugins/iCheck/square/blue.css") }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
    button#btn{cursor:pointer;height:44px;margin-top:25px;padding:0;background:#025AF2;-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;border:0;-moz-box-shadow:0 15px 30px 0 rgba(255, 255, 255, .25) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);-webkit-box-shadow:0 15px 30px 0 rgba(255, 255, 255, .25) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);box-shadow:0 15px 30px 0 rgba(255, 255, 255, .25) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);font-family:'PT Sans', Helvetica, Arial, sans-serif;font-size:14px;font-weight:700;color:#fff;text-shadow:0 1px 2px rgba(0, 0, 0, .1);-o-transition:all .2s;-moz-transition:all .2s;-webkit-transition:all .2s;-ms-transition:all .2s}
    input.form-control{height:42px;line-height:42px;padding:0 15px;background:#2d2d2d;*:;background-color: transparent;background:rgba(45, 45, 45, .15);-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px;border:1px solid #3d3d3d;border:1px solid rgba(255, 255, 255, .15);-moz-box-shadow:0 2px 3px 0 rgba(0, 0, 0, .1) inset;-webkit-box-shadow:0 2px 3px 0 rgba(0, 0, 0, .1) inset;box-shadow:0 2px 3px 0 rgba(0, 0, 0, .1) inset;font-family:'PT Sans', Helvetica, Arial, sans-serif;font-size:14px;color:#fff;text-shadow:0 1px 2px rgba(0, 0, 0, .1);-o-transition:all .2s;-moz-transition:all .2s;-webkit-transition:all .2s;-ms-transition:all .2s}
    input.form-control::-webkit-input-placeholder{color:#fff}
  </style>
</head>
<body class="hold-transition login-page" style="background: url({{url('/2.jpg')}}) no-repeat;background-size: cover;">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ admin_base_path('/') }}"><b style="color: #FFFFFF;">{{config('admin.name')}}</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="background-color: transparent;">
    {{--<p class="login-box-msg">{{ trans('admin.login') }}</p>--}}

    <form action="{{ admin_base_path('auth/login') }}" method="post">
      <div class="form-group has-feedback {!! !$errors->has('username') ?: 'has-error' !!}">

        @if($errors->has('username'))
          @foreach($errors->get('username') as $message)
            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label></br>
          @endforeach
        @endif

        <input type="input" class="form-control" placeholder="{{ trans('admin.username') }}" name="username" value="{{ old('username') }}">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback {!! !$errors->has('password') ?: 'has-error' !!}">

        @if($errors->has('password'))
          @foreach($errors->get('password') as $message)
            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label></br>
          @endforeach
        @endif

        <input type="password" class="form-control" placeholder="{{ trans('admin.password') }}" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

        <div class="form-group has-feedback {!! !$errors->has('captcha') ?: 'has-error' !!}">

          @if($errors->has('captcha'))
            @foreach($errors->get('captcha') as $message)
              <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label></br>
            @endforeach
          @endif
          <div style="display: flex;justify-content: space-between;">
            <input type="text" class="form-control" style="width: 55%;" placeholder="请输入验证码" name="captcha"autocomplete="off">
            <img  class="captcha" src="{{ captcha_src('admin') }}" style="height: 42px;border-radius: 6px;width: 42%;float: right">
          </div>
        </div>


        <div class="row">

        <!-- /.col -->
        <div class="col-xs-12">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button id="btn" type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('admin.login') }}</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="{{ admin_asset("/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}} "></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- iCheck -->
<script src="{{ admin_asset("/vendor/laravel-admin/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>

<script>
    $(function () {

        $('.captcha').click(function () {
            $('img[class="captcha"]').attr('src','{{ captcha_src('admin') }}'+Math.random());
        });
    });
</script>
</body>
</html>
