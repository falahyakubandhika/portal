<head>
<script language ="javascript">
function CekField()
{
	if (document.formData.detail_name.value=="")
	{
		alert("Name must be no blank !!!");
		document.formData.detail_name.focus();
		return false;
	}
   return true;
}   

function CekUpdate()
{
	if (document.formData.detail_name.value=="")
	{
		alert("Name must be no blank !!!");
		document.formData.detail_name.focus();
		return false;
	}
   return true;
}
</script>
</head>
<?php
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser']))
{
	echo "<link href='style.css' rel='stylesheet' type='text/css'>
		  <center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else
{
	$aksi="modul/mod_detail/aksi_detail.php";
	switch($_GET[act])
	{
 		 default:
   			 echo "<h2>Detail Data</h2>
					<form method=get action='$_SERVER[PHP_SELF]'>
						<input type=hidden name=module value=detail>
						<div id=paging><input type=text name='kata' size='70'><input type=submit value=Cari class='button'></div>
					</form>";
			echo "<input type=button class='button' value='New' onclick=\"window.location.href='?module=detail&act=tambahdetail';\">
					<table>
					<tr><th>No.</th><th>Seq</th><th>Name</th><th>Aktif</th><th>Action</th></tr>";
  			$p      = new Paging;
    		$batas  = 100;
    		$posisi = $p->cariPosisi($batas);
	
			if (empty($_GET['kata']))
	  		{
				$sSQL = " select *, IF(fl_active=1,'Yes','No') AS IsActive from tb_detail order by seq_number , detail_name asc LIMIT $posisi,$batas";
			
				$sSQL2 = " select no_int_detail , detail_name , IF(fl_active=1,'Yes','No') AS IsActive , image_1, seq_number 
				from  tb_detail order by seq_number, detail_name asc";
			}
	 		else 
	 		{
				$sSQL = " select no_int_detail , detail_name , IF(fl_active=1,'Yes','No') AS IsActive , image_1, seq_number 
				from  tb_detail 
				where (detail_name like '%".trim($_GET['kata'])."%') 
				order by seq_number , detail_name asc 
				LIMIT $posisi,$batas";
				
				$sSQL2 = " select no_int_detail , detail_name , IF(fl_active=1,'Yes','No') AS IsActive , image_1, detail_descr , seq_number 
				from  tb_detail 
				where (detail_name like '%".trim($_GET['kata'])."%') 
				order by seq_number , detail_name asc";
			}
			//echo $sSQL;
    		$tampil = mysql_query($sSQL);
    		$no = $posisi+1;
   			while($r=mysql_fetch_array($tampil))
				{
					echo "<tr bgcolor='#FFDD97'>
						<td>$no</td>
						<td>$r[seq_number]</td>
						<td>$r[detail_name]</td>
						<td>$r[IsActive]</td>
						<td><a href=?module=detail&act=editdetail&id=$r[no_int_detail]><b>Edit</b></a> |  
							<a href=$aksi?module=detail&act=hapus&id=$r[no_int_detail]><b>Delete</a></b></td>
						</tr>";
					$no++;
				}
		echo "</table>";

		$jmldata = mysql_num_rows(mysql_query($sSQL2));
		$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
		$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

		echo "<div id=paging>Page: $linkHalaman</div><br>";
 
    break;
  
  case "tambahdetail":
     
			echo "<h2>New</h2>
				<form method=POST action='$aksi?module=detail&act=input' enctype='multipart/form-data' name=formData onSubmit='return CekField();'>
				<table>
				<tr><td width=100>Name</td><td><input type=text name='detail_name' size=80  id='detail_name'></td></tr>
				<tr><td width=100>Seq No</td><td><input type=text name='seq_number' size=10  id='seq_number' value='0'></td></tr>
				<tr><td>Description</td><td><textarea id='loko' name='detail_descr'  style='width: 710px; height: 350px;'></textarea></td></tr>";
			echo "<tr><td>Main Image</td><td><input type=file name='fupload' size=60 id='fupload'> <b>Related / Color Icon (680x467 pixel)</b></td></tr>";
			echo "<tr><td>PDF/ Brochure</td><td><input type=file name='ffile' size=60></td></tr>";	
			echo "<tr><td>Link Video</td><td><input type=text name='link_video' size=80 class='required' id='link_video'><br>www.youtube.com/embed/zoKj7TdJk98</td></tr>";  
			echo "<tr><td>Enabled</td><td colspan=2 align=left>
					<input type=radio name='stsActive' value=1 checked>Yes
					<input type=radio name='stsActive' value=0> No</td></tr> ";						  
			echo "<tr><td colspan=2><input type=submit class='button' value=Save>
					<input type=button class='button' value=Cancel onclick=self.history.back()></td></tr>
		</table></form>";
     break;
	 
 case "editdetail":
		$id = $_GET['id'];
		$id = trim($id);
		$sSQL = " select * from tb_detail where no_int_detail ='$id' limit 1";

		$rslt=mysql_query($sSQL) or die ("error query");
		$i=0;
		while ($row=mysql_fetch_assoc($rslt))
		{
			$no_int_detail = $id;
			$detail_descr = $row['detail_descr'];
			$detail_name = $row['detail_name'];
			$stsActive = $row['fl_active'];
			$link=  $row['link'];
			$image = $row['image_1'];
			$seq_number = $row['seq_number'];
			$file_name1 = $row['file_name1'];
			$link_video = $row['link_video'];
		}
	   mysql_free_result($rslt);
	   echo "<h2>Edit</h2>
        <form method=POST action='$aksi?module=detail&act=update' enctype='multipart/form-data' name=formData onSubmit='return CekUpdate();'>
        <table>
		<input type='hidden' name='id' value='$id'/>
        <tr><td width=100>Name</td><td><input type=text name='detail_name'  value='$detail_name' size=80></td></tr>";
		echo "<tr><td width=100>Seq No</td><td><input type=text name='seq_number' size=10  id='seq_number' value='$seq_number'></td></tr>
		<tr><td>Description</td><td> <textarea id='loko' name='detail_descr'  style='width: 710px; height: 350px;'>$detail_descr</textarea></td></tr>  ";
			echo "<tr><td>Image-1</td><td>";
			if(! empty($image))
				{
					echo "<img src='../$image' style='width:80px;'>
					<a href='$aksi?module=detail&act=hapusgambar&id=$no_int_detail&namafile=$image'><img src='images/cross.png' class='tombol'></a>";
				}
			echo "<input type=file name='fupload' size=60> 
			<br>Tipe gambar harus JPG/JPEG/PNG dan ukuran lebar maks: 680x467 px</td></tr>";
			echo "<tr><td>Brochure / PDF </td><td>";
			echo $file_name1;		   
			echo "</td></tr>
				<tr><td>New Brochure/PDF</td><td><input type=file name='ffile' size=60> *)</td></tr>
				<tr><td colspan=2>*) Apabila file tidak diubah, dikosongkan saja.</td></tr>";		
			echo "<tr><td width=70>Link Video</td><td><input type=text name='link_video' size=80 value='$link_video' class='required'>
				<br>www.youtube.com/embed/zoKj7TdJk98
				</td></tr>";
			if ($stsActive=='1') 
				{
					echo "<tr><td>Enabled</td><td colspan=2 align=left><input type=radio name='stsActive' value=1 checked>Yes  
					<input type=radio name='stsActive' value=0> No</td></tr>";
				}	
			else
				{
					echo "<tr><td>Enabled</td><td colspan=2 align=left><input type=radio name='stsActive' value=1>Yes
					<input type=radio name='stsActive' value=0 checked> No</td></tr>";
				}										  
		echo "<tr><td colspan=2><input type=submit class='button' value=Save>
			<input type=button class='button' value=Cancel onclick=self.history.back()></td></tr>
			</table></form>";
		break;
	}
}
?>