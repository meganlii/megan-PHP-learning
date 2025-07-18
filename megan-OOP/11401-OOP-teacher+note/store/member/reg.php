<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員註冊</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<main>
    <style>
    main {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 80vh;
        justify-content: center;
    }

    form {
        background: #fff;
        padding: 2.5rem 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }

    form h1 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #333;
    }

    form div {
        margin-bottom: 1.2rem;
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 0.5rem;
        color: #444;
        font-weight: 500;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="date"] {
        padding: 0.6rem 0.8rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    input:focus {
        border-color: #007bff;
        outline: none;
    }

    button[type="submit"],
    button[type="reset"] {
        padding: 0.6rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        margin-right: 0.7rem;
        cursor: pointer;
        background: #007bff;
        color: #fff;
        transition: background 0.2s;
    }

    button[type="reset"] {
        background: #6c757d;
    }

    button[type="submit"]:hover {
        background: #0056b3;
    }

    button[type="reset"]:hover {
        background: #495057;
    }
    </style>
    <h1>會員註冊</h1>
    <form action="./api/add_member.php" method="post">
        <div>
            <label for="name">使用者名稱:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">電子郵件:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="acc">帳號:</label>
            <input type="text" id="acc" name="acc" required>
        </div>
        <div>
            <label for="pw">密碼:</label>
            <input type="password" id="pw" name="pw" required>
        </div>
        <div>
            <label for="birthday">生日:</label>
            <input type="date" id="birthday" name="birthday" required>
        </div>
        <div style="display: flex;flex-direction:row; justify-content: space-around;">
            <button type="submit">註冊</button>
            <button type="reset">重置</button>
        </div>
    </form>
</main>
<?php include 'footer.php'; ?>    
</body>
</html>