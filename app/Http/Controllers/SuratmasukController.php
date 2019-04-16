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
	 * MENAMPILKAN SEMUA DATA SURAT MASUK
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
		
		$cekSekre = RefSekretarisController::cekSekretaris($arrSess['nip']);

		if(count($cekSekre) > 0) {
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
	 * MENAMPILKAN SEMUA DATA SURAT MASUK
	 * DENGAN TIPE UNDANGAN
	 */
	public function undangan()
	{
		$arrSess = array(
			'nip' => session('nip'),
			'name' => session('name'),
			'kdunit' => session('kdunit'),
			'eselon' => session('eselon'),
			'kdlevel' => session('kdlevel'),
		);
		
		$cekSekre = RefSekretarisController::cekSekretaris($arrSess['nip']);

		if(count($cekSekre) > 0) {
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
		
		return view('surat-masuk-und', $data);
	}

	/**
	 * MENAMPILKAN SEMUA DATA SURAT MASUK
	 * DENGAN TIPE NON UNDANGAN
	 */
	public function nonUndangan()
	{
		$arrSess = array(
			'nip' => session('nip'),
			'name' => session('name'),
			'kdunit' => session('kdunit'),
			'eselon' => session('eselon'),
			'kdlevel' => session('kdlevel'),
		);
		
		$cekSekre = RefSekretarisController::cekSekretaris($arrSess['nip']);

		if(count($cekSekre) > 0) {
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
		
		return view('surat-masuk-non', $data);
	}

	/**
	 * MENAMPILKAN SEMUA DATA AGENDA SURAT MASUK
	 */
	public function agenda()
	{
		return "under construction!";
	}

	/**
	 * MENAMPILKAN SEMUA DATA AGENDA SURAT MASUK
	 */
	public function follow()
	{
		$arrSess = array(
			'nip' => session('nip'),
			'name' => session('name'),
			'kdunit' => session('kdunit'),
			'eselon' => session('eselon'),
			'kdlevel' => session('kdlevel'),
		);
		
		$cekSekre = RefSekretarisController::cekSekretaris($arrSess['nip']);

		if(count($cekSekre) > 0) {
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
		
		return view('surat-masuk-follow', $data);
	}

	/**
	 * MENAMPILKAN SEMUA DATA AGENDA SURAT MASUK
	 */
	public function pinned()
	{
		$arrSess = array(
			'nip' => session('nip'),
			'name' => session('name'),
			'kdunit' => session('kdunit'),
			'eselon' => session('eselon'),
			'kdlevel' => session('kdlevel'),
		);
		
		$cekSekre = RefSekretarisController::cekSekretaris($arrSess['nip']);

		if(count($cekSekre) > 0) {
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
		
		return view('surat-masuk-pinned', $data);
	}

	/**
	 * MENAMPILKAN SEMUA DATA AGENDA SURAT MASUK
	 */
	public function plt()
	{
		$arrSess = array(
			'nip' => session('nip'),
			'name' => session('name'),
			'kdunit' => session('kdunit'),
			'eselon' => session('eselon'),
			'kdlevel' => session('kdlevel'),
		);
		
		$cekSekre = RefSekretarisController::cekSekretaris($arrSess['nip']);

		if(count($cekSekre) > 0) {
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
		
		return view('surat-masuk-plt', $data);
	}

	/**
	 * UNTUK MENAMPILKAN FORM PEREKAMAN SURAT
	 */
	public function rekam()
	{
		$nip = session('nip');
		$cekSekre = RefSekretarisController::cekSekretaris($nip);

		if(count($cekSekre) > 0) {
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
		$kdunit = $arrSess['kdunit'];
		$baseURL = URL::to('/');
		$data = array();

		$cekSekre = RefSekretarisController::cekSekretaris($arrSess['nip']);

		if(count($cekSekre) > 0) {
			//jika ybs sekretaris
			$kdunit = $cekSekre['kdunit'];
			$rows = Suratmasuk::suratMasukBelumDisposisi($kdunit, $arrSess['nip'], $arrSess['eselon']);
		} else {
			$rows = Suratmasuk::suratMasukBelumDisposisi($kdunit, $arrSess['nip'], $arrSess['eselon']);
		}
		
		if(count($rows) > 0) {
			$i = 1;
			// ~ $aksi = '<a title="dokumen belum diterima" disabled class=""><i class="fa fa-file-pdf-o fa-lg"></i> </a>';
			foreach($rows as $row) {

				if(Suratmasuk::cekKualifikasi($row->hash) == 'biasa') {
					$kualifikasi = '<span title="kualifikasi biasa"><i class="fa fa-flag fa-lg text-green"></i> </span>';
				} else if(Suratmasuk::cekKualifikasi($row->hash) == 'segera') {
					$kualifikasi = '<span title="kualifikasi segera"><i class="fa fa-flag fa-lg text-yellow"></i> </span>';
				} else {
					$kualifikasi = '<span title="kualifikasi sangat segera"><i class="fa fa-flag fa-lg text-red"></i> </span>';
				}

				if(Suratmasuk::cekPinned(session('nip'), $row->id) != 0) {
					$pinned = '<span title="klik disini untuk unpinned" id="'.$row->hash.'" class="unpinned"><i class="fa fa-thumb-tack fa-lg text-danger"></i> </span>';
				} else {
					$pinned = '<span title="klik disini untuk pinned" class="pinned" id="'.$row->hash.'"><i class="fa fa-thumb-tack fa-lg text-primary"></i> </span>';
				}
				
				if(Suratmasuk::cekTerima(session('kdunit'), $row->hash) != 0) {
					// ~ $aksi = '<a title="klik disini untuk membuka dokumen" href="'.$baseURL.'/surat-masuk/pdf?mkey='.$row->hash.'" target="_blank"><i class="fa fa-file-pdf-o fa-lg text-red"></i> </a>';
					$aksi = '<a title="klik disini untuk membuka dokumen" href="'.$baseURL.'/surat-masuk/pdf?mkey='.$row->hash.'" title="berkas dokumen" class="dokumen" target="_blank"><i class="fa fa-file-pdf-o fa-lg text-red"></i> </a>';
				} else {
					$aksi = '<a title="dokumen belum diterima" disabled class=""><i class="fa fa-file-pdf-o fa-lg"></i> </a>';
				}
				
				$data[] = [
					'no' => $i++,
					'no_tgl' => $row->date.'<br><b>'.$row->ref.'</b>',
					'asal_isi' => $row->from.'<br><a href="surat-masuk/detail?mkey='.$row->hash.'" target="_blank">'.$row->subject.'</a>',
					'aksi' => $kualifikasi.'&nbsp;'.$aksi.'&nbsp;'.$pinned,
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
				$aksi = " ";
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
	 * MENAMPILKAN DATATABEL UNTUK SURAT MASUK BAGI Plt.
	 */
	public function dataTablePlt()
    {
        $nip = session('nip');
        $kdunit = session('kdunit');
        $eselon = session('eselon');
        $baseURL = URL::to('/');

        // query data PLT pegawai ybs
        $sql = \DB::connection('pbn_mail')->select("
            SELECT e.*
            FROM pbn_mail.dt_emp_plt_emp e
            WHERE e.nip = ?
                  AND e.active = 'y'
                  AND (date(NOW()) BETWEEN e.dateStart AND e.dateEnd)
        ", [$nip]);

        $numsql = count($sql);
        $data = [];

        if($numsql > 0) {
            $jnseselon = substr($eselon, 0, 1);
            $nipWho = $sql[0]->nip_who;
            $unitWho = $sql[0]->unit_who;
            
            if((int) $jnseselon < 3) {
                $sqlAdditional = " INNER JOIN pbn_mail.mail_in_push AS y ON y.mailinId = m.id ";
            } else {
                $sqlAdditional = " ";
            }

            $rows = \DB::connection('pbn_mail')->select("
                SELECT m.*
                FROM pbn_mail.mail_in m
                INNER JOIN pbn_ref.ref_mail_type AS t ON m.type = t.mail_type
                INNER JOIN pbn_mail.mail_in_pos AS p ON p.mailinId = m.id
                $sqlAdditional
                WHERE p.to = ? AND m.active = 'y' AND p.status = 'y'
				ORDER BY m.kualifikasi DESC
            ", [$unitWho]);

			if(isset($_GET['dateget']) || $_GET['dateget'] == '') {
				$sqlDate = '';
			} else {
				$sqlDate = '';
			}
			
            $numrows = count($rows);
            
            if($numrows > 0) {
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

                    if(Suratmasuk::cekPinned($nipWho, $row->id) != 0) {
                        $pinned = '<span title="click here to unpinned" id="'.$row->hash.'" class="unpinned"><i class="fa fa-thumb-tack fa-lg text-danger"></i> </span>';
                    } else {
                        $pinned = '<span title="clik here to pinned" class="pinned" id="'.$row->hash.'"><i class="fa fa-thumb-tack fa-lg text-primary"></i> </span>';
                    }
                    
                    if(Suratmasuk::cekTerima($unitWho, $row->hash) != 0) {
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
	public function tayangDetail()
	{
		$nip = session('nip');
		$kdunit = session('kdunit');
		$baseURL = URL::to('/');

		if(isset($_GET['mkey'])) {
			$hash = $_GET['mkey'];
		} else {
			$hash = '';
		}
		
		$row = Suratmasuk::detailSurat($hash);

		$dokumen = (count(Suratmasuk::cekTerimaByNIP($nip, $hash)) != 0) ? '<a title="klik disini untuk membuka dokumen" href="'.$baseURL.'/surat-masuk/pdf?mkey='.$row->hash.'" title="berkas dokumen" class="dokumen" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-red"></i> </a>' : '<a title="dokumen belum diterima" disabled class=""><i class="fa fa-file-pdf-o fa-2x"></i> </a>' ;

		$stsTrm = (count(Suratmasuk::cekTerimaByNIP($nip, $hash)) != 0) ? '' : '<button id="'.$row->hash.'" title="terima surat" class="btn btn-default terima"><i class="fa fa-download"></i> Terima surat</button>' ;

		$stsPinned = (Suratmasuk::cekPinned($nip, $row->id) != 0) ? '' : '<button id="'.$row->hash.'" title="pinned surat" class="btn btn-default pinned"><i class="fa fa-thumb-tack"></i> Pinned surat</button>';

		$stsNote = (Suratmasuk::cekNote($nip, $row->id) == 1) ? '' : '<button id="'.$row->hash.'" title="beri catatan" class="btn btn-default catatan"><i class="fa fa-pencil"></i> Beri catatan</button>' ;
		
		$data = [
			'side_menu' => MenuController::getMenu(),
			'nm_unit' => RefUnitController::unitById(session('kdunit'))->nm_unit,
			'baseurl' => $baseURL,
			'surat' => [
				'hcopy' => $dokumen,
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
			'ststrm' => $stsTrm,
			'stspinned' => $stsPinned,
			'catatan' => $stsNote,
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
	public function tayangPDF()
	{
		$param = (isset($_GET['mkey'])) ? $_GET['mkey'] : '';
		$baseURL = URL::to('/');
		$row = Suratmasuk::getFileSurat($param);
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
	public function doTerima(Request $request)
	{
		$selected = \DB::connection('pbn_mail')->table('mail_in')->where('hash', $request->hash)->first();

		$data = [
			'mailinId' => $selected->id,
			'from' => session('kdunit'),
			'to' => session('kdunit'),
			'who' => session('nip'),
			'note' => null, //$request->input('catatan'),
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
	public function doPinned(Request $request)
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
	public function doUnpinned(Request $request)
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

	// ~ /**
	 // ~ * description 
	 // ~ */
	// ~ public function suratUndangan()
	// ~ {
		// ~ $kdunit = session('kdunit');
		// ~ $rows = \DB::connection('pbn_mail')
					// ~ ->table('mail_in')
						// ~ ->select('id', 'date','ref','hash','subject as perihal','type')
						// ~ ->where('type', 7)
						// ~ ->where('unit', $kdunit)
						// ~ ->orderBy('date', 'desc')
						// ~ ->get();

		// ~ foreach($rows as $row) {
			// ~ $arrData[] = [
				// ~ 'kode' => $row->hash,
				// ~ 'uraian' => $row->date. ' '.strtoupper($row->ref).' #'.$row->perihal,
			// ~ ]; 
		// ~ }

		// ~ return DropdownController::option2($arrData);
	// ~ }
}
