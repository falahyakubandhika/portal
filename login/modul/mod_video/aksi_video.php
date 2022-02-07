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
	// Delete Banner
	if ($module=='video' AND $act=='hapus'){
        $Id = $_GET['Id'];
		$sSQL = "";
		$sSQL = " SELECT URL FROM bb_video WHERE Id ='".$Id."' limit 1";
		$rslt=mysql_query($sSQL) or die ("error query");
 		while ($row=mysql_fetch_assoc($rslt))
		{
			$gambar = $row['URL'];
		}
		mysql_free_result($rslt);
				
		$strSql = "delete from bb_video WHERE Id='".$Id."'";
	  	$result = mysql_query($strSql); 
		$loc = '../../media.php?module='.$module;
		echo "<script>document.location = '$loc'</script>";
	}
	// Input banner
	elseif ($module=='video' AND $act=='input'){  
			// without images 
			$sSQL = "";
			$sSQL = " insert into bb_video (URL) values ('".$_POST['URL']."')";
		  	$result = mysql_query($sSQL); 
			header('location:../../media.php?module='.$module);
	}   // act=input
	elseif ($module=='video' AND $act=='update'){
	    $Id = $_POST['Id'];
		$URL = $_POST['URL'];
		$sSQL = " update bb_video set URL ='".$URL."' where Id = '".$Id."'";
		mysql_query($sSQL);
		header('location:../../media.php?module='.$module);
	
	} // $module=='banner' AND $act=='update'
}	// 	empty($_SESSION['username']
?>

