<?php
 session_start();
 if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser']))
 {
 		 echo "<link href='style.css' rel='stylesheet' type='text/css'>
 				<center>Untuk mengakses modul, Anda harus login22 <br>";
 				 echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else
{
 	include "../../../config/koneksi.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_thumb.php";
	
 	$module=$_GET[module];
	$act=$_GET[act];
	// Delete running
	if ($module=='running' AND $act=='hapus'){
        $running_id = $_GET['running_id'];
		
		
			$strSql = "delete from tb_running_text WHERE running_id='".$running_id."'";
	  		$result = mysql_query($strSql); 
			
			$loc = '../../media.php?module='.$module;
		 	echo "<script>document.location = '$loc'</script>";
		 
		
		
		
		 

	}

	// Input running
	elseif ($module=='running' AND $act=='input'){   
	    $running_title = $_POST['running_title'];
		$stsActive = $_POST['stsActive'];
	
		$sSQL = "";
		$sSQL = " insert into tb_running_text (running_text , fl_active) ";
		$sSQL = $sSQL." values ('".$running_title."',";
		$sSQL = $sSQL."'".$stsActive."')";
		
		
						
							
		mysql_query($sSQL);
		header('location:../../media.php?module='.$module);

		
	   
	}   // act=input	
	
	elseif ($module=='running' AND $act=='update'){
	    $running_id = $_POST['running_id'];
	    $running_title = $_POST['running_title'];
	
		$stsActive = $_POST['stsActive'];
		$sSQL = " update tb_running_text set running_text ='".$running_title."'";
	    $sSQL = $sSQL." ,fl_active='".$stsActive."' where running_id = '".$running_id."'";
	    mysql_query($sSQL);
		header('location:../../media.php?module='.$module);
	
	} // $module=='running' AND $act=='update'
	
	
}	// 	empty($_SESSION['username']
?>

