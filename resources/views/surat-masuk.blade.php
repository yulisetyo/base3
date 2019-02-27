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
					<li><a href="#"><i class="fa fa-dashboard"></i> Dokumen</a></li>
					<li class="active">Surat Masuk</li>
					
				</ol>
			</section>

			<section class="content">
				<?php echo $rekam_surat; ?>
				<div class="box" id="div-ruh">
					<div class="box-header with-border">
						<h1 class="box-title">
							Rekam Surat Masuk
							<small></small>
						</h1>
					</div>
					<form class="form-horizontal" onsubmit="return false" id="form-ruh" name="form-ruh">
						<div class="box-body">
							{{ csrf_field() }}
							<div class="form-group">
								<label class="control-label col-md-2">Nomor Surat</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="nosurat" name="nosurat" />
								</div>
								<span id="warning-nosurat" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Tanggal Surat</label>
								<div class="col-md-2">
									<input type="text" class="form-control" id="tglsurat" name="tglsurat" />
								</div>
								<span id="warning-tglsurat" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Perihal Surat</label>
								<div class="col-md-8">
									<input type="text" class="form-control" id="perihal" name="perihal" />
								</div>
								<span id="warning-perihal" class="label label-danger warning">Required!</span>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Asal Instansi</label>
								<div class="col-md-2">
									<select class="form-control chosen" style="width: 100%;" id="inex" name="inex">
										<option value="" style="display:none;">Pilih</option>
										<option value="in">Internal</option>
										<option value="ex">Eksternal</option>
									</select>
								</div>
							</div>

							<div class="form-group" id="div-in">
								<label class="control-label col-md-2">&nbsp;</label>
								<div class="col-md-6">
									<select class="form-control chosen" style="width: 100%;" id="dari" name="dari">
										<option value="" style="display:none;">Pilih</option>
									</select>
								</div>
								<span id="warning-dari" class="label label-danger warning">Required!</span>
							</div>

							<div class="form-group" id="div-ex">
								<label class="control-label col-md-2">&nbsp;</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="eksternal" name="eksternal" placeholder="" />
								</div>
								<span id="warning-dari" class="label label-danger warning">Required!</span>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2">Jenis Surat</label>
								<div class="col-md-3">
									<select class="form-control chosen" style="width: 100%;" id="jnssurat" name="jnssurat">
										<option value="" style="display:none;">Pilih</option>
									</select>
								</div>
								<span id="warning-jnssurat" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Keaslian</label>
								<div class="col-md-2">
									<select class="form-control chosen" style="width: 100%;" id="keaslian" name="keaslian">
										<option value="" style="display:none;">Pilih</option>
										<option value="asli">Asli</option>
										<option value="tembusan">Tembusan</option>
									</select>
								</div>
								<span id="warning-keaslian" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Klasifikasi/Kualifikasi</label>
								<div class="col-md-2">
									<select class="form-control chosen" style="width: 100%;" id="klasifikasi" name="klasifikasi">
										<option value="" style="display:none;">Pilih</option>
										<option value="biasa">Biasa</option>
										<option value="terbatas">Terbatas</option>
										<option value="rahasia">Rahasia</option>
										<option value="sangat_rahasia">Sangat Rahasia</option>
									</select>
								</div>
								<span id="warning-klasifikasi" class="label label-danger warning">Required!</span>
								<div class="col-md-2">
									<select class="form-control chosen" style="width: 100%;" id="kualifikasi" name="kualifikasi">
										<option value="" style="display:none;">Pilih</option>
										<option value="biasa">Biasa</option>
										<option value="segera">Segera</option>
										<option value="sangat_segera">Sangat Segera</option>
									</select>
								</div>
								<span id="warning-kualifikasi" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Lampiran</label>
								<div class="col-md-2">
									<input type="text" class="form-control" id="lampiran" name="lampiran" style="text-align:right;" />
								</div>
								<span id="warning-lampiran" class="label label-danger warning">Required!</span>
								<div class="col-md-3">
									<select class="form-control chosen" style="width: 100%;" id="jnslam" name="jnslam">
										<option value="" style="display:none;">Pilih</option>
										<option value="berkas">berkas</option>
										<option value="lembar">lembar</option>
										<option value="bendel">bendel</option>
									</select>
								</div>
								<span id="warning-jnslam" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Berkas</label>
							</div>
							<div class="form-group">
								<div class="col-md-2">&nbsp;</div>
								<div class="col-md-4">
									<button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-save"></i> Proses</button>
									<button type="cancel" id="batal" class="btn btn-default"><i class="fa fa-refresh"></i> Batal</button>
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="box" id="div-tabel">
					<div class="box-header with-border">
						<h3 class="box-title">Tabel</h3>
					</div>
					<div class="box-body">
						<table class="table" id="tabel-ruh">
							<thead>
								<tr>
									<th>#</th>
									<th>No. & Tgl. Surat</th>
									<th>Asal & Perihal</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="4"><small>Data tidak ditemukan...</small></td>
								</tr>
							</tbody>
						</table>
					</div>					
				</div>
			</section>

<script>
jQuery(document).ready(function(){

	jQuery('.chosen').chosen({width:'100%'});

	jQuery('#div-in,#div-ex').hide();

	jQuery('#inex').change(function(){
		var inex = jQuery(this).val();
		if(inex == 'in') {
			jQuery('#div-in').show();
			jQuery('#div-ex').hide();
		} else if(inex == 'ex') {
			jQuery('#div-in').hide();
			jQuery('#div-ex').show();
		}
	});

	// tampilan default
	function form_default(){
		jQuery('#div-ruh,#div-in,#div-ex').hide();
		jQuery('#div-tabel').show();
		jQuery('#nosurat,#tglsurat,#perihal,#dari,#lampiran').val('');
		jQuery('.chosen').val('').trigger('chosen:updated');
	}

	//~ form_default();

	// untuk menampilkan form perekaman data
	jQuery('#tambah').click(function(){
		jQuery('#div-ruh').show();
		jQuery('#div-tabel').hide();
	});

	// batal menyimpan data
	jQuery('#batal').click(function(){
		form_default();
	});

	// menyimpan data perekaman
	jQuery('#submit').click(function(){		
		var next = true;
		
		if(next == true) {
			var data = jQuery('#form-ruh').serialize();
			alert(data);
			//~ jQuery.ajax({
				//~ url: 'surat-masuk',
				//~ method: 'POST',
				//~ data: data,
				//~ success: function(result){
					//~ if(result.message == 'success') {
						//~ alertify.message('berhasil menyimpan data');
					//~ } else {
						//~ alertify.message(result.message);
					//~ }
					//~ form_default();
				//~ }
			//~ });
		} 
	});
});
</script>
@endsection
