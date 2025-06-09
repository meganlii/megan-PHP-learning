<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<h1>成績是否及格判斷</h1>
<h3>第一種寫法</h3>
<?php
// 宣告變數
$score=50;

// 先顯示 echo結果：移到判斷式前面，不影響結果
echo "你的成績：".$score."分";
// echo "你的成績：$score 分";
echo "<br>";
echo "判定結果：";

// 執行判斷式 if..else
if($score >= 60){
    echo'及格';
}else{
    echo'不及格';
}

?>

<h3>第二種寫法：echo html元素+變數+字串</h3>
<?php
$score=50;
if($score>=60){    
    // echo "<span style='color:green'>及格</span>";
    echo "<h1 style='color:green'>及格</h1>";
}else{
    echo "<h3 style='color:red'>不及格</h3>";
}

?>

<H1>成績等級判斷</H1>
<h3>老師範例</h3>
<?php

$score=60;
if($score>=90 && $score<=100){
    echo 'A';
    
}else if($score>=75 && $score <=89){
    echo 'B';
    
}else if($score>=60 && $score<=74){
    echo 'C';   
    
}else{
    echo 'D';    
}


$score=60;
if($score>=90 && $score<=100){
    echo 'A';
}else{    
    if($score>=75 && $score <=89){
        echo 'B';
    }else{        
        if($score>=60 && $score<=74){	
        	echo 'C';        
        }else{
            echo 'D';
        }        
    }
}

?>

</body>
</html>