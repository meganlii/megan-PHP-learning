<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI計算器</title>
</head>
<body>
    <form action="bmi.php" method='post'>
        <div>
            <label for="height">身高(公尺):</label>
            <input type="number" name="height" step="0.01" min="0" required>
        </div>
        <div>
            <label for="weight">體重(公斤):</label>
            <input type="number" name="weight">
        </div>

        <input type="submit" value="計算BMI">
        <input type="reset" value="清空內容">
    </form>

    
</body>
</html>

