<?php 
echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";
include_once "db.php";
//$filename=date("YmdHis")."_".rand(1000,9999).".".explode(".", $_FILES['name']['name'])[1];

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

