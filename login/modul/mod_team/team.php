<script language ="javascript">
function CekField()
{
	if (document.formData.team_title.value=="")
	{
		alert("Name must be no blank !!!");
		document.formData.team_title.focus();
		return false;
	}	
	if (document.formData.fupload.value=="")
	{
		alert("Team Image must be no blank !!!");
		document.formData.fupload.focus();
		return false;
	}
   return true;
}   

function CekUpdate()
{
	if (document.formData.team_title.value=="")
	{
		alert("Name must be no blank !!!");
		document.formData.team_title.focus();
		return false;
	}
   return true;
}
</script>

<?php
   $aksi="modul/mod_team/aksi_team.php";
  
switch($_GET[act]){
	// Tampil Kategori
	default:  
	echo "<h2>Our Team</h2>
		<input type=button class='button' value='New Team' 
		onclick=\"window.location.href='?module=team&act=tambahteam';\">
		<table>
		<tr><th>ID</th><th>Nama</th><th>Phone</th><th>Status</th><th>Action</th></tr>";
		$p = new Paging;
		$batas  = 10;
		$posisi = $p->cariPosisi($batas);
		$sSQL = "SELECT team_id , team_title, team_phone , IF(team_StsActive=1,'Enabled','Disabled') AS IsActive FROM tb_team order by team_id LIMIT $posisi,$batas";
		$tampil=mysql_query($sSQL);
		$no=1;
		while ($r=mysql_fetch_array($tampil)){
			echo "<tr><td>$r[team_id]</td>
			<td>$r[team_title]</td>
			<td>$r[team_phone]</td>			
			<td>$r[IsActive]</td>
			<td><a href=?module=team&act=editteam&team_id=$r[team_id]><b>Edit</b></a> | 
			<a href=$aksi?module=team&act=hapus&team_id=$r[team_id]><b>Delete</b></a>
			</td></tr>";
			$no++;
		}
		echo "</table>";
		$jmldata = mysql_num_rows(mysql_query("select  * from tb_team"));
		$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
		$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);

		echo "<div id=paging>Page: $linkHalaman</div><br>";
	break;
	// Form Tambah Kategori
  case "tambahteam":
       $sSQL = "  SELECT (team_id + 1) AS team_id FROM tb_team ORDER BY team_id DESC LIMIT 1 ";
	   $rslt=mysql_query($sSQL) or die ("error query");
 	   $i=0;
	   while ($row=mysql_fetch_assoc($rslt))
	    {
	        $team_id = $row['team_id'];
	    }
	    mysql_free_result($rslt);
 
    echo "<h2>New Team</h2>
          <form method=POST action='$aksi?module=team&act=input' name=formData onSubmit='return CekField();' enctype='multipart/form-data'>
          <table>
		  <input name='team_id' type='hidden' value='$team_id'>
          <tr><td>Title</td><td><input type=text name='team_title' size='60'></td></tr>
		  <tr><td>Image</td><td><input type=file name='fupload' size='40'>Minimum Width 140px , height ...px </td></tr>
		  <tr><td>Link URL</td><td><input type=text name='team_phone' size='100'></td></tr>
		  <tr><td>Status</td><td colspan=2 align=left>
		  <input type=radio name='stsActive' value=1 checked>Enabled  
          <input type=radio name='stsActive' value=0> Disabled</td></tr>
		  <tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;
  
  // Form Edit Kategori  
  case "editteam":
	$sSQL="select * from tb_team WHERE team_id='$_GET[team_id]' limit 1";
	$rslt=mysql_query($sSQL) or die ("error query");
	$i=0;
	while ($row=mysql_fetch_assoc($rslt))
	{
		$team_id = $row['team_id'];
		$team_title = $row['team_title'];
		$team_phone = $row['team_phone'];
		$team_img =  $row['team_img'];
		$stsActive=$row['team_StsActive'];
		
	}
	mysql_free_result($rslt);
	/* Get small image */
	$real_gambar = "../".$team_img;
		
    echo "<h2>Team Edit</h2>
	  <form method=POST action='$aksi?module=team&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
          <table>
		  <input name='team_id' type='hidden' value='$team_id'><input name='team_img' type='hidden' value='$team_img'>
          <tr><td>Nama</td><td><input type=text name='team_title' size='60' value='$team_title'></td></tr>
		  <tr><td>Phone</td><td><input type=text name='team_phone' size='60' value='$team_phone'></td></tr>
		  <tr><td>Image</td><td><img src='$real_gambar' style='width:150px;'><a href='$aksi?module=team&act=hapusgambar&id=$team_id&namafile=$team_img'><img src='images/cross.png' class='tombol'></a>290px x .... px  </td></tr>
		  <tr><td>New Image</td><td><input type=file name='fupload' size='40'><i>Leave it Blank if you won't change this image</i> (Minimum Width 1000px , height 381px)</td></tr>";
			if ($stsActive=='1') {
				echo "<tr><td>Status</td><td colspan=2 align=left><input type=radio name='stsActive' value=1 checked>Enabled  
				<input type=radio name='stsActive' value=0> Disabled</td></tr>";
			}
			else
			{
				echo "<tr><td>Status</td><td colspan=2 align=left><input type=radio name='stsActive' value=1>Enabled
				<input type=radio name='stsActive' value=0 checked> Disabled</td></tr>";
			}
        echo "<tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
			<input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
		</table></form>";      
    break;  
}
?>