<?php 
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser']))
{
	echo "<link href='style.css' rel='stylesheet' type='text/css'>
	<center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else
{
 	include "../../../config/koneksi.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_thumb.php";
	
 	$module=$_GET[module];
	$act=$_GET[act];
	// Delete download
	if ($module=='download' AND $act=='hapus'){
        $download_id = $_GET['download_id'];
		$sSQL = "";
		$sSQL = " SELECT download_img FROM tb_download WHERE download_id ='".$download_id."' limit 1";
		$rslt=mysql_query($sSQL) or die ("error query");
 		while ($row=mysql_fetch_assoc($rslt))
		{
			$gambar = $row['download_img'];
		}
		mysql_free_result($rslt);
				
		if ($gambar!='')
		{
			$remove = "../../../".$gambar;
			$real_gambar = str_replace("images/download/","",$gambar);
			$real_gambar = trim($real_gambar);
				   
			unlink($remove);  
		};  
		
		$strSql = "delete from tb_download WHERE download_id='".$download_id."'";
	  	$result = mysql_query($strSql); 
		$loc = '../../media.php?module='.$module;
		echo "<script>document.location = '$loc'</script>";
	}
	// Input download
	elseif ($module=='download' AND $act=='input'){  
	    $download_title = $_POST['download_title'];
	    $seq = $_POST['seq'];
		$download_descr = $_POST['download_descr'];
		$stsActive = $_POST['stsActive'];
		$lokasi_file    = $_FILES['fupload']['tmp_name'];
		$tipe_file      = $_FILES['fupload']['type'];
		$nama_file      = $_FILES['fupload']['name'];
		$acak           = rand(000000,999999);
		$nama_file_unik = $acak.$nama_file; 
		$nama_file_unik2 = "images/download/".$acak.$nama_file; 
		$size_image	  = $_FILES['fupload']['size'];
		$size = round(($size_image / 1024), 2);
		
		if (!empty($lokasi_file)){
			if ($tipe_file != "application/pdf"){
				echo "<script>
					window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.PDF');
					window.location=('../../media.php?module=download')
				</script>";
			} else { 
				//UploadImagePNG_Banner($nama_file_unik);
				$result = move_uploaded_file($_FILES['fupload']['tmp_name'], "../../../".$nama_file_unik2);
				$sSQL = "";
				$sSQL = " insert into tb_download (download_title, seq, download_descr, download_img, download_stsActive) ";
				$sSQL = $sSQL." values ('".$download_title."','".$seq."','".mysql_real_escape_string($download_descr)."','".$nama_file_unik2."','".$stsActive."')";						
				mysql_query($sSQL);
				header('location:../../media.php?module='.$module);
			}
		} else {
			// without images 
			$sSQL = "";
			$sSQL = " insert into tb_download (download_title, seq, download_descr,download_stsActive) ";
			$sSQL = $sSQL." values ('".$download_title."','".$seq."','".mysql_real_escape_string($download_descr)."','".$stsActive."')";

			header('location:../../media.php?module='.$module);
		}
	}   // act=input
	elseif ($module=='download' AND $act=='update'){
	    $download_id = $_POST['download_id'];
	    $download_title = $_POST['download_title'];
	    $seq = $_POST['seq'];
		$download_descr = $_POST['download_descr'];
		$stsActive = $_POST['stsActive'];
		$download_img = $_POST['download_img'];
		$lokasi_file    = $_FILES['fupload']['tmp_name'];
		$tipe_file      = $_FILES['fupload']['type'];
		$nama_file      = $_FILES['fupload']['name'];
		$acak           = rand(000000,999999);
		$nama_file_unik = $acak.$nama_file; 
		$nama_file_unik2 = "images/download/".$acak.$nama_file;
		$size_image	  = $_FILES['fupload']['size'];
		$size = round(($size_image / 1024), 2);
		
		// If Image isn't replaced
		if(empty($lokasi_file))
		{
		    $sSQL = " update tb_download set download_title ='".$download_title."', seq='".$seq."', download_descr='".mysql_real_escape_string($download_descr)."', download_stsActive='".$stsActive."' where download_id = '".$download_id."'";
			mysql_query($sSQL);
		    header('location:../../media.php?module='.$module);
		}
		else       // if image is replaced
		{
		    // unlink first old imaged from tb_download 
			
			 if ($tipe_file != "application/pdf" )
			 {
    				echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.PDF');
        			window.location=('../../media.php?module=download')</script>";
		     }
   			 else
			 {
				//$remove = "../../../".$download_img;
				//unlink($remove);  
				
				 /* before upload , remove old images first */
					$sSQL = "";
					$sSQL = " SELECT download_img FROM tb_download WHERE download_id ='".$download_id."' limit 1";
					$rslt=mysql_query($sSQL) or die ("error query");
					 while ($row=mysql_fetch_assoc($rslt))
					{
						$gambar = $row['download_img'];
					}
					mysql_free_result($rslt);
			
					if ($gambar!='')
					{
						$remove = "../../../".$gambar;					   
						$real_gambar = str_replace("images/download/","",$gambar);
						$real_gambar = trim($real_gambar);
				   
						unlink($remove);
					}	
				/* End of Remove old images */
					//UploadImagePNG_Banner($nama_file_unik);
				$result = move_uploaded_file($_FILES['fupload']['tmp_name'], "../../../".$nama_file_unik2);
				$sSQL = "";
				$sSQL = " update tb_download set download_title ='".$download_title."',download_descr='".mysql_real_escape_string($download_descr)."', seq='".$seq."', banner_link ='".$banner_link."',";
				$sSQL = $sSQL." download_stsActive='".$stsActive."', download_img='".$nama_file_unik2."'";
				$sSQL = $sSQL." where download_id = '".$download_id."'";
				
				mysql_query($sSQL);
				$loc = '../../media.php?module='.$module;
				echo "<script>document.location = '$loc'</script>";
	         }  // $tipe_file
	    }    // empty($lokasi_file)  
	
	} // $module=='banner' AND $act=='update'
	
elseif ($module=='banner' AND $act=='hapusgambar'){
		mysql_query("UPDATE tb_download set download_img='' WHERE download_id='$_GET[id]'");
		  
		$gambar = $_GET[namafile];
		$remove = "../../../".$gambar;
		  
		$real_gambar = str_replace("images/banner/","",$gambar);
		$real_gambar = trim($real_gambar);
		unlink($remove);
		header('location:../../media.php?module='.$module.'&act=editartikel&id='.$_GET[id]);	
	}
}	// 	empty($_SESSION['username']
?>

