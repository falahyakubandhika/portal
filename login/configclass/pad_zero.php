<?php
/**
 * Fungsi untuk menambahkan NOL didepan angka. Contoh.
 *
 * <code>
 * pad_zero(4);            // output 000004
 * pad_zero(123);        // output 000123
 * pad_zero(123, 4);    // output 0123
 * pad_zero(123, 4, FALSE);    // output 1230
 * </code>
  
 * @author Rio Astamal <me@rioastamal.net>
 *
 * @param int $number - Angka yang akan ditambahkan NOL
 * @param int $length - Jumlah digit yang ingin ditampilkan
 * @param string $in_front - Posisi NOL apakah didepan (TRUE) atau dibelakang (FALSE)
 * 
 * @return string
 */
function pad_zero($number, $length=6, $in_front=TRUE) {
    // ubah ke string agar dapat dihitung jumlah karakternya
    $number = (string)$number;
    // jumlah loop yang dilakukan adalah panjang digit - jumlah karakter
    // jadi jika ingin digit 6 dan angka yang disupply adalah 3
    // maka loop = 6 - 1 => 5 buah NOL
    $loop = $length - strlen($number);
     
    // variabel penampung hasil
    $result = '';
    for ($i=0; $i<$loop; $i++) {
        // tambahkan nol
        $result .= '0';
    }
     
    // gabungkan jumlah NOL dengan angka
    if ($in_front === TRUE) {
        $result = $result . $number;
    } else {
        // NOL dibelakang
        $result = $number . $result;
    }
     
    return $result;
}