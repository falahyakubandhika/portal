<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_client/aksi_client.php";
switch($_GET[act]){
  // Tampil client
  
  
	
  
  default:
  
  		$p      = new Paging;

		$batas  = 30;

		$posisi = $p->cariPosisi($batas);
		
		
		if (empty($_GET['kata']))
		{
		  $sSQL1 =  "SELECT * FROM oc_customer  ";
		  $sSQL1 = $sSQL1." ORDER BY firstname, lastname";
		  $sSQL2 =  " SELECT * FROM oc_customer ";
		  $sSQL2= $sSQL2." ORDER BY firstname, lastname  LIMIT $posisi,$batas";
		}
		else
		{
		  $sSQL1 =  "SELECT * FROM oc_customer  where upper(firstname) like '%".strtoupper($_GET['kata'])."%'";
		  $sSQL1 = $sSQL1." ORDER BY firstname, lastname";
		  $sSQL2 =  " SELECT * FROM oc_customer where upper(firstname) like '%".strtoupper($_GET['kata'])."%'";
		  $sSQL2= $sSQL2." ORDER BY firstname, lastname  LIMIT $posisi,$batas";
		}
		
		
	
		$jmldata = mysql_num_rows(mysql_query($sSQL1));
		
		

    echo "<h2>List Customer</h2>";
	
	echo " <form method=get action='$_SERVER[PHP_SELF]'>

          <input type=hidden name=module value=client>

          <div id=paging>Cari Customer : <input type=text name='kata'> <input type=submit value=Cari class='button'></div>

          </form> ";
		  

	
      echo  " <table>
          <tr><th>no</th><th>customer name</th><th>email</th><th>telephone</th><th>email subscription</th><th>aksi</th></tr>";
    $tampil=mysql_query($sSQL2);
    $no = $posisi+1;
    while ($r=mysql_fetch_array($tampil)){
	     $newsletter = $r[newsletter];
		 if ($newsletter==1)
		     $flag = "Y";
		 else 
		     $flag = "N";	 
		 
		 $namo  = $r[firstname]." ".$r[lastname];
		 
      
      echo "<tr><td>$no</td>
                <td>$namo</td>
				<td>$r[email]</td>
				<td>$r[telephone]</td>
				<td>$flag</td>
                <td><a href='?module=client&act=editclient&id=$r[customer_id]'>Edit</a></td></tr>";
				 
	                
		    //echo  "</tr>";
    $no++;
    }
    echo "</table>";
	
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

	$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);



	if($jmldata > $batas){

		echo "<div id=paging>$linkHalaman</div>";

	}

    break;
  

    
  case "editclient":
    $edit = mysql_query("SELECT * FROM oc_customer WHERE customer_id='$_GET[id]'");
    $r    = mysql_fetch_array($edit);
	 $namo  = $r[firstname]." ".$r[lastname];

    echo "<h2>Edit client</h2>
		<form method=POST action='$aksi?module=client&act=update' enctype='multipart/form-data' id='Form'>
          <table>
		   <input type='hidden' name='id' value='$r[customer_id]'>
		   
          <tr><td>customer name</td><td>  : <input type=text name='client_nm' size='80' value='$namo'></td></tr>";
		  echo "<tr><td>email</td><td>  : <input type=text name='email' size='80' value='$r[email]'></td></tr>";
		  echo "<tr><td>telephone</td><td>  : <input type=text name='telephone' size='80' value='$r[telephone]'></td></tr>";
		  
		  
		  
          if ($r['newsletter']==1){
			  echo "<tr><td>email subscription</td> <td> : <input type=radio name='aktif' value='1' checked>Y  
											  <input type=radio name='aktif' value='0'> N</td></tr>";
			}
			else{
			  echo "<tr><td>email subscription</td> <td> : <input type=radio name='aktif' value='1'>Y  
											  <input type=radio name='aktif' value='0' checked>N</td></tr>";
			}     
		  echo"
          <tr><td colspan=2><input type='submit' value='Simpan'>
                            <input type='button' value='Batal' onclick='self.history.back()'></td></tr>
          </table></form>";

    break;  
	
	
}	
}
?>
