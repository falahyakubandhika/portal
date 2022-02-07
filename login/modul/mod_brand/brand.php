<script language ="javascript">
function CekField()
{
	if (document.formData.brand_title.value=="")
	{
		alert("Brand Name must be no blank !!!");
		document.formData.brand_title.focus();
		return false;
	}
	

   return true;
}   

function CekUpdate()
{
	if (document.formData.brand_title.value=="")
	{
		alert("Brand Name must be no blank !!!");
		document.formData.brand_title.focus();
		return false;
	}
	
   return true;
}   


</script>

<?php
   $aksi="modul/mod_brand/aksi_brand.php";
  
switch($_GET[act]){
  // Tampil Kategori
  default:  
  echo "<h2>Product Brand </h2>
          <input type=button class='button' value='New Brand' 
          onclick=\"window.location.href='?module=brand&act=tambahbrand';\">
          <table>
          <tr><th>ID</th><th>Brand Name</th><th>Status</th><th>Action</th></tr>"; 
		  
		   $p = new Paging;
		   $batas  = 30;
		   $posisi = $p->cariPosisi($batas);

		  $sSQL = "SELECT brand_id , brand_name , IF(fl_active=1,'Enabled','Disabled') AS IsActive FROM tb_brand order by brand_id LIMIT $posisi,$batas";
		  
  		  $tampil=mysql_query($sSQL);
    	  $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$r[brand_id]</td>
             <td>$r[brand_name]</td>
			 <td>$r[IsActive]</td>
			 
             <td><a href=?module=brand&act=editbrand&brand_id=$r[brand_id]><b>Edit</b></a> | 
	               <a href=$aksi?module=brand&act=hapus&brand_id=$r[brand_id]><b>Delete</b></a>
             </td></tr>";
      $no++;
	 } 
   
    echo "</table>";
	$jmldata = mysql_num_rows(mysql_query("select  * from tb_brand"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
	
    echo "<div id=paging>Page: $linkHalaman</div><br>";
    break;
	// Form Tambah brand
  case "tambahbrand":
   
 
    echo "<h2>New Product Brand</h2>
          <form method=POST action='$aksi?module=brand&act=input' name=formData onSubmit='return CekField();' enctype='multipart/form-data'>
          <table>
	       <tr><td>Brand Name</td><td> : <input type=text name='brand_title' size='30'></td></tr>
		   <tr><td>Description</td><td><textarea name='brand_desc' style='width: 750px; height: 550px;' id='loko'></textarea></td></tr>
		  
		  <tr><td>Status</td><td colspan=2 align=left>:
		  <input type=radio name='stsActive' value=1 checked>Enabled 
          <input type=radio name='stsActive' value=0> Disabled</td></tr>
		  
		  
          <tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
	  
     break;
  
  // Form Edit brand
  case "editbrand":

   $sSQL="select * from tb_brand WHERE brand_id='$_GET[brand_id]' limit 1";
	   $rslt=mysql_query($sSQL) or die ("error query");
 	   $i=0;
	   while ($row=mysql_fetch_assoc($rslt))
	   {
	        $brand_id = $row['brand_id'];
			$brand_title = $row['brand_name'];
			$brand_desc = $row['brand_desc'];
			
			$stsActive=$row['fl_active'];

	   }
	    mysql_free_result($rslt);
		
		
			
    echo "<h2>brand Edit</h2>
	  <form method=POST action='$aksi?module=brand&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
          <table>
		  <tr><td>Id</td><td>:$brand_id</td><input name='brand_id' type='hidden' value='$brand_id'>
		  </tr>
          <tr><td>Title</td><td> : <input type=text name='brand_title' size='30' value='$brand_title'></td></tr>
		  <tr><td>Description</td><td><textarea name='brand_desc' style='width: 750px; height: 550px;' id='loko'>$brand_desc</textarea></td></tr>
		  ";
		  
	if ($stsActive=='1') {
			echo "<tr><td>Status</td><td colspan=2 align=left>:<input type=radio name='stsActive' value=1 checked>Enabled 
        		 <input type=radio name='stsActive' value=0> Disabled</td></tr>";
    }
	else
	{
			echo "<tr><td>Status</td><td colspan=2 align=left>:<input type=radio name='stsActive' value=1>Enabled
        		  <input type=radio name='stsActive' value=0 checked> Disabled</td></tr>";
	}		  
		  
		  
		  
        echo  "<tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
	  
              
    break;  
}
?>