<?php
header("Content-type: text/html; charset=UTF-8");
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])
   && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
  // Ajaxリクエストの場合のみ処理する
  if(!empty( $a= $_POST['user_name'])){
    include "connect.php" ;

    $sql = "SELECT count(*) as cnt FROM member 
              WHERE user_name = ?";
    $sth = $dbh->prepare($sql);
    $sth->bindValue( 1, $a, PDO::PARAM_STR );
    $sth->execute();
    
    $result = $sth->fetchAll();  // 配列へ
    $result_arr = $result[0];	 // 1行目を取り出す
    
      if ( $result_arr["cnt"] !==0 ) { //このフィールドには行数が入っている
          // 0じゃなければ 
          echo "<strong>!</strong>このニックネームは会員登録済みです。<br>\n
          他のニックネームにしてください";
       }  
  }else{
      echo 'The parameter of "request" is not found.';
  }
}