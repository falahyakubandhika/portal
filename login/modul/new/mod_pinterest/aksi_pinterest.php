<?php
session_start();
include "../../../config/koneksi.php";

$module=$_GET[module];
$act=$_GET[act];
$id=$_POST[id];

// Hapus pinterest
if ($module=='pinterest' AND $act=='hapus'){
  mysql_query("DELETE FROM mod_pinterest WHERE id='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input pinterest
elseif ($module=='pinterest' AND $act=='input')
{
   $nama =   $_POST['nama'];
   $username = $_POST['username'];
   $stsActive = $_POST['stsActive'];
   
   $sSQL = " select username from mod_pinterest where username='$username' limit 1";
		 
 		$reccount = 0;
 		$reccount = mysql_num_rows(mysql_query($sSQL));

		 if ($reccount==0)
		 {
  			  $sSQL = " insert into mod_pinterest ( nama , username,stsActive ) ";
			  $sSQL= $sSQL." values ('".$nama."',"."'".$username."',"."'".$stsActive."')";
			  mysql_query($sSQL);
 		 }
		 header('location:../../media.php?module='.$module);
}

// Update pinterest
elseif ($module=='pinterest' AND $act=='update'){
  $id = $_POST['id'];
  $nama =   $_POST['nama'];
  $username = $_POST['username'];
  $stsActive = $_POST['stsActive'];
  $sSQL="";
  $sSQL = " update mod_pinterest set nama ='".$nama."',username='".$username."',stsActive ='".$stsActive."'" ;
  $sSQL = $sSQL." where id ='".$id."'";
  mysql_query($sSQL);
  $loc = '../../media.php?module='.$module;
  echo "<script>document.location = '$loc'</script>";
}
?>
