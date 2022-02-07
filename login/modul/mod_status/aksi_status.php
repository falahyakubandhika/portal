<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";
include "../../../include/fungsi.php";

$module=$_GET[module];
$act=$_GET[act];

if ($module=='status' AND $act=='update'){
   // do nothing here
}
elseif ($module=='status' AND $act=='updatestatus'){
	$order_no = $_GET['order_no'];
	
	
	$sSQL = " update order_temp set fl_status =8,id_upd='".$_SESSION['namauser']."',dt_upd=now()";
	$sSQL= $sSQL." where order_no ='".$order_no."'";
	mysql_query($sSQL);
	
	/* Update stock di master product */
	$sSQL = " select product_id, qty from order_temp where order_no='".$order_no."'" ; 
	 $rslt=mysql_query($sSQL) or die ("error query");
	 while ($row=mysql_fetch_assoc($rslt))
	 {
	   $product_id = $row['product_id'];
	   $qty = $row['qty'];
	   $sSQL = "";
	   $sSQL = " update tb_product set qty = qty + ".$qty." where product_id = '".$product_id."'";
	   mysql_query($sSQL);
	 
	 }
	 mysql_free_result($rslt);
	
	
	/* Jgn Lupa Email Void Order */
	$sql2 = mysql_query("select * from company where id='1'");
	  	  $j2   = mysql_fetch_array($sql2);
		   
		   
		   $jmlh=0;
		   $jmlh=calculate_cart_items_detail($order_no);
						 
						 $sSQL = " select total_plus_ongkir , case fl_status when 1 THEN 'New / Unpaid' when 2 then 'Paid' when 3 THEN 'Paid Validated' when 4 THEN 'Delivered' WHEN 8 THEN 'Void' END as status_ket  from order_temp where order_no='".$order_no."' limit 1";
						 $rslt=mysql_query($sSQL) or die ("error query");
						 while ($row=mysql_fetch_assoc($rslt))
						 {
						    $gtot = $row['total_plus_ongkir'];
							$status_ket = $row['status_ket'];
						 }
						mysql_free_result($rslt);
					
					
                    	
		   
		  $pesan = '
					   <html xmlns="http://www.w3.org/1999/xhtml">
					   <head>
					   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />';
		
		  $pesan = $pesan."<title>".$j2['nama_toko']."</title></head>";	
		   
		   
		 $pesan = $pesan."<body><br>";	 
		 $pesan = $pesan."<p><u><strong>".$j2['nama_toko']." ORDER VOID </strong></u></p><br>";	 
		 
		 $pesan = $pesan."<p style='color:#000000; font-weight:100; font-size: 22px;'>".
                       $jmlh." item(s) , Total = "." <strong>Rp.".number_format($gtot,0,',','.')." (".$status_ket.")</strong>
                    	</p>";
			
	
						
		$sSQL = " SELECT o.username ,o.order_dt, o.sentaddress,o.zipcode , o.attention_to , o.phone, o.ongkir ,
				  k.nama_kota , e.expedition_name, o.ongkir_tot,
				  p.payment_name , b.account_no , b.account_name, m.first_name , m.last_name , o.method_id, 
				  o.account_no_paid, o.account_nm_paid,o.account_bank_id_paid,o.account_amt_paid,o.account_payment_id_paid,o.account_validate_paid,o.account_dt_paid,
				  m.email, o.no_resi , o.dt_resi
				  FROM order_temp o
				  INNER JOIN tb_kota k ON o.id_kota = k.id_kota 
									 		  INNER JOIN tb_expedition e ON o.expedition_id = e.expedition_id 
											  INNER JOIN tb_payment p ON o.payment_id = p.payment_id	 
											  INNER JOIN tb_bank_account b ON o.account_no = b.account_no
									 		  INNER JOIN tb_member m ON o.username = m.username 	 
										  	  WHERE o.order_no = '".$order_no."'  limit 1 ";
									 
							 $rslt=mysql_query($sSQL) or die ("error query");
						     while ($row=mysql_fetch_assoc($rslt))
							 {
							        $order_dt1= $row['order_dt'];
									$sentaddress1 = $row['sentaddress'];
									$zipcode1 = $row['zipcode'];
									$attention_to1= $row['attention_to'];
									$phone1 = $row['phone'];
									$ongkir1 = $row['ongkir_tot'];
								
									$nama_kota1 = $row['nama_kota'];
									$expedition_name1 = $row['expedition_name'];
									$payment_name1  = $row['payment_name'];
									$account_no1= $row['account_no'];
									$account_name1 = $row['account_name'];
									$first_name1 = $row['first_name'];
									$last_name1= $row['last_name'];
									$deladdress = $nama_kota1." - ".$zipcode1;
									$method_id1 = $row['method_id'];
									$no_resi1 = $row['no_resi'];
									$dt_resi1 = $row['dt_resi'];
									
									if ($method_id1 =='1')
									    $method_name1 = "By Expedition"; 
									
									else 
									    $method_name1 = "Pick up at our office ";
										
									$account_no_paid = $row['account_no_paid'];
									$account_nm_paid = $row['account_nm_paid'];
									$account_bank_id_paid = $row['account_bank_id_paid'];
									$account_amt_paid =  $row['account_amt_paid'];
									$account_payment_id_paid = $row['account_payment_id_paid'];
									$account_validate_paid = $row['account_validate_paid'];
									$account_dt_paid =	$row['account_dt_paid'];
									$email = $row['email'];
									
							 }		 
							 mysql_free_result($rslt);		
			
			$sSQL = "";				 
			$sSQL = " select bank_name from tb_bank where bank_id ='".$account_bank_id_paid."' limit 1";
		    $rslt=mysql_query($sSQL) or die ($sSQL);				 
			while ($row=mysql_fetch_assoc($rslt))
			{
			   $mybank_name = $row['bank_name'];
			}
			mysql_free_result($rslt);
			
			
			
			$sSQL = "";				 
			$sSQL = " select payment_name from tb_payment where payment_id ='".$account_payment_id_paid."' limit 1";
		    $rslt=mysql_query($sSQL) or die ($sSQL);				 
			while ($row=mysql_fetch_assoc($rslt))
			{
			   $mypayment_name = $row['payment_name'];
			}
			mysql_free_result($rslt);
							 
							 
							 
			$pesan=$pesan.'<table cellspacing="5" cellpadding="5" align="left">
							<tr>
    							<td width="200">Order No</td>
   								 <td width="8">:</td>
								  <td width="8"></td>
    							<td width="600">';
			$pesan = $pesan.$order_no.'</td>
  							</tr>
  							<tr>
    							<td width="200">Order Date</td>
   								 <td width="8">:</td>
								  <td width="8"></td>
    							<td width="600">';
			$pesan = $pesan.$order_dt1.'</td>
  							</tr>
  							<tr>
    						<td>Customer Name</td>
    						<td>:</td>
							<td width="8"></td>
    						<td>'.$first_name1.''.$last_name1.'</td>
  							</tr>
							
							<tr>
							<td>Delivery Address</td>
    						<td>:</td>
							<td width="8"></td>';
			$pesan=$pesan.'<td>'.$sentaddress1.'</td>
  							</tr>
							
							<tr>
							<td></td>
    						<td>:</td>
							<td width="8"></td>
    						<td>'.$deladdress.'</td>
  							</tr>';
							
			$pesan=$pesan.'<tr>
							<td>Phone</td>
    						<td>:</td>
							<td width="8"></td>
    						<td>'.$phone1.'</td>
  							</tr>
							
							<tr>
							<td>Delivery Method</td>
    						<td>:</td>
							<td width="8"></td>';
							
    		$pesan=$pesan.'<td>'.$method_name1.' -'.$expedition_name1.'</td>
  							</tr>
							
							<tr>
							<td>Attention to</td>
    						<td>:</td>
							<td width="8"></td>
    						<td>'.$attention_to1.'</td>
  							</tr>';
							
			$pesan=$pesan.'<tr>
							<td>No Resi Pengiriman</td>
    						<td>:</td>
							<td width="8"></td>
    						<td> '.$no_resi1.' - Tanggal:'.$dt_resi1.'</td>
  							</tr>';				
							
							
			$pesan=$pesan.'<tr>
							<td>Payment Method</td>
    						<td>:</td>
							<td width="8"></td>
    						<td>'.$payment_name1.'</td>
  							</tr>';
							
			$pesan=$pesan.'<tr>
							<td>Paid To</td>
    						<td>:</td>
							<td width="8"></td>';
    		$pesan=$pesan.'<td>'.$account_no1.'-'.$account_name1.'</td>
  							</tr>';
							
							
			$pesan=$pesan.'<tr>
							<td>Expedition Cost (Kg)</td>
    						<td>:</td>
							<td width="8"></td>';
    		$pesan=$pesan.'<td>'.'Rp'.number_format($ongkir1,0,',','.').'</td>
  							</tr>';
							
			$pesan=$pesan.'</table><br>';	
			
			$pesan=$pesan.'<br>';
			
			$pesan=$pesan.'<table cellspacing="5" cellpadding="5" align="left">';
			$pesan=$pesan."<tr><td width='200'><h3>Your Payment Info</h3></td></tr>";
			$pesan=$pesan.'<tr>
    							<td width="200">Your Bank Account No</td>
   								 <td width="8">:</td>
								  <td width="8"></td>
    							<td width="600">';
								
						
								
			$pesan = $pesan.$account_no_paid.'</td>
  							</tr>';
							
			$pesan= $pesan.'<tr>
    							<td width="200">Your Bank Account Name</td>
   								 <td width="8">:</td>
								  <td width="8"></td>
    							<td width="600">';					 		
			$pesan = $pesan.$account_nm_paid.'</td>
  							</tr>';
							
			$pesan= $pesan.'<tr>
    							<td width="200">Your Bank  Name</td>
   								 <td width="8">:</td>
								  <td width="8"></td>
    							<td width="600">';					 		
			$pesan = $pesan.$mybank_name.'</td>
  							</tr>';		
							
			$pesan= $pesan.'<tr>
    							<td width="200">Your Amount Paid</td>
   								 <td width="8">:</td>
								  <td width="8"></td>
    							<td width="600">';					 		
			$pesan = $pesan."Rp.".number_format($account_amt_paid,0,',','.').',-</td>
  							</tr>';								
						
			$pesan= $pesan.'<tr>
    							<td width="200">Your Payment Method</td>
   								 <td width="8">:</td>
								  <td width="8"></td>
    							<td width="600">';					 		
			$pesan = $pesan.$mypayment_name.'</td>
  							</tr>';	
							
			$pesan= $pesan.'<tr>
    							<td width="200">Your Payment Date</td>
   								 <td width="8">:</td>
								  <td width="8"></td>
    							<td width="600">';					 		
			$pesan = $pesan.$account_dt_paid.'</td>
  							</tr>';	
							
			$pesan = $pesan."</table><br>";				
							
							
			$pesan = $pesan.'<table class="shopping-cart-summary" style="color:#000000;font-weight:100">
                    		 <thead>
		                     <tr>
                            	 <th align=left bgcolor="#CCCCCC">
                              		 Product
                        	 	 </th>
                        	 	<th align=left bgcolor="#CCCCCC">
                            		Description
                        	 	</th>
								
								<th align=left bgcolor="#CCCCCC">
                            		Color
                        	 	</th>
								
								<th align=left bgcolor="#CCCCCC">
                            		Size
                        	 	</th>
								
                        	 	<th align=left bgcolor="#CCCCCC">
                            		Unit Price
                        		</th>
                        		<th align=left bgcolor="#CCCCCC">
                           			Quantity
                        		</th>
                        		<th align=left bgcolor="#CCCCCC">
                           			Total
                        		</th>
                     
                    		</tr>
                    		</thead>
                    		<tbody>';
					
							
					 	 		$sSQL = "";
  						 		$sSQL = " SELECT * FROM order_temp WHERE  order_no = '".$order_no."'  limit 1";
 						 		$totaltrans  = mysql_num_rows(mysql_query($sSQL));
						 
  						 		if ($totaltrans>0) 
  						 		{
						          $sSQL = " SELECT o.order_id , o.order_dt , o.session_id , o.product_id , sum(o.qty) as qty , o.price , o.qty * o.price AS total , ";
				  				  $sSQL = $sSQL." p.product_name , p.image_1,p.qty as jml, c.color_name , s.size_name " ;
				  				  $sSQL = $sSQL." FROM order_temp o ";
				   				  $sSQL = $sSQL." INNER JOIN tb_product p ON o.product_id = p.product_id ";
								  $sSQL = $sSQL." INNER JOIN tb_color c ON c.color_id = p.color_id ";
								  $sSQL = $sSQL." INNER JOIN tb_size s ON s.size_id = p.size_id ";
								  $sSQL = $sSQL." WHERE o.order_no = '".$order_no."'";
								  $sSQL = $sSQL." GROUP BY o.product_id  ";
						       	  $rslt=mysql_query($sSQL) or die ("error query");
								  $gtot=0;
								  $totq=0;
								  $i=0;
								  $jml=0;
								  //echo $sSQL;
								  while ($row=mysql_fetch_assoc($rslt))
								  {
						                  $i=$i+1;
										  $order_id = $row['order_id'];
					  					  $order_dt = $row['order_dt'];
					  					  $product_id = $row['product_id'];
										  $qty = $row['qty'];
										  $price = $row['price'];
					 					  $total = $row['total'];
					  					  $product_name = $row['product_name'];
					  					  $image = $row['image_1'];
										  $real_image = str_replace("images/product/","",$image);
			   					  		  $real_image = trim($real_image);
			   					 		  $image_small = "images/product/small_".$real_image;
					  					  $gtot = $gtot + $total; 
										  $totq= $totq+$qty;
										  $jml = $row['jml'];
										  $pesan = $pesan."<tr>";
										  $pesan = $pesan."<td>".$product_id."</td>";
										  
										  $pesan = $pesan."<td>".$product_name."</td>";
										  
										  $pesan = $pesan."<td align='left'>".$color_name."</td>";
										  $pesan = $pesan."<td align='left'>".$size_name."</td>";
										  
										  $pesan = $pesan."<td>"."Rp.".number_format($price,0,',','.')."</td>";
										  
										
				
										 
										 $pesan = $pesan."<td>".$qty."</td>";
										  
										$pesan = $pesan."<td>"."Rp.".number_format($total,0,',','.')."</td>";
										
									
										$pesan = $pesan."</tr>";
										  
                        
								 		}
								  		mysql_free_result($rslt);
						 		}
								
								 		  
					
				
                  		$pesan = $pesan."</tbody>
                   		 </table>";
						 
						 $pesan= $pesan."<p> Your order has been void due to some reasons , please contact our staff for more details..</p>";
		
						$pesan= $pesan."<br><p><u><strong>".$j2['nama_toko']."</u></strong></p>";
						
														  				
		  
						 $$pesan=$pesan."</body>";		
						 $pesan=$pesan."</html>";	
						 
				//echo $pesan;		 
		
		
		
		
		/* Email ke member dari salesorder@xxxx.com */				
			$to = $email;
			$subject = "Order Void ".$j2['nama_toko'];
			$headers = "From: " . strip_tags($j2['email_pengelola']) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($j2['email_pengelola']) . "\r\n";
			
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
			mail($to, $subject, $pesan, $headers);
			
		/* End of Email ke member dari finance@xxxx.com */		
		
		/* Email notifikasi ke salesorder@xxx.com */
		
		$to = strip_tags($j2['email_pengelola']);
		$subject = "Order Void ".$j2['nama_toko'];
		$headers = "From: " . strip_tags($j2['email4']) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($email) . "\r\n";
		$headers .= "Cc: ". strip_tags($j2['email2']) . "\r\n";
			
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		mail($to, $subject, $pesan, $headers);
		
		/* End of Email notifikasi ke finance@xxx.com */	
		
	
	
	
	
	// Update status order
	
	
	echo "<script>
						
						window.location=('../../media.php?module=status')
	</script>";
	
}


}
?>
