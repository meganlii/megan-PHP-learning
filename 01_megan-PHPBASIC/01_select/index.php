<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        h1 {
            width: 100%;
            background-color: lightblue;
        }

        h2 {
            color: blue;
        }
    </style>
</head>

<body>
    <h1>練習一：判斷 成績是否及格 / if else二選一 / if 單選</h1>
    <h2>[第一種寫法]</h2>
    <?php
    // 宣告變數
    $score = 50;

    // 先顯示 echo結果：移到判斷式前面，不影響結果
    echo "你的成績：" . $score . "分";
    // echo "你的成績：$score 分";
    echo "<br>";
    echo "判定結果：";

    // 執行判斷式 if..else
    if ($score >= 60) {
        echo '及格';
    } else {
        echo '不及格';
    }

    ?>

    <h2>[第二種寫法] echo html元素+變數+字串</h2>
    <?php
    $score = 50;
    if ($score >= 60) {
        // echo "<span style='color:green'>及格</span>";
        echo "<h1 style='color:green'>及格</h1>";
    } else {
        echo "<h3 style='color:red'>不及格</h3>";
    }

    ?>

    <h2>[第三種寫法] [第一種寫法]加上 內建函式 !is_numeric 與 exit() </h2>
    <?php
    $score = "100";
    if (!is_numeric($score) || $score < 0 || $score > 100) {
        echo "請輸入合法的成績數字";
        exit();
        // exit()：與echo()一樣，屬於 內建函式
    }

    echo "你的成績：" . $score . "分";
    echo "<br>";
    echo "判定結果：";

    if ($score >= 60) {
        echo "<span style='color:green'>及格</span>";
    } else {
        echo "<span style='color:red'>不及格</span>";
    }

    ?>

    <h1>練習二：判斷 成績等級 / if elseif 多選一 / 由多組if else合併</h1>
    <h2>[巢狀迴圈] 難以閱讀及維護</h2>
    <?php
    $score = 60;
    if ($score >= 90 && $score <= 100) {
        echo 'A';
    } else {
        if ($score >= 75 && $score <= 89) {
            echo 'B';
        } else {
            if ($score >= 60 && $score <= 74) {
                echo 'C';
            } else {
                echo 'D';
            }
        }
    }

    ?>

    <h2> [語法結構 簡化] </h2>
    <?php

    $score = 70;
    if ($score >= 90 && $score <= 100) {
        echo 'A';
    } else if ($score >= 75 && $score <= 89) {
        echo 'B';
    } else if ($score >= 60 && $score <= 74) {
        echo 'C';
    } else {
        echo 'D';
    }

    ?>

    <h2> [程式邏輯 再簡化] if/else if 多選一</h2>
    <?php
    $score = 80;

    // 先顯示 echo結果：移到判斷式前面，不影響結果
    // 如果不加這三行，只會顯示 B
    echo "你的成績：$score 分";  //你的成績：80分
    echo "<br>";                // 換行
    echo "判定等級：";           // 判定等級：B

    // 新增 檢查條件
    if ($score < 0 && $score > 100) {

        echo "注意:成績應該在0~100之間";
    } else if ($score >= 90) {

        echo 'A';
    } else if ($score >= 75) {

        echo 'B';
    } else if ($score >= 60) {

        echo 'C';
    } else {

        echo 'D';
    }

    ?>

    <h1>練習三：依據成績等級給予評價 / switch case</h1>
    <h2>根據學生不同的成績等級，在網頁上印出不同的文字評價</h2>
    <?php
    // 等級(大寫字母) 要用字串，加""
    $level = "A";
    switch ($level) {
        case "A":
            echo "很棒";
            break;
        case "B":
            echo "GOOD JOB";
            break;
        case "C":
            echo "加油";
            break;
        case "D":
            echo "加加油";
            break;
        case "E":
            echo "要很加油";
            break;
        default:
            echo "請告知工程人員,修復錯誤";
    }


    ?>

    <h1>練習四：閏年判斷，給定一個西元年份，判斷是否為閏年</h1>

    <ul>
        <li>地球對太陽的公轉一年的真實時間大約是365天5小時48分46秒，因此以365天定為一年 的狀況下，每年會多出近六小時的時間，所以每隔四年設置一個閏年來消除這多出來的一天。</li>
        <li>公元年分 除以4 不可整除，為平年。</li>
        <li>公元年分 除以4 可整除，但 除以100不可整除，為閏年。</li>
        <li>公元年分 除以100 可整除，但 除以400不可整除，為平年。</li>
    </ul>

    <!-- 簡化規則 -->
    <ul>
        <li>能被4整除，但不能被100整除的年份 → 閏年</li>
        <li>能被400整除的年份 → 閏年</li>
    </ul>

    <?php
    $year = 2204;

    // 運算子：%取餘數、!= 「不等於」
    if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
        echo "閏年";
    } else {
        echo "平年";
    }
    ?>

</body>

</html>