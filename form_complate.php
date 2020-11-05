<?php session_start();
// 1.POSTの必須確認
if( empty($_POST['himitsu']) || $_POST['himitsu']!=$_SESSION['himitsu'] ||
empty($_POST['user_name']) || empty($_POST['profile_image']) || empty($_POST['seimei']) || empty($_POST['phone']) || empty($_POST['email']) || empty($_POST['user_password'])){
  echo '<meta http-equiv="refresh" content="3; URL=\'regist.php\'" />';	
		echo "<a href='regist.php'>プロフィール登録フォーム</a>から正しく入力してください";
		exit();  // ここで中断
}else{

  require_once('connect.php');
  require_once('mojifilter.php');

  //パスワードハッシュ作成
  $hash = password_hash( $_POST['user_password'] , PASSWORD_DEFAULT  );

  try {
    $dbh->beginTransaction();
    $sql = "INSERT INTO member (user_name,profile_image,seimei,phone,email,user_password) VALUES ( ?,?,?,?,?,? )";
    $stmh = $dbh->prepare($sql);
  $i=0;
  
    $stmh->bindValue(++$i,  $_POST['user_name'], PDO::PARAM_STR );
    $stmh->bindValue(++$i, $_POST['profile_image'], PDO::PARAM_STR );
    $stmh->bindValue(++$i, $_POST['seimei'],  PDO::PARAM_STR );
    $stmh->bindValue(++$i, $_POST['phone'],  PDO::PARAM_STR );
    $stmh->bindValue(++$i, $_POST['email'],  PDO::PARAM_STR );
    $stmh->bindValue(++$i, $hash,  PDO::PARAM_STR );
    $stmh->execute();
    $dbh->commit();

    $user_id= $dbh->lastInsertId('user_id');
   
    //自動ログインのためのセッション保存
       setcookie('user_id' ,$user_id ,time()+3600*240,"/");
        $_SESSION['user_name']=$_POST['user_name'];
        $_SESSION['user_id']=$user_id;
        $_SESSION['hash']= password_verify( $_POST['user_password'], $hash);

        header('Location: new_member.php');   
  } catch (PDOException $Exception) {
    $dbh->rollBack();
    print "エラー：" . $Exception->getMessage();
  }
}
