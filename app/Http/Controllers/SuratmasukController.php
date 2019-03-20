<?php

namespace App\Http\Controllers;

use App\Suratmasuk;
use Illuminate\Http\Request;
use Session;
use Datatables;
use URL;

class SuratmasukController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
    /**
	 * description 
	 */
	public function index()
	{
		$arrSess = array(
			'nip' => session('nip'),
			'name' => session('name'),
			'kdunit' => session('kdunit'),
			'eselon' => session('eselon'),
			'kdlevel' => session('kdlevel'),
		);
		
		$cekSekretaris = RefSekretarisController::cekSekretaris($arrSess['nip']);

		if(count($cekSekretaris) > 0) {
			$rekamSurat = '<div id="container-floating">
					<div id="tambah" data-toggle="tooltip" data-placement="left" data-original-title="Rekam" onclick="">
						<p class="plus">+</p>
						<img class="edit" src="https://ssl.gstatic.com/bt/C3341AA7A1A076756462EE2E5CD71C11/1x/bt_compose2_1x.png">
					</div>
				</div>';
		} else {
			$rekamSurat = '';
		}
		
		$data = [
			'side_menu' => MenuController::getMenu(),
			'nm_unit' => RefUnitController::unitById(session('kdunit'))->nm_unit,
			'rekam_surat' => $rekamSurat,
			'baseurl' => URL::to('/'),
		];
		
		return view('surat-masuk', $data);
	}

	/**
	 * UNTUK MENAMPILKAN FORM PEREKAMAN SURAT
	 */
	public function rekam()
	{
		$nip = session('nip');
		$cekSekretaris = RefSekretarisController::cekSekretaris($nip);

		if(count($cekSekretaris) > 0) {
			$rekamSurat = '<div id="container-floating">
					<div id="tambah" data-toggle="tooltip" data-placement="left" data-original-title="Rekam" onclick="">
						<p class="plus">+</p>
						<img class="edit" src="https://ssl.gstatic.com/bt/C3341AA7A1A076756462EE2E5CD71C11/1x/bt_compose2_1x.png">
					</div>
				</div>';
		} else {
			$rekamSurat = '';
		}
		
		$data = [
			'side_menu' => MenuController::getMenu(),
			'nm_unit' => RefUnitController::unitById(session('kdunit'))->nm_unit,
			'rekam_surat' => $rekamSurat,
			'baseurl' => URL::to('/'),
		];
		
		return view('surat-masuk-rekam', $data);
	}

	/**
	 * UNTUK MENYIMPAN DATA SURAT MASUK YANG DIREKAM
	 */
	public function simpan(Request $request)
	{
		//~ $acak = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
		$acak = sha1(time().'-'.mt_rand().md5(mt_rand()));
		$asal_surat = '';
		if($request->inex == 'in') {
			$asal_surat = RefUnitController::unitById($request->internal)->nm_unit;
		} else if($request == 'ex') {
			$asal_surat = $request->external;
		} 
		
		$data_surat = [
			'kk' => null,
			'hash' => sha1(md5($acak)),
			'date' => $request->tglsurat,
			'from' => $asal_surat,
			'ref' => $request->nosurat,
			'type' => $request->jnssurat,
			'subject' => $request->perihal,
			'cc' => $request->keaslian,
			'attach' => $request->lampiran,
			'attachType' => $request->jnslam,
			'kualifikasi' => $request->kualifikasi,
			'klasifikasi' => $request->klasifikasi,
			'mkNum' => null,
			'mkVal' => null,
			'unit' => session('kdunit'),
			'active' => 'y',
			'who' => session('nip'),
			'ip' => PustakaController::setUserIP(),
		];

		dd($data_surat);
		$insert = true;
		//~ $insert = \DB::connection('pbn_mail')->table('mail_in')->insert($data); 

		if($insert) {
			return response()->json(['error' => false, 'message' => 'success']);
		} else {
			return response()->json(['error' => true, 'message' => 'Proses simpan surat tidak berhasil!']);
		}
	}

	/**
	 * UNTUK MENYIMPAN DATA AGENDA RAPAT YANG DIREKAM OLEH SEKRETARIS
	 * BERDASARKAN SURAT DENGAN TIPE 7 (UNDANGAN)
	 */
	public function simpanUndangan(Request $request)
	{
		$hash = $request->hash;
		$und = \DB::connection('pbn_mail')->table('mail_in')
						->where('hash', $hash)
						->where('type', 7)
						->first();

		$data = [
			'mailinId' => $und->id,
			'start' => $request->und_awal,
			'end' => $request->und_akhir,
			'unit' => session('kdunit'),
			'pj' => $request->und_pj,
			'agenda' => $request->und_agenda,
			'prioritas' => $request->und_prio,
			'pimpinan' => $request->und_lead,
			'loc' => $request->und_lokasi,
			'active' => 'y',
			'who' => session('nip'),
			'ip' => PustakaController::setUserIP(),
		];

		//~ $insert = \DB::connection('pbn_mail')->table('tl_agendarapat')->insert($data);
		$insert = true;

		if($insert) {
			return response()->json(['error' => false, 'message' => 'success']);
		} else {
			return response()->json(['error' => true, 'message' => 'Proses simpan agenda tidak berhasil']);
		}
	}

	/**
	 * UNTUK MENAMPILKAN DATA KE DATATABEL 
	 */
	public function dataTable()
	{
		$arrSess = Session::get('arraysession');
		$baseURL = URL::to('/');
		$data = array();
		$cekSekretaris = RefSekretarisController::cekSekretaris($arrSess['nip']);
		$cekSekreUnit = Suratmasuk::cekSekreUnit($arrSess['nip'], $arrSess['kdunit'], $arrSess['eselon']);
		if(count($cekSekretaris) > 0) {
			//jika ybs sekretaris
			$kdunit = $cekSekreUnit[0]->kdunit;
				
			$rows = Suratmasuk::inboxEselon2($arrSess['kdunit']);
		} else {
			
			if(substr($arrSess['eselon'],0,1) == '1') {
				//tampilkan surat masuk (baik yang belum diterima maupun yang sudah diterima)
				//tampilkan surat masuk (baik yang belum didisposisi maupun yang sudah didisposisi)
				return 1;
				
			} else if(substr($arrSess['eselon'],0,1) == '2') {
				//tampilkan surat masuk (baik yang belum diterima maupun yang sudah diterima)
				//tampilkan surat masuk (baik yang belum didisposisi maupun yang sudah didisposisi)
				$rows = Suratmasuk::inboxEselon2($arrSess['kdunit']);
				
			} else if(substr($arrSess['eselon'],0,1) == '3') {
				//tampilkan surat masuk (baik yang belum diterima maupun yang sudah diterima)
				//tampilkan surat masuk (baik yang belum didisposisi maupun yang sudah didisposisi)
				if(count($cekSekreUnit) > 0) {
					$rows = Suratmasuk::inboxEselon3Sekre($arrSess['kdunit']);
				} else {
					$rows = Suratmasuk::inboxEselon3NonSekre($arrSess['kdunit']);
				}

			} else if(substr($arrSess['eselon'],0,1) == '4') {
				//tampilkan surat masuk (baik yang belum diterima maupun yang sudah diterima)
				//tampilkan surat masuk (baik yang belum didisposisi maupun yang sudah didisposisi)
				$rows = Suratmasuk::inboxEselon4($arrSess['kdunit'], $arrSess['nip']);

			} else {
				//tampilkan surat masuk (baik yang belum diterima maupun yang sudah diterima)
				$rows = Suratmasuk::inboxPelaksana($arrSess['nip']);

			}
		
		}
		
		if(count($rows) > 0) {
			$i = 1;
			$aksi = '';
			foreach($rows as $row) {

				if(Suratmasuk::cekKualifikasi($row->hash) == 'biasa') {
					$kualifikasi = '<span title="biasa"><i class="fa fa-flag fa-lg text-green"></i> </span>';
				} else if(Suratmasuk::cekKualifikasi($row->hash) == 'segera') {
					$kualifikasi = '<span title="segera"><i class="fa fa-flag fa-lg text-yellow"></i> </span>';
				} else {
					$kualifikasi = '<span title="sangat segera"><i class="fa fa-flag fa-lg text-red"></i> </span>';
				}

				if(Suratmasuk::cekPinned(session('nip'), $row->id) != 0) {
					$pinned = '<span title="click here to unpinned" id="'.$row->hash.'" class="unpinned"><i class="fa fa-thumb-tack fa-lg text-danger"></i> </span>';
				} else {
					$pinned = '<span title="clik here to pinned" class="pinned" id="'.$row->hash.'"><i class="fa fa-thumb-tack fa-lg text-primary"></i> </span>';
				}
				
				if(Suratmasuk::cekTerima($arrSess['kdunit'], $row->hash) != 0) {
					$aksi = '<a title="buka dokumen" href="'.$baseURL.'/surat-masuk/pdf/'.$row->hash.'" target="_blank"><i class="fa fa-file-pdf-o fa-lg text-red"></i> </a>';
				} 
				
				$data[] = [
					'no' => $i++,
					'no_tgl' => $row->date.'<br><b>'.$row->ref.'</b>',
					'asal_isi' => $row->from.'<br><a href="surat-masuk/detail/'.$row->hash.'" target="_blank">'.$row->subject.'</a>',
					'aksi' => $kualifikasi.$aksi.$pinned,
				];
			}
		}
		
		$collection = collect($data);
		return Datatables::of($collection)->make(true);
	}

	/**
	 * MENAMPILKAN DATATABEL UNTUK SURAT MASUK MELALUI PEREKAMAN
	 */
	public function dataTablePerekaman()
	{
		$kdunit = session('kdunit');
		$rows = Suratmasuk::dataDariPerekaman($kdunit);
		$data = [];
		$i = 1;
		if(count($rows) > 0) {
			foreach($rows as $row) {
				$aksi = "";
				$data[] = [
					'no' => $i++,
					'no_tgl' => $row->date,
					'asal_isi' => $row->from.'<br><a href="surat-masuk/detail/'.$row->hash.'" target="_blank">'.$row->subject.'</a>',
					'aksi' => $aksi,
				];
			}
		}
		$collection = collect($data);
		return Datatables::of($collection)->make(true);
	}

	/**
	 * UNTUK MENAMPILKAN SURAT YANG DI PILIH KE FORMAT JSON 
	 * BERDASARKAN KODE HASH-NYA 
	 */
	public function pilih($param)
	{
		$rows = Suratmasuk::where('hash', $param)->first();
		
		return response()->json($rows);
	}

	/**
	 * MENAMPILKAN ISI DETAIL SURAT
	 */
	public function tayangDetail($hash)
	{
		$kdunit = session('kdunit');
		$baseURL = URL::to('/');
		$row = Suratmasuk::detailSurat($hash);

		$data = [
			'side_menu' => MenuController::getMenu(),
			'nm_unit' => RefUnitController::unitById(session('kdunit'))->nm_unit,
			'baseurl' => $baseURL,
			'surat' => [
				'noagd' => 'KK- '.$row->kk.' /PB/2019',
				'hash' => $row->hash,
				'no' => $row->ref,
				'tgl' => ReferensiController::formatTanggal($row->date),
				'batas' => ReferensiController::formatTanggal($row->date),
				'asal' => $row->from,
				'jenis' => ReferensiController::jenisSuratByTipe($row->type),
				'perihal' => $row->subject,
				'kualifikasi' => $row->kualifikasi,
				'klasifikasi' => $row->klasifikasi,
			],
			'disposisi' => $this->tayangDisposisi($hash),
		];

		return view('surat-masuk-detail', $data);
	}

	/**
	 * MENAMPILKAN DETAIL DISPOSISI
	 * DARI SIAPA KEPADA SIAPA
	 */
	public function tayangDisposisi($hash)
	{
		$nip = session('nip');
		$kdunit = session('kdunit');
		$eselon = session('eselon');
		$jeselon = session('jeselon');
		//~ $hash = 'ecd7d31f55a828cf95ce6296fbdf2e463bd02675';
		$mailinId = Suratmasuk::getMailinByHash($hash)->id;		
		$semuaDisp = Suratmasuk::semuaDisp($mailinId, $kdunit);

		$data = array(
			'kdunit' => $kdunit,
			'hash' => $hash,
			'disposisi' => $semuaDisp,
			'mailinId' => $mailinId,
		);

		return view('surat-masuk-disposisi', $data);
	}

	/**
	 * MENAMPILKAN HARDCOPY SURAT DALAM FORMAT PDF
	 * BERDASARKAN KODE HASH-NYA 
	 */
	public function tayangPDF($param)
	{
		$baseURL = URL::to('/');
		$row = \DB::select("
			SELECT m.id, m.`hash`, f.idFile, f.realname, f.filetype, f.filesize
			FROM pbn_mail.mail_in m
			JOIN pbn_mail.file_upload f ON m.idFile = f.idFile
			WHERE m.active='y' AND m.`hash` = ?
		", [$param])[0];
		
		$filename = $row->realname;
		$filepath = 'data/inbox/'.$filename;

		if(file_exists($filepath)) {
			//~ dd($filepath);
			header('Content-type: '.$row->filetype.'');
			header('Content-Disposition: inline; filename="' . $row->realname . '"');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.filesize($filepath));
			header('Accept-Ranges: bytes');
			@readfile($filepath);
			exit;
		} else {
			return '<script type="text/javascript">alert("File hardcopy dokumen tidak ditemukan"); window.close();</script>';
		}
	}
	
	/**
	 * UNTUK PROSES PENERIMAAN SURAT
	 */
	public function terima(Request $request)
	{
		$selected = \DB::connection('pbn_mail')->table('mail_in')->where('hash', $request->hash)->first();
		$data = [
			'mailinId' => $selected->id,
			'from' => session('kdunit'),
			'to' => session('kdunit'),
			'who' => session('nip'),
			'note' => $request->input('catatan'),
			'status' => 'y',
			'ip' => PustakaController::setUserIP(),
		];

		$insert = \DB::connection('pbn_mail')->table('mail_in_pos')->insert($data);

		if($insert) {
			return response()->json(['error'=>false, 'message'=>'success']);
		} else {
			return response()->json(['error'=>true, 'message'=>'gagal menerima surat!']);
		}
	}

	/**
	 * UNTUK MEREKAM SURAT KE DAFTAR SURAT YANG PINNED
	 */
	public function pinned(Request $request)
	{
		$selected = Suratmasuk::getMailinByHash($request->hash);
		
		$data = [
			'mailinId' => $selected->id,
			'who' => session('nip'),
			'nip' => session('nip'),
			'active' => 'y',
			'ip' => PustakaController::setUserIP(),
		];

		$pinned = Suratmasuk::docPinned($request->hash, $data);
		
		if($pinned) {
			return response()->json(['error'=>false, 'message'=>'success']);
		} else {
			return response()->json(['error'=>true, 'message'=>'gagal untuk di-pinned']);
		}
	}

	/**
	 * UNTUK MENGHAPUS SURAT DARI DAFTAR SURAT YANG DI PINNED
	 */
	public function unpinned(Request $request)
	{
		$data = [
			'who' => session('nip'),
			'nip' => session('nip'),
			'active' => 'd',
		];

		$unpinned = Suratmasuk::docUnpinned($request->hash, $data);

		if($unpinned) {
			return response()->json(['error'=>false, 'message'=>'success']);
		} else {
			return response()->json(['error'=>true, 'message'=>'gagal untuk di-unpinned']);
		}
	}

	/**
	 * description 
	 */
	public function suratUndangan()
	{
		$kdunit = session('kdunit');
		$rows = \DB::connection('pbn_mail')
					->table('mail_in')
						->select('id', 'date','ref','hash','subject as perihal','type')
						->where('type', 7)
						->where('unit', $kdunit)
						->orderBy('date', 'desc')
						->get();

		foreach($rows as $row) {
			$arrData[] = [
				'kode' => $row->hash,
				'uraian' => $row->date. ' '.strtoupper($row->ref).' #'.$row->perihal,
			]; 
		}

		return DropdownController::option2($arrData);
	}
}
