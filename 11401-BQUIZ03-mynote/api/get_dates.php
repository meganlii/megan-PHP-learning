<?php include_once "db.php";

$id=$_GET['movieId'];

$movies=$Movie->find($id);
$ondate=strtotime($movies['ondate']);
$today=strtotime(date("Y-m-d"));

$passDay=($today-$ondate)/(60*60*24);

for($i=$passDay;$i<3;$i++){
    $date=date("Y-m-d",strtotime("+$i days",$ondate));
  echo "<option value='$date'>";
  echo $date;
  echo "</option>";
}


?>