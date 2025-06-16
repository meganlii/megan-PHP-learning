<?php 
echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";

//$filename=date("YmdHis")."_".rand(1000,9999).".".explode(".", $_FILES['name']['name'])[1];


// 步驟2：加上三個變數 $type=  $description=  $name=
$name=$_FILES['name']['name'];
$type=$_POST['type'];
$description=$_POST['description'];

// 步驟3：看不懂
// 將上傳的臨時檔案移動到指定位置
move_uploaded_file($_FILES['name']['tmp_name'], './files/'.$name);

// 步驟4：dbname=files
$dsn="mysql:host=localhost;dbname=files;charset=utf8";
$pdo=new PDO($dsn,'root','');

// 步驟1
// [PHP] Lesson 4 PHP + MySQL
$sql="insert into uploads(`name`,`type`,`description`) values ('$name','$type','$description')";

// 步驟5
// exec() 執行sql語句，但不返回資料，而是返回影響的資料筆數
$pdo->exec($sql);
// echo "檔案上傳成功，檔名為：".$filename;

// 步驟6
// [PHP] Lesson 1 網頁傳值
// https://mackliu.github.io/php-book/2021/09/21/php-lesson-01/ 


// PHP檔頭管理指令-header()
// 在檔案轉送時，在檔頭加入一些資訊供接收方使用
location:manage.php location:網址
?msg= 在網址後面帶訊息過去

header("location:manage.php ?msg=檔案上傳成功，檔名為：".$filename);
?>

