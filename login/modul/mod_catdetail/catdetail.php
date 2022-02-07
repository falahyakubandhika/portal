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
$aksi="modul/mod_catdetail/aksi_catdetail.php";
switch($_GET[act])
{
  default:
    echo "<h2>Our Business</h2>
		<form method=get action='$_SERVER[PHP_SELF]'>
		<input type=hidden name=module value=catdetail>
		<div id=paging>Search Article : <input type=text name='kata' size='60'  onKeyUp='this.value = String(this.value).toUpperCase();'> <input type=submit value=Cari class='button'></div>
		</form>
		<input type=button class='button' value='New' onclick=\"window.location.href='?module=catdetail&act=tambahcatdetail';\">";
		echo "<table class='hovertable'>
		<tr><th>no</th><th>title</th><th>date posted </th><th>Active</th><th>action</th></tr>";
		
		$p      = new Paging;
		$batas  = 50;
		$posisi = $p->cariPosisi($batas);
		
		if (empty($_GET['kata']))
		{
	    	$sSQL = " SELECT tip , Title , Subtitle , fl_active , Date  ";
        	$sSQL = $sSQL." FROM tb_catdetail ";
			$sSQL = $sSQL. " ORDER BY Date DESC LIMIT $posisi,$batas ";
		
			$sSQLt = " SELECT tip , Title , Subtitle , fl_active , Date  ";
       		$sSQLt = $sSQLt." FROM tb_catdetail ";
			$sSQLt = $sSQLt. " ORDER BY Date DESC";
		}
		else
		{
	        $sSQL = " SELECT tip , Title , Subtitle , fl_active , Date  ";
        	$sSQL = $sSQL." FROM tb_catdetail ";
			$sSQL = $sSQL. " where Title like '%".trim($_GET['kata'])."%'";
			$sSQL = $sSQL. " ORDER BY Date DESC LIMIT $posisi,$batas ";
		
			$sSQLt = " SELECT tip , Title , Subtitle , fl_active , Date  ";
       		$sSQLt = $sSQLt." FROM tb_catdetail ";
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
			if(empty($r['Imgpath'])) $r['Imgpath']="";
			echo "<tr>
				<td>$no</td>
				<td>".$r['Title']."</td>
				<td>$tgl_posting</td>
				<td align='center'><a href='#'>$aktif</a></td>
				<td style='width:100px;'> 
					<a href=?module=catdetail&act=editcatdetail&id=".$r['tip']."><img src='images/edit.png' class='tombol' title='Edit'></a>
					<a href='$aksi?module=catdetail&act=hapus&id=".$r['tip']."&namafile=".$r['Imgpath']."' class='ask'><img src='images/trash.png' class='tombol' title='Delete Article'></a>
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
	case "tambahcatdetail":	
	echo "<h2>New Our Business</h2>
		<form method=POST action='$aksi?module=catdetail&act=input' enctype='multipart/form-data' id='FormData' onSubmit='return CekField();' name=formData>
			<table class='hovertable'>
			<tr><td width=70>Title</td><td><input type=text name='Title' size=60 class='required'></td></tr>
			<tr><td width=70>Date Posted</td><td><input type=text name='Date' size='20' value='$dtnowshortIndo' class='datepicker'></td></tr>
			<tr><td>Headline Text</td><td> <textarea name='Subtitle' style='width: 710px; height: 50px;'></textarea></td></tr>
			<tr><td>Content</td><td><textarea id='loko' name='Detail'  style='width: 710px; height: 350px;'></textarea></td></tr>
			<tr><td>Image</td><td><input type=file name='fupload' size=40><br>Tipe gambar harus JPG/JPEG dan ukuran lebar maks: 400 px</td></tr>";
			echo "<tr><td>Kelompok</td>  <td> : 
				  <select name='brand_id' id='brand_id'>
						<option value=-1 selected>- Pilih Merk -</option>";
							$tampil=mysql_query("select * from tb_brand where fl_active =1  order by brand_name");
							while($r=mysql_fetch_array($tampil))
							{
								echo "<option value=".$r['brand_id'].">".$r['brand_name']."</option>";
							}
			echo "</select></td></tr>";				  
			echo "
			<tr><td colspan=2><input type=submit value=Save>
				<input type=button value=Cancel onclick=self.history.back()></td></tr>
			</table>
		</form>";
		  break;

	 case "editcatdetail":
	    echo "<h2> Edit Our Business </h2>";
		
		$edit = mysql_query("SELECT * FROM tb_catdetail WHERE tip='$_GET[id]'");
		$r    = mysql_fetch_array($edit);
		echo "<form method=POST action='$aksi?module=catdetail&act=update' enctype='multipart/form-data' id='Form'  onSubmit='return CekUpdate();' name=formData>
			<input type=hidden name=id value=".$r['tip'].">
			<table class='hovertable'>
			<tr><td width=70>Title</td><td><input type=text name='Title' size=60 class='required' value='".$r['Title']."'></td></tr>
			<tr><td width=70>Date Posted</td><td><input type=text name='Date' size='20' value='".$r['Date']."' class='datepicker'></td></tr>";
			echo "<tr><td>Headline Text</td>  <td> <textarea name='Subtitle'  style='width: 710px; height: 50px;' >".$r['Subtitle']."</textarea></td></tr>
			<tr><td>Content</td>  <td> <textarea id='loko' name='Detail'  style='width: 710px; height: 350px;'>".$r['Detail']."</textarea></td></tr>";
			echo "<tr><td>Gambar</td><td>";
			if ($r['Imgpath']!=''){
				$real_Imgpath = $r['Imgpath'];//str_replace("images/catdetail/","",$r[Imgpath]);
				$real_Imgpath = "../".trim($real_Imgpath);
				$Imgpath_small = "../images/catdetail/small_".$real_Imgpath;
				echo "<img src='".$real_Imgpath."' width='100'/>";
				echo "<a href='$aksi?module=catdetail&act=hapusgambar&id=".$r['tip']."&namafile=".$r['Imgpath']."'><img src='images/cross.png' class='tombol'></a>";
			}
			echo "</td></tr>
			<tr><td>Ganti Gbr</td><td><input type=file name='fupload' size=30> *)</td></tr>
			<tr><td colspan=2>*) Apabila Gambar tidak diubah, dikosongkan saja.</td></tr>
			"; 	
          echo "<tr><td>Kelompok</td>  <td> : 
          <select name='brand_id'>";
		  
		  $tampil=mysql_query("SELECT * FROM tb_brand ORDER BY brand_name");
		  
        while($w=mysql_fetch_array($tampil))
		{
            if ($r['cat']==$w['brand_id'])
			{
              echo "<option value=".$w['brand_id']." selected>".$w['brand_name']."</option>";
            }
            else
			{
              echo "<option value=".$w['brand_id'].">".$w['brand_name']."</option>";
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

