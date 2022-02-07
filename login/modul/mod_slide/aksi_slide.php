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
	// Delete slide
	if ($module=='slide' AND $act=='hapus'){
        $slide_id = $_GET['slide_id'];
		$sSQL = "";
		$sSQL = " SELECT slide_img FROM tb_slide WHERE slide_id ='".$slide_id."' limit 1";
		$rslt=mysql_query($sSQL) or die ("error query");
 		while ($row=mysql_fetch_assoc($rslt))
		{
			$gambar = $row['slide_img'];
		}
		mysql_free_result($rslt);
				
		if ($gambar!='')
		{
			$remove = "../../../".$gambar;
			$real_gambar = str_replace("images/slide/","",$gambar);
			$real_gambar = trim($real_gambar);
				   
			unlink($remove);  
		};  
		
		$strSql = "delete from tb_slide WHERE slide_id='".$slide_id."'";
	  	$result = mysql_query($strSql); 
		$loc = '../../media.php?module='.$module;
		echo "<script>document.location = '$loc'</script>";
	}
	// Input slide
	elseif ($module=='slide' AND $act=='input'){  
	    $slide_title = $_POST['slide_title'];
	    $seq = $_POST['seq'];
		$slide_link = $_POST['slide_link'];
		$stsActive = $_POST['stsActive'];
		$lokasi_file    = $_FILES['fupload']['tmp_name'];
		$tipe_file      = $_FILES['fupload']['type'];
		$nama_file      = $_FILES['fupload']['name'];
		$acak           = rand(000000,999999);
		$nama_file_unik = $acak.$nama_file; 
		$nama_file_unik2 = "images/slide/".$acak.$nama_file; 
		$size_image	  = $_FILES['fupload']['size'];
		$size = round(($size_image / 1024), 2);
		
		if (!empty($lokasi_file)){
			if ($tipe_file != "image/jpeg" and $tipe_file != "image/pjpeg" and $tipe_file !="image/png"){
				echo "<script>
					window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG atau *.png');
					window.location=('../../media.php?module=slide')
				</script>";
			} else { 
				if($size < 1024){
					if ($tipe_file == "image/png")
						{ 
							UploadImagePNG_Slide($nama_file_unik);
						} 
					else 
						{
							UploadImageJPG_Slide($nama_file_unik);
						}
						 
					$sSQL = "";
					$sSQL = " insert into tb_slide (slide_title, seq, slide_link, slide_img, slide_stsActive) ";
					$sSQL = $sSQL." values ('".$slide_title."','".$seq."','".$slide_link."','".$nama_file_unik2."','".$stsActive."')";						
					mysql_query($sSQL);
					header('location:../../media.php?module='.$module);
					} else {
						echo "<script>
							window.alert('Upload Gagal, File tidak boleh lebih dari 1 Mb');
							window.location=('../../media.php?module=slide')
							</script>";
					}
			}
		} else {
			// without images 
			$sSQL = "";
			$sSQL = " insert into tb_slide (slide_title, seq, slide_link, slide_stsActive) ";
			$sSQL = $sSQL." values ('".$slide_title."','".$seq."','".$slide_link."','".$stsActive."')";

			header('location:../../media.php?module='.$module);
		}
	}   // act=input
	elseif ($module=='slide' AND $act=='update'){
	    $slide_id = $_POST['slide_id'];
	    $slide_title = $_POST['slide_title'];
	    $seq = $_POST['seq'];
		$slide_link = $_POST['slide_link'];
		$stsActive = $_POST['stsActive'];
		$slide_img = $_POST['slide_img'];
		$lokasi_file    = $_FILES['fupload']['tmp_name'];
		$tipe_file      = $_FILES['fupload']['type'];
		$nama_file      = $_FILES['fupload']['name'];
		$acak           = rand(000000,999999);
		$nama_file_unik = $acak.$nama_file; 
		$nama_file_unik2 = "images/slide/".$acak.$nama_file;
		$size_image	  = $_FILES['fupload']['size'];
		$size = round(($size_image / 1024), 2);
		
		// If Image isn't replaced
		if(empty($lokasi_file))
		{
		    $sSQL = " update tb_slide set slide_title ='".$slide_title."', seq='".$seq."', slide_link ='".$slide_link."', slide_stsActive='".$stsActive."' where slide_id = '".$slide_id."'";
			mysql_query($sSQL);
		    header('location:../../media.php?module='.$module);
		}
		else       // if image is replaced
		{
		    // unlink first old imaged from tb_slide 
			
			 if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg" and $tipe_file !="image/png")
			 {
    				echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
        			window.location=('../../media.php?module=slide')</script>";
		     }
   			 else
			 {
				if($size < 1024)
				{
				    //$remove = "../../../".$slide_img;
					//unlink($remove);  
					
					 /* before upload , remove old images first */
			   			$sSQL = "";
			  			$sSQL = " SELECT slide_img FROM tb_slide WHERE slide_id ='".$slide_id."' limit 1";
			   			$rslt=mysql_query($sSQL) or die ("error query");
 			  			 while ($row=mysql_fetch_assoc($rslt))
			  			{
			         		$gambar = $row['slide_img'];
			  			}
			    		mysql_free_result($rslt);
				
						if ($gambar!='')
						{
			   				$remove = "../../../".$gambar;					   
			   				$real_gambar = str_replace("images/slide/","",$gambar);
			   				$real_gambar = trim($real_gambar);
					   
			   				unlink($remove);
						}	
					/* End of Remove old images */
						if ($tipe_file == "image/png")
						{
							UploadImagePNG_Slide($nama_file_unik);

						}
						else
						{
							UploadImageJPG_Slide($nama_file_unik);
						}
								
					$sSQL = "";
					$sSQL = " update tb_slide set slide_title ='".$slide_title."', seq='".$seq."', slide_link ='".$slide_link."',";
					$sSQL = $sSQL." slide_stsActive='".$stsActive."', slide_img='".$nama_file_unik2."'";
					$sSQL = $sSQL." where slide_id = '".$slide_id."'";
					
					mysql_query($sSQL);
					$loc = '../../media.php?module='.$module;
				    echo "<script>document.location = '$loc'</script>";
				}
				else
				{
					echo "<script>
							  	window.alert('Upload Gagal, File tidak boleh lebih dari 1 Mb');
							  	window.location=('../../media.php?module=slide')
							  </script>";
	
				}    // $size < 1024
	         }  // $tipe_file
	    }    // empty($lokasi_file)  
	
	} // $module=='slide' AND $act=='update'
	
elseif ($module=='slide' AND $act=='hapusgambar'){
		mysql_query("UPDATE tb_slide set slide_img='' WHERE slide_id='$_GET[id]'");
		  
		$gambar = $_GET[namafile];
		$remove = "../../../".$gambar;
		  
		$real_gambar = str_replace("images/slide/","",$gambar);
		$real_gambar = trim($real_gambar);
		unlink($remove);
		header('location:../../media.php?module='.$module.'&act=editartikel&id='.$_GET[id]);	
	}
}	// 	empty($_SESSION['username']
?>

