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
	
	include "../../../include/fungsi.php";

	

	$module=$_GET['module'];

	$act=$_GET['act'];

	

	// Hapus email

	if ($module=='email' AND $act=='hapus'){

		  $data=mysql_fetch_array(mysql_query("SELECT gambar,posting FROM email WHERE id_email='$_GET[id]'"));
		  
        if ($data['posting']=='Y')
		{
		    $msg = " Maaf, email ini tidak dapat dihapus  sudah di email blast !!!";
			echo "<script>alert('".$msg."');</script>";
		}
		else
		{
		  		

			 		mysql_query("DELETE FROM email WHERE id_email='$_GET[id]'");

		}

		
		 $loc = "../../media.php?module=".$module;
		  
		  echo "<script>window.location = '../../media.php?module='.$module'</script>";
		  echo "<script language=javascript>
		      window.location='".$loc."'";
	    echo "</script>"; 

	}



	// Input email

elseif ($module=='email' AND $act=='input'){

	$tgl=date('Y-m-d', strtotime($_POST['tanggal']));

	if (!empty($_POST['tag_seo'])){

	$tag_seo = $_POST['tag_seo'];

	$tag=implode(',',$tag_seo);

	}

	$judul_seo      = seo_title($_POST['judul']);

	

	

		mysql_query("INSERT INTO email(judul,

											judul_seo,

											id_kategori,

											headline,

											username,

											isi_email,

											tanggal,

											cuplikan) 

									VALUES('$_POST[judul]',

										   '$judul_seo',

										   '$_POST[kategori]',

										   '$_POST[headline]', 

										   '$_SESSION[namauser]',

										   '$_POST[isi_email]',

										   '$tgl',

										   '$_POST[cuplikan]')");

									   

		  $sql=mysql_query("SELECT last_insert_id() as id_email");

		  $data=mysql_fetch_array($sql);

		  $id_email=$data['id_email'];							   

		

		  header('location:../../media.php?module='.$module);


	



}

// Update email

elseif ($module=='email' AND $act=='update')
{

	

		if($_POST['autoseo']=="Y"){

	  		$judul_seo = seo_title($_POST['judul']);

		}else{

			$judul_seo = $_POST['judul_seo'];	

		}

	  // Apabila gambar tidak diganti

	

		mysql_query("UPDATE email SET judul       = '$_POST[judul]',

									   judul_seo   = '$judul_seo', 

									   id_kategori = '$_POST[kategori]',

									   headline    = '$_POST[headline]',

									   tag         = '$tag',

									   isi_email  = '$_POST[isi_email]',

									   cuplikan  = '$_POST[cuplikan]'

								 WHERE id_email   = '$_POST[id]'");

	  header('location:../../media.php?module='.$module);

}	
	
	  
	elseif ($module=='email' AND $act=='emailemail'){
	
	  $sql2 = mysql_query("select * from company where id='1'");
	  $j2   = mysql_fetch_array($sql2);
	
	  $sSQL = " select * from email where id_email ='".$_GET[id]."' limit 1";
	
	  $rslt=mysql_query($sSQL) or die ("error query email");
	   
	  while ($row=mysql_fetch_assoc($rslt))
	  {
	    $cuplikan = $row['cuplikan'];
		$isi_email = $row['isi_email'];
		 $judul = $row['judul'];
	  }
     mysql_free_result($rslt);
	
	
	$str = $j2['website'];
	$cari = strstr($str,"http://"); 
	
	   $cari = "http://".$j2['website']."/";
	   
	  
	 $new = trim($new); 
	  
	  
	  /* str_replace ( word_search , word_replace , source_text) 
	     str_replace ( "world" , "peter" , "hello world ")  --> find word : world , replace by peter --> result: hello peter 
	  
	  */
	  
	  
    //  $new = str_replace("../","http://www.nidjishop.com/",$isi_email);
	
	$new = str_replace("../",$cari,$isi_email);

	  //$new = str_replace("../","",$isi_email);
	  
	 
	 
	  
	  $new = trim($new); 

	
	
	  
	  //$link = "http://www.netsprogram.com/sweetpeony/adminweb/modul/mod_email/unsubscribe_email.php?EmailName=";
	  
	  /*this is ok */
	  //$link="modul/mod_email/unsubscribe_email.php?EmailName=";
	   
	
	  
	 
	  $sSQL = "";
	  $sSQL = " select * from tb_member where email_subscribe = 1 order by id_member ";
	  $rslt=mysql_query($sSQL) or die ("error query");
	  $total = mysql_num_rows(mysql_query($sSQL));
	  $i= 0;
	  while ($row=mysql_fetch_assoc($rslt))
	  {
	     $i = $i + 1;
	     $email = $row['email'];
		 $id_member = $row['id_member'];
		 
		 /* testing di netsprogram 
		 $linkadd = "http://www.netsprogram.com/sweetpeony/adminweb/modul/mod_email/unsubscribe_email.php?EmailName='".$email."'";
		 */
		 //$linkadd = "http://www.sweetpeonycollection.com/sweetpeony/adminweb/modul/mod_email/unsubscribe_email.php?EmailName='".$email."'";
		 
		 //$newlink = str_replace($link,$linkadd,$new);
		
		 
		 
		
		 $pesan = "
			<html>
			<head>
				<title>".$j2['nama_toko']."</title>
			</head>

			<body>
			".$new."
					
			</body>
			</html>";
		
			
            /* ke member */
			$to = $email;

			$subject = $judul;

			$headers = "From: " . strip_tags($j2['email3']) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($j2['email3']) . "\r\n";
			
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			mail($to, $subject, $pesan, $headers);
			
			
			/* ke marketing */
			
			
			
			$to = strip_tags($j2['email3']);

			$subject = $judul;

			$headers = "From: " . strip_tags($j2['email4']) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($j2['email3']) . "\r\n";
			
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			mail($to, $subject, $pesan, $headers);
			
			
			
			
			/* Progress bar */
			$percent = intval($i/$total * 100)."%";
			echo '<script language="javascript">
    			   document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#990000;\">&nbsp;</div>";
    			   document.getElementById("information").innerHTML="'.$i.' row(s) processed.";
                  </script>';
	
		    // This is for the buffer achieve the minimum size in order to flush data
    		echo str_repeat(' ',1024*64);

    
			// Send output to browser immediately
    		flush();

    
			// Sleep one second so we can see the delay
    		sleep(1);
		
		 
		 
	  }
	  
	   mysql_free_result($rslt); 
	   echo '<script language="javascript">document.getElementById("information").innerHTML="Processed Sending Email Completed ..."</script>';
	}
	
	
	$sSQLs = " update email set posting = 'Y' where id_email ='".$_GET[id]."'";
	$ok=mysql_query($sSQLs);
	
  
    $msg="Thank you for sending Email Blast ";
			 
    echo "<script>alert('".$msg."');</script>";

    $loc = '../../media.php?module='.$module;
		 echo "<script>document.location = '$loc'</script>";




}

?>
<html lang="en">
<body>
<!-- Progress bar holder -->
<div id="progress" style="width:500px;border:1px solid #ccc; margin-left:200px; margin-top:250px;"></div>
<!-- Progress information -->
<div id="information" style="width;margin-left:200px; margin-top:10px;"></div>

</body>
</html>
