<?php

/************* Logo Perusahaan JPG & PNG *************************/
function UploadImageJPG_Logo($fupload_name){
  //direktori gambar
  $vdir_upload = "../../../images/logo/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);
  
   $dst_width = $src_width;
   $dst_height = $src_height;
   
    //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im,$vdir_upload . $fupload_name);
  
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
}

function UploadImagePNG_Logo($fupload_name){
  //direktori gambar
  $vdir_upload = "../../../images/logo/";
  $vfile_upload = $vdir_upload . $fupload_name;
  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //======== Mulai Merubah ukuran small
  //identitas file asli
  $im_src = imagecreatefrompng($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);
  
  $dst_width = $src_width;
  $dst_height = $src_height;
   
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagealphablending($im, false);
  imagesavealpha($im,true);
  $transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
  imagefilledrectangle($im, 0, 0, $dst_width, $dst_height, $transparent);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
  //Simpan gambar
  imagepng($im,$vdir_upload .  $fupload_name);
   
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
}
/************* End Of Logo Perusahaan JPG & PNG *************************/



/*--- Upload Logo Perusahaan --------*/
function UploadLogo($fupload_name){
  $vdir_upload = "../../../images/logo/";
  $vfile_upload = $vdir_upload . $fupload_name;
  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}

	/* Upload Multiple Image Product */
		function UploadImageJPG_Product_Multiple($fupload_name)
		{
			//direktori gambar
			$vdir_upload = "../../../images/product/";
			$vfile_upload = $vdir_upload . $fupload_name;
			move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
			// *** Include the class
			include_once("resize-class.php");
			// *** 1) Initialise / load image
			$resizeObj = new resize($vfile_upload);
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage(680, 467, 'crop');
			// *** 3) Save image
			$resizeObj -> saveImage($vfile_upload, 100);
		}
		function UploadImagePNG_Product_Multiple($fupload_name)
		{
			//direktori gambar
			$vdir_upload = "../../../images/product/";
			$vfile_upload = $vdir_upload . $fupload_name;
			move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
			// *** Include the class
			include_once("resize-class.php");
			// *** 1) Initialise / load image
			$resizeObj = new resize($vfile_upload);
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage(680, 467, 'crop');
			// *** 3) Save image
			$resizeObj -> saveImage($vfile_upload, 100);
		}
		/////////////////////detail start
		function UploadImageJPG_Detail_Multiple($fupload_name)
		{
			//direktori gambar
			$vdir_upload = "../../../images/detail/";
			$vfile_upload = $vdir_upload . $fupload_name;
			move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
			// *** Include the class
			include_once("resize-class.php");
			// *** 1) Initialise / load image
			$resizeObj = new resize($vfile_upload);
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage(680, 467, 'crop');
			// *** 3) Save image
			$resizeObj -> saveImage($vfile_upload, 100);
		}
		function UploadImagePNG_Detail_Multiple($fupload_name)
		{
			//direktori gambar
			$vdir_upload = "../../../images/detail/";
			$vfile_upload = $vdir_upload . $fupload_name;
			move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
			// *** Include the class
			include_once("resize-class.php");
			// *** 1) Initialise / load image
			$resizeObj = new resize($vfile_upload);
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage(680, 467, 'crop');
			// *** 3) Save image
			$resizeObj -> saveImage($vfile_upload, 100);
		}
		/////////////////////detail end
		function UploadImageJPG_exhibitions($fupload_name)
		{
			//direktori gambar
			$vdir_upload = "../../../images/exhibitions/";
			$vfile_upload = $vdir_upload . $fupload_name;
			move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
			// *** Include the class
			include_once("resize-class.php");
			// *** 1) Initialise / load image
			$resizeObj = new resize($vfile_upload);
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage(700, 700, 'crop');
			// *** 3) Save image
			$resizeObj -> saveImage($vfile_upload, 100);
		}
		function UploadImagePNG_exhibitions($fupload_name)
		{
			//direktori gambar
			$vdir_upload = "../../../images/exhibitions/";
			$vfile_upload = $vdir_upload . $fupload_name;
			move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
			// *** Include the class
			include_once("resize-class.php");
			// *** 1) Initialise / load image
			$resizeObj = new resize($vfile_upload);
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage(700, 700, 'crop');
			// *** 3) Save image
			$resizeObj -> saveImage($vfile_upload, 100);
		}
		function UploadImageJPG_Banner($fupload_name)
		{
			$vdir_upload = "../../../images/banner/";
			$vfile_upload = $vdir_upload . $fupload_name;
			//Simpan gambar dalam ukuran sebenarnya
			move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
		}
		function UploadImagePNG_Banner($fupload_name)
		{
			$vdir_upload = "../../../images/banner/";
			$vfile_upload = $vdir_upload . $fupload_name;
			//Simpan gambar dalam ukuran sebenarnya
			move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
		}


		function UploadImageJPG_Team($fupload_name)
		{
			$vdir_upload = "../../../images/team/";
			$vfile_upload = $vdir_upload . $fupload_name;
			//Simpan gambar dalam ukuran sebenarnya
			move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
		}
		function UploadImagePNG_TEam($fupload_name)
		{
			$vdir_upload = "../../../images/team/";
			$vfile_upload = $vdir_upload . $fupload_name;
			//Simpan gambar dalam ukuran sebenarnya
			move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
		}
		/* Upload Product Image for Related Product  based on Color size 50x50 */
		function UploadImageJPG_Product_Related($fupload_name)
		{
 				 //direktori gambar
 				 $vdir_upload = "../../../images/product/";
				 $vfile_upload = $vdir_upload . $fupload_name;
				 
				  move_uploaded_file($_FILES["fupload_icon"]["tmp_name"], $vfile_upload);
				 
				 //identitas file asli
 				 $im_src = imagecreatefromjpeg($vfile_upload);
  				 $src_width = imageSX($im_src);
  				 $src_height = imageSY($im_src);
				 
				$dst_width = 50;
				$dst_height = 65;
				  
 			  //proses perubahan ukuran
 				  $im = imagecreatetruecolor($dst_width,$dst_height);
  				  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

 				  //Simpan gambar
  				  imagejpeg($im,$vdir_upload . $fupload_name); 
  
  				  //Hapus gambar di memori komputer
 				  imagedestroy($im_src);
  				  imagedestroy($im);
		}
		
		function UploadImagePNG_Product_Related($fupload_name)
		{
 			 //direktori gambar
 			 $vdir_upload = "../../../images/product/";
  			 $vfile_upload = $vdir_upload . $fupload_name;
  			 //Simpan gambar dalam ukuran sebenarnya
			 move_uploaded_file($_FILES["fupload_icon"]["tmp_name"], $vfile_upload);

 			 //======== Mulai Merubah ukuran small
			 //identitas file asli
  			 $im_src = imagecreatefrompng($vfile_upload);
 			 $src_width = imageSX($im_src);
 			 $src_height = imageSY($im_src);
			 
			 
			// $dst_width = 250;
			// $dst_height = 333;
				  
 			//proses perubahan ukuran
  			$im = imagecreatetruecolor($dst_width,$dst_height);
 			imagealphablending($im, false);
  			imagesavealpha($im,true);
 			$transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
  			imagefilledrectangle($im, 0, 0, $dst_width, $dst_height, $transparent);
 			imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
  			//Simpan gambar
 			imagepng($im,$vdir_upload . $fupload_name);
			
			//Hapus gambar di memori komputer
			imagedestroy($im_src);
			imagedestroy($im);
		}

