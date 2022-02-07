<script language ="javascript">
function CekField()
{
	if (document.formData.order_no.value=="")
	{
		alert("Order Number must be no blank !!!");
		document.formData.order_no.focus();
		return false;
		
	}
	
	if (document.formData.expedition.value==-1)
	{
		alert("Expedition must be no blank !!!");
		document.formData.expedition.focus();
		return false;
		
	}
	
	if (document.formData.kota.value==-1)
	{
		alert("City must be no blank !!!");
		document.formData.kota.focus();
		return false;
		
	}

   return true;
}   

function CekUpdate()
{
	if (document.formData.expedition.value==-1)
	{
		alert("Expedition must be no blank !!!");
		document.formData.expedition.focus();
		return false;
		
	}
	
	if (document.formData.city.value=="")
	{
		alert("Account No must be no blank !!!");
		document.formData.city.focus();
		return false;
		
	}
	
   return true;
}   


</script>

<?php
   $aksi="modul/mod_resi_kirim/aksi_resi_kirim.php";
  
switch($_GET[act]){
  // Tampil Kategori
  default:  
  echo "<h2>Resi Pengiriman (Manual) </h2>
          <input type=button class='button' value='New Resi' 
          onclick=\"window.location.href='?module=resi_kirim&act=tambahresi';\">
          <table>
          <tr><th>Order No</th><th>Order Dt</th><th>Customer<th>No Resi</th><th>Tgl Resi</th><th>Expedition</th><th>City</th><th>Action</th></tr>"; 
		  
		   $p = new Paging;
		   $batas  = 10;
		   $posisi = $p->cariPosisi($batas);

				   
		  $sSQL = " SELECT r.order_no , r.order_dt , r.no_resi , r.dt_resi , r.full_name , e.expedition_name, k.nama_kota 
					FROM tb_resi  r
					INNER JOIN tb_expedition e ON r.expedition_id = e.expedition_id 	
					INNER JOIN tb_kota k on r.id_kota = k.id_kota 	   
					order by r.order_no  LIMIT $posisi,$batas";
				   
				   
				   
				   
			//echo $sSQL;	   
		  
  		  $tampil=mysql_query($sSQL);
    	  $no=1;
    while ($r=mysql_fetch_array($tampil)){
	
	   $account_no = substr($r[account_no],0,80);
	   
       echo "<tr><td>$r[order_no]</td>
             <td>$r[order_dt]</td>
			 <td>$r[full_name]</td>
			 <td>$r[no_resi]</td>
			 <td>$r[dt_resi]</td>
			 <td>$r[expedition_name]</td>
			 <td>$r[nama_kota]</td>
			 
			 
             <td><a href=?module=resi_kirim&act=editresi&order_no=$r[order_no]><b>Edit</b></a> | 
	               <a href=$aksi?module=resi_kirim&act=hapus&order_no=$r[order_no]><b>Delete</b></a>
             </td></tr>";
      $no++;
	 } 
   
    echo "</table>";
	$jmldata = mysql_num_rows(mysql_query("select  * from tb_resi"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);
	
    echo "<div id=paging>Page: $linkHalaman</div><br>";
    break;
	// Form Tambah Bank
  case "tambahresi":
       
 
    echo "<h2>New Resi Pengiriman</h2>
          <form method=POST action='$aksi?module=resi_kirim&act=input' enctype='multipart/form-data' name=formData onSubmit='return CekField();'>
          <table>
		  <tr><td>Order No</td><td>:<input name='order_no' type='text' id='order_no' onKeyUp='this.value = String(this.value).toUpperCase();'></td></tr>
          <tr><td>Order Dt</td><td> : <input type=text name='tanggal' size='20' value='$dtnowshortIndo' class='datepicker'></td></tr>
		  <tr><td>Costumer Name</td><td>:<input name='cost_name' type='text' id='cost_name' onKeyUp='this.value = String(this.value).toUpperCase();'></td></tr>
		  <tr><td>Resi Code</td><td>:<input name='resi_no' type='text' value='' size='40'></td></tr>
		  <tr><td>Resi Dt</td><td> : <input type=text name='tanggalresi' size='20' value='$dtnowshortIndo' class='datepicker'></td></tr>
		  ";
			echo  " <tr><td>Expedition</td><td> :";
			
			echo " <select name='expedition' id='expedition_id'>
				   <option value=-1 selected>- Choose Expedition -</option>";
			$tampilw=mysql_query("select * from tb_expedition where fl_active =1  order by expedition_name");
            while($rw=mysql_fetch_array($tampilw))
			{
              echo "<option value=$rw[expedition_id]>$rw[expedition_name]</option>";
            }
			echo "</select></td>";	
			echo "</tr>";
			
			echo  " <tr><td>City</td><td> :";
			
			echo " <select name='kota' id='id_kota'>
				   <option value=-1 selected>- Choose City -</option>";
			$tampilc=mysql_query("select * from tb_kota where aktif ='Y'  order by nama_kota");
            while($rc=mysql_fetch_array($tampilc))
			{
              echo "<option value=$rc[id_kota]>$rc[nama_kota]</option>";
            }
			echo "</select></td>";	
			echo "</tr>";
		  
		echo "<tr><td>Status</td><td colspan=2 align=left>:
		  <input type=radio name='stsActive' value=1 checked>Enabled  
          <input type=radio name='stsActive' value=0> Disabled</td></tr>
		  
		  
          <tr><td colspan=2><input type=submit name=submit value=Save>
                            <input type=button class='button'  value=Cancel onclick=self.history.back()></td></tr>
          </table></form>";
	  
     break;
  
  // Form Edit Resi
  case "editresi":
  
	 $order_no = isset($_GET['order_no'])  ? strval($_GET['order_no']) : false;
	  //echo $account_no;

   $sSQL="select * from tb_resi WHERE order_no='$_GET[order_no]' limit 1";
   
    //echo $sSQL;
	   $rslt=mysql_query($sSQL) or die ("error query");
 	   $i=0;
	   while ($row=mysql_fetch_assoc($rslt))
	   {
	        $order_no = $row['order_no'];
	        $order_dt = $row['order_dt'];
	        $name = $row['full_name'];
	        $expedition_id = $row['expedition_id'];
	        $no_resi = $row['no_resi'];
	        $dt_resi = $row['dt_resi'];
	        $id_kota = $row['id_kota'];
			
			$stsActive=$row['fl_active'];

	   }
	    mysql_free_result($rslt);
		
		
			
    echo "<h2>Edit Resi Manual</h2>
	  <form method=POST action='$aksi?module=resi_kirim&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
          <table>
		  <tr><td>Order No</td><td> : <input name='order_no' type='text' value='$order_no' size='40' readonly='true'></td></tr>
		  <tr><td width=70>Order dt</td> <td> : <input type=text name='tanggal' size='20' value='$order_dt' class='datepicker'></td></tr>
          <tr><td>Costumer Name</td><td> : <input type=text name='cost_name' size='80' onKeyUp='this.value = String(this.value).toUpperCase()' value='$name'></td></tr>
          <tr><td>Resi Code</td><td> : <input type=text name='no_resi' size='80' onKeyUp='this.value = String(this.value).toUpperCase()' value='$no_resi'></td></tr>
		  <tr><td width=70>Resi dt</td> <td> : <input type=text name='tanggalresi' size='20' value='$dt_resi' class='datepicker'></td></tr>
		  ";
		  
		  
	   echo "<tr><td>Expedition</td>  <td> : 
          <select name='expedition'>";
		  
		  $tampil=mysql_query("SELECT * FROM tb_expedition ORDER BY expedition_name");
		  
        while($w=mysql_fetch_array($tampil))
		{
            if ($expedition_id==$w[expedition_id])
			{
              echo "<option value=$w[expedition_id] selected>$w[expedition_name]</option>";
            }
            else
			{
              echo "<option value=$w[expedition_id]>$w[expedition_name]</option>";
            }
        }
		
		echo "</select></td></tr>";	  
		echo "<tr><td>City</td>  <td> : 
          <select name='city'>";
		  
		  $tampil=mysql_query("SELECT * FROM tb_kota ORDER BY nama_kota");
		  
        while($c=mysql_fetch_array($tampil))
		{
            if ($id_kota==$c[id_kota])
			{
              echo "<option value=$c[id_kota] selected>$c[nama_kota]</option>";
            }
            else
			{
              echo "<option value=$c[id_kota]>$c[nama_kota]</option>";
            }
        }
		
		echo "</select></td></tr>";	  
		  
		  
		  
		  
	if ($stsActive=='1') {
			echo "<tr><td>Status</td><td colspan=2 align=left>:<input type=radio name='stsActive' value=1 checked>Enabled 
        		 <input type=radio name='stsActive' value=0> Disabled</td></tr>";
    }
	else
	{
			echo "<tr><td>Status</td><td colspan=2 align=left>:<input type=radio name='stsActive' value=1>Enabled
        		  <input type=radio name='stsActive' value=0 checked> Disabled</td></tr>";
	}		  
		  
		  
		  
        echo  "<tr><td colspan=2><input type=submit name=submit class='button'  value=Save>
                            <input type=button class='button'  value=Cancel onclick=self.history.back()></td></tr>
          </table></form>";
              
    break;  
}
?>