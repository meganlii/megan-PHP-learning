<?php
// 1.建立 PDO連線：兩個變數
    // 1-1 建立 資料庫基本資料，主要是資料庫系統名稱，主機名稱，使用的資料庫
    // host => 主機名稱或是IP
    // dbname => 使用的資料庫名稱
    // charset => 使用的字元集，一般選utf8即可
$dsn="mysql:host=localhost ; dbname=school ; charset=utf8";

    // 1-2 創建 新的new PDO 物件，用來連接到資料庫
    // $dsn 是資料庫的連接字符串，'root' 是用戶名，''是密碼（這裡是空的）
$pdo=new PDO($dsn, 'root', '');

// 2. 建立 SQL 查詢指令 select查詢比對之用
// 從 students 表中 選取 所有欄位， 條件是 id 等於 10
$sql="select * from students where id<=20";

// 3. 傳遞 SQL：使用 PDO函式
// sign up 新增/註冊 $pdo->exec($sql)
// $pdo->query($sql)->fetchAll()  一次取回多筆
// 執行 SQL 查詢 並 使用 fetchAll(PDO::FETCH_ASSOC) 獲取所有結果

// 4. 取得回傳值：以函式取得回傳值，並指定給變數
// 返回一個 二維關聯陣列，鍵名是欄位名稱
$rows=$pdo  ->query($sql)   ->fetchAll(PDO::FETCH_ASSOC);
// echo "<pre>";
// print_r($rows);;
// echo "</pre>";

?>


<!-- <table>加 css -->
<style>
table {
    width: 50%;
    border-collapse: collapse;
    margin: 20px auto;
}
th, td {
    border: 1px solid #ddd;
    padding: 5px 12px;
    text-align: center;
}
</style>

<!-- 將查詢結果 $rows 動態顯示在一個 HTML 表格中 -->
<!-- 1.創建一個 HTML 表格，標題欄顯示 id、學號、姓名、生日 和 電話 -->
<!-- 2.使用 foreach 迴圈遍歷 $rows 中的每一筆學生記錄。 -->
<!-- 3.為每筆記錄生成一行的表格數據，動態顯示學生的詳細資訊。 -->

<!-- html 表格 開頭 -->
<table>
    <tr>
        <th>id</th>
        <th>學號</th>
        <th>姓名</th>
        <th>生日</th>
        <th>電話</th>
    </tr>

<!-- php foreach 迴圈開始 -->
    <!-- 開始 PHP 程式碼區塊 -->
    <!-- 結束 PHP ，接下來進入 HTML -->
    <?php 
    foreach($rows as $row){
    ?>

<!-- HTML 表格數據行 -->
<!-- 加 PHP 簡寫語法<> 放陣列$row[] -->
<!-- 等價 <?php echo $row['id']; ?> -->
<!-- 用來輸出 $row 中 id 欄位的值，例如 1 -->
    <tr>
        <td><?=$row['id'];?></td>
        <td><?=$row['school_num'];?></td>
        <td><?=$row['name'];?></td>
        <td><?=$row['birthday'];?></td>
        <td><?=$row['tel'];?></td>
    </tr>

<!-- php foreach 迴圈結束 -->
    <!-- 重新進入 PHP 程式碼區塊 -->
    <!-- 結束 foreach 迴圈 -->
    <!-- 結束 PHP -->
    <?php 
    }
    ?>

<!-- html 表格結尾 結束 -->
</table>