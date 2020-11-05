<?php  
function h($p){
	$p = htmlspecialchars($p);
	$p = str_replace( ' ','' , $p ); //半角空白除去
	$p = str_replace( ',','、' , $p ); //半角カンマ置換
	return $p;
}	