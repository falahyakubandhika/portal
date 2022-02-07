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
	$aksi="modul/mod_versus/aksi_versus.php";
	switch($_GET[act])
	{
		default:
		echo "<h2>Board</h2>";  
			$sql  = mysql_query("SELECT * FROM tb_versus where id=1 limit 1");
			$r    = mysql_fetch_array($sql);
		echo "<div id='profileTabList' class='tabs'>
				<a href='#tab2'>Versus</a>
			</div>
			<div id='profileTabData' class='both'>
				<div id='tab2' class='tab_content'>
					<form method=POST enctype='multipart/form-data' action=$aksi?module=versus&act=update>
						<input type=hidden name=id value=$r[id]>
						<table style='width:100%;'>
						<tr><td><textarea name='isi' style='width: 100%; height: 550px;' id='loko'>$r[versus_text]</textarea></td></tr>
						<tr><td><input type=submit value=Save  class='button'><input type=button value=Cancel onclick=self.history.back()  class='button'></td></tr>
						</table>
					</form>
				</div>
			</div>";
		break;  
	}
}
?>