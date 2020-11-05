<?php session_start();
	if( empty($_SESSION['post'])) 
		// セッションがなければ 登録画面に速攻でリダイレクト
		header('Location: new_member.php');
	
 ?>
本登録  "Z:\06_php\ch9\torok.php" 保存しました｡
	1.DBに1件挿入
		・パスワードはハッシュ化して保存
	2.本登録完了メール送信,ユーザーと管理者へ
	3.ログインセッションとクッキーを保存
	4.会員サイトのTOPへリダイレクト (ヘッダーに ようこそ〇〇さん)
<?php 
	require_once('connect.php');
$table_name = 'member';
$field=implode(',' , $fieldName);
// last_name, first_name, age 配列をカンマで連結した文字列になる
$cnt = count($fieldName);            // 3
$pl = array_fill( 0, $cnt , "?") ;// 配列を同じ値で埋める 
$plstr = implode(',' ,$pl);     // ?,?,?
// パスワードハッシュに入れ替える
// var_dump($fieldName); exit;

$_SESSION['post']['user_password']=password_hash(
	$_SESSION['post']['user_password'], PASSWORD_DEFAULT);

try {
  $dbh->beginTransaction();
  $sql = "
  INSERT INTO $table_name ( $field ) VALUES ( $plstr )";
//  名前付きプレースホルダ(入れ物)より ?プレースホルダが楽
  $stmh = $dbh->prepare($sql);
  // プリペアドステートメント → 実行前の構文チェック
  foreach($fieldName as $i=>$v){
    $stmh->bindValue( $i+1 
    , $_SESSION['post'][ $v ]
    , $wamei[$v]['bind'] );    // PDO::PARAM_STR
  }
  // バインド機構 入れ物 結束して値を入れてやる
  $stmh->execute(); // クエリの実行

  $dbh->commit(); // 全て確実に実行できるなら実行
 
  //セッションは破棄
  //ログインセッションを作る
  	$_SESSION['login']['profile_image']= $_SESSION['post']['profile_image'];
  	$_SESSION['login']['user_name']= $_SESSION['post']['user_name'];
  	$_SESSION['post']=null;
 echo "<p>ようこそ" , $_SESSION['login']['user_name'] ,"さん"
 	,'<img src="',$_SESSION['login']['profile_image'],'" width="150px" >';

} catch (PDOException $Exception) {
  $dbh->rollBack(); // 全てなかった事にする
  print "エラー：" . $Exception->getMessage();
}