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
			$sSQL = " select image from tb_product where product_id='".$product_id."'";
			$rslt=mysql_query($sSQL) or die ($sSQL);
 			while ($row=mysql_fetch_assoc($rslt))
			{
			      $gambar = $row['image'];
			}
			      mysql_free_result($rslt);
				
				 if ($gambar!='')
				 {
			   		$remove = "../../../".$gambar;
			   		$real_gambar = str_replace("images/product/","",$gambar);
			   		$real_gambar = trim($real_gambar);
			   		$gambar_small = "../../../"."images/product/small_".$real_gambar;
			   		$gambar_medium = "../../../"."images/product/medium_".$real_gambar;
					   
			   		unlink($remove);  
			  		unlink($gambar_small);   
			   		unlink($gambar_medium);   
			    						   
				  }	
		
  			mysql_query("delete FROM tb_product WHERE product_id='$_GET[id]'");
  			$loc = '../../media.php?module='.$module;
			echo "<script>document.location = '$loc'</script>";
			
		}

		// Input produk
		elseif ($module=='product' AND $act=='input'){
		       
			    $product_id = $_POST['product_id'];
				$product_headline = $_POST['product_headline'];
				$product_descr = $_POST['product_descr'];
				$product_name = $_POST['product_name'];
				$brand = $_POST['brand'];
				$parent_category = $_POST['parent_category'];
				$child_category = $_POST['child_category'];
				$weight = $_POST['weight'];
				$unit = $_POST['unit'];
				$price_1 = $_POST['price_1'];
				$price_2 = $_POST['price_2'];
				$stsActive = $_POST['stsActive'];
				$fl_promo = $_POST['fl_promo'];
				$fl_new = $_POST['fl_new'];
				$fl_feature = $_POST['fl_feature'];
				$fl_best_seller = $_POST['fl_best_seller'];
				$fl_hot = $_POST['fl_hot'];
				$fl_special = $_POST['fl_special'];
				$fl_sold = $_POST['fl_sold'];
				$fl_consigned = $_POST['fl_consigned'];
				$link_video = $_POST['link_video'];
				
				$weight = $_POST['weight'];
				$weightunit = $_POST['weightunit'];
				$length = $_POST['length'];
				$width = $_POST['width'];
				$height = $_POST['height'];
				$volume = $_POST['volume'];
				$volumeunit = $_POST['volumeunit'];
				
				
				$link=  seo_title($_POST['product_name']);
				$qty = $_POST['qty'];
				
			
		 /* Get Images Product */
				/* First Image or Main Image Product */
				
  				$lokasi_file    = $_FILES['fupload']['tmp_name'];
  				$tipe_file      = $_FILES['fupload']['type'];
  				$nama_file      = $_FILES['fupload']['name'];
  				$acak           = rand(1,999);
  				$nama_file_unik = $acak.$nama_file; 
				
				$nama_file_unik1 = "images/product/".$acak.$nama_file; 
				$size_image	  = $_FILES['fupload']['size'];
				$size = round(($size_image / 1024), 2);
				
				
				/* 2nd Image */
				$lokasi_file2    = $_FILES['fupload2']['tmp_name'];
  				$tipe_file2      = $_FILES['fupload2']['type'];
  				$nama_file2      = $_FILES['fupload2']['name'];
  				$acak2           = rand(1,999);
				$nama_file_unik2 = $acak2.$nama_file2; 
  				//$nama_file_unik2 = "images/product/".$acak2.$nama_file2; 
				
				
				$size_image2	  = $_FILES['fupload2']['size'];
				$size2 = round(($size_image2 / 1024), 2);
				/* 2nd Image */
				
				/* 3rd Image */
				$lokasi_file3    = $_FILES['fupload3']['tmp_name'];
  				$tipe_file3      = $_FILES['fupload3']['type'];
  				$nama_file3      = $_FILES['fupload3']['name'];
  				$acak3           = rand(1,999);
  				$nama_file_unik3 = $acak3.$nama_file3; 
				
				
				$size_image3	  = $_FILES['fupload3']['size'];
				$size3 = round(($size_image3 / 1024), 2);
				/* 3rd Image */
				
				/* 4th Image */
				$lokasi_file4    = $_FILES['fupload4']['tmp_name'];
  				$tipe_file4      = $_FILES['fupload4']['type'];
  				$nama_file4      = $_FILES['fupload4']['name'];
  				$acak4           = rand(1,999);
  				$nama_file_unik4 = $acak4.$nama_file4; 
				
				
				$size_image4	  = $_FILES['fupload4']['size'];
				$size4 = round(($size_image4 / 1024), 2);
				/* 4th Image */
				
				/* 5th Image */
				$lokasi_file5    = $_FILES['fupload5']['tmp_name'];
  				$tipe_file5      = $_FILES['fupload5']['type'];
  				$nama_file5      = $_FILES['fupload5']['name'];
  				$acak5           = rand(1,999);
  				$nama_file_unik5 = $acak5.$nama_file5; 
				
				
				$size_image5	  = $_FILES['fupload5']['size'];
				$size5 = round(($size_image5 / 1024), 2);
				/* 5th Image */
				
				/* 6th Image */
				$lokasi_file6    = $_FILES['fupload6']['tmp_name'];
  				$tipe_file6      = $_FILES['fupload6']['type'];
  				$nama_file6      = $_FILES['fupload6']['name'];
  				$acak6           = rand(1,999);
  				$nama_file_unik6 = $acak6.$nama_file6; 
				
				
				$size_image6	  = $_FILES['fupload6']['size'];
				$size6 = round(($size_image6 / 1024), 2);
				/* 5th Image */
				
	/* End Get Images Product --------------------------------------------------*/			
				
				
				
				/* Pdf */
				$lokasi_file_pdf    = $_FILES['ffile']['tmp_name'];
				$tipe_file_pdf      = $_FILES['ffile']['type'];
				$nama_file_pdf      = $_FILES['ffile']['name'];
				$acak_pdf           = rand(1,99);
				$nama_file_unik_pdf = $acak_pdf.$nama_file_pdf; 
				//$nama_file_unik_pdf2 = "files/".$acak_pdf.$nama_file_pdf; 
				
				

				// Apabila ada gambar yang diupload
		  		if (!empty($lokasi_file)){
						if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg" AND $tipe_file != "image/png"){
								echo "<script>
										window.alert('Upload Main Image Product Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');
										window.location=('../../media.php?module=product')
						 			</script>";

						}
						else
						{
						     /* Check whether 2nd - 6th image are empty or not */
							 if (!empty($lokasi_file2))
							 {
							     	if ($tipe_file2 != "image/jpeg" AND $tipe_file2 != "image/pjpeg" AND $tipe_file2 != "image/png")
									{
												echo "<script>
													  window.alert('Upload 2nd Image Product Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');
													  window.location=('../../media.php?module=product')
						 							  </script>";
									}				  

							  }
							  
							  
							 if (!empty($lokasi_file3))
							 {
							     	if ($tipe_file3 != "image/jpeg" AND $tipe_file3 != "image/pjpeg" AND $tipe_file3 != "image/png")
									{
												echo "<script>
													  window.alert('Upload 3rd Image Product Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');
													  window.location=('../../media.php?module=product')
						 							  </script>";
									}				  

							  }
							  
							  if (!empty($lokasi_file4))
							  {
							     	if ($tipe_file4 != "image/jpeg" AND $tipe_file4 != "image/pjpeg" AND $tipe_file4 != "image/png")
									{
												echo "<script>
													  window.alert('Upload 4th Image Product Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');
													  window.location=('../../media.php?module=product')
						 							  </script>";
									}				  

							   }
							 
							 if (!empty($lokasi_file5))
							  {
							     	if ($tipe_file5 != "image/jpeg" AND $tipe_file5 != "image/pjpeg" AND $tipe_file5 != "image/png")
									{
												echo "<script>
													  window.alert('Upload 5th Image Product Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');
													  window.location=('../../media.php?module=product')
						 							  </script>";
									}				  

							   }
							   
							   if (!empty($lokasi_file6))
							  {
							     	if ($tipe_file6 != "image/jpeg" AND $tipe_file6 != "image/pjpeg" AND $tipe_file6 != "image/png")
									{
												echo "<script>
													  window.alert('Upload 6th Image Product Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');
													  window.location=('../../media.php?module=product')
						 							  </script>";
									}				  

							   }
							  
						
							 
							 
							 
							/* End  Check whether 2nd - 6th image are empty or not */
						
						
						    /* Upload All Product Images */
						    if ($tipe_file == "image/png")
							    
								UploadImagePNG_Product($nama_file_unik);
							else
								UploadImageJPG_Product_Multiple($nama_file_unik,1);
								
								
							if ($tipe_file2 == "image/png")
							
								UploadImagePNG_Product($nama_file_unik2);
							else
								UploadImageJPG_Product_Multiple($nama_file_unik2,2);	
								
							
							if ($tipe_file3 == "image/png")
							
								UploadImagePNG_Product($nama_file_unik3);
							else
								UploadImageJPG_Product_Multiple($nama_file_unik3,3);		
								
							if ($tipe_file4 == "image/png")
							
								UploadImagePNG_Product($nama_file_unik4);
							else
								UploadImageJPG_Product_Multiple($nama_file_unik4,4);	
							
							if ($tipe_file5 == "image/png")
							
								UploadImagePNG_Product($nama_file_unik5);
							else
								UploadImageJPG_Product_Multiple($nama_file_unik5,5);	
								
							
							if ($tipe_file6 == "image/png")
							
								UploadImagePNG_Product($nama_file_unik6,6);
							else
								UploadImageJPG_Product_Multiple($nama_file_unik6);	
								
							
							$nama_file_unik2 = "images/product/".$acak2.$nama_file2; 	
							$nama_file_unik3 = "images/product/".$acak3.$nama_file3; 	
							$nama_file_unik4 = "images/product/".$acak3.$nama_file4; 	
							$nama_file_unik5 = "images/product/".$acak3.$nama_file5; 	
							$nama_file_unik6 = "images/product/".$acak3.$nama_file6; 	
							
							
							
							
								
							/* End Upload All Product Images */
							
							/* Upload PDF File */
							if (!empty($lokasi_file_pdf))
							{
							    UploadFileBrochure($nama_file_unik_pdf);
							}
							
							
							$sSQL = "";
		  					$sSQL = " select product_id from tb_product ";
		  					$sSQL = $sSQL." where product_id ='".$product_id."' limit 1";
		 					$total = mysql_num_rows(mysql_query($sSQL));
		  					if ($total==0)
		  					{
							  
							  
							 		 $sSQL = " insert into tb_product (product_id , product_name , unit_id , fl_active , price_1 , price_2 , ";
                              		 $sSQL= $sSQL." image , fl_new , fl_feature , fl_promo , link , product_descr , ";
                        	 		 $sSQL = $sSQL." brand_id , category_id , subcategory_id,weight ,product_headline,qty,fl_best_seller,file_name1,fl_hot,fl_special,";
							  		 $sSQL = $sSQL." fl_sold , fl_consigned , link_video, ";
							 		 $sSQL = $sSQL." weight_unit_id,";
							  		 $sSQL = $sSQL." length,width, height,volume,volume_unit_id, image2,image3,image4,image5,image6";
							  		 $sSQL = $sSQL." ) VALUES ('";
							  		 $sSQL = $sSQL.$product_id."',"."'".$product_name."',"."'".$unit."',"."'".$stsActive."',";
							  		 $sSQL = $sSQL."'".$price_1."',"."'".$price_2."',"."'".$nama_file_unik1."',"."'".$fl_new."',";
							  		 $sSQL = $sSQL."'".$fl_feature."',"."'".$fl_promo."',"."'".$link."',"."'".$product_descr."',";
							  		 $sSQL = $sSQL."'".$brand."',"."'".$parent_category."',"."'".$child_category."',"."'".$weight."',";
							  		 $sSQL = $sSQL."'".$product_headline."','".$qty."','".$fl_best_seller."','".$nama_file_unik_pdf."',";
							  		 $sSQL = $sSQL."'".$fl_hot."','".$fl_special."',";
							 		 $sSQL = $sSQL."'".$fl_sold."','".$fl_consigned."',"."'".$link_video."',";
							  		 $sSQL = $sSQL."'".$weightunit."',";
							 		 $sSQL = $sSQL."'".$length."',"."'".$width."',";
							  		 $sSQL = $sSQL."'".$height."',"."'".$volume."',";
							  		 $sSQL = $sSQL."'".$volumeunit."',";
									 $sSQL = $sSQL."'".$nama_file_unik2."',"."'".$nama_file_unik3."',"."'".$nama_file_unik4."',"."'".$nama_file_unik5."',";
									 $sSQL = $sSQL."'".$nama_file_unik6."')";
									 
									 
							  
							  		 $ok=mysql_query($sSQL) or die ($sSQL);
							  
							  } // $total 
							 		

					} // $tipe_file			
						
				
				  }  //empty($lokasi_file)
				 
  			$loc = '../../media.php?module='.$module;
			echo "<script>document.location = '$loc'</script>";
		}  //$act=='input'
		
		elseif ($module=='product' AND $act=='update'){
		        $id = $_POST['id'];
		 		$product_id = $_POST['product_id'];
				$product_headline = $_POST['product_headline'];
				$product_descr = $_POST['product_descr'];
				$product_name = $_POST['product_name'];
				$brand = $_POST['brand'];
				$parent_category = $_POST['parent_category'];
				$child_category = $_POST['child_category'];
				$weight = $_POST['weight'];
				$unit = $_POST['unit'];
				$price_1 = $_POST['price_1'];
				$price_2 = $_POST['price_2'];
				$stsActive = $_POST['stsActive'];
				$fl_promo = $_POST['fl_promo'];
				$fl_new = $_POST['fl_new'];
				$fl_feature = $_POST['fl_feature'];
				$link=  seo_title($_POST['product_name']);
				$fupload = $_POST['fupload'];
				$ffile = $_POST['ffile'];
				$qty = $_POST['qty'];
				$fl_best_seller = $_POST['fl_best_seller'];
				$fl_hot = $_POST['fl_hot'];
				$fl_special = $_POST['fl_special'];
				$fl_sold = $_POST['fl_sold'];
				$fl_consigned = $_POST['fl_consigned'];
				$link_video = $_POST['link_video'];
				
				$weight = $_POST['weight'];
				$weightunit = $_POST['weightunit'];
				$length = $_POST['length'];
				$width = $_POST['width'];
				$height = $_POST['height'];
				$volume = $_POST['volume'];
				$volumeunit = $_POST['volumeunit'];
				
				
  				$lokasi_file    = $_FILES['fupload']['tmp_name'];
  				$tipe_file      = $_FILES['fupload']['type'];
  				$nama_file      = $_FILES['fupload']['name'];
  				$acak           = rand(1,999);
  				$nama_file_unik = $acak.$nama_file; 
				
				$nama_file_unik2 = "images/product/".$acak.$nama_file; 
				$size_image	  = $_FILES['fupload']['size'];
				$size = round(($size_image / 1024), 2);
				
				
				/* Pdf */
				$lokasi_file_pdf    = $_FILES['ffile']['tmp_name'];
				$tipe_file_pdf      = $_FILES['ffile']['type'];
				$nama_file_pdf      = $_FILES['ffile']['name'];
				$acak_pdf           = rand(1,99);
				$nama_file_unik_pdf = $acak_pdf.$nama_file_pdf; 
				$nama_file_unik_pdf2 = "files/".$acak_pdf.$nama_file_pdf; 
				
				
				// If Image is not replaced with new one
				if(empty($lokasi_file))
				{
				   
				   
				   
				   $sSQL = " update tb_product set product_headline='".$product_headline."',";
				   $sSQL = $sSQL." product_name ='".$product_name."',";
				   $sSQL = $sSQL." brand_id ='".$brand."',";
				   $sSQL = $sSQL." category_id ='".$parent_category."',";
				   $sSQL = $sSQL." subcategory_id ='".$child_category."',";
				   $sSQL = $sSQL." weight ='".$weight."',";
				   $sSQL = $sSQL." unit_id ='".$unit."',";
				   $sSQL = $sSQL." price_1 ='".$price_1."',";
				   $sSQL = $sSQL." price_2 ='".$price_2."',";
				   $sSQL = $sSQL." fl_active ='".$stsActive."',";
				   $sSQL = $sSQL." fl_promo ='".$fl_promo."',";
				   $sSQL = $sSQL." fl_new ='".$fl_new."',";
				   $sSQL = $sSQL." fl_feature ='".$fl_feature."',";
				   $sSQL = $sSQL." fl_hot ='".$fl_hot."',";
				   $sSQL = $sSQL." fl_special ='".$fl_special."',";
				   $sSQL = $sSQL." fl_sold ='".$fl_sold."',";
				   $sSQL = $sSQL." fl_consigned ='".$fl_consigned."',";
				   $sSQL = $sSQL." link ='".$link."',";
				   $sSQL = $sSQL." product_descr='".$product_descr."',";
				   $sSQL = $sSQL." qty='".$qty."',";
				   $sSQL = $sSQL." fl_best_seller='".$fl_best_seller."',";
				   $sSQL = $sSQL." link_video='".$link_video."',";
				   $sSQL = $sSQL." weight_unit_id='".$weightunit."',";
				   $sSQL = $sSQL." length='".$length."',";
				   $sSQL = $sSQL." width='".$width."',";
				   $sSQL = $sSQL." height='".$height."',";
				   $sSQL = $sSQL." volume='".$volume."',";
				   $sSQL = $sSQL." volume_unit_id='".$volumeunit."'";
				   $sSQL = $sSQL." where product_id='".$product_id."'";
				   
				    //die($sSQL);
				   
				   $ok=mysql_query($sSQL) or die ($sSQL);
				   
				   
				   
				   
				   
				   
				  // $loc = '../../media.php?module='.$module;
				   /*echo "<script>document.location = '$loc'</script>";*/
				}
				else                // Old image is replace with new one
				{
				 		  if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg" AND $tipe_file != "image/png")
						  {
    								echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');
        							window.location=('../../media.php?module=product')</script>";
						  }
				   		  else
						 {
								/* before upload , remove old images first */
			 					$sSQL = "";
			   					$sSQL = " select image from tb_product where product_id='".$product_id."'";
			   					$rslt=mysql_query($sSQL) or die ($sSQL);
 			   					while ($row=mysql_fetch_assoc($rslt))
			   					{
			        				 $gambar = $row['image'];
			   					}
			    				mysql_free_result($rslt);
				
								if ($gambar!='')
								{
			   
			   						$remove = "../../../".$gambar;
					   
			   						$real_gambar = str_replace("images/product/","",$gambar);
			   						$real_gambar = trim($real_gambar);
			   						$gambar_small = "../../../"."images/product/small_".$real_gambar;
			   						$gambar_medium = "../../../"."images/product/medium_".$real_gambar;
					   
			   						unlink($remove);  
			  						unlink($gambar_small);   
			   						unlink($gambar_medium);   
			    						   
								}	
								 /* End of Remove old images */	
								 
								  if ($tipe_file == "image/png"){

										UploadImagePNG_Product($nama_file_unik);

								  }
								  else
								  {

										UploadImageJPG_Product($nama_file_unik);
								  }
								 
								 $sSQL = " update tb_product set product_headline='".$product_headline."',";
								 $sSQL = $sSQL." product_name ='".$product_name."',";
				  				 $sSQL = $sSQL." brand_id ='".$brand."',";
				   				 $sSQL = $sSQL." category_id ='".$parent_category."',";
				   				 $sSQL = $sSQL." subcategory_id ='".$child_category."',";
								 $sSQL = $sSQL." weight ='".$weight."',";
				  				 $sSQL = $sSQL." unit_id ='".$unit."',";
				 				 $sSQL = $sSQL." price_1 ='".$price_1."',";
				   				 $sSQL = $sSQL." price_2 ='".$price_2."',";
								 $sSQL = $sSQL." fl_active ='".$stsActive."',";
				   				 $sSQL = $sSQL." fl_promo ='".$fl_promo."',";
				 				 $sSQL = $sSQL." fl_new ='".$fl_new."',";
				   				 $sSQL = $sSQL." fl_feature ='".$fl_feature."',";
								 $sSQL = $sSQL." fl_hot ='".$fl_hot."',";
				   				 $sSQL = $sSQL." fl_special ='".$fl_special."',";
								 $sSQL = $sSQL." fl_sold ='".$fl_sold."',";
				   				 $sSQL = $sSQL." fl_consigned ='".$fl_consigned."',";
								 $sSQL = $sSQL." link ='".$link."',";
								 $sSQL = $sSQL." image ='".$nama_file_unik2."',";
								 $sSQL = $sSQL." product_descr='".$product_descr."'";
								 $sSQL = $sSQL." ,qty='".$qty."'";
								 $sSQL = $sSQL." ,fl_best_seller='".$fl_best_seller."',";
								 $sSQL = $sSQL." link_video='".$link_video."',";
								 $sSQL = $sSQL." weight_unit_id='".$weightunit."',";
				   				 $sSQL = $sSQL." length='".$length."',";
				  				 $sSQL = $sSQL." width='".$width."',";
				   				 $sSQL = $sSQL." height='".$height."',";
				  				 $sSQL = $sSQL." volume='".$volume."',";
				   				 $sSQL = $sSQL." volume_unit_id='".$volumeunit."'";
								 $sSQL = $sSQL." where product_id='".$product_id."'";
								 
								 //die($sSQL);
				   
				   				 $ok=mysql_query($sSQL) or die ($sSQL);
								
								
		  
								
	        			  }  // $tipe_file	
				}    // $lokasi_file 
				
				if (!empty($lokasi_file_pdf))
				{
				      $sSQL = "";
					  $sSQL = " select file_name1 from tb_product where product_id='$product_id' limit 1";
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
					  $sSQL = $sSQL." where product_id='".$product_id."'";
					  
					  //die($sSQL);
					  $ok=mysql_query($sSQL) or die ($sSQL);
				}
				
				
				 $loc = '../../media.php?module='.$module;
				 echo "<script>document.location = '$loc'</script>";
				
				
				
		}   // update
		
		elseif ($module=='product' AND $act=='hapusgambar')
		{

		  	mysql_query("UPDATE tb_product set image='' WHERE product_id='$_GET[id]'");
		  
		 	$gambar = $_GET[namafile];
		    $remove = "../../../".$gambar;
					   
			$real_gambar = str_replace("images/product/","",$gambar);
			$real_gambar = trim($real_gambar);
					   
			$gambar_small = "../../../"."images/product/small_".$real_gambar;
					   
			$gambar_medium = "../../../"."images/product/medium_".$real_gambar;
					   
			
			unlink($remove);  
			unlink($gambar_small);   
			unlink($gambar_medium);   
		  
		  

	

		  //header('location:../../media.php?module='.$module.'&act=editproduct&id='.$product_id."'");	
		  header('location:../../media.php?module='.$module.'&act=editproduct&id='.$_GET[id]);	

	}

   } //$_SESSION['username']

?>
