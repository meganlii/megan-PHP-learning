<?php 

$dsn="mysql:host=localhost;dbname=school;charset=utf8";


$pdo=new PDO($dsn, 'root', '');

$sql="select * from students where id<=20";
//$query=$pdo->query($sql); //PDOStatement物件
//$row=$query->fetch(); //一維陣列
$rows=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC); //二維陣列
/* echo "<pre>";
print_r($rows);;
echo "</pre>";
 */

?>
<style>
table {
    width: 50%;
    border-collapse: collapse;
    margin: 20px auto;
}
th, td {
    border: 1px solid #ddd;
    padding: 5px 12px;
    text-align: center;
}
</style>

<table>
    <tr>
        <th>id</th>
        <th>學號</th>
        <th>姓名</th>
        <th>生日</th>
        <th>電話</th>
    </tr>
    <?php 
    foreach($rows as $row){
    ?>
    <tr>
        <td><?=$row['id'];?></td>
        <td><?=$row['school_num'];?></td>
        <td><?=$row['name'];?></td>
        <td><?=$row['birthday'];?></td>
        <td><?=$row['tel'];?></td>
    </tr>
    <?php 
    }
    ?>
</table>
<style>
    .card{
        width: 300px;
        margin: 10px auto;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #ccc;
        display:inline-block;
    }
h3.head{
    margin: 0;
    padding:0;
    font-size: 1.2em;
    padding-bottom: 5px;
    margin-bottom: 5px;
    border-bottom: 1px solid #ccc;

}
.card div:hover{
    background-color: #f0f0f0;
}
</style>
    <?php 
    foreach($rows as $row){
    ?>
<div class='card'>
    <h3 class='head'><?=$row['name'];?></h3>
    <div class='id'><?=$row['id'];?></div>
    <div class='birthday'><?=$row['birthday'];?></div>
    <div class='tel'><?=$row['tel'];?></div>
    <div class='num'><?=$row['school_num'];?></div>
</div>
<?php 
    }

?>