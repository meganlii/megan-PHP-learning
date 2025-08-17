<?php 

//判斷是否登入成功
$dsn='mysql:host=localhost;dbname=foodie;charset=utf8';
$pdo=new PDO($dsn,'root','');
/* echo "<pre>";
print_r($_POST);
echo "</pre>"; */
//$sql="SELECT * FROM `members` WHERE `acc`='{$_POST['acc']}' && `pw`='".md5($_POST['pw'])."'";
$sql="SELECT count(*) FROM `members` WHERE `acc`='{$_POST['acc']}' && `pw`='".md5($_POST['pw'])."'";
//echo $sql;
//$mem=$pdo->query($sql)->fetch();
$mem=$pdo->query($sql)->fetchColumn();


//if($mem['acc']==$_POST['acc'] && $mem['pw']==md5($_POST['pw'])){
if($mem){
    //登入成功
    session_start();
    $_SESSION['mem']=$_POST['acc'];
   header("location:../member_center.php");

}else{
    //登入失敗
   header("location:../login.php?err=1");
}
?>