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

	

	// Hapus artikel

	if ($module=='artikel' AND $act=='hapus'){

		  $data=mysql_fetch_array(mysql_query("SELECT gambar,posting FROM artikel WHERE id_artikel='$_GET[id]'"));
		  
        if ($data['posting']=='Y')
		{
		    $msg = " Maaf, artikel ini tidak dapat dihapus  sudah di email blast !!!";
			echo "<script>alert('".$msg."');</script>";
		}
		else
		{
		  		if ($data['gambar']!=''){

			 			mysql_query("DELETE FROM artikel WHERE id_artikel='$_GET[id]'");

						unlink("../../../foto_artikel/$_GET[namafile]");   

						unlink("../../../foto_artikel/small_$_GET[namafile]"); 

						unlink("../../../foto_artikel/medium_$_GET[namafile]");  

		  		}

		  		else	{

			 		mysql_query("DELETE FROM artikel WHERE id_artikel='$_GET[id]'");

		  		}
		  }

		
		 $loc = "../../media.php?module=".$module;
		  
		  echo "<script>window.location = '../../media.php?module='.$module'</script>";
		  echo "<script language=javascript>
		      window.location='".$loc."'";
	    echo "</script>"; 

	}



	// Input artikel

elseif ($module=='artikel' AND $act=='input'){

	

	$lokasi_file    = $_FILES['fupload']['tmp_name'];

	$tipe_file      = $_FILES['fupload']['type'];

	$nama_file      = $_FILES['fupload']['name'];

	$acak           = rand(1,99);

	$nama_file_unik = $acak.$nama_file; 

	

	$tgl=date('Y-m-d', strtotime($_POST['tanggal']));

	

	

	if (!empty($_POST['tag_seo'])){

	$tag_seo = $_POST['tag_seo'];

	$tag=implode(',',$tag_seo);

	}

	$judul_seo      = seo_title($_POST['judul']);

	

	// Apabila ada gambar yang diupload

	if (!empty($lokasi_file)){

		if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){

			echo "<script>

					window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');

					window.location=('../../media.php?module=artikel)

				</script>";

				die('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');

		}else{

			if ($tipe_file == "image/png"){

				UploadImagePNG($nama_file_unik);

			}else{

				UploadImageJPG($nama_file_unik);

			}

			

			mysql_query("INSERT INTO artikel(judul,

											judul_seo,

											id_kategori,

											headline,

											username,

											isi_artikel,

											tanggal,

											gambar,

											cuplikan) 

									VALUES('$_POST[judul]',

										   '$judul_seo',

										   '$_POST[kategori]',

										   '$_POST[headline]', 

										   '$_SESSION[namauser]',

										   '$_POST[isi_artikel]',

										   '$tgl',

										   '$nama_file_unik',

										   '$_POST[cuplikan]')");

			

			

			

		  $sql=mysql_query("SELECT last_insert_id() as id_artikel");

		  $data=mysql_fetch_array($sql);

		  $id_artikel=$data['id_artikel'];							   

		

		  header('location:../../media.php?module='.$module);

		  }

	}else{

		mysql_query("INSERT INTO artikel(judul,

											judul_seo,

											id_kategori,

											headline,

											username,

											isi_artikel,

											tanggal,

											cuplikan) 

									VALUES('$_POST[judul]',

										   '$judul_seo',

										   '$_POST[kategori]',

										   '$_POST[headline]', 

										   '$_SESSION[namauser]',

										   '$_POST[isi_artikel]',

										   '$tgl',

										   '$_POST[cuplikan]')");

									   

		  $sql=mysql_query("SELECT last_insert_id() as id_artikel");

		  $data=mysql_fetch_array($sql);

		  $id_artikel=$data['id_artikel'];							   

		

		  header('location:../../media.php?module='.$module);

	}

	



}

// Update artikel