/* End Upload Multiple Image Product */



/* ----------Upload Single Image Product --------------------------------------------*/
function UploadImageJPG_Product($fupload_name)
{
	//direktori gambar
	$vdir_upload = "../../../images/product/";
	$vfile_upload = $vdir_upload . $fupload_name;
	move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
	// *** Include the class
	include_once("resize-class.php");
	// *** 1) Initialise / load image
	$resizeObj = new resize($vfile_upload);
	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(680, 467, 'crop');
	// *** 3) Save image
	$resizeObj -> saveImage($vfile_upload, 100);
}
function UploadImagePNG_Product($fupload_name)
{
	//direktori gambar
	$vdir_upload = "../../../images/product/";
	$vfile_upload = $vdir_upload . $fupload_name;
	move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
	// *** Include the class
	include_once("resize-class.php");
	// *** 1) Initialise / load image
	$resizeObj = new resize($vfile_upload);
	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(680, 467, 'crop');
	// *** 3) Save image
	$resizeObj -> saveImage($vfile_upload, 100);
}
/*--------------------- Upload Main Image Product -------------------------*/




/*--------------------- Upload Foto Article -------------------------*/
function UploadImageJPG_Article($fupload_name){
  //direktori gambar
  $vdir_upload = "../../../images/article/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 110 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 110;
  $dst_height = ($dst_width/$src_width)*$src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im,$vdir_upload . "small_" . $fupload_name);
  

  //Simpan dalam versi medium 360 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width2 = 300;
  $dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im2,$vdir_upload . "medium_" . $fupload_name);
  
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}

