<?php
$aksi="modul/mod_users_group/aksi_users_group.php";
switch($_GET[act]){
  // Tampil users_group
  default:
    echo "<h2>Group User</h2>
          <input type=button value='Tambah Group' onclick=\"window.location.href='?module=users_group&act=tambahgroup';\" class='button'>
          <table>
          <tr><th>no</th><th>nama group</th><th>aktif</th><th>aksi</th></tr>"; 
    $tampil=mysql_query("SELECT * FROM users_group ORDER BY id_user_group");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
		if ($r['aktif'] == 'Y'){
			$aktif="<img src='images/aktif.png' class='tombol'>";
		}else{
			$aktif="<img src='images/nonaktif.png' class='tombol'>";
		}

       echo "<tr><td>$no</td>
             <td>$r[nama_user_group]</td>";
		if ($r['nama_user_group'] != 'Administrators') { 	 
	   echo	"<td align='center'><a href=$aksi?module=users_group&act=aktifnonaktif&id=$r[id_user_group]&aktif=$r[aktif]>$aktif</a></td>
             <td><a href=?module=users_group&act=editgroup&id=$r[id_user_group] title='Edit'><img src='images/user_edit.png' class='tombol'></a>  
			 	  
			     <a href=?module=users_group&act=permissions&id=$r[id_user_group] title='Permissions'><img src='images/lock.png' class='tombol'> </a></td>";
		}	//<a href=$aksi?module=users_group&act=hapus&id=$r[id_user_group] title='Hapus' class='ask'><img src='images/trash.png' class='tombol'></a>	 
		echo "</tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  // Form Tambah users_group
  case "tambahgroup":
    echo "<h2>Tambah Group User</h2>
          <form method=POST action='$aksi?module=users_group&act=input'>
          <table>
          <tr><td>Nama Group</td><td> : <input type=text name='nama_user_group'></td></tr>
          <tr><td>Aktif</td>      <td> : <input type=radio name='aktif' value='Y' checked>Y  
                                         <input type=radio name='aktif' value='N'> N</td></tr>
          <tr><td colspan=2><input type=submit name=submit value=Simpan  class='button'>
                            <input type=button value=Batal onclick=self.history.back()  class='button'></td></tr>
          </table></form>";
     break;
  
  // Form Edit users_group  
  case "editgroup":
    $edit=mysql_query("SELECT * FROM users_group WHERE id_user_group='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Group User</h2>
          <form method=POST action=$aksi?module=users_group&act=update>
          <input type=hidden name=id value='$r[id_user_group]'>
          <table>
          <tr><td>Nama users_group</td><td> : <input type=text name='nama_user_group' value='$r[nama_user_group]'></td></tr>";
    if ($r[aktif]=='Y'){
      echo "<tr><td>Aktif</td> <td> : <input type=radio name='aktif' value='Y' checked>Y  
                                      <input type=radio name='aktif' value='N'> N</td></tr>";
    }
    else{
      echo "<tr><td>Aktif</td> <td> : <input type=radio name='aktif' value='Y'>Y  
                                      <input type=radio name='aktif' value='N' checked>N</td></tr>";
    }
	
    echo"  <tr><td colspan=2><input type=submit value=Update  class='button'>
                            <input type=button value=Batal onclick=self.history.back()  class='button'></td></tr>
          </table></form>";
    break;  
	
  // Form Edit users_group  
  case "permissions":
    $edit=mysql_query("SELECT * FROM users_group WHERE id_user_group='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Permision <b style='color:red;'>$r[nama_user_group]</b></h2>";
		
	echo"<input type=button value='Aktifkan Semua' onclick=\"window.location.href='$aksi?module=users_group&act=aktifnonaktifmenuall&id=$r[id_user_group]&aktif=Y';\">
		 <input type=button value='Non Aktifkan Semua' onclick=\"window.location.href='$aksi?module=users_group&act=aktifnonaktifmenuall&id=$r[id_user_group]&aktif=N';\">
		 <input type=button value=Back onclick=self.history.back()>
		 <br><br>";
		
    echo"<div style='background-color:#ccc; padding:10px;'>";
				
    function html_menu(&$strmenu="", $parent=0) {
    
	
	$query ="SELECT MN.id_menu, MN.id_user_group, MN.id_modul, MN.aktif, MN.id_parent, 
									 MD.id_modul, MD.nama_modul  
									 FROM menu_admin MN
									 INNER JOIN modul MD ON MD.id_modul=MN.id_modul
									 INNER JOIN users_group UG ON UG.id_user_group=MN.id_user_group
									 WHERE MN.id_user_group='$_GET[id]' 
									 AND MN.id_parent='$parent'";
    //die ($query);
    $sql = mysql_query($query);
     
    if (mysql_num_rows($sql) > 0) {
    $strmenu .= '<ul >';
    }
     
    // tampilkan anaknya
    while ($row = mysql_fetch_assoc($sql)) {
     
    $strmenu .= "<li><span class='aktifnonaktif-ul'>";
    $strmenu .= sprintf("%s </span> <span class='aktifnonaktif'> <a href='modul/mod_users_group/aksi_users_group.php?module=users_group&act=aktifnonaktifmenu&id=%s&aktif=%s'>%s</a> </span>"
						, $row['nama_modul'], $row['id_menu'], $row['aktif'], $row['aktif'] );
     
    //panggil diri sendiri
    html_menu($strmenu, $row['id_modul']);
    $strmenu .= "</li>";
    }
     
    if (mysql_num_rows($sql) > 0)
    $strmenu .= '</ul>';
     
    }
     
    $strmenu = "";
    html_menu($strmenu, 0);
    echo $strmenu;				
				echo"</div>";
    break;  	
	
}
?>
