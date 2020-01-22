<?php
session_start();
if (!empty($_POST['email'])) {
	//セッションにIPが保存されていないこと
// var_dump($_SESSION['user_ip']);	
	if (@$_SESSION['user_ip'][0]==$_SERVER['REMOTE_ADDR']
	&& @$_SESSION['user_ip'][1]==$_POST['email']
	&& @$_SESSION['user_ip'][2] > 2
	) exit("<p>連続送信は禁止</p>");
		
 mail($_POST['email'],"サイト名","パスワードを設定するには以下のアドレスへ移動してください
 	\n<http://localhost/ninsho/regist.php>");
 echo "<p>送信完了しました,受信フォルダを開いて登録を継続してください";
 
 if(empty($_SESSION['user_ip'])){
 //送信後にセッションに保存(なければ)
	$_SESSION['user_ip'][0]=$_SERVER['REMOTE_ADDR'];
		$_SESSION['user_ip'][1]=$_POST['email'];
		$_SESSION['user_ip'][2]=1;
 }else{
 	$_SESSION['user_ip'][2]++ ; //カウントアップする
 }
		
}
?>
<h2>サインアップ</h2>
<form action="" method="post">
	<label>メールアドレス<small>(必須)</small></label>
	<input type="email" name="email" id="" required>
	<input type="submit" value="次へ進む">
</form>
