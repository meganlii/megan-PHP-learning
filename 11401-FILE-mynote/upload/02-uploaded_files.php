<?php 
echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";
include_once "db.php";

// 重新更名 重新編碼需求 開放大量上傳避免檔名重複 統一化管理
// 用三組函式處理 日期date() / 亂數rand() / explode()
// 也可設定 先檢查是否重複  有重複再跑一次rand()
// explode() 取出副檔名  例如uploads.sql  重新編碼後顯示20251225_1234.sql
// $filename=date("YmdHis")."_".rand(1000,9999).".".explode(".", $_FILES['name']['name'])[1];

foreach($_FILES['name']['tmp_name'] as $key=> $tmp_name){
    
    $name=$_FILES['name']['name'][$key];
    $type=$_POST['type'][$key];
    $description=$_POST['description'][$key];

    move_uploaded_file($tmp_name, './files/'.$name);
    echo "insert into uploads(`name`,`type`,`description`) values ('$name','$type','$description')";
    echo "<br>";
    
    q("insert into uploads(`name`,`type`,`description`) values ('$name','$type','$description')");

}

//$pdo->exec($sql);
// echo "檔案上傳成功，檔名為：".$filename;

header("location: manage.php?msg=檔案上傳成功");
?>

