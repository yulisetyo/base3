<?php

namespace App\Http\Controllers;

use App\Suratmasuk;
use Illuminate\Http\Request;
use Session;
use Datatables;
use URL;

class TesController extends Controller
{
    /**
	 * description 
	 */
	public function index()
	{
		return sha1(time().'-'.mt_rand().md5(mt_rand()));
	}

	/**
	 * description 
	 */
	public function layoutData()
	{
		$eselon = Session::get('eselon');
		$nip = Session::get('nip');
		$kdunit = Session::get('kdunit');

		//pastikan sekretaris atau bukan
		$rows = \DB::connection('pbn_mail')->select("
			SELECT `u`.`nip` , `u`.`unit` , `u`.`upNip`
			FROM pbn_mail.dt_emp_under AS u WHERE u.nip = ? AND u.active = 'y' LIMIT 1
		", [$nip])[0];

		if(count($rows) > 0) {
			if($rows->unit != '') {
				$unit = $rows->unit;
			} else {
				$unit = $kdunit;
			}
		} else {
			$unit = $kdunit;
		}


		// query tambahan untuk pejabat eselon 2 keatas
		if($eselon < '30' && $eselon != '') {
			$queryEselon2 = " INNER JOIN pbn_mail.mail_in_push AS y ON y.mailinId = m.id ";
		} else {
			$queryEselon2 = " ";
		}

		if($unit == '11211015050010404') {
			
		} 
	}
	
	/**
	 * description 
	 */
	public function layoutView()
	{
		$nip = session('nip');
		$kdunit = session('kdunit');
		$eselon = session('eselon');
		$hash = (isset($_GET['hash'])) ? $_GET['hash'] : '3c72149b8f1ada98d481232beba98c47c4dda62d';

		$rsl = \DB::connection('pbn_mail')->table('mail_in')->where('hash', $hash)->first();
		$id = $rsl->id;

		// pastikan sekretaris atau bukan
		$sekrePos = \DB::connection('pbn_mail')->select("
			SELECT `u`.`nip` , `u`.`unit` , `u`.`upNip`
			FROM pbn_mail.dt_emp_under AS u WHERE u.nip = ? AND u.active = 'y' LIMIT 1
		", [$nip]);

		if(count($sekrePos) > 0) {
			$sekreUnit = $sekrePos[0]->unit;
		} else {
			$sekreUnit = '';
		}

		// query data PLT pejabat ybs
		$pltVal = \DB::select("
			SELECT e.*
			FROM pbn_mail.dt_emp_plt_emp e
			WHERE e.active = 'y' AND e.nip = ? AND (DATE(NOW()) >= e.dateStart AND DATE(NOW()) <= e.dateEnd) LIMIT 1
		", [$nip]);

		if(count($pltVal) > 0) {
			$unitPlt = $pltVal[0]->unit_who;
			$esPlt = $pltVal[0]->eselon_who;
		} else {
			$unitPlt = '';
			$esPlt = '';
		}

		$eselon = ($esPlt != '') ? $esPlt : $eselon;
		$unit_me = ($sekreUnit != '') ? $sekreUnit : $kdunit;
		$valid = ($eselon != '') ? 1 : 0;

		$rows = \DB::select("SELECT m.id,
				m.id,
				m.kk,
				m.date,
				year(m.date) as year,
				m.`from`,
				m.ref,
				m.`subject`,
				m.cc,
				m.attach,
				m.attachType,
				m.kualifikasi,
				m.klasifikasi,
				m.type,
				m.mkNum,
				m.mkVal,
				m.idFile,
				m.who,
				t.mail_typeAbre,
				t.mail_typeName
			FROM pbn_mail.mail_in m
			INNER JOIN pbn_ref.ref_mail_type t ON m.type = t.mail_type
			WHERE m.id = ? AND m.hash = ? LIMIT 1
		", [$id, $hash]);

		if(count($rows) > 0) {
			$jeselon = substr($eselon, 0, 1);

			if($jeselon == '1') {
				$unes_level1 = substr($kdunit, 0, 10);
			} else if($jeselon == '2') {
				$unes_level1 = substr($kdunit, 0, 10);
				$unes_level2 = substr($kdunit, 0, 13);
			} else if($jeselon == '3') {
				$unes_level1 = substr($kdunit, 0, 10);
				$unes_level2 = substr($kdunit, 0, 13);
				$unes_level3 = substr($kdunit, 0, 15);
			} else if($jeselon == '4') {
				$unes_level1 = substr($kdunit, 0, 10);
				$unes_level2 = substr($kdunit, 0, 13);
				$unes_level3 = substr($kdunit, 0, 15);
				$unes_level4 = substr($kdunit, 0, 17);
			} else {
				$unes_level1 = substr($kdunit, 0, 10);
				$unes_level2 = substr($kdunit, 0, 13);
				$unes_level3 = substr($kdunit, 0, 15);
				$unes_level4 = substr($kdunit, 0, 17);
			}

			$dispQuery = \DB::select("
				SELECT d.id
				FROM pbn_mail.mail_in_disp d
				WHERE d.mailinId = ? AND
					(d.from = ? OR d.to = ? OR d.from_nip = ? OR d.to_nip = ?) AND
					d.value IS NOT NULL
					AND d.active = 'y'
				ORDER BY time ASC
			", [$id, $kdunit, $kdunit, $nip, $nip]);

			$dispNum = count($dispQuery);

			if($valid > 0 && $dispNum > 0) {

				$dispFrom = \DB::select("
					SELECT DISTINCT d.from, d.from_nip, date_format(d.time, '%d %b %Y %H:%i') as time, d.value, d.note, d.who
					FROM pbn_mail.mail_in_disp d
					WHERE d.mailinId = ? AND d.`from` <> '0' AND
						(
							d.from = ? OR
							d.from LIKE ? OR
							d.from LIKE ? OR
							d.from LIKE ?
						)
				", [$id, $unes_level1, $unes_level2.'%', $unes_level3.'%', $unes_level4.'%']);

				return json_encode($dispFrom);
			} 
		} else {
			return response()->json(['error' => true, 'message' => 'data not found!']);
		}
	}

	/**
	 * description 
	 */
	public function baz()
	{
		$nip = session('nip');
		$kdunit = session('kdunit');
		$eselon = session('eselon');
		$jeselon = session('jeselon');
		//~ $hash = 'ecd7d31f55a828cf95ce6296fbdf2e463bd02675';
		$hash = 'b719f261479c95588e85bddf51e78708f12b062c';
		$mailinId = \App\Suratmasuk::getMailinByHash($hash)->id;

		//~ if($jeselon == '1') {
			//~ $unes[0] = substr($kdunit, 0, 10);
		//~ } else if($jeselon == '2') {
			//~ $unes[0] = substr($kdunit, 0, 10);
			//~ $unes[1] = substr($kdunit, 0, 13);
		//~ } else if($jeselon == '3') {
			//~ $unes[0] = substr($kdunit, 0, 10);
			//~ $unes[1] = substr($kdunit, 0, 13);
			//~ $unes[2] = substr($kdunit, 0, 15);
		//~ } else if($jeselon == '4') {
			//~ $unes[0] = substr($kdunit, 0, 10);
			//~ $unes[1] = substr($kdunit, 0, 13);
			//~ $unes[2] = substr($kdunit, 0, 15);
			//~ $unes[3] = substr($kdunit, 0, 17);
		//~ } else {
			//~ if(count(RefSekretarisController::cekSekretaris($nip)) > 0) {
				//~ $unes[0] = substr($kdunit, 0, 10);
				//~ $unes[1] = substr($kdunit, 0, 13);
			//~ } else {
				//~ $unes[0] = substr($kdunit, 0, 10);
				//~ $unes[1] = substr($kdunit, 0, 13);
				//~ $unes[2] = substr($kdunit, 0, 15);
				//~ $unes[3] = substr($kdunit, 0, 17);
			//~ }
		//~ }

		function semuaDisp($mailinId, $kdunit)
		{
			$es1 = substr($kdunit, 0, 10);
			$es2 = substr($kdunit, 0, 13).'%';
			$es3 = substr($kdunit, 0, 15).'%';
			$es4 = substr($kdunit, 0, 17).'%';
			
			$semuaDisp = \DB::connection('pbn_mail')->select("
				SELECT DISTINCT d.from, d.from_nip, DATE_FORMAT(d.time, '%d %b %Y %H:%i') AS TIME, d.value, d.note, d.who
				FROM pbn_mail.mail_in_disp d
				WHERE d.mailinId = ? AND d.from <> '0'
					  AND (d.from = ? OR
						   d.from LIKE ? OR
						   d.from LIKE ? OR
						   d.from LIKE ?)
					  AND d.value IS NOT NULL
					  AND d.active = 'y'
				ORDER BY d.from ASC
			", [$mailinId, $es1, $es2, $es3, $es4]);

			return $semuaDisp;
		}

		$rows = semuaDisp($mailinId, $kdunit);
		
		foreach($rows as $row) {
			
			$dispQuery = \DB::connection('pbn_mail')->select("
				SELECT d.*
				FROM pbn_mail.mail_in_disp d
				WHERE d.active = 'y'
					  AND d.mailinId = ?
					  AND d.`from` = ?
					  AND d.value = ?
				ORDER BY `time` ASC
			", [$mailinId, $row->from, $row->value]);

			//~ $dispStatusCount = \DB::connection('pbn_mail')->select("
				//~ SELECT d.id
				//~ FROM pbn_mail.mail_in_disp d
				//~ WHERE d.active = 'y'
					  //~ AND d.mailinId = ?
					  //~ AND d.`from` = ?
					  //~ AND d.to_nip = ?
				//~ LIMIT 1
			//~ ", [$mailinId, $row->from, $nip]);

			//~ $valDispStatusCount = count($dispStatusCount);

			if($kdunit == $row->from) {
				echo '<p style="font-family:courier;border:1px solid #000;background-color:#E6C78D;">';
			} else {
				echo '<p style="font-family:courier;border:1px solid #000;">';
			}
		
			echo RefUnitController::unitById($row->from)->jabatan."<br>";
			
			foreach($dispQuery as $disp) {
				if(RefPegawaiController::pegawaiByNIP($disp->to_nip)->eselon > 50) {
					
					if(is_null($disp->to_nip) || $disp->to_nip == '') {
						echo "&nbsp;&nbsp;&nbsp;".RefUnitController::unitById($disp->to)->jabatan."<br>";
					} else {
						echo "&nbsp;&nbsp;&nbsp;".RefPegawaiController::pegawaiByNIP($disp->to_nip)->nama."<br>";
					}
					
				} else {
					if($row->from == $disp->to) {
						echo "&nbsp;&nbsp;&nbsp;"."Diri sendiri"."<br>";
					} else {
						echo "&nbsp;&nbsp;&nbsp;".RefUnitController::unitById($disp->to)->jabatan."<br>";
					}
				}
				
			}

			if($row->value != '') {
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row->value."<br>";
			}
			
			if($row->note != ''  && strlen($row->note) > 1 ) {
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."catatan : ".$row->note."<br><br>";
			} else {
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			
			echo "</p>";
		}
	}

	/**
	 * description 
	 */
	public function foo()
	{
		$kdunit = Session::get('kdunit');
		//~ $rows = Suratmasuk::suratMasukBelumDisposisi($kdunit);
		$rows = Suratmasuk::suratMasukDariAtasTapiBelumDisposisi($kdunit);
		return response()->json($rows);
	}

	/**
	 * description 
	 */
	public function datatable()
	{
		$nip = session('nip');
		$kdunit = session('kdunit');
		$eselon = session('eselon');
		$rows = Suratmasuk::suratMasukBelumDisposisi($kdunit, $nip, $eselon);
		$data = [];
		
		if(count($rows)) {
			$i = 1;
			foreach($rows as $row) {
				$data[] = [
					'no' => $i++,
					'no_tgl' => $row->date.'<br><b>'.$row->ref.'</b>',
					'asal_isi' => $row->from.'<br><a href="surat-masuk/detail/'.$row->hash.'" target="_blank">'.$row->subject.'</a>',
					'aksi' => ''
				];
			}
		}

		$collection = collect($data);
		return Datatables::of($collection)->make(true);
	}

	/**
	 * description 
	 */
	public function datatable2()
	{
		$nip = session('nip');
		$kdunit = session('kdunit');
		$eselon = session('eselon');
		$rows = Suratmasuk::suratMasukDariAtasTapiBelumDisposisi($kdunit, $nip, $eselon);
		$data = [];
		
		if(count($rows)) {
			$i = 1;
			foreach($rows as $row) {
				$data[] = [
					'no' => $i++,
					'no_tgl' => $row->date.'<br><b>'.$row->ref.'</b>',
					'asal_isi' => $row->from.'<br><a href="surat-masuk/detail/'.$row->hash.'" target="_blank">'.$row->subject.'</a>',
					'aksi' => ''
				];
			}
		}

		$collection = collect($data);
		return Datatables::of($collection)->make(true);
	}
}
