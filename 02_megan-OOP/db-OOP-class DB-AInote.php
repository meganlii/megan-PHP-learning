<?php
session_start(); // 啟動 session，方便記錄使用者狀態
date_default_timezone_set("Asia/Taipei"); // 設定時區為台北

// 除錯用函式，格式化輸出陣列內容
function dd($array)
{
  echo "<pre>";
  print_r($array);
  echo "</pre>";
}

// 執行 SQL 查詢並回傳所有結果（關聯式陣列）
function q($sql)
{
  $dsn = 'mysql:host=localhost;dbname=db09;charset=utf8';
  $pdo = new PDO($dsn, 'root', '');
  return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// 重新導向到指定網址
function to($url)
{
  header("location:" . $url);
}

// 資料庫操作類別（OOP 實作）
class DB
{
  private $dsn = "mysql:host=localhost;dbname=db09;charset=utf8"; // 資料庫連線字串
  private $pdo;   // PDO 物件
  private $table; // 目前操作的資料表

  // 建構子，初始化 PDO 連線與指定資料表
  function __construct($table)
  {
    $this->table = $table;
    $this->pdo = new PDO($this->dsn, "root", '');
  }

  // 取得所有資料，可加條件
  function all(...$arg)
  {
    $sql = "select * from $this->table ";  // SQL語句 SELECT * FROM 資料表
    if (isset($arg[0])) {
      if (is_array($arg[0])) {
        $tmp = $this->arraytosql($arg[0]);
        $sql = $sql . " where " . join(" AND ", $tmp);
      } else {
        $sql .= $arg[0];
      }
    }

    if (isset($arg[1])) {
      $sql .= $arg[1];
    }

    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  }

  // 計算資料筆數，可加條件
  function count(...$arg)
  {
    $sql = "select count(*) from $this->table ";
    if (isset($arg[0])) {
      if (is_array($arg[0])) {
        $tmp = $this->arraytosql($arg[0]);
        $sql = $sql . " where " . join(" AND ", $tmp);
      } else {
        $sql .= $arg[0];
      }
    }

    if (isset($arg[1])) {
      $sql .= $arg[1];
    }

    return $this->pdo->query($sql)->fetchColumn();
  }

  // 取得單筆資料（可用 id 或條件陣列）
  function find($id)
  {
    $sql = "select * from $this->table ";

    if (is_array($id)) {
      $tmp = $this->arraytosql($id);
      $sql = $sql . " where " . join(" AND ", $tmp);
    } else {
      $sql .= " WHERE `id`='$id'";
    }
    //echo $sql;
    return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
  }

  // 新增或更新資料
  function save($array)
  {
    if (isset($array['id'])) {
      // 更新
      $sql = "update $this->table set ";
      $tmp = $this->arraytosql($array);
      $sql .= join(" , ", $tmp) . "where `id`= '{$array['id']}'";
    } else {
      // 新增
      $cols = join("`,`", array_keys($array));
      $values = join("','", $array);
      $sql = "insert into $this->table (`$cols`) values('$values')";
    }

    return $this->pdo->exec($sql);
  }

  // 刪除資料
  function del($id)
  {
    $sql = "delete  from $this->table ";

    if (is_array($id)) {
      $tmp = $this->arraytosql($id);
      $sql = $sql . " where " . join(" AND ", $tmp);
    } else {
      $sql .= " WHERE `id`='$id'";
    }
    //echo $sql;
    return $this->pdo->exec($sql);
  }

  // 將陣列轉換為 SQL 條件語句
  private function arraytosql($array)
  {
    $tmp = [];
    foreach ($array as $key => $value) {
      $tmp[] = "`$key`='$value'";
    }

    return $tmp;
  }
}

// 建立各資料表的 DB 物件
$Title = new DB('title');
$Ad = new DB('ad');
$Mvim = new DB('mvim');
$Image = new DB('image');
$News = new DB('news');
$Admin = new DB('admin');
$Menu = new DB('menu');
$Total = new DB('total');
$Bottom = new DB('bottom');

// 記錄瀏覽人數（只記錄一次）
if (!isset($_SESSION['visit'])) {
  // 第一次來訪
  $t = $Total->find(1);
  $t['total']++;
  $Total->save($t);
  $_SESSION['visit'] = 1;
}

// OOP（物件導向程式設計）概念補充
// 類別（Class）：如 DB，定義資料結構與操作方法。
// 物件（Object）：如 $Title = new DB('title')，根據類別產生的實體。
// 封裝（Encapsulation）：將資料（屬性）與操作（方法）包裝在類別內部。
// 繼承（Inheritance）：可建立子類別繼承父類別功能（本例未用到）。
// 多型（Polymorphism）：同一方法可依物件型態有不同表現（本例未用到）。
