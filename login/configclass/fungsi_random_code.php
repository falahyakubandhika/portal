<?php
function createCode($length) {
	$chars = "234567890abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$i = 0;
	$code = "";
	while ($i <= $length) {
		$code .= $chars{mt_rand(0,strlen($chars))};
		$i++;
	}
	return $code;
}
 
//$password = createPassword(8);
//echo "Your 8 character password is: $password";
 
?>