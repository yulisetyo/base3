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
					<input type="hidden" class="form-control" id="baseurl" name="baseurl" value{{ $baseurl }} />
				</ol>
			</section>

			<section class="content">

				<?php echo $rekam_surat; ?>

				<div class="box" id="div-tabel">
					<div class="box-header with-border">
						<div id="segarkan1" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i> </div>
						<h1 class="box-title"><small>Surat Masuk Belum Disposisi</small></h1>
					</div>
					<div class="box-body"><small>
						<table class="table table-condensed table-striped table-hover" id="tabel-inbox" style="font-size:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>No. & Tgl. Surat</th>
									<th>Asal & Perihal</th>
									<th>Keterangan</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table></small>
					</div>
				</div>

				<div class="box">
					<div class="box-header" id="div-tabel-dua">
						<div id="segarkan2" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i> </div>
						<h1 class="box-title"><small>Surat Masuk Dari Atasan Yang Belum Di Disposisi</small></h1>
					</div>
					<div class="box-body"><small>
						<table class="table table-condensed table-striped table-hover" id="tabel-inbox-dua" style="font-size:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>No. & Tgl. Surat</th>
									<th>Asal & Perihal</th>
									<th>Keterangan</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table></small>
					</div>
				</div>
					
			</section>

<script>
jQuery(document).ready(function(){

	var baseurl = jQuery('#baseurl').val();
	
	// tampilan default
	function form_default(){
		jQuery('#div-tabel').show();
	}

	form_default();
	
	// untuk menampilkan form perekaman data
	jQuery('#tambah').click(function(){
		var baseurl = jQuery('#baseurl').val();
		window.location.replace('./surat-masuk/rekam');
	});

	//data surat masuk
	function dataSuratMasuk() {
		jQuery('#tabel-inbox').DataTable().destroy();
		jQuery('#tabel-inbox').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords:	"Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				//~ emptyTable: "Data tidak ditemukan..",
				paginate: {
					previous: "Sebelumnya",
					next: "Selanjutnya",
				},
			},
			paging: true,
			searching: false,
			lengthChange: false,
			info: true,
			pageLength: 10,
			autoWidth: false,
			serverSide: true,
			ajax : "surat-masuk/tabel",
			columns: [
				{data:'no', name:'ref', orderable: false, width: "5%"},
				{data:'no_tgl', name:'ref', orderable: false, width: "18%"},
				{data:'asal_isi', name:'subject', orderable: false},
				{data:'aksi', name:'aksi', orderable: false, width: "17%"},
			]
		});	
	}
	
	dataSuratMasuk();

	function dataSuratMasukDua() {
		jQuery('#tabel-inbox-dua').DataTable().destroy();
		jQuery('#tabel-inbox-dua').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords:	"Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				//~ emptyTable: "Data tidak ditemukan..",
				paginate: {
					previous: "Sebelumnya",
					next: "Selanjutnya",
				},
			},
			paging: true,
			searching: false,
			lengthChange: false,
			info: true,
			pageLength: 10,
			autoWidth: false,
			serverSide: true,
			ajax : "surat-masuk/tabel2",
			columns: [
				{data:'no', name:'ref', orderable: false, width: "5%"},
				{data:'no_tgl', name:'ref', orderable: false, width: "18%"},
				{data:'asal_isi', name:'subject', orderable: false},
				{data:'aksi', name:'aksi', orderable: false, width: "17%"},
			]
		});	
	}
	
	dataSuratMasukDua();

	jQuery('#segarkan1').click(function(){
		dataSuratMasuk();
	});
	
	jQuery('#segarkan2').click(function(){
		dataSuratMasukDua();
	});

	jQuery('body').off('click', '.pinned').on('click', '.pinned', function(){
		var hash = this.id;
		jQuery.get('token', function(token){
			var data = 'hash='+hash+'&_token='+token;
			jQuery.post('surat-masuk/pinned', data, function(response){
				dataSuratMasuk();
			});
		});
	});

	jQuery('body').off('click', '.unpinned').on('click', '.unpinned', function(){
		var hash = this.id;
		jQuery.get('token', function(token){
			var data = 'hash='+hash+'&_token='+token;
			jQuery.post('surat-masuk/unpinned', data, function(response){
				dataSuratMasuk();
			});
		});
	});
	
});
</script>

@endsection
