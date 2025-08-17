<?php
// 紀錄會談 使用者紀錄
session_start();

// 括號內變數忘記加雙引號
// date_default_timezone_set(Asia/Taipei);
date_default_timezone_set('Asia/Taipei');

// 小大括號之間 記得留空格
function dd($array)
{
  echo '<pre>';
  print_r($array);
  echo '</pre>';
}

// 變數不用加引號 會變成字串
// 雙引號內 直接以空格區分不同字串或變數
function to($url)
{
  // header('location:' . $url); 
  header("location: $url");
}

// mysql:localhost 少mysql:host
function q($sql)
{
  $dsn = 'mysql:host=localhost;dbname:db02;charset:utf8';
  $pdo = new PDO($dsn, 'root', '');
  return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

class DB
{
  private $dsn = 'mysql:host=localhost;dbname:db02;charset:utf8';
  private $pdo;
  private $table;

  function __construct($table)
  {
    $this->table = $table;
    $this->pdo = new PDO($this->dsn, 'root', '');
  }

  function all(...$arg){
    $sql = "select * from $this->table";

    if (isset($arg[0])) {
      $tmp = $this->arraytosql($arg[0]);
      $sql = $sql . " where " . join(" AND ", $tmp );
    
    }

    if (isset($arg[1])){

    }

    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    
  }

  function count(){}

  function find(){}

  function save(){}

  function del(){}




}