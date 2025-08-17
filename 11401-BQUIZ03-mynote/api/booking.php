<?php include_once "db.php";

$_POST['tickets']=count($_POST['seats']);
$_POST['seats']=serialize($_POST['seats']);
$_POST['no']=date("Ymd");
$maxNo=$Order->max("id")+1;
$_POST['no'] .= sprintf("%04d", $maxNo);


$Order->save($_POST);

echo $_POST['no'];

?>