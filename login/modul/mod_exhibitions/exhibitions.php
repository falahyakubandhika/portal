<script language ="javascript">
function CekField()
{
	if (document.formData.exhibitions_title.value=="")
	{
		alert("Title must be no blank !!!");
		document.formData.exhibitions_title.focus();
		return false;
	}
	

	if (document.formData.fupload.value=="")
	{
		alert("Image must be no blank !!!");
		document.formData.fupload.focus();
		return false;
	}
	
	if (document.formData.page.value=="")
	{
		alert("Page must be no blank !!!");
		document.formData.page.focus();
		return false;
	}
	
	
	if (document.formData.pos.value=="")
	{
		alert("Please Choose Position !!!");
		document.formData.pos.focus();
		return false;
	}
	
   return true;
}   

function CekUpdate()
{
	if (document.formData.exhibitions_title.value=="")
	{
		alert("Title must be no blank !!!");
		document.formData.exhibitions_title.focus();
		return false;
	}
	
   return true;
}   


</script>

<?php
   $aksi="modul/mod_exhibitions/aksi_exhibitions.php";
  
switch($_GET[act]){
  // Tampil Kategori
  default:  
  echo "<h2>Exhibitions </h2>
          <input type=button class='button' value='New Exhibitions' 
          onclick=\"window.location.href='?module=exhibitions&act=tambahexhibitions'\">
          <table>
          <tr><th>ID</th><th>Seq</th><th>Title</th><th>Status</th><th>Action</th></tr>"; 
		  
		   $p = new Paging;
		   $batas  = 10;
		   $posisi = $p->cariPosisi($batas);

		  $sSQL = "SELECT exhibitions_id , exhibitions_name , seq , IF(fl_active=1,'Enabled','Disabled') AS IsActive 
		           FROM tb_exhibitions order by exhibitions_id LIMIT $posisi,$batas";
		  
  		  $tampil=mysql_query($sSQL);
    	  $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$r[exhibitions_id]</td>
             <td>$r[seq]</td>
             <td>$r[exhibitions_name]</td>
			 <td>$r[IsActive]</td>
             <td><a href=?module=exhibitions&act=editexhibitions&exhibitions_id=$r[exhibitions_id]><b>Edit</b></a> | 
	               <a href=$aksi?module=exhibitions&act=hapus&exhibitions_id=$r[exhibitions_id]><b>Delete</b></a>
             </td></tr>";
      $no++;
	 } 
   
    echo "</table>";
	$jmldata = mysql_num_rows(mysql_query("select  * from tb_exhibitions"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);
	
    echo "<div id=paging>Page: $linkHalaman</div><br>";
    break;
	// Form Tambah Kategori
  case "tambahexhibitions":
       $sSQL = "  SELECT (exhibitions_id + 1) AS exhibitions_id FROM tb_exhibitions ORDER BY exhibitions_id DESC LIMIT 1 ";
	   $rslt=mysql_query($sSQL) or die ("error query");
 	   $i=0;
	   while ($row=mysql_fetch_assoc($rslt))
	   {
	        $exhibitions_id = $row['exhibitions_id'];
	   }
	    mysql_free_result($rslt);
 
    echo "<h2>New Exhibitions</h2>
          <form method=POST action='$aksi?module=exhibitions&act=input' name=formData onSubmit='return CekField();' enctype='multipart/form-data'>
          <table>
		  <input name='exhibitions_id' type='hidden' value='$exhibitions_id'>
          <tr><td>Title</td><td><input type=text name='exhibitions_title' size='60'></td></tr>
          <tr><td>Seq</td><td><input type=text name='seq' size='60'></td></tr>
		  <tr><td>Image</td><td><input type=file name='fupload' size='60'>Minimum : 460px width  , 210px Height</td> </tr>
		  <tr><td>Status</td><td colspan=2 align=left>
		  <input type=radio name='stsActive' value=1 checked>Enabled  
          		<input type=radio name='stsActive' value=0> Disabled</td></tr>
          <tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
	  
     break;
  
  // Form Edit Kategori  
  case "editexhibitions":

   $sSQL="select * from tb_exhibitions WHERE exhibitions_id='$_GET[exhibitions_id]' limit 1";
	   $rslt=mysql_query($sSQL) or die ("error query");
 	   $i=0;
	   while ($row=mysql_fetch_assoc($rslt))
	   {
	        $exhibitions_id = $row['exhibitions_id'];
			$exhibitions_title = $row['exhibitions_name'];
			$exhibitions_img =  $row['exhibitions_image'];
			$stsActive=$row['fl_active'];
			$seq=$row['seq'];
	   }
	    mysql_free_result($rslt);
			
    echo "<h2>Exhibitions Edit</h2>
	  <form method=POST action='$aksi?module=exhibitions&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
          <table>
		  <input name='exhibitions_id' type='hidden' value='$exhibitions_id'><input name='exhibitions_img' type='hidden' value='$exhibitions_img'>
          <tr><td>Title</td><td><input type=text name='exhibitions_title' size='60' value='$exhibitions_title'></td></tr>
          <tr><td>Seq</td><td><input type=text name='seq' size='10' value='$seq'></td></tr>
		  <tr><td>Image</td><td><img src='../".$exhibitions_img."' style='width:200px;'><a href='$aksi?module=exhibitions&act=hapusgambar&id=$exhibitions_id&namafile=$exhibitions_img'><img src='images/cross.png' class='tombol'></a></td></tr>
		  <tr><td>New Image</td><td><input type=file name='fupload' size='40'><i>Leave it Blank if you won't change this image</i> (Minimum : 460px width  , 210px Height)</td></tr> ";		  
			if ($stsActive=='1') {
			echo "<tr><td>Status</td><td colspan=2 align=left><input type=radio name='stsActive' value=1 checked>Enabled  
			<input type=radio name='stsActive' value=0> Disabled</td></tr>";
			}
			else
			{
			echo "<tr><td>Status</td><td colspan=2 align=left><input type=radio name='stsActive' value=1>Enabled
			<input type=radio name='stsActive' value=0 checked> Disabled</td></tr>";
			}		  
		echo  "<tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
			<input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
		</table></form>";      
    break;  
}
?>