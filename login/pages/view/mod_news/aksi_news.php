<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<link href='style.css' rel='stylesheet' type='text/css'>
	<center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=../../index.php><b>LOGIN</b></a></center>";
} else {
	include "../../../config/koneksi.php";
	include "../../../../config/library.php";
	include "../../../../config/fungsi_thumb.php";
	include "../../../../config/fungsi_seo.php";
	
	$module=$_GET['module'];
	$act=$_GET['act'];
	// Hapus news
	if ($module=='news' AND $act=='hapus'){
		$data=mysql_fetch_array(mysql_query("SELECT Imgpath,fl_active FROM tb_article WHERE gal='$_GET[id]'"));
			if ($data['Imgpath']!=''){
				$Imgpath = $data['Imgpath'];
				$remove = "../../../../".$Imgpath;

				$real_Imgpath = str_replace("images/gallery/","",$Imgpath);
				$real_Imgpath = trim($real_Imgpath);
				unlink($remove);
				mysql_query("DELETE FROM tb_article WHERE gal='$_GET[id]'");
			} else {
				mysql_query("DELETE FROM tb_article WHERE gal='$_GET[id]'");
			}
			$loc = "../../../?module=".$module;
		  
			echo "<script>window.location = '../../../?module='.$module'</script>
			<script language=javascript>window.location='".$loc."'</script>";
	}
	// Input news

elseif ($module=='news' AND $act=='input'){
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$acak           = rand(1,99);
	$nama_file_unik = $acak.$nama_file; 
	$nama_file_unik2 = "images/article/".$acak.$nama_file;
	$tgl=date('Y-m-d', strtotime($_POST['Date']));
	$judul_seo      = seo_title(trim($_POST['Title']));
	// Apabila ada gambar yang diupload
	if (!empty($lokasi_file)){
		if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){
			echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');
				window.location=('../../../?module=news)
			</script>";
			die('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
		}else{
			if ($tipe_file == "image/png"){
				UploadImagePNG_Article($nama_file_unik);
			} else { 
				UploadImageJPG_Article($nama_file_unik);
			}
			$sSQL = "insert into tb_article(username,
										judul,
										judul_seo,
										isi_berita,
										tanggal,
										gambar,
										judul_id,
										isi_berita_id) 
			values('$_SESSION[namauser]',
					'$_POST[Title]',
					'$judul_seo',
					'$_POST[Detail]',
					'$tgl',
					'$nama_file_unik2',
					'$_POST[Title_id]',
					'$_POST[Detail_id]')";
			mysql_query($sSQL) or die($sSQL);
			$loc = '../../../?module='.$module;
			echo "<script>document.location = '$loc'</script>";
		}
	} else {
		$sSQL = "insert into tb_article(username,
										judul,
										judul_seo,
										isi_berita,
										tanggal,
										judul_id,
										isi_berita_id) 
		values('$_SESSION[namauser]',
					'$_POST[Title]',
					'$judul_seo',
					'$_POST[Detail]',
					'$tgl',
					'$_POST[Title_id]',
					'$_POST[Detail_id]')";
		mysql_query($sSQL);
		$loc = '../../../?module='.$module;
		echo "<script>document.location = '$loc'</script>";
	}
}
// Update news

}