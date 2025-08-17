<?php 
$order=$Order->find(['no'=>$_GET['no']]);

?>
<style>
    .result-table{
        width:540px;
        margin:20px auto;
        padding:20px;
        border:1px solid #ccc;
        background:#eee;
    }
    .result-table td{
        padding:5px 2px;
        border:1px solid #ccc;
    }

    .result-table tr:nth-child(even) td:nth-child(1){
        background:#aaa;
        width:20%;
    }
</style>
<table class="result-table">
    <tr>
        <td colspan="2">感謝您的訂購，您的訂單編號是：<?=$_GET['no'];?></td>
    </tr>
    <tr>
        <td>電影名稱：</td>
        <td><?=$order['movie'];?></td>
    </tr>
    <tr>
        <td>日期：</td>
        <td><?=$order['date'];?></td>
    </tr>
    <tr>
        <td>場次時間：</td>
        <td><?=$order['session'];?></td>
    </tr>
    <tr>
        <td colspan="2">
            <div>座位：</div>
            <?php 
            $seats=unserialize($order['seats']);
            sort($seats);
            foreach($seats as $seat){
                echo "<div>";
                echo floor($seat/5)+1 . "排" . ($seat%5)+1 . "號";
                echo "</div>";
            }

            ?>

            <div>共<?=$order['tickets'];?>張電影票</div>
        </td>
    </tr>
    <tr>
        <td colspan="2" class='ct'>
            <button onclick="location.href='index.php'">確認</button>
        </td>

    </tr>
</table>