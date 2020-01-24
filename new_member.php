<?php // 06_php/ch9/new_member.php
session_start();
	// 1 connect.php読み込み
require_once('connect.php');
	// 2 $tableの上書き
	$table_name='premember';

	// 3 POST値がある,なしの分岐

	if( !empty($_POST['user_email']) && !empty($_POST['himitsu']) && $_POST['himitsu']==$_SESSION['himitsu'] ){
	  // あるばあい  4 トークン発行(URLパラメータになる)
	  $parametor = token();
		  // 5 メールでDB検索
	  $sql = "select email from $table_name where email = ?";
	  	 $stmh = $dbh->prepare($sql);
			 $stmh->bindValue(1,$_POST['user_email'],PDO::PARAM_STR);
			 $stmh->execute(); 
				if( $stmh->rowCount()>0 ){
		  	// 1行以上あるならその行にUPDATE文
					$sql = "UPDATE $table_name 
					SET parametor = $parametor ,
					WHERE email = ?";
					$stmh->bindValue(1,$_POST['user_email'],PDO::PARAM_STR);
				}else{
		  	// ないなら INSERT文
					$sql="INSERT INTO $table_name (email,parametor)
          VALUES ( ? , ?)";
    // var_dump($sql,$_POST['user_email'],$parametor);      
          $stmh = $dbh->prepare($sql);
          $stmh->bindValue(1,$_POST['user_email'],PDO::PARAM_STR);
          $stmh->bindValue(2,$parametor,PDO::PARAM_STR);
          $stmh->execute(); 
				}
		  // 6 メール送信 signup.php?parametor=***&email=***@**のURLが本文
			$body = '本登録するには次のリンクをクリックしてください｡'."\r\n";
			$body .=  $_SERVER["SERVER_NAME"];
			$body .= dirname($_SERVER['SCRIPT_NAME']);
			$body .= '/signup.php?parametor='. $parametor;
			$body .= '&email='. $_POST['user_email'];
			$header = 'From: webmaster@example.com';
			mb_send_mail($_POST['user_email'],'本登録のURL',$body,$header);
		echo "<p>送信いただいたメール宛に本登録のURLを送信しました"	;
		// このサーバーはメールが送れないので画面に表示する
		echo "<p>本登録のURL= $body</p>";
	}else{
	  // POST値がない 7 メールとボタンだけのフォームの表示 	
	  $_SESSION['himitsu']=token(9);
?>
<form id="fm" method="post" >
	<p><label>Eメール: </label><input type="email" id="user_email" name="user_email" required>
	<div id="alert"><!--ここにメッセージが埋め込まれる--></div>

	<p><input id="submit_btn" type="button" value="本登録のURLを要求">
	<input type="hidden" name="himitsu" value="<?=$_SESSION['himitsu']?>">
</form>
<?php		

	}

// 8 古い(24時間経過した)パラメータの行を削除
$sql="DELETE FROM $table_name 
	WHERE reg_date < ( now() - INTERVAL 1 DAY )" ;
	// mysql でタイムスタンプ,PHPでタイムスタンプ 結果は同じ
$stmh = $dbh->prepare($sql);
$stmh->execute(); 

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
//  $('#user_email').change(function(){
 $('#submit_btn').click(function(){
	// $(document).on("click", "#submit_btn", function () {
//POSTメソッドで送るデータを定義する
//var data = {パラメータ : 値};
	var email = { request : $('#user_email').val() };

	$.ajax({
		type: "POST",  // HTTP通信の種類
		url: "ajax-mailcheck.php", // リクエスト送信先のURL
		data: email, // サーバに送信する値
		//Ajax通信が成功した場合に呼び出されるメソッド
		success: function(data, dataType){
			// dataはphpから書き出された文字列
			if(data != ""){
				$('#alert').html(data);
				return false;
			}else{
				// return true;
				// $('#submit_btn').attr('type','submit').attr('id','submit');
				$('#alert').html('');
				$('#fm').submit();
			}

		},
		//Ajax通信が失敗した場合に呼び出されるメソッド
		error: function(XMLHttpRequest, textStatus, errorThrown){
			console.log(data);
			return false;
		}
	});
	 return false;
});

</script>