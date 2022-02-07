<head>
<script language ="javascript">
function CekField()
{
	if (document.formData.product_name.value=="")
	{
		alert("Product Name must be no blank !!!");
		document.formData.product_name.focus();
		return false;
	}
   return true;
}   

function CekUpdate()
{
	if (document.formData.product_name.value=="")
	{
		alert("Product Name must be no blank !!!");
		document.formData.product_name.focus();
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
	$aksi="modul/mod_product/aksi_product.php";
	switch($_GET[act])
	{
 		 default:
   			 echo "<h2>Data Product</h2>
					<form method=get action='$_SERVER[PHP_SELF]'>
						<input type=hidden name=module value=product>
						<div id=paging><input type=text name='kata' size='70'><input type=submit value=Cari class='button'></div>
					</form>";
			echo "<input type=button class='button' value='New Product' onclick=\"window.location.href='?module=product&act=tambahproduct';\">
					<table>
					<tr><th>No.</th><th>Seq</th><th>Product Name</th><th>Aktif</th><th>Action</th></tr>";
  			$p      = new Paging;
    		$batas  = 100;
    		$posisi = $p->cariPosisi($batas);
	
			if (empty($_GET['kata']))
	  		{
				$sSQL = " select *, IF(fl_active=1,'Yes','No') AS IsActive from tb_product order by seq_number , product_name asc LIMIT $posisi,$batas";
			
				$sSQL2 = " select no_int_product , product_name , IF(fl_active=1,'Yes','No') AS IsActive , image_1, seq_number 
				from  tb_product order by seq_number, product_name asc";
			}
	 		else 
	 		{
				$sSQL = " select no_int_product , product_name , IF(fl_active=1,'Yes','No') AS IsActive , image_1, seq_number 
				from  tb_product 
				where (product_name like '%".trim($_GET['kata'])."%') 
				order by seq_number , product_name asc 
				LIMIT $posisi,$batas";
				
				$sSQL2 = " select no_int_product , product_name , IF(fl_active=1,'Yes','No') AS IsActive , image_1, product_descr , seq_number 
				from  tb_product 
				where (product_name like '%".trim($_GET['kata'])."%') 
				order by seq_number , product_name asc";
			}
			//echo $sSQL;
    		$tampil = mysql_query($sSQL);
    		$no = $posisi+1;
   			while($r=mysql_fetch_array($tampil))
				{
					echo "<tr bgcolor='#FFDD97'>
						<td>$no</td>
						<td>$r[seq_number]</td>
						<td>$r[product_name]</td>
						<td>$r[IsActive]</td>
						<td><a href=?module=product&act=editproduct&id=$r[no_int_product]><b>Edit</b></a> |  
							<a href=$aksi?module=product&act=hapus&id=$r[no_int_product]><b>Delete</a></b></td>
						</tr>";
					$no++;
				}
		echo "</table>";

		$jmldata = mysql_num_rows(mysql_query($sSQL2));
		$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
		$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

		echo "<div id=paging>Page: $linkHalaman</div><br>";
 
    break;
  
  case "tambahproduct":
     
			echo "<h2>New Product</h2>
				<form method=POST action='$aksi?module=product&act=input' enctype='multipart/form-data' name=formData onSubmit='return CekField();'>
				<table>
				<tr><td width=100>Product Name</td><td><input type=text name='product_name' size=80  id='product_name'></td></tr>
				<tr><td width=100>Seq No</td><td><input type=text name='seq_number' size=10  id='seq_number' value='0'></td></tr>
				<tr><td>Product Detail</td><td><textarea id='loko' name='product_descr'  style='width: 710px; height: 350px;'></textarea></td></tr>";
			echo "<tr><td>Main Image</td><td><input type=file name='fupload' size=60 id='fupload'> <b>Related Product / Color Icon Product (680x467 pixel)</b></td></tr>";
			echo "<tr><td>Merk/Brand</td>  <td> : 
				  <select name='brand_id' id='brand_id'>
						<option value=-1 selected>- Pilih Merk -</option>";
							$tampil=mysql_query("select * from tb_brand where fl_active =1  order by brand_name");
							while($r=mysql_fetch_array($tampil))
							{
								echo "<option value=$r[brand_id]>$r[brand_name]</option>";
							}
			echo "</select></td></tr>";				  
			echo "<tr><td>Enabled</td><td colspan=2 align=left>
					<input type=radio name='stsActive' value=1 checked>Yes
					<input type=radio name='stsActive' value=0> No</td></tr> ";						  
			echo "<tr><td colspan=2><input type=submit class='button' value=Save>
					<input type=button class='button' value=Cancel onclick=self.history.back()></td></tr>
		</table></form>";
     break;
	 
 case "editproduct":
		$id = $_GET['id'];
		$id = trim($id);
		$sSQL = " select * from tb_product where no_int_product ='$id' limit 1";

		$rslt=mysql_query($sSQL) or die ("error query");
		$i=0;
		while ($row=mysql_fetch_assoc($rslt))
		{
			$no_int_product = $id;
			$product_descr = $row['product_descr'];
			$product_name = $row['product_name'];
			$brand_id = $row['brand_id'];
			$stsActive = $row['fl_active'];
			$link=  $row['link'];
			$image = $row['image_1'];
			$seq_number = $row['seq_number'];
			$file_name1 = $row['file_name1'];
			$link_video = $row['link_video'];
		}
	   mysql_free_result($rslt);
	   echo "<h2>Edit Product</h2>
        <form method=POST action='$aksi?module=product&act=update' enctype='multipart/form-data' name=formData onSubmit='return CekUpdate();'>
        <table>
		<input type='hidden' name='id' value='$id'/>
        <tr><td width=100>Product Name</td><td><input type=text name='product_name'  value='$product_name' size=80></td></tr>";
		echo "<tr><td width=100>Seq No</td><td><input type=text name='seq_number' size=10  id='seq_number' value='$seq_number'></td></tr>
		<tr><td>Product Detail</td><td> <textarea id='loko' name='product_descr'  style='width: 710px; height: 350px;'>$product_descr</textarea></td></tr>  ";
			echo "<tr><td>Image-1</td><td>";
			if(! empty($image))
				{
					echo "<img src='../$image' style='width:80px;'>
					<a href='$aksi?module=product&act=hapusgambar&id=$no_int_product&namafile=$image'><img src='images/cross.png' class='tombol'></a>";
				}
			echo "<input type=file name='fupload' size=60> 
			<br>Tipe gambar harus JPG/JPEG/PNG dan ukuran lebar maks: 680x467 px</td></tr>";
          echo "<tr><td>Merk/Brand</td>  <td> : 
          <select name='brand_id'>";
		  
		  $tampil=mysql_query("SELECT * FROM tb_brand ORDER BY brand_name");
		  
        while($w=mysql_fetch_array($tampil))
		{
            if ($brand_id==$w[brand_id])
			{
              echo "<option value=$w[brand_id] selected>$w[brand_name]</option>";
            }
            else
			{
              echo "<option value=$w[brand_id]>$w[brand_name]</option>";
            }
        }
		
		echo "</select></td></tr>";
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