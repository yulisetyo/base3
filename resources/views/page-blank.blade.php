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
					<li><a href="#"><i class="fa fa-th-large"></i> Blank</a></li>
					<li class="active">Blank</li>
				</ol>
			</section>

			<section class="content">
				<div class="box ">
					<div class="box-header with-border">
						<h3 class="box-title">
							Header
							<small></small>
						</h3>
					</div>
					<div class="box-body"></div>
				</div>
			</section>

<script>
jQuery(document).ready(function(){
	// jQuery kode
	
});
</script>
@endsection
