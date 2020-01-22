<?php //会員専用のページTOP
session_start();
?>
<style>
  .profile_image{width: 35px;
    height: 35px;
    border-radius: 45px;}
</style>
<div>
    <img src="/ninsho/uploads/userProfile/<?=$_SESSION['login']['profile_image']?>" class="profile_image" alt="">
  ようこそ<?=$_SESSION['login']['user_name']?> さん
  <span><a href="logoff.php">ログオフ</a></span>

</div>