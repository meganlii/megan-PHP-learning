<?php
// 搭配講義註解
/* 
1.[技能檢定]網頁乙級檢定-前置作業-程式功能整合測試-基礎
https://mackliu.github.io/php-book/2024/01/03/skill-check1-init-04/

2.[資料庫] Lesson 3 SQL 語法
https://mackliu.github.io/php-book/2021/09/20/db-lesson-03/

3.老師題組一解題說明
https://bquiz.mackliu.com/solve/solve01-02.html
*/

// 總共2+3+6+1 = 12個函式
// 記憶技巧 先列出全部函式 寫完時間 老師15分 同學25分
/*
1.全域函式 *2 + *3  再寫DB類別  *6

2.寫FN name( ){ }，先寫名稱/小大括號/變數  例 function all(...$arg)
all//find(查R) count  save(增C.改U)//del(刪D)  arraytosql
R-read顯示 在SQL稱為query  顯示功能屬於R

3.再寫new DB('table') 物件
$Title = new DB('title');

4.最後寫訪客計數器
if(!isset($_SESSION['visit'])){...}
*/


// 一、共用函式目的
/* ==============================================================
 * 簡化 CRUD動作、除錯過程
 * 減少 撰寫SQL錯誤
 * include 到所有頁面使用 之後維護和重複使用
 * 放到最上/外層的頁面 放backend.php(後台) 寫一次即可 不用寫好幾次
 * 後台會載入其他檔案(如backend\title.php) 都會共用到 
 * 使用include_once 因為有用session
 * php echo 接雙引號還是單引號 雙引號會解析變數和轉義字符，而單引號則不會
 * 有些功能獨立寫到api 而非全部塞到一個檔案處理 後面維護麻煩 如果有錯不容易找到或要改好幾個地方
============================================================== */

session_start();
// 啟用 session：讓網頁可以記錄使用者狀態（如登入、計數等）
// 每個需要使用 Session 的頁面，都要先呼叫 session_start()
// 用來在不同網頁間，保存使用者資料的機制

date_default_timezone_set("Asia/Taipei");
// 設定預設時區為台北，避免時間錯誤


// 二、撰寫輔助用的全域函式：輔助函式
/* ==============================================================
1. 共 dd  q  to 三組函式： 除錯 / 資料庫 / 跳轉
2. 宣告在共用的引入檔中，做為全域隨時可以呼叫的工具函式
3. 不用放到類別中，獨立在 DB 類別之外
============================================================== */

// 陣列除錯用/測試用輔助函數，格式化輸出內容，方便開發時檢查資料
function dd($array)
{
    echo "<pre>";     // 格式化輸出
    print_r($array);  // print_r() 以易讀 保持格式化結構 輸出變數的結構和內容
    echo "</pre>";    // 關閉格式化輸出
}

