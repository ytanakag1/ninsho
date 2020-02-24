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
          echo "<strong>!</strong><p>入力されたメールアドレスはすでに登録済みです。<br>\n
                    ログインするか,パスワードリセットを要求してください。</p>";
       }  
  