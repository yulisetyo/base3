@extends('master')

@section('sidemenu')
					<?php echo $side_menu;?>
@endsection

@section('content')
			<section class="content-header">
				<h1>
					Dokumen
					<small>Surat Masuk</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Dokumen</a></li>
					<li class="active">Surat Masuk</li>
				</ol>
			</section>

			<section class="content">
				<div class="box box-ruh">
					<div class="box-header with-border">
						<h3 class="box-title">
							Rekam Surat Masuk
						</h3>
					</div>
					<form class="form-horizontal">
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
									<input type="text" class="form-control" id="tglsurat" name="tglsurat" />
								</div>
								<span id="warning-tglsurat" class="label label-danger warning">Required!</span>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-2">Asal Instansi</label>
								<div class="col-md-6">
									<select class="form-control chosen" style="width: 100%;" id="dari" name="dari">
										<option value="" style="display:none;">Pilih</option>
									</select>
								</div>
								<span id="warning-tglsurat" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Jenis Surat</label>
								<div class="col-md-3">
									<select class="form-control chosen" style="width: 100%;" id="jnsurat" name="eselon">
										<option value="" style="display:none;">Pilih</option>
									</select>
								</div>
								<span id="warning-tglsurat" class="label label-danger warning">Required!</span>
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
								<div class="col-md-2">
									<select class="form-control chosen" style="width: 100%;" id="kualifikasi" name="kualifikasi">
										<option value="" style="display:none;">Pilih</option>
										<option value="biasa">Biasa</option>
										<option value="segera">Segera</option>
										<option value="sangat_segera">Sangat Segera</option>
									</select>
								</div>
								<span id="warning-tglsurat" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Lampiran</label>
								<div class="col-md-2">
									<input type="text" class="form-control" id="lampiran" name="lampiran" style="text-align:right;" />
								</div>
								<div class="col-md-3">
									<select class="form-control chosen" style="width: 100%;" id="jnslampiran" name="jnslampiran">
										<option value="" style="display:none;">Pilih</option>
										<option value="berkas">berkas</option>
										<option value="lembar">lembar</option>
										<option value="bendel">bendel</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Berkas</label>
							</div>
							<div class="form-group">
								<div class="col-md-2">&nbsp;</div>
								<div class="col-md-2">
									<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Proses</button>
									<button type="cancel" class="btn btn-default"><i class="fa fa-refreh"></i> Batal</button>
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="box" id="box-tabel">
					<div class="box-header with-border">
						<h3 class="box-title">Tabel</h3>
					</div>
					<div class="box-body">
						<table class="table" id="tabel-ruh">
							<thead>
								<tr>
									<th>#</th>
									<th>NIP</th>
									<th>Nama</th>
									<th>Unit Kerja</th>
									<th>Level</th>
									<th>Username</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>196405121985031001</td>
									<td>Mukidi</td>
									<td>Sekretariat Direktorat Jenderal</td>
									<td>Pengguna</td>
									<td>mukidi</td>
									<td>
										<div title="update profil" class="btn btn-xs btn-primary"><i class="fa fa-refresh"></i>U </div>
										<div title="reset password" class="btn btn-xs btn-default"><i class="fa fa-refresh"></i>R </div>
										<div title="delete user" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i>X </div>
									</td>
								</tr>
								<tr>
									<td>2</td>
									<td>197802161999121002</td>
									<td>Valentino Rossi</td>
									<td>Direktorat Sistem Informasi dan Teknologi Perbendaharaan</td>
									<td>Pengguna</td>
									<td>vr46</td>
									<td>
										<div title="update profil" class="btn btn-xs btn-primary"><i class="fa fa-refresh"></i>U </div>
										<div title="reset password" class="btn btn-xs btn-default"><i class="fa fa-refresh"></i>R </div>
										<div title="delete user" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i>X </div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>					
				</div>
			</section>

<script>
jQuery(document).ready(function(){
	function form_default(){
		jQuery('#box-ruh').hide();
		jQuery('#box-tabel').show();
	}

	//~ form_default();

	jQuery('#tambah').click(function(){
		jQuery('#box-ruh').show();
		jQuery('#box-tabel').hide();
	});
});
</script>
@endsection
