<script language ="javascript">
function CekField()
{
	if (document.formData.running_title.value=="")
	{
		alert("running Name must be no blank !!!");
		document.formData.running_title.focus();
		return false;
	}
	

   return true;
}   

function CekUpdate()
{
	if (document.formData.running_title.value=="")
	{
		alert("running Name must be no blank !!!");
		document.formData.running_title.focus();
		return false;
	}
	
   return true;
}   


</script>

<?php
 session_start();
// echo $_SESSION['namauser'].$_SESSION['passuser'];
 if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser']))
 {
 		 echo "<link href='style.css' rel='stylesheet' type='text/css'>
 				<center>Untuk mengakses modul, Anda harus login2 <br>";
 				 echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}

   $aksi="modul/mod_running/aksi_running.php";
  
switch($_GET[act]){
  // Tampil Kategori
  default:  
  echo "<h2>RUNNING TEXT </h2>
          <input type=button class='button' value='New running' 
          onclick=\"window.location.href='?module=running&act=tambahrunning';\">
          <table>
          <tr><th>ID</th><th>running Text</th><th>Status</th><th>Action</th></tr>"; 
		  
		   $p = new Paging;
		   $batas  = 10;
		   $posisi = $p->cariPosisi($batas);

		  $sSQL = "SELECT running_id , running_text , IF(fl_active=1,'Enabled','Disabled') AS IsActive FROM tb_running_text order by running_id LIMIT $posisi,$batas";
		  
  		  $tampil=mysql_query($sSQL);
    	  $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$r[running_id]</td>
             <td>$r[running_text]</td>
			 <td>$r[IsActive]</td>
			 
             <td><a href=?module=running&act=editrunning&running_id=$r[running_id]><b>Edit</b></a> | 
	               <a href=$aksi?module=running&act=hapus&running_id=$r[running_id]><b>Delete</b></a>
             </td></tr>";
      $no++;
	 } 
   
    echo "</table>";
	$jmldata = mysql_num_rows(mysql_query("select  * from tb_running_text"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);
	
    echo "<div id=paging>Page: $linkHalaman</div><br>";
    break;
	// Form Tambah running
  case "tambahrunning":
       $sSQL = "  SELECT (running_id + 1) AS running_id FROM tb_running_text ORDER BY running_id DESC LIMIT 1 ";
	   $rslt=mysql_query($sSQL) or die ("error query");
 	   $i=0;
	   while ($row=mysql_fetch_assoc($rslt))
	   {
	        $running_id = $row['running_id'];
	   }
	    mysql_free_result($rslt);
 
    echo "<h2>New Running Text</h2>
          <form method=POST action='$aksi?module=running&act=input' name=formData onSubmit='return CekField();' enctype='multipart/form-data'>
          <table>
		  <tr><td>Id</td><td>:$running_id</td><input name='running_id' type='hidden' value='$running_id'>
		  </tr>
          <tr><td>Title</td><td> : <input type=text name='running_title' size='30'></td></tr>
		  
		  <tr><td>Status</td><td colspan=2 align=left>:
		  <input type=radio name='stsActive' value=1 checked>Enabled  
          <input type=radio name='stsActive' value=0> Disabled</td></tr>
		  
		  
          <tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
	  
     break;
  
  // Form Edit running
  case "editrunning":

   $sSQL="select * from tb_running_text WHERE running_id='$_GET[running_id]' limit 1";
	   $rslt=mysql_query($sSQL) or die ("error query");
 	   $i=0;
	   while ($row=mysql_fetch_assoc($rslt))
	   {
	        $running_id = $row['running_id'];
			$running_title = $row['running_text'];
			
			$stsActive=$row['fl_active'];

	   }
	    mysql_free_result($rslt);
		
		
			
    echo "<h2>Running Text Edit</h2>
	<form method=POST action='$aksi?module=running&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
	<table>
		<tr><td>Id</td><td>$running_id</td><input name='running_id' type='hidden' value='$running_id'></td></tr>
		<tr><td>Title</td><td><input type=text name='running_title' size='90' value='$running_title'></td></tr>";
		if ($stsActive=='1') {
			echo "<tr><td>Status</td><td colspan=2 align=left><input type=radio name='stsActive' value=1 checked>Enabled
			<input type=radio name='stsActive' value=0> Disabled</td></tr>";
		}
		else
		{
			echo "<tr><td>Status</td><td colspan=2 align=left><input type=radio name='stsActive' value=1>Enabled 
			<input type=radio name='stsActive' value=0 checked> Disabled</td></tr>";
		}		  
		echo "<tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
		<input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
	</table></form>";              
    break;  
}
?>