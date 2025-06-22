<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>子字串取用</h2>
    <p>將” The reason why a great man is great is that he resolves to be a great man”只取前十字成為” The reason…”</p>
    
    <?php
    $str="將”The reason why a great man is great is that he resolves to be a great man";
    $str=mb_substr($str,0,10,"utf-8") . "...";
    echo $str;
    ?>

    <h2>尋找字串與HTML、css整合應用</h2>
    <ul>
        <li>給定一個句子，將指定的關鍵字放大</li>
        <li>“學會PHP網頁程式設計，薪水會加倍，工作會好找”</li>
        <li>請將上句中的 “程式設計” 放大字型或變色.</li>
    </ul>

    <?php
    $str="學會PHP網頁程式設計，薪水會加倍，工作會好找";
    
    $key="程式設計";    
    $style="font-size:3em ; color:green";

    $str=str_replace("$key" , "<span style='$style'>$key</span>" , $str);

    echo $str;

    



    ?>

    
</body>
</html>