<?php    
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_profil/aksi_profil.php";
switch($_GET['act']){
  // Tampil Profil
  default:
   echo "<h2>Company Profile</h2>";  
    $sql  = mysql_query("SELECT * FROM company where id=1 limit 1");
    $r    = mysql_fetch_array($sql);
echo "<div id='profileTabList' class='tabs'>
      	<a href='#tab1'>Company</a>
      	<a href='#tab2'>Welcome Message</a>
      	<a href='#tab3'>Our Team</a>
	  	<a href='#tab5'>Meta</a>
	</div>";
echo "<div id='profileTabData' class='both'>";
	$image = $r['gambar'];
	$real_gambar = str_replace("images/logo/","",$image);
	$real_gambar = trim($real_gambar);					   
	echo "<div id='tab1' class='tab_content'>";
	echo "<form method=POST enctype='multipart/form-data' action=$aksi?module=profil&act=update>
			<input type=hidden name=id value=$r[id]>
			<table>
			<tr><td>Nama Perusahaan </td><td><input type=text name='nama_perusahaan' value='$r[nama_perusahaan]' size=50></td></tr>
			<tr><td>Website </td><td><input type=text name='website' value='$r[website]' size=80></td></tr>
			<tr><td>Alamat EN</td><td><textarea name='alamat' style='width: 680px; height:100px;' id='loko5'>$r[alamat]</textarea></td></tr>
			<tr><td>Alamat ID</td><td><textarea name='alamat_id' style='width: 680px; height:100px;' id='loko5'>$r[alamat_id]</textarea></td></tr>
			<tr><td>Facebook </td><td><input type=text name='facebook' value='$r[facebook]' size=80></td></tr>
			<tr><td>Twitter </td><td><input type=text name='twitter' value='$r[twitter]' size=80></td></tr>
			<tr><td>Youtube </td><td><input type=text name='youtube' value='$r[youtube]' size=80></td></tr>
			<tr><td>Email </td><td><input type=text name='email_pengelola' value='$r[email_pengelola]' size=80></td></tr>
			<tr><td>Phone </td><td><input type=text name='nomor_tlp' value='$r[nomor_tlp]' size=60></td></tr>
			<tr><td>Fax </td><td><input type=text name='nomor_fax' value='$r[nomor_fax]'></td></tr>
			<tr><td>Logo </td><td><img src='../$image' style='max-width:300px;'></td></tr>
			<tr><td>New Logo </td><td><input type=file name='fupload' size=60>
			<tr><td colspan=2>*) Apabila file tidak diubah, dikosongkan saja.</td></tr>
			<tr><td colspan=2><input type=submit value=Save  class='button'>
			<input type=button value=Batal onclick=self.history.back()  class='button'></td></tr>
		</form></table>
	</div>";
	echo "<div id='tab2' class='tab_content'>";
    echo" <form method=POST enctype='multipart/form-data' action=$aksi?module=profil&act=updatewm>
			<input type=hidden name=id value=$r[id]>
			<table style='width:100%;'>
			<tr><td><textarea name='wlcmessage' style='width:100%;height:400px;' id='loko'>$r[wlcmessage]</textarea></td></tr>
			<tr><td><input type=submit value=Save class='button'>
			<input type=button value=Batal onclick=self.history.back() class='button'></td></tr>
		</form></table>";
	echo"</div>";
	echo "<div id='tab3' class='tab_content'>";
    echo" <form method=POST enctype='multipart/form-data' action=$aksi?module=profil&act=updateou>
			<input type=hidden name=id value=$r[id]>
			<table style='width:100%;'>
			<tr><td><textarea name='ourteam' style='width:100%;height:400px;' id='loko1'>$r[wlcmessageEng]</textarea></td></tr>
			<tr><td><input type=submit value=Save class='button'>
			<input type=button value=Batal onclick=self.history.back() class='button'></td></tr>
		</form></table>";
	echo"</div>";
	echo "<div id='tab5' class='tab_content'>";
    echo" <form method=POST enctype='multipart/form-data' action=$aksi?module=profil&act=updatemeta>
			<input type=hidden name=id value=$r[id]>
			<table>
			<tr><td>meta_title</td><td> <input type=text name='meta_title' value='$r[meta_title]' size=100></td></tr>
			<tr><td>meta_description</td><td><textarea name='meta_description' style='width: 600px;'>$r[meta_description]</textarea></td></tr>
			<tr><td>meta_keywords</td><td><textarea name='meta_keywords' style='width: 600px;'>$r[meta_keywords]</textarea></td></tr>
			<tr><td>meta_abstract</td><td><textarea name='meta_abstract' style='width: 600px;'>$r[meta_abstract]</textarea></td></tr>
			<tr><td>meta_keyphrases</td><td><textarea name='meta_keyphrases' style='width: 600px;'>$r[meta_keyphrases]</textarea></td></tr>
			<tr><td>meta_mytopic</td><td><textarea name='meta_mytopic' style='width: 600px;'>$r[meta_mytopic]</textarea></td></tr>
			<tr><td>meta_revesit_after</td><td><input type='text' name='meta_revesit_after' style='width: 80px;' value='$r[meta_revesit_after]'></td></tr>
			<tr><td>meta_robots</td><td><input type='text' name='meta_robots' style='width: 600px;' value='$r[meta_robots]'></td></tr>
			<tr><td>meta_distribution</td><td><input type='text' name='meta_distribution' style='width: 600px;' value='$r[meta_distribution]'></td></tr>
			<tr><td>meta_classification</td><td><textarea name='meta_classification' style='width: 600px;'>$r[meta_classification]</textarea></td></tr>
			<tr><td colspan=2><input type=submit value=Save class='button'>
			<input type=button value=Batal onclick=self.history.back() class='button'></td></tr>
		</form></table>";
	echo"</div>";
echo "</div>";
    break;  
}
}
?>
