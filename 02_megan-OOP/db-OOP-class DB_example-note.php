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

function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function q($sql){
    $dsn='mysql:host=localhost;dbname=db09;charset=utf8';
    $pdo=new PDO($dsn,'root','');
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function to($url){
    header("location:".$url);
}

/*
簡化自訂函式
1. 可用物件導向的方式來簡化自訂函式的撰寫
2. 考量檢定時間限制，並不是全面採用OOP
3. 只是把常用的自訂函式，包裝成一個工具類別(Class)
*/

// 共有 const  all  count  find  save  del  arraytosql
class DB{
private $dsn="mysql:host=localhost;dbname=db09;charset=utf8";
private $pdo;   
private $table;

function __construct($table){
    $this->table = $table;  
    // $this 替換 資料表名稱 
    // 讓每個 DB 物件記住自己要操作哪個資料表！
    $this->pdo = new PDO($this->dsn,"root",''); // 建立PDO物件連接資料庫
}

// 查詢全部資料
function all(...$arg){   
    $sql="select * from $this->table "; // 查詢邏輯
    // $this->table 資料表名稱
    //...$arg 代表 可變-參數陣列
    // 如果有條件陣列，則產生 WHERE 條件
    // 如果沒有條件陣列，則直接查詢全部資料
    // 如果有其他SQL語法，則.join附加 在SQL語句後
    if(isset($arg[0])){
        if(is_array($arg[0])){
            $tmp=$this->arraytosql($arg[0]);  // 產生條件陣列
            $sql=$sql." where ".join(" AND " , $tmp);  // 產生 WHERE 條件

        }else{
            $sql .= $arg[0];    
        }
    }

    if(isset($arg[1])){
        $sql .= $arg[1];
    }

    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function count(...$arg){
    $sql="select count(*) from $this->table ";
    if(isset($arg[0])){
        if(is_array($arg[0])){
            $tmp=$this->arraytosql($arg[0]);
            $sql=$sql." where ".join(" AND " , $tmp);

        }else{
            $sql .= $arg[0];
        }
    }

    if(isset($arg[1])){
        $sql .= $arg[1];
    }

    return $this->pdo->query($sql)->fetchColumn();
}

// 查詢單筆資料
// $id是主鍵值或條件陣列
function find($id){   
    
    $sql="select * from $this->table ";
    
    if(is_array($id)){
        $tmp=$this->arraytosql($id);
        $sql=$sql." where ".join(" AND " , $tmp);

    }else{
        $sql .= " WHERE `id`='$id'";
    }
    //echo $sql;
    return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
}

function save($array){
    if(isset($array['id'])){
        
        //update
        $sql="update $this->table set ";
        $tmp=$this->arraytosql($array);
        $sql.= join(" , ",$tmp) . "where `id`= '{$array['id']}'";
    }else{
        
        //insert
        $cols=join("`,`",array_keys($array));
        $values=join("','",$array);
        $sql="insert into $this->table (`$cols`) values('$values')";
    }

    return $this->pdo->exec($sql);
}

function del($id){
    $sql="delete  from $this->table ";
    
    if(is_array($id)){
        $tmp=$this->arraytosql($id);
        $sql=$sql." where ".join(" AND " , $tmp);

    }else{
        $sql .= " WHERE `id`='$id'";
    }
    //echo $sql;
    return $this->pdo->exec($sql);
}


private function arraytosql($array){
    $tmp=[];
    foreach($array as $key => $value){
        $tmp[]="`$key`='$value'";
    }

    return $tmp;
}

}


$Title=new DB('title'); 
$Ad=new DB('ad');
$Mvim=new DB('mvim');
$Image=new DB('image');
$News=new DB('news');
$Admin=new DB('admin');
$Menu=new DB('menu');
$Total=new DB('total');
$Bottom=new DB('bottom');


if(!isset($_SESSION['visit'])){
    //第一次來訪
    $t=$Total->find(1);
    $t['total']++;
    $Total->save($t);
    $_SESSION['visit']=1;
}





?>