<script language ="javascript">
function CekField()
{
	if (document.formData.judul.value=="")
	{
		alert("Judul Artikel Harus diinput !!!");
		document.formData.judul.focus();
		return false;
	}
	
    if (document.formData.tanggal.value=="")
	{
		alert("Tanggal Artikel Harus diinput !!!");
		document.formData.tanggal.focus();
		return false;
	}
	
	 if (document.formData.cuplikan.value=="")
	{
		alert("Cuplikan Artikel Harus diinput !!!");
		document.formData.cuplikan.focus();
		return false;
	}
	
    if (document.formData.isi_artikel.value=="")
	{
		alert("Isi Artikel Harus diinput !!!");
		document.formData.isi_artikel.focus();
		return false;
	}
	
	/*
	if (document.formData.fupload.value=="")
	{
		alert("Gambar Artikel Harus diinput !!!");
		document.formData.fupload.focus();
		return false;
	}
	
	if (document.formData.sumber.value=="")
	{
		alert("Sumber Artikel Harus diinput !!!");
		document.formData.sumber.focus();
		return false;
	}
	*/


   return true;
}   


function CekUpdate()
{
	if (document.formData.judul.value=="")
	{
		alert("Judul Artikel Harus diinput !!!");
		document.formData.judul.focus();
		return false;
	}
	
    if (document.formData.tanggal.value=="")
	{
		alert("Tanggal Artikel Harus diinput !!!");
		document.formData.tanggal.focus();
		return false;
	}
	
	 if (document.formData.cuplikan.value=="")
	{
		alert("Cuplikan Artikel Harus diinput !!!");
		document.formData.cuplikan.focus();
		return false;
	}
	
    if (document.formData.isi_artikel.value=="")
	{
		alert("Isi Artikel Harus diinput !!!");
		document.formData.isi_artikel.focus();
		return false;
	}
	
	/*

	if (document.formData.sumber.value=="")
	{
		alert("Sumber Artikel Harus diinput !!!");
		document.formData.sumber.focus();
		return false;
	}
	*/


   return true;
}   


</script>

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



$aksi="modul/mod_artikel/aksi_artikel.php";

