<?php
  // Ajaxリクエストの場合のみ処理する
  if(empty( $a= $_POST['request'])) exit;
  
  include "connect.php" ;
    $sql = "SELECT email FROM member 
              WHERE email = ?";
    $sth = $dbh->prepare($sql);
    $sth->bindValue( 1, $a, PDO::PARAM_STR );
    $sth->execute();
    
    if( $sth->rowCount() > 0 ){
          // 0じゃなければ 
          echo $sql,$a,"<strong>!</strong>このメールアドレスは会員登録済みです。<br>\n
          ログインするか,他のメールアドレスにしてください";
       }  
  