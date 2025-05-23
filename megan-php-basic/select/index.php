<!DOCTYPE html>
<!-- 以上先打html宣告 !+tab -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選擇結構</title>
</head>
<body>

    <h1>判斷成績</h1>
    <P>給定一個成績數字，判斷是否及格(60)分</P>
    <p>1. 不及格用紅色，及格用綠色</p>
    <p>2. 判斷$score是否為數字，如果不是數字，擇題是錯誤</p>


<!-- 要先宣告給php範圍，包在<body>裡面，要再打上？>定義結尾 -->
<?php

// 練習題目1：if…else。給定一個成績數字，判斷是否及格(60)分

// 1.設定條件
$score=50;

// 2.加上echo，顯示網頁文字
echo "你的成績：".$score."分";
echo "<br>";
echo "判定結果：";

// 3.接寫函數
if($score>=60){
    echo "<span style='color:green'>及格</span>";
    // 先打echo ""; 另一行在打<span>，之後剪下貼上
}
else{
    echo "<span style='color:red'>不及格</span>";
}
?>

<!-- 練習題目2：多個ifs用法 if else if -->
<h2>分配成績等級</h2>
<p>給定一個成績數字，根據成績所在的區間，給定等級</p>
<?php


?>

<!-- 練習題目3： -->
<h2>依據學生成績等級給予評價</h2>
<p>根據學生不同的成績等級在網頁上印出不同的文字評價</p>
<?php

?>

<!-- 練習題目4： -->
<h2>閏年判斷，給定一個西元年份，判斷是否為閏年</h2>
<ul>
    <li>地球對太陽的公轉一年的真實時間大約是365天5小時48分46秒，因此以365天定為一年 的狀況下，每年會多出近六小時的時間，所以每隔四年設置一個閏年來消除這多出來的一天。</li>
    <li>公元年分除以4不可整除，為平年。</li>
    <li>公元年分除以4可整除但除以100不可整除，為閏年。</li>
    <li>公元年分除以100可整除但除以400不可整除，為平年。</li>
</ul>
<?php

?>

</body>
</html>

    


