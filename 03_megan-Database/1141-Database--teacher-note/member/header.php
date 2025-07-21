<?php
session_start();
?>

<div id='header'>
    <div class='logo'></div>
    <div class="nav">
        <a href="index.php">首頁</a>
        <?php
        if(isset($_SESSION['mem'])):
        ?>
        <a href="member_center.php">會員中心</a>
        <a href="./api/logout.php">登出</a>
        <?php 
        else:
        ?>
        <a href="reg.php">註冊</a>
        <a href="login.php">登入</a>
        <?php 
        endif;
        ?>
    </div>
</div>