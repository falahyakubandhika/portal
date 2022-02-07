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
				
			
		 
			
				$bykFile = count($_FILES['fupload']['name']);
				$nama_file_tb[]="";
				for ($i = 0; $i < $bykFile; $i++) 
				{
				        
						$nama_file      = $_FILES['fupload']['name'][$i];
    					$lokasi_file    = $_FILES['fupload']['tmp_name'][$i];
    					$tipe_file      = $_FILES['fupload']['type'][$i];
    					$acak           = rand(1,99);
    					$nama_file_unik = $acak.$nama_file; 	
					
  						if ((isset($nama_file)) && ($nama_file != "")) 
						{

				
								if ($tipe_file == "image/png")
								{
									UploadImageProdukPNG($nama_file_unik,$i);
								}
								else
								{
									UploadImageJPG_Product_Multiple($nama_file_unik,$i);
								}
								$nama_file_tb[$i] ="images/product/".$nama_file_unik;
						}	
						
    			
				
				}		
				
				
				
			
				
				
				
				/* Pdf */
				$lokasi_file_pdf    = $_FILES['ffile']['tmp_name'];
				$tipe_file_pdf      = $_FILES['ffile']['type'];
				$nama_file_pdf      = $_FILES['ffile']['name'];
				$acak_pdf           = rand(1,99);
				$nama_file_unik_pdf = $acak_pdf.$nama_file_pdf; 
				
				/* Upload PDF File */
				if (!empty($lokasi_file_pdf))
					UploadFileBrochure($nama_file_unik_pdf);
				else 
				    $nama_file_unik_pdf="";
							
							
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
					$sSQL = $sSQL." length,width, height,volume,volume_unit_id";
					$sSQL = $sSQL." ) VALUES ('";
					$sSQL = $sSQL.$product_id."',"."'".$product_name."',"."'".$unit."',"."'".$stsActive."',";
					$sSQL = $sSQL."'".$price_1."',"."'".$price_2."',"."'".$nama_file_tb[0]."',"."'".$fl_new."',";
					$sSQL = $sSQL."'".$fl_feature."',"."'".$fl_promo."',"."'".$link."',"."'".$product_descr."',";
					$sSQL = $sSQL."'".$brand."',"."'".$parent_category."',"."'".$child_category."',"."'".$weight."',";
					$sSQL = $sSQL."'".$product_headline."','".$qty."','".$fl_best_seller."','".$nama_file_unik_pdf."',";
					$sSQL = $sSQL."'".$fl_hot."','".$fl_special."',";
					$sSQL = $sSQL."'".$fl_sold."','".$fl_consigned."',"."'".$link_video."',";
					$sSQL = $sSQL."'".$weightunit."',";
					$sSQL = $sSQL."'".$length."',"."'".$width."',";
					$sSQL = $sSQL."'".$height."',"."'".$volume."',";
					$sSQL = $sSQL."'".$volumeunit."')";
					
					
					
					
					
					
					
									 
							  
					$ok=mysql_query($sSQL) or die ($sSQL);
					
					$x = 0;
					for ($i = 1; $i < $bykFile; $i++) 
					{
					    
					    if ((isset($nama_file_tb[$i])) && ($nama_file_tb[$i]!=""))
						{
						   $x = $i + 1; 
						   $nvar = "image_".$x;
						   $nvar = trim($nvar);
						   $sSQL = "";
						   $sSQL = " update tb_product set ".$nvar."='".$nama_file_tb[$i]."' where product_id = '".$product_id."'";
						   mysql_query($sSQL) or die($sSQL);
						}
						
					
					}
							  
				 } // $total 
							 		

				
  			$loc = '../../media.php?module='.$module;
			echo "<script>document.location = '$loc'</script>";
		}  //$act=='input'
		
		elseif ($module=='product' AND $act=='update')
		{
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
				}  //(!empty($lokasi_file_pdf))
				
				 $sSQL = " select image , image_2, image_3,image_4,image_5, image_6 from tb_product where product_id='$product_id' limit 1 ";
				// die($sSQL);
				 $rslt=mysql_query($sSQL) or die ($sSQL);
 	  			 $i=0;
				 while ($row=mysql_fetch_assoc($rslt))
				 {
					$image_1 = $row['image'];
					$image_2 = $row['image_2'];
					$image_3 = $row['image_3'];
					$image_4 = $row['image_4'];
					$image_5 = $row['image_5'];
					$image_6 = $row['image_6'];
				 }
				 mysql_free_result($rslt);
				// die($image_1);
				
					//$bykFile = count($_FILES['fupload']['name']);
				$bykFile = 7;
				$nama_file_tb[]="";
				$indeks = 0; 
				for ($i= 1; $i < $bykFile; $i++) 
				{
				   // $indeks = $indeks+1;
				        
					$nama_file      = $_FILES['fupload']['name'][$i];
    				$lokasi_file    = $_FILES['fupload']['tmp_name'][$i];
    				$tipe_file      = $_FILES['fupload']['type'][$i];
    				$acak           = rand(1,99);
    				$nama_file_unik = $acak.$nama_file; 	
					$indeks = $indeks + 1;
					$nama_file_tb[$i] ="images/product/".$nama_file_unik;
					
  					if ((isset($nama_file)) && ($nama_file != "")) 
					{
					
					      /* Remove first from server old images */
						           
						         $sSQL = "";
								 $gambarremove="";
							     switch ($indeks)
								 {
 								   case 1:
      								  $gambarremove = $image_1 ;
									  $sSQL = " update tb_product set image ='".$nama_file_tb[$i]."' where product_id='$product_id'";
									
									    mysql_query($sSQL);
									    break;
									   
    							   case 2:
       								  $gambarremove = $image_2 ;
									   $sSQL = " update tb_product set image_2 ='".$nama_file_tb[$i]."' where product_id='$product_id'";
									    mysql_query($sSQL) or die($sSQL);
        							  break;
    							   case 3:
        							  $gambarremove = $image_3 ;
									  $sSQL = " update tb_product set image_3 ='".$nama_file_tb[$i]."' where product_id='$product_id'";
									   mysql_query($sSQL) or die($sSQL);
        								break;
									case 4:
        							 $gambarremove = $image_4 ;
									 $sSQL = " update tb_product set image_4 ='".$nama_file_tb[$i]."' where product_id='$product_id'";
									  mysql_query($sSQL) or die($sSQL);
        								break;	
									case 5:
        							 $gambarremove = $image_5 ;
									  $sSQL = " update tb_product set image_5 ='".$nama_file_tb[$i]."' where product_id='$product_id'";
									   mysql_query($sSQL) or die($sSQL);
        								break;		
									case 6:
        							  $gambarremove = $image_6 ;
									  $sSQL = " update tb_product set image_6 ='".$nama_file_tb[$i]."' where product_id='$product_id'";
									    mysql_query($sSQL) or die($sSQL);
        								break;		
										
								}		//switch ($i)
								
								//die($sSQL);
								
								

								if (!empty($gambarremove) && $gambarremove!="")
								{
								    $remove = "../../../".$gambarremove;
						        	$real_gambar = str_replace("images/product/","",$gambarremove);
									$real_gambar = trim($real_gambar);
									$gambar_small = "../../../"."images/product/small_".$real_gambar;   
									$gambar_medium = "../../../"."images/product/medium_".$real_gambar;
					   
									unlink($remove);  
									unlink($gambar_small);   
									unlink($gambar_medium); 
								}	//((isset($gambarremove)) && ($gambarremove != "")) 	
								
								
								if ($tipe_file == "image/png")
							{
											UploadImageProdukPNG($nama_file_unik,$i);
							}
							else
							{
											UploadImageJPG_Product_Multiple($nama_file_unik,$i);
							}
							
						   
					 } // ((isset($nama_file)) && ($nama_file != "")) 
							
		  					
					}		// $for 
				
				
				
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
								 $loc = '../../media.php?module='.$module;
				 				 echo "<script>document.location = '$loc'</script>";
				
				
			
				
		}   // update
	
		
		elseif ($module=='product' AND $act=='hapusgambar')
		{

		  	
		  
		 	$gambar = $_GET[namafile];
			$indeks = $_GET[indeks];
			
			
		    $remove = "../../../".$gambar;
					   
			$real_gambar = str_replace("images/product/","",$gambar);
			$real_gambar = trim($real_gambar);
					   
			$gambar_small = "../../../"."images/product/small_".$real_gambar;
					   
			$gambar_medium = "../../../"."images/product/medium_".$real_gambar;
					   
			
			unlink($remove);  
			unlink($gambar_small);   
			unlink($gambar_medium); 
			
			$sSQL = "";  
			
			$sSQL = " update tb_product set ";
			if ($indeks=='1')
			   $sSQL = $sSQL." image='' ";
			else 
			   $sSQL = $sSQL." image_".$indeks."=''";
		  
		     $sSQL = $sSQL. " WHERE product_id='$_GET[id]'";
			 
		     mysql_query($sSQL);

	

		  
		  header('location:../../media.php?module='.$module.'&act=editproduct&id='.$_GET[id]);	

	}

   } //$_SESSION['username']

?>
