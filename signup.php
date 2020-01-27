<?php    // 06_php\ch9\sigunup.php

include_once("connect.php");    // connect.php をインクルード
//torokから戻ったときにこの下のifブロックはやらない
if( empty($_SESSION['post']['email'] )) //カラならtrue
//パラメータ無しで開かせない｡
  if( !empty($_GET['parametor']) && !empty($_GET['email'])){
    //あれば, prememberで検索して,emailが合っていることを確認→削除
    $sql="select email from premember where parametor = ? AND email = ?";
    $stmh = $dbh->prepare($sql);
    $stmh->bindValue(1,$_GET['parametor'],PDO::PARAM_STR);
    $stmh->bindValue(2,$_GET['email'],PDO::PARAM_STR);
    $stmh->execute(); 
    // ヒット数をカウント → あれば削除
      if( $stmh->rowCount() > 0 ){
        $result = $stmh->fetchAll();  // 配列にする
          $sql="DELETE FROM premember 
          WHERE parametor = ? "  ;
          $stmh = $dbh->prepare($sql);
          $stmh->bindValue(1,$_GET['parametor'],PDO::PARAM_STR);
          $stmh->execute(); 
      }else{ //parametor見つからない ならリダイレクトさせる
        header('Location: ./new_member.php'); exit;
      }

  }else{
    // prememberが無い,emailが違う場合もリダイレクト
    header('Location: ./new_member.php');  exit;
  }


// kenテーブルからすべて読み込む select文を書く
	$sql = "select * from ken"; 
// prepare → execute → 代入 $stmt
 $stmh = $dbh->prepare($sql);
  $stmh->execute();
  
// "Z:\06_php\ninsho\sampledb.sql"
?>

<link rel="stylesheet" href="style.css">

<p>前回作った $wamei配列をもっと効率化する
	フィールド名のキー=>[属性の配列]
</p>
<!-- 送信を止めるためreturn falseを受け取る -->
<form action="confirm.php" onsubmit="return chkpw()"method="post">
<?php  

// $stmt を回す
 echo "<p>都道府県:
 <select name='pref' >
 <option value=''>選択してください</option>"; 
  foreach($stmh as $k => $v){
 // optionを書き出す
   echo  "<option value={$v['id']} > {$v['ken']} </option>";
 } 
	echo "</select>";

	// #wameiからフォームを作る
	foreach ($wamei as $key => $value) {
		if($key == 'pref') continue;
      echo $value['type'] != 'hidden' ? "<p>{$value['label']} : " : ''; // hiddenならラベルはいらない
      echo "<input type='{$value['type']}' 
        name='{$key}' {$value['required']}  id='{$value['id']}' ";
      echo  $key == 'email' ? ' value="'. h($_GET['email']) .'"' : '';  //メールはhiddenなのでvalueが必要
      echo ">";
	}
?>

<p> と確認:<input type="password" id="pswd_conf">
<p>	<input type="submit" value="送信">
</form>

<button id="showImage">画像を送信する</button>


<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script> <!--jquery コピペ-->

<script>
	function chkpw(){
		var pswd = $('#pswd').val();
		var pswd_conf = $('#pswd_conf').val();
	// パターンマッチは matchメソッドで判定できる	
	// 2つのパスワードの照合を追加してみよう
		if(pswd.match(/(?=.{8,25})(?=.*\d+.*)(?=.*[a-zA-Z]+.*).*/) ){
			if(pswd == pswd_conf){
				return true;
			}else{
				alert("パスワードが一致しません");	return false;
			}
		}else{
			alert("8文字以上の英数字混在で");
			return false;
		}
	}

</script>
 <p>"06php/ch9/sigunup.php" ここにあるのでコピペ</p>
http://192.168.175.99/
		→ public/06_php/ch9/sigunup.php


<div id="myProfileImage">
	<form id="my_form">
  <label class="selectButton" >
  	<p class="plh">ここに画像送信をドロップ</p>
      <input type="file" name="uploadfile">
  </label>　  
    
  <div>
    <button type="button" id="fileSubmit" onclick="file_upload()">アップロード</button>
    <button type="cancel" id="canselSubmit">キャンセル</button>
  </div>
      <p>(最大5MBまで。JPG,GIF,PNGが使えます)</p>
</form>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script>
  //画像のアップ
function file_upload(){
  // カラなら送信を止める
  if( $('[type="file"]').val() =="") return;

  var formdata = new FormData($('#my_form').get(0));

  // POSTでアップロード
  $.ajax({
      url  : "view.php",
      type : "POST",
      data : formdata,
      cache       : false,
      contentType : false,  //content-typeヘッダを変換せず送信
      processData : false,  //dataをクエリ文字列に変換せずに送信
      dataType    : "html"
  })
  .done(function(data){
  	//この要素の下にimgを追加
  	$('#profile_image').after('<img>').val(data);
  	//追加した img にsrc属性
    $('#profile_image').next('img').attr('src',data).css({'width':'200px','height':'200px','display':'block'});
    $('#myProfileImage').hide();
  });
    return false;
}


$('#showImage').click(function(){  //画像追加ボタンで表示
  $('#myProfileImage').show(500);
});

</script>
</div><!--myProfileImage-->