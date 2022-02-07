<?php    
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



$aksi="modul/mod_message/aksi_message.php";

switch($_GET[act])
{


  default:

    echo "<h2>Incoming message</h2>

          <form method=get action='$_SERVER[PHP_SELF]'>

          <input type=hidden name=module value=message>

          <div id=paging>Search message : <input type=text name='kata' size='60'  onKeyUp='this.value = String(this.value).toUpperCase();'> <input type=submit value=Cari class='button'></div>

          </form>";

         



   
		

		echo "<table class='hovertable'>  

			  <tr><th>no</th><th>subject</th><th>sender</th><th>phone</th><th>email </th><th>date received </th><th>date replied </th><th>action</th></tr>";



		$p      = new Paging;

		$batas  = 50;

		$posisi = $p->cariPosisi($batas);

         
		if (empty($_GET['kata']))
		{
		
		    $sSQL = "SELECT message_id , subject , sender , dt_receive, phone , email ,content, reply_date
					FROM tb_message
					ORDER BY dt_receive DESC  LIMIT $posisi,$batas ";

		
		
		    
   			$sSQLt = "SELECT message_id , subject , sender , dt_receive, phone , email , content ,  reply_date
					FROM tb_message
					ORDER BY dt_receive DESC   ";
		}
		else
		{
		
		    $sSQL = "SELECT message_id , subject , sender , dt_receive, phone , email , content ,   reply_date
					FROM tb_message
					where  subject  like '%".trim($_GET['kata'])."%'";
					
			$sSQL = 	$sSQL." ORDER BY dt_receive DESC  LIMIT $posisi,$batas ";
			
			$sSQLt = "SELECT message_id , subject , sender , dt_receive, phone , email , content ,    reply_date
					FROM tb_message
					where  subject like '%".trim($_GET['kata'])."%'";
					
			$sSQLt = 	$sSQLt." ORDER BY dt_receive DESC  LIMIT $posisi,$batas ";
		
					
	    }

		 

		  $tampil = mysql_query($sSQL);

								

		$no = $posisi+1;

		while($r=mysql_fetch_array($tampil))
		{

		  $tgl_posting=tgl_indo($r['dt_receive']);

		  


			  echo "<tr><td>$no</td>

					<td>$r[subject]</td>

					<td>$r[sender]</td>
					
					<td>$r[phone]</td>
					<td>$r[email]</td>
					

					<td>$tgl_posting</td>
					
					<td>$r[reply_date]</td>

					
					<td style='width:100px;'> 
							<a href=?module=message&act=viewmessage&id=$r[message_id]><img src='images/edit.png' class='tombol' title='View message'></a> 
							
						
							
							
							
							</td>

					</tr>";

		  $no++;

		}

		echo "</table>";


          
		

		$jmldata = mysql_num_rows(mysql_query($sSQLt));

		

		$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

		$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);



		if($jmldata > $batas)
		{
			echo "<div id=paging>$linkHalaman</div><br>";
		}
		break;    
 
 
	 case "viewmessage":
	    echo "<h2> View / Reply Message </h2>";
		
		 $edit = mysql_query("SELECT * FROM tb_message WHERE message_id='$_GET[id]'");
         $r    = mysql_fetch_array($edit);
		 
		  echo "<form method=POST action='$aksi?module=message&act=update' enctype='multipart/form-data' id='Form'  onSubmit='return CekUpdate();' name=formData>
		  
		   <input type=hidden name=id value=$r[message_id]>
		   <input type=hidden name=email value=$r[email]>
		   <input type=hidden name=subject value=$r[subject]>
		   <input type=hidden name=sender value=$r[sender]>
		   <input type=hidden name=phone value=$r[phone]>
		   <input type=hidden name=content value=$r[content]>
		   
		   
			
			
			

          <table class='hovertable'>

          <tr><td width=70>Subject</td>     <td> :".$r['subject']."</td></tr>
		  <tr><td width=70>Sender</td>     <td> :".$r['sender']."</td></tr>
		  <tr><td width=70>Phone</td>     <td> :".$r['phone']."</td></tr>
		  <tr><td width=70>Email</td>     <td> :".$r['email']."</td></tr>
		  <tr><td width=70>Content</td>     <td> :".$r['content']."</td></tr>";
		  echo "<tr><td>Reply Text</td>  <td> <textarea  name='reply_text'  style='width: 710px; height: 350px;'>".$r['reply_text']."</textarea></td></tr>";

		 

    echo "</td></tr>

          <tr><td colspan=2><input type=submit value=Send name=Submit>

                            <input type=button value=Cancel onclick=self.history.back()></td></tr>

          </table></form>";

		 
	
		break; 
	 
	 
	 
}   // switch 	 
	

}

?>

