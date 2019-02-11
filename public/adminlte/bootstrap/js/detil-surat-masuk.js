jQuery(document).ready(function(){
	
	//form default
	function formDefault(){
		jQuery("#dok_note, #mail_id, #mail_hash").val("");
		jQuery('#box-catatan, #ruh-sm-semua-forward, #ruh-sm-semua-disposisi').hide();
	}
	
	
	//menjalankan form default
	formDefault();
	
	
	//mengaktifkan chosen-select untuk dropdown
	jQuery('.chosen-select').chosen({width:'100%'});
	
	
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
	
	var baseurl = jQuery(".baseurl").val();
	var token1 = jQuery.getValues(baseurl+'/token');
	
	
	//beri catatan
	jQuery(".catatan").click(function(){
		jQuery("#box-catatan").show();
	});
	
	
	//menerima surat masuk
	jQuery('body').off('click', '.terima').on('click', '.terima', function(){
		var hash = this.id;
		
		alertify.alert('Konfirmasi', 'Apakah surat ini akan di terima?', 
			function(){
				jQuery.ajax({
					url: baseurl+'/suratmasuk/terima?_token='+token1,
					method: 'POST',
					data: {hash: hash},
					success: function(resp){
						if(resp == 'success'){
							//dataTableAll();
							alertify.message('Dokumen telah diterima');
							window.location.replace(baseurl+'/suratmasuk/detil/'+hash);
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
	
	
	//simpan catatan
	jQuery("#simpan_komentar").click(function(){
		var data = jQuery("#form-komentar").serialize();
		var komentar = jQuery("#dok_note").val();
		if(komentar == ''){
			alertify.alert("eoffice","Anda belum menuliskan catatan!");
		} else {
			/*jQuery.ajax({
				url: '../../suratmasuk/catatan?_token='+token1,
				method: 'post',
				data: {hash: hash},
				success: function(resp){
					if(resp == 'success'){
						formDefault();
						alertify.message('Catatan surat berhasil di simpan');
					}
				},
			});*/
			alertify.message('Catatan surat berhasil di simpan');
			formDefault();
		}
	});
	
	
	//batal komentar
	jQuery("#batal_komentar").click(function(){
		formDefault();
		// jQuery("#box-catatan").show();
	});
	
	
	//mengaktifkan form disposisi
	jQuery('body').off('click', '.disposisi').on('click', '.disposisi', function(){
		var hash = this.id;
		jQuery('#div-row-tab, #tabel-sm-semua').hide();
		jQuery('#div-row-form, #ruh-sm-semua-disposisi').show();
		jQuery.getJSON(baseurl+'/suratmasuk/ruh/'+hash, function(result){
			jQuery('#disp-mailid').val(result.id);
			jQuery('#disp-no-surat').val(result.ref);
		});
		jQuery.get(baseurl+'/unit/chk-unit', function(result){
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
				url: baseurl+'/suratmasuk/disp?_token='+token1,
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
	
	
	//mengaktifkan form penerusan surat
	jQuery('body').off('click', '.teruskan').on('click', '.teruskan', function(){
		var hash = this.id;
		jQuery('#div-row-tab, #tabel-sm-semua').hide();
		jQuery('#div-row-form, #ruh-sm-semua-forward').show();
		jQuery.get(baseurl+'/unit/chk-unit-fwd', function(result){
			jQuery('#fwd-kepada').html(result).trigger('chosen:updated');
		});
		jQuery.getJSON(baseurl+'/suratmasuk/ruh/'+hash, function(result){
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
				url: baseurl+'/suratmasuk/fwd?_token='+token1,
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
	
});