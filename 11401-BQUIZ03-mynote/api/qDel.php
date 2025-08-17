<?php include_once "db.php";

//$Order->del(["{$_POST['type']}"=>$_POST['data']]);

$type=$_POST['type'];
$data=$_POST['data'];

switch($type){
    case 'date':
        $Order->del(['date'=>$data]);
    break;
    case 'movie':
        $Order->del(['movie'=>$data]);
    break;
}


