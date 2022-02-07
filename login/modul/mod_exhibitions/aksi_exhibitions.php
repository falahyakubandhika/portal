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
	// Delete exhibitions
	if ($module=='exhibitions' AND $act=='hapus'){
        $exhibitions_id = $_GET['exhibitions_id'];
		
		$sSQL = "";
		$sSQL = " SELECT exhibitions_image FROM tb_exhibitions WHERE exhibitions_id ='".$exhibitions_id."' limit 1";
		$rslt=mysql_query($sSQL) or die ("error query");
 		while ($row=mysql_fetch_assoc($rslt))
		{
			   $gambar = $row['exhibitions_image'];
		}
			    mysql_free_result($rslt);
				
		if ($gambar!='')
		{
			$remove = "../../../".$gambar;
			unlink($remove);  
		};  
		
		$strSql = "delete from tb_exhibitions WHERE exhibitions_id='".$exhibitions_id."'";
	  	$result = mysql_query($strSql); 
		
		
		 $loc = '../../media.php?module='.$module;
		 echo "<script>document.location = '$loc'</script>";
		 

	}

	// Input exhibitions
	elseif ($module=='exhibitions' AND $act=='input'){
	   
	    $exhibitions_title = $_POST['exhibitions_title'];
		$stsActive = $_POST['stsActive'];
		$seq = $_POST['seq'];
		
		$lokasi_file    = $_FILES['fupload']['tmp_name'];
		$tipe_file      = $_FILES['fupload']['type'];
		$nama_file      = $_FILES['fupload']['name'];
		$acak           = rand(000000,999999);
		$nama_file_unik = $acak.$nama_file; 
		
		$nama_file_unik2 = "images/exhibitions/".$acak.$nama_file; 
		$size_image	  = $_FILES['fupload']['size'];
		$size = round(($size_image / 1024), 2);
		
		if (!empty($lokasi_file))
		{
			if ($tipe_file != "image/jpeg" and $tipe_file != "image/pjpeg" and $tipe_file !="image/png")
			{
				echo "<script>
							window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG atau .PNG');
							window.location=('../../media.php?module=exhibitions')
					 </script>";
			}
			else
			{
				if ($tipe_file == "image/png")
				{
					UploadImagePNG_exhibitions($nama_file_unik);
				}
				else
				{
					UploadImageJPG_exhibitions($nama_file_unik);
				}
				$sSQL = "";
				$sSQL = " insert into tb_exhibitions (exhibitions_name, exhibitions_image, fl_active, seq) ";
				$sSQL = $sSQL." values ('".$exhibitions_title."','".$nama_file_unik2."','".$stsActive."','".$seq."')";
				mysql_query($sSQL) or die($sSQL);
				header('location:../../media.php?module='.$module);
			}
        } else {                 
			// without images 
			$sSQL = "";
			$sSQL = " insert into tb_exhibitions (exhibitions_name,  fl_active, seq) ";
			$sSQL = $sSQL." values ('".$exhibitions_title."','".$stsActive."','".$seq."')";
			mysql_query($sSQL) or die($sSQL);

			header('location:../../media.php?module='.$module);
		}
	}   // act=input	
	
	elseif ($module=='exhibitions' AND $act=='update'){
	    $exhibitions_id = $_POST['exhibitions_id'];
	    $exhibitions_title = $_POST['exhibitions_title'];
		$stsActive = $_POST['stsActive'];
		$exhibitions_img = $_POST['exhibitions_img'];
		$seq = $_POST['seq'];
	
		 
		$lokasi_file    = $_FILES['fupload']['tmp_name'];
		$tipe_file      = $_FILES['fupload']['type'];
		$nama_file      = $_FILES['fupload']['name'];
		$acak           = rand(000000,999999);
		$nama_file_unik = $acak.$nama_file; 
		$nama_file_unik2 = "images/exhibitions/".$acak.$nama_file;
		$size_image	  = $_FILES['fupload']['size'];
		$size = round(($size_image / 1024), 2);
		
		
		
		// If Image isn't replaced
		if(empty($lokasi_file))
		{
		    $sSQL = " update tb_exhibitions set exhibitions_name ='".$exhibitions_title."', fl_active='".$stsActive."', seq='".$seq."' where exhibitions_id = '".$exhibitions_id."'";
			mysql_query($sSQL);
		    header('location:../../media.php?module='.$module);
		}
		else       // if image is replaced
		{
		    // unlink first old imaged from tb_exhibitions 			
			if ($tipe_file != "image/jpeg" and $tipe_file != "image/pjpeg" and $tipe_file != "image/png")
			{
				echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
				window.location=('../../media.php?module=exhibitions')</script>";
			}
   			 else
			 {
				if($size < 1024)
				{
				    //$remove = "../../../".$exhibitions_img;
					//unlink($remove);  
					/* before upload , remove old images first */
			   			$sSQL = "";
			  			$sSQL = " SELECT exhibitions_image FROM tb_exhibitions WHERE exhibitions_id ='".$exhibitions_id."' limit 1";
			   			$rslt=mysql_query($sSQL) or die ("error query");
 			  			 while ($row=mysql_fetch_assoc($rslt))
			  			{
			         		$gambar = $row['exhibitions_image'];
			  			}
			    		mysql_free_result($rslt);
				
						if ($gambar!='')
						{
			   				$remove = "../../../".$gambar;					   
			   				unlink($remove);  
						}	
						/* End of Remove old images */
						if ($tipe_file == "image/png")
						{
							UploadImagePNG_exhibitions($nama_file_unik);
						}
						else
						{
							UploadImageJPG_exhibitions($nama_file_unik);
						}	
					
					$sSQL = "";
					$sSQL = " update tb_exhibitions set exhibitions_name ='".$exhibitions_title."', fl_active='".$stsActive."', exhibitions_image='".$nama_file_unik2."', seq='".$seq."' where exhibitions_id = '".$exhibitions_id."'";
					
					mysql_query($sSQL);
					$loc = '../../media.php?module='.$module;
				    echo "<script>document.location = '$loc'</script>";

				}
				else
				{
					echo "<script>
							  	window.alert('Upload Gagal, File tidak boleh lebih dari 1 Mb');
							  	window.location=('../../media.php?module=exhibitions')
							  </script>";
	
				}    // $size < 1024
	         }  // $tipe_file
	    }    // empty($lokasi_file)  
	
	} // $module=='exhibitions' AND $act=='update'
	
elseif ($module=='exhibitions' AND $act=='hapusgambar'){
		mysql_query("UPDATE tb_exhibitions set exhibitions_image='' WHERE exhibitions_id='$_GET[id]'");  
		$gambar = $_GET[namafile];
		$remove = "../../../".$gambar;
		unlink($remove);  
		header('location:../../media.php?module='.$module.'&act=editexhibitions&exhibitions_id='.$_GET[id]);	
	}
}	// 	empty($_SESSION['username']
?>

