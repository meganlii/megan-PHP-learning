<?php include_once "db.php";?>
<style>
    .booking-box{
        width:540px;
        height:370px;
        background:url("./icon/03D04.png") no-repeat center;
        margin:0 auto;
    }
    .info-box{
        background:#ddd;
        width:540px;
        margin:10px auto;
        padding:10px 70px;
        box-sizing:border-box;
    }
    #seats{
        display:flex;
        flex-wrap:wrap;       
        width:320px;
        height:344px;
        margin:0 auto;
        padding-top:18px;
    }
    .seat{
        width:64px;
        height:86px;
        box-sizing:border-box;
        text-align:center;
        padding:2px;
        position:relative;
    }
    .seat input[type="checkbox"]{
        position:absolute;
        bottom:5px;
        right:5px;
    }
    
    .seat:nth-child(odd){
        width:64px;
        height:86px;
        box-sizing:border-box;
    }
    .booked{
        background:url("./icon/03D03.png") no-repeat center;
    }
    .null{
        background:url("./icon/03D02.png") no-repeat center;
    }
</style>
<?php
$orders=$Order->all(['movie'=>$Movie->find($_GET['id'])['name'],'date'=>$_GET['date'],'session'=>$_GET['session']]);
$seats=[];
foreach($orders as $order){
    $seats=array_merge($seats,unserialize($order['seats']));
}
//dd($seats);
?>
<div class="booking-box">
 <div id="seats">
    <?php
    for($i=0;$i<20;$i++):
        
        $booked=in_array($i,$seats)?'booked':'null';
    ?>
    <div class="seat <?=$booked;?>">
        <div><?=floor($i/5)+1;?>排<?=($i%5)+1;?>號</div>
        <!--判斷是否要顯示checkbox-->
        <?php if($booked=='null'):?>
        <input type="checkbox" name="seat" value="<?=$i;?>">
        <?php endif;?>
    </div>
    <?php
    endfor;
?>

 </div>

</div>

<div class="info-box">
<div class="order-info">
    <div>您選擇的電影是：<?=$Movie->find($_GET['id'])['name'];?></div>
    <div>您選擇的時刻是：<?=$_GET['date'];?> <?=$_GET['session'];?></div>
    <div>您己經勾選<span id="tickets">0</span>張票，最多可以購買四張票</div>
</div>

<div class="ct">
    <button class='btn-prev'>上一步</button>
    <button class='btn-order'>訂購</button>
</div>
</div>

<script>
    let selectedSeats=[];
    $(".seat input[type='checkbox']").on("change",function(){
        //console.log($(this).prop("checked"),$(this).val());
        
        if($(this).prop("checked")){
            if(selectedSeats.length <4){
                selectedSeats.push($(this).val());
               // $(this).parent().removeClass("null").addClass("booked");
            }else{
                alert("最多只能選擇四張票");
                $(this).prop("checked",false);
            }
        }else{
            selectedSeats.splice(selectedSeats.indexOf($(this).val()),1)
          //  $(this).parent().removeClass("booked").addClass("null");
        }
        //console.log(selectedSeats);
        $("#tickets").text(selectedSeats.length);

    })

    $(".btn-order").on("click",function(){
        $.post("./api/booking.php",{
            movie:"<?=$Movie->find($_GET['id'])['name'];?>",
            date:"<?=$_GET['date'];?>",
            session:"<?=$_GET['session'];?>",
            seats:selectedSeats
        },(no)=>{
           // console.log(no)
            location.href=`?do=result&no=${no}`;
        })
    })
</script>
