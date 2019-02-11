jQuery(document).ready(function(){
	
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
	
	
	jQuery("#li-all").click(function(){
		dataTableAll();
		dataTableAllDisp();
	});
	
	
	//datatable semua surat masuk
	function dataTableAll(param) {
		if(param != 'xxx'){
			var url = "suratmasuk/datatabel/all?tgl="+param+"&tipe=all&_token="+token1; 
		} else {
			var url = "suratmasuk/datatabel/all?tipe=all&_token="+token1;
		}
		
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
	// datatable semua surat masuk belum disposisi
	dataTableAll('xxx');
	
	
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
	// datatable semua surat masuk sudah disposisi
	dataTableAllDisp();
	
	
	jQuery('#data-plt').click(function(){
		window.open('./../referensi/plt')
	});
});