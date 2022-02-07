<?php
function format_rupiah($angka){
  $rupiah = number_format($angka,0,',','.');
  return $rupiah;
}
// number_format($saldo, 2, ",", ".")
// 10000
//echo " total " . format_rupiah(10000000);
?> 
