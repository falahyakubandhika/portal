<?php
//include "../subdomain.php";
function getnodoc($id){
	$ssql = "SELECT CONCAT(kd_doc,'-',LPAD(last_number + 1, 7,'0')) AS no_doc
				FROM tb_doc
				WHERE id_doc = $id";

	$result = mysql_query($ssql);	
	$rnodoc = mysql_fetch_array($result, MYSQL_ASSOC);   
	$no_doc = $rnodoc["no_doc"];   
	return $no_doc;
}

//Fungsi Counter No Doc
function counterdoc($id){
  	$sql=mysql_query("SELECT last_number FROM tb_doc
						WHERE id_doc='$id' limit 1");
  	$r=mysql_fetch_array($sql); 
	$last_number=$r['last_number'] + 1;
	
	mysql_query("UPDATE tb_doc SET last_number='$last_number' WHERE id_doc='$id' ");
	
	return;
}

function getCodeMember($param){
	
	$ssql = "SELECT CONCAT(DATE_FORMAT(NOW(),'%d%m%y'), LPAD(id + 1, 4,'0')) AS no_doc
			FROM kustomer   
			WHERE id = " . $param;
	$result = mysql_query($ssql);
	$rnodoc = mysql_fetch_array($result, MYSQL_ASSOC);   
	$no_doc = $rnodoc["no_doc"];   
	
	return $no_doc;
}

?>