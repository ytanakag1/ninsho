<?php 
$file_dir = 'upload/'; // このファイルからの相対
$file_path = $file_dir . $_FILES["uploadfile"]["name"];
$moto_path = $_FILES["uploadfile"]["tmp_name"];
$finfo = new finfo(); //p148の要点
$m = $finfo->file( $moto_path, FILEINFO_MIME_TYPE);
$mt=explode('/',$m); //$mtype[0]=image

if ( ($mt[1]=="jpeg" || $mt[1]=="png" || $mt[1]=="gif") && move_uploaded_file( $moto_path , $file_path) ) {
	echo $file_path;
}