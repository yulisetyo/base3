jQuery(document).ready(function(){
	
	//setting baseurl
	var baseurl = jQuery(".baseurl").val();
	
	//form default
	function formDefault(){
		jQuery('#plt-nosprin,#plt-tglsprin,#plt-tglmulai,#plt-tglselesai,#plt-alasan').val('');
		jQuery('.chosen-select').val('').trigger('chosen:updated');
		jQuery('.warning').hide();
	}
	
	formDefault();
	
	//datepicker
	jQuery('#plt-tglsprin,#plt-tglmulai,#plt-tglselesai').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd',
		todayBtn: true,
		todayHighlight: true,
	});
	
	//mengaktifkan chosen-select untuk dropdown
	jQuery('.chosen-select').chosen({width:'100%'});
	
	//dropdown NIP 
	jQuery.get('dropdown/plt', function(result){
		if(result){
			jQuery('#plt-nip').html(result).trigger('chosen:updated');
		}
	});	
	
	//dropdown unit organisasi 
	jQuery.get('dropdown/unit', function(result){
		if(result){
			jQuery('#plt-unit').html(result).trigger('chosen:updated');
		}
	});
	
	//validasi form sebelum disimpan
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
	
	//pembatalan proses simpan
	jQuery('#btn-batal').click(function(){
		formDefault();
	});
	
	//simpan data Plt.
	jQuery('#btn-simpan').click(function(){
		var next = formValid('plt-nip,plt-nosprin,plt-tglsprin,plt-unit,plt-tglmulai,plt-tglselesai,plt-alasan');
		//var next=true;
		if(next == true){
			var data = jQuery('#form-ruh-plt').serialize();
			
			jQuery.ajax({
				url : baseurl+'/referensi/plt/simpan',
				method : 'POST',
				data : data,
				success : function(resp){
					if(resp == 'success'){
						alertify.message('Sukses menyimpan data');
						formDefault();
					} else {
						// alertify.message('Gagal menyimpan data');
						alertify.message(resp);
					}
				}
			});
		} 
	});
	
	//pengganti : nip-unit-eselon-nama-gol
	//plt_dari : nip-unit-eselon-nama-jbtn
});