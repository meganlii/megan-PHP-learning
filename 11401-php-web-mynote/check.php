<?php

if($_POST['acc'] == 'admin' && $_POST['pw'] == '1234'){
    echo "登入成功";    
    header("location:login.php?login=1");
}else{
    echo "登入失敗";
    header("location:login.php?login=0");
}   

?>