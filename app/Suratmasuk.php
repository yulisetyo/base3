<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Suratmasuk extends Model
{
	protected $fillable = [];
	
	protected $connection = 'pbn_mail';
    
    protected $table = 'mail_in';
    
    public $primaryKey = 'id';
    
    public $incrimenting = true;

	/**
	 * description 
	 */
	public static function dataDariPerekaman($kdunit)
	{
		return DB::connection('pbn_mail')->select("
			SELECT m.* 
			FROM pbn_mail.mail_in m 
			WHERE m.active = 'y' 
				  AND m.unit = ? 
				  AND m.id NOT IN (SELECT DISTINCT d.mailinId
								   FROM pbn_mail.mail_in_disp d) 
				  AND m.id NOT IN (SELECT DISTINCT p.mailinId
								   FROM pbn_mail.mail_in_pos p);
		", [$kdunit]);
	}

	/**
	 * description 
	 */
	public static function detailSurat($hash)
	{
		return DB::connection('pbn_mail')->table('mail_in')
					->where('hash', $hash)
					->first();
	}

	/**
	 * MENGECEK APAKAH UNIT MEMILIKI SEKRETARIS ATAU TIDAK 
	 */
	public static function cekSekreUnit($nip, $kdunit, $eselon)
	{
		$eselon = substr($eselon, 0, 1);
		$param = [$nip, $kdunit];
		
		if($eselon == '7' || $eselon == '9') {
			$condition = " sekre.nip = ? AND sekre.unit = ? ";
		} else {
			$condition = " sekre.upNip = ? AND sekre.unit = ? ";
		}
		
		return DB::select("
			SELECT sekre.id, 
				   sekre.nip,
				   sekre.unit AS kdunit,
				   sekre.upNip AS atasan,
				   sekre.upJab AS jabatan
			FROM pbn_mail.dt_emp_under sekre
			WHERE $condition
		", $param );
	}

	/**
	 * MENGECEK PENERIMAAN SURAT BERDASARKAN UNIT DAN KODE HASH
	 */
	public static function cekTerima($kdunit, $hash)
	{
		$mail = self::detailSurat($hash);

		$row = DB::connection('pbn_mail')
					->table('mail_in_pos')
					->where('from', $kdunit)
					->where('to', $kdunit)
					->where('mailinId', $mail->id)
					->first();
					
		return count($row);
	}

	/**
	 * MENGECEK PENERIMAAN SURAT BERDASARKAN NIP DAN KODE HASH 
	 */
	public static function cekTerimaByNIP($nip, $hash)
	{
		$mail = self::detailSurat($hash);
		
		$rows = DB::connection('pbn_mail')
					->select("
					SELECT p.*
					FROM pbn_mail.mail_in_pos p
					WHERE p.`status` = 'y' AND p.mailinId = ? AND p.who = ?
					", [$mail->id, $nip]);

		return ($rows);
	}

	/**
	 * MENGECEK JENIS KUALIFIKASI SURAT 
	 */
	public static function cekKualifikasi($hash)
	{
		$row = self::detailSurat($hash);
						
		return $row->kualifikasi;
	}

	/**
	 * MENGECEK APAKAH SURAT SUDAH DI PINNED ATAU BELUM 
	 */
	public static function cekPinned($nip, $mailinId)
	{
		$row = DB::connection('pbn_mail')
					->select("
			SELECT m.`id`, m.`hash`, p.nip, p.id AS pid, p.`who`, p.active
			FROM pbn_mail.mail_in m
			INNER JOIN pbn_mail.mail_in_pinned p ON m.id=p.mailinId AND p.active=m.active
			WHERE m.active='y' AND p.nip=? AND m.`id`=?
				", [$nip, $mailinId]);
				
		return count($row);
	}

	/**
	 * MENGECEK APAKAH ADA CATATAN UNTUK SURAT BERKENAAN
	 */
	public static function cekNote($nip, $mailinId)
	{
		$row = DB::connection('pbn_mail')->table('mail_in_note')
					->where('active', 'y')
					->where('who', $nip)
					->where('mailinId', $mailinId)
					->first();

		return count($row);
	}

	/**
	 * UNTUK MENGECEK STATUS DISPOSISISI SURAT
	 * APAKAH TELAH DIDISPOSISIKAN ATAU BELUM 
	 */
	public static function cekDisposisi($kdunit, $nip, $hash)
	{
		$rows =  DB::connection('pbn_mail')->select("
			SELECT d.*
			FROM pbn_mail.mail_in_disp d
			WHERE (d.`from` = ? OR d.from_nip = ?)
					AND d.mailinId IN (SELECT m.id 
										FROM mail_in m 
										WHERE m.`hash` = ?) 


		", [$kdunit, $nip, $hash]);

		return count($rows);
	}

	/**
	 * MENCARI URAT BERDASARKAN KODE HASH 
	 */
	public static function getMailinByHash($hash)
	{
		return self::detailSurat($hash);
	}

	/**
	 * MENCARI SURAT BERDASARKAN ID
	 */
	public static function getMailinById($id)
	{
		return DB::connection('pbn_mail')->table('mail_in')->where('id', $id)->first();
	}

	/**
	 * MENCARI FILE HARDCOPY SURAT BERDASARKAN KODE HASH
	 */
	public static function getFileSurat($hash)
	{
		$row = DB::connection('pbn_mail')->select("
			SELECT m.id, m.`hash`, f.idFile, f.realname, f.filetype, f.filesize
			FROM pbn_mail.mail_in m
			JOIN pbn_mail.file_upload f ON m.idFile = f.idFile
			WHERE m.active='y' AND m.`hash` = ?
		", [$hash]);

		return $row[0];
	}

	/***
	 * MENAMPILKAN ASAL DISPOSISI
	 */
	public static function semuaDisp($mailinId, $kdunit)
	{
		$es1 = substr($kdunit, 0, 10);
		$es2 = substr($kdunit, 0, 13).'%';
		$es3 = substr($kdunit, 0, 15).'%';
		$es4 = substr($kdunit, 0, 17).'%';
		
		return DB::connection('pbn_mail')->select("
			SELECT DISTINCT d.from, d.from_nip, d.time AS time, d.value, d.note, d.who
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
	}

	/**
	 * MENAMPILKAN KEPADA SIAPA SURAT TELAH DISIPOSISIKAN
	 */
	public static function dispQuery($mailinId, $from, $value)
	{
		return DB::connection('pbn_mail')->select("
			SELECT d.*
			FROM pbn_mail.mail_in_disp d
			WHERE d.active = 'y'
				  AND d.mailinId = ?
				  AND d.`from` = ?
				  AND d.value = ?
			ORDER BY `time` ASC
		", [$mailinId, $from, $value]);
	}

	/**
	 * UNTUK MELAKUKAN PINNED TERHADAP SURAT MASUK
	 */
	public static function docPinned($hash, $data)
	{
		$mail = self::detailSurat($hash);
		$mailinId = $mail->id;

		$pinned = DB::connection('pbn_mail')->table('mail_in_pinned')->insert($data);
	}

	/**
	 * UNTUK MELAKUKAN UNPINNED TERHADAP SURAT MASUK
	 */
	public static function docUnpinned($hash, $data)
	{
		$mail = self::detailSurat($hash);
		$mailinId = $mail->id;

		$unpinned = DB::connection('pbn_mail')->table('mail_in_pinned')->where('mailinId', $mailinId)->update($data);
	}

	/**
	 * UNTUK MENAMPILKAN DATATABEL SURAT YANG DITANDAI/PINNED
	 */
	public static function tabelPinned($nip)
	{
		return DB::connection('pbn_mail')->select("
			SELECT m.*, t.mail_typeAbre, t.mail_typeName
			FROM pbn_mail.mail_in m
			INNER JOIN pbn_ref.ref_mail_type t
				ON m.`type` = t.mail_type
			RIGHT JOIN (SELECT p.*
						FROM pbn_mail.mail_in_pinned p
						WHERE p.active = 'y' AND (p.who = ? OR p.nip = ?) ) p
				ON m.id = p.mailinId
		", [$nip, $nip]);
	}

	/**
	 * description 
	 */
	public static function suratMasukBelumDisposisi($kdunit, $nip, $eselon)
	{
		if(isset($_GET['tipe'])) {
			if($_GET['tipe'] == 'und') {
				$whereTipe = " AND m.type = 7 ";
			} else {
				$whereTipe = " AND m.type != 7 ";
			}
		} else {
			$whereTipe = " ";
		}
		
		return DB::connection('pbn_mail')->select("
			SELECT m.*, d.mailinId
			FROM pbn_mail.mail_in m
			INNER JOIN (SELECT DISTINCT p.mailinId
						FROM pbn_mail.mail_in_pos p
						WHERE p.`status` = 'y' AND p.`to` = ?) p
				ON p.mailinId = m.id
			LEFT OUTER JOIN (SELECT DISTINCT d.mailinId, d.`from`
							 FROM pbn_mail.mail_in_disp d
							 WHERE (d.`from` = ?) AND d.active = 'y') d
				ON d.mailinId = m.id
			WHERE m.active = 'y' ".$whereTipe."
				  AND d.mailinId IS NULL 
			ORDER BY m.kualifikasi ASC
		",[$kdunit, $kdunit]);
	}

	/**
	 * description 
	 */
	public static function suratMasukDariAtasTapiBelumDisposisi($kdunit, $nip, $eselon)
	{
		return DB::connection('pbn_mail')->select("
			SELECT m.*, p.mailinId, s.mailinId
			FROM pbn_mail.mail_in m 
			INNER JOIN (SELECT DISTINCT d.mailinId, d.`to` 
						FROM pbn_mail.mail_in_disp d 
							WHERE d.active = 'y' 
								  AND d.`from` <> ?
									AND d.`to` = ?) d
			   ON d.mailinId = m.id
			LEFT OUTER JOIN (SELECT DISTINCT s.mailinId 
							 FROM pbn_mail.mail_in_disp s 
								  WHERE s.active = 'y' 
										AND s.`from` = ?) s
			   ON s.mailinId = m.id
			LEFT OUTER JOIN (SELECT DISTINCT p.mailinId
							 FROM pbn_mail.mail_in_pos p
							 WHERE p.`status` = 'y'
								   AND (p.`from` = ? OR p.`to` = ?)) p
			   ON p.mailinId = m.id
			WHERE m.active = 'y' 
				  AND p.mailinId IS NULL
				  AND s.mailinId IS NULL
			ORDER BY m.kualifikasi DESC, m.id DESC
		",[$kdunit, $kdunit, $kdunit, $kdunit, $kdunit]);
	}

	/**
	 * description 
	 */
	public static function suratMasukSudahDisposisi($kdunit, $nip, $eselon)
	{
		$queryAdditional1 = " ";
		$queryAdditional2 = " ";
		$queryAdditional3 = " ";

		if((int) session('eselon') < 30 && session('eselon') != '') {
			$queryAdditional3 = " INNER JOIN (SELECT DISTINCT y.mailinId FROM pbn_mail.mail_in_push y) y ON y.mailinId = m.id ";
		} 
		
		if(isset($_GET['follow'])) {
			$queryAdditional1 = " INNER JOIN (SELECT DISTINCT n.mailinId FROM pbn_mail.mail_in_note n) n ";
			$queryAdditional2 = " ";
		}
		 
		if(isset($_GET['pinned'])) {
			$queryAdditional1 = " INNER JOIN (SELECT DISTINCT n.mailinId FROM pbn_mail.mail_in_note n) n ";
			$queryAdditional2 = " AND n.active = 'y' AND n.who = '' ";
		}

		if(isset($_GET['tipe'])) {
			$tipe = $_GET['tipe'];
			
			if($tipe != '') {

				if($tipe == 'und') {
					$query1 = " AND m.type = 7 ";
				} else if($tipe == 'non') {
					$query1 = " AND m.type != 7 ";
				} else {
					$query1 = " ";
				}
				
			} else {
				$query1 = " ";
			}
		}

		$query2 = " ";
		
		return DB::connection('pbn_mail')->select("
			
		",[$kdunit, $kdunit]);
	}
}
