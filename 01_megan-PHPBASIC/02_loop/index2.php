<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1> [for迴圈練習] </h1>
  <?php
  $result = 1;

  for ($i = 1; $i <= 10; $i++) {
    $result = $result * $i;
  }

  echo "結果 $result ";
  // echo 寫在大括號之外
  // echo "結果" . $result ;
  ?>

</body>

</html>