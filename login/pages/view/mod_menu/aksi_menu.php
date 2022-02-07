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
	include "../../../../config/fungsi_seo.php";
	
 	$module=$_GET['module'];
	$act=$_GET['act'];
	// Delete brand
	if ($module=='menu' AND $act=='hapus'){
        $brand_id = $_GET['id'];
		
		$sSQL = "";
		$sSQL = " select brand_id from tb_product  where brand_id ='".$brand_id."' limit 1";
		$total = mysql_num_rows(mysql_query($sSQL));
		if ($total>0)
		{
		    echo "<script>
						window.alert('Data brand tidak dapat dihapus karena sudah digunakan dalam product');
						window.location=('../../../?module=brand')
				 </script>";
		}
		else 
		{
			$strSql = "delete from tb_brand WHERE brand_id='".$brand_id."'";
	  		$result = mysql_query($strSql); 
			
			$loc = '../../../?module='.$module;
		 	echo "<script>document.location = '$loc'</script>";
		 
		}	
		
		
		 

	}

	// Input brand
	elseif ($module=='menu' AND $act=='input'){   
	    $brand_name = $_POST['brand_name'];
	    $brand_desc = $_POST['brand_desc'];
	     $brand_name_id = $_POST['brand_name_id'];
	    $brand_desc_id = $_POST['brand_desc_id'];
	    $link = $_POST['link'];
		$stsActive = $_POST['stsActive'];
		$judul_seo		= seo_title( $_POST['brand_name']);	
		$sSQL = "";
		$sSQL = " insert into tb_brand (brand_url, brand_name , brand_desc, brand_name_id, brand_desc_id, fl_active, link) ";
		$sSQL = $sSQL." values ('".$judul_seo."','".$brand_name."','".$brand_desc."','".$brand_name_id."','".$brand_desc_id."',";
		$sSQL = $sSQL."'".$stsActive."','".$link."')";
						
							
		mysql_query($sSQL);
		header('location:../../../?module='.$module);

		
	   
	}   // act=input	
	
	elseif ($module=='menu' AND $act=='update'){
	    $brand_id = $_POST['brand_id'];
	    $brand_desc = $_POST['brand_desc'];
	    $brand_name = $_POST['brand_name'];
	    $brand_name_id = $_POST['brand_name_id'];
	    $brand_desc_id = $_POST['brand_desc_id'];
	    $link = $_POST['link'];
	    $judul_seo	= seo_title( $_POST['brand_name']);
	
		$stsActive = $_POST['stsActive'];
		$sSQL = " update tb_brand set brand_url='".$judul_seo."',brand_name ='".$brand_name."', brand_desc ='".$brand_desc."',brand_name_id ='".$brand_name_id."',brand_desc_id ='".$brand_desc_id."'";
	    $sSQL = $sSQL." ,fl_active='".$stsActive."',link='".$link."' where brand_id = '".$brand_id."'";
	    mysql_query($sSQL);
		header('location:../../../?module='.$module);
	
	} // $module=='brand' AND $act=='update'
	
	
}	// 	empty($_SESSION['username']
?>

