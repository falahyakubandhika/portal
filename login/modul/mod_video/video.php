<script language ="javascript">
function CekField()
{
   return true;
}   

function CekUpdate()
{
   return true;
}
</script>

<?php
   $aksi="modul/mod_video/aksi_video.php";
  
switch($_GET[act]){
	// Tampil Kategori
	default:  
	echo "<h2>Video</h2>
		<input type=button class='button' value='New Video' 
		onclick=\"window.location.href='?module=video&act=tambahvideo';\">
		<table>
		<tr><th>ID</th><th>Video</th><th>Action</th></tr>";
		$p = new Paging;
		$batas  = 10;
		$posisi = $p->cariPosisi($batas);
		$sSQL = "SELECT Id   FROM bb_video order by Id LIMIT $posisi,$batas";
		$tampil=mysql_query($sSQL);
		$no=1;
		while ($r=mysql_fetch_array($tampil)){
			echo "<tr><td>$r[Id]</td>
			<td>$r[Id]</td>
			<td><a href=?module=video&act=editvideo&Id=$r[Id]><b>Edit</b></a> | 
			<a href=$aksi?module=video&act=hapus&Id=$r[Id]><b>Delete</b></a>
			</td></tr>";
			$no++;
		}
		echo "</table>";
		$jmldata = mysql_num_rows(mysql_query("select  * from bb_video"));
		$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
		$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);

		echo "<div id=paging>Page: $linkHalaman</div><br>";
	break;
	// Form Tambah Kategori
  case "tambahvideo":
       $sSQL = "  SELECT (Id + 1) AS Id FROM bb_video ORDER BY Id DESC LIMIT 1 ";
	   $rslt=mysql_query($sSQL) or die ("error query");
 	   $i=0;
	   while ($row=mysql_fetch_assoc($rslt))
	    {
	        $Id = $row['Id'];
	    }
	    mysql_free_result($rslt);
 
    echo "<h2>New Video</h2>
          <form method=POST action='$aksi?module=video&act=input' name=formData onSubmit='return CekField();' enctype='multipart/form-data'>
          <table>
		  <input name='Id' type='hidden' value='$Id'>
		  <tr><td>Link Video</td><td><input type=text name='Video' size='130' onKeyUp='this.value = String(this.value).toLowerCase()'><i></i></td></tr>
		  <tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;
  
  // Form Edit Kategori  
  case "editvideo":
	$sSQL="select * from bb_video WHERE Id='$_GET[Id]' limit 1";
	$rslt=mysql_query($sSQL) or die ("error query");
	$i=0;
	while ($row=mysql_fetch_assoc($rslt))
	{
		$Id = $row['Id'];
		$URL = $row['URL'];
	}
	mysql_free_result($rslt);
    echo "<h2>Video Edit</h2>
	  <form method=POST action='$aksi?module=video&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
          <table>
		  <input name='Id' type='hidden' value='$Id'>
          <tr><td>Title</td><td><input type=text name='URL' size='130' value='$URL'></td></tr>
			";
        echo "<tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
			<input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
		</table></form>";      
    break;  
}
?>