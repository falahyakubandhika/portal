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
	// Delete team
	if ($module=='team' AND $act=='hapus'){
        $team_id = $_GET['team_id'];
		$sSQL = "";
		$sSQL = " SELECT team_img FROM tb_team WHERE team_id ='".$team_id."' limit 1";
		$rslt=mysql_query($sSQL) or die ("error query");
 		while ($row=mysql_fetch_assoc($rslt))
		{
			$gambar = $row['team_img'];
		}
		mysql_free_result($rslt);
				
		if (isset($gambar))
		{
			$remove = "../../../".$gambar;
			$real_gambar = str_replace("images/team/","",$gambar);
			$real_gambar = trim($real_gambar);
				   
			unlink($remove);  
		};  
		
		$strSql = "delete from tb_team WHERE team_id='".$team_id."'";
	  	$result = mysql_query($strSql); 
		$loc = '../../../?module='.$module;
		echo "<script>document.location = '$loc'</script>";
	}
	// Input team
	elseif ($module=='team' AND $act=='input'){  
	    $team_title = $_POST['team_title'];
		$team_position = $_POST['team_position'];
		$team_cat = $_POST['team_cat'];
		$lokasi_file    = $_FILES['fupload']['tmp_name'];
		$tipe_file      = $_FILES['fupload']['type'];
		$nama_file      = $_FILES['fupload']['name'];
		$acak           = rand(000000,999999);
		$nama_file_unik = $acak.$nama_file; 
		$nama_file_unik2 = "images/team/".$acak.$nama_file; 
		$size_image	  = $_FILES['fupload']['size'];
		$size = round(($size_image / 1024), 2);
		
		if (!empty($lokasi_file)){
			if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){
			echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');
				window.location=('../../../?module=team')
			</script>";
			die('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
			} else { 
				
					if ($tipe_file == "image/png")
						{ 
							UploadImagePNG_Team($nama_file_unik);
						} 
					else 
						{
							UploadImageJPG_Team($nama_file_unik);
						}
						 
					$sSQL = "";
					$sSQL = " insert into tb_team (team_title, team_position, team_img, team_cat) ";
					$sSQL = $sSQL." values ('".$team_title."','".$team_position."','".$nama_file_unik2."','".$team_cat."')";						
					mysql_query($sSQL);
					header('location:../../../?module='.$module);
					
			}
		} else {
			// without images 
			$sSQL = "";
			$sSQL = " insert into tb_team (team_title, team_position, team_cat) ";
			$sSQL = $sSQL." values ('".$team_title."','".$team_position."','".$team_cat."')";
			mysql_query($sSQL);
			$loc = '../../../?module='.$module;
			echo "<script>document.location = '$loc'</script>";
		}
	}   // act=input
	elseif ($module=='team' AND $act=='update'){
	    $team_id = $_POST['team_id'];
	    $team_title = $_POST['team_title'];
		$team_position = $_POST['team_position'];
		$team_cat = $_POST['team_cat'];
		$team_img = $_POST['team_img'];
		$lokasi_file    = $_FILES['fupload']['tmp_name'];
		$tipe_file      = $_FILES['fupload']['type'];
		$nama_file      = $_FILES['fupload']['name'];
		$acak           = rand(000000,999999);
		$nama_file_unik = $acak.$nama_file; 
		$nama_file_unik2 = "images/team/".$acak.$nama_file;
		$size_image	  = $_FILES['fupload']['size'];
		$size = round(($size_image / 1024), 2);
		
		// If Image isn't replaced
		if(empty($lokasi_file))
		{
		    $sSQL = " update tb_team set team_title ='".$team_title."', team_position ='".$team_position."', team_cat='".$team_cat."' where team_id = '".$team_id."'";
			mysql_query($sSQL);
		   $loc = '../../../?module='.$module;
			echo "<script>document.location = '$loc'</script>";
		}
		else       // if image is replaced
		{
		    // unlink first old imaged from tb_team 
			
			 if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg" and $tipe_file !="image/png")
			 {
    				echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
        			window.location=('../../../?module=team')</script>";
		     }
   			 else
			 {
				if($size < 1024)
				{
				    //$remove = "../../../".$team_img;
					//unlink($remove);  
					
					 /* before upload , remove old images first */
			   			$sSQL = "";
			  			$sSQL = " SELECT team_img FROM tb_team WHERE team_id ='".$team_id."' limit 1";
			   			$rslt=mysql_query($sSQL) or die ("error query");
 			  			 while ($row=mysql_fetch_assoc($rslt))
			  			{
			         		$gambar = $row['team_img'];
			  			}
			    		mysql_free_result($rslt);
				
						if ($gambar!='')
						{
			   				$remove = "../../../".$gambar;					   
			   				$real_gambar = str_replace("images/team/","",$gambar);
			   				$real_gambar = trim($real_gambar);
					   
			   				unlink($remove);
						}	
					/* End of Remove old images */
						if ($tipe_file == "image/png")
						{
							UploadImagePNG_Team($nama_file_unik);

						}
						else
						{
							UploadImageJPG_Team($nama_file_unik);
						}
								
					$sSQL = "";
					$sSQL = " update tb_team set team_title ='".$team_title."', team_position ='".$team_position."',";
					$sSQL = $sSQL." team_img='".$nama_file_unik2."', team_cat='".$team_cat."'";
					$sSQL = $sSQL." where team_id = '".$team_id."'";
					
					mysql_query($sSQL);
					$loc = '../../../?module='.$module;
				    echo "<script>document.location = '$loc'</script>";
				}
				else
				{
					echo "<script>
							  	window.alert('Upload Gagal, File tidak boleh lebih dari 1 Mb');
							  	window.location=('../../../?module=team')
							  </script>";
	
				}    // $size < 1024
	         }  // $tipe_file
	    }    // empty($lokasi_file)  
	
	} // $module=='team' AND $act=='update'
	
elseif ($module=='team' AND $act=='hapusgambar'){
		mysql_query("UPDATE tb_team set team_img='' WHERE team_id='$_GET[team_id]'");
		  
		$gambar = $_GET[namafile];
		$remove = "../../../".$gambar;
		  
		$real_gambar = str_replace("images/team/","",$gambar);
		$real_gambar = trim($real_gambar);
		unlink($remove);
		header('location:../../../?module='.$module.'&act=editartikel&team_id='.$_GET[team_id]);	
	}
}	// 	empty($_SESSION['username']
?>

