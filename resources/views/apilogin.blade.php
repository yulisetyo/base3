<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="/adminlte/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="/adminlte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="/adminlte/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="/adminlte/plugins/alertifyjs/css/alertify.css">
  <link rel="stylesheet" href="/adminlte/plugins/alertifyjs/css/themes/default.css">
  <script src="/adminlte/plugins/jQuery/jquery-2.2.3.min.js" type="text/javascript"></script>
</head>

<body class="hold-transition login-page">
	
	<div class="login-box">
		<div class="login-logo">
			<a href="./"><b>API-Login</b></a>
		</div>
		<div class="login-box-body">
			<!--<p class="login-box-msg">Silahkan login untuk menggunakan <b>eOffice</b></p>-->

			<form name="flogin" id="flogin" onsubmit="return false" >
				{{ csrf_field() }}
				<div class="form-group has-feedback">
					<input type="text" class="form-control" id="username" name="username" placeholder="Username">
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				
				<div class="form-group has-feedback">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				
				<div class="row">
					<!--
					<div class="col-xs-8">
						<div class="checkbox icheck">
							<label>
								<input type="checkbox"> Remember Me
							</label>
						</div>
					</div>
					-->
					<div class="col-xs-4 pull-right">
						<button type="submit" id="btn_login" class="btn btn-primary btn-block btn-flat">Login</button>
					</div>
				</div>
			</form>
			<!--
			<a href="#">I forgot my password</a><br>
			<a href="register.html" class="text-center">Register a new membership</a>
			-->
		</div>
	</div>

<script src="/adminlte/plugins/alertifyjs/alertify	.min.js"></script>
<script src="/adminlte/bootstrap/js/bootstrap.min.js"></script>
<script src="/adminlte/plugins/iCheck/icheck.min.js"></script>
<script>
	jQuery(document).ready(function () {
		//~ jQuery('input').iCheck({
			//~ checkboxClass: 'icheckbox_square-blue',
			//~ radioClass: 'iradio_square-blue',
			//~ increaseArea: '20%' // optional
		//~ });
		
		jQuery('#btn_login').click(function(){
			var uname = jQuery('#username').val();
			var upass = jQuery('#password').val();
			var lanjut = true;
			
			if(uname == '') {
				alertify.alert('api-login', 'Username harus di isi', function(){ var lanjut = true; });
				var lanjut = false;
			} else {
				if(upass == '') {
					alertify.alert('api-login', 'Password harus di isi', function(){ var lanjut = true; });
					var lanjut = false;
				} else {
					var lanjut = true;
				}
			}
			
			if(lanjut == true) {
				var data = jQuery('#flogin').serialize();
				jQuery.ajax({
					url: '/api/v1/apilogin',
					method: 'POST',
					data: data,
					success: function(result){
						alertify.alert('api-login', result.token, function(){});
						//~ if(result.token == 'success') {
							//~ alertify.alert('api-login', 'Selamat datang di API-Login', function(){
								//~ //window.location.replace('/home');
							//~ });
						//~ } else {
							//~ alertify.alert('api-login', result.message, function(){});
						//~ }
					}
				});
			} 
		});
	});
</script>
</body>
</html>
