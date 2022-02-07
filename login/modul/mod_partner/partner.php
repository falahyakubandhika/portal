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
	$aksi="modul/mod_partner/aksi_partner.php";
	switch($_GET[act])
	{
	  default:
  		 echo "<h2>Company partner</h2>";  
   			  $sql  = mysql_query("SELECT * FROM tb_partner where id=1 limit 1");
    		  $r    = mysql_fetch_array($sql);

		 echo "<div id='profileTabList' class='tabs'>
      		   <a href='#tab2'>Company partner</a>
	  	
  	           </div>";

		 echo "<div id='profileTabData' class='both'>";


		 echo "<div id='tab2' class='tab_content'>";
	
  		 echo " <form method=POST enctype='multipart/form-data' action=$aksi?module=partner&act=update>
          	   <input type=hidden name=id value=$r[id]>
               <table>
          
		       <tr><td>partner</td><td> : <textarea name='isi' style='width: 680px; height: 250px;' id='loko'>$r[partner_text]</textarea></td></tr>
        
		  	   <tr><td colspan=2><input type=submit value=Save  class='button'>
               <input type=button value=Cancel onclick=self.history.back()  class='button'></td></tr>
        	   </form></table>";
		 
	     echo "</div>";

	
			 
		 echo "</div>";	 
	 
		 
    	 break;  
	}
}
?>


