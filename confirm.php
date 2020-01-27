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
"Z:\06_php\ch9\eye-icon.png" 目のアイコンをダウンロードしてください
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script>  //目のiconでパスワードが表示される
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
	<ol>
	<li>必須項目が全てPOSTされてなければ3秒で前のページに戻る</li>
	<li>$_POSTをループしてh()関数に入れて戻り値を$clean配列に代入</li>
	<li>$clean 配列をループして 項目名 |  入力値のペアで表示</li>
	<li>SESSION変数に代入</li>
	<li>torok.phpへのリンクを作ってボタンっぽくする</li>
</ol>
<pre>どこかのページへリダイレクトさせる方法
		1. phpの header()関数 (文字を書き出す前なら使える)
		2. javascriptの  location.href="URL"
		3. htmlの meta refresh (秒数)