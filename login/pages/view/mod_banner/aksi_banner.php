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
	include "../../../../config/library.php";
	include "../../../../config/fungsi_thumb.php";
	
 	$module=$_GET['module'];
	$act=$_GET['act'];
	// Delete Banner
	if ($module=='banner' AND $act=='hapus'){
        $banner_id = $_GET['banner_id'];
		$sSQL = "";
		$sSQL = " SELECT banner_img FROM tb_banner WHERE banner_id ='".$banner_id."' limit 1";
		$rslt=mysql_query($sSQL) or die ("error query");
 		while ($row=mysql_fetch_assoc($rslt))
		{
			$gambar = $row['banner_img'];
		}
		mysql_free_result($rslt);
				
		if (isset($gamber))
		{
			$remove = "../../../../".$gambar;
			$real_gambar = str_replace("images/banner/","",$gambar);
			$real_gambar = trim($real_gambar);
				   
			unlink($remove);  
		};  
		
		$strSql = "delete from tb_banner WHERE banner_id='".$banner_id."'";
	  	$result = mysql_query($strSql); 
		$loc = '../../media.php?module='.$module;
		echo "<script>alert('Data anda berhasil di dihapus'); window.location = '../../../?module=".$module."'</script>";
	}
	// Input banner
	elseif ($module=='banner' AND $act=='input'){  
	    $banner_title = $_POST['banner_title'];
	    $seq = $_POST['seq'];
		$banner_link = $_POST['banner_link'];
		$banner_descr = $_POST['banner_descr'];
		$stsActive = $_POST['stsActive'];
		$lokasi_file    = $_FILES['fupload']['tmp_name'];
		$tipe_file      = $_FILES['fupload']['type'];
		$nama_file      = $_FILES['fupload']['name'];
		$acak           = rand(000000,999999);
		$nama_file_unik = $acak.$nama_file; 
		$nama_file_unik2 = "images/banner/".$acak.$nama_file; 
		$size_image	  = $_FILES['fupload']['size'];
		$size = round(($size_image / 1024), 2);
		
		if (!empty($lokasi_file)){
			if ($tipe_file != "image/jpeg" and $tipe_file != "image/pjpeg" and $tipe_file !="image/png"){
				echo "<script>
					window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG atau *.png');
					window.location=('../../media.php?module=banner')
				</script>";
			} else { 
				if($size < 1024){
					if ($tipe_file == "image/png")
						{ 
							UploadImagePNG_Banner($nama_file_unik);
						} 
					else 
						{
							UploadImageJPG_Banner($nama_file_unik);
						}
						 
					$sSQL = "";
					$sSQL = " insert into tb_banner (banner_title, seq, banner_link, banner_descr, banner_img, banner_stsActive) ";
					$sSQL = $sSQL." values ('".$banner_title."','".$seq."','".$banner_link."','".mysql_real_escape_string($banner_descr)."','".$nama_file_unik2."','".$stsActive."')";						
					mysql_query($sSQL);
					echo "<script>alert('Data anda berhasil di input'); window.location = '../../../?module=".$module."'</script>";
					} else {
						echo "<script>
							window.alert('Upload Gagal, File tidak boleh lebih dari 1 Mb');
							window.location=('../../../?module=".$module."')
							</script>";
					}
			}
		} else {
			// without images 
			$sSQL = "";
			$sSQL = " insert into tb_banner (banner_title, seq, banner_link, banner_descr,banner_stsActive) ";
			$sSQL = $sSQL." values ('".$banner_title."','".$seq."','".$banner_link."','".mysql_real_escape_string($banner_descr)."','".$stsActive."')";

			echo "<script>alert('Data anda berhasil di input'); window.location = '../../../?module=".$module."'</script>";
		}
	}   // act=input
	elseif ($module=='banner' AND $act=='update'){
	    $banner_id = $_POST['banner_id'];
	    $banner_title = $_POST['banner_title'];
	    $seq = $_POST['seq'];
		$banner_link = $_POST['banner_link'];
		$banner_descr = $_POST['banner_descr'];
		$stsActive = $_POST['stsActive'];
		$banner_img = $_POST['banner_img'];
		$lokasi_file    = $_FILES['fupload']['tmp_name'];
		$tipe_file      = $_FILES['fupload']['type'];
		$nama_file      = $_FILES['fupload']['name'];
		$acak           = rand(000000,999999);
		$nama_file_unik = $acak.$nama_file; 
		$nama_file_unik2 = "images/banner/".$acak.$nama_file;
		$size_image	  = $_FILES['fupload']['size'];
		$size = round(($size_image / 1024), 2);
		
		// If Image isn't replaced
		if(empty($lokasi_file))
		{
		    $sSQL = " update tb_banner set banner_title ='".$banner_title."', seq='".$seq."', banner_link ='".$banner_link."', banner_descr='".mysql_real_escape_string($banner_descr)."', banner_stsActive='".$stsActive."' where banner_id = '".$banner_id."'";
			mysql_query($sSQL);
		    echo "<script>alert('Data anda berhasil di update'); window.location = '../../../?module=".$module."'</script>";
		}
		else       // if image is replaced
		{
		    // unlink first old imaged from tb_banner 
			
			 if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg" and $tipe_file !="image/png")
			 {
    				echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
        			window.location=('../../../?module=".$module."')</script>";
		     }
   			 else
			 {
				if($size < 1024)
				{
				    //$remove = "../../../".$banner_img;
					//unlink($remove);  
					
					 /* before upload , remove old images first */
			   			$sSQL = "";
			  			$sSQL = " SELECT banner_img FROM tb_banner WHERE banner_id ='".$banner_id."' limit 1";
			   			$rslt=mysql_query($sSQL) or die ("error query");
 			  			 while ($row=mysql_fetch_assoc($rslt))
			  			{
			         		$gambar = $row['banner_img'];
			  			}
			    		mysql_free_result($rslt);
				
						if ($gambar!='')
						{
			   				$remove = "../../../../".$gambar;					   
			   				$real_gambar = str_replace("images/banner/","",$gambar);
			   				$real_gambar = trim($real_gambar);
					   
			   				unlink($remove);
						}	
					/* End of Remove old images */
						if ($tipe_file == "image/png")
						{
							UploadImagePNG_Banner($nama_file_unik);

						}
						else
						{
							UploadImageJPG_Banner($nama_file_unik);
						}
								
					$sSQL = "";
					$sSQL = " update tb_banner set banner_title ='".$banner_title."',banner_descr='".mysql_real_escape_string($banner_descr)."', seq='".$seq."', banner_link ='".$banner_link."',";
					$sSQL = $sSQL." banner_stsActive='".$stsActive."', banner_img='".$nama_file_unik2."'";
					$sSQL = $sSQL." where banner_id = '".$banner_id."'";
					
					mysql_query($sSQL);
					$loc = '../../media.php?module='.$module;
				     echo "<script>alert('Data anda berhasil di update'); window.location = '../../../?module=".$module."'</script>";
				}
				else
				{
					echo "<script>
							  	window.alert('Upload Gagal, File tidak boleh lebih dari 1 Mb');
							  	window.location=('../../../?module=".$module."')
							  </script>";
	
				}    // $size < 1024
	         }  // $tipe_file
	    }    // empty($lokasi_file)  
	
	} // $module=='banner' AND $act=='update'
	
elseif ($module=='banner' AND $act=='hapusgambar'){
		mysql_query("UPDATE tb_banner set banner_img='' WHERE banner_id='$_GET[id]'");
		  
		$gambar = $_GET[namafile];
		$remove = "../../../../".$gambar;
		  
		$real_gambar = str_replace("images/banner/","",$gambar);
		$real_gambar = trim($real_gambar);
		unlink($remove);
		header('location:../../../?module='.$module.'&act=editartikel&id='.$_GET[id]);	
	}
}	// 	empty($_SESSION['username']
?>

