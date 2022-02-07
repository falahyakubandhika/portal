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
		// Delete Product
		if ($module=='product' AND $act=='hapus'){
		    $id = $_GET['id'];
		    $sSQL = "";
			/* cek first jika child record masih ada tdk bisa dihapus */
			$sSQL = " select fl_active ,image_1 from tb_product where no_int_product='$_GET[id]'";
			//die($sSQL);
			$rslt=mysql_query($sSQL) or die ($sSQL);
 			while ($row=mysql_fetch_assoc($rslt))
			{
				$gambarremove="";
				$no_int_product = $row['no_int_product'];
				$fl_active = $row['fl_active'];
				$image_1 = $row['image_1'];		
			}
			// cek jika masih aktif maka tidak dapat dihapus 
			if ($fl_active==1)
				{
					echo "<script>
					window.alert('Data product tidak dapat dihapus karena status product masih aktif');
					window.location=('../../media.php?module=product')
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
					mysql_query("delete from tb_product WHERE no_int_product='$_GET[id]'");
					$loc = '../../media.php?module='.$module;
					echo "<script>document.location = '$loc'</script>";
				}
		}
		// Input produk
		elseif ($module=='product' AND $act=='input'){
			$product_name = $_POST['product_name'];
			$stsActive = $_POST['stsActive'];
			$link_video = $_POST['link_video'];
			$seq_number = $_POST['seq_number'];
			$brand_id = $_POST['brand_id'];
			$link=  seo_title($_POST['product_name']);
			/* Upload Product Images */
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
								UploadImagePNG_Product_Multiple($nama_file_unik);
							}
						else
							{
								UploadImageJPG_Product_Multiple($nama_file_unik);
							}
							$nama_file_tb ="images/product/".$nama_file_unik;
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
					
					$sSQL = " insert into tb_product ( product_name , fl_active , image_1 , link , product_descr , file_name1 , link_video , seq_number, brand_id) VALUES 
					('".$product_name."','".$stsActive."','".$nama_file_tb."','".$link."','".mysql_real_escape_string($_POST['product_descr'])."','".$nama_file_unik_pdf."','".$link_video."','".$seq_number."','".$brand_id."')";
					$ok=mysql_query($sSQL) or die ($sSQL);
					
  			$loc = '../../media.php?module='.$module;
			echo "<script>document.location = '$loc'</script>";
		}  //$act=='input'
		elseif ($module=='product' AND $act=='update')
		{
			$id = $_POST['id'];
			$product_descr = $_POST['product_descr'];
			$product_name = $_POST['product_name'];
			$stsActive = $_POST['stsActive'];
			$link=  seo_title($_POST['product_name']);
			$fupload = $_POST['fupload'];
			$ffile = $_POST['ffile'];
			$link_video = $_POST['link_video'];
			$seq_number = $_POST['seq_number'];
			$brand_id = $_POST['brand_id'];
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
						$sSQL = " select file_name1 from tb_product where no_int_product='$id' limit 1";
						$rslt=mysql_query($sSQL) or die ("error query");
						while ($row=mysql_fetch_assoc($rslt))
						{
							$file_name1 = $row['file_name1'];
						}
						mysql_free_result($rslt);
						$remove_pdf = "../../../files/".$file_name1;
						unlink($remove_pdf);
						UploadFileBrochure($nama_file_unik_pdf);
						$sSQL = " update tb_product set file_name1='".$nama_file_unik_pdf."'";
						$sSQL = $sSQL." where no_int_product='".$id."'";
						//die($sSQL);
						$ok=mysql_query($sSQL) or die ($sSQL);
					}  //(!empty($lokasi_file_pdf))
				
				$sSQL = " select image_1 from tb_product where no_int_product='$id' limit 1 ";
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
					$nama_file_tb ="images/product/".$nama_file_unik;
  					if ((isset($nama_file)) && ($nama_file != "")) 
					{
						$sSQL = "";
						$gambarremove="";
						$gambarremove = $image_1 ;
						$sSQL = " update tb_product set image_1 ='".$nama_file_tb."' where no_int_product='$id'";
						mysql_query($sSQL);
						
							if (!empty($gambarremove) && $gambarremove!="")
								{
									$remove = "../../../".$gambarremove;
									unlink($remove);
								}	
							if ($tipe_file == "image/png")
								{
									UploadImagePNG_Product_Multiple($nama_file_unik);
								}
							else
								{
									UploadImageJPG_Product_Multiple($nama_file_unik);
								}	   
					}
				$sSQL = " update tb_product set product_name ='".$product_name."',";
				$sSQL = $sSQL." fl_active ='".$stsActive."',";
				$sSQL = $sSQL." link ='".$link."',";
				$sSQL = $sSQL." product_descr='".mysql_real_escape_string($_POST['product_descr'])."',";
				$sSQL = $sSQL." link_video='".$link_video."',";
				$sSQL = $sSQL." seq_number ='".$seq_number."',";
				$sSQL = $sSQL." brand_id ='".$brand_id."'";
				$sSQL = $sSQL." where no_int_product='".$id."'";

				$ok=mysql_query($sSQL) or die ($sSQL);
				$loc = '../../media.php?module='.$module;
				echo "<script>document.location = '$loc'</script>";
		}   // update
		elseif ($module=='product' AND $act=='hapusgambar')
		{ 
		 	$gambar = $_GET[namafile];
		    $remove = "../../../".$gambar;
			unlink($remove);
			$sSQL = "";
			$sSQL = " update tb_product set image_1='' WHERE no_int_product='".$_GET[id]."'";
			mysql_query($sSQL);
		  header('location:../../media.php?module='.$module.'&act=editproduct&id='.$_GET[id]);
		}
	} //$_SESSION['username']

?>
