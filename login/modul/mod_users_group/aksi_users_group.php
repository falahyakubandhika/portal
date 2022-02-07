<?php
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";
include "../../../config/fungsi_seo.php";

$module=$_GET['module'];
$act=$_GET['act'];

// Nonaktif
if ($module=='users_group' AND $act=='aktifnonaktif'){
	if ($_GET['aktif']=='Y'){
  		mysql_query("UPDATE users_group SET aktif = 'N' WHERE id_user_group = '$_GET[id]'");
	}elseif ($_GET['aktif']=='N'){
		mysql_query("UPDATE users_group SET aktif = 'Y' WHERE id_user_group = '$_GET[id]'");
	}
  header('location:../../media.php?module='.$module);
}

// Input user_group
elseif ($module=='users_group' AND $act=='input'){
  $user_group_seo = seo_title($_POST['nama_user_group']);
  mysql_query("INSERT INTO users_group(nama_user_group, aktif) VALUES('$_POST[nama_user_group]','$_POST[aktif]')");
  
  $sql=mysql_query("SELECT last_insert_id() as id_user_group");
  $data=mysql_fetch_array($sql);
  $id_terakhir=$data['id_user_group'];
  
  $tampil=mysql_query("SELECT * FROM modul where aktif='Y')");
  mysql_query(" INSERT INTO menu_admin(id_user_group, id_modul, id_parent, aktif) 
  				  SELECT $id_terakhir, id_modul, id_group, 'N' FROM modul where aktif='Y'");
  header('location:../../media.php?module='.$module);
}

// Update user_group
elseif ($module=='users_group' AND $act=='update'){
  $user_group_seo = seo_title($_POST['nama_user_group']);
  mysql_query("UPDATE users_group SET nama_user_group = '$_POST[nama_user_group]', aktif = '$_POST[aktif]' WHERE id_user_group = '$_POST[id]'");
  
  //delet dulu
  mysql_query("DELETE FROM menu_admin WHERE id_user_group = '$_POST[id]'");
  
  $tampil=mysql_query("SELECT * FROM modul where aktif='Y')");
  mysql_query(" INSERT INTO menu_admin(id_user_group, id_modul, id_parent, aktif) 
  				  SELECT '$_POST[id]', id_modul, id_group, 'N' FROM modul where aktif='Y'");
  
  //echo  ("SELECT '$_POST[id]', id_modul, id_group, 'N' FROM modul where aktif='Y'");
  header('location:../../media.php?module='.$module);
}

elseif ($module=='users_group' AND $act=='aktifnonaktifmenu'){
	
	if ($_GET['aktif']=='Y'){
  		mysql_query("UPDATE menu_admin SET aktif = 'N' WHERE id_menu = '$_GET[id]'");
	}elseif ($_GET['aktif']=='N'){
		mysql_query("UPDATE menu_admin SET aktif = 'Y' WHERE id_menu = '$_GET[id]'");
	}
	$sql=mysql_query("SELECT id_user_group FROM menu_admin WHERE id_menu = '$_GET[id]'");
  	$data=mysql_fetch_array($sql);
  	$id_group=$data['id_user_group'];	
  header('location:../../media.php?module=users_group&act=permissions&id='.$id_group);
}

elseif ($module=='users_group' AND $act=='aktifnonaktifmenuall'){
	
	if ($_GET['aktif']=='N'){
  		mysql_query("UPDATE menu_admin SET aktif = 'N' WHERE id_user_group = '$_GET[id]'");
	}elseif ($_GET['aktif']=='Y'){
		mysql_query("UPDATE menu_admin SET aktif = 'Y' WHERE id_user_group = '$_GET[id]'");
	}

  	$id_group=$_GET[id];	
  header('location:../../media.php?module=users_group&act=permissions&id='.$id_group);
}

// Input user_group
elseif ($module=='users_group' AND $act=='hapus'){
 
  mysql_query("DELETE FROM users_group WHERE id_user_group='$_GET[id]'");
  mysql_query("DELETE FROM menu_admin WHERE id_user_group='$_GET[id]'");

  header('location:../../media.php?module='.$module);
}


}
?>
