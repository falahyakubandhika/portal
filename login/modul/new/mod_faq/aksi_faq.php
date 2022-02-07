<?php
session_start();
include "../../../config/koneksi.php";
include "../../../config/fungsi_thumb.php";

$module=$_GET[module];
$act=$_GET[act];

// Update profil
if ($module=='faq' AND $act=='update')
   {
     $sSQL = " update tb_faq set faq_text ='".$_POST['isi']."' where id='".$_POST['id']."'";   

	mysql_query($sSQL);
	
	//header('location:../../media.php?module='.$module);
	
	$loc = '../../media.php?module='.$module;
    echo "<script>document.location = '$loc'</script>";
		 
 
}
?>