elseif ($module=='artikel' AND $act=='update'){

	  $lokasi_file    = $_FILES['fupload']['tmp_name'];

	  $tipe_file      = $_FILES['fupload']['type'];

	  $nama_file      = $_FILES['fupload']['name'];

	  $acak           = rand(1,99);

	  $nama_file_unik = $acak.$nama_file; 

	

	  if (!empty($_POST['tag_seo'])){

		$tag_seo = $_POST['tag_seo'];

		$tag=implode(',',$tag_seo);

	  }

		if($_POST['autoseo']=="Y"){

	  		$judul_seo = seo_title($_POST['judul']);

		}else{

			$judul_seo = $_POST['judul_seo'];	

		}

	  // Apabila gambar tidak diganti

	  if (empty($lokasi_file)){

		mysql_query("UPDATE artikel SET judul       = '$_POST[judul]',

									   judul_seo   = '$judul_seo', 

									   id_kategori = '$_POST[kategori]',

									   headline    = '$_POST[headline]',

									   tag         = '$tag',

									   isi_artikel  = '$_POST[isi_artikel]',

									   cuplikan  = '$_POST[cuplikan]'

								 WHERE id_artikel   = '$_POST[id]'");

	  header('location:../../media.php?module='.$module);

	  }

	  else{

			if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){

			echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');

				window.location=('../../media.php?module=artikel)</script>";

			}

			else{

				if ($tipe_file == "image/png"){

					UploadImagePNG($nama_file_unik);

				}else{

					UploadImageJPG($nama_file_unik);

				}

				mysql_query("UPDATE artikel SET judul       = '$_POST[judul]',

										   judul_seo   = '$judul_seo', 

										   id_kategori = '$_POST[kategori]',

										   headline    = '$_POST[headline]',

										   tag         = '$tag',

										   isi_artikel  = '$_POST[isi_artikel]',

										   gambar      = '$nama_file_unik',

										   cuplikan  = '$_POST[cuplikan]'

									 WHERE id_artikel   = '$_POST[id]'");

		   header('location:../../media.php?module='.$module);

		   }

		  }

	}

	elseif ($module=='artikel' AND $act=='posting'){

		  mysql_query("UPDATE artikel set posting='Y' WHERE id_artikel='$_GET[id]'");

		  header('location:../../media.php?module='.$module);

	}

	elseif ($module=='artikel' AND $act=='hapusgambar'){

		  mysql_query("UPDATE artikel set gambar='' WHERE id_artikel='$_GET[id]'");

			 unlink("../../../foto_artikel/$_GET[namafile]");   

			 unlink("../../../foto_artikel/small_$_GET[namafile]"); 

			 unlink("../../../foto_artikel/medium_$_GET[namafile]");  

		  

		  header('location:../../media.php?module='.$module.'&act=editartikel&id='.$_GET[id]);	

	}

	

	//update meta

   elseif ($module=='artikel' AND $act=='updatemeta'){

		mysql_query("UPDATE artikel SET meta_title      	= '$_POST[meta_title]',

									  meta_description  	= '$_POST[meta_description]',

									  meta_keywords			= '$_POST[meta_keywords]'  

								WHERE id_artikel       = '$_POST[id]'");

  		header('location:../../media.php?module='.$module.'&act=editartikel&id='.$_POST[id]);



	}
	
	elseif ($module=='artikel' AND $act=='emailartikel'){
	
	  $sql2 = mysql_query("select email_pengelola,nama_toko from company where id='1'");
	  $j2   = mysql_fetch_array($sql2);
	
	  $sSQL = " select * from artikel where id_artikel ='".$_GET[id]."' limit 1";
	
	  $rslt=mysql_query($sSQL) or die ("error query artikel");
	   
	  while ($row=mysql_fetch_assoc($rslt))
	  {
	    $cuplikan = $row['cuplikan'];
		$isi_artikel = $row['isi_artikel'];
		 $judul = $row['judul'];
	  }
     mysql_free_result($rslt);
	  
	  //$new = str_replace("../","../../../",$isi_artikel);
	  $new = trim($new); 
	  
	  //$namo = $j2['nama_toko']."/sweetpeony/";
	   
	   
      $new = str_replace("../","http://www.sweetpeonycollection.com/sweetpeony/",$isi_artikel);
	  
	  //$new = str_replace("../",$namo,$isi_artikel);
	  
	 
	  
	  $new = trim($new); 

	 // die($new);
	 
	// $link = "http://www.sweetpeonycollection.com/sweetpeony/adminweb/modul/mod_artikel/unsubscribe_email.php?EmailName=$emailaddr";
	  
	  $link = "http://www.sweetpeonycollection.com/sweetpeony/adminweb/modul/mod_artikel/unsubscribe_email.php?EmailName=";
	   
	
	  
	 
	  $sSQL = "";
	  $sSQL = " select * from oc_customer where newsletter = 1 order by customer_id ";
	  $rslt=mysql_query($sSQL) or die ("error query");
	  $total = mysql_num_rows(mysql_query($sSQL));
	  $i= 0;
	  while ($row=mysql_fetch_assoc($rslt))
	  {
	     $i = $i + 1;
	     $email = $row['email'];
		 $customer_id = $row['customer_id'];
		 
		 $linkadd = "http://www.sweetpeonycollection.com/sweetpeony/adminweb/modul/mod_artikel/unsubscribe_email.php?EmailName='".$email."'";
		 $newlink = str_replace($link,$linkadd,$new);
		
		 
		 
		
		 $pesan = "
			<html>
			<head>
				<title>Sweetpeonycollection</title>
			</head>

			<body>
			".$newlink."
					
			</body>
			</html>";
		
			

			$to = $email;

			$subject = $judul;
			
			

			$headers = "From: " . strip_tags($j2['email_pengelola']) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($j2['email_pengelola']) . "\r\n";
			
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
	
	
	$sSQLs = " update artikel set posting = 'Y' where id_artikel ='".$_GET[id]."'";
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
