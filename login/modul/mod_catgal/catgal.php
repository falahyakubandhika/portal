<script language ="javascript">
function CekField()
{
	if (document.formData.Title.value=="")
	{
		alert("Title Harus diinput !!!");
		document.formData.Title.focus();
		return false;
	}	
    if (document.formData.Date.value=="")
	{
		alert("Date Harus diinput !!!");
		document.formData.Date.focus();
		return false;
	}
	/*
	if (document.formData.fupload.value=="")
	{
		alert("Imgpath Harus diinput !!!");
		document.formData.fupload.focus();
		return false;
	}
	*/
   return true;
}
function CekUpdate()
{
	if (document.formData.Title.value=="")
	{
		alert("Title Harus diinput !!!");
		document.formData.Title.focus();
		return false;
	}	
    if (document.formData.Date.value=="")
	{
		alert("Date Harus diinput !!!");
		document.formData.Date.focus();
		return false;
	}
   return true;
}
</script>
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
$aksi="modul/mod_catgal/aksi_catgal.php";
switch($_GET[act])
{
  default:
    echo "<h2>Gallery</h2>
		<form method=get action='$_SERVER[PHP_SELF]'>
		<input type=hidden name=module value=catgal>
		<div id=paging>Search : <input type=text name='kata' size='60'  onKeyUp='this.value = String(this.value).toUpperCase();'> <input type=submit value=Cari class='button'></div>
		</form>
		<input type=button class='button' value='New' onclick=\"window.location.href='?module=catgal&act=tambahcatgal';\">";
		echo "<table class='hovertable'>
		<tr><th>no</th><th>title</th><th>date posted </th><th>Active</th><th>action</th></tr>";
		
		$p      = new Paging;
		$batas  = 50;
		$posisi = $p->cariPosisi($batas);
		
		if (empty($_GET['kata']))
		{
	    	$sSQL = " SELECT gal , Title  , fl_active , Date  ";
        	$sSQL = $sSQL." FROM tb_catgal ";
			$sSQL = $sSQL. " ORDER BY Date DESC LIMIT $posisi,$batas ";
		
			$sSQLt = " SELECT gal , Title, fl_active , Date  ";
       		$sSQLt = $sSQLt." FROM tb_catgal ";
			$sSQLt = $sSQLt. " ORDER BY Date DESC";
		}
		else
		{
	        $sSQL = " SELECT gal , Title , fl_active , Date  ";
        	$sSQL = $sSQL." FROM tb_catgal ";
			$sSQL = $sSQL. " where Title like '%".trim($_GET['kata'])."%'";
			$sSQL = $sSQL. " ORDER BY Date DESC LIMIT $posisi,$batas ";
		
			$sSQLt = " SELECT gal , Title, fl_active , Date  ";
       		$sSQLt = $sSQLt." FROM tb_catgal ";
			$sSQLt = $sSQLt. " where Title like '%".trim($_GET['kata'])."%'";
			$sSQLt = $sSQLt. " ORDER BY Date DESC";
		}
		$tampil = mysql_query($sSQL);
		$no = $posisi+1;
		while($r=mysql_fetch_array($tampil))
		{
			$tgl_posting=tgl_indo($r['Date']);
			if ($r['fl_active'] == 1)
			{
				$aktif="<img src='images/aktif.png' class='tombol'>";
			}	
			else
			{
				$aktif="<img src='images/nonaktif.png' class='tombol'>";
			}
			if(empty($r['Imgpath'])) $r['Imgpath'] ="";
			echo "<tr>
				<td>$no</td>
				<td>$r[Title]</td>
				<td>$tgl_posting</td>
				<td align='center'><a href='#'>$aktif</a></td>
				<td style='width:100px;'> 
					<a href=?module=catgal&act=editcatgal&id=$r[gal]><img src='images/edit.png' class='tombol' title='Edit'></a>
					<a href='$aksi?module=catgal&act=hapus&id=$r[gal]&namafile=$r[Imgpath]' class='ask'><img src='images/trash.png' class='tombol' title='Delete Article'></a>
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
	case "tambahcatgal":	
	echo "<h2>New Gallery</h2>
		<form method=POST action='$aksi?module=catgal&act=input' enctype='multipart/form-data' id='FormData' onSubmit='return CekField();' name=formData>
			<table class='hovertable'>
			<tr><td width=70>Title</td><td><input type=text name='Title' size=60 class='required'></td></tr>
			<tr><td width=70>Date Posted</td><td><input type=text name='Date' size='20' value='$dtnowshortIndo' class='datepicker'></td></tr>
			<tr><td>Content</td><td><textarea id='loko' name='Detail'  style='width: 710px; height: 350px;'></textarea></td></tr>
			<tr><td>Image</td><td><input type=file name='fupload' size=40><br>Tipe gambar harus JPG/JPEG dan ukuran lebar maks: 400 px</td></tr>";
			echo "<tr><td>Our Business</td>  <td> : 
				  <select name='tip' id='tip'>
						<option value=-1 selected>- Pilih -</option>";
							$tampil=mysql_query("select * from tb_catdetail where fl_active =1  order by Title");
							while($r=mysql_fetch_array($tampil))
							{
								echo "<option value=$r[tip]>$r[Title]</option>";
							}
			echo "</select></td></tr>";				  
			echo "
			<tr><td colspan=2><input type=submit value=Save>
				<input type=button value=Cancel onclick=self.history.back()></td></tr>
			</table>
		</form>";
		  break;

	 case "editcatgal":
	    echo "<h2> Edit Our Business </h2>";
		
		$edit = mysql_query("SELECT * FROM tb_catgal WHERE gal='$_GET[id]'");
		$r    = mysql_fetch_array($edit);
		echo "<form method=POST action='$aksi?module=catgal&act=update' enctype='multipart/form-data' id='Form'  onSubmit='return CekUpdate();' name=formData>
			<input type=hidden name=id value=$r[gal]>
			<table class='hovertable'>
			<tr><td width=70>Title</td><td><input type=text name='Title' size=60 class='required' value='$r[Title]'></td></tr>
			<tr><td width=70>Date Posted</td><td><input type=text name='Date' size='20' value='$r[Date]' class='datepicker'></td></tr>";
			echo "
			<tr><td>Content</td>  <td> <textarea id='loko' name='Detail'  style='width: 710px; height: 350px;'>$r[Detail]</textarea></td></tr>";
			echo "<tr><td>Gambar</td><td>";
			if ($r[Imgpath]!=''){
				$real_Imgpath = $r[Imgpath];//str_replace("images/catgal/","",$r[Imgpath]);
				$real_Imgpath = "../".trim($real_Imgpath);
				$Imgpath_small = "../images/catgal/small_".$real_Imgpath;
				echo "<img src='".$real_Imgpath."' width='100'/>";
				echo "<a href='$aksi?module=catgal&act=hapusgambar&id=$r[gal]&namafile=$r[Imgpath]'><img src='images/cross.png' class='tombol'></a>";
			}
			echo "</td></tr>
			<tr><td>Ganti Gbr</td><td><input type=file name='fupload' size=30> *)</td></tr>
			<tr><td colspan=2>*) Apabila Gambar tidak diubah, dikosongkan saja.</td></tr>
			"; 	
          echo "<tr><td>Our Business</td>  <td> : 
          <select name='tip'>";
		  
		  $tampil=mysql_query("SELECT * FROM tb_catdetail ORDER BY Title");
		  
        while($w=mysql_fetch_array($tampil))
		{
            if ($r[tip]==$w[tip])
			{
              echo "<option value=$w[tip] selected>$w[Title]</option>";
            }
            else
			{
              echo "<option value=$w[tip]>$w[Title]</option>";
            }
        }
		
		echo "</select></td></tr>";
			if ($r['fl_active']==1)
			{
				echo "<tr><td>Enabled</td><td><input type=radio name='fl_active' value='1' checked>Y  
				<input type=radio name='fl_active' value='0'> N";
			}
			else
			{
				echo "<tr><td>Enabled</td><td><input type=radio name='fl_active' value='1'>Y  
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

