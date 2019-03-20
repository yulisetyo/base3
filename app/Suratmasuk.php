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
			select m.* 
			from pbn_mail.mail_in m 
			where m.active = 'y' 
				  and m.unit = ? 
				  and m.id not in (select distinct d.mailinId
								   from pbn_mail.mail_in_disp d) 
				  and m.id not in (select distinct p.mailinId
								   from pbn_mail.mail_in_pos p);
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
	 * description 
	 */
	public static function inboxSekretaris($kdunit)
	{
		return DB::select("
			SELECT m.*
			FROM pbn_mail.mail_in m
			RIGHT JOIN (SELECT DISTINCT d.mailinId, d.active, d.`to`, d.`from`
						FROM pbn_mail.mail_in_disp d
						WHERE d.active = 'y' AND d.`to` = ?) t 
				ON t.mailinId = m.id AND t.active = m.active
			WHERE m.active = 'y'
			ORDER BY m.time DESC
		", [$kdunit]);
	}

	/**
	 * description 
	 */
	public static function inboxEselon2($kdunit)
	{
		return DB::select("
			SELECT m.*
			FROM pbn_mail.mail_in m
			RIGHT JOIN (SELECT DISTINCT d.mailinId
							FROM pbn_mail.mail_in_disp d
							WHERE d.active = 'y' 
								AND d.`to` = ? AND d.`to` != d.`from`
								AND d.mailinId NOT IN (SELECT DISTINCT h.mailinId 
															  FROM pbn_mail.mail_in_push h
															  WHERE h.active = 'y' 
																	  AND h.`to` = ?)
							##
							UNION
							##
							SELECT DISTINCT d.mailinId
							FROM pbn_mail.mail_in_disp d
							WHERE d.active = 'y' 
								AND d.`to` = ? AND d.`to` != d.`from`
								AND d.mailinId IN (SELECT DISTINCT h.mailinId 
														FROM pbn_mail.mail_in_push h
														WHERE h.active = 'y' 
															AND h.`to` = ?)) t 
				ON m.id = t.mailinId
			WHERE m.active = 'y'
			ORDER BY `date` DESC
		", [$kdunit, $kdunit, $kdunit, $kdunit]);
	}

	/**
	 * SURAT YANG MASUK KE INBOX ESELON 3 YANG TIDAK MEMILIKI SEKRETARIS
	 * TERDIRI DARI SURAT YANG DIDISPOSISIKAN OLEH ESELON 2
	 * DAN SURAT YANG DITERUSKAN OLEH ESELON III LAIN (DALAM UNIT ESELON 2 YANG SAMA)
	 */
	public static function inboxEselon3NonSekre($kdunit)
	{
		return DB::select("
			SELECT m.*
			FROM pbn_mail.mail_in m
			RIGHT JOIN (SELECT DISTINCT d.mailinId
						FROM pbn_mail.mail_in_disp d
						WHERE d.active = 'y'
							  AND d.`to` = ?
							  AND d.`from` != d.`to`) d 
				ON m.id = d.mailinId
			WHERE m.active = 'y'
			ORDER BY m.`date` DESC
		", [$kdunit]);
	}

	/**
	 * SURAT YANG MASUK KE INBOX ESELON 3 YANG MEMILIKI SEKRETARIS
	 * TERDIRI DARI SURAT YANG DI PUSH SEKRETARISNYA
	 * DAN SURAT YANG DIDISPOSISIKAN OLEH ESELON 2
	 * DAN SURAT YANG DITERUSKAN OLEH ESELON III LAIN (DALAM UNIT ESELON 2 YANG SAMA)
	 */
	public static function inboxEselon3Sekre($kdunit)
	{
		return DB::select("
			SELECT m.*
			FROM pbn_mail.mail_in m
			RIGHT JOIN (SELECT DISTINCT d.mailinId
							FROM pbn_mail.mail_in_disp d
							WHERE d.active = 'y' 
								AND d.`to` = ? AND d.`to` != d.`from`
								AND d.mailinId NOT IN (SELECT DISTINCT h.mailinId 
															  FROM pbn_mail.mail_in_push h
															  WHERE h.active = 'y' 
																	  AND h.`to` = ?)
							##
							UNION
							##
							SELECT DISTINCT d.mailinId
							FROM pbn_mail.mail_in_disp d
							WHERE d.active = 'y' 
								AND d.`to` = ? AND d.`to` != d.`from`
								AND d.mailinId IN (SELECT DISTINCT h.mailinId 
														FROM pbn_mail.mail_in_push h
														WHERE h.active = 'y' 
															AND h.`to` = ?)) t 
				ON m.id = t.mailinId
			WHERE m.active = 'y'
			ORDER BY `date` DESC
		", [$kdunit, $kdunit, $kdunit, $kdunit]);
	}

	/**
	 * SURAT YANG MASUK KE INBOX ESELON 4
	 * TERDIRI DARI SURAT YANG DIDISPOSISIKAN OLEH ATASANNYA (ESELON 3)
	 * DAN PENERUSAN DARI ESELON 4 LAIN (DALAM UNIT ESELON 2 YANG SAMA)
	 */
	public static function inboxEselon4($kdunit, $nip)
	{
		return DB::select("
			SELECT m.*
			FROM pbn_mail.mail_in m
			RIGHT JOIN (		
				#DARI ATASAN DAN BELUM DI TERIMA
				SELECT 0 AS trm, d.*
				FROM pbn_mail.mail_in_disp d
				WHERE d.`to` = ? 
					  AND LENGTH(d.`to`) != LENGTH(d.`from`)
					  AND d.mailinId NOT IN (SELECT DISTINCT p.mailinId
											 FROM pbn_mail.mail_in_pos p
											 WHERE p.`to` = ?
												   AND p.`from` = p.`to`)
				#####
				UNION
				#####
				#DARI ATASAN DAN SUDAH DITERIMA DAN SIAP UNTUK DIDISPOSISIKAN
				SELECT 1 AS trm, d.*
				FROM pbn_mail.mail_in_disp d
				WHERE d.`to` = ?
					  AND LENGTH(d.`to`) != LENGTH(d.`from`)
					  AND d.mailinId IN (SELECT DISTINCT p.mailinId
										 FROM pbn_mail.mail_in_pos p
									 WHERE p.`to` = ?
										   AND p.`from` = p.`to`) ) n
				ON m.id = n.mailinId
			ORDER BY m.`date` DESC
		", [$kdunit, $kdunit, $kdunit, $kdunit]);
	}

	/**
	 * SURAT YANG MASUK KE INBOX PELAKSANA
	 * TERDIRI ATAS SURAT YANG DITERIMA DARI ESELON 4 (ATASANNYA)
	 */
	public static function inboxPelaksana($nip)
	{
		return DB::select("
			SELECT 0 AS sts_mail, rcv.* 
			FROM pbn_mail.mail_in rcv
			WHERE rcv.id IN (SELECT disp.mailinId AS id
							 FROM pbn_mail.mail_in_disp disp
							 WHERE disp.to_nip = ?) 
				  AND rcv.id IN (SELECT pos.mailinId AS id
								 FROM pbn_mail.mail_in_pos pos
								 WHERE pos.who = ?) 
			#####
			UNION
			#####
			SELECT 1 AS sts_mail, rcv.* 
			FROM pbn_mail.mail_in rcv
			WHERE rcv.id IN (SELECT disp.mailinId AS id
							 FROM pbn_mail.mail_in_disp disp
							 WHERE disp.to_nip = ?) 
				  AND rcv.id NOT IN (SELECT pos.mailinId AS id
							   FROM pbn_mail.mail_in_pos pos
							   WHERE pos.who = ?) 
			ORDER BY sts_mail ASC, id DESC
		", [$nip, $nip, $nip, $nip]);
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
		$mail = DB::connection('pbn_mail')->table('mail_in')->where('hash', $hash)->first();

		if(count($jml) == 1) {
			$row = DB::connection('pbn_mail')
						->table('mail_in_pos')
						->where('from', $kdunit)
						->where('to', $kdunit)
						->where('mailinId', $mail->id)
						->first();
						
			return 1;
		} else {
			return 0;
		}
	}

	/**
	 * MENGECEK PENERIMAAN SURAT BERDASARKAN NIP DAN KODE HASH 
	 */
	public static function cekTerimaByNIP($nip, $hash)
	{
		$mail = DB::connection('pbn_mail')->table('mail_in')->where('hash', $hash)->first();
		
		$rows = DB::connection('pbn_mail')
					->select("
					SELECT p.*
					FROM pbn_mail.mail_in_pos p
					WHERE p.`status` = 'y' AND p.mailinId = ? AND p.who = ?
					", [$mail->id, $nip]);

		return $rows;
	}

	/**
	 * MENGECEK JENIS KUALIFIKASI SURAT 
	 */
	public static function cekKualifikasi($hash)
	{
		$row = DB::connection('pbn_mail')
						->table('mail_in')
						->where('hash', $hash)
						->first();
						
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
		return DB::connection('pbn_mail')->table('mail_in')->where('hash', $hash)->first();
	}

	/**
	 * MENCARI SURAT BERDASARKAN ID
	 */
	public static function getMailinById($id)
	{
		return DB::connection('pbn_mail')->table('mail_in')->where('id', $id)->first();
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

}
