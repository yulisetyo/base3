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
					<li><a href="#"><i class="fa fa-chevron-right"></i> Dokumen</a></li>
					<li class="active">Surat Masuk</li>
				</ol>
			</section>

			<section class="content">
				<div class="box ">
					<div class="box-header with-border">
						<h3 class="box-title">
							Dokumen
							<small>Surat Masuk</small>
						</h3>
					</div>
					<div class="box-body">
						<dl class="dl-horizontal">
							<small>
								<dt>Nomor Agenda</dt> <dd>{{ $surat['noagd'] }}</dd>
								<dt>Jenis Dokumen</dt> <dd>{{ $surat['jenis'] }}</dd>
								<dt>Nomor Dokumen/ Tanggal</dt> <dd>{{ $surat['no'] }} / {{ $surat['tgl'] }}</dd>
								<dt>Tanggal Deadline</dt> <dd>{{ $surat['batas'] }}</dd>
								<dt>Asal Dokumen</dt> <dd>{{ $surat['asal'] }}</dd>
								<dt>Klasifikasi/Kualifikasi</dt> <dd>{{ $surat['klasifikasi'] }}/{{ $surat['kualifikasi'] }}</dd>
								<dt>Perihal</dt> <dd class="text-red text-bold">{{ $surat['perihal'] }}</dd>
							</small>
						</dl>
						<hr>
						<br>
					</div>
				</div>
			</section>

<script>
jQuery(document).ready(function(){
	// jQuery kode
	
});
</script>
@endsection
