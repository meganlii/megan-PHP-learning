<?php 
include_once "db.php";
echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";

//$filename=date("YmdHis")."_".rand(1000,9999).".".explode(".", $_FILES['name']['name'])[1];
if(!empty($_FILES['name']['tmp_name'])){
    $name=$_FILES['name']['name'];
    move_uploaded_file($_FILES['name']['tmp_name'], './files/'.$name);
    $_POST['name']=$name;
}

$type=$_POST['type'];
$description=$_POST['description'];

save('uploads',$_POST);

// echo "檔案上傳成功，檔名為：".$filename;

header("location:manage.php?msg=檔案編輯成功，檔名為：".$name);
?>

