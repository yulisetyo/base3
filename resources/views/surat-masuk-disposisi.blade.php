<?php 

$nbsp = "&nbsp";
$str4 = str_repeat($nbsp, 5);
$str8 = str_repeat($str4, 2);

$html = '<small>';
$fac = '<span class="text-default"><i class="fa fa-clock-o"></i> </span>'.$nbsp;
$faf = '<span class="text-default"><i class="fa fa-user"></i> </span>'.$nbsp;
$fat = '<span class="text-default"><i class="fa fa-user"></i> </span>'.$nbsp;

foreach($disposisi as $row) {

	if($row->from == session('kdunit')) {
		$html .= '<div class="callout callout-warning">';
	} else {
		$html .= '<div class="callout callout-default" style="background-color:#E5E5E5;">';
	}

	$html .= '<span class="text-bold">'.$fac.App\Http\Controllers\ReferensiController::formatWaktu($row->time).' WIB'.'</span>'.'<br>'; 
	$html .= '<span class="text-bold">'.$faf.App\Http\Controllers\RefUnitController::unitById($row->from)->jabatan.'</span>'.'<br>';

	$subrows = App\Suratmasuk::dispQuery($mailinId, $row->from, $row->value);

	foreach($subrows as $kpd) {

		if(strlen($row->from) > 15) {
			
			if(count(App\Suratmasuk::cekTerimaByNIP($kpd->to_nip, $hash)) > 0) {
				$stsTrm = ' <span title="sudah terima" class="text-green"><i class="fa fa-check"></i></span> ';
			} else {
				$stsTrm = ' <span title="belum terima" class="text-warning"><i class="fa fa-calendar-o"></i></span> ';
			}

			if($row->from_nip != $kpd->to_nip) {
				$html .= $str4.$stsTrm.App\Http\Controllers\RefPegawaiController::pegawaiByNIP($kpd->to_nip)->nama.'<br>';
			} else {
				$html .= $str4.$stsTrm."Diri Sendiri".'<br>';
			}
			
		} else {
			$html .= $str4.$fat.App\Http\Controllers\RefUnitController::unitById($kpd->to)->jabatan.'<br>';
		}

	} 

	if($row->value != '') {
		$html .= $str8.'<span class="text-bold">'.$row->value.'</span>'."<br>";
	}

	if($row->note != ''  && strlen($row->note) > 1 ) {
		$html .= $str8.'Catatan : <i>'.$row->note.'</i>'."<br>";
	}
	
	$html .= '</div>';
}

$html .= '</small>';

echo $html;
