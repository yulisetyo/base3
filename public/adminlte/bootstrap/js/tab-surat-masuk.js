jQuery(document).ready(function(){
	
	//form default
	function formDefault(){
		localStorage.removeItem('nosurat');
		localStorage.removeItem('mailtype');
		// jQuery('.warning, #div-row-form, #ruh-sm-semua-rekam, #ruh-sm-semua-forward, #ruh-sm-semua-disposisi').hide();
		jQuery('.warning, #ruh-sm-semua-rekam, #ruh-sm-semua-forward, #ruh-sm-semua-disposisi').hide();
		jQuery('#ruh-sm-undangan-rekam').hide();
		jQuery('#div-row-tab, #tabel-sm-semua, #tambah, #box-ruh-surat-masuk').show();
		jQuery('input').val('');
		jQuery('#dari_unit').val('').trigger('chosen:updated');
		jQuery('#jnssurat').val('').trigger('chosen:updated');
		jQuery('#klasifikasi').val('biasa').trigger('chosen:updated');
		jQuery('#kualifikasi').val('biasa').trigger('chosen:updated');
		jQuery('#stssurat').val('asli').trigger('chosen:updated');
		jQuery('#jnslampiran').val('lembar').trigger('chosen:updated');
		// jQuery('#jmllampiran').val(0);
		jQuery('#perihal,#undtgl,#undtempat,#undagenda').val('');
		jQuery('#undawal,#undakhir').val('08:00:00').trigger('chosen:updated');
		// jQuery.get('./unit/chk-unit', function(result){
			// jQuery('#disp-unit').html(result);
		// });
		jQuery('#disp-sifat').val('biasa').trigger('chosen:updated');
		jQuery('#disp-mailid,disp-no-surat').val('');
		jQuery('.cekunit,.cekdisp').prop('checked', false);
		jQuery("#fwd-kepada").val('').trigger('chosen:updated');
		jQuery('#box-catatan').hide();
	}
	
	formDefault();
	
	// jQuery('.warning, #div-row-form, #ruh-sm-semua-rekam, #ruh-sm-semua-forward, #ruh-sm-semua-disposisi').hide();
	
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
	// var baseurl = jQuery(".baseurl").val();
	var token1 = jQuery.getValues('token');
	
	//dropdown unit pengirim surat
	jQuery.get('unit/dd-unit/xxx', function(unit){
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
	jQuery.get('referensi/jns-surat', function(result){
		jQuery('#jnssurat').html(result).trigger('chosen:updated');
		
		jQuery('#jnssurat').change(function(){
			var jnssurat = jQuery(this).val();
			// localStorage.removeItem('mailtype');
			// localStorage.setItem('mailtype', jnssurat);
			
			//if(jnssurat == '7'){
				//jQuery('#ruh-sm-undangan-rekam').show();
			//} else{
				//jQuery('#ruh-sm-undangan-rekam').hide();
				//jQuery('#undtgl,#undawal,#undakhir,#undtempat,#undagenda').val('');
			//}
		});
	});
	
	jQuery.get('referensi/jam-rapat', function(jamrapat){
		jQuery('#undawal, #undakhir').html(jamrapat).trigger('chosen:updated');
	});
	
	
	jQuery('#nosurat').focusout(function(){
		var nosurat = jQuery(this).val();
		
		//localStorage.removeItem('nosurat');
		//localStorage.setItem('nosurat', nosurat);
	});
	
	
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
	
	
	jQuery("#li-inp").click(function(){
		dataTableRUH();
	});
	
	jQuery("#li-all").click(function(){
		dataTableAll();
		dataTableAllDisp();
	});
	
	jQuery("#li-und").click(function(){
		dataTableUnd();
		dataTableUndDisp();
	});
	
	jQuery("#li-non").click(function(){
		dataTableNon();
		dataTableNonDisp();
	});
	
	jQuery("#li-fol").click(function(){
		dataTableFollow();
		dataTableFollowDisp();
		// alertify.error('follow-underconstruction');
	});
	
	jQuery("#li-pin").click(function(){
		dataTablePinned();
		dataTablePinnedDisp();
		// alertify.error('pinned-underconstruction');
	});
	
	jQuery("#li-plh").click(function(){
		dataTablePlh();
		dataTablePlhDisp();
		// alertify.error('plhplt-underconstruction');
	});
	
	jQuery("#li-agd").click(function(){
		alertify.error('agenda-underconstruction');
	});
	
	
	//datatable surat masuk yang di rekam sekretaris
	function dataTableRUH() {
		jQuery('#tabel-ruh-surat-masuk').DataTable().destroy();
		jQuery('#tabel-ruh-surat-masuk').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords:	"Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/tabel/ruh?_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});	
	}
	// datatable semua surat masuk
	// dataTableRUH();
	
	//datatable semua surat masuk di inbox sekretaris
	function dataTableInp() {
		jQuery('#tabel-data-sm-dari-rekam').DataTable().destroy();
		jQuery('#tabel-data-sm-dari-rekam').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords:	"Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/tabel/inp&_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});	
	}
	// datatable semua surat masuk
	//dataTableInp();
	
	//datatable semua surat masuk
	function dataTableAll() {
		jQuery('#tabel-data-sm-semua').DataTable().destroy();
		jQuery('#tabel-data-sm-semua').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords:	"Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/datatabel/all?tipe=all&_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});	
	}
	// datatable semua surat masuk
	dataTableAll();
	
	//datatable semua surat masuk sudah disposisi
	function dataTableAllDisp() {
		jQuery('#tabel-data-sm-semua-disp').DataTable().destroy();
		jQuery('#tabel-data-sm-semua-disp').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords:	"Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/datatabel/all-disp?tipe=all&_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});	
	}
	// datatable semua surat masuk
	dataTableAllDisp();
	
	
	//datatable undangan belum disposisi
	function dataTableUnd() {
		jQuery('#tabel-data-sm-undangan').DataTable().destroy();
		jQuery('#tabel-data-sm-undangan').DataTable({
			language: {
				processing: "Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords: "Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/datatabel/all?tipe=und&_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});
	}
	// datatable undangan belum disposisi
	// dataTableUnd();
	
	
	//datatable undangan sudah disposisi
	function dataTableUndDisp() {
		jQuery('#tabel-data-sm-undangan-disp').DataTable().destroy();
		jQuery('#tabel-data-sm-undangan-disp').DataTable({
			language: {
				processing: "Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords: "Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/datatabel/all-disp?tipe=und&_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});
	}
	// datatable undangan sudah disposisi
	// dataTableUndDisp();
	
	
	//datatable non-undangan belum disposisi
	function dataTableNon() {
		jQuery('#tabel-data-sm-non-undangan').DataTable().destroy();
		jQuery('#tabel-data-sm-non-undangan').DataTable({
			language: {
				processing: "Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords: "Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/datatabel/all?tipe=non&_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});
	}
	// datatable non-undangan belum disposisi
	//dataTableNon();
	
	
	//datatable non-undangan sudah disposisi
	function dataTableNonDisp() {
		jQuery('#tabel-data-sm-non-undangan-disp').DataTable().destroy();
		jQuery('#tabel-data-sm-non-undangan-disp').DataTable({
			language: {
				processing: "Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords: "Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/datatabel/all-disp?tipe=non&_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});
	}
	// datatable non-undangan sudah disposisi
	//dataTableNonDisp();
	
	
	//datatable semua surat masuk yang di follow (di beri komentar/catatan)
	function dataTableFollow() {
		jQuery('#tabel-data-sm-follow').DataTable().destroy();
		jQuery('#tabel-data-sm-follow').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords:	"Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/datatabel/all?tipe=all&tab=fol&_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});	
	}
	// datatable semua surat masuk follow belum disposisi
	//dataTableFollow();


	//datatable semua surat masuk yang di follow (di beri komentar/catatan)
	function dataTableFollowDisp() {
		jQuery('#tabel-data-sm-follow-disp').DataTable().destroy();
		jQuery('#tabel-data-sm-follow-disp').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords:	"Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/datatabel/all-disp?tipe=all&tab=fol&_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});	
	}
	// datatable semua surat masuk
	//dataTableFollowDisp();
	
	
	//datatable semua surat masuk yang di pinned (di beri pin)
	function dataTablePinned() {
		jQuery('#tabel-data-sm-pinned').DataTable().destroy();
		jQuery('#tabel-data-sm-pinned').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords:	"Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/datatabel/all?tipe=all&tab=pin&_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});	
	}
	// datatable semua surat masuk pinned belum disposisi
	//dataTablePinned();
	
	
	//datatable semua surat masuk yang di pinned (di beri pin)
	function dataTablePinnedDisp() {
		jQuery('#tabel-data-sm-pinned-disp').DataTable().destroy();
		jQuery('#tabel-data-sm-pinned-disp').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords:	"Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/datatabel/all-disp?tipe=all&tab=pin&_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});	
	}
	// datatable semua surat masuk pinned belum disposisi
	//dataTablePinnedDisp();
	
	
	//datatable semua surat masuk yang di pinned (di beri pin)
	function dataTablePlh() {
		jQuery('#tabel-data-sm-plh').DataTable().destroy();
		jQuery('#tabel-data-sm-plh').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords:	"Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/datatabel/all?tipe=plh&_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});	
	}
	// datatable semua surat masuk pinned belum disposisi
	//dataTablePlh();
	
	
	//datatable semua surat masuk yang di pinned (di beri pin)
	function dataTablePlhDisp() {
		jQuery('#tabel-data-sm-plh-disp').DataTable().destroy();
		jQuery('#tabel-data-sm-plh-disp').DataTable({
			language: {
				processing:	"Sedang proses...",
				search: "Pencarian :",
				lengthMenu: "Tayangkan _MENU_ baris",
				info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
				infoEmpty: "Menampilkan 0 to 0 of 0 data",
				loadingRecords:	"Memuat data..",
				zeroRecords: '<div style="text-align:center;"><big>Tidak ada data</big><div>',
				// emptyTable: "Tabel kosong",
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
			ajax : "suratmasuk/datatabel/all-disp?tipe=plh&_token="+token1,
			columns: [
				{data:'ref', name:'ref', orderable: false, width: "14%"},
				{data:'subject', name:'subject', orderable: true},
				{data:'aksi', name:'aksi', orderable: false, width: "12%"},
			]
		});	
	}
	// datatable semua surat masuk pinned belum disposisi
	//dataTablePlhDisp();
	
	// datepicker
	jQuery('#tglsurat,#undtgl,#tgl_surat_non,#tgl_surat_und,#tgl_surat_all,#tgl_surat_fol,#tgl_surat_pin,#tgl_surat_plh').datepicker({
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
		url:'suratmasuk/upload-hc',
		dataType: 'json',
		method: 'post',
		formData: { _token: token1, mailref: localStorage.getItem('nosurat') },
		done: function(e, data) {
			jQuery('#nmfile').html(data.files[0].name);
			alertify.message('Upload file '+data.files[0].name+' berhasil!');
			localStorage.removeItem('nosurat');
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
		// jQuery('#div-row-tab, #form-ruh-sm-semua-disposisi, #form-ruh-sm-semua-forward, #tabel-sm-semua').hide();
		jQuery('#form-ruh-sm-semua-disposisi, #form-ruh-sm-semua-forward, #box-ruh-surat-masuk').hide();
		// jQuery('#div-row-form, #ruh-sm-semua-rekam').fadeIn();
		jQuery('#ruh-sm-semua-rekam, #div-row-form').fadeIn();
	});
	
	
	//proses simpan perekaman surat
	jQuery('#btn-simpan-rekam').click(function(){
		var data = jQuery('#form-ruh-sm-semua').serialize();
		var jnssurat = jQuery('#jnssurat').val();

		var next = formValid('nosurat,tglsurat,dari_unit,instansi,klasifikasi,kualifikasi,jnssurat,stssurat,jmllampiran,jnslampiran,perihal');
		
		if( next == true ) {
			jQuery.ajax({
				url: 'suratmasuk/ruh?_token='+token1,
				method: 'post',
				data: data,
				success: function(resp){
					if(resp.message == 'success'){
						formDefault();
						dataTableRUH();
						alertify.message('berhasil menyimpan surat masuk');
						if(resp.mailtype == '7') {
							jQuery('#ruh-sm-undangan-rekam').show();
						} else {
							jQuery('#ruh-sm-undangan-rekam').hide();
						}
						jQuery('#mailid').val(resp.mailid);
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
	jQuery('#btn-rekam-und').click(function(){
		var data = jQuery('#form-ruh-sm-undangan').serialize();
		var next = formValid('undtgl,undawal,undakhir,undtempat,undpimpin,undagenda');
		
		if(next == true){
			jQuery.ajax({
				url: 'suratmasuk/ruh/und?_token='+token1,
				method: 'post',
				data: data,
				success: function(resp){
					if(resp){
						formDefault();
						dataTableRUH();
						alertify.message('Berhasil menyimpan undangan');
					}
				},
				error: function(e){
					alertify.error(e);
				}
			});
		}
	});
	
	
	//proses pembatalan perekaman undangan
	jQuery('#btn-batal-und').click(function(){
		formDefault();
		alertify.message('batal simpan surat');
	});
	
	
	//proses push surat kepada atasan
	jQuery('body').off('click', '.push').on('click', '.push', function(){
		// formDefault();
		var hash = this.id;
		alertify.confirm('Konfirmasi', 'Apakah surat ini akan di push kepada atasan?', 
			function(){
				jQuery.ajax({
					url: 'suratmasuk/push?_token='+token1,
					method: 'post',
					data: {hash: hash},
					success: function(resp){
						if(resp == 'success'){
							dataTableRUH();
							alertify.message('Surat telah di push ke atasan');
						}
					},
				});
			}, 
			function(){
				alertify.message('Surat tidak jadi di push ke atasan');
			}
		);
	});
	
	
	//lihat isi detil surat
	jQuery('body').off('click', '.detilsurat').on('click', '.detilsurat', function(){
		var param = this.id;
		jQuery.get('suratmasuk/detil/'+param, function(result) {			
			// alertify.alert('Detil Surat', result, function(){});
			//window.open('./suratmasuk/detil/'+param, '_blank');
			jQuery('#box-catatan').hide();
		});
	});	
	
	
	//pinned surat
	jQuery('body').off('click', '.pinned').on('click', '.pinned', function(){
		var param = this.id;
		jQuery.get('suratmasuk/pinned/'+param, function(result) {			
			// alertify.alert('Detil Surat', result, function(){});
			//window.open('./suratmasuk/detil/'+param, '_blank');
			jQuery('#box-catatan').hide();
		});
	});
	
	/*
	//beri catatan
	jQuery("#beri_catatan").click(function(){
		jQuery("#box-catatan").show();
	});
	
	
	//simpan catatan
	jQuery("#simpan_komentar").click(function(){
		var data = jQuery("#form-komentar").serialize();
		
		if(jQuery("#dok_note").val==("")){
			alertify.alert("eoffice","Anda belum menuliskan catatan!");
		} else {
			jQuery.ajax({
				url: 'suratmasuk/catatan?_token='+token1,
				method: 'post',
				data: {hash: hash},
				success: function(resp){
					if(resp == 'success'){
						jQuery("#box-catatan").hide();
						jQuery("#dok_note").val("");
						dataTableRUH();
						alertify.message('Catatan surat telah di simpan');
					}
				},
			});
		}
	});
	
	
	//mengaktifkan form disposisi
	jQuery('body').off('click', '.disposisi').on('click', '.disposisi', function(){
		var hash = this.id;
		jQuery('#div-row-tab, #tabel-sm-semua').hide();
		jQuery('#div-row-form, #ruh-sm-semua-disposisi').show();
		jQuery.getJSON('suratmasuk/ruh/'+hash, function(result){
			jQuery('#disp-mailid').val(result.id);
			jQuery('#disp-no-surat').val(result.ref);
		});
		jQuery.get('./unit/chk-unit', function(result){
			jQuery('#disp-unit').html(result);
		});
	});
	
	
	//pembatalan disposisi surat
	jQuery('#btn-batal-disp').click(function(){
		formDefault();
		jQuery('.cekunit').prop('checked', false);
		jQuery('.cekdisp').prop('checked', false);
		// alertify.error('batal disposisi surat');
	});
	
	//value untuk unit penerima disposisi
	function getValueUnit(){
		var chkUnit = [];
		
		jQuery(".chkunit:checked").each(function(){
			chkUnit.push(this.id);
		});
		
		var unitTerpilih;
		unitTerpilih = chkUnit.join(',');
		
		if(unitTerpilih.length > 0){
			jQuery("#disp-kepada-unit").val(unitTerpilih);
		} else {
			alertify.alert("eoffice","Anda belum memilih unit tujuan disposisi");
		}
	}
	
	//value untuk disposisi
	function getValueDisposisi(){
		var chkInstruksi = [];
		
		jQuery(".cekdisp:checked").each(function(){
			chkInstruksi.push(this.id);
		});
		
		var instruksiTerpilih;
		instruksiTerpilih = chkInstruksi.join(',');
		
		if(instruksiTerpilih.length > 0){
			jQuery('#disp-value').val(instruksiTerpilih);
		} else {
			alertify.alert("eoffice","Anda belum memilih instruksi disposisi");
		}
	}
	
	//proses simpan disposisi surat
	jQuery('#btn-proses-disp').click(function(){
		getValueDisposisi();
		getValueUnit();
		var data = jQuery('#form-disposisi').serialize();	
		
		var next = formValid('disp-no-surat,disp-sifat,disp-kepada-unit,disp-value');
		
		if(next == true) {
			jQuery.ajax({
				url: 'suratmasuk/disp?_token='+token1,
				method: 'POST',
				data: data,
				success: function(resp){
					if(resp == 'success'){
						formDefault();
						alertify.message('surat telah di disposisi');
					}
				},
				error: function(e){
					alertify.error(e);
				}
			});
		}
	});
	*/
	/*
	//mengaktifkan form penerusan surat
	jQuery('body').off('click', '.teruskan').on('click', '.teruskan', function(){
		var hash = this.id;
		jQuery('#div-row-tab, #tabel-sm-semua').hide();
		jQuery('#div-row-form, #ruh-sm-semua-forward').show();
		jQuery.get('./unit/chk-unit-fwd', function(result){
			jQuery('#fwd-kepada').html(result).trigger('chosen:updated');
		});
		jQuery.getJSON('suratmasuk/ruh/'+hash, function(result){
			jQuery('#fwd-mailid').val(result.id);
		});
	});
	
	
	//simpan penerusan surat
	jQuery('#btn-proses-fwd').click(function(){
		var data = jQuery('#form-ruh-sm-semua-forward').serialize();
		var next = formValid('fwd-kepada,fwd-note');
		
		if(next == true){
			// alert(data);
			jQuery.ajax({
				url: 'suratmasuk/fwd?_token='+token1,
				method: 'POST',
				data: data,
				success: function(resp){
					if(resp == 'success'){
						formDefault();
						dataTableAll();
						alertify.message('surat telah di teruskan');
					} else {
						alertify.error(e);
					}
				},
				error: function(e){
					alertify.error(e);
				}
			});
		} else {
			alert('unit tujuan dan catatan penerusan wajib di isi');
		}
	});
	
	
	//pembatalan penerusan surat
	jQuery('#btn-batal-fwd').click(function(){
		formDefault();
		alertify.error('batal meneruskan surat');
	});
	
	
	//menerima surat masuk
	jQuery('body').off('click', '.terima').on('click', '.terima', function(){
		var hash = this.id;
		
		alertify.alert('Konfirmasi', 'Apakah surat ini akan di terima?', 
			function(){
				jQuery.ajax({
					url: 'suratmasuk/terima?_token='+token1,
					method: 'POST',
					data: {hash: hash},
					success: function(resp){
						if(resp == 'success'){
							dataTableAll();
							alertify.message('Dokumen telah diterima');
						} else {
							alertify.message(resp);
						}
					},
					error: function(e){
						alertify.error(e);
					}
				});
			}
		);
	});
	*/
});