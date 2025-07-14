<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>線上日曆</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap');

    body {
      font-family: 'Nunito', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      margin: 0;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #fff;
      font-size: 2.5em;
      font-weight: 800;
      text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      margin-bottom: 30px;
      letter-spacing: 2px;
    }

    h2 {
      text-align: center;
      color: #fff;
      font-size: 1.8em;
      font-weight: 700;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
      margin: 20px 0;
    }

    .navigation {
      display: flex;
      width: 60%;
      margin: 0 auto;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .navigation a {
      background: linear-gradient(145deg, #ff6b6b, #ee5a52);
      color: white;
      padding: 12px 24px;
      text-decoration: none;
      border-radius: 25px;
      font-weight: 600;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
      border: 3px solid #fff;
    }

    .navigation a:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
      background: linear-gradient(145deg, #ff5252, #d32f2f);
    }

    .box-container {
      width: 490px;
      margin: 0 auto;
      box-sizing: border-box;
      padding: 20px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 25px;
      backdrop-filter: blur(10px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .th-box {
      width: 60px;
      height: 40px;
      background: linear-gradient(145deg, #4fc3f7, #29b6f6);
      display: inline-block;
      border: 3px solid #fff;
      box-sizing: border-box;
      margin: 2px;
      border-radius: 15px;
      text-align: center;
      line-height: 34px;
      font-weight: 700;
      color: #fff;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .box {
      width: 60px;
      height: 80px;
      background: linear-gradient(145deg, #fff, #f5f5f5);
      display: inline-block;
      border: 3px solid #fff;
      box-sizing: border-box;
      margin: 2px;
      border-radius: 15px;
      vertical-align: top;
      position: relative;
      transition: all 0.3s ease;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .box:hover {
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      background: linear-gradient(145deg, #ffeb3b, #ffc107);
      cursor: pointer;
    }

    .day-info {
      padding: 2px;
    }

    .day-num {
      font-size: 16px;
      font-weight: 700;
      color: #333;
      text-align: center;
      margin-bottom: 2px;
    }

    .day-week {
      font-size: 10px;
      color: #666;
      text-align: center;
      font-weight: 600;
    }

    .holiday-info {
      margin-top: 2px;
    }

    .holiday {
      background: linear-gradient(145deg, #ff4081, #e91e63);
      color: white;
      font-size: 9px;
      padding: 2px 4px;
      border-radius: 8px;
      text-align: center;
      font-weight: 600;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      margin: 1px;
    }

    .todo-info {
      margin-top: 2px;
    }

    .todo {
      background: linear-gradient(145deg, #4caf50, #388e3c);
      color: white;
      font-size: 9px;
      padding: 2px 4px;
      border-radius: 8px;
      text-align: center;
      font-weight: 600;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      margin: 1px;
    }

    /* 空白日期的樣式 */
    .box:has(.day-num:empty) {
      opacity: 0.3;
      background: linear-gradient(145deg, #e0e0e0, #bdbdbd);
    }

    /* 今天的特殊樣式 */
    .today {
      background: linear-gradient(145deg, #ff9800, #f57c00) !important;
      animation: pulse 2s infinite;
      border: 3px solid #fff700 !important;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.05);
      }

      100% {
        transform: scale(1);
      }
    }

    /* 週末的特殊樣式 */
    .weekend {
      background: linear-gradient(145deg, #ffcdd2, #f8bbd9);
    }

    /* 響應式設計 */
    @media (max-width: 600px) {
      .box-container {
        width: 350px;
      }

      .th-box,
      .box {
        width: 45px;
        margin: 1px;
      }

      .box {
        height: 60px;
      }
    }
  </style>
</head>

<body>
  <h1>🎬 皮克斯風格日曆 🎬</h1>

  <?php
  if (isset($_GET['month'])) {
    $month = $_GET['month'];
  } else {
    $month = date("m");
  }
  if (isset($_GET['year'])) {
    $year = $_GET['year'];
  } else {
    $year = date("Y");
  }
  if ($month - 1 > 0) {
    $prev = $month - 1;  //上一個月
    $prevyear = $year;
  } else {
    $prev = 12;  //上一個月
    $prevyear = $year - 1;
  }
  if ($month + 1 > 12) {
    $next = 1;  //下一個月
    $nextyear = $year + 1;
  } else {
    $next = $month + 1;  //下一個月
    $nextyear = $year;
  }


  $today = date("Y-$month-d");
  $firstDay = date("Y-$month-01");
  $firstDayWeek = date("w", strtotime($firstDay));
  $theDaysOfMonth = date("t", strtotime($firstDay));


  $spDate = [
    '2025-04-04' => '兒童節',
    '2025-04-05' => '清明節',
    '2025-05-11' => '母親節',
    '2025-05-01' => '勞動節',
    '2025-05-30' => '端午節',
    '2025-06-06' => "生日"
  ];

  $todoList = ['2025-05-01' => '開會'];

  $monthDays = [];

  //填入空白日期
  for ($i = 0; $i < $firstDayWeek; $i++) {
    $monthDays[] = [];
  }

  //填入當日日期
  for ($i = 0; $i < $theDaysOfMonth; $i++) {
    $timestamp = strtotime(" $i days", strtotime($firstDay));
    $date = date("d", $timestamp);
    $holiday = "";
    foreach ($spDate as $d => $value) {
      if ($d == date("Y-m-d", $timestamp)) {
        $holiday = $value;
      }
    }
    $todo = '';
    foreach ($todoList as $d => $value) {
      if ($d == date("Y-m-d", $timestamp)) {
        $todo = $value;
      }
    }
    $monthDays[] = [
      "day" => date("d", $timestamp),
      "fullDate" => date("Y-m-d", $timestamp),
      "weekOfYear" => date("W", $timestamp),
      "week" => date("w", $timestamp),
      "daysOfYear" => date("z", $timestamp),
      "workday" => date("N", $timestamp) < 6 ? true : false,
      "holiday" => $holiday,
      "todo" => $todo
    ];
  }

  /* echo "<pre>";
    print_r($monthDays);
    echo "</pre>"; */
  ?>

  <div class="navigation">
    <a href="?year=<?= $prevyear; ?>&month=<?= $prev; ?>">← 上一月</a>
    <a href="?year=<?= $nextyear; ?>&month=<?= $next; ?>">下一月 →</a>
  </div>

  <h2><?= $year; ?>年<?= $month; ?>月</h2>

  <?php

  //建立外框及標題
  echo "<div class='box-container'>";

  echo "<div class='th-box'>日</div>";
  echo "<div class='th-box'>一</div>";
  echo "<div class='th-box'>二</div>";
  echo "<div class='th-box'>三</div>";
  echo "<div class='th-box'>四</div>";
  echo "<div class='th-box'>五</div>";
  echo "<div class='th-box'>六</div>";


  //使用foreach迴圈,印出日期
  foreach ($monthDays as $day) {
    $boxClass = "box";

    // 判斷是否為今天
    if (isset($day['fullDate']) && $day['fullDate'] == date('Y-m-d')) {
      $boxClass .= " today";
    }

    // 判斷是否為週末
    if (isset($day['week']) && ($day['week'] == 0 || $day['week'] == 6)) {
      $boxClass .= " weekend";
    }

    echo "<div class='$boxClass'>";
    echo "<div class='day-info'>";
    echo "<div class='day-num'>";
    if (isset($day['day'])) {

      echo $day["day"];
    } else {
      echo "&nbsp;";
    }
    echo "</div>";
    echo "<div class='day-week'>";
    if (isset($day['weekOfYear'])) {
      echo "W" . $day["weekOfYear"];
    } else {
      echo "&nbsp;";
    }

    echo "</div>";
    echo "</div>";


    echo "<div class='holiday-info'>";
    if (isset($day['holiday'])) {
      echo "<div class='holiday'>";
      echo $day['holiday'];
      echo "</div>";
    } else {
      echo "&nbsp;";
    }
    echo "</div>";
    echo "<div class='todo-info'>";
    if (isset($day['todo']) && !empty($day['todo'])) {

      echo "<div class='todo'>";
      echo $day['todo'];
      echo "</div>";
    } else {
      echo "&nbsp;";
    }
    echo "</div>";
    echo "</div>";
  }
  echo "</div>";
  ?>

</body>

</html>