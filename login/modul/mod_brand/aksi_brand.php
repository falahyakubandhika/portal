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
	// Delete brand
	if ($module=='brand' AND $act=='hapus'){
        $brand_id = $_GET['brand_id'];
		
		$sSQL = "";
		$sSQL = " select brand_id from tb_product  where brand_id ='".$brand_id."' limit 1";
		$total = mysql_num_rows(mysql_query($sSQL));
		if ($total>0)
		{
		    echo "<script>
						window.alert('Data brand tidak dapat dihapus karena sudah digunakan dalam product');
						window.location=('../../media.php?module=brand')
				 </script>";
		}
		else 
		{
			$strSql = "delete from tb_brand WHERE brand_id='".$brand_id."'";
	  		$result = mysql_query($strSql); 
			
			$loc = '../../media.php?module='.$module;
		 	echo "<script>document.location = '$loc'</script>";
		 
		}	
		
		
		 

	}

	// Input brand
	elseif ($module=='brand' AND $act=='input'){   
	    $brand_title = $_POST['brand_title'];
	    $brand_desc = $_POST['brand_desc'];
		$stsActive = $_POST['stsActive'];
	
		$sSQL = "";
		$sSQL = " insert into tb_brand (brand_name , brand_desc, fl_active) ";
		$sSQL = $sSQL." values ('".$brand_title."','".$brand_desc."',";
		$sSQL = $sSQL."'".$stsActive."')";
						
							
		mysql_query($sSQL);
		header('location:../../media.php?module='.$module);

		
	   
	}   // act=input	
	
	elseif ($module=='brand' AND $act=='update'){
	    $brand_id = $_POST['brand_id'];
	    $brand_desc = $_POST['brand_desc'];
	    $brand_title = $_POST['brand_title'];
	
		$stsActive = $_POST['stsActive'];
		$sSQL = " update tb_brand set brand_name ='".$brand_title."', brand_desc ='".$brand_desc."'";
	    $sSQL = $sSQL." ,fl_active='".$stsActive."' where brand_id = '".$brand_id."'";
	    mysql_query($sSQL);
		header('location:../../media.php?module='.$module);
	
	} // $module=='brand' AND $act=='update'
	
	
}	// 	empty($_SESSION['username']
?>

