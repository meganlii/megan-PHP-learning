<h3 class="ct">訂單管理</h3>
<div>
    快速刪除：
    <input type="radio" name="type" value='date' checked>依日期
    <input type="text" name="date" id="date" >
    <input type="radio" name="type" value='movie'>依電影
    <select name="movie" id="movie">        
        <?php
        $movies = q("select `movie` from `orders` group by `movie`");
        foreach($movies as $movie){
            echo "<option value='{$movie['movie']}'>{$movie['movie']}</option>";
        }
        ?>
    </select>
    <button class='quick-del'>刪除</button>
</div>

<style>
.list-col{
    display:flex;
    justify-content:space-between;
    margin-top:5px;
   
}  
.list-col div{
    width:calc(98% / 7);
    background:#eee;
    padding:2px 5px;
    box-sizing:border-box;
}  
.list-data{
    display:flex;
    justify-content:space-between;
    align-items:center;
   
}  
.list-data div{
    width:calc(98% / 7);
    padding:2px 5px;
    box-sizing:border-box;
}  
#items{
    overflow:auto;
    height:360px;
}
</style>
<div class="list-col ct">
    <div>訂單編號</div>
    <div>電影名稱</div>
    <div>日期</div>
    <div>場次時間</div>
    <div>訂購數量</div>
    <div>訂購位置</div>
    <div>操作</div>
</div>
<div id="items">
    <?php 
    $orders=$Order->all(" order by `no` desc");
    foreach($orders as $order):
    ?>
    <div class="list-data ct">
        <div><?=$order['no'];?></div>
        <div><?=$order['movie'];?></div>
        <div><?=$order['date'];?></div>
        <div><?=$order['session'];?></div>
        <div><?=$order['tickets'];?></div>
        <div><?php
        $seats=unserialize($order['seats']);
        sort($seats);
        foreach($seats as $seat){
            echo floor($seat/5)+1 ."排".($seat%5)+1 . "號<br>";
        }
        
        
        ?></div>
        <div>
            <button class='btn-del' data-id="<?=$order['id'];?>">刪除</button>
        </div>
    </div>
    <hr>
    <?php endforeach; ?>
</div>
<script>
 $(".btn-del").on("click",function(){
    let id=$(this).data("id");

    if(confirm("確定要刪除訂單嗎?")){
        $.post("./api/del.php",{table:'Order',id},()=>{
            location.reload();
        })
    }
})   

$(".quick-del").on("click",function(){
    let type=$("input[name='type']:checked").val();
    let data='';
    switch(type){
        case 'date':
            data=$("#date").val();
        break;
        case 'movie':
            data=$("#movie").val();
        break;
    }

    if(confirm(`確定要刪除${data}的所有訂單嗎?`)){
        $.post("./api/qDel.php",{type,data},()=>{
            location.reload();
        })
    }
})
</script>

