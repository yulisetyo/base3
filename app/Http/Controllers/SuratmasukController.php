<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
			$data = [
				'side_menu' => MenuController::getMenu(),
				'nm_unit' => 'DJPB',
			];
			
			return view('surat-masuk', $data);
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
	public function tes()
	{
		$data = Session::get('data');
		$hash = '26602d7c8b34867a8a8d985075f4b58e4c49a3bb';
		$res = session('arraysession');
		return json_encode($res);
	}
}
