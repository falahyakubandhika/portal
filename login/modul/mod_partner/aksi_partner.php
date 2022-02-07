<?php
session_start();
include "../../../config/koneksi.php";
include "../../../config/fungsi_thumb.php";

$module=$_GET[module];
$act=$_GET[act];

// Update profil
if ($module=='partner' AND $act=='update')
   {
     $sSQL = " update tb_partner set partner_text ='".$_POST['isi']."' where id='".$_POST['id']."'";   

	mysql_query($sSQL);
	
	
	
	$loc = '../../media.php?module='.$module;
    echo "<script>document.location = '$loc'</script>";
		 
 
}
?>
