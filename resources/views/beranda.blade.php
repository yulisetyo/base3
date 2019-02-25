@extends('master')

@section('sidemenu')
					<?php echo $side_menu;?>
@endsection

@section('content')
			<section class="content-header">
				<h1>
					<small><?php echo $nm_unit;?></small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
					<li class="active">Dashboard</li>
				</ol>
			</section>
			
			<section class="content">
				<div class="row">
					
					<div class="col-md-3 col-xs-6">
						<div class="small-box bg-red">
							<div class="inner">
								<h3 ID="jml_sms">0</h3>
								<p>Semua Surat Masuk</p>
							</div>
							<div class="icon">
								<i class="fa fa-envelope"></i>
							</div>
							<a href="surat-masuk" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
					
					<div class="col-md-3 col-xs-6">
						<div class="small-box bg-yellow">
							<div class="inner">
								<h3 id="jml_trm">0</h3>
								<p>Surat Masuk Sudah Diterima</p>
							</div>
							<div class="icon">
								<i class="fa fa-handshake-o"></i>
							</div>
							<a href="surat-masuk" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
				
				
					<div class="col-md-3 col-xs-6">
						<div class="small-box bg-green">
							<div class="inner">
							<h3 id="jml_smbd">0</h3>
								<p>Surat Masuk Belum Disposisi</p>
							</div>
							<div class="icon">
								<i class="fa fa-mail-forward"></i>
							</div>
							<a href="surat-masuk" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
					
					<div class="col-md-3 col-xs-6">
						<div class="small-box bg-aqua">
							<div class="inner">
								<h3 id="jml_smsd">0</h3>
								<p>Surat Masuk Sudah Disposisi</p>
							</div>
							<div class="icon">
								<i class="fa fa-envelope-open"></i>
							</div>
							<a href="surat-masuk" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
					
				</div>
				
				<div class="row">
					<section class="col-lg-12 connectedSortable">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs pull-right">
								<li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
								<li><a href="#sales-chart" data-toggle="tab">Donut</a></li>
								<li class="pull-left header"><i class="fa fa-inbox"></i> Dokumen</li>
							</ul>
							<div class="tab-content no-padding">
								<div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
								<div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
							</div>
						</div>
					</section>
					
					<div class="col-lg-12">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#surat-masuk" data-toggle="tab">Tab 1</a></li>
								<li><a href="#surat-keluar" data-toggle="tab">Tab 2</a></li>
								<li><a href="#surat-dibaca" data-toggle="tab">Tab 3</a></li>
							</ul>
							<div class="tab-content">
								<div class="active tab-pane" id="surat-masuk">
									<div class="box box-primary" id="div-surat-masuk">
										<form class="form-horizontal" id="form-in">
											<div class="box-body">
												<p>Lorem ipsum sit dolor amet</p>
												<p>Lorem ipsum sit dolor amet</p>
												<p>Lorem ipsum sit dolor amet</p>
											</div>
										</form>
									</div>
								</div>
								
								<div class="tab-pane" id="surat-keluar">
									<div class="box box-primary" id="div-surat-keluar">
										<form class="form-horizontal" id="form-out">
											<div class="box-body">
												<p>Bla bla bla</p>
												<p>Bla bla bla</p>
												<p>Bla bla bla</p>
											</div>
										</form>
									</div>
								</div>
								
								<div class="tab-pane" id="surat-dibaca">
									<div class="box box-primary" id="div-surat-dibaca">
										<form class="form-horizontal" id="form-read">
											<div class="box-body">
												<p>Prikitiew</p>
												<p>Prikitiew</p>
												<p>Prikitiew</p>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</section>
	
	<script>
		jQuery(document).ready(function(){
			jQuery.getJSON('dashboard/jsm', function(result){
				if(result) {
					jQuery('#jml_sms').html(result.jml_sms);
					jQuery('#jml_trm').html(result.jml_trm);
					jQuery('#jml_smbd').html(result.jml_smbd);
					jQuery('#jml_smsd').html(result.jml_smsd);
				}
			});
		});
	</script>
			
@endsection
