<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<link href='style.css' rel='stylesheet' type='text/css'>
	<center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=../../index.php><b>LOGIN</b></a></center>";
} else {
	include "../../../config/koneksi.php";
	include "../../../configclass/library.php";
	include "../../../configclass/fungsi_thumb.php";
	include "../../../configclass/fungsi_seo.php";
	
	
	// Hapus catdetail
	if (isset($_GET['aksi'])) {
		if($_GET['aksi']=='delete'){
			$data=mysql_fetch_array(mysql_query("SELECT * FROM tb_catdetail WHERE tip=".$_GET['id']));
			$Imgpath = $data['Imgpath'];
			$remove = "../../../".$Imgpath;
			if (file_exists($remove)){	
				$real_Imgpath = str_replace("images/catdetail/","",$Imgpath);
				$real_Imgpath = trim($real_Imgpath);
				unlink($remove);
				mysql_query("DELETE FROM tb_catdetail WHERE tip=".$_GET['id']);
			} else {
				mysql_query("DELETE FROM tb_catdetail WHERE tip=".$_GET['id']);
			}
			echo "<script>window.history.back()</script>";
			//echo "<script>window.location = '../../media.php?module='.$module'</script> <script language=javascript>window.location='".$loc."'</script>";
		}
		else if($_GET['aksi']=='ubahstatus'){
			$data2=mysql_fetch_array(mysql_query("SELECT * FROM tb_catdetail WHERE tip=".$_GET['id']));
			$cek = $data2['fl_active'];
			if($cek=='1') mysql_query("UPDATE tb_catdetail SET fl_active = 0 WHERE tip=".$_GET['id']);
			else if(!$cek) mysql_query("UPDATE tb_catdetail SET fl_active = 1 WHERE tip=".$_GET['id']);

			echo "<script>window.history.back()</script>";
		}
	}
	// Input catdetail

else if (isset($_POST['sbinput'])){
	 //echo "<p>" . $_POST['fupload'] . " => file input successfull</p>";
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$judul_seo		= seo_title( $_POST['Title']);
	$acak           = rand(1,99);
	$nama_file_unik = $acak.$nama_file; 
	$nama_file_unik2 = "images/catdetail/".$acak.$nama_file;
	$tgl=date('Y-m-d', strtotime($_POST['Date']));
	//echo $lokasi_file.",".$tipe_file.",".$nama_file;
	// Apabila ada gambar yang diupload
	if (!empty($lokasi_file)){
		if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){
			echo "";
			die('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
		}else{
			if ($tipe_file == "image/png"){
				UploadImagePNG_catdetail($nama_file_unik);
			} else { 
				UploadImageJPG_catdetail($nama_file_unik);
			}
			$sSQL = "insert into tb_catdetail(cat_url,Title,Detail,Date,Imgpath,Subtitle,cat,meta_key, fl_active) 
			values('".$judul_seo."','".$_POST['Title']."','".$_POST['Detail']."','".$tgl."','".$nama_file_unik2."','".$_POST['Subtitle']."','".$_POST['brand_id']."','".$_POST['meta_key']."', '1')";
			mysql_query($sSQL) or die($sSQL);
			echo "<script>window.history.back()</script>";
			//echo "<script>document.location = '$loc'</script>";
		}
	} else {
		$sSQL = "insert into tb_catdetail(cat_url,Title,Detail,Date,Subtitle,cat,meta_key,fl_active) 
		values('".$judul_seo."', '".$_POST['Title']."','".$_POST['Detail']."','$tgl','".mysql_real_escape_string($_POST['Subtitle'])."','".$_POST['brand_id'].",'".$_POST['meta_key']."', '1')";
		mysql_query($sSQL);
		echo "<script>window.history.back()</script>";
	}
}
// Update catdetail
else if (isset($_POST['sbupdate'])){
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$judul_seo		= seo_title( $_POST['Title']);
	$acak           = rand(1,99);
	$nama_file_unik = $acak.$nama_file; 
	$nama_file_unik2 = "images/catdetail/".$acak.$nama_file;
	// Apabila Imgpath tidak diganti
	if (empty($lokasi_file)){
		$sSQL = "UPDATE tb_catdetail SET cat_url='".$judul_seo."', 
		Title= '".$_POST['Title']."',
		Detail  = '".$_POST['Detail']."',
		Subtitle  = '".$_POST['Subtitle']."',
		meta_key = '".$_POST['meta_key']."',
		cat = '".$_POST['brand_id']."'
		WHERE tip   = '".$_POST['id']."'" ;
		//die($sSQL);		 
		mysql_query($sSQL) or die($sSQL);
		//$loc = '../../media.php?module='.$module;
		echo "<script>window.location=('http://ijintender.co.id/development/login/?page=catdetail')</script>";
		//echo "<script>window.history.back()</script>";
	} else { 
		if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){
			echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
				window.location=('../../media.php?module=catdetail)</script>";
		} else {			
			/* before upload , remove old images first */
			$sSQL = "";
			$sSQL = " select Imgpath from tb_catdetail where tip='".$_POST['id']."'";
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
				   
				//unlink($remove);  
				/* End of Remove old images */		   
			}	
			if ($tipe_file == "image/png"){
				UploadImagePNG_catdetail($nama_file_unik);
			} else {
				UploadImageJPG_catdetail($nama_file_unik);
			}				
			$sSQL = "UPDATE tb_catdetail SET cat_url = '$judul_seo',
			Title= '".$_POST['Title']."',
			Detail  = '".$_POST['Detail']."',
			meta_key = '".$_POST['meta_key']."',
			Subtitle  = '".mysql_real_escape_string($_POST['Subtitle'])."',
			Imgpath ='".$nama_file_unik2."',
			cat = '".$_POST['brand_id']."'
			WHERE tip   = '".$_POST['id']."'" ;
			mysql_query($sSQL) or die($sSQL);
			echo "<script>window.location=('http://ijintender.co.id/development/login/?page=catdetail')</script>";
			//echo "<script>window.history.back()</script>";
			//echo "<script>document.location = '$loc'</script>";
		}
	}
}


}