switch($_GET[act])
{


  default:

    echo "<h2>News</h2>

          <form method=get action='$_SERVER[PHP_SELF]'>

          <input type=hidden name=module value=artikel>

          <div id=paging>Search Article : <input type=text name='kata' size='60'  onKeyUp='this.value = String(this.value).toUpperCase();'> <input type=submit value=Cari class='button'></div>

          </form>

          <input type=button class='button' value='New' onclick=\"window.location.href='?module=artikel&act=tambahartikel';\">";



   
		

		echo "<table class='hovertable'>  

			  <tr><th>no</th><th>title</th><th>headline</th><th>date posted </th><th>Active</th><th>action</th></tr>";



		$p      = new Paging;

		$batas  = 50;

		$posisi = $p->cariPosisi($batas);

         
		if (empty($_GET['kata']))
		{
	    	$sSQL = " SELECT id_article , judul , headline , fl_active , tanggal  ";
        	$sSQL = $sSQL." FROM tb_article ";
			$sSQL = $sSQL. " ORDER BY tanggal DESC LIMIT $posisi,$batas ";
		
			$sSQLt = " SELECT id_article , judul , headline , fl_active , tanggal  ";
       		$sSQLt = $sSQLt." FROM tb_article ";
			$sSQLt = $sSQLt. " ORDER BY tanggal DESC";
		}
		else
		{
	        $sSQL = " SELECT id_article , judul , headline , fl_active , tanggal  ";
        	$sSQL = $sSQL." FROM tb_article ";
			$sSQL = $sSQL. " where judul like '%".trim($_GET['kata'])."%'";
			$sSQL = $sSQL. " ORDER BY tanggal DESC LIMIT $posisi,$batas ";
		
			$sSQLt = " SELECT id_article , judul , headline , fl_active , tanggal  ";
       		$sSQLt = $sSQLt." FROM tb_article ";
			$sSQLt = $sSQLt. " where judul like '%".trim($_GET['kata'])."%'";
			$sSQLt = $sSQLt. " ORDER BY tanggal DESC";
		}

		 

		  $tampil = mysql_query($sSQL);

								

		$no = $posisi+1;

		while($r=mysql_fetch_array($tampil))
		{

		  $tgl_posting=tgl_indo($r[tanggal]);

		  if ($r['fl_active'] == 1)
		  {
			$aktif="<img src='images/aktif.png' class='tombol'>";
		  }	
		  else
		  {
			$aktif="<img src='images/nonaktif.png' class='tombol'>";
		  }	



			  echo "<tr><td>$no</td>

					<td>$r[judul]</td>

					<td>$r[headline]</td>

					<td>$tgl_posting</td>

					<td align='center'><a href='#'>$aktif</a></td>
					<td style='width:100px;'> 
							<a href=?module=artikel&act=editartikel&id=$r[id_article]><img src='images/edit.png' class='tombol' title='Edit Article'></a> 
							
							<a href='$aksi?module=artikel&act=hapus&id=$r[id_article]&namafile=$r[gambar]' class='ask'><img src='images/trash.png' class='tombol' title='Delete Article'></a>
							
							
							
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
 
 case "tambahartikel":	
	 
	 echo "<h2>New News</h2>

          <form method=POST action='$aksi?module=artikel&act=input' enctype='multipart/form-data' id='FormData' onSubmit='return CekField();' name=formData>

          <table class='hovertable'>

          <tr><td width=70>Title</td>     <td> : <input type=text name='judul' size=60 class='required'></td></tr>

		  <tr><td width=70>Date Posted</td>     <td> : <input type=text name='tanggal' size='20' value='$dtnowshortIndo' class='datepicker'></td></tr>";

       

    echo "<tr><td>Headline</td>    <td> : <input type=radio name='headline' value='Y' checked>Y  

                                           <input type=radio name='headline' value='N'> N 

			</td></tr>

		  <tr><td>Headline Text</td>  <td> <textarea name='cuplikan'  style='width: 710px; height: 50px;'></textarea></td></tr>

          <tr><td>Content</td>  <td> <textarea id='loko' name='isi_artikel'  style='width: 710px; height: 350px;'></textarea></td></tr>

          <tr><td>Image</td>      <td> : <input type=file name='fupload' size=40> 

                                          <br>Tipe gambar harus JPG/JPEG dan ukuran lebar maks: 400 px</td></tr>";
     
	echo "<tr><td width=70>Source From</td>     <td> : <input type=text name='sumber' size=100 class='required'></td></tr>"; 
    

    echo "</td></tr>

          <tr><td colspan=2><input type=submit value=Save>

                            <input type=button value=Cancel onclick=self.history.back()></td></tr>

          </table></form>";
		  break;

	 case "editartikel":
	    echo "<h2> Edit News </h2>";
		
		 $edit = mysql_query("SELECT * FROM tb_article WHERE id_article='$_GET[id]' AND username='$_SESSION[namauser]'");
         $r    = mysql_fetch_array($edit);
		 
		  echo "<form method=POST action='$aksi?module=artikel&act=update' enctype='multipart/form-data' id='Form'  onSubmit='return CekUpdate();' name=formData>
		  
		   <input type=hidden name=id value=$r[id_article]>

          <table class='hovertable'>

          <tr><td width=70>Title</td>     <td> : <input type=text name='judul' size=60 class='required' value='$r[judul]'></td></tr>

		  <tr><td width=70>Date Posted</td>     <td> : <input type=text name='tanggal' size='20' value='$r[tanggal]' class='datepicker'></td></tr>";

         if ($r[headline]=='Y'){

		  echo "<tr><td>Headline</td> <td> : <input type=radio name='headline' value='Y' checked>Y  

											 <input type=radio name='headline' value='N'> N";

		}

		else{

		  echo "<tr><td>Headline</td> <td> : <input type=radio name='headline' value='Y'>Y  

											<input type=radio name='headline' value='N' checked>N";

		}

   
			echo "</td></tr>";

		  echo "<tr><td>Headline Text</td>  <td> <textarea name='cuplikan'  style='width: 710px; height: 50px;' >$r[headlinetext]</textarea></td></tr>

          <tr><td>Content</td>  <td> <textarea id='loko' name='isi_artikel'  style='width: 710px; height: 350px;'>$r[isi_berita]</textarea></td></tr>";
		  
  echo "<tr><td>Gambar</td>       <td> :  ";

			  if ($r[gambar]!=''){
			      
				   $real_gambar = str_replace("images/article/","",$r[gambar]);
				   $real_gambar = trim($real_gambar);
					   
				   $gambar_small = "../images/article/small_".$real_gambar;
				   
				 
				   echo "<img src='".$gambar_small."'/>";
				   
				   
				  

				  echo "<a href='$aksi?module=artikel&act=hapusgambar&id=$r[id_article]&namafile=$r[gambar]'><img src='images/cross.png' class='tombol'></a>";  

			  }

		echo "</td></tr>

			  <tr><td>Ganti Gbr</td>    <td> : <input type=file name='fupload' size=30> *)</td></tr>

			  <tr><td colspan=2>*) Apabila gambar tidak diubah, dikosongkan saja.</td></tr>";

          
	echo "<tr><td width=70>Source From</td>     <td> : <input type=text name='sumber' size=100 class='required' value='$r[sumber]'></td></tr>"; 
	
	if ($r[fl_active]==1)
	{

		  echo "<tr><td>Enabled</td> <td> : <input type=radio name='fl_active' value='1' checked>Y  
											 <input type=radio name='fl_active' value='0'> N";

	}

	else
	{

		  echo "<tr><td>Enabled</td> <td> : <input type=radio name='fl_active' value='1'>Y  
											<input type=radio name='fl_active' value='0' checked>N";
 	}
    

    echo "</td></tr>

          <tr><td colspan=2><input type=submit value=Save>

                            <input type=button value=Cancel onclick=self.history.back()></td></tr>

          </table></form>";

		 
	
		break; 
	 
	 
	 
}   // switch 	 
	

}

?>

