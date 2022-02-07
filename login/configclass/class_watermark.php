<?php

class watermark {
   public static function emboss($pic1, $patt) {

      //header("Content-type: image/png");
      $source = imagecreatefromjpeg($pic1); // Source
      //$pattern = imagecreatefromjpeg($patt); // pattern
	  $pattern = imagecreatefromjpeg($patt); // pattern

      list ($width, $height) = getimagesize($pic1);
      list ($widthpatt, $heightpatt) = getimagesize($patt);

      $new_width = $width;
      $new_height = $width / $widthpatt * $heightpatt;

      if ($new_height > $height) {
    $offset = intval(($new_height - $height) / 2);
      }elseif ($new_height < $height) {
    $offset = intval(($new_height - $height) / 2);
       } else {
       $offset = 0;
        }

    $image_p = imagecreatetruecolor($new_width, $new_height);
    $pattern = imagecreatefromjpeg($patt);
     imagecopyresampled($image_p, $pattern, 0, 0, 0, 0, $new_width, $new_height, $widthpatt, $heightpatt);

    $im = imagecreatetruecolor($width, $height);
        for ($y = 0; $y < $height; $y ++) {
       for ($x = 0; $x < $width; $x ++) {
         $colors = imagecolorsforindex($source, imagecolorat($source, $x, $y));
         $pattern_color = imagecolorsforindex($image_p, imagecolorat($image_p, $x, ($y + $offset)));
        
        //changes brightness depending on luminance
        if (($y + $offset +1) > 0 && ($y + $offset) < ($new_height -1)) {
          $brightness = abs(($pattern_color['red'] * 50 / 255) - 50);
		  
           if ($pattern_color['red'] < 150) {
             $change = true;
           } else {
              $change = false;
              $tally = 0;
           }

           if ($change && $tally < 2) {
             $highlight = 1.8;
             $tally ++;
           } else {
             $highlight = 1;
           }
           $brightness = $brightness * $highlight;
        } else {
            $brightness = 0;
        }
        $r = (($colors['red'] + $brightness) > 255) ? 255 : ($colors['red'] + $brightness);
        $g = (($colors['green'] + $brightness) > 255) ? 255 : ($colors['green'] + $brightness);
        $b = (($colors['blue'] + $brightness) > 255) ? 255 : ($colors['blue'] + $brightness);
        $test = imagecolorallocate($im, $r, $g, $b);
        imagesetpixel($im, $x, $y, $test);
       }
        }

    imagepng($im,$pic1);
    imagedestroy($im);
   }
}


?>
