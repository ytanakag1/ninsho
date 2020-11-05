<?php
$dbname = "sample"; //引数を上書き
$table_name = "member";
$auto_increment = true; //A_Iなら trueにする

  $host = 'localhost';
	$user = 'ginzo';
	$psw =  'Hy5QkXsYc3YogVc3jObRFA==';
  $key = 'MOEdjm;jeagpoj-e-0-b934tggesij0dfgn0jsrh)nkmaJDFGOE208349SRBJ';
  $psw = openssl_decrypt($psw, 'AES-128-ECB', $key);
    $mydb = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';
  try{
    $dbh=new PDO($mydb,$user,$psw ); //DBへ接続
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // PDOのエラーモードを追加してください
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 構文チェックと実行を分離したままにする 必須
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // メモリ効率がいい

  } catch (PDOException $e) {
   die('ConneCt Error: ' .$e->getCode()); //DB接続エラー時の処理
  }

  $field_name = $dbh->query("DESCRIBE $table_name");	

foreach ($field_name as $key=>$value)
$fieldName[] = $value["Field"];

// テーブルの先頭がA_Iならこの2行は有効化する
 if($auto_increment){
  unset($fieldName[0]);        //indexは詰められてない
  $fieldName = array_values($fieldName); // 0から振り直す
 }

	// トークン作成のための関数
function token($length = 20){  	
	return substr(str_shuffle('1234567890QWERTYUIOPLKJHGFDSAZXCVBNMabcdefghijklmnopqrstuvwxyz'), 0, $length);
}

function h($p){
	$p = htmlspecialchars($p);
	$p = str_replace( ' ','' , $p ); //半角空白除去
	$p = str_replace( ',','、' , $p ); //半角カンマ置換
	return $p;
}	

 $wamei=[
	"user_name"=>[
		'label'=>'ニックネーム'
		 ,'required'=>'required'
		 ,'type'=>'text'
		 ,'id'=>''
		 ,'bind'=> PDO::PARAM_STR
	],
	  "profile_image"=>[
  		'label'=>'プロフィールイメージ'
		 ,'required'=>'hidden'
		 ,'type'=>''
		 ,'id'=>'profile_image'
		 ,'bind'=> PDO::PARAM_STR
	],
  "pref"=>[
	  'label'=>'都道府県'
		 ,'required'=>''
		 ,'type'=>'select'
		 ,'id'=>''
		 ,'bind'=> PDO::PARAM_STR
	],
  "seimei"=>[
		'label'=>'姓名'
		 ,'required'=>'required'
		 ,'type'=>'text'
		 ,'id'=>''
		 ,'bind'=> PDO::PARAM_STR
  ],
  "phone"=>[
  	'label'=>'お電話'
		 ,'required'=>''
		 ,'type'=>'tel'
		 ,'id'=>''
		 ,'bind'=> PDO::PARAM_STR
	],
  "email"=>[
	  	'label'=>'メール'
		 ,'required'=>''
		 ,'type'=>'hidden'
		 ,'id'=>''
		 ,'bind'=> PDO::PARAM_STR
  ],
  "user_password"=>[
  	'label'=>'パスワード'
		 ,'required'=>'required'
		 ,'type'=>'password'
		 ,'id'=>'pswd'
		 ,'bind'=> PDO::PARAM_STR
  ]
];