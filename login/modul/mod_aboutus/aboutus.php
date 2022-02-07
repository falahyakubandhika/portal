<?php    
if (empty($_SESSION['username']) AND empty($_SESSION['passuser']))
{
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else
{
	$aksi="modul/mod_aboutus/aksi_aboutus.php";
	switch($_GET[act])
	{
	default:
  		echo "<h2>About Us</h2>";  
   			  $sql  = mysql_query("SELECT * FROM tb_about where id=1 limit 1");
    		  $r    = mysql_fetch_array($sql);

  		echo " <form method=POST enctype='multipart/form-data' action=$aksi?module=aboutus&act=update>
          	   <input type=hidden name=id value=$r[id]>
               <table>
		       <tr><td><textarea name='isi' style='width: 800px; height: 550px;' id='loko'>$r[about_text]</textarea></td></tr>
		  	   <tr><td colspan=2><input type=submit value=Save  class='button'>
               <input type=button value=Cancel onclick=self.history.back()  class='button'></td></tr>
        	   </form></table>";		 
    	break;  
	}
}
?>