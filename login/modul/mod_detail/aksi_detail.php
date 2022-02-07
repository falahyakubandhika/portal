<?php
	session_start();
	include "../../../config/koneksi.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_thumb.php";
	include "../../../config/fungsi_seo.php";
	
	$module=$_GET[module];
	$act=$_GET[act];
	if (empty($_SESSION['username']) AND empty($_SESSION['passuser']))
 	{
 		echo "<link href='style.css' rel='stylesheet' type='text/css'>
 			<center>Untuk mengakses modul, Anda harus login <br>";
 		echo "<a href=../../index.php><b>LOGIN</b></a></center>";
	}
	else
	{
		// Delete Detail
		if ($module=='detail' AND $act=='hapus'){
		    $id = $_GET['id'];
		    $sSQL = "";
			/* cek first jika child record masih ada tdk bisa dihapus */
			$sSQL = " select fl_active ,image_1 from tb_detail where no_int_detail='$_GET[id]'";
			//die($sSQL);
			$rslt=mysql_query($sSQL) or die ($sSQL);
 			while ($row=mysql_fetch_assoc($rslt))
			{
				$gambarremove="";
				$no_int_detail = $row['no_int_detail'];
				$fl_active = $row['fl_active'];
				$image_1 = $row['image_1'];		
			}
			// cek jika masih aktif maka tidak dapat dihapus 
			if ($fl_active==1)
				{
					echo "<script>
					window.alert('Data detail tidak dapat dihapus karena status detail masih aktif');
					window.location=('../../media.php?module=detail')
					</script>";  
				}
			else
				{
					$remove = "../../../".$image_1;
					if(trim($image_1)!="")
						{   
							unlink($remove); 
						}
					mysql_free_result($rslt);
					mysql_query("delete from tb_detail WHERE no_int_detail='$_GET[id]'");
					$loc = '../../media.php?module='.$module;
					echo "<script>document.location = '$loc'</script>";
				}
		}
		// Input produk
		elseif ($module=='detail' AND $act=='input'){
			$detail_name = $_POST['detail_name'];
			$stsActive = $_POST['stsActive'];
			$link_video = $_POST['link_video'];
			$seq_number = $_POST['seq_number'];
			$link=  seo_title($_POST['detail_name']);
			/* Upload Detail Images */
				$nama_file = $_FILES['fupload']['name'];
				$lokasi_file = $_FILES['fupload']['tmp_name'];
				$tipe_file = $_FILES['fupload']['type'];
				$acak = rand(1,99);						
				$str = str_replace(' ', '', $nama_file);
				$nama_file_unik = $acak.trim($str);
				$nama_file_unik = trim($nama_file_unik);
					if (!empty($lokasi_file))
					{
						if ($tipe_file == "image/png")
							{
								UploadImagePNG_Detail_Multiple($nama_file_unik);
							}
						else
							{
								UploadImageJPG_Detail_Multiple($nama_file_unik);
							}
							$nama_file_tb ="images/detail/".$nama_file_unik;
					}
					else
					{
						$nama_file_tb ="";
					}
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
					
					$sSQL = " insert into tb_detail ( detail_name , fl_active , image_1 , link , detail_descr , file_name1 , link_video , seq_number ) VALUES 
					('".mysql_real_escape_string($detail_name)."','".$stsActive."','".$nama_file_tb."','".$link."','".mysql_real_escape_string($_POST['detail_descr'])."','".$nama_file_unik_pdf."','".$link_video."','".$seq_number."')";
					$ok=mysql_query($sSQL) or die ($sSQL);
					
  			$loc = '../../media.php?module='.$module;
			echo "<script>document.location = '$loc'</script>";
		}  //$act=='input'
		elseif ($module=='detail' AND $act=='update')
		{
			$id = $_POST['id'];
			$detail_descr = $_POST['detail_descr'];
			$detail_name = $_POST['detail_name'];
			$stsActive = $_POST['stsActive'];
			$link=  seo_title($_POST['detail_name']);
			$fupload = $_POST['fupload'];
			$ffile = $_POST['ffile'];
			$link_video = $_POST['link_video'];
			$seq_number = $_POST['seq_number'];
			/* Pdf */
			$lokasi_file_pdf    = $_FILES['ffile']['tmp_name'];
			$tipe_file_pdf      = $_FILES['ffile']['type'];
			$nama_file_pdf      = $_FILES['ffile']['name'];
			$acak_pdf           = rand(1,99);
			$nama_file_unik_pdf = $acak_pdf.$nama_file_pdf; 
			$nama_file_unik_pdf2 = "files/".$acak_pdf.$nama_file_pdf;
				/* Jika file_pdf diganti */
				if (!empty($lokasi_file_pdf))
					{
						$sSQL = "";
						$sSQL = " select file_name1 from tb_detail where no_int_detail='$id' limit 1";
						$rslt=mysql_query($sSQL) or die ("error query");
						while ($row=mysql_fetch_assoc($rslt))
						{
							$file_name1 = $row['file_name1'];
						}
						mysql_free_result($rslt);
						$remove_pdf = "../../../files/".$file_name1;
						unlink($remove_pdf);
						UploadFileBrochure($nama_file_unik_pdf);
						$sSQL = " update tb_detail set file_name1='".$nama_file_unik_pdf."'";
						$sSQL = $sSQL." where no_int_detail='".$id."'";
						//die($sSQL);
						$ok=mysql_query($sSQL) or die ($sSQL);
					}  //(!empty($lokasi_file_pdf))
				
				$sSQL = " select image_1 from tb_detail where no_int_detail='$id' limit 1 ";
				// die($sSQL);
				$rslt=mysql_query($sSQL) or die ($sSQL);
				while ($row=mysql_fetch_assoc($rslt))
				{
					$image_1 = $row['image_1'];
				}
				mysql_free_result($rslt);
				/* Main Images */
				    $nama_file= "";    
					$nama_file      = $_FILES['fupload']['name'];
    				$lokasi_file    = $_FILES['fupload']['tmp_name'];
    				$tipe_file      = $_FILES['fupload']['type'];
    				$acak           = rand(1,99);
					$str = str_replace(' ', '', $nama_file);
    				$nama_file_unik = $acak.trim($str); 	
					$nama_file_unik = trim($nama_file_unik);
					$nama_file_tb ="images/detail/".$nama_file_unik;
  					if ((isset($nama_file)) && ($nama_file != "")) 
					{
						$sSQL = "";
						$gambarremove="";
						$gambarremove = $image_1 ;
						$sSQL = " update tb_detail set image_1 ='".$nama_file_tb."' where no_int_detail='$id'";
						mysql_query($sSQL);
						
							if (!empty($gambarremove) && $gambarremove!="")
								{
									$remove = "../../../".$gambarremove;
									unlink($remove);
								}	
							if ($tipe_file == "image/png")
								{
									UploadImagePNG_Detail_Multiple($nama_file_unik);
								}
							else
								{
									UploadImageJPG_Detail_Multiple($nama_file_unik);
								}	   
					}
				$sSQL = " update tb_detail set detail_name ='".mysql_real_escape_string($detail_name)."',";
				$sSQL = $sSQL." fl_active ='".$stsActive."',";
				$sSQL = $sSQL." link ='".$link."',";
				$sSQL = $sSQL." detail_descr='".mysql_real_escape_string($_POST['detail_descr'])."',";
				$sSQL = $sSQL." link_video='".$link_video."',";
				$sSQL = $sSQL." seq_number ='".$seq_number."'";
				$sSQL = $sSQL." where no_int_detail='".$id."'";

				$ok=mysql_query($sSQL) or die ($sSQL);
				$loc = '../../media.php?module='.$module;
				echo "<script>document.location = '$loc'</script>";
		}   // update
		elseif ($module=='detail' AND $act=='hapusgambar')
		{ 
		 	$gambar = $_GET[namafile];
		    $remove = "../../../".$gambar;
			unlink($remove);
			$sSQL = "";
			$sSQL = " update tb_detail set image_1='' WHERE no_int_detail='".$_GET[id]."'";
			mysql_query($sSQL);
		  header('location:../../media.php?module='.$module.'&act=editdetail&id='.$_GET[id]);
		}
	} //$_SESSION['username']

?>
