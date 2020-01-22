<?php
session_start();
include "connect.php" ;

if(!empty( $_POST['user_name']) && !empty( $_POST['user_password'])
  && $_SESSION['himitsu']==$_POST['himitsu'] 
  && $_SESSION['himitsu2']!=$_POST['himitsu']  ){
 
    $sql="select user_name ,profile_image ,email ,user_password 
    from member where  user_name = ?";
    $sth = $dbh->prepare($sql);
    $sth->bindValue( 1, $_POST['user_name'], PDO::PARAM_STR );
    $sth->execute();
      $result = $sth->fetchAll();  // 配列へ
      if(count($result)){
       //パスワードがハッシュにマッチするか
        if(password_verify($_POST['user_password'], $result[0]['user_password'])){
            echo '認証成功';
        }else{
            echo '認証失敗 パスワードが違います';
        }
        
      }else{
        echo "認証できません,ユーザー名がありません";
      }
 //二重送信防止,トークン再発行
    $_SESSION['himitsu2'] = $_POST['himitsu'];
    $_SESSION['himitsu']= token();
}else{
  //何も送信していない場合
  $_SESSION['himitsu']= token();
  $_SESSION['himitsu2'] = "";
}


?>

<form method="post">
<p>user_name: <input type="text"name="user_name">
<p>password: <input type="password"name="user_password">
  <input type="hidden" name="himitsu" value="<?=$_SESSION['himitsu']?>">
<p>  <input type="submit" value="ログイン">
</form>
