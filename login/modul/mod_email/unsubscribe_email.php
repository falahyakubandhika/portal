<?php
  $EmailName = isset($_GET['EmailName'])  ? strval($_GET['EmailName']) : false;
  
  
  
  $server = "localhost";
  $username = "sweetpe1_root";
  $password = "fisika";
  $database = "sweetpe1_ocar464";
  

  // Koneksi dan memilih database di server
  mysql_connect($server,$username,$password) or die("Koneksi gagal");
  mysql_select_db($database) or die("Database tidak bisa dibuka");
  
  $sSQLs = " update oc_customer set newsletter = 0 where email =".$EmailName;
 
  $ok=mysql_query($sSQLs);
  if ($ok)
  {
       $msg="Thank you for unsubscribing ";
			 
        echo "<script>alert('".$msg."');</script>";
		
  
  }

?>