<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員登入</title>
    <link rel="stylesheet" href="style.css">
</head>
    <style>
    .login-container *{
        box-sizing: border-box;
    }
    .login-container {
        max-width: 350px;
        margin: 40px auto;
        padding: 32px 24px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        text-align: center;
    }
    .login-container h2 {
        margin-bottom: 24px;
        color: #333;
        font-weight: 600;
    }
    .login-form .form-group {
        margin-bottom: 18px;
        text-align: left;
    }
    .login-form label {
        display: block;
        margin-bottom: 6px;
        color: #555;
        font-size: 15px;
    }
    .login-form input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.2s;
    }
    .login-form input:focus {
        border-color: #0078d7;
        outline: none;
    }
    .login-btn {
        width: 100%;
        padding: 12px 0;
        background: #0078d7;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 17px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .login-btn:hover {
        background: #005fa3;
    }
    </style>
<body>
<?php include 'header.php'; ?>
<main>
    <div class="login-container">
        <h2>會員登入</h2>
        <?php if(isset($_GET['err'])){
            echo "帳號或密碼錯誤，請重新輸入。";
        } ?>
            
        <form action="./api/login_process.php" method="post" class="login-form">
            <div class="form-group">
                <label for="acc">帳號</label>
                <input type="text" id="acc" name="acc" required autocomplete="username">
            </div>
            <div class="form-group">
                <label for="pw">密碼</label>
                <input type="password" id="pw" name="pw" required autocomplete="current-password">
            </div>
            <button type="submit" class="login-btn">登入</button>
        </form>
    </div>

</main>
<?php include 'footer.php'; ?>    
</body>
</html>