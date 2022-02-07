<?php
 session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser']))
 {
 		 echo "<link href='style.css' rel='stylesheet' type='text/css'>
 				<center>Untuk mengakses modul, Anda harus login <br>";
 				 echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else
{
 	include "../../../config/koneksi.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_thumb.php";
	
 	$module=$_GET[module];
	$act=$_GET[act];
	// Delete resi manual
	if ($module=='resi_kirim' AND $act=='hapus'){
        $order_no = $_GET['order_no'];
		 
			$strSql = "DELETE from tb_resi WHERE order_no='".$order_no."'";
	  		$result = mysql_query($strSql); 
			
			$loc = '../../media.php?module='.$module;
		 	echo "<script>document.location = '$loc'</script>";

	}

	// Input resi
	elseif ($module=='resi_kirim' AND $act=='input'){   
	    $order_no = $_POST['order_no'];
	    $resi_no = $_POST['resi_no'];
		$cost_name = $_POST['cost_name'];
		$expedition_id = $_POST['expedition'];
		$id_kota = $_POST['kota'];
		$tgl=date('Y-m-d', strtotime($_POST['tanggal']));
		$resitgl=date('Y-m-d', strtotime($_POST['tanggalresi']));
		$stsActive = $_POST['stsActive'];
	
		$sSQL = " insert into tb_resi(order_no, order_dt, full_name, expedition_id, no_resi, dt_resi, id_kota, fl_active) ";
		$sSQL = $sSQL." values ('".$order_no."','".$tgl."','".$cost_name."','".$expedition_id."','".$resi_no."','".$resitgl."','".$id_kota."',";
		$sSQL = $sSQL." '".$stsActive."')";
						
							
		mysql_query($sSQL);
		header('location:../../media.php?module='.$module);

		
	   
	}   // act=input	
	
	elseif ($module=='resi_kirim' AND $act=='update'){
	    $order_no = $_POST['order_no'];
	    $cost_name = $_POST['cost_name'];
	    $tgl = $_POST['tanggal'];
	    $no_resi = $_POST['no_resi'];
	    $expedition = $_POST['expedition'];
	    $city = $_POST['city'];
	    $dt_resi = $_POST['tanggalresi'];
	
		$stsActive = $_POST['stsActive'];
		
		$sSQL = " update tb_resi set order_no ='".$order_no."', order_dt='".$tgl."', full_name='".$cost_name."', expedition_id='".$expedition."', no_resi='".$no_resi."', dt_resi='".$dt_resi."', id_kota='".$city."'";
	    $sSQL = $sSQL." ,fl_active='".$stsActive."' where order_no = '".$order_no."'";
	    mysql_query($sSQL);
		header('location:../../media.php?module='.$module);
	
	} // $module=='bank' AND $act=='update'
	
	
}	// 	empty($_SESSION['username']
?>

