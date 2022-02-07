<?php    

session_start();

if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){

	  echo "<link href='style.css' rel='stylesheet' type='text/css'>

	 <center>Untuk mengakses modul, Anda harus login <br>";

	  echo "<a href=../../index.php><b>LOGIN</b></a></center>";

}

else{



function GetCheckboxes($table, $key, $Label, $Nilai='') {

  $s = "select * from $table order by nama_tag";

  $r = mysql_query($s);

  $_arrNilai = explode(',', $Nilai);

  $str = '';

  while ($w = mysql_fetch_array($r)) {

    $_ck = (array_search($w[$key], $_arrNilai) === false)? '' : 'checked';

    $str .= "<input type=checkbox name='".$key."[]' value='$w[$key]' $_ck>$w[$Label] ";

  }

  return $str;

}



$aksi="modul/mod_email/aksi_email.php";

switch($_GET[act]){

  // Tampil email

  default:

    echo "<h2>Email Blast</h2>

          <form method=get action='$_SERVER[PHP_SELF]'>

          <input type=hidden name=module value=email>

          <div id=paging>Masukkan Judul email : <input type=text name='kata'> <input type=submit value=Cari class='button'></div>

          </form>

          <input type=button class='button' value='Tambah email' onclick=\"window.location.href='?module=email&act=tambahemail';\">";



    if (empty($_GET['kata'])){

		

		echo "<table class='hovertable'>  

			  <tr><th>no</th><th>judul</th><th>tgl. email</th><th>email</th><th>headline</th><th>link</th><th>aksi</th></tr>";



		$p      = new Paging;

		$batas  = 50;

		$posisi = $p->cariPosisi($batas);



		  $tampil = mysql_query("SELECT * FROM email

								ORDER BY id_email DESC LIMIT $posisi,$batas");

								

		$no = $posisi+1;

		while($r=mysql_fetch_array($tampil)){

		  $tgl_posting=tgl_indo($r[tanggal]);

		  if ($r['posting'] == 'Y'){

			$aktif="<img src='images/aktif.png' class='tombol'>";

		  }else{

			$aktif="<img src='images/nonaktif.png' class='tombol'>";

		  }



		  echo "<tr><td>$no</td>

					<td>$r[judul]</td>

					

					<td>$tgl_posting</td>

					<td align='center'><a href='$aksi?module=email&act=posting&id=$r[id_email]'>$aktif</a></td>

					<td>$r[headline]</td>

					<td>content-email-$r[id_email]-$r[judul_seo].html</td>

						<td style='width:100px;'> 

							<a href=?module=email&act=editemail&id=$r[id_email]><img src='images/edit.png' class='tombol' title='Edit email'></a> 
							
							<a href='$aksi?module=email&act=emailemail&id=$r[id_email]&namafile=$r[gambar]' class='ask'><img src='images/icon-1.png' class='tombol' title='Email email'></a>

							<a href='$aksi?module=email&act=hapus&id=$r[id_email]&namafile=$r[gambar]' class='ask'><img src='images/trash.png' class='tombol' title='Delete email'></a>
							
							
							
							</td>

					</tr>";

		  $no++;

		}

		echo "</table>";



		

		$jmldata = mysql_num_rows(mysql_query("SELECT * FROM email 
							ORDER BY id_email"));

		

		$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

		$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);



		if($jmldata > $batas){

		echo "<div id=paging>$linkHalaman</div><br>";

		}

	 

		break;    

    }

    else{

		

		echo "<table class='hovertable'>  

			  <tr><th>no</th><th>judul</th><th>tgl. email</th><th>Email</th><th>headline</th><th>aksi</th></tr>";



		$p      = new Paging;

		$batas  = 50;

		$posisi = $p->cariPosisi($batas);



		$tampil = mysql_query("SELECT * from email
							WHERE judul LIKE '%$_GET[kata]%' 
							ORDER BY id_email DESC LIMIT $posisi,$batas");

	  

		$no = $posisi+1;

		while($r=mysql_fetch_array($tampil)){

		  $tgl_posting=tgl_indo($r['tanggal']);

		  echo "<tr><td>$no</td>

					<td>$r[judul]</td>

					<td>$tgl_posting</td>

					<td>$r[posting]</td>

					<td>$r[headline]</td>

						<td><a href=?module=email&act=editemail&id=$r[id_email]>Edit</a> | 

							<a href='$aksi?module=email&act=hapus&id=$r[id_email]&namafile=$r[gambar]'>Hapus</a></td>

					</tr>";

		  $no++;

		}

		echo "</table>";



		

		$jmldata = mysql_num_rows(mysql_query("SELECT * FROM email 
							WHERE judul LIKE '%$_GET[kata]%'"));

		

		$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

		$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

		

		if($jmldata > $batas){

		echo "<div id=paging>$linkHalaman</div><br>";

		}

		break;    

    }



  

  case "tambahemail":

    echo "<h2>Tambah email</h2>

          <form method=POST action='$aksi?module=email&act=input' enctype='multipart/form-data' id='Form'>

          <table class='hovertable'>

          <tr><td width=70>Judul</td>     <td> : <input type=text name='judul' size=60 class='required'></td></tr>

		  <tr><td width=70>Tanggal</td>     <td> : <input type=text name='tanggal' size='20' value='$dtnowshortIndo' class='datepicker'></td></tr>";

          

    echo "</select></td></tr>

           <tr><td>Headline</td>    <td> : <input type=radio name='headline' value='Y' checked>Y  

                                           <input type=radio name='headline' value='N'> N 

			</td></tr>

		  <tr><td>Cuplikan email</td>  <td> <textarea name='cuplikan'  style='width: 710px; height: 50px;'></textarea></td></tr>

          <tr><td>Isi email</td>  <td> <textarea id='loko' name='isi_email'  style='width: 710px; height: 350px;'></textarea></td></tr>

          ";

    

    echo "</td></tr>

          <tr><td colspan=2><input type=submit value=Simpan>

                            <input type=button value=Batal onclick=self.history.back()></td></tr>

          </table></form>";

     break;

    

    

  case "editemail":

  	echo "<h2> Edit email </h2>";

    $edit = mysql_query("SELECT * FROM email WHERE id_email='$_GET[id]' AND username='$_SESSION[namauser]'");

    $r    = mysql_fetch_array($edit);

	



	echo "<div id='profileTabList' class='tabs'>

			<a href='#tab1'>email</a>

			<a href='#tab2'>Meta</a>

		  </div>";

	echo "<div id='profileTabData' class='both'>";

	

	echo "<div id='tab1' class='tab_content'>

			  <form method=POST enctype='multipart/form-data' action=$aksi?module=email&act=update id='Form'>

			  <input type=hidden name=id value=$r[id_email]>

			  <table class='hovertable'>

			  <tr><td width=70>Judul</td>     <td> : <input type=text name='judul' size=60 value='$r[judul]' class='required'></td></tr>

			  <tr><td width=70>Tanggal</td>     <td> : <input type=text name='tanggal' size='20' value='$r[tanggal]' class='datepicker'></td></tr>

			  <tr><td width=70>Judul SEO</td>     <td> : 

			  		<input type=text name='judul_seo' size=60 value='$r[judul_seo]' class='required'> &nbsp;&nbsp;

					<input type='checkbox' value='Y' name='autoseo' checked />Auto SEO</td></tr>";

			
	

	   if ($r[headline]=='Y'){

		  echo "<tr><td>Headline</td> <td> : <input type=radio name='headline' value='Y' checked>Y  

											 <input type=radio name='headline' value='N'> N";

		}

		else{

		  echo "<tr><td>Headline</td> <td> : <input type=radio name='headline' value='Y'>Y  

											<input type=radio name='headline' value='N' checked>N";

		}

	

		  echo "<tr><td>Cuplikan</td>   <td> <textarea name='cuplikan' style='width: 710px; height: 50px;'>$r[cuplikan]</textarea></td></tr>

				<tr><td>Isi email</td>   <td> <textarea id='loko' name='isi_email' style='width: 710px; height: 350px;'>$r[isi_email]</textarea></td></tr>";

			

		echo  "<tr><td colspan=2><input type=submit value=Update class='button'>

								<input type=button value=Batal onclick=self.history.back() class='button'></td></tr>

			 </table></form>";

	echo "</div>";

	

	echo "<div id='tab2' class='tab_content'>";

	

    echo" <form method=POST enctype='multipart/form-data' action=$aksi?module=email&act=updatemeta>

          <input type=hidden name=id value=$r[id_email]>

          <table class='hovertable'>

          <tr><td>meta_title</td><td> <input type=text name='meta_title' value='$r[meta_title]' size=50></td></tr>

		  <tr><td>meta_description</td><td><textarea name='meta_description' style='width: 380px;'>$r[meta_description]</textarea></td></tr>

		  <tr><td>meta_keywords</td><td><textarea name='meta_keywords' style='width: 380px;'>$r[meta_keywords]</textarea></td></tr>

          <tr><td colspan=2><input type=submit value=Save class='button'></td></tr>

         </form></table>";	

	

	

	echo"</div>";	

 

echo "</div>";		 

    break;  

}



}

?>

