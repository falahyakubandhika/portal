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

		  $data=mysql_fetch_array(mysql_query("SELECT gambar,fl_active FROM tb_article WHERE id_article='$_GET[id]'"));
		  
       
		  		if ($data['gambar']!=''){
				     
					   $gambar = $data['gambar'];
					   $remove = "../../../".$gambar;
					   
					   $real_gambar = str_replace("images/article/","",$gambar);
					   $real_gambar = trim($real_gambar);
					   
					   $gambar_small = "../../../"."images/article/small_".$real_gambar;
					   
					   $gambar_medium = "../../../"."images/article/medium_".$real_gambar;
					   
			
					   unlink($remove);  
					   
					   
					    
					  unlink($gambar_small);   
					 unlink($gambar_medium);   
					   
					   
					   
					   

			 			mysql_query("DELETE FROM tb_article WHERE id_article='$_GET[id]'");

					

		  		}

		  		else	{

			 		mysql_query("DELETE FROM tb_article WHERE id_article='$_GET[id]'");

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
	
	$nama_file_unik2 = "images/article/".$acak.$nama_file;


	$tgl=date('Y-m-d', strtotime($_POST['tanggal']));


	$judul_seo      = seo_title(trim($_POST['judul']));

	

	// Apabila ada gambar yang diupload

	if (!empty($lokasi_file)){

		if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){

			echo "<script>

					window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG atau PNG');

					window.location=('../../media.php?module=artikel)

				</script>";

				die('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');

		}else{

			if ($tipe_file == "image/png"){

				UploadImagePNG_Article($nama_file_unik);

			}else{

				UploadImageJPG_Article($nama_file_unik);

			}

			$sSQL = "insert into tb_article(judul,judul_seo,headline,
					 username,isi_berita,tanggal,gambar,headlinetext,sumber,tag) 
					 values('$_POST[judul]','$judul_seo','$_POST[headline]', 
					 '$_SESSION[namauser]','$_POST[isi_artikel]','$tgl','$nama_file_unik2'
					 ,'$_POST[cuplikan]','$_POST[sumber]','')";
					 
			

			mysql_query($sSQL) or die($sSQL);

		

	        	$loc = '../../media.php?module='.$module;
				   echo "<script>document.location = '$loc'</script>";

		  }

	}else{
	   $sSQL = "insert into tb_article(judul,judul_seo,headline,
					 username,isi_berita,tanggal,headlinetext,sumber) 
					 values('$_POST[judul]','$judul_seo','$_POST[headline]', 
					 '$_SESSION[namauser]','$_POST[isi_artikel]','$tgl',
					 '$_POST[cuplikan]','$_POST[sumber]')";
					 

		mysql_query($sSQL);

		 $loc = '../../media.php?module='.$module;
				   echo "<script>document.location = '$loc'</script>";

	}

	



}

// Update artikel

elseif ($module=='artikel' AND $act=='update')
{

	  $lokasi_file    = $_FILES['fupload']['tmp_name'];

	  $tipe_file      = $_FILES['fupload']['type'];

	  $nama_file      = $_FILES['fupload']['name'];

	  $acak           = rand(1,99);

	  $nama_file_unik = $acak.$nama_file; 

	  $nama_file_unik2 = "images/article/".$acak.$nama_file;

	

		
		
      $judul_seo      = seo_title(trim($_POST['judul']));
		

	  // Apabila gambar tidak diganti

	  if (empty($lokasi_file)){
	        
			$sSQL = "UPDATE tb_article SET judul= '$_POST[judul]',
     			     judul_seo   = '$judul_seo', 
					 headline    = '$_POST[headline]',
					 isi_berita  = '$_POST[isi_artikel]',
					 headlinetext  = '$_POST[cuplikan]',
					 sumber = '$_POST[sumber]', fl_active = '$_POST[fl_active]'
					 WHERE id_article   = '$_POST[id]'" ;
			//die($sSQL);		 

			mysql_query($sSQL) or die($sSQL);

	 			 $loc = '../../media.php?module='.$module;
				   echo "<script>document.location = '$loc'</script>";

	  }

	  else{

			if ($tipe_file != "image/jpg" AND $tipe_file != "image/jpeg" AND $tipe_file != "image/png"){

			echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');

				window.location=('../../media.php?module=artikel)</script>";

			}

			else{
			
			   /* before upload , remove old images first */
			   $sSQL = "";
			   $sSQL = " select gambar from tb_article where id_article='$_POST[id]'";
			   $rslt=mysql_query($sSQL) or die ("error query");
 			   while ($row=mysql_fetch_assoc($rslt))
			   {
			         $gambar = $row['gambar'];
			   }
			    mysql_free_result($rslt);
				
				if ($gambar!='')
				{
			   
			   		$remove = "../../../".$gambar;
					   
			   		$real_gambar = str_replace("images/article/","",$gambar);
			   		$real_gambar = trim($real_gambar);
			   		$gambar_small = "../../../"."images/article/small_".$real_gambar;
			   		$gambar_medium = "../../../"."images/article/medium_".$real_gambar;
					   
			   		unlink($remove);  
			  		unlink($gambar_small);   
			   		unlink($gambar_medium);   
			     	/* End of Remove old images */		   
				}	
		  

				if ($tipe_file == "image/png"){

					UploadImagePNG_Article($nama_file_unik);

				}else{

					UploadImageJPG_Article($nama_file_unik);

				}
				
				$sSQL = "UPDATE tb_article SET judul= '$_POST[judul]',
     			     judul_seo   = '$judul_seo', 
					 headline    = '$_POST[headline]',
					 isi_berita  = '$_POST[isi_artikel]',
					 headlinetext  = '$_POST[cuplikan]',
					 sumber = '$_POST[sumber]', fl_active = '$_POST[fl_active]',
					 gambar ='$nama_file_unik2'
					 WHERE id_article   = '$_POST[id]'" ;
					 
			   		 


				mysql_query($sSQL) or die($sSQL);

		   	 $loc = '../../media.php?module='.$module;
			 echo "<script>document.location = '$loc'</script>";

		   }

		  }

	}

	

	elseif ($module=='artikel' AND $act=='hapusgambar'){

		  mysql_query("UPDATE tb_article set gambar='' WHERE id_article='$_GET[id]'");
		  
		  $gambar = $_GET[namafile];
		  $remove = "../../../".$gambar;
					   
					   $real_gambar = str_replace("images/article/","",$gambar);
					   $real_gambar = trim($real_gambar);
					   
					   $gambar_small = "../../../"."images/article/small_".$real_gambar;
					   
					   $gambar_medium = "../../../"."images/article/medium_".$real_gambar;
					   
			
					   unlink($remove);  
					   unlink($gambar_small);   
					   unlink($gambar_medium);   
		  
		  

			
		  

		  header('location:../../media.php?module='.$module.'&act=editartikel&id='.$_GET[id]);	

	}

}	


	
	