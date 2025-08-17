<?php 
include_once "db.php";

/* $table=$_POST['table'];
$id=$_POST['id'];

$$table->del($id); */

${$_POST['table']}->del($_POST['id']);

?>