function UploadImagePNG_Article($fupload_name){
  //direktori gambar
  $vdir_upload = "../../../images/article/";
  $vfile_upload = $vdir_upload . $fupload_name;
  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //======== Mulai Merubah ukuran small
  //identitas file asli
  $im_src = imagecreatefrompng($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);
  //Simpan dalam versi small 110 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 110;
  $dst_height = ($dst_width/$src_width)*$src_height;
  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagealphablending($im, false);
  imagesavealpha($im,true);
  $transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
  imagefilledrectangle($im, 0, 0, $dst_width, $dst_height, $transparent);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
  //Simpan gambar
  imagepng($im,$vdir_upload . "small_" . $fupload_name);
  //========= akhir perubahan ukuran small
  
  
  //========= Mulai merubah ukuran medium
  //Simpan dalam versi medium 360 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width2 = 300;
  $dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  imagealphablending($im2, false);
  imagesavealpha($im2,true);
  $transparent = imagecolorallocatealpha($im2, 255, 255, 255, 127);
  imagefilledrectangle($im2, 0, 0, $dst_width, $dst_height, $transparent);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);
  //Simpan gambar
  imagepng($im2,$vdir_upload . "medium_" . $fupload_name);
  
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
/*--------------------- Upload Foto Article -------------------------*/

/*--------------------- Upload Foto Slideshow -------------------------*/
function UploadImageJPG_Slide($fupload_name){
  //direktori gambar
  $vdir_upload = "../../../images/slide/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);
  
  $dst_width = 1280;
  $dst_height = 500;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
  //Simpan gambar
  imagejpeg($im,$vdir_upload  . $fupload_name);
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
}

function UploadImagePNG_Slide($fupload_name){
  //direktori gambar
  $vdir_upload = "../../../images/slide/";
  $vfile_upload = $vdir_upload . $fupload_name;
  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //======== Mulai Merubah ukuran small
  //identitas file asli
  $im_src = imagecreatefrompng($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);
  
  $dst_width = 1280;
  $dst_height = 500;
  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagealphablending($im, false);
  imagesavealpha($im,true);
  $transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
  imagefilledrectangle($im, 0, 0, $dst_width, $dst_height, $transparent);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
  //Simpan gambar
  imagepng($im,$vdir_upload . $fupload_name);
  
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
}
/*--------------------- Upload Foto Slideshow -------------------------*/

