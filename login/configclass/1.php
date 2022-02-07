    <?php  
    function watermarkImage ($SourceFile, $WaterMarkText, $DestinationFile) {   
       list($width, $height) = getimagesize($SourceFile); // Mendapatkan ukuran file   
       $image_p = imagecreatetruecolor($width, $height);  
       $image = imagecreatefromjpeg($SourceFile);  
       imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);   
       $black = imagecolorallocate($image_p, 0, 0, 255);  
       //$font = 'Aliquam.ttf'; // Menentukan font apa yang akan di gunakan, saya disini akan mengunakan Aliquam.ttf  
	   //$font ='arial.ttf';
	  $font = '../../images/arial.ttf';
       $font_size = 20; // Ukuran tulisan  
       imagettftext($image_p, $font_size, 0, 100, 200, $black, $font, $WaterMarkText); // menyisipkan watermark pada gambar dengan posisi 10 , 20 (x,y)  
       if ($DestinationFile<>'') {  
          imagejpeg ($image_p, $DestinationFile, 100);   
       } else {  
          header('Content-Type: image/jpeg');  
          imagejpeg($image_p, null, 100);  
       };  
       imagedestroy($image);   
       imagedestroy($image_p);   
	   //die();
    };  
    ?>  