// 複雜SQL語法的簡化函式
//DSN 資料來源/連線名稱 (Data Source Name)
//PDO (PHP Data Objects)
// PDO也是一個物件
// 資料庫設定資料：資料庫位置和名稱
// 使用者名稱
// 密碼（空白
function q($sql)
{
    $dsn = 'mysql:host=localhost;dbname=db09;charset=utf8';
    $pdo = new PDO($dsn, 'root', '');
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// classDB函式處理不了 解決聯表查詢或是子查詢 執行複雜 SQL 查詢
/* ==============================================================
只有題組三會用到 直接執行SQL語句，並返回結果 不會用到class DB
$movies = q("select `movie` from `orders` group by `movie`");
foreach($movies as $movie){
    echo "<option value='{$movie['movie']}'>{$movie['movie']}</option>";
}
*/


// 將sql句子帶進pdo的query方法中，並以fetchAll()方式回傳所有的結果
/*
執行 SQL 查詢並返回結果
fetchAll(PDO::FETCH_ASSOC) 取得所有結果，並以關聯陣列形式返回資料
PDO::FETCH_ASSOC 只返回 關聯陣列(二維)key=value，不返回數字索引
自訂函式用 return 回傳資料
共三組參數 pdo  // query($sql) 執行SQL查詢  // fetchAll(PDO::FETCH_ASSOC)取回全部關聯陣列
*/

// 回傳值 fetchAll()
/*
參考 https://mackliu.github.io/php-book/2021/09/21/php-lesson-04/
PDO:: PHP範圍解析運算符，用雙冒號 :: 表示
存取 類別常數：存取 PDO 類別中定義的常數
存取 PDO類別 的 FETCH_ASSOC 常數
::「進入」一個類別，存取內部的靜態內容（常數、靜態方法、靜態屬性）的符號
*/

// PDO 類別常數
/*
PDO::FETCH_ASSOC  回傳 帶欄位 名稱的資料
關聯陣列 ['name' => 'John', 'age' => 25]

PDO::FETCH_NUM    回傳 帶欄位 索引的資料
索引陣列 [0 => 'John', 1 => 25]
============================================================== */

// 錄製_2025_06_24_09_36_32_40-1300-步驟3 建立共用函式檔
// 對照OOP-db.php FN all()寫法


// 接收一個參數 $url（要跳轉的目標網址）
function to($url)
{
    header("location: $url"); 
    // header("location:" . $url); 雙引號內 直接以空格區分不同字串或變數
    // header() 函數發送 HTTP 標頭Location
    // 標頭Location 會告訴瀏覽器 跳轉到指定的網址
    // . $url 將參數中的網址串接到 "location:" 後面
}

/* 頁面導(定)向輔助函式：PHP檔頭管理指令-header()
1. 重新導向/跳轉 到指定網址 可為內部首頁、外部網址、相對路徑
2. 跳轉時帶參數 to("profile.php?id=123");
3. 跳轉到首頁 to("index.php") 
    伺服器 發送 HTTP 標頭：Location: login.php
    瀏覽器 接收標頭
    瀏覽器 自動跳轉到 login.php
4. 常見使用情境 不用前後端一直跳頁
    // 表單提交後跳轉
    if($_POST['submit']) {
        // 處理表單...
        to("success.php");
    }
*/

// 三、資料庫操作類別 (Database Access Object, DAO)
/* ======================================================================
1. 簡化自訂函式：用物件導向的方式 簡化自訂函式的撰寫
2. 考量檢定時間限制，並不是全面採用OOP
3. 只是把常用的自訂函式，包裝成一個 資料庫DB類別(Class DB)
======================================================================== */

// 步驟1 宣告類別DB
// 類別名稱：大寫開頭
class DB
{

    // 步驟2 宣告屬性/變數  
    // PDO連線的建立方式  
    // 2-1 建立資料庫基本資料  $dsn  $pdo=new PDO()
    // host => 主機名稱或是位置IP / charset => 使用的字元集，一般選utf8 / dbname => 使用的資料庫名稱
    private $dsn = "mysql:host=localhost;dbname=db09;charset=utf8";

    // 2-2 建立PDO物件 連線資料庫
    private $pdo;  // 這裡存放另一個物件（PDO物件)

    // 2-3 讓每個 DB 物件記住自己要操作哪個資料表！
    private $table;  // $this->table = 資料表名稱


    // 步驟3 建構函式/建構子
    // 在建構時帶入 table資料表名稱時 會建立資料庫的連線
    // 建立物件時 自動執行
    // 物件被實例化(new DB)時 會先執行的方法
    function __construct($table)
    {
        $this->table = $table;  // $this替換 資料表名稱 帶參數的概念
        $this->pdo = new PDO($this->dsn, 'root', '');
    }

    // 3-1 使用 [$this->屬性名稱(不用$)]  存取 物件的屬性(變數)

    // 3-2 $this->dsn = $dsn = "mysql:host=localhost;dbname=db09;charset=utf8"
    /*
     * PHP 內建類別PDO 不需要自己宣告
     * 同時建立另一個PDO物件(內部建立的PDO物件)，存放在$this->pdo屬性中
     * 物件包含物件的概念 建構子 之下有兩個$this
     */


    // 步驟4 自訂函式-CRUD / CURD
    // 共7個FN：const  all//find(查R)  count(額外加)  save(增C.改U)//del(刪D)  arraytosql
    
    // 4-1 $Table->all()-查詢 符合條件的 "全部資料" select *
    // 五組變數 $sql  三個if  return
    /*
     * 使用 "..." 可變/不定(數量的)參數  三個點點點...
     * (...$arg) 不定參數陣列，表示可以接收0個或多個參數
     * 參數 會被包裝成陣列 $arg
     * 如果有傳入參數$arg[0][1]，則根據參數來修改 SQL 語句
     * all();                             // 0個參數 ✓
     * all(['name' => 'John']);           // 1個參數 ✓  
     * all(['age' => 25], "ORDER BY id"); // 2個參數 ✓
     */
    function all(...$arg)
    {
        // 步驟1：建立查詢語句
        // 查詢 基本語句，選取資料表所有欄位
        // $this->table = 資料表名稱  'title'
        // 輸出 $sql = "select * from title"
        $sql = "select * from $this->table";

        // 步驟3：處理第一個參數
        // isset()  檢查是否成立 有傳入資料
        if (isset($arg[0])) {

            // 步驟4：is_array() 如果有資料 且 第一個參數是陣列
            if (is_array($arg[0])) {

                // 步驟2：arraytosql() 將陣列 轉為SQL字串
                // 簡稱 a2s()
                $tmp = $this->arraytosql($arg[0]);

                $sql = $sql . " where " . join(" AND ", $tmp);
                // 拚接sql語句
                // 留意 (點.)運算子  WHERE前後有空格
                // AND拼接 WHERE 條件字串
                // 將語法字串及參數帶入 取得一個完整的SQL句子

                // join() 是 PHP 函數，將陣列元素 串接成字串
                // 第一個參數 " AND " 是分隔符號 連接 多條件查詢
                // 第二個參數 $tmp 是要串接的陣列

                // "AND" 連接多個查詢條件
                // 如果$tmp為SQL多條件字串
                // join(" AND ", ['id' => 1, 'name' => 'John'])
                // 輸出：`id`='1' AND `name`='John'  (`id`=1 數字可不用' ')
                // 整個 $sql 輸出
                // select * from users where `id`='1' AND `name`='John'


                // 如果第一個參數不是陣列，則直接附加到SQL語句後
            } else {
                $sql .= $arg[0];
                // $sql = $sql . $arg[0];
                // 將原本 $sql 變數內容保留，並在後面 加上新內容
                // 例如 $sql .= " where id=1"
                // $sql = "select * from title where `id`='1'
                // 程式假設使用者傳入完整 SQL 片段，不用再加"where"
            }
        }

        // .= 是一個 複合-賦值-運算符：相當在原來的字串後面加上新的內容
        /*
        * $variable .= $value 等同於 $variable = $variable . $value。
        * 結合了 字串串接 (string concatenation) 和 賦值 (assignment) 的功能 
        * "=" 賦值 運算符，用於將一個值賦給一個變數。
        * "." 字串串接 運算符，用於將兩個字串連接在一起。
        * 將右邊的值附加到左邊變數的值之後，然後將結果賦值給左邊的變數
        * $variable .= $value 先將 $variable 的值與 $value 的值串接，然後將結果存回 $variable
        */

        // 步驟5：處理第二個參數
        // 如果有第二個參數，則附加到SQL語句 where之後
        // 例如：$sql .= " order by id desc"
        // 第二參數 可為條件句-兩者之間BETWEEN  特殊指定IN 
        // 或 限制句 如 排序ORDER BY 或 限制筆數LIMIT
        // 
        // 例如：$arg[1] = " order by id desc"
        // 例如：$sql = "select * from title order by id desc"
        if (isset($arg[1])) {
            $sql .= $arg[1];
        }

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        // 共三組參數 $this->pdo // query($sql) 執行 SQL 查詢  // fetchAll(PDO::FETCH_ASSOC)取回全部關聯陣列

    }

    // 4-5 查詢 資料筆數 select count(*) 之後7/1才補上的函數-進行more判斷並在db.php中增count函式
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
        // 如果有第二個參數，則附加到SQL語句where之後
        if (isset($arg[1])) {
            $sql .= $arg[1];
        }

        return $this->pdo->query($sql)->fetchColumn();
        // fetchColumn() 只返回第一列的第一個欄位值
        // 例如：如果查詢結果是 10 筆資料，則返回 10

    }

    // 4-2 $Table->find($id)-查詢 符合條件的 "單筆資料" select *
    // 複製all()，變數改為($id)  刪除isset()
    /*
     * 找某個特定id的資料  回傳資料表 指定id的資料 
     * find() 函數 - 固定參數  VS 不定參數
     * $id 一定存在，因為是必要參數
     * 只需要檢查 $id「類型」，不用檢查「是否存在isset()」
     * find();           // ❌ 錯誤！缺少必要參數
     * find(1);          // ✓ 正確
     * find(['name' => 'John']); // ✓ 正確
     * 比較
     * all(...$arg)：不定參數 → 需要用 isset() 檢查參數是否存在
     * find($id)：固定參數 → 參數一定存在，只需檢查參數的內容/類型
     */
    function find($id)
    {
        $sql = "select * from $this->table ";  // 資料表

        // 如果 $id 是陣列
        if (is_array($id)) {

            //執行內部方法4-6 a2s()
            // 將陣列轉換為字串
            $tmp = $this->arraytosql($id);

            //拚接sql語句
            $sql = $sql .
                " where " . join(" AND ", $tmp);

            // 如果 $id 不是陣列  是其他類型
        } else {

            //拚接sql語句
            $sql .= " WHERE `id`='$id'";
        }

        //echo $sql;
        //將sql句子帶進pdo的query方法中，並以fetch的方式回傳一筆資料結果
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    // 4-4 儲存資料：update、insert
    // 先寫出update、insert 兩個部分
    /*
     * $array 要儲存的資料陣列
     * 利用新增和更新語法的特點，整合兩個動作為一個，
     * 簡化函式的數量並提高函式的通用性
     * $arg 必須是陣列，但考量速度，程式中沒有特別檢查是否為陣列
     * 
     */



    function save($array)
    {
        // 先判斷有沒有id 決定 新增 或 更新
        // 如果 $array 中有 'id' 鍵
        if (isset($array['id'])) {

            // 步驟1 update set
            // 建立更新資料的 SQL 語句 UPDATE `table` SET
            $sql = " update $this->table set ";

            $tmp = $this->arraytosql($array);  // 將陣列轉換為字串

            // 拚接 SQL 語句
            // join()位置不同
            $sql .= join(" , ", $tmp) .
                " where `id`= '{$array['id']}' ";

            // 如果 $array 中 沒有 'id' 鍵    
        } else {

            // 步驟2 insert into
            $cols = join("`,`", array_keys($array));
            // $cols 取得 欄位名稱
            // array_keys()
            // 將陣列的鍵名轉換為字串，並用逗號分隔
            // 例如 $array = [
            //     'name' => 'John',
            //     'age' => 25,
            //     'email' => 'john@example.com'
            // ];
            // 取得陣列key：將key或index取出為一個陣列

            // 輸出：name(`,`)age(`,`)age
            // 之後加上 前後引號(`$cols`) 就完美了

            $values = join("','", $array);
            // $values 取得 欄位值
            // 關聯陣列使用 join() ，PHP 只會使用值（value），會忽略鍵（key）
            // 另一個函式    也可以取得索引=>值
            // Array
            // (
            // [0] => name
            // [1] => age
            // )

            // 建立新增資料SQL語句 insert into 表/欄位/值
            $sql = "insert into $this->table (`$cols`) values('$values')";
        }

        return $this->pdo->exec($sql);
    }


    // 4-3 刪除資料
    // 複製find()
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
    // 查詢query($sql) 改成 執行exec($sql) 後面刪除fetch()
    // 執行sql語句，但不返回資料，而是返回影響的資料筆數，適合使用在"新增，更新"或"刪除"資料時

    // 4-6 簡稱 a2s()將陣列轉換為SQL字串 
    // 將陣列轉換為 SQL 條件字串
    // 例如：arraytosql(['id' => 1, 'name' => 'John'])
    // 輸出：['`id` = \'1\'', '`name` = \'John\'']
    // 用於生成 SQL 查詢條件
    // 這個函式會被 all()、find()、save() 和 del() 使用
    private function arraytosql($array)
    {
        // 步驟2：初始化一個空陣列 $tmp
        $tmp = [];

        // 步驟1：先寫 foreach 迴圈
        foreach ($array as $key => $value) {
            $tmp[] = " `$key` = '$value' ";
        }

        // 步驟3：回傳 $tmp 陣列
        // 將每個鍵值對轉換為 SQL 條件字串
        return $tmp;
    }
}

// 建立資料庫物件
/*
 * 使用 new語法 建立一個DB連線物件，並將這個物件指定給一個變數$DB
 * 類似 宣告$pdo= new DB($dsn,'root','')

 * 變數$DB(大寫開頭) = new DB('資料表名稱');
 * 資料表名稱 實務上 用複數 較理想['titles']  因應檢定考試取巧之需
 * 可與單數形式的資料欄位區分

 * 建立一個專門處理 [ title 資料表] 的 [ 物件 $Title ]
 * $Title 物件變數  ['title'] 數值/參數
 * 用法 $this->table = $title = $Title->find(1)
 * -> 是 PHP物件運算子，用來呼叫物件的方法或存取物件的屬性。
 */

$Title = new DB('title');  // 用複數較理想 要加s ['titles'] 
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
 * 第一次訪問
    $_SESSION['visit'] 不存在 → 執行計數邏輯
    假設資料庫中 total = 100
    執行後：total = 101，$_SESSION['visit'] = 1

 * 同一使用者再次訪問（重新整理頁面等）
    $_SESSION['visit'] = 1 已存在 → 跳過計數邏輯，不重複加 1
*/