// Upload gambar untuk berita
function UploadImageProdukJPG($fupload_name,$i){
  //direktori gambar
  $vdir_upload = "../../../foto_produk/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"][$i], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 155 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 140;
  $dst_height = ($dst_width/$src_width)*$src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im,$vdir_upload . "small_" . $fupload_name);
  

  //Simpan dalam versi medium 360 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width2 = 320;
  $dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im2,$vdir_upload . "medium_" . $fupload_name);
  
  $dst_width2 = 460;
  $dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  $im3 = imagecreatetruecolor($dst_width2,$dst_height2);
  imagealphablending($im3, false);
  imagesavealpha($im3,true);
  $transparent = imagecolorallocatealpha($im2, 255, 255, 255, 127);
  imagefilledrectangle($im3, 0, 0, $dst_width, $dst_height, $transparent);
  imagecopyresampled($im3, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);
  //Simpan gambar
  imagepng($im3,$vdir_upload . "big_" . $fupload_name);
    
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
  imagedestroy($im3);
}

// Upload gambar untuk berita
function UploadImageProdukPNG($fupload_name,$i){
  //direktori gambar
  $vdir_upload = "../../../foto_produk/";
  $vfile_upload = $vdir_upload . $fupload_name;
  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"][$i], $vfile_upload);

  //======== Mulai Merubah ukuran small
  //identitas file asli
  $im_src = imagecreatefrompng($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);
  //Simpan dalam versi small 155 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 140;
  $dst_height = ($dst_width/$src_width)*$src_height;
  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagealphablending($im, false);
  imagesavealpha($im,true);
  $transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
  imagefilledrectangle($im, 0, 0, $dst_width, $dst_height, $transparent);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
  //Simpan gambar
  imagepng($im,$vdir_upload . "small_" . $fupload_name);
  //========= akhir perubahan ukuran small
  
  
  //========= Mulai merubah ukuran medium
  //Simpan dalam versi medium 360 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width2 = 320;
  $dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  imagealphablending($im2, false);
  imagesavealpha($im2,true);
  $transparent = imagecolorallocatealpha($im2, 255, 255, 255, 127);
  imagefilledrectangle($im2, 0, 0, $dst_width, $dst_height, $transparent);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);
  //Simpan gambar
  imagepng($im2,$vdir_upload . "medium_" . $fupload_name);
  
  $dst_width2 = 460;
  $dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  $im3 = imagecreatetruecolor($dst_width2,$dst_height2);
  imagealphablending($im3, false);
  imagesavealpha($im3,true);
  $transparent = imagecolorallocatealpha($im2, 255, 255, 255, 127);
  imagefilledrectangle($im3, 0, 0, $dst_width, $dst_height, $transparent);
  imagecopyresampled($im3, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);
  //Simpan gambar
  imagepng($im3,$vdir_upload . "big_" . $fupload_name);
    
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
  imagedestroy($im3);
}


