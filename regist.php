<?php
session_start();
  require_once('connect.php');
  $himitsu = $_SESSION['himitsu']= token();
?>
<link rel="stylesheet" href="style.css">
<body>
	<div id="page" class="site">

	<div id="primary" class="content-area page-signup">
		<main id="main" class="site-main" role="main">

  
<h2>プロフィール登録</h2>
<div class="form">
<form action="form_complate.php" method="post" class="user" onsubmit="return formVlidation();">
  <input type="hidden" name="himitsu" value="<?=$himitsu?>">
	<section class="public">
		<h3>公開情報</h3>
	    
	    <div><label class="hisu">ニックネーム</label><input type="text" name="user_name" id="user_name" placeholder="taro12" autocomplete="off" required=""> ※サービス上で使用する名前です。特定されない名前を付けてください(5文字以上)。
	    		<div class="balloon"><strong>!</strong> </div>
	    </div>
	    <div><label class="hisu">プロフィール画像</label> <div id="button_showImage">画像を追加する</div>
	          <div id="_profileAvatarImage" class="avatarContainer">
	          	<span>※閲覧数、投資コンタクト率を上げるためにお好きな画像をアップしてください。</span>
		      	<!--ここに画像が映る-->
		      		<img style="width:200px">
		      </div>
		      	<input type="hidden" name="profile_image" id="profileImage" value="" required="">
		      		<div class="balloon"><strong>!</strong> 画像をアップしてください</div>
	    </div>
	</section>
  
  
  <section class="private">
  	
    <div><label class="hisu">お名前</label><input type="text" name="seimei" required=""></div>
    
    <div><label class="hisu">電話番号</label><input type="tel" name="phone" id="phone" required=""> ※ハイフンなしで
    	<div class="balloon"><strong>!</strong>電話番号の書式が違います</div>
    </div>
    
    <div><label class="hisu">メールアドレス</label><input type="email" name="email" id="email" value="" required="">
    		<div class="balloon"><strong>!</strong>メールアドレスの書式が違います</div>
    </div>
    
    <div><label class="hisu">パスワード</label><input type="password" id="password" name="user_password" autocomplete="off" required=""> ※英数字混在で8字以上
    	<div class="balloon"><strong>!</strong>パスワードの書式が違います<br>
            英数字混在で8文字以上 例:kpyR2848</div>
    </div>
    
    <div><label class="hisu">パスワード確認</label><input type="password" id="password_confirm" name="user_password_vrfy" required="">
    	<div class="balloon"><strong>!</strong>パスワードが一致しません</div>
    </div>
    
    <div><input type="submit" name="txtSubmit" value="確認へ"></div>
    <p>利用規約とプライバシーポリシーをご確認の上、登録手続きを進めてください。</p>
  </section>  
</form>



<div id="myProfileImage">
  <form id="my_form">
    <label for="_profileAvatarUploadSelect" class="selectButton" role="button">
   		 <input type="file" name="file_1">
    </label>　  
    	
    <div>
    	<button type="button" id="fileSubmit" onclick="file_upload()">アップロード</button>
      <button type="cancel" id="canselSubmit">キャンセル</button>
    </div>
        <p>(最大5MBまで。JPG,GIF,PNGが使えます)</p>
	</form>
</div>

</div><!--#form-->

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="form_validate.js"></script>
<script>
 $('#user_name').change(function() {
	//5文字以上,他人との重複は避ける
  var user_name_lemgth = $(this).val().length;
  
  if(user_name_lemgth > 4){
      // POSTメソッドで送るデータを定義します var data = {パラメータ名 : 値};
      var submitData = {'user_name' : $(this).val()};
      /**
       * Ajax通信メソッド
       * @param type  : HTTP通信の種類
       * @param url   : リクエスト送信先のURL
       * @param data  : サーバに送信する値
       */
      $.ajax({
        type: "POST",
        url: '/ninsho/ajax-nickname.php',
        data: submitData,
      }).done(function(data, dataType) {
        // successのブロック内は、Ajax通信が成功した場合に呼び出される
        // PHPから返ってきたデータの表示
            if(data.length > 10){
              $("#user_name").focus().next().html(data).show();
              setTimeout( function(){
                  $("#user_name").next().hide(500);
              },3000) ;
              returnFlag['user_name']  = false;
                errAlert($("#user_name"));   // アラート
            }else{
              returnFlag['user_name']  = true;
            }  
      }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
        // 通常はここでtextStatusやerrorThrownの値を見て処理を切り分けるか、単純に通信に失敗した際の処理を記述します。
        alert('Error : ' + errorThrown);
      });
      // サブミット後、ページをリロードしないようにする
      return false;
  }else{
    $("#user_name").focus().next().html('5文字以上で入れてください');
    errAlert($("#user_name"));   // アラート
	}  
});




//画像のアップ
function file_upload(){
    // フォームデータの0番目の要素をオブジェクトで取得(ファイルを送る場合の書き方)
    var formdata = new FormData($('#my_form').get(0));

    // POSTでアップロード
    $.ajax({
        url  : "/ninsho/image-ajax.php",
        type : "POST",
        data : formdata,
        cache       : false,
        contentType : false,  //content-typeヘッダを変換せず送信
        processData : false,  //dataをクエリ文字列に変換せずに送信
        dataType    : "html"
    })
    .done(function(data, textStatus, jqXHR){
        //出力する部分
        if ( data.indexOf('登録済み') != -1) {
          //dataに"登録済み"を含む場合の処理
         $('#_profileAvatarImage').addClass('balloon').show(300).children('span').html(data);
          setTimeout( function(){ 
            $('#_profileAvatarImage').hide(500);
          },3000) ;
         errAlert($("#user_name"));
        }else{
          //含まない
          $('#_profileAvatarImage').show(300).children('span').html('');
          $('#_profileAvatarImage img').attr('src','/ninsho/uploads/userProfile/'+data);
          // $('[name=profile_image]').val(data).attr({ type:'text' ,readonly:'readonly'});
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        alert("fail");
    });
      return false;
}





$('#myProfileImage').hide();  //画像アップのフｫームは非表示にしておく

$('#canselSubmit').click(function(){  //キャンセルしたら非表示
  $('#myProfileImage').hide();
});	
  $('#fileSubmit').click(function(){    //送信しても非表示
  $('#myProfileImage').hide();
});	

$('#button_showImage').click(function(){  //画像追加ボタンで表示
  $('#myProfileImage').show(500);
});





</script>
	</main><!-- #main -->
</div><!-- #primary -->

</div></body>