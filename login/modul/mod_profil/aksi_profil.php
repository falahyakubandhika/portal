<?php
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	include "../../../config/koneksi.php";
	include "../../../config/fungsi_thumb.php";
	
	$module=$_GET['module'];
	$act=$_GET['act'];
	
	// Update profil
	if ($module=='profil' AND $act=='update'){
		/* Pdf */
		$lokasi_file_pdf = $_FILES['ffile']['tmp_name'];
		$tipe_file_pdf = $_FILES['ffile']['type'];
		$nama_file_pdf = $_FILES['ffile']['name'];
		$acak_pdf = rand(1,99);
		$nama_file_unik_pdf = $acak_pdf.$nama_file_pdf;
		/* Upload PDF File */
		if (!empty($lokasi_file_pdf))
			UploadFileBrochure($nama_file_unik_pdf);
		else 
			$nama_file_unik_pdf="";
					
		$lokasi_file    = $_FILES['fupload']['tmp_name'];
		$tipe_file      = $_FILES['fupload']['type'];
		$nama_file      = $_FILES['fupload']['name'];
		$acak           = rand(1,99);
		$nama_file_unik = $acak.$nama_file; 
		$nama_file_unik2 = "images/logo/".$acak.$nama_file;
		// die($expired_order);
		// Apabila ada gambar yang diupload
		if (!empty($lokasi_file))
			{
			if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg" AND $tipe_file != "image/png")
				{
					echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');
						  window.location=('../../media.php?module=profil')</script>";
				}
			else
				{
					/* Remove old logo first */
					$sSQL = "";
					$sSQL = " SELECT * FROM company where id=1 limit 1";
					$rslt=mysql_query($sSQL) or die ($sSQL);
					while ($row=mysql_fetch_assoc($rslt))
						{
							$gambar = $row['gambar'];
						}
						mysql_free_result($rslt);					
					if ($gambar!='')
						{
							$remove = "../../../".$gambar;
							unlink($remove);
						}	
					if ($tipe_file == "image/png")
						{
							UploadImagePNG_Logo($nama_file_unik);
						}
					else
						{
							UploadImageJPG_Logo($nama_file_unik);
						}
					mysql_query("UPDATE company SET nama_perusahaan = '$_POST[nama_perusahaan]',
								website = '$_POST[website]',
								email_pengelola = '$_POST[email_pengelola]',
								nomor_tlp = '$_POST[nomor_tlp]',
								nomor_fax = '$_POST[nomor_fax]',
								static_content = '$_POST[isi]',
								alamat = '$_POST[alamat]',
								alamat_id = '$_POST[alamat_id]',
								facebook = '$_POST[facebook]',
								twitter = '$_POST[twitter]',
								youtube = '$_POST[youtube]',
								gambar = '$nama_file_unik2'
								WHERE id = '$_POST[id]'");
				}     //($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg" AND $tipe_file != "image/png")								
			}
		else
			{
				mysql_query("UPDATE company SET nama_perusahaan = '$_POST[nama_perusahaan]',
						website = '$_POST[website]',
						email_pengelola = '$_POST[email_pengelola]',
						nomor_tlp = '$_POST[nomor_tlp]',
						nomor_fax = '$_POST[nomor_fax]',
						alamat = '$_POST[alamat]',
						alamat_id = '$_POST[alamat_id]',
						facebook = '$_POST[facebook]',
						twitter = '$_POST[twitter]',
						youtube = '$_POST[youtube]',
						static_content = '$_POST[isi]'
						WHERE id = '$_POST[id]'");					
			}   //if (!empty($lokasi_file))
		$loc = '../../media.php?module='.$module;
		echo "<script>document.location = '$loc'</script>";
	}
	elseif ($module=='profil' AND $act=='updatewm')
		{
			mysql_query("UPDATE company set wlcmessage='".$_POST[wlcmessage]."' WHERE id='1'");
			header('location:../../media.php?module='.$module);
		}
	elseif ($module=='profil' AND $act=='updateou')
		{
			mysql_query("UPDATE company set wlcmessageEng='".$_POST[ourteam]."' WHERE id='1'");
			header('location:../../media.php?module='.$module);
		}
	elseif ($module=='profil' AND $act=='hapusgambar')
		{
			mysql_query("UPDATE company set gambar='' WHERE id='$_GET[id]'");
			unlink("../../../images/$_GET[namafile]");   
			header('location:../../media.php?module='.$module);
		}
	elseif ($module=='profil' AND $act=='updatejenisweb')
		{
			mysql_query("UPDATE company SET fl_jenis_web = '$_POST[fl_jenis_web]'
			WHERE id = '$_POST[id]'");
			if ($_POST['fl_jenis_web']=='W') 
				{			
					mysql_query("UPDATE plugin SET aktif = 'N' WHERE fl_jenis_web = 'E'");
				}
			else
				{
					mysql_query("UPDATE plugin SET aktif = 'Y' WHERE fl_jenis_web = 'E'");
				}
			header('location:../../media.php?module='.$module);
		}
	elseif ($module=='profil' AND $act=='updatemeta')
		{
			mysql_query("UPDATE company SET meta_title      	= '$_POST[meta_title]',
						meta_description  	= '$_POST[meta_description]',
						meta_keywords			= '$_POST[meta_keywords]',
						meta_abstract 		= '$_POST[meta_abstract]',
						meta_keyphrases   	= '$_POST[meta_keyphrases]',
						meta_mytopic      	= '$_POST[meta_mytopic]',
						meta_revesit_after	= '$_POST[meta_revesit_after]',
						meta_robots 			= '$_POST[meta_robots]',
						meta_distribution 	= '$_POST[meta_distribution]',
						meta_classification 	= '$_POST[meta_classification]'    
						WHERE id       = '$_POST[id]'");
			header('location:../../media.php?module='.$module);
		}
}
?>
