<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadfileController extends Controller
{

    /**
	 * description 
	 */
	public function uploadFile()
	{
		
		try {
			$targetDirectory = 'data/inbox/berkas';
			$_fileName = basename($_FILES['unggah']['name']);
			$targetFile = $targetDirectory.$_fileName;
			
			$uploadOK = 1;
			
			if(isset($_POST['submit'])) {
				
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "pdf" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "PDF") {
					return "Hanya berkas berekstensi .jpg, .png, .pdf yang dapat diupload";
				} 
			} 
			
		} catch(\Exception $e){
			
		}
	}
	
	/**
	 * description 
	 */
	public function uploadHCMI(Request $request)
	{
		try {
			$targetDirectory = 'data/inbox/berkas/';
			
			//cek folder
			$listing = file_exists($targetDirectory);
			if(!$listing) {
				mkdir($targetDirectory, 0777, true);
			}
			
			//cek file
			if(!empty($_FILES)) {
				$fileName = $_FILES['file']['name'];
				$tempFile = $_FILES['file']['tmp_name'];
				$fileParts = pathinfo($fileName);
				$targetFile = $targetDirectory.$fileName;
				$fileTypes = ['pdf', 'PDF'];
				$fileSize = $_FILES['file']['size'];
				
				//cek type file
				if(in_array($fileParts['extension'], $fileTypes)) {
					//cek ukuran file
					if($fileSize > 0 && $fileSize<=10000000) {
						$newFileName = 'surat_masuk_'.sha1(md5( rand() )).'.'.$fileParts['extension'];
						
						//pindahkan file dari php
						$localUpload = move_uploaded_file($tempFile, $targetDirectory.$newFileName);
						if($localUpload) {
							session(['file_upload_hcmi'=>$newFileName]);
							setcookie('file_upload_hcmi', $newFileName, time()+3600, "/");
							return '1';
						} else {
							throw new \Exception("file gagal di upload ke local storage");
						}
					} else {
						throw new \Exception("ukuran file tidak valid, periksa data Anda");
					}
				} else {
					throw new \Exception("tipe file tidak sesuai");
				}
			} else {
				throw new \Exception("tidak ada file yang diupload");
			}
			 
		} catch(\Exception $e){
			//~ return $e->getMessage();
			return "terdapat kesalahan lainnya, hubungi Administrator";
		}
	}
	
    /**
	 * description 
	 */
	public function xuploadHCMI(Request $request)
	{
		//~ try {
			$targetDirectory = 'data/inbox/berkas/';
			
			if(!empty($_FILES)) {
				$fileName = $_FILES['upload']['name'];
				$tempFile = $_FILES['upload']['tmp_name'];
				$targetFile = $targetDirectory.$fileName;
				$fileTypes = array('PDF', 'pdf', 'PNG', 'png', 'JPG', 'jpg');
				$fileParts = pathinfo($_FILES['upload']['name']);
				$fileSize = $_FILES['upload']['size'];
				
				if(in_array($fileParts['extension'], $fileTypes)) { // jika file sesuai
					
					if($fileSize > 0 && $fileSize <= 5000000) { // jika ukuran file lebih besar dari 0Kb dan lebih kecil dari 5Mb
						
						$newFileName = 'HCMI_'.md5(uniqid(rand(), TRUE)).'.'.$fileParts['extension'];
						
						move_uploaded_file($tempFile, $targetDirectory.$newFileName);
						
						if(file_exists($targetDirectory.$newFileName)) {
							
							session(['file_upload_hcmi' => $newFileName]);
							return 1;
							
						} else {
							throw new \Exception("Gagal mengunggah berkas");
						}
						
					} else {
						throw new \Exception("Ukuran berkas tidak valid");
					}
					
				} else {
					throw new \Exception("Tipe berkas tidak sesuai");
				}
				
			} else {
				throw new \Exception("Tidak ada berkas yang di unggah");
			} 
			
		//~ } catch(\Exception $e){
			//~ return $e;
		//~ }
	}
}
