<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<link href='style.css' rel='stylesheet' type='text/css'>
	<center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=../../index.php><b>LOGIN</b></a></center>";
} else {
	include "../../../configclass/koneksi.php";
	include "../../../configclass/library.php";
	include "../../../configclass/fungsi_thumb.php";
	include "../../../configclass/fungsi_seo.php";
	
	
	// Hapus catdetail
	if (isset($_GET['aksi']) && $_GET['aksi']=='hapus'){
		$data=mysql_fetch_array(mysql_query("SELECT Imgpath,fl_active FROM tb_catdetail WHERE tip='$_GET[id]'"));
			if ($data['Imgpath']!=''){
				$Imgpath = $data['Imgpath'];
				$remove = "../../../".$Imgpath;

				$real_Imgpath = str_replace("images/catdetail/","",$Imgpath);
				$real_Imgpath = trim($real_Imgpath);
				unlink($remove);
				mysql_query("DELETE FROM tb_catdetail WHERE tip='$_GET[id]'");
			} else {
				mysql_query("DELETE FROM tb_catdetail WHERE tip='$_GET[id]'");
			}
			$loc = "../../media.php?module=".$module;
		  
			//echo "<script>window.location = '../../media.php?module='.$module'</script> <script language=javascript>window.location='".$loc."'</script>";
	}
	// Input catdetail

elseif (isset($_POST['sbinput'])){
	 echo "<p>" . $_POST['fupload'] . " => file input successfull</p>";
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$judul_seo		= seo_title( $_POST['Title']);
	$acak           = rand(1,99);
	$nama_file_unik = $acak.$nama_file; 
	$nama_file_unik2 = "images/catdetail/".$acak.$nama_file;
	$tgl=date('Y-m-d', strtotime($_POST['Date']));
	echo $lokasi_file.",".$tipe_file.",".$nama_file;
	// Apabila ada gambar yang diupload
	if (!empty($lokasi_file)){
		if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){
			echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');
				window.location=('../../media.php?module=catdetail)
			</script>";
			die('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
		}else{
			if ($tipe_file == "image/png"){
				UploadImagePNG_catdetail($nama_file_unik);
			} else { 
				UploadImageJPG_catdetail($nama_file_unik);
			}
			$sSQL = "insert into tb_catdetail(cat_url,Title,Detail,Date,Imgpath,Subtitle,cat) 
			values('".$judul_seo."','".$_POST['Title']."','".$_POST['Detail']."','".$tgl."','".$nama_file_unik2."','".$_POST['Subtitle']."','".$_POST['brand_id']."')";
			mysql_query($sSQL) or die($sSQL);
			$loc = "http://localhost/exijintender/login/";
			//echo "<script>document.location = '$loc'</script>";
		}
	} else {
		$sSQL = "insert into tb_catdetail(cat_url,Title,Detail,Date,Subtitle,cat) 
		values('".$judul_seo."', '".$_POST['Title']."','".$_POST['Detail']."','$tgl','".mysql_real_escape_string($_POST['Subtitle'])."','".$_POST['brand_id']."')";
		mysql_query($sSQL);
		$loc = "http://localhost/exijintender/login/";
		//echo "<script>document.location = '$loc'</script>";
	}
}
// Update catdetail
elseif ($module=='catdetail' AND $act=='update')
{
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$judul_seo		= seo_title( $_POST['Title']);
	$acak           = rand(1,99);
	$nama_file_unik = $acak.$nama_file; 
	$nama_file_unik2 = "images/catdetail/".$acak.$nama_file;
	// Apabila Imgpath tidak diganti
	if (empty($lokasi_file)){
		$sSQL = "UPDATE tb_catdetail SET cat_url='$judul_seo', 
		Title= '".$_POST[Title]."',
		Detail  = '$_POST[Detail]',
		Subtitle  = '$_POST[Subtitle]',
		fl_active = '$_POST[fl_active]',
		cat = '$_POST[brand_id]'
		WHERE tip   = '$_POST[id]'" ;
		//die($sSQL);		 
		mysql_query($sSQL) or die($sSQL);
		$loc = '../../media.php?module='.$module;
		echo "<script>document.location = '$loc'</script>";
	} else { 
		if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){
			echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
				window.location=('../../media.php?module=catdetail)</script>";
		} else {			
			/* before upload , remove old images first */
			$sSQL = "";
			$sSQL = " select Imgpath from tb_catdetail where tip='$_POST[id]'";
			$rslt=mysql_query($sSQL) or die ("error query");
			while ($row=mysql_fetch_assoc($rslt))
			{
				$Imgpath = $row['Imgpath'];
			}
			mysql_free_result($rslt);				
			if ($Imgpath!='')
			{
				$remove = "../../../".$Imgpath;	   
				$real_Imgpath = str_replace("images/catdetail/","",$Imgpath);
				$real_Imgpath = trim($real_Imgpath);
				   
				unlink($remove);  
				/* End of Remove old images */		   
			}	
			if ($tipe_file == "image/png"){
				UploadImagePNG_catdetail($nama_file_unik);
			} else {
				UploadImageJPG_catdetail($nama_file_unik);
			}				
			$sSQL = "UPDATE tb_catdetail SET cat_url = '$judul_seo',
			Title= '$_POST[Title]',
			Detail  = '".$_POST[Detail]."',
			Subtitle  = '".mysql_real_escape_string($_POST[Subtitle])."',
			fl_active = '$_POST[fl_active]',
			Imgpath ='$nama_file_unik2'
			WHERE tip   = '$_POST[id]'" ;
			mysql_query($sSQL) or die($sSQL);
			$loc = '../../media.php?module='.$module;
			echo "<script>document.location = '$loc'</script>";
		}
		}
} 
elseif ($module=='catdetail' AND $act=='hapusgambar'){ 
	mysql_query("UPDATE tb_catdetail set Imgpath='' WHERE tip='$_GET[id]'");		  
	$Imgpath = $_GET[namafile];
	$remove = "../../../".$Imgpath;
	$real_Imgpath = str_replace("images/catdetail/","",$Imgpath);
	$real_Imgpath = trim($real_Imgpath);
	unlink($remove);  
	header('location:../../media.php?module='.$module.'&act=editcatdetail&id='.$_GET[id]);
}
}