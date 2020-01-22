<?php
	$dbname = "sampledb"; //引数を上書き
	$host = 'localhost';
	$user = 'ginzo';
	$psw =  'wert3333';
 		$mydb = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

	try{
		$dbh=new PDO($mydb,$user,$psw ); //DBへ接続
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// PDOのエラーモードを追加してください
		$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		// 構文チェックと実行を分離したままにする 必須
		$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // メモリ効率がいい
			return $dbh;
	} catch (PDOException $e) {
		die('ConneCt Error: ' .$e->getCode()); //DB接続エラー時の処理
	}


	// トークン作成のための関数
function token($length = 20){  	
	return substr(str_shuffle('1234567890QWERTYUIOPLKJHGFDSAZXCVBNMabcdefghijklmnopqrstuvwxyz'), 0, $length);
}