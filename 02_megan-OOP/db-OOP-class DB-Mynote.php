<?php
session_start();
date_default_timezone_set("Asia/Taipei");

/*
共用函式目的
1. 簡化CRUD動作
2. 減少撰寫SQL錯誤
3. 簡化除錯過程
*/

// 共有 dd  q  to 三組函式

function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function q($sql)
{
    $dsn = 'mysql:host=localhost;dbname=db09;charset=utf8';
    $pdo = new PDO($dsn, 'root', '');
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function to($url)
{
    header("location:" . $url);
}

/*
簡化自訂函式
1. 用物件導向的方式 簡化自訂函式的撰寫
2. 考量檢定時間限制，並不是全面採用OOP
3. 只是把常用的自訂函式，包裝成一個工具類別(Class)
*/

// 資料庫操作類別 (Database Access Object, DAO) 
// 共7個FN：const  all  count  find  save  del  arraytosql

// 步驟1 宣告類別DB
class DB
{

    // 步驟2 宣告屬性/變數
    // 2-1 建立資料庫基本資料
    // host => 主機名稱或是位置IP / charset => 使用的字元集，一般選utf8 / dbname => 使用的資料庫名稱
    private $dsn = "mysql:host=localhost;dbname=db09;charset=utf8";

    // 2-2 建立PDO物件連接資料庫
    private $pdo;  // 這裡存放另一個物件（PDO物件)

    // 2-3 讓每個 DB 物件記住自己要操作哪個資料表！
    private $table;  // $this->table = 資料表名稱


    // 步驟3 建構函式
    // 讓每個 DB 物件記住自己要操作哪個資料表！
    function __construct($table)
    {

        // 3-1 使用 [$this->屬性名稱(不用$)]  存取 物件的屬性(變數) 
        $this->table = $table;  // $this 替換 資料表名稱


        // 3-2 $this->dsn = $dsn = "mysql:host=localhost;dbname=db09;charset=utf8"
        // PHP 內建類別PDO 不需要自己宣告
        // 同時建立另一個PDO物件(內部建立的PDO物件)，存放在$this->pdo屬性中
        // 物件包含物件的概念 建構子下有兩個$this
        $this->pdo = new PDO(  // PDO也是一個物件
            $this->dsn,  // 資料庫的設定資料：資料庫位置和名稱
            "root",      // 使用者名稱
            ''           // 密碼（空白）
        );
    }

    // 步驟4 自訂函式
    // 4-1 查詢 全部資料
    // (...$arg) 代表 可變參數陣列，允許傳入多個參數
    // 如果有傳入參數，則根據參數來修改 SQL 語句
    function all(...$arg)
    {
        $sql = "select * from $this->table "; // 查詢邏輯
        // $this->table = 資料表名稱
        // $this->table = 'title'
        // 所以 $sql = "select * from title"

        // 處理第一個參數
        if (isset($arg[0])) {   // isset()檢查是否有傳入條件陣列或SQL

            // 如果第一個參數是陣列，則將陣列轉換為SQL條件字串
            // 如果第一個參數不是陣列，則直接附加到SQL語句後
            if (is_array($arg[0])) {
                $tmp = $this->arraytosql($arg[0]);  // 產生條件陣列
                $sql = $sql . " where " . join(" AND ", $tmp);  // 產生 WHERE 條件
            } else {
                $sql .= $arg[0];
            }
        }

        // 處理第二個參數
        // 如果有第二個參數，則附加到SQL語句後
        if (isset($arg[1])) {
            $sql .= $arg[1];
        }

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4-2 查詢 資料筆數
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

    // 4-3 查詢 單筆資料
    // $id是主鍵值或條件陣列
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

    // 4-4 儲存資料
    // $array是要儲存的資料陣列
    function save($array)
    {
        if (isset($array['id'])) {

            //update
            $sql = "update $this->table set ";
            $tmp = $this->arraytosql($array);
            $sql .= join(" , ", $tmp) . "where `id`= '{$array['id']}'";
        } else {

            //insert
            $cols = join("`,`", array_keys($array));
            $values = join("','", $array);
            $sql = "insert into $this->table (`$cols`) values('$values')";
        }

        return $this->pdo->exec($sql);
    }

    // 4-5 刪除資料
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

    // 4-6 將陣列轉換為SQL條件字串
    private function arraytosql($array)
    {
        $tmp = [];
        foreach ($array as $key => $value) {
            $tmp[] = "`$key`='$value'";
        }

        return $tmp;
    }
}

// 建立資料庫物件
// 使用 new語法 建立一個DB連線物件，並將這個物件指定給一個變數$DB
// $DB = new DB('資料表名稱');
$Title = new DB('title');
$Ad = new DB('ad');
$Mvim = new DB('mvim');
$Image = new DB('image');
$News = new DB('news');
$Admin = new DB('admin');
$Menu = new DB('menu');
$Total = new DB('total');
$Bottom = new DB('bottom');


if (!isset($_SESSION['visit'])) {
    //第一次來訪
    $t = $Total->find(1);
    $t['total']++;
    $Total->save($t);
    $_SESSION['visit'] = 1;
}
