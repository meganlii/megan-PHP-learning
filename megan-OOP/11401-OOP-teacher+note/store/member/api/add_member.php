<?php 

$dsn='mysql:host=localhost;dbname=foodie;charset=utf8';
$pdo=new PDO($dsn,'root','');

$pw=md5($_POST['pw']);

$sql="INSERT INTO `members`(`name`, `acc`, `pw`, `birthday`, `email`) 
           VALUES ('{$_POST['name']}',
                   '{$_POST['acc']}',
                   '{$pw}',
                   '{$_POST['birthday']}',
                   '{$_POST['email']}')";


$pdo->exec($sql);
header("location:../index.php");