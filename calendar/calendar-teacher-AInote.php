<?php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>線上日曆</title>
    <style>
        /* CSS 樣式：設定日曆外觀 */
        h1{ text-align:center; color:blue; }
        table{ min-width:60%; border-collapse:collapse; margin:0 auto; }
        td{ border:1px solid blue; text-align:center; padding:5px 10px; }
        .today{ background-color:yellow; font-weight:bold; }
        .other-month{ background-color:gray; color:#aaa; }
        .holiday{ background-color:pink; color:white; font-size:12px; }
        tr:not(tr:nth-child(1)) td:hover{ background-color:lightblue; cursor:pointer; font-size:16px; font-weight:bold; }
        .pass-date{ color:#aaa; }
        .date-num{ font-size:14px; text-align:left; }
        .date-event{ height:40px; }
        .box,.th-box{ width:60px; height:80px; background-color:lightblue; display:inline-block; border:1px solid blue; box-sizing:border-box; margin-left:-1px; margin-top:-1px; vertical-align:top; }
        .box-container{ width:420px; margin:0 auto; box-sizing:border-box; padding-left:1px; padding-top:1px; }
        .th-box{ height:25px; text-align:center; }
        .day-num,.day-week{ display:inline-block; width:50%; }
        .day-num{ color:#999; font-size:14px; }
        .day-week{ color:#aaa; font-size:12px; text-align:right; }
    </style>
</head>
<body>
<!-- 日曆外框（註解掉的範例） -->
<!-- <div class="box-container">
<?php
/* for($i=0;$i<20;$i++){
    echo "<div class='box'>";
        echo $i;
    echo "</div>";
} */
?>
</div> -->
 
 <h1>線上日曆</h1>  

 <?php
// 取得目前瀏覽的月份與年份，若無則預設為本月本年
if(isset($_GET['month'])){
    $month=$_GET['month'];  
}else{
    $month=date("m");
}

if(isset($_GET['year'])){
    $year=$_GET['year'];
}else{
    $year=date("Y");
}

// 計算上一個月與下一個月的數值（用於切換月份）
if($month-1>0){
    $prev=$month-1;  //上一個月
    $prevyear=$year;
}else{
    $prev=12;  //上一個月
    $prevyear=$year-1;
}

if($month+1>12){
    $next=1;  //下一個月
    $nextyear=$year+1;
}else{
    $next=$month+1;  //下一個月
    $nextyear=$year;
}

// 計算本月第一天、今天、第一天是星期幾、這個月有幾天
$today = date("Y-$month-d");
$firstDay = date("Y-$month-01");
$firstDayWeek = date("w", strtotime($firstDay)); // 0=星期日
$theDaysOfMonth=date("t", strtotime($firstDay)); // 本月天數

// 特殊節日資料（key:日期，value:節日名稱）
$spDate=[
    '2025-04-04'=>'兒童節',
    '2025-04-05'=>'清明節',
    '2025-05-11'=>'母親節',
    '2025-05-01'=>'勞動節',
    '2025-05-30'=>'端午節',
    '2025-06-06'=>"生日"
];

// 代辦事項資料（key:日期，value:事項）
$todoList=[ '2025-05-01'=>'開會' ];

// 儲存每一天的資料
$monthDays=[];

// 填入本月第一天前的空白（補齊星期）
for($i=0;$i<$firstDayWeek;$i++){
    $monthDays[]=[];
}

// 填入本月每一天的資料
for($i=0;$i<$theDaysOfMonth;$i++){
    $timestamp = strtotime(" $i days", strtotime($firstDay)); // 取得每一天的時間戳
    $date=date("d", $timestamp);
    $holiday="";
    // 判斷是否為特殊節日
    foreach($spDate as $d=>$value){
        if($d==date("Y-m-d", $timestamp)){
            $holiday=$value;
        }
    }
    $todo='';
    // 判斷是否有代辦事項
    foreach($todoList as $d=>$value){
        if($d==date("Y-m-d", $timestamp)){
            $todo=$value;
        }
    }
    // 儲存當天的各種資訊
    $monthDays[]=[
        "day"=>date("d", $timestamp),
        "fullDate"=>date("Y-m-d", $timestamp),
        "weekOfYear"=>date("W", $timestamp),
        "week"=>date("w", $timestamp),
        "daysOfYear"=>date("z", $timestamp),
        "workday"=>date("N", $timestamp)<6?true:false,
        "holiday"=>$holiday,
        "todo"=>$todo
    ];
}

/* 除錯用：印出 $monthDays 陣列
echo "<pre>";
print_r($monthDays);
echo "</pre>"; */
?>

<!-- 上一月、下一月的切換連結 -->
<div style="display:flex;width:60%;margin:0 auto;justify-content:space-between;">
    <a href="?year=<?=$prevyear;?>&month=<?=$prev;?>">上一月</a>
    <a href="?year=<?=$nextyear;?>&month=<?=$next;?>">下一月</a>
</div>

<!-- 顯示目前年月 -->
<h2><?=$year;?>年<?=$month;?>月</h2>

<?php
// 建立日曆外框及星期標題
echo "<div class='box-container'>";
echo "<div class='th-box'>日</div>";
echo "<div class='th-box'>一</div>";
echo "<div class='th-box'>二</div>";
echo "<div class='th-box'>三</div>";
echo "<div class='th-box'>四</div>";
echo "<div class='th-box'>五</div>";
echo "<div class='th-box'>六</div>";

// 使用 foreach 迴圈印出每一天
foreach($monthDays as $day){
    echo "<div class='box'>";
    echo "<div class='day-info'>";
        echo "<div class='day-num'>";
        // 顯示日期（若為空白則顯示空格）
        if(isset($day['day'])){
            echo $day["day"];
        }else{
            echo "&nbsp;";
        }
        echo "</div>";
        echo "<div class='day-week'>";
        // 顯示週次（若為空白則顯示空格）
        if(isset($day['weekOfYear'])){
            echo $day["weekOfYear"];
        }else{
            echo "&nbsp;";
        }
        echo "</div>";
    echo "</div>";

    // 顯示節日
    echo "<div class='holiday-info'>";
    if(isset($day['holiday'])){
        echo "<div class='holiday'>";
        echo $day['holiday'];
        echo "</div>";
    }else{
        echo "&nbsp;";
    }
    echo "</div>";

    // 顯示代辦事項
    echo "<div class='todo-info'>";
    if(isset($day['todo']) && !empty($day['todo'])){
        echo "<div class='todo'>";
        echo $day['todo'];
        echo "</div>";
    }else{
        echo "&nbsp;";
    }
    echo "</div>";
    echo "</div>";
}
echo "</div>";
?>

</body>
</html>