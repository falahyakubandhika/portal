<script language ="javascript">
function CekField()
{
	if (document.formData.nama.value=="")
	{
		alert("Livechat Name must be no blank !!!");
		document.formData.nama.focus();
		return false;
	}
	
	if (document.formData.username.value=="")
	{
		alert("Link Livechat  must be no blank !!!");
		document.formData.username.focus();
		return false;
	}
	
	
   return true;
}   
</script>
<?php
$aksi="modul/mod_livechat/aksi_livechat.php";
switch($_GET[act]){
  // Tampil livechat
  default:
    echo "<h2>Livechat Status</h2>
          <input type=button class=button value='New livechat' 
          onclick=\"window.location.href='?module=livechat&act=tambahlivechat';\">
          <table>
          <tr><th>No</th><th>Livechat Name</th><th>Link Livechat</th><th>Status</th><th>Action</th></tr>"; 
    $tampil=mysql_query("SELECT  id, nama , username , IF(stsActive=1,'Active','InActive') AS IsActive FROM mod_livechat ORDER BY id DESC");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[nama]</td>
			 <td>$r[username]</td>
			 <td>$r[IsActive]</td>
			 
             <td><a href=?module=livechat&act=editlivechat&id=$r[id]><b>Edit</b></a> | 
	               <a href=$aksi?module=livechat&act=hapus&id=$r[id]><b>Delete</b></a>
             </td></tr>";
      $no++;
    }
    echo "</table>";
	echo "";
    break;
  
  // Form Tambah livechat
  case "tambahlivechat":
    echo "<h2>New Livechat</h2>
          <form method=POST action='$aksi?module=livechat&act=input' name=formData enctype='multipart/form-data' onSubmit='return CekField();'>
          <table>
          <tr><td>Livechat Name</td><td> : <input type=text name='nama' onKeyUp='this.value = String(this.value).toUpperCase()' size='100'></td></tr>
		  <tr><td>Link Livechat</td><td> : <input type=text name='username' onKeyUp='this.value = String(this.value).toLowerCase()' size='50'></td></tr>
		  <tr><td>Status</td><td colspan=2 align=left>:
		  <input type=radio name='stsActive' value=1 checked>Active  
          <input type=radio name='stsActive' value=0> Inactive</td></tr>
		  
          <tr><td colspan=2><input type=submit name=submit class=button value=Simpan>
                            <input type=button class=button value=Cancel onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit livechat  
  case "editlivechat":
  
  
    $sSQL="SELECT * FROM mod_livechat WHERE id='$_GET[id]'";
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
 

    echo "<h2>Edit Livechat</h2>
          <form method=POST action='$aksi?module=livechat&act=update'  enctype='multipart/form-data' name=formData onSubmit='return CekField();'>
          <table>
          <tr><td>Livechat Name</td><td> : <input type=text name='nama' onKeyUp='this.value = String(this.value).toUpperCase()' size='100' value='$nama'></td></tr><input name='id' type='hidden' value='$id'>
		  <tr><td>Link Livechat</td><td> : <input type=text name='username' onKeyUp='this.value = String(this.value).toLowerCase()' size='120' value='$username'></td></tr>";
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