function UploadKategoriProduk($fupload_name){
  //direktori gambar
  $vdir_upload = "../../../foto_produk/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}

function UploadImageJPG_Subcategory($fupload_name)
		{
			//direktori gambar
			$vdir_upload = "../../../images/subcategory/";
			$vfile_upload = $vdir_upload . $fupload_name;

			move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

			// *** Include the class
			include_once("resize-class.php");

			// *** 1) Initialise / load image
			$resizeObj = new resize($vfile_upload);

			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage(680, 467, 'crop');

			// *** 3) Save image
			$resizeObj -> saveImage($vfile_upload, 100);
		}
		function UploadImagePNG_Subcategory($fupload_name)
		{
			//direktori gambar
			$vdir_upload = "../../../images/subcategory/";
			$vfile_upload = $vdir_upload . $fupload_name;

			move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

			// *** Include the class
			include_once("resize-class.php");

			// *** 1) Initialise / load image
			$resizeObj = new resize($vfile_upload);

			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage(680, 467, 'crop');

			// *** 3) Save image
			$resizeObj -> saveImage($vfile_upload, 100);
		}
		function UploadFileBrochure($fupload_name){
  //direktori file
  $vdir_upload = "../../../files/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan file
  move_uploaded_file($_FILES["ffile"]["tmp_name"], $vfile_upload);
}

/*--------------------- Upload Foto catdetail -------------------------*/
function UploadImageJPG_catdetail($fupload_name){
  //direktori gambar
  $vdir_upload = "../../../../images/catdetail/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 110 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 110;
  $dst_height = ($dst_width/$src_width)*$src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  //gakperlu--- imagejpeg($im,$vdir_upload . "small_" . $fupload_name);
  

  //Simpan dalam versi medium 360 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width2 = 300;
  $dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  //gakperlu--- imagejpeg($im2,$vdir_upload . "medium_" . $fupload_name);
  
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}

function UploadImagePNG_catdetail($fupload_name){
  //direktori gambar
  $vdir_upload = "../../../../images/catdetail/";
  $vfile_upload = $vdir_upload . $fupload_name;
  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //======== Mulai Merubah ukuran small
  //identitas file asli
  $im_src = imagecreatefrompng($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);
  //Simpan dalam versi small 110 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 110;
  $dst_height = ($dst_width/$src_width)*$src_height;
  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagealphablending($im, false);
  imagesavealpha($im,true);
  $transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
  imagefilledrectangle($im, 0, 0, $dst_width, $dst_height, $transparent);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
  //Simpan gambar
  //gakperlu--- imagepng($im,$vdir_upload . "small_" . $fupload_name);
  //========= akhir perubahan ukuran small
  
  
  //========= Mulai merubah ukuran medium
  //Simpan dalam versi medium 360 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width2 = 300;
  $dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  imagealphablending($im2, false);
  imagesavealpha($im2,true);
  $transparent = imagecolorallocatealpha($im2, 255, 255, 255, 127);
  imagefilledrectangle($im2, 0, 0, $dst_width, $dst_height, $transparent);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);
  //Simpan gambar
  //gakperlu--- imagepng($im2,$vdir_upload . "medium_" . $fupload_name);
  
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
/*--------------------- Upload Foto catdetail -------------------------*/

/*--------------------- Upload Foto catgal -------------------------*/
function UploadImageJPG_catgal($fupload_name){
  //direktori gambar
  $vdir_upload = "../../../images/gallery/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 110 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 110;
  $dst_height = ($dst_width/$src_width)*$src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  //gakperlu--- imagejpeg($im,$vdir_upload . "small_" . $fupload_name);
  

  //Simpan dalam versi medium 360 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width2 = 300;
  $dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  //gakperlu--- imagejpeg($im2,$vdir_upload . "medium_" . $fupload_name);
  
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}

function UploadImagePNG_catgal($fupload_name){
  //direktori gambar
  $vdir_upload = "../../../images/gallery/";
  $vfile_upload = $vdir_upload . $fupload_name;
  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //======== Mulai Merubah ukuran small
  //identitas file asli
  $im_src = imagecreatefrompng($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);
  //Simpan dalam versi small 110 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 110;
  $dst_height = ($dst_width/$src_width)*$src_height;
  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagealphablending($im, false);
  imagesavealpha($im,true);
  $transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
  imagefilledrectangle($im, 0, 0, $dst_width, $dst_height, $transparent);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
  //Simpan gambar
  //gakperlu--- imagepng($im,$vdir_upload . "small_" . $fupload_name);
  //========= akhir perubahan ukuran small
  
  
  //========= Mulai merubah ukuran medium
  //Simpan dalam versi medium 360 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width2 = 300;
  $dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  imagealphablending($im2, false);
  imagesavealpha($im2,true);
  $transparent = imagecolorallocatealpha($im2, 255, 255, 255, 127);
  imagefilledrectangle($im2, 0, 0, $dst_width, $dst_height, $transparent);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);
  //Simpan gambar
  //gakperlu--- imagepng($im2,$vdir_upload . "medium_" . $fupload_name);
  
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
/*--------------------- Upload Foto Gallery -------------------------*/



?>
