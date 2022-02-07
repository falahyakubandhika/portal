<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

include "../../../config/koneksi.php";
//phpinfo();
$module=$_GET['module'];
$act=$_GET['act'];

// Hapus modul
if ($module=='modul' AND $act=='hapus'){
  mysql_query("DELETE FROM modul WHERE id_modul='".$_GET['id']."'");
  echo "<script>alert('Data anda berhasil di delete'); window.location = '../../../?module=".$module."'</script>";
}

// Input modul
elseif ($module=='modul' AND $act=='input'){
  // Cari angka urutan terakhir
  $u=mysql_query("SELECT urutan FROM modul ORDER by urutan DESC");
  $d=mysql_fetch_array($u);
  $urutan=$d['urutan']+1;
  
  // Input data modul
  mysql_query("INSERT INTO modul(nama_modul,
                                 link,
                                 publish,
                                 aktif,
                                 status,
                                 urutan,
								 id_group,
								 link_file) 
	                       VALUES('$_POST[nama_modul]',
                                '$_POST[link]',
                                '$_POST[publish]',
                                '$_POST[aktif]',
                                '$_POST[status]',
                                '$urutan',
								'$_POST[mainmenu]',
								'$_POST[link_file]')");
								
								
  $sql=mysql_query("SELECT last_insert_id() as id_modul");
  $data=mysql_fetch_array($sql);
  $id_modul=$data['id_modul'];
  
  $sql1=mysql_query("SELECT * FROM modul WHERE id_modul='$id_modul'");
  $data1=mysql_fetch_array($sql1);
  $id_parent=$data1['id_group'];
  
  $tampil=mysql_query("SELECT * FROM users_group where aktif='Y'");
  while($r=mysql_fetch_array($tampil)) {
	  $id_user_group =$r['id_user_group'];
	  if ($id_user_group=='1') {
	  	$aktif='Y';
	  }else{
	  	$aktif='N';
	  } 
	  mysql_query(" INSERT INTO menu_admin(id_user_group, id_modul, id_parent, aktif) 
					  VALUES ($id_user_group, $id_modul, $id_parent, '$aktif')");
  }
	echo "<script>alert('Data anda berhasil di input'); window.location = '../../../?module=".$module."'</script>";
}

// Update modul
elseif ($module=='modul' AND $act=='update'){
	$sql ="UPDATE modul SET nama_modul = '$_POST[nama_modul]',
                                link       = '$_POST[link]',
                                publish    = '$_POST[publish]',
                                aktif      = '$_POST[aktif]',
                                status     = '$_POST[status]',
                                urutan     = '$_POST[urutan]',
								id_group   = '$_POST[mainmenu]',
								link_file  = '$_POST[link_file]'  
                          WHERE id_modul   = '$_POST[id]'";
  mysql_query($sql);
 
  echo "<script>alert('Data anda berhasil di update'); window.location = '../../../?module=".$module."'</script>";
}

elseif ($module=='modul' AND $act=='aktifnonaktif'){
	
	if ($_GET['aktif']=='Y'){
  		mysql_query("UPDATE modul SET aktif = 'N' WHERE id_modul = '$_GET[id]'");
	}elseif ($_GET['aktif']=='N'){
		mysql_query("UPDATE modul SET aktif = 'Y' WHERE id_modul = '$_GET[id]'");
	}
header('location:../../media.php?module='.$module);
}

elseif ($module=='modul' AND $act=='publish'){
	
	if ($_GET['publish']=='Y'){
  		mysql_query("UPDATE modul SET publish = 'N' WHERE id_modul = '$_GET[id]'");
	}elseif ($_GET['publish']=='N'){
		mysql_query("UPDATE modul SET publish = 'Y' WHERE id_modul = '$_GET[id]'");
	}
echo "<script>alert('Data anda berhasil di update'); window.location = '../../../?module=".$module."'</script>";
}
}
?>
