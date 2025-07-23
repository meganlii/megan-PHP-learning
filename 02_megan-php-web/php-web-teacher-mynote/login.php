<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員登入</title>
</head>
<body>
<?php 

if(!isset($_GET['login'])){
?>
    <form action="check.php" method='post'>
        <div>
            <label for="acc">帳號:</label>
            <input type="text" name="acc" step="0.01" min="0" required>
        </div>
        <div>
            <label for="pw">密碼:</label>
            <input type="text" name="pw">
        </div>

        <input type="submit" value="登入">
        <input type="reset" value="清空內容">
    </form>
<?php
}elseif (isset($_GET['login']) && $_GET['login'] == 1){
    echo "登入成功";
}else{
    echo "登入失敗";
}
?>
    
</body>
</html>

