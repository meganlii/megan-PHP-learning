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
// 雙引號內 直接以空格區分不同字串或變數
function to($url) {
  // header('location:' . $url); 
  header("location: $url");  
}

// mysql:localhost 少mysql:host
function q($sql){
  $dsn = 'mysql:host=localhost;dbname:db02;charset:utf8';
  $pdo = new PDO($dsn,'root','');
  return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}


?>