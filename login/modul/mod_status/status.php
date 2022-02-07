<html>
<head>
<script language ="javascript">
function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}
</script>

</head>
<body onLoad="JavaScript:timedRefresh(90000);">

<?php    
session_start();

if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){

	  echo "<link href='style.css' rel='stylesheet' type='text/css'>

	 <center>Untuk mengakses modul, Anda harus login <br>";

	  echo "<a href=../../index.php><b>LOGIN</b></a></center>";

}

else
{



	function GetCheckboxes($table, $key, $Label, $Nilai='')
	{

 		 $s = "select * from $table order by nama_tag";

		 $r = mysql_query($s);

  		 $_arrNilai = explode(',', $Nilai);

  		 $str = '';

  		  while ($w = mysql_fetch_array($r)) 
		  {
		    $_ck = (array_search($w[$key], $_arrNilai) === false)? '' : 'checked';
		    $str .= "<input type=checkbox name='".$key."[]' value='$w[$key]' $_ck>$w[$Label] ";
		  }
		  return $str;
}



$aksi="modul/mod_status/aksi_status.php";

switch($_GET[act])
{


  default:

    echo "<h2>List Order Status</h2>

          <form method=get action='$_SERVER[PHP_SELF]'>

          <input type=hidden name=module value=status>

          <div id=paging>Search : <input type=text name='kata' size='60'  onKeyUp='this.value = String(this.value).toUpperCase();'> <input type=submit value=Cari class='button'></div>

          </form>";

       



   
		

		echo "<table class='hovertable'>  

			  <tr><th>#</th><th>Order No</th><th>Tgl Order</th><th>Expired</th><th>Lama</th><th>User Name</th><th>Ongkos Kirim</th><th>Subtotal</th><th>Total</th><th>Status</th><th>Bukti Bayar</th><th>action</th></tr>";



		$p      = new Paging;

		$batas  = 50;

		$posisi = $p->cariPosisi($batas);
		
		$sSQL = "";
		$sSQLt="";

         
		if (empty($_GET['kata']))
		{
	    	
			
			$sSQL = $sSQL." SELECT due_dt,order_id , order_no , order_dt , username , ongkir_tot , sum(total) as total , total_plus_ongkir  ";
			$sSQL = $sSQL. " , case fl_status when 1 THEN 'New / Unpaid' when 2 then 'Paid' when 3 THEN 'Paid Validated' when 4 THEN 'Delivered' WHEN 8 THEN 'Void' END as status_ket, account_validate_paid" ;
			$sSQL = $sSQL."  , DATEDIFF( curdate(), order_dt) as selisih ";
			$sSQL = $sSQL." FROM order_temp ";
			$sSQL = $sSQL."	WHERE fl_status > 0" ;
			$sSQL = $sSQL."	GROUP BY order_no ";
			$sSQL = $sSQL." ORDER BY order_no DESC LIMIT $posisi,$batas ";

			
			
		
			$sSQLt = $sSQLt." SELECT due_dt,order_id , order_no , order_dt , username , ongkir_tot , sum(total) as total ,  total_plus_ongkir ";
				$sSQLt = $sSQLt. " , case fl_status when 1 THEN 'New / Unpaid' when 2 then 'Paid' when 3 THEN 'Paid Validated' when 4 THEN 'Delivered' WHEN 8 THEN 'Void' END as status_ket" ;
				$sSQLt = $sSQLt."  , DATEDIFF( curdate(), order_dt) as selisih, account_validate_paid ";
			$sSQLt = $sSQLt." FROM order_temp ";
			$sSQLt = $sSQLt."	WHERE  fl_status > 0  ";
			$sSQLt = $sSQLt."	GROUP BY order_no ";
			$sSQLt = $sSQLt." ORDER BY order_no DESC  ";
		}
		else
		{
		   	$sSQL = $sSQL." SELECT due_dt,order_id , order_no , order_dt , username , ongkir_tot , sum(total) as total , total_plus_ongkir ";
				$sSQL = $sSQL. " , case fl_status when 1 THEN 'New / Unpaid' when 2 then 'Paid' when 3 THEN 'Paid Validated' when 4 THEN 'Delivered' WHEN 8 THEN 'Void' END as status_ket" ;
				$sSQL = $sSQL."  , DATEDIFF( curdate(), order_dt) as selisih , account_validate_paid";
			$sSQL = $sSQL." FROM order_temp ";
			$sSQL = $sSQL."	WHERE fl_status > 0 ";
			$sSQL = $sSQL. " (order_no like '%".trim($_GET['kata'])."%') or ";
			$sSQL = $sSQL. " (username like '%".trim($_GET['kata'])."%')  ";
			$sSQL = $sSQL."	GROUP BY order_no ";
			$sSQL = $sSQL." ORDER BY order_no DESC LIMIT $posisi,$batas ";
			
			$sSQLt = $sSQLt." SELECT due_dt,order_id , order_no , order_dt , username , ongkir_tot , sum(total) as total ,";
				$sSQLt = $sSQLt. " , case fl_status when 1 THEN 'New / Unpaid' when 2 then 'Paid' when 3 THEN 'Paid Validated' when 4 THEN 'Delivered' WHEN 8 THEN 'Void' END as status_ket" ;
				$sSQLt = $sSQLt."  , DATEDIFF( curdate(), order_dt) as selisih, account_validate_paid ";
			$sSQLt = $sSQLt." FROM order_temp ";
			$sSQLt = $sSQLt."	WHERE fl_status > 0 and  ";
			$sSQLt = $sSQLt. " (order_no like '%".trim($_GET['kata'])."%') or ";
			$sSQLt = $sSQLt. " (username like '%".trim($_GET['kata'])."%')  ";
			$sSQLt = $sSQLt."	GROUP BY order_no ";
			$sSQLt = $sSQLt." ORDER BY order_no DESC ";
			
			
			
	        
		}

		// echo $sSQL;

		  $tampil = mysql_query($sSQL);
		  
		  

								

		$no = $posisi+1;

		while($r=mysql_fetch_array($tampil))
		{

		  $tgl_posting=tgl_indo($r[order_dt]);
$tgl_jatuh=tgl_indo($r[due_dt]);
		  
			  echo "<tr><td>$no</td>

					<td>$r[order_no]</td>

					<td>$tgl_posting</td>
					
					<td>$tgl_jatuh</td>
					
					<td>$r[selisih]</td>

					<td>$r[username]</td>
					
					
					
					<td align='right'>".number_format($r[ongkir_tot],0,',','.')."</td>
					
					<td align='right'>".number_format($r[total],0,',','.')."</td>
					
					<td align='right'>".number_format($r[total_plus_ongkir],0,',','.')."</td>";
					
					 echo "<td>$r[status_ket]</td>";
					
					echo "<td align='left'><a href=../$r[account_validate_paid]>$r[account_validate_paid]</a></td>";
					
					
               
				echo "<td> 
							<a href=?module=status&act=editstatus&id=$r[order_no]><img src='images/edit.png' class='tombol' title='Edit order'></a> 
							
							</td>

					</tr>";

		  $no++;

		}

		echo "</table>";


          
		

		$jmldata = mysql_num_rows(mysql_query($sSQLt));

		

		$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

		$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);



		if($jmldata > $batas)
		{
			echo "<div id=paging>$linkHalaman</div><br>";
		}
		break;    
 
  case "editstatus":
	    echo "<h2> Edit Order  </h2>";
		
		$sSQL = $sSQl. " SELECT o.order_no,o.order_id , o.order_dt , o.session_id , o.product_id , o.qty , o.price,  ";
		$sSQL = $sSQL." o.total, o.username, o.sentaddress,  o.attention_to , o.id_kota , o.phone,o.fullname ";
		$sSQL = $sSQL." , k.nama_kota ,m.email,p.product_name,o.ongkir_tot , o.total_plus_ongkir, o.zipcode , o.account_no_paid , o.account_nm_paid,o.account_dt_paid, ";
		$sSQL = $sSQL."	 o.account_bank_id_paid, o.account_amt_paid, o.account_payment_id_paid , o.account_validate_paid ,";
		$sSQL = $sSQL. " b.bank_name , py.payment_name";
		$sSQL = $sSQL. " ,o.account_no,o.payment_id , o.method_id , o.expedition_id , e.expedition_name , d.method_nm  , ba.account_name";
			$sSQL = $sSQL. " , case o.fl_status when 1 THEN 'New / Unpaid' when 2 then 'Paid' when 3 THEN 'Paid Validated' when 4 THEN 'Delivered' WHEN 8 THEN 'Void' END as status_ket, o.fl_status , c.color_name , s.size_name " ;
        $sSQL = $sSQL."	 FROM order_temp o ";
	 	$sSQL = $sSQL."  LEFT JOIN tb_product p ON o.product_id = p.product_id ";
			$sSQL = $sSQL." left JOIN tb_color c ON c.color_id = p.color_id ";
		$sSQL = $sSQL." left JOIN tb_size s ON s.size_id = p.size_id ";
	 	$sSQL = $sSQL." LEFT JOIN tb_kota  k ON o.id_kota =  k.id_kota ";
     	$sSQL = $sSQL." LEFT JOIN tb_member m ON o.username = m.username ";
	    $sSQL = $sSQL." LEFT JOIN tb_bank b on o.account_bank_id_paid = b.bank_id "; 	
		$sSQL = $sSQL." LEFT JOIN tb_payment py on o.account_payment_id_paid = py.payment_id "; 	
		$sSQL = $sSQL." LEFT JOIN tb_expedition e on o.expedition_id = e.expedition_id  "; 	
		$sSQL = $sSQL." LEFT JOIN tb_delivery_method d on o.method_id = d.method_id  "; 	
		$sSQL = $sSQL." LEFT JOIN tb_bank_account ba on o.account_no = ba.account_no  "; 	
	    $sSQL = $sSQL." where o.order_no='$_GET[id]'";
		
		//echo $sSQL;
		
		
		$edit = mysql_query($sSQL);
        $r    = mysql_fetch_array($edit);
		$status = $r['status_ket'];
		
		$name = $r['fullname']." (".$r['username'].")";
		$telp = "Telp.".$r['phone'];
		$ditujukan = "Up.".$r['attention_to'];
		$order_no = $r['order_no'];
		$fl_status = $r['fl_status'];
		
		
		echo "<a href='?module=status'>Back </a>";
		echo "
			<table style='width:100%;'>
				
				<tr>
					<td colspan='2' align='center'>
					<span style='text-decoration:underline; font-size:18px;'>O R D E R </span><br>
					<span style='font-weight:bold;'>No : $r[order_no] </span><br><br>
					</td>
				</tr>
				
				<td style='border:1px solid #ccc; width:50%; padding-left:15px;' valign='top'><b>Tgl. Order : </b> $r[order_dt]</td>
					<td style='border:1px solid #ccc; width:50%; padding-left:15px;' valign='top'><b>Status Order : </b> $status</td>
				</tr>
				
				<tr>
					<td style='border:1px solid #ccc; width:50%; padding:15px;' valign='top' colspan='2'>
						Customer : <br/>
						<b>$name</b> <br />
						$telp <br /> 
						$r[sentaddress] - $r[zipcode] <br /> 
						<i>$r[nama_kota]</i><br>
						<i>$ditujukan</i>
						
					</td>		
					<tr>
					<td style='border:1px solid #ccc; width:50%; padding:15px;' valign='top' colspan='2'>
						Delivery Method : <br/>
						<b> By ".$r[method_nm]."-".$r[expedition_name]."</b> <br />
						
					</td>		
					
				  </tr> 
				  
					<tr>
					<td style='border:1px solid #ccc; width:50%; padding:15px;' valign='top' colspan='2'>
						Payment Information : <br/>
						<b>Account No :$r[account_no_paid]  <br />
						Account Name : $r[account_nm_paid] <br /> 
						Date Paid : $r[account_dt_paid] <br /> 
						Amount Paid : Rp. ".format_rupiah($r[account_amt_paid])." <br /> 
						Bank Name :  $r[account_bank_id_paid] <br /> 
						Payment Method :  $r[payment_name] <br /> 
						
						
						</b>
						
					</td>		
					
				</tr> 
				
				<tr>
					<td style='border:1px solid #ccc; width:50%; padding:15px;' valign='top' colspan='2'>
						Paid to : <br/>
						<b>Account No :$r[account_no]  <br />
						Account Name : $r[account_name] <br /> 
					
						
						
						</b>
						
					</td>		
					
				</tr> 
				
				
				</table>";
				
				// display detail product 
				
			echo "<table class='hovertable' style='width:100%;'>
			  <tr>
				<th style='width:30px;'>No</th>
				<th>Product</th>
				<th>Color</th>
				<th>Size</th>
				
				<th style='width:75px;'>Qty</th>
				<th style='width:100px;'>Price</th>
				<th style='width:100px;'>Sub Total</th>
			</tr>";
			$no=1;
			 $tot_weight =0;
			 $total = 0;
			 $tot_ship = 0;
			
			 $rslt=mysql_query($sSQL) or die ("error query");
			 while ($row=mysql_fetch_assoc($rslt))
	 		 {
			   $price = $row['price'];
			   $qty = $row['qty'];
			   $product_name = $row['product_name'];
			     $color_name = $row['color_name'];
			   $size_name = $row['size_name'];
			  
			   $order_id = $row['order_id'];
			
			   
			   $subtotal    = ($price * $qty);
			   $subtotal_rp = format_rupiah($subtotal); 
			   
			   $price = format_rupiah($price);   
			
			   
			  
			  
			   
			   $total= $total + $subtotal;
			   
			   
		 
			
			   echo "<tr>
						<td align='right'>$no</td>
						
						<td>$product_name</td>
						<td>$color_name</td>
						<td>$size_name</td>
						
						
						<td align=center>$qty</td>
						<td align=right>$price</td>
						<td align=right>$subtotal_rp</td>
				</tr>";
				
			
			   $no++;
			}
			
			$total_rp = format_rupiah($total);
			$ongkir_tot = format_rupiah($r['ongkir_tot']);
			
			$grandtotal_rp = $r['total_plus_ongkir'];
			$grandtotal_rp = format_rupiah($grandtotal_rp);
			
			
			
			
			
			
	  echo "<tr><td colspan='6' align='right'>Total : </td><td align='right'><b>$total_rp</b></td></tr>
			  <tr><td colspan='6' align='right'>Ongkos kirim : </td><td align='right'><b>$ongkir_tot</b></td></tr>      
			 
			      
			  <tr><td colspan='6' align='right'>Grand Total : </td><td align='right'><b>$grandtotal_rp</b></td></tr>";		
	  		
	   echo "</table>";
				
		mysql_free_result($rslt);
		
		
		
		
		if ($fl_status <> '8')
		{
		echo"
			<form action='$aksi?module=status&act=updatestatus&order_no=$order_no' method='post'>
			<table>
			
				<tr><td colspan='2'><input type='submit' value='Void'><input type=button value=Close onclick=self.history.back()></td></tr>
			</table>
			</form>";
		}
		else
		{
		
		   		echo"
			<form action='$aksi?module=status&act=updatestatus&order_no=$order_no' method='post'>
			<table>
			
				<tr><input type=button value=Close onclick=self.history.back()></td></tr>
			</table>
			</form>";
		}

		
	
		
		
		
		
		
	 
	 
	 
}   // switch 	 
	

}

?>
</body>
</html>
