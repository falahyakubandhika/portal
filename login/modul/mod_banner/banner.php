<script language ="javascript">
function CekField()
{
	if (document.formData.banner_title.value=="")
	{
		alert("Banner Title must be no blank !!!");
		document.formData.banner_title.focus();
		return false;
	}	
	if (document.formData.fupload.value=="")
	{
		alert("Banner Image must be no blank !!!");
		document.formData.fupload.focus();
		return false;
	}
   return true;
}   

function CekUpdate()
{
	if (document.formData.banner_title.value=="")
	{
		alert("Banner Title must be no blank !!!");
		document.formData.banner_title.focus();
		return false;
	}
   return true;
}
</script>

<?php
   $aksi="modul/mod_banner/aksi_banner.php";
  
switch($_GET[act]){
	// Tampil Kategori
	default:  
	echo "<h2>Banner</h2>
		<input type=button class='button' value='New Banner' 
		onclick=\"window.location.href='?module=banner&act=tambahbanner';\">
		<table>
		<tr><th>ID</th><th>Banner Title</th><th>Status</th><th>Action</th></tr>";
		$p = new Paging;
		$batas  = 10;
		$posisi = $p->cariPosisi($batas);
		$sSQL = "SELECT banner_id , banner_title , IF(banner_StsActive=1,'Enabled','Disabled') AS IsActive FROM tb_banner order by banner_id LIMIT $posisi,$batas";
		$tampil=mysql_query($sSQL);
		$no=1;
		while ($r=mysql_fetch_array($tampil)){
			echo "<tr><td>$r[banner_id]</td>
			<td>$r[banner_title]</td>
			<td>$r[IsActive]</td>
			<td><a href=?module=banner&act=editbanner&banner_id=$r[banner_id]><b>Edit</b></a> | 
			<a href=$aksi?module=banner&act=hapus&banner_id=$r[banner_id]><b>Delete</b></a>
			</td></tr>";
			$no++;
		}
		echo "</table>";
		$jmldata = mysql_num_rows(mysql_query("select  * from tb_banner"));
		$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
		$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);

		echo "<div id=paging>Page: $linkHalaman</div><br>";
	break;
	// Form Tambah Kategori
  case "tambahbanner":
       $sSQL = "  SELECT (banner_id + 1) AS banner_id FROM tb_banner ORDER BY banner_id DESC LIMIT 1 ";
	   $rslt=mysql_query($sSQL) or die ("error query");
 	   $i=0;
	   while ($row=mysql_fetch_assoc($rslt))
	    {
	        $banner_id = $row['banner_id'];
	    }
	    mysql_free_result($rslt);
 
    echo "<h2>New Banner</h2>
          <form method=POST action='$aksi?module=banner&act=input' name=formData onSubmit='return CekField();' enctype='multipart/form-data'>
          <table>
		  <input name='banner_id' type='hidden' value='$banner_id'>
          <tr><td>Title</td><td><input type=text name='banner_title' size='60'></td></tr>
          <tr><td>Seq No</td><td><input type=text name='seq' size='10'></td></tr>
		  <tr><td>Image</td><td><input type=file name='fupload' size='40'>Minimum Width 290px , height ...px </td></tr>
		  <tr><td>Link URL</td><td><input type=text name='banner_link' size='100' onKeyUp='this.value = String(this.value).toLowerCase()'><i>http://www.domainname.com/url/</i></td></tr>
		  <tr><td>Status</td><td colspan=2 align=left>
		  <input type=radio name='stsActive' value=1 checked>Enabled  
          <input type=radio name='stsActive' value=0> Disabled</td></tr>
		  <tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;
  
  // Form Edit Kategori  
  case "editbanner":
	$sSQL="select * from tb_banner WHERE banner_id='$_GET[banner_id]' limit 1";
	$rslt=mysql_query($sSQL) or die ("error query");
	$i=0;
	while ($row=mysql_fetch_assoc($rslt))
	{
		$banner_id = $row['banner_id'];
		$seq = $row['seq'];
		$banner_title = $row['banner_title'];
		$banner_link = $row['banner_link'];
		$banner_descr = $row['banner_descr'];
		$banner_img =  $row['banner_img'];
		$stsActive=$row['banner_stsActive'];
	}
	mysql_free_result($rslt);
	/* Get small image */
	$real_gambar = "../".$banner_img;
		
    echo "<h2>Banner Edit</h2>
	  <form method=POST action='$aksi?module=banner&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
          <table>
		  <input name='banner_id' type='hidden' value='$banner_id'><input name='banner_img' type='hidden' value='$banner_img'>
          <tr><td>Title</td><td><input type=text name='banner_title' size='60' value='$banner_title'></td></tr>
          <tr><td>Seq No</td><td><input type=text name='seq' size='10' value='$seq'></td></tr>
		  <tr><td>Image</td><td><img src='$real_gambar' style='width:150px;'><a href='$aksi?module=banner&act=hapusgambar&id=$banner_id&namafile=$banner_img'><img src='images/cross.png' class='tombol'></a>290px x .... px  </td></tr>
		  <tr><td>New Image</td><td><input type=file name='fupload' size='40'><i>Leave it Blank if you won't change this image</i> (Minimum Width 1000px , height 381px)</td></tr>
		  <tr><td>Link URL</td><td><input type=text name='banner_link' size='120' onKeyUp='this.value = String(this.value).toLowerCase()' value='$banner_link'><i>http://www.domainname.com/url/</i></td></tr>";
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