<script language ="javascript">
function CekField()
{
	if (document.formData.foundation_title.value=="")
	{
		alert("foundation Name must be no blank !!!");
		document.formData.foundation_title.focus();
		return false;
	}
   return true;
}
function CekUpdate()
{
	if (document.formData.foundation_title.value=="")
	{
		alert("foundation Name must be no blank !!!");
		document.formData.foundation_title.focus();
		return false;
	}	
   return true;
}
</script>
<?php
$aksi="modul/mod_foundation/aksi_foundation.php";
switch($_GET[act]){
	// Tampil Kategori
	default:  
	echo "<h2>Foundation </h2>
			<form method=get action='$_SERVER[PHP_SELF]'>
         	<input type=hidden name=module value=foundation>
          	<div id=paging><input type=text name='kata' size='60'> <input type=submit value=Cari class='button'></div>
			</form>  
			<input type=button class='button' value='New Foundation' 
			onclick=\"window.location.href='?module=foundation&act=tambahfoundation';\">
			<table>
			<tr><th>ID</th><th>Sequence</th><th>Foundation Name</th><th>Status</th><th>Action</th></tr>";
			$p = new Paging;
			$batas  = 10;
			$posisi = $p->cariPosisi($batas);
			if (empty($_GET['kata']))
			{
				$sSQL = "SELECT foundation_id , foundation_name , IF(fl_active=1,'Enabled','Disabled') AS IsActive, seq ";
				$sSQL = $sSQL." FROM tb_foundation order by seq, foundation_id LIMIT $posisi,$batas";
				
				$sSQL2 = " select * from tb_foundation ";
			}	
			else 
			{
				$sSQL = "select foundation_id , foundation_name , IF(fl_active=1,'Enabled','Disabled') AS IsActive , seq";
				$sSQL = $sSQL." from tb_foundation ";
				$sSQL = $sSQL. " where foundation_name like '%".trim($_GET['kata'])."%'";
				$sSQL = $sSQL." order by seq, foundation_id LIMIT $posisi,$batas";
				
				$sSQL2 = " select * from tb_foundation ";
				$sSQL2 = $sSQL2. " where foundation_name like '%".trim($_GET['kata'])."%'";
			}
			$tampil=mysql_query($sSQL);
			$no=1;
			while ($r=mysql_fetch_array($tampil)){
				echo "<tr><td>$r[foundation_id]</td>
					<td>$r[seq]</td>
					<td>$r[foundation_name]</td>
					<td>$r[IsActive]</td>
					<td>
						<a href=?module=foundation&act=editfoundation&foundation_id=$r[foundation_id]><b>Edit</b></a> | 
						<a href=$aksi?module=foundation&act=hapus&foundation_id=$r[foundation_id]><b>Delete</b></a>
					</td>
				</tr>";
				$no++;
			}
    echo "</table>";
	$jmldata = mysql_num_rows(mysql_query($sSQL2));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);
	
    echo "<div id=paging>Page: $linkHalaman</div><br>";
    break;
	// Form Tambah foundation
  case "tambahfoundation":
    echo "<h2>New Foundation</h2>
        <form method=POST action='$aksi?module=foundation&act=input' name=formData onSubmit='return CekField();' enctype='multipart/form-data'>
			<table>
				<tr><td>Name </td><td><input type=text name='foundation_title' size='60'></td></tr>
				<tr><td>Seq </td><td><input type=text name='seq' size='4' value='0'></td></tr>
				<tr><td>Description </td><td><textarea name='descr' style='width: 680px; height: 450px;' id='loko4'></textarea></td></tr>
				<tr><td>Status</td><td colspan=2 align=left>
					<input type=radio name='stsActive' value=1 checked>Enabled 
					<input type=radio name='stsActive' value=0> Disabled</td></tr>
				<tr><td colspan=2><input type=submit name=submit class='button'  value=Save>
				<input type=button class='button'  value=Cancel onclick=self.history.back()></td></tr>
			</table></form>";
		break;
  // Form Edit foundation
	case "editfoundation":
	$sSQL="select * from tb_foundation WHERE foundation_id='$_GET[foundation_id]' limit 1";
		$rslt=mysql_query($sSQL) or die ("error query");
		$i=0;
		while ($row=mysql_fetch_assoc($rslt))
		{
	        $foundation_id = $row['foundation_id'];
			$foundation_title = $row['foundation_name'];
			$seq = $row['seq'];	
			$stsActive=$row['fl_active'];
			$descr = $row['foundation_descr'];
		}
	    mysql_free_result($rslt);	
    echo "<h2>Foundation Edit</h2>
		<form method=POST action='$aksi?module=foundation&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
			<table>
				<input name='foundation_id' type='hidden' value='$foundation_id'>
				<tr><td>Sequence</td><td><input name='seq' type='text' value='$seq'></td></tr>
				<tr><td>Foundation Name</td><td><input type=text name='foundation_title' size='60' value='$foundation_title'></td></tr>
				<tr><td>Description </td><td><textarea name='descr' style='width: 680px; height: 450px;' id='loko4'>$descr</textarea></td></tr>";
					if ($stsActive=='1') 
						{
							echo "<tr><td>Status</td><td colspan=2 align=left><input type=radio name='stsActive' value=1 checked>Enabled
								<input type=radio name='stsActive' value=0> Disabled</td></tr>";
						}
					else
						{
							echo "<tr><td>Status</td><td colspan=2 align=left><input type=radio name='stsActive' value=1>Enabled
								<input type=radio name='stsActive' value=0 checked> Disabled</td></tr>";
						}		  
				echo "<tr><td colspan=2><input type=submit name=submit class='button'  value=Save>
						<input type=button class='button'  value=Cancel onclick=self.history.back()></td></tr>
			</table>
		</form>";              
    break;  
}
?>