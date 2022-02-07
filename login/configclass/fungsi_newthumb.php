<?php

// Upload gambar untuk berita
function UploadPromoImageJPG($fupload_name){
	//direktori gambar
	$vdir_upload = "../../../foto_produk/";
	$vfile_upload = $vdir_upload . $fupload_name;

	//Simpan gambar dalam ukuran sebenarnya
	move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

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
function UploadPromoImagePNG($fupload_name){
	//direktori gambar
	$vdir_upload = "../../../foto_produk/";
	$vfile_upload = $vdir_upload . $fupload_name;
	//Simpan gambar dalam ukuran sebenarnya
	move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

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

?>
