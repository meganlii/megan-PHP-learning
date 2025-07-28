<?php

// 4-1 重看  4-2 查詢 資料筆數--從這邊開始看  7/28

/* 搭配講義註解
1.[技能檢定]網頁乙級檢定-前置作業-程式功能整合測試-基礎
https://mackliu.github.io/php-book/2024/01/03/skill-check1-init-04/

2. [資料庫] Lesson 3 SQL 語法
https://mackliu.github.io/php-book/2021/09/20/db-lesson-03/

3. 總共2+3+7 = 12個函式
*/


session_start();
// 啟用 session：讓網頁可以記錄使用者狀態（如登入、計數等）
// 每個需要使用 Session 的頁面，都要先呼叫 session_start()
// 用來在不同網頁間，保存使用者資料的機制

date_default_timezone_set("Asia/Taipei");
// 設定預設時區為台北，避免時間錯誤

/* 共用函式目的
1. 簡化CRUD動作、除錯過程
2. 減少撰寫SQL錯誤
3. include到所有的頁面去使用
*/

/* 撰寫輔助用的全域函式：輔助函式
1. 共 dd  q  to 三組函式： 除錯 資料庫 跳轉
2. 宣告在共用的引入檔中，做為全域隨時可以呼叫的工具函式
3. 不用放到類別中，獨立在 DB 類別之外
*/


function dd($array)   // 陣列除錯用/測試用，格式化輸出內容，方便開發時檢查資料
{
    echo "<pre>";     // 格式化輸出
    print_r($array);  // print_r() 以易讀 保持格式化結構 輸出變數的結構和內容
    echo "</pre>";    // 關閉格式化輸出
}

function q($sql)   // 複雜SQL語法的簡化函式
// classDB函式處理不了 解決聯表查詢或是子查詢

