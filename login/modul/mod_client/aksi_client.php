<?php
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";
include "../../../config/library.php";
include "../../../config/fungsi_thumb.php";
include "../../../config/fungsi_seo.php";


	$module=$_GET[module];
	$act=$_GET[act];

	if ($module=='client' AND $act=='update'){

    		mysql_query("UPDATE oc_customer SET	newsletter 	 = '$_POST[aktif]'
            	                 WHERE customer_id = '$_POST[id]'");
	
 		 header('location:../../media.php?module='.$module);
} 
}
?>
