jQuery(document).ready(function(){
	
	jQuery('.warning, #div-row-form, #ruh-sm-semua-rekam, #ruh-sm-semua-forward, #ruh-sm-semua-disposisi').hide();
	
	//mengaktifkan chosen-select untuk dropdown
	jQuery('.chosen-select').chosen({width:'100%'});
	
	
	//get token
	jQuery.extend({
		getValues: function(url){
			var result = null;
			jQuery.ajax({
				url: url,
				method: 'GET',
				async: false,
				success: function(data){
					result = data;
				}
			});
			
			return result;
		}
	});
	
	var token1 = jQuery.getValues('./../token');

	
	//dropdown unit pengirim surat
	jQuery.get('./../unit/dd-unit/xxx', function(unit){
		jQuery('#dari_unit').html(unit).trigger('chosen:updated');
		
		jQuery('#dari_unit').change(function(){
			var unit = jQuery(this).val();
			jQuery.getJSON('unit/json-unit/'+unit, function(result){
				if(result) {
					if(result.id_unit != '0000000000'){
						jQuery('#instansi').val(result.nm_unit);
					}  else {
						jQuery('#instansi').val('');
					} 
				} 
			});
		});
	});
	
	
	//dropdown referensi jenis surat
	jQuery.get('./../referensi/jns-surat', function(result){
		jQuery('#jnssurat').html(result).trigger('chosen:updated');
	});
	

	//form default
	function formDefault(){
		jQuery('.warning, #div-row-form, #ruh-sm-semua-rekam, #ruh-sm-semua-forward, #ruh-sm-semua-disposisi').hide();
		jQuery('#div-row-tab,#tabel-sm-semua, #tambah').show();
		jQuery('input').val('');
		jQuery('#dari_unit').val('').trigger('chosen:updated');
		jQuery('#jnssurat').val('').trigger('chosen:updated');
		jQuery('#klasifikasi').val('biasa').trigger('chosen:updated');
		jQuery('#kualifikasi').val('biasa').trigger('chosen:updated');
		jQuery('#stssurat').val('asli').trigger('chosen:updated');
		jQuery('#jnslampiran').val('lembar').trigger('chosen:updated');
		jQuery('#jmllampiran').val(0);
		jQuery('#perihal').val('');
		// jQuery('.chosen-select').val('').trigger('chosen:updated');
	}
	
	formDefault();
	
	
	//form untuk validasi
	function formValid(str_id){
		var arr_id = str_id.split(',');
		var next = true;
		
		for(x = 0; x < arr_id.length; x++){
			if(jQuery('#'+arr_id[x]).val() == ''){
				jQuery('#warning-'+arr_id[x]).show();
				next = false;
			}
		}
		
		return next;
	}
	
	//datatable surat masuk dari perekaman sekretaris
	function dataTableInp() {
		jQuery('#tabel-data-sm-dari-rekam').DataTable().destroy();
		jQuery('#tabel-data-sm-dari-rekam').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian ",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				loadingRecords:	"Memuat data..",
				zeroRecords: "Tidak ada data",
				emptyTable: "Tabel kosong",
				paginate: {
					previous: "Sebelumnya",
					next: "Selanjutnya",
				},
			},
			paging: true,
			searching: false,
			lengthChange: false,
			info: true,
			pageLength: 50,
			autoWidth: false,
			serverSide: true,
			ajax : "./../suratmasuk/tabel/inp",
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});	
	}
	// datatable semua surat masuk
	dataTableInp();
	/*
	//datatable semua surat masuk
	function dataTableAll() {
		jQuery('#tabel-data-sm-semua').DataTable().destroy();
		jQuery('#tabel-data-sm-semua').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian ",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				loadingRecords:	"Memuat data..",
				zeroRecords: "Tidak ada data",
				emptyTable: "Tabel kosong",
				paginate: {
					previous: "Sebelumnya",
					next: "Selanjutnya",
				},
			},
			paging: true,
			searching: false,
			lengthChange: false,
			info: true,
			pageLength: 50,
			autoWidth: false,
			serverSide: true,
			ajax : "suratmasuk/tabel/all?tipe=all",
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});	
	}
	// datatable semua surat masuk
	dataTableAll();
	
	//datatable undangan
	function dataTableUnd() {
		jQuery('#tabel-data-sm-undangan').DataTable().destroy();
		jQuery('#tabel-data-sm-undangan').DataTable({
			language: {
				processing: "Sedang proses...",
				search: "Pencarian ",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				loadingRecords: "Memuat data..",
				zeroRecords: "Tidak ada data",
				emptyTable: "Tabel kosong",
				paginate: {
					previous: "Sebelumnya",
					next: "Selanjutnya",
				},
			},
			paging: true,
			searching: false,
			lengthChange: false,
			info: true,
			pageLength: 50,
			autoWidth: false,
			serverSide: true,
			ajax : "suratmasuk/tabel/all?tipe=und",
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});
	}
	// datatable non-undangan
	dataTableUnd();
	
	//datatable non-undangan
	function dataTableNon() {
			jQuery('#tabel-data-sm-non-undangan').DataTable().destroy();
			jQuery('#tabel-data-sm-non-undangan').DataTable({
			language: {
				processing: "Sedang proses...",
				search: "Pencarian ",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				loadingRecords: "Memuat data..",
				zeroRecords: "Tidak ada data",
				emptyTable: "Tabel kosong",
				paginate: {
					previous: "Sebelumnya",
					next: "Selanjutnya",
				},
			},
			paging: true,
			searching: false,
			lengthChange: false,
			info: true,
			pageLength: 50,
			autoWidth: false,
			serverSide: true,
			ajax : "suratmasuk/tabel/all?tipe=non",
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});
	}
	// datatable non-undangan
	dataTableNon();
	*/
	
	// datepicker
	jQuery('#tglsurat').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd',
		todayBtn: true,
		todayHighlight: true,
	});
	
	
	//upload hasil scan dokumen surat masuk
	jQuery('#fileupload').click(function(){
		jQuery('#progress .progress-bar').css('width', 0);
		jQuery('#progress .progress-bar').html('');
		jQuery('#nmfile').html('');
	});
	
	jQuery('#fileupload').fileupload({
		url:'./../suratmasuk/upload-hc',
		dataType: 'json',
		method: 'post',
		formData: {_token: token1},
		done: function(e, data) {
			jQuery('#nmfile').html(data.files[0].name);
			alertify.message('Upload file '+data.files[0].name+' berhasil!');
		},
		error: function(error) {
			alertify.message(error.responseText);
		},
		progressall: function(e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			jQuery('#progress .progress-bar').css('width', progress + '%');
		}			
	}).prop('disabled', !$.support.fileInput)
	  .parent().addClass($.support.fileInput ? undefined : 'disabled');
	
	
	//mengaktifkan form perekaman surat masuk
	jQuery('#tambah').click(function(){
		jQuery(this).hide();
		jQuery('#div-row-tab, #form-ruh-sm-semua-disposisi, #form-ruh-sm-semua-forward, #tabel-sm-semua').hide();
		jQuery('#div-row-form, #ruh-sm-semua-rekam').fadeIn();
	});
	
	
	//proses simpan perekaman surat
	jQuery('#btn-simpan-rekam').click(function(){
		var data = jQuery('#form-ruh-sm-semua').serialize();
		var next = formValid('nosurat,tglsurat,dari_unit,instansi,klasifikasi,kualifikasi,jnssurat,stssurat,jmllampiran,jnslampiran,perihal');
		
		if(next == true) {
			jQuery.ajax({
				url: './../suratmasuk/ruh?_token='+token1,
				method: 'post',
				data: data,
				success: function(resp){
					if(resp == 'success'){
						formDefault();
						dataTableAll();
						alertify.message('berhasil menyimpan surat masuk');
					}
				},
				error: function(e){
					alertify.error(e);
				}
			});
		} else {
			alertify.alert('eOffice','isian belum lengkap!');
		}
	});
	
	
	//proses pembatalan perekaman surat
	jQuery('#btn-batal-rekam').click(function(){
		formDefault();
		alertify.message('batal simpan surat');
	});
	
	
	//proses simpan surat undangan
	jQuery('#btn-und-rekam').click(function(){
		var dataund = jQuery('#form-ruh-sm-undangan').serialize();
		var next = formValid('mailid,undtgl,undawal,undakhir,undtempat,undpimpin,undagenda');
		
		if(next == true) {
			jQuery.ajax({
				url: '',
				method: 'POST',
				data: data,
				success: function(resp){
					formDefault();
				},
				error: function(e){
					
				},
			});
		}
	});
	
	
	//proses pembatalan simpan surat undangan
	
	
	//proses push surat kepada atasan
	jQuery('body').off('click', '.push').on('click', '.push', function(){
		// formDefault();
		var hash = this.id;
		alertify.confirm('Konfirmasi', 'Apakah surat ini akan di push kepada atasan?', 
			function(){
				jQuery.ajax({
					url: './../suratmasuk/push?_token='+token1,
					method: 'post',
					data: {hash: hash},
					success: function(resp){
						if(resp == 'success'){
							dataTableInp();
							alertify.message('Surat telah di push ke atasan');
						}
					},
				});
			}, 
			function(){
				alertify.message('Surat batal di push ke atasan')
			}
		);
	});
	
	
	//lihat isi detil surat
	jQuery('body').off('click', '.detilsurat').on('click', '.detilsurat', function(){
		var param = this.id;
		jQuery.get('./../suratmasuk/detil/'+param, function(result) {			
			alertify.alert('Detil Surat', result, function(){});
		});
	});
	
	
	//mengaktifkan form disposisi
	jQuery('body').off('click', '.disposisi').on('click', '.disposisi', function(){
		jQuery('#div-row-tab, #tabel-sm-semua').hide();
		jQuery('#div-row-form, #ruh-sm-semua-disposisi').show();
	});
	
	
	//pembatalan disposisi surat
	jQuery('#btn-batal-disp').click(function(){
		formDefault();
		alertify.error('batal disposisi surat');
	});
	
	
	//proses simpan disposisi surat
	jQuery('#btn-simpan-disp').click(function(){
		formDefault();
		alertify.message('proses disposisi surat');
	});
	
	
	//mengaktifkan form penerusan surat
	jQuery('body').off('click', '.teruskan').on('click', '.teruskan', function(){
		var hash = this.id;
		jQuery('#div-row-tab, #tabel-sm-semua').hide();
		jQuery('#div-row-form, #ruh-sm-semua-forward').show();
	});
	
	//pembatalan penerusan surat
	jQuery('#btn-batal-fwd').click(function(){
		formDefault();
		alertify.error('batal meneruskan surat');
	});
});