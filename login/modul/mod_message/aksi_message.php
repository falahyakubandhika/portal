<?php

session_start();

 if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){

  echo "<link href='style.css' rel='stylesheet' type='text/css'>

 <center>Untuk mengakses modul, Anda harus login <br>";

  echo "<a href=../../index.php><b>LOGIN</b></a></center>";

}

else{

	include "../../../config/koneksi.php";

	include "../../../config/library.php";

	include "../../../config/fungsi_thumb.php";

	include "../../../config/fungsi_seo.php";

	

	$module=$_GET['module'];

	$act=$_GET['act'];

	

	
// Update Message

if ($module=='message' AND $act=='update')
{

	

	       $email=$_POST['email'];
		   
		   $subject2 = $_POST['subject'];
		   $sender = $_POST['sender'];
		   $phone = $_POST['phone'];
		   $content2 = $_POST['content'];
		  
		  
		   $pesan = "Subject :".$subject2."<br>";
		   $pesan = $pesan."Sender :".$sender."<br>";
		   $pesan = $pesan."Phone :".$phone."<br>";
		   $pesan = $pesan."Message :".$content2."<br>";
		   
		   
		   
		   
		   $pesan = $pesan."Reply : ".$_POST['reply_text']."<br>";
		   
		   //$pesan =$pesan."<hr>";
		   
		  
		   
		   
		    
		   
		  
		   
	        
			$sSQL = "UPDATE tb_message SET reply_text= '$_POST[reply_text]', reply_id='".$_SESSION['namauser']."',reply_date=now()
					 WHERE message_id  = '$_POST[id]'" ;
			//die($sSQL);		 

			mysql_query($sSQL) or die($sSQL);
			
			$sql2 = mysql_query("select email_pengelola,nama_toko from company where id='1'");
	  	    $j2   = mysql_fetch_array($sql2);
			
			$pesan = $pesan.$j2['nama_toko'];
			
			$to = $email;
		 	$subject = "Reply Message From ".$j2['nama_toko'];
			$headers = "From: " . strip_tags($j2['email_pengelola']) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($j2['email_pengelola']) . "\r\n";
			
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			mail($to, $subject, $pesan, $headers);
			
	      // echo $pesan;
			
			

	 			 $loc = '../../media.php?module='.$module;
				  echo "<script>document.location = '$loc'</script>";

}

	


}	


	
	