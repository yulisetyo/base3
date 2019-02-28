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
			'baseurl' => csrf_token(),
		];
		
		return view('surat-masuk', $data);
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
		$selected = \DB::connection('pbn_mail')->table('mail_in')->where('hash', $request->hash)->first();
		
		$data = [
			'mailinId' => $selected->id,
			'who' => session('nip'),
			'nip' => session('nip'),
			'active' => 'y',
			'ip' => PustakaController::setUserIP(),
		];

		$pinned = \DB::connection('pbn_mail')->table('mail_in_pinned')->insert($data);

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
		$selected = \DB::connection('pbn_mail')->table('mail_in')->where('hash', $request->hash)->first();
		
		$data = [
			'who' => session('nip'),
			'nip' => session('nip'),
			'active' => 'd',
		];

		$unpinned = \DB::connection('pbn_mail')->table('mail_in_pinned')->where('mailinId', $selected->id)->update($data);

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

	/**
	 * description 
	 */
	public function tes()
	{
		$data = Session::get('data');
		$hash = '26602d7c8b34867a8a8d985075f4b58e4c49a3bb';
		$res = session('arraysession');
		return json_encode($res);
	}
}
