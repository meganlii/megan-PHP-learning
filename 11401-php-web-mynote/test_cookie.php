<?php

date_default_timezone_set("Asia/Taipei");


if(isset($_COOKIE["test_cookie"])) {
    echo "Cookie is set!";
} else {
    echo "Cookie is not set!";
    setcookie("test_cookie", "3", time() + 300, "/");
}
?>