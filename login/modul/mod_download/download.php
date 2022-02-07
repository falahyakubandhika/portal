<script language ="javascript">
function CekField()
{
	if (document.formData.download_title.value=="")
	{
		alert(" Title must be no blank !!!");
		document.formData.download_title.focus();
		return false;
	}	
	if (document.formData.fupload.value=="")
	{
		alert("File must be no blank !!!");
		document.formData.fupload.focus();
		return false;
	}
   return true;
}   

function CekUpdate()
{
	if (document.formData.download_title.value=="")
	{
		alert(" Title must be no blank !!!");
		document.formData.download_title.focus();
		return false;
	}
   return true;
}
</script>

<?php
   $aksi="modul/mod_download/aksi_download.php";
  
switch($_GET[act]){
	// Tampil Kategori
	default:  
	echo "<h2>download</h2>
		<input type=button class='button' value='New File' 
		onclick=\"window.location.href='?module=download&act=tambahdownload';\">
		<table>
		<tr><th>ID</th><th>Title</th><th>Status</th><th>Action</th></tr>";
		$p = new Paging;
		$batas  = 10;
		$posisi = $p->cariPosisi($batas);
		$sSQL = "SELECT download_id , download_title , IF(download_stsActive=1,'Enabled','Disabled') AS IsActive FROM tb_download order by download_id LIMIT $posisi,$batas";
		$tampil=mysql_query($sSQL);
		$no=1;
		while ($r=mysql_fetch_array($tampil)){
			echo "<tr><td>$r[download_id]</td>
			<td>$r[download_title]</td>
			<td>$r[IsActive]</td>
			<td><a href=?module=download&act=editdownload&download_id=$r[download_id]><b>Edit</b></a> | 
			<a href=$aksi?module=download&act=hapus&download_id=$r[download_id]><b>Delete</b></a>
			</td></tr>";
			$no++;
		}
		echo "</table>";
		$jmldata = mysql_num_rows(mysql_query("select  * from tb_download"));
		$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
		$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);

		echo "<div id=paging>Page: $linkHalaman</div><br>";
	break;
	// Form Tambah Kategori
  case "tambahdownload":
       $sSQL = "  SELECT (download_id + 1) AS download_id FROM tb_download ORDER BY download_id DESC LIMIT 1 ";
	   $rslt=mysql_query($sSQL) or die ("error query");
 	   $i=0;
	   while ($row=mysql_fetch_assoc($rslt))
	    {
	        $download_id = $row['download_id'];
	    }
	    mysql_free_result($rslt);
 
    echo "<h2>New File</h2>
          <form method=POST action='$aksi?module=download&act=input' name=formData onSubmit='return CekField();' enctype='multipart/form-data'>
          <table>
		  <input name='download_id' type='hidden' value='$download_id'>
          <tr><td>Title</td><td><input type=text name='download_title' size='60'></td></tr>
          <tr><td>Seq No</td><td><input type=text name='seq' size='10'></td></tr>
		  <tr><td>File PDF</td><td><input type=file accept='.pdf' name='fupload' size='40'></td></tr>
		  <tr><td>Status</td><td colspan=2 align=left>
		  <input type=radio name='stsActive' value=1 checked>Enabled  
          <input type=radio name='stsActive' value=0> Disabled</td></tr>
		  <tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;
  
  // Form Edit Kategori  
  case "editdownload":
	$sSQL="select * from tb_download WHERE download_id='$_GET[download_id]' limit 1";
	$rslt=mysql_query($sSQL) or die ("error query");
	$i=0;
	while ($row=mysql_fetch_assoc($rslt))
	{
		$download_id = $row['download_id'];
		$seq = $row['seq'];
		$download_title = $row['download_title'];
		$download_descr = $row['download_descr'];
		$download_img =  $row['download_img'];
		$stsActive=$row['download_stsActive'];
	}
	mysql_free_result($rslt);
	/* Get small image */
	$real_gambar = "../".$download_img;
		
    echo "<h2>Edit</h2>
	  <form method=POST action='$aksi?module=download&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
          <table>
		  <input name='download_id' type='hidden' value='$download_id'><input name='download_img' type='hidden' value='$download_img'>
          <tr><td>Title</td><td><input type=text name='download_title' size='60' value='$download_title'></td></tr>
          <tr><td>Seq No</td><td><input type=text name='seq' size='10' value='$seq'></td></tr>
		  <tr><td>File PDF</td><td>".$download_img."<a href='$aksi?module=download&act=hapusgambar&id=$download_id&namafile=$download_img'><img src='images/cross.png' class='tombol'></a></td></tr>
		  <tr><td>New File PDF</td><td><input type=file accept='.pdf' name='fupload' size='40'><i>Leave it Blank if you won't change this file</i> </td></tr>";
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