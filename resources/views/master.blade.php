<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/bootstrap/css/floating.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/plugins/alertifyjs/css/alertify.css">
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/plugins/alertifyjs/css/themes/default.css">
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/plugins/chosen/chosen.css">
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/plugins/pekeupload/css/custom.css">	
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/plugins/pekeupload/css/themes/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/plugins/pekeupload/css/themes/bootstrap/css/bootstrap-theme.css">
	<link rel="stylesheet" href="<?php echo \URL::to('/public');?>/adminlte/plugins/jquery-file-upload/css/jquery.fileupload.css">
	<script src="<?php echo \URL::to('/public');?>/adminlte/plugins/jQuery/jquery-2.2.3.min.js" type="text/javascript"></script>
	<script src="<?php echo \URL::to('/public');?>/adminlte/plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
	<script>
		jQuery(document).ready(function(){
			$.widget.bridge('uibutton', $.ui.button);
		});
	</script>
	
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!--<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">-->
	<div class="wrapper">
		<header class="main-header">
			<a href="{{ url('/home') }}" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini">e<b>O</b></span>
				<span class="logo-lg"><b>{{ config('app.name', 'Laravel') }}</b></span>
			</a>
			
			<nav class="navbar navbar-static-top">
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<?php if(Session::get('jnskel') == 'P') {?>
								<img src="<?php echo \URL::to('/public');?>/adminlte/dist/img/avatar2.png" class="user-image" alt="User Image">
								<?php } else {?>
								<img src="<?php echo \URL::to('/public');?>/adminlte/dist/img/avatar5.png" class="user-image" alt="User Image">
								<?php } ?>
								<span class="hidden-xs"><b>{{ Session::get('name') }}</b></span>
							</a>
							
							<ul class="dropdown-menu">
								<li class="user-header">
									<?php if(Session::get('jnskel') == 'P') {?>
									<img src="<?php echo \URL::to('/public');?>/adminlte/dist/img/avatar2.png" class="img-circle" alt="User Image">
									<?php } else {?>
									<img src="<?php echo \URL::to('/public');?>/adminlte/dist/img/avatar5.png" class="img-circle" alt="User Image">
									<?php } ?>
									<p>
										<span>{{ Session::get('name') }}</span><br/><small>NIP {{ Session::get('nip') }}</small>
									</p>
								</li>
								
								<li class="user-footer">
									<div class="pull-left">
									<?php if('060000060' === session('nip')) { ?>
										&nbsp;
									<?php } else { ?>
										<a href="{{ url('profil') }}" class="btn btn-default btn-flat">Profile</a>
									<?php } ?>
									</div>
									<div class="pull-right">
										<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="">
                                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                            <button class="btn btn-default btn-flat"><i class="fa fa-sing-out"></i> Logout</button>
                                        </form>
                                        
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		
		<aside class="main-sidebar">
			<section class="sidebar">
				<div class="user-panel">
					<div class="pull-left image">
						<?php if(Session::get('jnskel') == 'P') {?>
						<img src="<?php echo \URL::to('/public');?>/adminlte/dist/img/avatar2.png" class="img-circle" alt="User Image">
						<?php } else {?>
						<img src="<?php echo \URL::to('/public');?>/adminlte/dist/img/avatar5.png" class="img-circle" alt="User Image">
						<?php } ?>
					</div>
					<div class="pull-left info">
						<p>{{ Session::get('nama') }}</p>
						<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
					</div>
				</div>
				
				<ul class="sidebar-menu">
					
					<li class="">
						<a href="{{ url('/home') }}">
							<!--<i class="fa fa-dashboard"></i> <span>Beranda</span>-->
							<i class="glyphicon glyphicon-dashboard"></i> <span>Beranda</span>
						</a>
					</li>
					
					@yield('sidemenu')
					
				</ul>
			</section>
		</aside>
		
		<div class="content-wrapper">
			
			@yield('content')
			
		</div>
		
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> 2.3.6
			</div>
			<strong>Copyright &copy; 2018 <a target="_blank" href="http://www.djpbn.kemenkeu.go.id/portal/id">Kementerian Keuangan - Direktorat Jenderal Perbendaharaan</a>.</strong> All rights reserved.
		</footer>
	</div>


	<script src="<?php echo \URL::to('/public');?>/adminlte/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo \URL::to('/public');?>/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="<?php echo \URL::to('/public');?>/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo \URL::to('/public');?>/adminlte/plugins/fastclick/fastclick.js"></script>
	<script src="<?php echo \URL::to('/public');?>/adminlte/dist/js/app.min.js"></script>
	<script src="<?php echo \URL::to('/public');?>/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo \URL::to('/public');?>/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo \URL::to('/public');?>/adminlte/plugins/alertifyjs/alertify.min.js"></script>
	<script src="<?php echo \URL::to('/public');?>/adminlte/plugins/chosen/chosen.jquery.min.js"></script>
	<!--<script src="<?php echo \URL::to('/public');?>/adminlte/plugins/chosen/chosen.proto.min.js"></script>-->
	<script src="<?php echo \URL::to('/public');?>/adminlte/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
	<script src="<?php echo \URL::to('/public');?>/adminlte/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
	
</body>

</html>
