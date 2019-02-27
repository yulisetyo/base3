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
	 * SURAT MASUK INBOX YANG BELUM DITERIMA SEKRETARIS 
	 */
	//~ public static function unreceived($kdunit)
	//~ {
		//~ return DB::select("
			//~ SELECT unreceive.*, 0 AS sts_mail
			//~ FROM pbn_mail.mail_in unreceive
			//~ INNER JOIN pbn_ref.ref_mail_type t ON unreceive.type=t.mail_type
			//~ WHERE unreceive.active='y' 
				  //~ AND unreceive.unit = ? 
				  //~ AND unreceive.id NOT IN (SELECT DISTINCT d.mailinId
										   //~ FROM pbn_mail.mail_in_pos d
										   //~ WHERE d.`to` = ?)
		//~ ", [$kdunit, $kdunit]);
	//~ }

	/**
	 * SURAT MASUK INBOX YANG SUDAH DITERIMA SEKRETARIS
	 * (JIKA UNIT MEMILIKI SEKRETARIS)
	 */
	//~ public static function received($kdunit)
	//~ {
		//~ return DB::select("
			//~ /*SURAT MASUK INBOX YANG BELUM DITERIMA*/
			//~ SELECT t.*
			//~ FROM (SELECT unreceive.*, 0 as sts_mail
				//~ FROM pbn_mail.mail_in unreceive
				//~ INNER JOIN pbn_ref.ref_mail_type t ON unreceive.type=t.mail_type
				//~ WHERE unreceive.active='y' 
					  //~ AND unreceive.unit = ? 
					  //~ AND unreceive.id NOT IN (SELECT DISTINCT d.mailinId
											   //~ FROM pbn_mail.mail_in_pos d
											   //~ WHERE d.`to` = ?)
				//~ ORDER BY time DESC) t
			//~ #####
			//~ UNION
			//~ #####
			//~ /*SURAT MASUK INBOX YANG SUDAH DITERIMA*/
			//~ SELECT t.*
			//~ FROM (SELECT received.*, 1 as sts_mail
				//~ FROM pbn_mail.mail_in received
				//~ INNER JOIN pbn_ref.ref_mail_type t ON received.type=t.mail_type
				//~ WHERE received.active = 'y' 
					  //~ AND received.unit = ? 
					  //~ AND received.id IN (SELECT DISTINCT d.mailinId
										  //~ FROM pbn_mail.mail_in_pos d
										  //~ WHERE d.`to` = ?)
				//~ ORDER BY time DESC) t
			//~ ORDER BY time DESC
		//~ ", [$kdunit, $kdunit, $kdunit, $kdunit]);
	//~ }

	/**
	 * SURAT MASUK INBOX YANG SUDAH DITERIMA SEKRETARIS
	 * STATUSNYA BELUM DI PUSH KE ATASAN SEKRETARIS
	 * (JIKA UNIT MEMILIKI SEKRETARIS)
	 */
	//~ public static function unpushed($kdunit)
	//~ {
		//~ return DB::select("
			//~ SELECT unpush.*, 0 AS sts_mail
			//~ FROM (SELECT m.*
				  //~ FROM pbn_mail.mail_in m
				  //~ INNER JOIN pbn_ref.ref_mail_type t ON m.type=t.mail_type
				  //~ WHERE m.active='y' 
						//~ AND m.unit = ? 
						//~ AND m.id IN (SELECT DISTINCT d.mailinId
									 //~ FROM pbn_mail.mail_in_pos d
									 //~ WHERE d.to = ?)) unpush
			//~ WHERE unpush.id NOT IN (SELECT DISTINCT p.mailinId
									//~ FROM pbn_mail.mail_in_push p
									//~ WHERE p.`to` = ?)
		//~ ", [$kdunit, $kdunit, $kdunit]);
	//~ }

	/**
	 * SURAT MASUK INBOX YANG SUDAH DITERIMA SEKRETARIS
	 * STATUSNYA SUDAH DI PUSH KE ATASAN SEKRETARIS
	 * (JIKA UNIT MEMILIKI SEKRETARIS)
	 */
	//~ public static function pushed($kdunit)
	//~ {
		//~ return DB::select("
			//~ SELECT pushed.*
			//~ FROM (SELECT m.*
				  //~ FROM pbn_mail.mail_in m
				  //~ INNER JOIN pbn_ref.ref_mail_type t ON m.type=t.mail_type
				  //~ WHERE m.active='y' 
						//~ AND m.unit = ? 
						//~ AND m.id IN (SELECT DISTINCT d.mailinId
									 //~ FROM pbn_mail.mail_in_pos d
									 //~ WHERE d.`to` = ?)) pushed
			//~ WHERE pushed.id IN (SELECT DISTINCT p.mailinId
								//~ FROM pbn_mail.mail_in_push p
								//~ WHERE p.`to` = ?)
		//~ ", [$kdunit, $kdunit, $kdunit]);
	//~ }

	/**
	 * SURAT MASUK INBOX YANG BELUM DITERIMA ATASAN SEKRETARIS
	 * (JIKA UNIT MEMILIKI SEKRETARIS)
	 */
	//~ public static function unread($kdunit)
	//~ {
		//~ return DB::select("
			//~ SELECT unread.*
			//~ FROM (SELECT pushed.*
				  //~ FROM (SELECT m.*
						//~ FROM pbn_mail.mail_in m
						//~ INNER JOIN pbn_ref.ref_mail_type t ON m.type=t.mail_type
						//~ WHERE m.active='y' 
							  //~ AND m.unit = ? 
							  //~ AND m.id IN (SELECT DISTINCT d.mailinId
										   //~ FROM pbn_mail.mail_in_pos d
										   //~ WHERE d.`to` = ?)) pushed
				  //~ WHERE pushed.id IN (SELECT DISTINCT p.mailinId
									  //~ FROM pbn_mail.mail_in_push p
									  //~ WHERE p.`to` = ?)) unread
			//~ WHERE unread.id NOT IN (SELECT DISTINCT d.mailinId
									//~ FROM pbn_mail.mail_in_pos d
									//~ WHERE d.`to` = ?)
		//~ ", [$kdunit, $kdunit, $kdunit, $kdunit]);
	//~ }

	/**
	 * SURAT MASUK INBOX YANG SUDAH DITERIMA ATASAN SEKRETARIS
	 * (JIKA UNIT MEMILIKI SEKRETARIS)
	 */
	//~ public static function beread()
	//~ {
		//~ return DB::select("
			//~ SELECT beread.*
			//~ FROM (SELECT pushed.*
				  //~ FROM (SELECT m.*
						//~ FROM pbn_mail.mail_in m
						//~ INNER JOIN pbn_ref.ref_mail_type t ON m.type=t.mail_type
						//~ WHERE m.active='y' 
							  //~ AND m.unit = ? 
							  //~ AND m.id IN (SELECT DISTINCT d.mailinId
										   //~ FROM pbn_mail.mail_in_pos d
										   //~ WHERE d.`to` = ?)) pushed
				  //~ WHERE pushed.id IN (SELECT DISTINCT p.mailinId
									  //~ FROM pbn_mail.mail_in_push p
									  //~ WHERE p.`to` = ?)) beread
			//~ WHERE beread.id IN (SELECT DISTINCT d.mailinId
								//~ FROM pbn_mail.mail_in_pos d
								//~ WHERE d.`to` = ?)
		//~ ", [$kdunit, $kdunit, $kdunit, $kdunit]);
	//~ }

	/**
	 * SURAT MASUK INBOX YANG SUDAH DITERIMA ATASAN SEKRETARIS
	 * DAN SUDAH DI DISPOSISIKAN KE UNIT BAWAHANNYA
	 * (JIKA UNIT MEMILIKI SEKRETARIS)
	 */
	//~ public static function disposed($kdunit)
	//~ {
		//~ return DB::select("
			//~ SELECT dispo.*
			//~ FROM (SELECT beread.*
				  //~ FROM (SELECT pushed.*
						//~ FROM (SELECT m.*
							  //~ FROM pbn_mail.mail_in m
							  //~ INNER JOIN pbn_ref.ref_mail_type t ON m.type=t.mail_type
							  //~ WHERE m.active='y' 
									//~ AND m.unit = ? 
									//~ AND m.id IN (SELECT DISTINCT d.mailinId
												 //~ FROM pbn_mail.mail_in_pos d
												 //~ WHERE d.`to` = ?)) pushed
						//~ WHERE pushed.id IN (SELECT DISTINCT p.mailinId
											//~ FROM pbn_mail.mail_in_push p
											//~ WHERE p.`to` = ?)) beread
				  //~ WHERE beread.id IN (SELECT DISTINCT d.mailinId
									  //~ FROM pbn_mail.mail_in_pos d
									  //~ WHERE d.`to` = ?)) dispo
			//~ WHERE dispo.id IN (SELECT d.mailinId
							   //~ FROM pbn_mail.mail_in_disp d
							   //~ WHERE d.`from` = ?)
		//~ ", [$kdunit, $kdunit, $kdunit, $kdunit, $kdunit]);
	//~ }

	/**
	 * SURAT MASUK INBOX YANG SUDAH DITERIMA ATASAN SEKRETARIS
	 * DAN SUDAH DI TERUSKAN KE UNIT BAWAHANNYA
	 * (JIKA UNIT MEMILIKI SEKRETARIS)
	 */
	//~ public static function forwarded()
	//~ {
		//~ return DB::select("
			//~ SELECT forward.*
			//~ FROM (SELECT beread.*
				  //~ FROM (SELECT pushed.*
						//~ FROM (SELECT m.*
							  //~ FROM pbn_mail.mail_in m
							  //~ INNER JOIN pbn_ref.ref_mail_type t ON m.type=t.mail_type
							  //~ WHERE m.active='y' 
									//~ AND m.unit = ? 
									//~ AND m.id IN (SELECT DISTINCT d.mailinId
												 //~ FROM pbn_mail.mail_in_pos d
												 //~ WHERE d.`to` = ?)) pushed
						//~ WHERE pushed.id IN (SELECT DISTINCT p.mailinId
											//~ FROM pbn_mail.mail_in_push p
											//~ WHERE p.`to` = ?)) beread
				  //~ WHERE beread.id IN (SELECT DISTINCT d.mailinId
									  //~ FROM pbn_mail.mail_in_pos d
									  //~ WHERE d.`to` = ?)) forward
			//~ WHERE forward.id IN (SELECT d.mailinId
								 //~ FROM pbn_mail.mail_in_disp d
								 //~ WHERE d.`from` = ?
									   //~ AND d.`from` != d.`to`
									   //~ AND LENGTH(d.`from`)=LENGTH(d.`to`))
		//~ ", [$kdunit, $kdunit, $kdunit, $kdunit, $kdunit]);
	//~ }

	/**
	 * SURAT YANG MASUK KE INBOX S 
	 */
	//~ public static function uninboxEselon4($kdunit, $nip)
	//~ {
		//~ return DB::select("
			//~ SELECT m.*
			//~ FROM pbn_mail.mail_in m
			//~ RIGHT JOIN (SELECT DISTINCT disp.mailinId
							//~ FROM pbn_mail.mail_in_disp disp
							//~ WHERE disp.`to` = '11211015050080104' 
							//~ AND disp.`from` != disp.`to`
							//~ AND disp.mailinId IN (SELECT pos.mailinId
										//~ FROM pbn_mail.mail_in_pos pos
										//~ WHERE pos.`to` = '11211015050080104') ) dp on m.id = dp.mailinId
		//~ ", [$kdunit, $kdunit]);
	//~ }

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
	 * description 
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
	 * description 
	 */
	public static function cekTerima($kdunit, $hash)
	{
		$jml = DB::connection('pbn_mail')
					->table('mail_in')
					->where('hash', $hash)
					->first();
					
		if(count($jml) == 1) {
			$row = DB::connection('pbn_mail')
						->table('mail_in_pos')
						->where('from', $kdunit)
						->where('to', $kdunit)
						->where('mailinId', $jml->id)
						->first();
						
			return count($row);
		} else {
			return 0;
		}
	}

	/**
	 * description 
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

		return count($rows);
	}

	/**
	 * description 
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
	 * description 
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
	 * description 
	 */
	public static function disposisi($kdunit, $eselon, $hash)
	{
		$where['hash'] = " AND m.`hash` = ? ";
		
		if($eselon == '1') {
			
			$where['length'] = " AND LENGTH(d.`to`) = 10 ";
			$param = [$hash, $kdunit];
			
		} else if($eselon == '2') {
			
			$where['length'] = " AND LENGTH(d.`to`) = 13 ";
			$param = [$hash, $kdunit];
			
		} else if($eselon == '3') {
			
			$where['length'] = " AND LENGTH(d.`to`) = 15 ";
			$param = [$hash, $kdunit];
			
		} else if($eselon == '4') {
			
			$where['length'] = " AND LENGTH(d.`to`) = 17 ";
			$param = [$hash, $kdunit];
			
		}

		$where = implode(" ", $where);
		
		$rows = DB::connection('pbn_mail')
			->select("
				SELECT d.id, d.mailinId, d.`from`, d.`to`
				FROM pbn_mail.mail_in_disp d
				JOIN pbn_mail.mail_in m ON m.id = d.mailinId
				WHERE d.`active` = 'y' AND m.`hash` = '6f0fa90b351d67063ccdbc8aeb82ffd83286e44a' AND d.`to` = '1121101505' AND LENGTH(d.`to`) = 10
			");
	}

}
