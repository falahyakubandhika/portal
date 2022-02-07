<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<link href='style.css' rel='stylesheet' type='text/css'>
	<center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=../../index.php><b>LOGIN</b></a></center>";
} else {
	include "../../../config/koneksi.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_thumb.php";
	include "../../../config/fungsi_seo.php";
	
	$module=$_GET['module'];
	$act=$_GET['act'];
	// Hapus catgal
	if ($module=='catgal' AND $act=='hapus'){
		$data=mysql_fetch_array(mysql_query("SELECT Imgpath,fl_active FROM tb_catgal WHERE gal='$_GET[id]'"));
			if ($data['Imgpath']!=''){
				$Imgpath = $data['Imgpath'];
				$remove = "../../../".$Imgpath;

				$real_Imgpath = str_replace("images/gallery/","",$Imgpath);
				$real_Imgpath = trim($real_Imgpath);
				unlink($remove);
				mysql_query("DELETE FROM tb_catgal WHERE gal='$_GET[id]'");
			} else {
				mysql_query("DELETE FROM tb_catgal WHERE gal='$_GET[id]'");
			}
			$loc = "../../media.php?module=".$module;
		  
			echo "<script>window.location = '../../media.php?module='.$module'</script>
			<script language=javascript>window.location='".$loc."'</script>";
	}
	// Input catgal

elseif ($module=='catgal' AND $act=='input'){
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$acak           = rand(1,99);
	$nama_file_unik = $acak.$nama_file; 
	$nama_file_unik2 = "images/gallery/".$acak.$nama_file;
	$tgl=date('Y-m-d', strtotime($_POST['Date']));
	// Apabila ada gambar yang diupload
	if (!empty($lokasi_file)){
		if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){
			echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');
				window.location=('../../media.php?module=catgal)
			</script>";
			die('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
		}else{
			if ($tipe_file == "image/png"){
				UploadImagePNG_catgal($nama_file_unik);
			} else { 
				UploadImageJPG_catgal($nama_file_unik);
			}
			$sSQL = "insert into tb_catgal(Title,Detail,Date,Imgpath,tip) 
			values('$_POST[Title]','".$_POST[Detail]."','$tgl','$nama_file_unik2','$_POST[tip]')";
			mysql_query($sSQL) or die($sSQL);
			$loc = '../../media.php?module='.$module;
			echo "<script>document.location = '$loc'</script>";
		}
	} else {
		$sSQL = "insert into tb_catgal(Title,Detail,Date,Subtitle,tip) 
		values('$_POST[Title]','".$_POST[Detail]."','$tgl','".mysql_real_escape_string($_POST[Subtitle])."','$_POST[tip]')";
		mysql_query($sSQL);
		$loc = '../../media.php?module='.$module;
		echo "<script>document.location = '$loc'</script>";
	}
}
// Update catgal
elseif ($module=='catgal' AND $act=='update')
{
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$acak           = rand(1,99);
	$nama_file_unik = $acak.$nama_file; 
	$nama_file_unik2 = "images/gallery/".$acak.$nama_file;
	// Apabila Imgpath tidak diganti
	if (empty($lokasi_file)){
		$sSQL = "UPDATE tb_catgal SET Title= '$_POST[Title]',
		Detail  = '$_POST[Detail]',
		fl_active = '$_POST[fl_active]',
		tip = '$_POST[tip]'
		WHERE gal   = '$_POST[id]'" ;
		//die($sSQL);		 
		mysql_query($sSQL) or die($sSQL);
		$loc = '../../media.php?module='.$module;
		echo "<script>document.location = '$loc'</script>";
	} else { 
		if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){
			echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
				window.location=('../../media.php?module=catgal)</script>";
		} else {			
			/* before upload , remove old images first */
			$sSQL = "";
			$sSQL = " select Imgpath from tb_catgal where gal='$_POST[id]'";
			$rslt=mysql_query($sSQL) or die ("error query");
			while ($row=mysql_fetch_assoc($rslt))
			{
				$Imgpath = $row['Imgpath'];
			}
			mysql_free_result($rslt);				
			if ($Imgpath!='')
			{
				$remove = "../../../".$Imgpath;	   
				$real_Imgpath = str_replace("images/gallery/","",$Imgpath);
				$real_Imgpath = trim($real_Imgpath);
				   
				unlink($remove);  
				/* End of Remove old images */		   
			}	
			if ($tipe_file == "image/png"){
				UploadImagePNG_catgal($nama_file_unik);
			} else {
				UploadImageJPG_catgal($nama_file_unik);
			}				
			$sSQL = "UPDATE tb_catgal SET Title= '$_POST[Title]',
			Detail  = '".$_POST[Detail]."',
			fl_active = '$_POST[fl_active]',
			Imgpath ='$nama_file_unik2',
			tip = '$_POST[tip]'
			WHERE gal   = '$_POST[id]'" ;
			mysql_query($sSQL) or die($sSQL);
			$loc = '../../media.php?module='.$module;
			echo "<script>document.location = '$loc'</script>";
		}
		}
} 
elseif ($module=='catgal' AND $act=='hapusgambar'){ 
	mysql_query("UPDATE tb_catgal set Imgpath='' WHERE gal='$_GET[id]'");		  
	$Imgpath = $_GET[namafile];
	$remove = "../../../".$Imgpath;
	$real_Imgpath = str_replace("images/gallery/","",$Imgpath);
	$real_Imgpath = trim($real_Imgpath);
	unlink($remove);  
	header('location:../../media.php?module='.$module.'&act=editcatgal&id='.$_GET[id]);
}
}