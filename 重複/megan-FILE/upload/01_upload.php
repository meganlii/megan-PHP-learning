<?php
/**
 * 1.建立表單
 * 2.建立處理檔案程式
 * 3.搬移檔案
 * 4.顯示檔案列表
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>檔案上傳</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- 檔案上傳練習- -->

0.建立三個檔案
    頁面A：upload.php
    頁面B：upload.sql 額外建立sql檔案
    頁面C：uploaded_files.php    
    頁面D：manage.php 檔案管理
    edit_upload.php
    del_upload
    save_upload

1.<form></form>建立 HTML 表單：設定三個屬性 
    <!-- 搭配 label 標籤-->
    <label for="name">選擇檔案上傳：</label>
    
    <!-- 連結頁面B：uploaded_files.php -->
    <form action="uploaded_files.php" method="post" enctype="multipart/form-data">
    
    <!-- 設定三個屬性 -->
    <!-- enc 指 encode 縮寫 -->
    action="uploaded_files.php" 設定表單處理程式的 網址
    <!-- 傳送目的地：表單資料傳送到指定網址 -->
    method="post" 設定函式：表單資料傳回web的方法
    enctype="multipart/form-data" 設定編碼方式

2.<input>表單輸入(沒有結束tag)：設定四個屬性
    <input type="file" name="name" id="name" required>

    <!-- 設定四個屬性 -->
    <!-- type有多種，常用file button/submit/reset  checkbox -->
    type="file" 上傳檔案
    name="name" 欄位名稱，也可設定upfile
    
    id="name" 之後指定使用
    required 欄位必填
    multiple 上傳多個檔案 

    <!-- type="hidden" 輔助生成id欄位，前台不顯示 -->
    <input type="hidden" name="id" value="<?=$row['id'];?>">

3.<select></select> + <option>下拉選單
    <select name="type" id="type">
    name="type" 選單名稱：類型
    id="type 之後指定使用
        
        <option value="image">影像</option>
        value="image" 不設name改設value

4.<textarea></textarea>多行文字方塊
    <textarea name="description" id="description"></textarea>
    name="description"
    id="description"

5.<button></button>按鈕
    <button type="submit">上傳檔案</button>
    type="submit"



<!-- ============================== -->

<h1 class="header">檔案上傳練習</h1>
<!----建立你的表單及設定編碼----->

<form action="uploaded_files.php" method="post" enctype="multipart/form-data">
    
    <label for="name">選擇檔案上傳：</label>
    <input type="file" name="name" id="name" required>
    <br>

    <select name="type" id="type">
        <option value="image">影像</option>
        <option value="document">文件</option>
        <option value="video">影片</option>
        <option value="music">音樂</option>
    </select>
    
    <br>
    <textarea name="description" id="description"></textarea>
        
    <br>
    <button type="submit">上傳檔案</button>
</form>



<!----建立一個連結來查看上傳後的圖檔---->  


</body>
</html>