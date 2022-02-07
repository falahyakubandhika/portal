<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";

$module=$_GET['module'];
$act=$_GET['act'];

// Input user
if ($module=='user' AND $act=='input'){
  $pass=md5($_POST[password]);
  mysql_query("INSERT INTO users(username,
                                 password,
                                 nama_lengkap,
                                 email, 
                                 no_telp,
                                 id_session,
								 id_user_group) 
	                       VALUES('$_POST[username]',
                                '$pass',
                                '$_POST[nama_lengkap]',
                                '$_POST[email]',
                                '$_POST[no_telp]',
                                '$pass',
								'$_POST[usergroup]')");
  header('location:../../media.php?module='.$module);
}

// Update user
elseif ($module=='user' AND $act=='update'){
  if (empty($_POST[password])) {
    mysql_query("UPDATE users SET nama_lengkap   = '$_POST[nama_lengkap]',
                                  email          = '$_POST[email]',
                                  blokir         = '$_POST[blokir]',  
                                  no_telp        = '$_POST[no_telp]',
								  is_marketing   = '$_POST[is_marketing]',
								  id_user_group  = '$_POST[usergroup]'
                           WHERE  id_session     = '$_POST[id]'");
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST[password]);
    mysql_query("UPDATE users SET password        = '$pass',
                                 nama_lengkap    = '$_POST[nama_lengkap]',
                                 email           = '$_POST[email]',  
                                 blokir          = '$_POST[blokir]',  
                                 no_telp         = '$_POST[no_telp]',
								 id_user_group  = '$_POST[usergroup]'  
                           WHERE id_session      = '$_POST[id]'");
						  
  }
  header('location:../../media.php?module='.$module);
}

// Input user_group
elseif ($module=='user' AND $act=='blokir'){
 
	if ($_GET['blokir']=='N'){
  		mysql_query("UPDATE users SET blokir = 'Y' WHERE id_user = '$_GET[id]'");
	}elseif ($_GET['blokir']=='Y'){
		mysql_query("UPDATE users SET blokir = 'N' WHERE id_user = '$_GET[id]'");
	}
  header('location:../../media.php?module='.$module);
}
}
?>
