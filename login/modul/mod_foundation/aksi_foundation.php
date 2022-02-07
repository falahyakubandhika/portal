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
	include "../../../config/fungsi_seo.php";
	
 	$module=$_GET[module];
	$act=$_GET[act];
	// Delete foundation
	if ($module=='foundation' AND $act=='hapus')
	{		
		$strSql = "delete from tb_foundation WHERE foundation_id='".$foundation_id."'";
		$result = mysql_query($strSql); 

		$loc = '../../media.php?module='.$module;
		echo "<script>document.location = '$loc'</script>";
	}  // hapus
	// Input foundation
	elseif ($module=='foundation' AND $act=='input')
	{   
		// echo "masup";
	    $foundation_title = $_POST['foundation_title'];
		$stsActive = $_POST['stsActive'];
		$seq = $_POST['seq'];
		$link=  seo_title($_POST['foundation_title']);
		
		$sSQL = "";
		$sSQL = "insert into tb_foundation (foundation_name, fl_active, seq, foundation_descr, link) values ('".$foundation_title."','".$stsActive."','".$seq."','".mysql_real_escape_string($_POST[descr])."','".$link."')";
				
		mysql_query($sSQL);
		$loc = '../../media.php?module='.$module;
		echo "<script>document.location = '$loc'</script>";
				
	 
	}   // act=input	
	
	elseif ($module=='foundation' AND $act=='update')
	{
	    $foundation_id = $_POST['foundation_id'];
	    $foundation_title = $_POST['foundation_title'];
		$fupload = $_POST['fupload'];
		$stsActive = $_POST['stsActive'];
		$seq = $_POST['seq'];
		$link =  seo_title($_POST['foundation_title']);
		
		$sSQL = " update tb_foundation set foundation_name ='".$foundation_title."', seq='".$seq."'";
		$sSQL = $sSQL." ,fl_active='".$stsActive."', foundation_descr='".mysql_real_escape_string($_POST[descr])."', link='".$link."' where foundation_id = '".$foundation_id."'";
		mysql_query($sSQL);
		header('location:../../media.php?module='.$module);
	} // $module=='foundation' AND $act=='update'
}	// 	empty($_SESSION['username']
?>

