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
								<label class="control-label col-md-3">Nomor Surat</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="nosurat" name="nosurat" />
								</div>
								<span id="warning-nosurat" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Tanggal Surat</label>
								<div class="col-md-2">
									<input type="text" class="form-control" id="tglsurat" name="tglsurat" />
								</div>
								<span id="warning-tglsurat" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Perihal Surat</label>
								<div class="col-md-8">
									<input type="text" class="form-control" id="perihal" name="perihal" />
								</div>
								<span id="warning-perihal" class="label label-danger warning">Required!</span>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Asal Instansi</label>
								<div class="col-md-3">
									<select class="form-control chosen" style="width: 100%;" id="inex" name="inex">
										<option value="" style="display:none;">Pilih</option>
										<option value="in">Internal DJPb</option>
										<option value="ex">Eksternal DJPb</option>
									</select>
								</div>
							</div>

							<div class="form-group" id="div-in">
								<label class="control-label col-md-3">&nbsp;</label>
								<div class="col-md-6">
									<select class="form-control chosen" style="width: 100%;" id="internal" name="internal">
										<option value="" style="display:none;">Pilih</option>
									</select>
								</div>
								<span id="warning-dari" class="label label-danger warning">Required!</span>
							</div>

							<div class="form-group" id="div-ex">
								<label class="control-label col-md-3">&nbsp;</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="eksternal" name="eksternal" placeholder="" />
								</div>
								<span id="warning-dari" class="label label-danger warning">Required!</span>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Jenis Surat</label>
								<div class="col-md-3">
									<select class="form-control chosen" style="width: 100%;" id="jnssurat" name="jnssurat">
										<option value="" style="display:none;">Pilih</option>
									</select>
								</div>
								<span id="warning-jnssurat" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Keaslian</label>
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
								<label class="control-label col-md-3">Klasifikasi/Kualifikasi</label>
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
								<label class="control-label col-md-3">Lampiran</label>
								<div class="col-md-1">
									<input type="text" class="form-control" id="lampiran" name="lampiran" style="text-align:right;" />
								</div>
								<span id="warning-lampiran" class="label label-danger warning">Required!</span>
								<div class="col-md-2">
									<select class="form-control chosen" style="width: 100%;" id="jnslam" name="jnslam">
										<option value="" style="display:none;">Pilih</option>
										<option value="berkas">berkas</option>
										<option value="lembar">lembar</option>
										<option value="bendel">bendel</option>
										<option value="boks">boks</option>
									</select>
								</div>
								<span id="warning-jnslam" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Berkas</label>
							</div>
							<div class="form-group">
								<div class="col-md-3">&nbsp;</div>
								<div class="col-md-4">
									<button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
									<button type="cancel" id="batal" class="btn btn-default"><i class="fa fa-refresh"></i> Batal</button>
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="box" id="div-und">
					<div class="box-header with-border">
						<h1 class="box-title">Rekam Agenda Rapat</h1>
					</div>
					<form class="form-horizontal" onsubmit="return false" id="form-ruh" name="form-ruh">
						<div class="box-body">
							<div class="form-group">
								<label class="control-label col-md-3">No. Surat Undangan</label>
								<div class="col-md-8">
									<select class="form-control chosen" style="width: 100%;" id="und_nosurat" name="und_nosurat">
										<option value="" style="display:none;">Pilih</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Waktu</label>
								<div class="col-md-2">
									<input type="text" class="form-control" id="und_awal" name="und_awal" placeholder="" />
								</div>
								<label class="control-label col-md-1" style="text-align:center;"> s.d. </label>
								<div class="col-md-2">
									<input type="text" class="form-control" id="und_akhir" name="und_akhir" placeholder="" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Pemimpin</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="und_lead" name="und_lead" placeholder="" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Tempat</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="und_lokasi" name="und_lokasi" placeholder="" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Prioritas</label>
								<div class="col-md-2">
									<select class="form-control chosen" style="width: 100%;" id="und_prio" name="und_prio">
										<option value="" style="display:none;">Pilih</option>
										<option value="1">Penting</option>
										<option value="2">Sangat Penting</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Agenda Pembahasan</label>
								<div class="col-md-8">
									<input type="text" class="form-control" id="und_agenda" name="und_agenda" placeholder="" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Penanggung Jawab</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="und_pj" name="und_pj" placeholder="" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">&nbsp;</div>
								<div class="col-md-4">
									<button type="submit" id="und_submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
									<button type="cancel" id="und_batal" class="btn btn-default"><i class="fa fa-refresh"></i> Batal</button>
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="box" id="div-tabel">
					<div class="box-header with-border">
						<h1 class="box-title">Tabel</h1>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>
jQuery(document).ready(function(){

	jQuery('#lampiran').val('9');

	// tampilan default
	function form_default(){
		jQuery('#lampiran').val(0);
		jQuery('#div-ruh,#div-in,#div-ex,#div-und').hide();
		jQuery('#div-tabel').show();
		jQuery('#nosurat,#tglsurat,#perihal,#dari,#lampiran').val('');
		jQuery('.chosen').val('').trigger('chosen:updated');
	}

	//~ form_default();
	
	jQuery('#tglsurat').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayBtn: true,
		todayHighlight: true,
	});
	
	jQuery('.chosen').chosen({width:'100%'});

	jQuery('#div-in,#div-ex').hide();

	// pilihan untuk asal surat apakah dari instansi internal atau eksternal DJPb
	jQuery('#inex').change(function(){
		var inex = jQuery(this).val();
		if(inex == 'in') {
			jQuery('#div-in').show();
			jQuery('#div-ex').hide();

			jQuery.get('opsi/unit-lengkap', function(result){
				jQuery('#internal').html(result).trigger('chosen:updated');
			});
		} else if(inex == 'ex') {
			jQuery('#div-in').hide();
			jQuery('#div-ex').show();
		}
	});

	// pilihan untuk jenis surat = surat undangan (7) 
	jQuery.get('opsi/jenis-surat', function(result){
		jQuery('#jnssurat').html(result).trigger('chosen:updated');

		jQuery('#jnssurat').change(function(){
			var jnssurat = jQuery(this).val();

			if(jnssurat == '7') {
				alertify.message('Undangan');
			}
		});
		
	});

	// menampilkan form rekam agenda surat undangan
	function form_undangan(){
		jQuery.get('opsi/undangan', function(result){
			jQuery('#und_nosurat').html(result).trigger('chosen:updated');
		});
		
		jQuery('#div-und').show();
		jQuery('#und_awal,#und_akhir').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
		});
	}

	form_undangan();

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
			//~ alert(data);
			jQuery.ajax({
				url: 'surat-masuk',
				method: 'POST',
				data: data,
				success: function(result){
					if(result.message == 'success') {
						alertify.message('berhasil menyimpan data');
					} else {
						alertify.message(result.message);
					}
					form_default();
				}
			});
		} 
	});
});
</script>
@endsection
