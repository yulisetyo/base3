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
					<li><a href="#"><i class="fa fa-th-large"></i> Dokumen</a></li>
					<li class="active">Surat Masuk</li>
				</ol>
			</section>

			<section class="content">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h1 class="box-title">
							Dokumen
							<small>Detail</small>
						</h1>
					</div>
					<div class="box-body">
						<dl class="dl-horizontal">
							<input type="hidden" class="form-control" id="baseurl" name="baseurl" value={{ $baseurl }} />
							<input type="hidden" class="form-control" id="hash" name="hash" value={{ $surat['hash'] }} />
							<small>
								<dt>Dokumen</dt> <dd><?php echo $surat['hcopy']; ?></dd>
								<dt>Nomor Agenda</dt> <dd>{{ $surat['noagd'] }}</dd>
								<dt>Jenis Dokumen</dt> <dd>{{ $surat['jenis'] }}</dd>
								<dt>Nomor Dokumen/ Tanggal</dt> <dd>{{ $surat['no'] }} / {{ $surat['tgl'] }}</dd>
								<dt>Tanggal Deadline</dt> <dd>{{ $surat['batas'] }}</dd>
								<dt>Asal Dokumen</dt> <dd>{{ $surat['asal'] }}</dd>
								<dt>Klasifikasi/Kualifikasi</dt> <dd>{{ $surat['klasifikasi'] }}/{{ $surat['kualifikasi'] }}</dd>
								<dt>Perihal</dt> <dd class="text-red text-bold">{{ $surat['perihal'] }}</dd>
							</small>
						</dl>
					</div>
				</div>
				<div class="box box-primary">
					<div class="box-header with-border">
						<h1 class="box-title">
							Dokumen
							<small>Disposisi</small>
						</h1>
					</div>
					<div class="box-body" id="isi-disposisi">
						<!-- DISPOSISI -->
						<?php echo $disposisi; ?>

						<!--BUTTON TERIMA SURAT, PINNED SURAT, DAN PEMBERIAN CATATAN-->
						<?php echo $ststrm; ?>
						<?php echo $stspinned; ?>
						<?php echo $catatan; ?>
					</div>
				</div>
			</section>

<script>
jQuery(document).ready(function(){
	
	// jQuery kode
	var baseurl = jQuery('#baseurl').val();
	var hash = jQuery('#hash').val();

	jQuery('body').off('click', '.terima').on('click', '.terima', function(){
		var hash = this.id;
		jQuery.get(baseurl+'token', function(xtoken){
			if(xtoken) {
				var data = 'hash='+hash+'&_token='+xtoken;
				jQuery.post(baseurl+'/surat-masuk/terima', data, function(response){
					if(response.message=='success') {
						// ~ alertify.message('dokumen telah diterima');
						window.location.reload()
					} else {
						alertify.message('dokumen tidak dapat di terima');
					}
				});
			}
		});
	});
	//~ jQuery.get(baseurl+'/surat-masuk/disposisi/'+hash, function(result){
		//~ jQuery('#isi-disposisi').html(result);
	//~ });
	
});
</script>
@endsection
