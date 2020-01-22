<?php session_start();
$time=time()-1;
setcookie('login[0]' ,'',$time,"/", "","", true);
setcookie('login[1]' ,'',$time,"/", "","", true);
setcookie('login[2]' ,'',$time,"/", "","", true);
setcookie('login[2]' ,'',$time,"/", "","", true);

unset($_SESSION['login'] );
$_SESSION['login'] = array();
$referer = $_SERVER['HTTP_REFERER'];
$url = parse_url($referer);
$host = $url['host'];
 
$parse = parse_url($_SERVER["HTTP_REFERER"]);
 ?> 
<h2>ログアウトしました</h2>
<meta http-equiv="refresh" content="3; URL=<?php 
  echo $parse["scheme"],'://',$parse["host"],"/ninsho/";  ?>"> 