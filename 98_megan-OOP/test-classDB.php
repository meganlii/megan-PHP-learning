<?php
// 紀錄會談 使用者紀錄
session_start();

// 括號內變數忘記加雙引號
// date_default_timezone_set(Asia/Taipei);
date_default_timezone_set('Asia/Taipei');

// 小大括號之間 記得留空格
function dd($array) {
  echo '<pre>';
  print_r($array);
  echo '</pre>';
}

// 變數不用加引號 會變成字串
function to($url) {
  // header('location:' . $url); 
  header("location: $url");  // 雙引號內 直接以空格區分不同字串或變數
}

function q($sql) {
  $dsn = 'mysqlhost:localhot;dbname=db02;charset:utf8';
  $pdo = 
  return 

}

?>