<?php
session_start();
 if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
?>
<body>
<?php 
   echo "<h2>Order Report</h2>
          

          <form method=POST action='modul/mod_laporan/print_report.php' target='_blank'>
          <table>
          <tr><td colspan=2><b>Order Report Per Period</b></td></tr>
          <tr><td>Start Date</td><td> : ";        
          combotgl(1,31,'tgl_mulai',$tgl_skrg);
          combonamabln(1,12,'bln_mulai',$bln_sekarang);
          combothn(2000,$thn_sekarang,'thn_mulai',$thn_sekarang);

    echo "</td></tr>
          <tr><td>End Date</td><td> : ";
          combotgl(1,31,'tgl_selesai',$tgl_skrg);
          combonamabln(1,12,'bln_selesai',$bln_sekarang);
          combothn(2000,$thn_sekarang,'thn_selesai',$thn_sekarang);
  	
	/*	  
		  echo '<tr>';	  
		  echo '<td> Report Type :</td><td> :
  				<select id="cmbreport" name="cmbreport">
   					<option value="0">Summary</option>
			    	<option value="1">Detail</option>
				  </select></td>';
  		  echo '</tr>';
 	*/ 
  
  echo '<tr>';	  
	echo '<td> Order Status  :</td><td> :
  <select id="cmbstatus" name="cmbstatus" >
     <option value="0">All Status</option>
     <option value="1">New Order</option>
	 <option value="2">Paid</option>
	 <option value="3">Paid Validated</option>
	 <option value="4">Delivered</option>
	 <option value="8">Void</option>
	 
	 
	 
	 
  </select></td>	 ';
  echo '</tr>';
  
  echo '<tr>';	  
  echo '<td>  Customer</td>';
  ?>
  
 <!-- <td><input type="checkbox" id="chkbox" onchange="document.getElementById('txtBox').disabled=!this.checked;document.getElementById('txtBox2').disabled=!this.checked;" checked="checked" />All
  -->
  <!--<input type='text' id='txtBox' name='txtBox'/>
  		 <input type='text' id='txtBox2' name='txtBox'/></td>-->
		 
	<td><input type="checkbox" id="chkbox" name="chkbox" onChange="document.getElementById('member1').disabled=this.checked;document.getElementById('member2').disabled=this.checked;"  />All 
				  <select name='member1' id='member1' name='member1'>
						    <?
							$tampil=mysql_query("select * from tb_member   order by username");
							while($r=mysql_fetch_array($tampil))
							{
							   $name = $r['first_name']." ".$r['last_name'];
								echo "<option value=$r[email]>$name</option>";
							}
							?>
			</select> &nbsp;&nbsp;to 
			
			
				  <select name='member2' id='member2' name='member2'>
						    <?
							$tampil=mysql_query("select * from tb_member   order by username");
							while($r=mysql_fetch_array($tampil))
							{
							   $name = $r['first_name']." ".$r['last_name'];
								echo "<option value=$r[email]>$name</option>";
							}
							?>
			</select>
  
  
<?
    echo "</td></tr>";
	
	
 echo '<tr>';	  
  echo '<td> Product</td>';
  ?>

		 
	<td><input type="checkbox" id="chkbox2" name="chkbox2" onChange="document.getElementById('product1').disabled=this.checked;document.getElementById('product2').disabled=this.checked;"  />All 
				  <select name='product1' id='product1' name='product1'>
						    <?
							$tampil=mysql_query("select * from tb_product   order by product_name");
							while($r=mysql_fetch_array($tampil))
							{
							   $name = $r['product_name'];
								echo "<option value=$r[product_id]>$name</option>";
							}
							?>
			</select> &nbsp;&nbsp;to 
			
			
				  <select name='product2' id='product2' name='product2'>
						    <?
							$tampil=mysql_query("select * from tb_product   order by product_name");
							while($r=mysql_fetch_array($tampil))
							{
							   $name = $r['product_name'];
								echo "<option value=$r[product_id]>$name</option>";
							}
							?>
			</select>
  
  
<?
    echo "</td></tr>";	
	
	
	
    echo " <tr><td colspan=2><input type=submit value=Submit></td></tr>
          </table>
          </form>";
}
?>
</body>
