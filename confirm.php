<?php 
	session_start(); 
	include_once("connect.php");
?>
送信データの確認画面 confirm.php
	DBに値が入るので htmlspecialcharsに
	半角カンマ,スペース 除去も加える (SQLインジェクション対策)
	<link rel="stylesheet" href="style.css">
<h2>確認してください</h2>


<?php
if( empty($_POST['user_password']) || empty($_POST['user_name']) || empty($_POST['seimei']) || empty($_POST['email'])) {
	echo "<meta http-equiv='Refresh' content='3; url=signup.php' />";
	echo '<p>必須項目が入力されていません 3秒後にもとに戻ります</p>';
	exit;  //一応処理の中断も書いておく
}
// 2 POST値を無害化し$cleanへ
 foreach($_POST as $k => $v) $clean[$k] = h($v);
// var_dump($clean); 
// 3 $cleanをループして画面表示 /06_php/ch9/confirm.php
 foreach ($wamei as $k => $v) {
		 
	 if( $k == 'user_password'){
	 	// パスワードのときは非表示にするので分岐する
		 echo "<li>" , $v['label'] , " : 
		 <input type='password' class='cpswd' disabled value='", $clean[$k] ," '> 
		 <a id='see'><img src='eye-icon.png'></a>
		 <a id='hide'><img src='eye-see-icon.png'></a>";
		}else{
			echo "<li>" , $v['label'] , " : ", $clean[$k];
	 }
 }

// SESSIONに保存 他のセッションもあるので['post']に入れる
	$_SESSION['post'] = $clean;
//Buttonを作ってリンクにする
?>	
	<p><button onclick="location.href='torok.php'">
		この内容で送信する
	</button>

<p>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script>  //目のiconでパスワードが表示される push requestのための更新
	$('#see').click(function(){
		$( '[type="password"]').attr('type','text');
		$(this).hide();
		$('#hide').show();
	}	);

	$('#hide').click(function(){
		$( '[type="text"]').attr('type','password');
		$(this).hide();
		$('#see').show();
	}	);
</script>