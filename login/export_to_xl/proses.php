<?php
// menggunakan class phpExcelReader
include "excel_reader2/excel_reader2.php";

// koneksi ke mysql
include"koneksi.php";
mysql_query("TRUNCATE tb_kota");

// membaca file excel yang diupload
$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);

// membaca jumlah baris dari data excel
$baris = $data->rowcount($sheet_index=0);

// nilai awal counter untuk jumlah data yang sukses dan yang gagal diimport
$sukses = 0;
$gagal = 0;

// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{
	// provinsi
	$prov = $data->val($i, 1);
	// kabupaten
	$kab = $data->val($i, 2);
	// kode kota
	$kodekota = $data->val($i, 3);
	// namakota
	$namakota = $data->val($i, 4);
	// tarif reguler
	$ongkir = $data->val($i, 5);
	// tarif oke
	$ongkir2 = $data->val($i, 6);	
	
  // setelah data dibaca, sisipkan ke dalam tabel mhs
  $query = "INSERT INTO tb_kota (prov, kab, kode_kota, nama_kota, ongkos_kirim, ongkos_kirim2) 
  				VALUES ('$prov', '$kab', '$kodekota', '$namakota', '$ongkir', '$ongkir2')";
  $hasil = mysql_query($query);

  // jika proses insert data sukses, maka counter $sukses bertambah
  // jika gagal, maka counter $gagal yang bertambah
  if ($hasil) $sukses++;
  else $gagal++;
}

// tampilan status sukses dan gagal
echo "<h3>Proses import data selesai.</h3>";
echo "<p>Jumlah data yang sukses diimport : ".$sukses."<br>";
echo "Jumlah data yang gagal diimport : ".$gagal."</p>";

?>
