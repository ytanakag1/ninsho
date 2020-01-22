<?php  
  function h($p){ 
     // 引数には初期値を与えられる
    $p = htmlspecialchars($p,ENT_QUOTES,'UTF-8');
    $p = str_replace('-','ー',$p);
    $p = str_replace(',','、',$p);
    return $p; 
  }
