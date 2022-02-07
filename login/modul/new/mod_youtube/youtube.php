<script language ="javascript">
function CekField()
{
	if (document.formData.nama.value=="")
	{
		alert("FB Name must be no blank !!!");
		document.formData.nama.focus();
		return false;
	}
	
	if (document.formData.username.value=="")
	{
		alert("Link FB  must be no blank !!!");
		document.formData.username.focus();
		return false;
	}
	
	
   return true;
}   
</script>
<?php
$aksi="modul/mod_youtube/aksi_youtube.php";
switch($_GET[act]){
  // Tampil youtube
  default:
    echo "<h2>youtube Status</h2>
          <input type=button class=button value='New youtube' 
          onclick=\"window.location.href='?module=youtube&act=tambahyoutube';\">
          <table>
          <tr><th>No</th><th>FB Name</th><th>Link FB</th><th>Status</th><th>Action</th></tr>"; 
    $tampil=mysql_query("SELECT  id, nama , username , IF(stsActive=1,'Active','InActive') AS IsActive FROM mod_youtube ORDER BY id DESC");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[nama]</td>
			 <td>$r[username]</td>
			 <td>$r[IsActive]</td>
			 
             <td><a href=?module=youtube&act=edityoutube&id=$r[id]><b>Edit</b></a> | 
	               <a href=$aksi?module=youtube&act=hapus&id=$r[id]><b>Delete</b></a>
             </td></tr>";
      $no++;
    }
    echo "</table>";
	echo "";
    break;
  
  // Form Tambah youtube
  case "tambahyoutube":
    echo "<h2>New youtube</h2>
          <form method=POST action='$aksi?module=youtube&act=input' name=formData enctype='multipart/form-data' onSubmit='return CekField();'>
          <table>
          <tr><td>FB Name</td><td> : <input type=text name='nama' onKeyUp='this.value = String(this.value).toUpperCase()' size='100'></td></tr>
		  <tr><td>Link FB</td><td> : <input type=text name='username' onKeyUp='this.value = String(this.value).toLowerCase()' size='50'></td></tr>
		  <tr><td>Status</td><td colspan=2 align=left>:
		  <input type=radio name='stsActive' value=1 checked>Active  
          <input type=radio name='stsActive' value=0> Inactive</td></tr>
		  
          <tr><td colspan=2><input type=submit name=submit class=button value=Simpan>
                            <input type=button class=button value=Cancel onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit youtube  
  case "edityoutube":
  
  
    $sSQL="SELECT * FROM mod_youtube WHERE id='$_GET[id]'";
    $rslt=mysql_query($sSQL) or die ("error query");
 	$i=0;
	while ($row=mysql_fetch_assoc($rslt))
	{
	        $id = $row['id'];
			$username = $row['username'];
			$stsActive=$row['stsActive'];
			$nama = $row['nama'];
	 }
	  mysql_free_result($rslt);
 

    echo "<h2>Edit youtube</h2>
          <form method=POST action='$aksi?module=youtube&act=update'  enctype='multipart/form-data' name=formData onSubmit='return CekField();'>
          <table>
          <tr><td>FB Name</td><td> : <input type=text name='nama' onKeyUp='this.value = String(this.value).toUpperCase()' size='100' value='$nama'></td></tr><input name='id' type='hidden' value='$id'>
		  <tr><td>Link FB</td><td> : <input type=text name='username' onKeyUp='this.value = String(this.value).toLowerCase()' size='120' value='$username'></td></tr>";
	if ($stsActive=='1') {
			echo "<tr><td>Status</td><td colspan=2 align=left>:<input type=radio name='stsActive' value=1 checked>Active  
        		 <input type=radio name='stsActive' value=0> Inactive</td></tr>";
    }
	else
	{
			echo "<tr><td>Status</td><td colspan=2 align=left>:<input type=radio name='stsActive' value=1>Active  
        		  <input type=radio name='stsActive' value=0 checked> Inactive</td></tr>";
	}		  
		  		  
       echo " <tr><td colspan=2><input type=submit name=submit class=button value=Simpan>
                            <input type=button class=button value=Cancel onclick=self.history.back()></td></tr>
              </table></form>";
	  
    break;  
}
?>
