@extends('master')

@section('sidemenu')
					<?php echo $side_menu;?>
@endsection

@section('content')
			<section class="content-header">
				<h3>
					Dokumen
				</h3>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Dokumen</a></li>
					<li class="active">Surat Masuk</li>
				</ol>
			</section>

			<section class="content">
				<div class="box" id="box-ruh">
					<div class="box-header with-border">
						<h3 class="box-title">Form</h3>
					</div>
					<form class="form-horizontal" id="form-ruh" name="form-ruh">
						<div class="box-body">
							<div class="form-group">
								<label class="control-label col-md-2">NIP</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="nip" name="nip" placeholder="NIP" />
								</div>
								<span id="warning-nip" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Nama</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="name" name="name" placeholder="nama" />
								</div>
								<span id="warning-name" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Unit Kerja</label>
								<div class="col-md-4">
									<select class="form-control" style="width: 100%;" id="kdunit" name="kdunit">
										<option value="">Pilih</option>
									</select>
								</div>
								<span id="warning-kdunit" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Eselon</label>
								<div class="col-md-4">
									<select class="form-control" style="width: 100%;" id="eselon" name="eselon">
										<option value="">Pilih</option>
										<option value="11">Eselon I.A</option>
										<option value="12">Eselon I.B</option>
										<option value="21">Eselon II.A</option>
										<option value="22">Eselon II.B</option>
										<option value="31">Eselon III.A</option>
										<option value="32">Eselon III.B</option>
										<option value="41">Eselon IV.A</option>
										<option value="42">Eselon IV.B</option>
										<option value="77">Pejabat Fungsional</option>
										<option value="99">Pelaksana</option>
									</select>
								</div>
								<span id="warning-eselon" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Username</label>
								<div class="col-md-4">
									<input type="text" maxlength="18" class="form-control" id="username" name="username" placeholder="username" />
								</div>
								<span id="warning-username" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Password</label>
								<div class="col-md-4">
									<input type="password" maxlength="18" class="form-control" id="password" name="password" placeholder="password" />
								</div>
								<span id="warning-password" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Konfirmasi Password</label>
								<div class="col-md-4">
									<input type="password" maxlength="18" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="konfirmasi password" />
								</div>
								<span id="warning-password_confirmation" class="label label-danger warning">Required!</span>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Level User</label>
								<div class="col-md-4">
									<select class="form-control" style="width: 100%;" id="kdlevel" name="kdlevel">
										<option value="">Pilih</option>
										<option value="e1">Dirjen</option>
										<option value="e2">Direktur/Kakanwil</option>
										<option value="e3">Kasubdit/Kabag/Kabid/Kepala KPPN</option>
										<option value="e4">Kasi/Kasubbag</option>
										<option value="e7">Fungsional</option>
										<option value="e9">Pelaksana</option>
									</select>
								</div>
								<span id="warning-kdlevel" class="label label-danger warning">Required!</span>
							</div>
							<hr/>
							<div class="form-group">
								<label class="control-label col-md-2">&nbsp;</label>
								<div class="col-md-4">
									<button title="cancel" class="btn btn-default"><i class="fa fa-refresh"></i> Cancel</button>
									<button title="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
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
