<?php
$server = "localhost";
$username = "k9762398_admin";
$password  = "4606ykfrdw.";
$database = "k9762398_pt";

// Koneksi dan memilih database di server
mysql_connect($server,$username,$password) or die("Koneksi gagal");
mysql_select_db($database) or die("Database tidak bisa dibuka");
?>
