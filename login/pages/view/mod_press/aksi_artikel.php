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
	include "../../../../config/fungsi_indotgl.php";
	
	$module=$_GET['module'];
	$act=$_GET['act'];
	// Hapus artikel
	if ($module=='press' AND $act=='hapus'){
		$data=mysql_fetch_array(mysql_query("SELECT gambar,fl_active FROM tb_press WHERE id_article='$_GET[id]'"));
			if ($data['gambar']!=''){
				$gambar = $data['gambar'];
				$remove = "../../../".$gambar;

				$real_gambar = str_replace("images/article/","",$gambar);
				$real_gambar = trim($real_gambar);
				$gambar_small = "../../../../"."images/article/small_".$real_gambar;
				$gambar_medium = "../../../../"."images/article/medium_".$real_gambar;
				unlink($remove);
				unlink($gambar_small);   
				unlink($gambar_medium);   
				mysql_query("DELETE FROM tb_press WHERE id_article='$_GET[id]'");
			} else {
				mysql_query("DELETE FROM tb_press WHERE id_article='$_GET[id]'");
			}
			echo "<script>alert('Data anda berhasil di hapus'); window.location = '../../../?module=".$module."'</script>";
	}
	// Input press

elseif ($module=='press' AND $act=='input'){
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$acak           = rand(1,99);
	$nama_file_unik = $acak.$nama_file; 
	$nama_file_unik2 = "images/article/".$acak.$nama_file;
	$tgl=date('Y-m-d', strtotime($_POST['tanggal']));
	$judul_seo      = seo_title(trim($_POST['judul']));
	// Apabila ada gambar yang diupload
	if (!empty($lokasi_file)){
		if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){
			echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');
				window.location=('../../../?module=press)
			</script>";
			die('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
		}else{
			if ($tipe_file == "image/png"){
				UploadImagePNG_Article($nama_file_unik);
			} else { 
				UploadImageJPG_Article($nama_file_unik);
			}
			$sSQL = "insert into tb_press(judul,judul_seo,headline, 
			username,isi_berita,tanggal,gambar,headlinetext,link_video,tag,judul_id,isi_berita_id) 
			values('$_POST[judul]','$judul_seo','".$_POST[cuplikan]."', 
			'$_SESSION[namauser]','".$_POST[isi_artikel]."','$tgl','$nama_file_unik2', 
			'$_POST[cuplikan]','$_POST[link_video]','','$_POST[judul_id]','$_POST[isi_artikel_id]')";
			mysql_query($sSQL) or die($sSQL);
			$loc = '../../../?module='.$module;
			echo "<script>document.location = '$loc'</script>";
		}
	} else {
		$sSQL = "insert into tb_press(judul,judul_seo,headline,
		username,isi_berita,tanggal,headlinetext,link_video,judul_id,isi_berita_id) 
		values('$_POST[judul]','$judul_seo','$_POST[headline]', 
		'$_SESSION[namauser]','".$_POST[isi_artikel]."','$tgl',
		'".$_POST[cuplikan]."','$_POST[link_video]','$_POST[judul_id]','$_POST[isi_artikel_id]')";
		mysql_query($sSQL);
		$loc = '../../../?module='.$module;
		echo "<script>document.location = '$loc'</script>";
	}
}
// Update artikel
elseif ($module=='press' AND $act=='update')
{
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$acak           = rand(1,99);
	$nama_file_unik = $acak.$nama_file; 
	$nama_file_unik2 = "images/article/".$acak.$nama_file;
	$judul_seo      = seo_title(trim($_POST['judul']));
	// Apabila gambar tidak diganti
	if (empty($lokasi_file)){
		$sSQL = "UPDATE tb_press SET 
		judul= '$_POST[judul]',
		judul_seo   = '$judul_seo', 
		headline    = '$_POST[headline]',
		isi_berita  = '$_POST[isi_artikel]',
		tanggal = '$_POST[tanggal]',
		headlinetext  = '$_POST[cuplikan]',
		link_video = '$_POST[link_video]', 
		fl_active = '$_POST[fl_active]',
		judul_id= '$_POST[judul_id]',
		isi_berita_id= '$_POST[isi_artikel_id]'
		WHERE id_article   = '$_POST[id]'" ;
		//die($sSQL);		 
		mysql_query($sSQL) or die($sSQL);
		$loc = '../../../?module='.$module;
		echo "<script>document.location = '$loc'</script>";
	} else { 
		if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){
			echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
				window.location=('../../../?module=".$module."')</script>";
		} else {			
			/* before upload , remove old images first */
			$sSQL = "";
			$sSQL = " select gambar from tb_press where id_article='$_POST[id]'";
			$rslt=mysql_query($sSQL) or die ("error query");
			while ($row=mysql_fetch_assoc($rslt))
			{
				$gambar = $row['gambar'];
			}
			mysql_free_result($rslt);				
			if ($gambar!='')
			{
				$remove = "../../../".$gambar;	   
				$real_gambar = str_replace("images/article/","",$gambar);
				$real_gambar = trim($real_gambar);
				$gambar_small = "../../../../"."images/article/small_".$real_gambar;
				$gambar_medium = "../../../../"."images/article/medium_".$real_gambar;
				   
				unlink($remove);  
				unlink($gambar_small);   
				unlink($gambar_medium);   
				/* End of Remove old images */		   
			}	
			if ($tipe_file == "image/png"){
				UploadImagePNG_Article($nama_file_unik);
			} else {
				UploadImageJPG_Article($nama_file_unik);
			}				
			$sSQL = "UPDATE tb_press SET judul= '$_POST[judul]',
			judul_seo   = '$judul_seo', 
			headline    = '$_POST[headline]',
			isi_berita  = '$_POST[isi_artikel]',
			tanggal = '$_POST[tanggal]',
			headlinetext  = '$_POST[cuplikan]',
			link_video = '$_POST[link_video]', fl_active = '$_POST[fl_active]',
			gambar ='$nama_file_unik2',
			judul_id= '$_POST[judul_id]',
		isi_berita_id= '$_POST[isi_artikel_id]'
			WHERE id_article   = '$_POST[id]'" ;
			mysql_query($sSQL) or die($sSQL);
			$loc = '../../../?module='.$module;
			echo "<script>alert('Data anda berhasil di update'); window.location = '../../../?module=".$module."'</script>";
		}
		}
} 
elseif ($module=='press' AND $act=='hapusgambar'){ 
	mysql_query("UPDATE tb_press set gambar='' WHERE id_article='$_GET[id]'");		  
	$gambar = $_GET[namafile];
	$remove = "../../../".$gambar;
	$real_gambar = str_replace("images/article/","",$gambar);
	$real_gambar = trim($real_gambar);
	$gambar_small = "../../../../"."images/article/small_".$real_gambar;
	$gambar_medium = "../../../../"."images/article/medium_".$real_gambar;
	unlink($remove);  
	unlink($gambar_small);   
	unlink($gambar_medium);   
	header('location:../../../?module='.$module.'&act=editartikel&id='.$_GET[id]);
}
}