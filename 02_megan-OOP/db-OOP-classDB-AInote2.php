<?php
<?php // PHP 檔案開頭
// 重複的 <?php 可以刪除，保留一個即可

session_start(); // 啟動 session，讓網頁可以記錄使用者狀態（如登入、計數等）
date_default_timezone_set("Asia/Taipei"); // 設定預設時區為台北，避免時間錯誤

function dd($array){
    // 陣列除錯用，格式化輸出內容，方便開發時檢查資料
    echo "<pre>";
    print_r($array); // 印出陣列內容
    echo "</pre>";
}

function q($sql){
    // 執行 SQL 查詢，回傳所有結果（關聯式陣列）
    $dsn='mysql:host=localhost;dbname=db09;charset=utf8'; // 資料庫連線字串
    $pdo=new PDO($dsn,'root',''); // 建立 PDO 物件，連線資料庫
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC); // 執行查詢並回傳所有資料
}

function to($url){
    // 重新導向到指定網址
    header("location:".$url); // 送出 HTTP 重新導向標頭
}

// 資料庫操作類別，封裝常用的 CRUD 方法
class DB{
private $dsn="mysql:host=localhost;dbname=db09;charset=utf8"; // 資料庫連線字串
private $pdo;   // PDO 物件，負責連線與執行 SQL
private $table; // 資料表名稱

function __construct($table){
    // 建構式，初始化 PDO 並設定資料表
    $this->table=$table; // 設定要操作的資料表
    $this->pdo=new PDO($this->dsn,"root",''); // 建立 PDO 物件
}

function all(...$arg){
    // 取得全部資料，可加條件或排序
    $sql="select * from $this->table "; // 基本查詢語法
    if(isset($arg[0])){
        if(is_array($arg[0])){
            // 若條件為陣列，轉換成 SQL 語法
            $tmp=$this->arraytosql($arg[0]);
            $sql=$sql." where ".join(" AND " , $tmp); // 多條件用 AND 連接
        }else{
            // 若條件為字串，直接加到 SQL
            $sql .= $arg[0]; // 例如 "where xxx"
        }
    }

    if(isset($arg[1])){
        // 第二個參數可加排序等
        $sql .= $arg[1]; // 例如 "order by xxx"
    }

    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC); // 執行查詢並回傳結果
}

function count(...$arg){
    // 計算資料筆數，可加條件
    $sql="select count(*) from $this->table "; // 計算筆數
    if(isset($arg[0])){
        if(is_array($arg[0])){
            $tmp=$this->arraytosql($arg[0]);
            $sql=$sql." where ".join(" AND " , $tmp); // 多條件
        }else{
            $sql .= $arg[0]; // 字串條件
        }
    }

    if(isset($arg[1])){
        $sql .= $arg[1]; // 例如排序
    }

    return $this->pdo->query($sql)->fetchColumn(); // 執行查詢並回傳計數
}

function find($id){
    // 查詢單筆資料（可用 id 或條件陣列）
    $sql="select * from $this->table "; // 查詢語法
    
    if(is_array($id)){
        // 若為陣列，組成 where 條件
        $tmp=$this->arraytosql($id);
        $sql=$sql." where ".join(" AND " , $tmp); // 多條件
    }else{
        // 若為 id，直接查詢
        $sql .= " WHERE `id`='$id'"; // 用主鍵查詢
    }
    //echo $sql; // 除錯用
    return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC); // 回傳單筆資料（關聯式陣列）
}

function save($array){
    // 儲存資料（有 id 則更新，無 id 則新增）
    if(isset($array['id'])){
        // update 更新資料
        $sql="update $this->table set "; // 更新語法
        $tmp=$this->arraytosql($array); // 轉換欄位
        $sql.= join(" , ",$tmp) . "where `id`= '{$array['id']}'"; // 設定條件
    }else{
        // insert 新增資料
        $cols=join("`,`",array_keys($array)); // 欄位名稱
        $values=join("','",$array); // 欄位值
        $sql="insert into $this->table (`$cols`) values('$values')"; // 新增語法
    }

    return $this->pdo->exec($sql); // 執行 SQL（回傳影響筆數）
}

function del($id){
    // 刪除資料（可用 id 或條件陣列）
    $sql="delete  from $this->table "; // 刪除語法
    
    if(is_array($id)){
        $tmp=$this->arraytosql($id);
        $sql=$sql." where ".join(" AND " , $tmp); // 多條件
    }else{
        $sql .= " WHERE `id`='$id'"; // 用主鍵刪除
    }
    //echo $sql; // 除錯用
    return $this->pdo->exec($sql); // 執行刪除
}

private function arraytosql($array){
    // 將陣列轉換成 SQL 條件語法
    $tmp=[];
    foreach($array as $key => $value){
        $tmp[]="`$key`='$value'"; // 產生 `欄位`='值' 格式
    }

    return $tmp; // 回傳條件陣列
}

}

// 建立各資料表的物件，方便操作（每個物件代表一個資料表）
$Title=new DB('title');   // 標題資料表
$Ad=new DB('ad');         // 廣告資料表
$Mvim=new DB('mvim');     // 動畫資料表
$Image=new DB('image');   // 圖片資料表
$News=new DB('news');     // 新聞資料表
$Admin=new DB('admin');   // 管理員資料表
$Menu=new DB('menu');     // 選單資料表
$Total=new DB('total');   // 計數資料表
$Bottom=new DB('bottom'); // 頁尾資料表

if(!isset($_SESSION['visit'])){
    // 第一次來訪，計數器加一
    $t=$Total->find(1); // 取得 id=1 的資料（假設只有一筆）
    $t['total']++;      // total 欄位加一
    $Total->save($t);   // 更新資料表
    $_SESSION['visit']=1; // 設定 session，避免重複計算
}

?>