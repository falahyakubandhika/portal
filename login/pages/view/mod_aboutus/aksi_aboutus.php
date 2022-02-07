<?php
session_start();
include "../../../config/koneksi.php";
include "../../../../config/fungsi_thumb.php";

$module=$_GET['module'];
$act=$_GET['act'];

// Update profil
if ($module=='aboutus' AND $act=='update')
   {
     $sSQL = " update tb_about set about_text ='".$_POST['isi']."' where id='".$_POST['id']."'";   

	mysql_query($sSQL);
	
	//header('location:../../media.php?module='.$module);
	
	$loc = '../../media.php?module='.$module;
    echo "<script>alert('Data anda berhasil di update'); window.location = '../../../?module=".$module."'</script>";
		 
 
}
?>