{
    $dsn = 'mysql:host=localhost;dbname=db09;charset=utf8';
    $pdo = new PDO($dsn, 'root', '');
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

/* 頁面導(定)向輔助函式：PHP檔頭管理指令-header()
1. 重新導向/跳轉 到指定網址 可為內部首頁、外部網址、相對路徑
2. 跳轉時帶參數 to("profile.php?id=123");
3. 跳轉到首頁 to("index.php") 
    伺服器發送 HTTP 標頭：Location: login.php
    瀏覽器接收到這個標頭
    瀏覽器自動跳轉到 login.php
4. 常見使用情境
    // 表單提交後跳轉
    if($_POST['submit']) {
        // 處理表單...
        to("success.php");
    }
*/
function to($url)  // 接收一個參數 $url（要跳轉的目標網址）
{
    header("location:" . $url);
    // header() 函數發送 HTTP 標頭Location
    // 標頭Location 會告訴瀏覽器跳轉到指定的網址
    // . $url 將參數中的網址串接到 "location:" 後面
}

/* 簡化自訂函式
1. 用物件導向的方式 簡化自訂函式的撰寫
2. 考量檢定時間限制，並不是全面採用OOP
3. 只是把常用的自訂函式，包裝成一個工具類別(Class)
*/

/* 資料庫操作類別 (Database Access Object, DAO) 
共7個FN：const  all  count  find  save  del  arraytosql
*/

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
    // 建立建構式，在建構時帶入table名稱會建立資料庫的連線
    // 建構函式：當建立物件時自動執行
    // 建構式為物件被實例化(new DB)時會先執行的方法
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
    /** 
     * 4-1 $table->all()-查詢 符合條件的 全部資料 select *
     *      處理不同類型的查詢需求  用來取得符合條件的所有資料
     *      (...$arg) 可變參數陣列，允許傳入多個參數
     *      如果有傳入參數，則根據參數來修改 SQL 語句
     **/

    function all(...$arg)
    {
        $sql = "select * from $this->table "; // 基本查詢語句，選取資料表所有欄位
        // $this->table = 資料表名稱
        // $this->table = 'title'
        // 所以 $sql = "select * from title"

        // 處理第一個參數
        // isset()  檢查是否成立 有傳入資料
        if (isset($arg[0])) {

            // is_array() 如果第一個參數是陣列
            if (is_array($arg[0])) {
                $tmp = $this->arraytosql($arg[0]);
                //arraytosql() 將陣列轉換為SQL條件字串

                $sql = $sql . " where " . join(" AND ", $tmp);
                // 留意點.運算子  AND拼接 WHERE 條件字串
                // join() 將陣列元素連接成字串  AND 連接 多條件查詢
                // 多個查詢條件用 "AND" 連接
                // 如果$tmp為SQL多條件字串
                // join(" AND ", ['id' => 1, 'name' => 'John'])
                // 輸出：`id`='1' AND `name`='John'  (`id`=1 數字可不用' ')
                // 整個 $sql 輸出
                // select * from users where `id`='1' AND `name`='John'


                // 如果第一個參數不是陣列，則直接附加到SQL語句後
            } else {
                $sql .= $arg[0];
                // 將原本的 $sql 變數內容保留，準備在後面加上新內容
                // 等同於 $sql .= " where id=1"
                // 例如：$sql = "select * from title
                // 程式假設使用者傳入的是完整的 SQL 片段，不用再加"where" ~ 看不懂@@

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

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);  // 取回全部 關聯陣列

        // 執行 SQL 查詢並返回結果
        // fetchAll(PDO::FETCH_ASSOC) 取得所有結果，並以關聯陣列形式返回資料
        // PDO::FETCH_ASSOC 只返回關聯陣列(二維)，不返回數字索引
        // 自訂函式用 return 回傳資料
        // 共三組參數 $this->pdo  // query($sql) 執行 SQL 查詢  // fetchAll(PDO::FETCH_ASSOC)

        /* 回傳值 fetchAll()
        參考 https://mackliu.github.io/php-book/2021/09/21/php-lesson-04/
        PDO:: PHP 中的範圍解析運算符，用雙冒號 :: 表示
        存取類別常數：存取 PDO 類別中定義的常數
        存取 PDO 類別中的 FETCH_ASSOC 常數
        :: 就是用來「進入」一個類別，存取它內部的靜態內容（常數、靜態方法、靜態屬性）的符號。
        */

        /* PDO 常用常數
        PDO::FETCH_ASSOC  回傳 帶欄位名稱的資料
        // 關聯陣列 ['name' => 'John', 'age' => 25]
        
        PDO::FETCH_NUM    回傳 帶欄位索引的資料
        // 索引陣列 [0 => 'John', 1 => 25]
        */
    }

    // 4-2 查詢 資料筆數 select count(*) --從這邊開始看
    // count() SQL內建函式 聚合函式
    function count(...$arg)
    {
        $sql = "select count(*) from $this->table ";
        // 處理第一個參數 
        // isset()  檢查是否成立 有傳入資料
        if (isset($arg[0])) {

            // is_array() 如果第一個參數是陣列
            if (is_array($arg[0])) {
                $tmp = $this->arraytosql($arg[0]);
                $sql = $sql . " where " . join(" AND ", $tmp);

                // 如果第一個參數不是陣列，則直接附加到SQL語句後
            } else {
                $sql .= $arg[0];
            }
        }

        // 處理第二個參數
        if (isset($arg[1])) {
            $sql .= $arg[1];
        }

        return $this->pdo->query($sql)->fetchColumn();
        // fetchColumn() 只返回第一列的第一個欄位值
        // 例如：如果查詢結果是 10 筆資料，則返回 10

    }

    // 4-3 $table->find($id)-查詢 符合條件的 單筆資料 select *
    /** 
     *      回傳資料表指定id的資料 $id是主鍵值或條件陣列
     * 
     * 
     */


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

    // 4-4 儲存資料：update、insert
    // $array 要儲存的資料陣列
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
/** 
 * 使用 new語法 建立一個DB連線物件，並將這個物件指定給一個變數$DB
 * 變數$DB(大寫開頭) = new DB('資料表名稱');
 * 建立一個專門處理 [ title 資料表] 的 [ 物件 $Title ]
 * $Title 物件變數  ['title'] 數值/參數
 * 用法 $title = $Title->find(1);
 **/

$Title = new DB('title');
$Ad = new DB('ad');
$Mvim = new DB('mvim');
$Image = new DB('image');
$News = new DB('news');
$Admin = new DB('admin');
$Menu = new DB('menu');
$Total = new DB('total');
$Bottom = new DB('bottom');


// 網站訪客計數器
if (!isset($_SESSION['visit'])) {
    // 檢查是否為新訪客：檢查 Session 中是否有 'visit' 標記(變數/key值)

    // 第一次來訪
    // 如果沒有設定，表示這是使用者第一次造訪網站

    $t = $Total->find(1);
    // 如果是新訪客
    // 從資料庫取得 ID 為 1 的總訪問次數記錄
    // $Total 應該是一個資料庫操作類別的實例    


    $t['total']++;
    // 將總訪問次數加 1
    // $t (=$total) 是一個陣列，包含 資料庫記錄的各個欄位
    // 'total' 欄位儲存 總訪問次數

    $Total->save($t);
    // 將更新後的資料存回資料庫

    $_SESSION['visit'] = 1;
    // 在 Session 中設定 'visit' 標記為 1
    // 表示這個使用者已經被計算過了，避免重複計算
}

/* 網站訪客計數器
1. 檢查是否為新訪客：檢查 Session 中是否有 'visit' 標記
2. 如果是新訪客：
    從資料庫取得目前的總訪問次數
    將次數加 1
    更新回資料庫
    在 Session 中做標記，避免同一個訪客重複計算
*/

/*
第一次訪問
    $_SESSION['visit'] 不存在 → 執行計數邏輯
    假設資料庫中 total = 100
    執行後：total = 101，$_SESSION['visit'] = 1

同一使用者再次訪問（重新整理頁面等）
    $_SESSION['visit'] = 1 已存在 → 跳過計數邏輯，不重複加 1
*/
