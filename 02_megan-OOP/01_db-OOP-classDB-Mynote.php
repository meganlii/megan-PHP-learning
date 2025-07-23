<?php
session_start(); // 啟動 session，讓網頁可以記錄使用者狀態（如登入、計數等）
// 每個需要使用 Session 的頁面都要先呼叫 session_start()
// 用來在不同網頁間保存使用者資料的機制

date_default_timezone_set("Asia/Taipei"); // 設定預設時區為台北，避免時間錯誤

/*
共用函式目的
1. 簡化CRUD動作
2. 減少撰寫SQL錯誤
3. 簡化除錯過程
*/

// 共有 dd  q  to 三組函式： 除錯 資料庫 跳轉
function dd($array)   // 陣列除錯用/測試用，格式化輸出內容，方便開發時檢查資料
{
    echo "<pre>";     // 格式化輸出
    print_r($array);  // print_r() 函式 以易讀 保持格式化的結構 輸出變數的結構和內容
    echo "</pre>";    // 關閉格式化輸出
}

function q($sql)   // classDB函式處理不了 較複雜的SQL語法 用這個Query()
{
    $dsn = 'mysql:host=localhost;dbname=db09;charset=utf8';
    $pdo = new PDO($dsn, 'root', '');
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// PHP檔頭管理指令-header()
// 重新導向到指定網址  在程式中跳轉到其他頁面
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
// 類別名稱：大寫開頭
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
    // (...$arg) 可變參數陣列，允許傳入多個參數
    // 如果有傳入參數，則根據參數來修改 SQL 語句
    function all(...$arg)
    {
        $sql = "select * from $this->table "; // 基本查詢語句，選取資料表所有欄位
        // $this->table = 資料表名稱
        // $this->table = 'title'
        // 所以 $sql = "select * from title"

        // 處理第一個參數
        if (isset($arg[0])) {   // isset()  檢查是否成立 有傳入資料

            // 如果第一個參數是陣列， 
            if (is_array($arg[0])) {
                $tmp = $this->arraytosql($arg[0]);  // arraytosql() 將陣列轉換為SQL條件字串

                $sql = $sql . " where " . join(" AND ", $tmp);  // AND拼接 WHERE 條件字串
                // join() 將陣列元素連接成字串  AND 連接 多條件查詢
                // 多個查詢條件用 "AND" 連接
                // 如果$tmp為SQL多條件字串
                // join(" AND ", ['id' => 1, 'name' => 'John'])
                // 會輸出：`id`='1' AND `name`='John'  (`id`=1 數字可不用' ')


                // 如果第一個參數不是陣列，則直接附加到SQL語句後
            } else {
                $sql .= $arg[0];
                // 將原本的 $sql 變數內容保留，準備在後面加上新內容
                // 等同於 $sql .= " where id=1"
                // 例如：$sql = "select * from title
                // 程式假設使用者傳入的是完整的 SQL 片段，不用再加"where" ~ 不太懂

            }
        }

        // 處理第二個參數
        // 如果有第二個參數，則附加到SQL語句後
        // 例如：$sql .= " order by id desc"
        // 第二參數常用在查詢時指定排序貨其他 SQL 附加條件（如 ORDER BY 或 LIMIT）
        // 
        // 例如：$arg[1] = " order by id desc"
        // 例如：$sql = "select * from title order by id desc"
        if (isset($arg[1])) {
            $sql .= $arg[1];
        }

        // 執行 SQL 查詢並返回結果
        // fetchAll(PDO::FETCH_ASSOC) 取得所有結果，並以關聯陣列形式返回資料
        // PDO::FETCH_ASSOC 只返回關聯陣列(二維)，不返回數字索引
        // 自訂函式用 return 回傳資料
        // 共三組參數 $this->pdo  // query($sql) 執行 SQL 查詢  // fetchAll(PDO::FETCH_ASSOC)
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4-2 查詢 資料筆數
    // count() 內建函式
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
        // fetchColumn() 只返回第一列的第一個欄位值
        // 例如：如果查詢結果是 10 筆資料，則返回 10

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
