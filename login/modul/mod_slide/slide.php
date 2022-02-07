<script language ="javascript">
function CekField()
{
	if (document.formData.slide_title.value=="")
	{
		alert("Slide Title must be no blank !!!");
		document.formData.slide_title.focus();
		return false;
	}	
	if (document.formData.fupload.value=="")
	{
		alert("Slide Image must be no blank !!!");
		document.formData.fupload.focus();
		return false;
	}
   return true;
}   

function CekUpdate()
{
	if (document.formData.slide_title.value=="")
	{
		alert("Slide Title must be no blank !!!");
		document.formData.slide_title.focus();
		return false;
	}
   return true;
}
</script>

<?php
   $aksi="modul/mod_slide/aksi_slide.php";
  
switch($_GET[act]){
	// Tampil Kategori
	default:  
	echo "<h2>Slide Show</h2>
		<input type=button class='button' value='New Slide' 
		onclick=\"window.location.href='?module=slide&act=tambahslide';\">
		<table>
		<tr><th>ID</th><th>Slide Title</th><th>Status</th><th>Action</th></tr>";
		$p = new Paging;
		$batas  = 10;
		$posisi = $p->cariPosisi($batas);
		$sSQL = "SELECT slide_id , slide_title , IF(slide_StsActive=1,'Enabled','Disabled') AS IsActive FROM tb_slide order by slide_id LIMIT $posisi,$batas";
		$tampil=mysql_query($sSQL);
		$no=1;
		while ($r=mysql_fetch_array($tampil)){
			echo "<tr><td>$r[slide_id]</td>
			<td>$r[slide_title]</td>
			<td>$r[IsActive]</td>
			<td><a href=?module=slide&act=editslide&slide_id=$r[slide_id]><b>Edit</b></a> | 
			<a href=$aksi?module=slide&act=hapus&slide_id=$r[slide_id]><b>Delete</b></a>
			</td></tr>";
			$no++;
		}
		echo "</table>";
		$jmldata = mysql_num_rows(mysql_query("select  * from tb_slide"));
		$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
		$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);

		echo "<div id=paging>Page: $linkHalaman</div><br>";
	break;
	// Form Tambah Kategori
  case "tambahslide":
       $sSQL = "  SELECT (slide_id + 1) AS slide_id FROM tb_slide ORDER BY slide_id DESC LIMIT 1 ";
	   $rslt=mysql_query($sSQL) or die ("error query");
 	   $i=0;
	   while ($row=mysql_fetch_assoc($rslt))
	    {
	        $slide_id = $row['slide_id'];
	    }
	    mysql_free_result($rslt);
 
    echo "<h2>New Slide</h2>
          <form method=POST action='$aksi?module=slide&act=input' name=formData onSubmit='return CekField();' enctype='multipart/form-data'>
          <table>
		  <input name='slide_id' type='hidden' value='$slide_id'>
          <tr><td>Title</td><td><input type=text name='slide_title' size='60' onKeyUp='this.value = String(this.value).toUpperCase()'></td></tr>
          <tr><td>Seq No</td><td><input type=text name='seq' size='10'></td></tr>
		  <tr><td>Link URL</td><td><input type=text name='slide_link' size='100'><i>http://www.domainname.com/url/</i></td></tr>
		  <tr><td>Image</td><td><input type=file name='fupload' size='40'>Minimum Width 1300px , height 406px </td></tr>
		  <tr><td>Status</td><td colspan=2 align=left>
		  <input type=radio name='stsActive' value=1 checked>Enabled  
          <input type=radio name='stsActive' value=0> Disabled</td></tr>
		  <tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;
  
  // Form Edit Kategori  
  case "editslide":
	$sSQL="select * from tb_slide WHERE slide_id='$_GET[slide_id]' limit 1";
	$rslt=mysql_query($sSQL) or die ("error query");
	$i=0;
	while ($row=mysql_fetch_assoc($rslt))
	{
		$slide_id = $row['slide_id'];
		$seq = $row['seq'];
		$slide_title = $row['slide_title'];
		$slide_link = $row['slide_link'];
		$slide_img =  $row['slide_img'];
		$stsActive=$row['slide_stsActive'];
	}
	mysql_free_result($rslt);
	/* Get small image */
	$real_gambar = "../".$slide_img;
		
    echo "<h2>Slide Edit</h2>
	  <form method=POST action='$aksi?module=slide&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
          <table>
		  <input name='slide_id' type='hidden' value='$slide_id'><input name='slide_img' type='hidden' value='$slide_img'>
          <tr><td>Title</td><td><input type=text name='slide_title' size='60' onKeyUp='this.value = String(this.value).toUpperCase()' value='$slide_title'></td></tr>
          <tr><td>Seq No</td><td><input type=text name='seq' size='10' value='$seq'></td></tr>
		  <tr><td>Link URL</td><td><input type=text name='slide_link' size='120'  value='$slide_link'><i>http://www.domainname.com/url/</i></td></tr>
		  <tr><td>Image</td><td><img src='$real_gambar' style='width:300px;'>
		  <a href='$aksi?module=slide&act=hapusgambar&id=$slide_id&namafile=$slide_img'><img src='images/cross.png' class='tombol'></a>1300 x 406 px  
		  </td></tr>
		  <tr><td>New Image</td><td><input type=file name='fupload' size='40'><i>Leave it Blank if you won't change this image</i> (Minimum Width 670px , height 450px)</td></tr>";
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