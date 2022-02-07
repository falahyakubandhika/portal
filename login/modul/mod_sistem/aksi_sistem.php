<?php
session_start();
include "../../../config/koneksi.php";
include "../../../config/fungsi_thumb.php";
$module=$_GET[module];
$act=$_GET[act];
// Update profil
if ($module=='sistem' AND $act=='update')
{
	$sSQL = " update tb_sistem set sistem_text ='".$_POST[isi]."' where id='".$_POST['id']."'";
	mysql_query($sSQL);
	$loc = '../../media.php?module='.$module;
    echo "<script>document.location = '$loc'</script>";
}
?>
