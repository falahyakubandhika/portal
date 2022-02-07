<?php
error_reporting(0);
session_start();
include "../../../config/koneksi.php";
include "../../../config/library.php";
include "../../../config/fungsi_thumb.php";
include "../../../config/fungsi_seo.php";
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser']))
{
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 					<center>Untuk mengakses modul, Anda harus login <br>";
 			 echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}

	$cmbstatus=$_POST[cmbstatus];
	$mulai=$_POST[thn_mulai].'-'.$_POST[bln_mulai].'-'.$_POST[tgl_mulai];
	$selesai=$_POST[thn_selesai].'-'.$_POST[bln_selesai].'-'.$_POST[tgl_selesai];
	$chkbox=$_POST[chkbox];
	$chkbox2=$_POST[chkbox2];
	
	if ($chkbox)
	{
	  //all member
	   
	} 
	else 
	{
	  $member1=$_POST[member1];
	   $member2=$_POST[member2];
	 }  
	   
	
	if ($chkbox2)
	{
	   // all product
	   
	} 
	{
		$product1=$_POST[product1];
	    $product2=$_POST[product2];
	}	
	
	
	
	
	switch ($cmbstatus) 
	{
   		 case 0:
       		 $status ="99";
       		 break;
    	 case 1:
       		 $status ="1";   // New order
        	 break;
    	 case 2:
        	$status ="2";   // Paid
        	break;
		
		case 3:
    	    $status ="3";   // Paid validated
        	break;	
    	case 4:
        	$status ="4";   // Delivered
        	break;	
		
		case 8:
        	$status ="8";   // void
        	break;				
	} 
	
	$sSQL = " SELECT distinct o.order_no , o.username ,m.id_member,o.order_dt, o.sentaddress,o.zipcode , o.attention_to , o.phone, o.ongkir ,";
				 	$sSQL = $sSQL."	k.nama_kota , e.expedition_name,";
				    $sSQL = $sSQL." p.payment_name , b.account_no , b.account_name, m.first_name , m.last_name , o.method_id , pr.weight , pr.volume,o.qty,m.email, "; 
					$sSQL = $sSQL. " pr.product_id, o.ongkir_tot ,  m.email, o.total_plus_ongkir ";
					$sSQL = $sSQL. " ,case o.fl_status when 1 THEN 'New' when 2 then 'Paid'when 3 THEN 'Paid Validated' when 4 THEN 'Delivered' WHEN 8 THEN 'Void' END as status_ket , o.fl_status ,pr.product_name , o.price";
				    $sSQL = $sSQL. " from order_temp o ";
				    $sSQL = $sSQL." left join tb_kota k ON o.id_kota = k.id_kota ";
			        $sSQL = $sSQL." left join tb_product pr on o.product_id = pr.product_id ";
				    $sSQL = $sSQL. " left join tb_expedition e ON o.expedition_id = e.expedition_id ";
			        $sSQL = $sSQL. " left join tb_payment p ON o.payment_id = p.payment_id	"; 
				    $sSQL = $sSQL. " left join tb_bank_account b ON o.account_no = b.account_no";
				    $sSQL = $sSQL. " left join tb_member m ON o.username = m.username 	 ";
					
		if ($cmbstatus==0)			
				$sSQL = $sSQL. " where o.fl_status > 0  ";
		else 
		       $sSQL = $sSQL. " where o.fl_status ='".$status."'"; 		
			   
			   
	      

       $mulai = $mulai." 00:00:00 ";
	   $selesai = $selesai." 23:59:59";
	   
	   $sSQL = $sSQL." and o.order_dt between '".$mulai."' and '".$selesai."'";
	   
	   
	   if ($chkbox)               // filter per email / member
	   {
	       // do nothing here all member
	   }
	   else 
	   {
	      $sSQL = $sSQL." and (o.username between '".$member1."' and '".$member2."')";
	   }
	
		if ($chkbox2)
		{
	   		  // do nothing here all product 
		} 
		else
		{
			$sSQL = $sSQL." and (o.product_id between '".$product1."' and '".$product2."')";
		}	
		
	$rslt=mysql_query($sSQL) or die ($sSQL);
			   
    //echo $sSQL;			   
			   
					
	 
	 
	 if(isset($_GET['xls']))
	 {
	             	$mulai1=$_GET[mulai1];
					$selesai1=$_GET[selesai1];
					$cmbstatus1=$_GET[cmbstatus1];
					
					$member1= $_GET[member1];
					$member2= $_GET[member2];
					
					$product1= $_GET[product1];
					$product2= $_GET[product2];
					
					$chkbox= $_GET[chkbox];
					$chkbox2= $_GET[chkbox2];
					
					
					
					
					
					
					$acak           = rand(1,100000);
					$filename ="Report".$acak.".xls";
    			    
					
					switch ($cmbstatus1) 
					{
   						 case 0:
       					   $status1 ="99";
       		 			   break;
    	 				 case 1:
       					   $status1 ="1";   // New order
        	 			   break;
    	 				 case 2:
        					$status1 ="2";   // Paid
        					break;
		
						case 3:
    	    				$status1 ="3";   // Paid validated
        					break;	
    					case 4:
        					$status1 ="4";   // Delivered
        					break;	
		
						case 8:
        					$status1 ="8";   // void
        					break;				
	} 
	
	    
			        $sSQL1 = " SELECT distinct o.order_no ,o.order_dt, o.sentaddress,o.zipcode , o.attention_to , o.phone, o.ongkir ,";
				 	$sSQL1 = $sSQL1."	k.nama_kota  as nama_kota_pengiriman,o.expedition_id,o.id_kota as kota_kirim, e.expedition_name,m.id_member,m.first_name , m.last_name,m.address as member_address,m.dob,m.phone as member_phone,
					m.id_kota as member_city,m.email_subscribe ,";
				    $sSQL1 = $sSQL1."bk.bank_id , bk.bank_name, o.payment_id as payment_code,p.payment_name , b.account_no , b.account_name,  o.method_id , pr.weight , pr.volume,o.qty, "; 
					$sSQL1 = $sSQL1. " pr.product_id, pr.product_name, o.price,o.total, o.ongkir_tot ,   o.total_plus_ongkir ";
					$sSQL1 = $sSQL1. " ,case o.fl_status when 1 THEN 'New' when 2 then 'Paid'when 3 THEN 'Paid Validated' when 4 THEN 'Delivered' WHEN 8 THEN 'Void' END as status_ket , o.fl_status, o.account_no_paid , o.account_nm_paid , o.account_dt_paid ,o.account_amt_paid ";
				    $sSQL1 = $sSQL1. " from order_temp o ";
				    $sSQL1 = $sSQL1." left join tb_kota k ON o.id_kota = k.id_kota ";
			        $sSQL1 = $sSQL1." left join tb_product pr on o.product_id = pr.product_id ";
				    $sSQL1 = $sSQL1. " left join tb_expedition e ON o.expedition_id = e.expedition_id ";
			        $sSQL1 = $sSQL1. " left join tb_payment p ON o.payment_id = p.payment_id	"; 
				    $sSQL1 = $sSQL1. " left join tb_bank_account b ON o.account_no = b.account_no";
					$sSQL1 = $sSQL1. " left join tb_bank bk ON b.bank_id = bk.bank_id";
				    $sSQL1 = $sSQL1. " left join tb_member m ON o.username = m.username 	 ";
					if ($cmbstatus1==0)			
							$sSQL1 = $sSQL1. " where o.fl_status > 0  ";
					else 
		     				$sSQL1 = $sSQL1. " where o.fl_status ='".$status1."'"; 		
							
					$sSQL1 = $sSQL1." and o.order_dt between '".$mulai1."' and '".$selesai1."'";	
					
					
					 if ($chkbox)               // filter per email / member
	  				 {
	      					 // do nothing here all member
	  				 }
	   				 else 
	  				 {
	     				 $sSQL1 = $sSQL1." and (o.username between '".$member1."' and '".$member2."')";
	  				 }
	
					if ($chkbox2)
					{
	   		 			 // do nothing here all product 
					} 
					else
					{
						$sSQL1 = $sSQL1." and (o.product_id between '".$product1."' and '".$product2."')";
					}	
			
			  // echo $sSQL1;
				 	
					
			 	$export = mysql_query($sSQL1); 
				//echo $sSQL1;
				$fields = mysql_num_fields($export); 
				for ($i = 0; $i < $fields; $i++) { 
				   $header .= mysql_field_name($export, $i) . "\t"; 
				} 
				while($row = mysql_fetch_row($export)) 
				{ 
				    $line = ''; 
				    foreach($row as $value) 
					{                                             
			    	    if ((!isset($value)) OR ($value == "")) 
						{ 
				            $value = " \t"; 
			        	}
						else 
						{
				        		$value=stripcslashes($value); 
			            		$value = str_replace('"', '""', $value); 
			            		$value = '"' . $value . '"' . "\t"; 
		        		} 
        				$line .= $value; 
		   		 	} 
		   			 $data .= trim($line)."\n"; 
				} 
				$data = str_replace("\r","",$data); 
				if ($data == "") 
				{ 
			    	$data = "\n(0) Records Found!\n";                         
				} 
			
				
				
				header("Content-type: text/plain");
				 
				header('Content-Disposition: attachment; filename='.$filename);
				header("Pragma: no-cache");
			    header("Expires: 0"); 
				print "$header\n$data";
			}	
	 
	 
	 $total = mysql_num_rows(mysql_query($sSQL));
  	 if ($total>0) 
  	 {
	 
	 		
		
			    echo "<form method=get action=$_SERVER[PHP_SELF] name='formselectxls'>";
				echo "<input type='hidden' name='cmbstatus1' value='".$cmbstatus."'>";
				echo "<input type='hidden' name='mulai1' value='".$mulai."'>";
				echo "<input type='hidden' name='selesai1' value='".$selesai."'>";
				
				
				echo "<input type='hidden' name='chkbox' value='".$chkbox."'>";
				echo "<input type='hidden' name='chkbox2' value='".$chkbox2."'>";
				
				echo "<input type='hidden' name='member1' value='".$member1."'>";
				echo "<input type='hidden' name='member2' value='".$member2."'>";
				
				echo "<input type='hidden' name='product1' value='".$product1."'>";
				echo "<input type='hidden' name='product2' value='".$product2."'>";
				
				
				
				
				
				echo "Export To : <select name='xls' onChange='this.form.submit()'>";
				echo "<option value=0 selected>-- ALL --</option>";
				echo "<option value=1>XLS</option>";
				echo "</select>";
				echo "</form>";
			
			
			        echo 'Order Summary Report';
					echo '<br>';
					echo 'From :'.$_POST[tgl_mulai].'-'.$_POST[bln_mulai].'-'.$_POST[thn_mulai].' to '.$_POST[tgl_selesai].'-'.$_POST[bln_selesai].'-'.$_POST[thn_selesai];
					echo '<br>';
	      			echo '<table style="color:#000000;font-weight:100;border:0px solid #ccc;">
                    		<thead>
					
                    		<tr style="color:#000000;font-weight:100;border:1px solid #ccc;">
                        		<th align=left style="color:#000000;font-weight:100;border:1px solid #ccc;" >
                            		Order No
                        		</th>
								
								
								
                        		<th align=left style="color:#000000;font-weight:100;border:1px solid #ccc;">
                            		Order Date
                        		</th>
								
								<th align=left style="color:#000000;font-weight:100;border:1px solid #ccc;">
                            		Member ID
                        		</th>
								
								<th align=left style="color:#000000;font-weight:100;border:1px solid #ccc;">
                            		Member Name
                        		</th>
								
								<th align=left style="color:#000000;font-weight:100;border:1px solid #ccc;">
                            		Product Name
                        		</th>
								
								<th   align=right style="color:#000000;font-weight:100;border:1px solid #ccc;">
                            		Qty
                        		</th>
								
								<th   align=right style="color:#000000;font-weight:100;border:1px solid #ccc;">
                            		Price
                        		</th>
								
						
								<th align=left style="color:#000000;font-weight:100;border:1px solid #ccc;">
                            		Exp Name
                        		</th>
						
                        		<th align=right style="color:#000000;font-weight:100;border:1px solid #ccc;">
                            		Subtotal
                        		</th>
                        		<th   align=right style="color:#000000;font-weight:100;border:1px solid #ccc;">
                            		Exp Cost
                        		</th>
                       			<th   align=right style="color:#000000;font-weight:100;border:1px solid #ccc;">
                            		Total
                        		</th>
                        		<th align=left style="color:#000000;font-weight:100;border:1px solid #ccc;">
                             		Status 
                        		</th>
							</tr>
                    	</thead>
                    	<tbody>';
		
		            $tot_ongkir=0;
					$gtot = 0;
					$nilai_ongkir = 0;
					$order_no1="";
	 				while ($row=mysql_fetch_assoc($rslt))
					{					
	   		 				$order_no = $row['order_no'];
						 	$order_dt = $row['order_dt'];
							$ongkir_tot = $row['ongkir_tot'];
			 				$total_plus_ongkir = $row['total_plus_ongkir'];
			 				$subtotal = $total_plus_ongkir - $ongkir_tot ;
			 				$exp_name = $row['expedition_name'];
			 				$fl_status = $row['fl_status'];
			 				$status_ket = $row['status_ket'];
							$ongkir = $row['ongkir'];
							$first_name = $row['first_name'];
							$last_name = $row['last_name'];
							$id_member = $row['id_member'];
							
							$nama = $first_name."-".$last_name;
							
							if ($order_no!=$order_no1)
							{
								$tot_ongkir= $tot_ongkir + $ongkir_tot;
								$gtot = $gtot + $total_plus_ongkir;
								$order_no1 = $order_no;
							}
							
							    	
							
							$email = $row['email'];
							$qty = $row['qty'];
							$product_name = $row['product_name'];
							$price= $row['price'];
							//$subtotal =0;
							//$subtotal = ($qty * $price) + 
							
						
							
		
					   
							echo "<tr style='color:#000000;font-weight:100;border:0px solid #ccc;'>";
							echo  "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>".$order_no."</td>";
							echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>".$order_dt."</td>";
							echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>".$id_member."</td>";
							echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>".$nama."</td>";
							echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>".$product_name."</td>";
							echo "<td align='right' style='color:#000000;font-weight:100;border:0px solid #ccc;'>".number_format($qty,0,',','.')."</td>";
							echo "<td align='right' style='color:#000000;font-weight:100;border:0px solid #ccc;'>".number_format($price,0,',','.')."</td>";						
							
							
							echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>".$exp_name."</td>";
							echo "<td align='right' style='color:#000000;font-weight:100;border:0px solid #ccc;'>".number_format($qty*$price,0,',','.')."</td>";
							echo "<td align='right'style='color:#000000;font-weight:100;border:0px solid #ccc;'>".number_format($ongkir_tot,0,',','.')."</td>";
							echo "<td align='right' style='color:#000000;font-weight:100;border:0px solid #ccc;'>".number_format($total_plus_ongkir,0,',','.')."</td>";
							echo "<td align='left'style='color:#000000;font-weight:100;border:0px solid #ccc;'>".$status_ket."</td>";
							echo "</tr>";
					}	//while ($row=mysql_fetch_assoc($rslt))
						   
	  				mysql_free_result($rslt);
	 
	
					echo '</tbody>';
					
					
		 			echo "<tr style='color:#000000;font-weight:100;border:1px solid #ccc;'>";
					echo  "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo  "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo "<td align='right' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."Total Cost :</td>";
					echo "<td align='right' style='color:#000000;font-weight:100;border:0px solid #ccc;'>".number_format($tot_ongkir,0,',','.')."</td>";
			
					echo "</tr>";
					
					echo "<tr style='color:#000000;font-weight:100;border:1px solid #ccc;'>";
					echo  "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo  "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo "<td align='left' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."</td>";
					echo "<td align='right' style='color:#000000;font-weight:100;border:0px solid #ccc;'>"."Grand total :</td>";
					echo "<td align='right' style='color:#000000;font-weight:100;border:0px solid #ccc;'>".number_format($gtot,0,',','.')."</td>";
			
					echo "</tr>";
		 
					echo '</table>';		
		
	}	// if ($total>0) 
	
	
?>	

