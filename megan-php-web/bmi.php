<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>計算BMI</title>
    <style>
        .bmi {
            width: 50%;
            height: 30vh;
            background-color: lightpink;

            /* text-align: center; */
        }

        br {
            color: blue;
        }
    </style>
</head>

<body>


    <?php
echo "<div class='bmi'>";

echo "<div class='bmi-1'>";
    echo "<div class='height'>";    
    if(isset($_POST['height'])){    
        echo "身高 cm".$_POST['height']."<br>";
}
    echo "</div>";

    echo "<div class='weight'>";
    if(isset($_POST['weight'])){
        echo "體重 kg".$_POST['weight']."<br>";
}
    echo "</div>";

echo "</div>";

echo "<div class='bmi-2'>";
    // BMI=體重(公斤) 除以 身高(公尺) 的平方
    $bmi=round($_POST['weight']/($_POST['height']*$_POST['weight']),2);
    echo "BMI為:" . $bmi . "<br>";
echo "</div>";

echo "</div>";

?>

    <a href="index.php">返回首頁</a>



</body>

</html>