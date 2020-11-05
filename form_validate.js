// バリデーションチェック｡ 最初に必須項目は全てfalseを代入して送信出来ないようにする
var returnFlag = {};
returnFlag['user_name'] = false; 
returnFlag['email'] = false; 
returnFlag['phone']= false; 
returnFlag['password']=false; 
returnFlag['password_confirm']=false; 
returnFlag['profileImage']=false; 



$('#email').change(function(){
let value = $.trim($(this).val());
$(this).val("");
$(this).val(value);
  returnFlag['email'] = emailCheck( value );
});

$('#phone').change(function(){
  let value = $.trim($(this).val());
  returnFlag['phone']=telCheck( value );
});

$('#password').change(function(){
let value = $.trim($(this).val());
$(this).val("");
$(this).val(value);
returnFlag['password']=checkPassword( value );
});

$('#password_confirm').change(function(){
let value = $.trim($(this).val());
$(this).val("");
$(this).val(value);
returnFlag['password_confirm']=checkPasswordConfirm( value );
});



function checkPasswordConfirm(sp) {
  if (sp == $("#password").val() ){
  return true;
  }else{
  errAlert($("#password_confirm"));   // アラート
  return  false;
  }
}
       
       
function errAlert(sp){ // バルーン式に開閉するユーザ定義関数
 sp.focus().next().show();
   setTimeout( function(){ sp.next().hide(500);
    },3000) ;
}

function emailCheck(sp){   // email書式が正しいか
 if( sp.match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])*\.+([a-zA-Z0-9\._-]+)+$/) ){
   return true;
 }else{
    errAlert($("#email"));   // アラート
   return false;
 }
} 

function telCheck(sp){  // 3~4桁の整数のみ
 if(  sp.match(/^\d{10,12}$/) ){
    return true;
 }else{
    errAlert($('#phone'));   // アラート
   return false;
 }
}

function checkPassword( sp ) {
  if( sp.match( /(?=.{8,25})(?=.*\d+.*)(?=.*[a-zA-Z]+.*).*/ ) ) {
    return true;
  } else {
    errAlert($("#password"));   
    return false;
  }
}


function formVlidation(){ 
// 送信ボタンで呼び出し｡ データ要件を満たすべきリスト
returnFlag['email'] = emailCheck($('#email').val()); //changeイベントが発火しないので
returnFlag['phone']=telCheck($('#phone').val());
returnFlag['password_confirm']=checkPasswordConfirm($('#password_confirm').val());

 if($('#_profileAvatarImage img').attr('src') != undefined)
   returnFlag['profileImage']= true;
 
 if($("#user_name").val().length > 4){
   returnFlag['user_name']  = true;
 }else{
   $("#user_name").focus().next().html('5文字以上で入れてください')
 }
 
for(key in returnFlag){
 //	console.log(key + " => " +returnFlag[key]);
   if(returnFlag[key] != true ){
     var sp = '#' + key;
      errAlert($(sp));
     return false;
   }
}
return true;  //roopを抜けてからfalseがなければ
}
