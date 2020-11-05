<?php
header("Content-type: text/plain; charset=UTF-8");
//Ajaxによるリクエストかどうかの識別を行う 
//strtolower()を付けるのは、XMLHttpRequestやxmlHttpRequestで返ってくる場合があるため

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){  
 
	if(!empty($_FILES["file_1"])){
		include "connect.php" ;

    $sql = "SELECT count(*) as cnt FROM member 
              WHERE profile_image = ?";
    $sth = $dbh->prepare($sql);
    $sth->bindValue( 1, $_FILES["file_1"]["name"], PDO::PARAM_STR );
    $sth->execute();
    
    $result = $sth->fetchAll();  // 2次元配列へ
    
      if ( $result[0]["cnt"] !==0 ) { //このフィールドには行数が入っている
          // 0じゃなければ 
          echo "<strong>!</strong>このファイル名は登録済みです。<br>\n
					他のファイル名にしてアップしてください";
					exit;
			 }  
//最終行の user_idを取得する SQL文		
		$sql="select user_id from member
					order by user_id desc
					limit 1 ;";	 
		$sth = $dbh->prepare($sql);
		$sth->execute();
		$result = $sth->fetchAll();
		$image_id = ++$result[0]['user_id'];  
			 
		$dirname = dirname(__FILE__);
	//var/www/html/ninsho/uploads/userProfile/
		
		$ft = explode("/",$dirname); //ファイルパスを/で分解し配列へ
			$savedir = $ft[0]."/".$ft[1]."/".$ft[2]."/".$ft[3]."/".$ft[4]."/uploads/userProfile/";
			$file_tmp  = $_FILES["file_1"]["tmp_name"];
			
			$file_name = $_FILES["file_1"]["name"];
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$file_name = 	str_replace($ext, $image_id.".".$ext, $file_name );
			// 正式保存先ファイルパス
			$file_save = $savedir. $file_name;
			
			// ファイル移動
			$result = @move_uploaded_file($file_tmp, $file_save);
			if ( $result === true ) {
					echo $file_name;
			} else {
					echo "UPLOAD NG";
			}
		}else{
			echo "UPLOAD NG";
		}
}