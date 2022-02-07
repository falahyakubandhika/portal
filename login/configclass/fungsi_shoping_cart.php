<?php
$sessionID = $_COOKIE['PHPSESSID'];

function getBasket(){
	
	$sessionID = $_COOKIE['PHPSESSID'];
	
	$query  = "SELECT * FROM orders_temp WHERE id_session = '" . $sessionID . "' GROUP BY id_produk ORDER By id_orders_temp DESC";
	$result = mysql_query($query);
	//echo $query;
	
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		
		$query2  = "SELECT * FROM produk WHERE id_produk = " . $row['id_produk']; 
		//echo $query2;
		
		$result2 = mysql_query($query2);
		$row2 = mysql_fetch_array( $result2 );
	
		$productID		= $row2['id_produk'];
		$Price 			= $row2['harga'];
		$discount 		= $row2['diskon'];	
		$disc       	= ($price*$discount) / 100; //($discount/100)*$Price;
    	$productPrice   = ($Price-$disc);
		$productName	= $row2['nama_produk'];	
	
		$query2  = "SELECT jumlah AS totalItems FROM orders_temp WHERE id_session = '" . $sessionID . "' AND id_produk = " . $productID;
		$result2 = mysql_query($query2);
		$row2 = mysql_fetch_array( $result2 );
		$totalItems = $row2['totalItems'];
		$basketText = $basketText . '<li id="productID_' . $productID . '">
									<a href=inc/functions.php?action=deleteFromBasket&productID=' . $productID . ' onClick="return false;"><img src="js/sliding-basket/images/delete.png" id="deleteProductID_' . $productID . '"></a> ' . $productName . '(' . $totalItems . ' items) - Rp. <span class="productPrice">' . ($totalItems * $productPrice) . '</span></li>';
		
	}
	echo $basketText;
}
	

?>