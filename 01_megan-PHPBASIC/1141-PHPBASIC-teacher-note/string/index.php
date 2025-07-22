<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>字串處理</title>
    <style>
        h1{
            text-align:center;
            font-size:1.5em;
            color:blue;
            border-bottom:1px solid #ccc;
            padding-bottom:10px;
        }
    </style>
</head>
<body>
 <h1>字串處理</h1> 
 <h2>字串取代</h2>
 <p>將”aaddw1123”改成”*********”</p>

<?php
$str="aadsafdsfs13";
/* $str=str_replace("a","*",$str);
$str=str_replace("d","*",$str);
$str=str_replace("w","*",$str);
$str=str_replace("1","*",$str);
$str=str_replace("2","*",$str);
$str=str_replace("3","*",$str); */
//$str=str_replace("aaddw1123","*********",$str);
//$str=str_replace(["a","d","w","1","2","3"],"*",$str);
//$str=str_replace(str_split($str,1),"*",$str);
$str=str_repeat("*",strlen($str));


echo $str;

?>
<h2>字串分割</h2>
<p>將”this,is,a,book”依”,”切割後成為陣列</p>
<?php
$str="this,is,a,book";
$str=explode(",",$str); 

echo "<pre>";
print_r($str);
echo "</pre>";

?>
<h2>字串組合</h2>
<p>將上例陣列重新組合成“this is a book”</p>
<?php
$str=join(" ",$str);
echo $str;
?>

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
$keyword="PHP";

$words="程式設計";
$style="font-size:3em;color:green;";

$str=str_replace("$keyword","<span style='$style'>$keyword</span>",$str);

echo $str;




?>
<hr>
<?php
$str="美國總統川普（Donald Trump）的「對等關稅」政策再有新變化！美中雙方上週末在瑞士日內瓦舉行的貿易談判中達成共識，同意於5月14日前互降關稅90天。針對川普對等關稅政策出現急轉彎，是否意味著美中關稅戰徹底休兵？財訊傳媒董事長謝金河就發文點出川普談判策略出現重大轉折的原因，並以川普大作《交易的藝術》預測美中貿易戰略的關鍵4部曲。
美中兩國在台灣時間12日發表共同聲明，表示雙方達成互降關稅90天的共識，自14日起美國將暫把原對中國關稅從145％降至30％，而中國則是把對美課稅從125％降至10％，降幅高達115％。消息讓市場一片驚愕。謝金河12日就在臉書以「是驚嚇？還是驚喜？山不轉，川普先轉！」為題，解讀川普談判策略出現重大轉折的隱藏內幕。
美中關稅戰休兵不打了？新台幣「翻貶跳水」謝金河曝關鍵數字：機會很大
他首先提到，自己先前就曾指出美中兩國持續互加關稅的舉措，實際上毫無意義，因為「稅率超過50%，邊際效應已經很低，稅率超過100%，等於雙方不會有往來」，而他也預言川普猛課關稅的最終結局，「一定會撞到牆壁，最後一定會自己找台階下」。而近來川普接連放低姿態、蹲下來兩次的作法，也讓謝金河的預言得到驗證，「其中一次是4月12日宣布對75個國家豁免90天，接下來是美國財長4月22日透露川普將對中國降關稅」。";
echo $str;

$keyword="川普";
$keyword2="關稅";
$style="font-size:1.1em;color:green;";
$style2="font-size:1.1em;color:red;";
$str=str_replace("$keyword","<span style='$style'>$keyword</span>",$str);
$str=str_replace("$keyword2","<span style='$style2'>$keyword2</span>",$str);

echo "<hr>";
echo $str;




?>
<hr>
<?php
$str="SpaceX創辦人伊隆馬斯克（Elon Musk）近日重申人類應移居火星，作為對抗地球最終毀滅的保險政策。根據美國國家航空暨太空總署（NASA）與日本東邦大學的最新研究，地球上的生命可能會在約10億年後因太陽演化而面臨全面滅絕。<br>
根據外媒報導，這項研究發表於《自然地球科學》（Nature Geoscience），科學家利用超級電腦與氣候模型模擬太陽長期變化對地球環境的影響。他們進行超過40萬次模擬，發現隨著太陽亮度與溫度逐漸增加，地球將面臨氣候極端化與氧氣逐步消失的危機，最終導致有氧生命無法存活，僅剩下厭氧微生物得以苟延殘喘。<br>
研究指出，地球大氣中氧氣的穩定存在將於約10.8億年後崩潰，誤差範圍約為1.4億年。此後，地表氣候將變得極度不穩，海洋沸騰、生命系統瓦解，預示著地球生物圈的終結。<br>
馬斯克接受福斯新聞專訪時表示，「最終地球上的所有生命都將被太陽毀滅。這是推動我致力於火星殖民的原因之一。」他形容火星是「集體生命的壽險」，人類若想延續文明，必須成為「多行星物種」。太陽預計在約50億年後進入紅巨星階段，屆時太陽體積將大幅膨脹，可能吞噬水星、金星甚至地球，這一過程將徹底摧毀地球現有的物理結構與環境。<br>
面對長遠的宇宙命運，馬斯克提出希望未來20年內在火星建立可容納百萬人的自給自足城市。他強調：「如果火星必須依賴地球補給才能生存，那我們並未真正建立生命的保險機制。只有當火星可以獨立生存時，人類的未來才真正有保障。」<br>
美國政府也展現出對太空殖民的支持，川普總統任內曾批准對NASA的預算重組，將60億美元由國際太空站營運與研究計畫中轉移至載人太空任務，包括火星探索。<br>
SpaceX目前正全力推進星際飛船（Starship）計畫，該火箭系統為全球最強大，設計可重複使用，大幅降低發射成本。2025年初進行的兩次試射雖未完全成功，但展現出強勁的技術進展。馬斯克計畫最快於明年發射無人火星任務，並於四年內實現載人登陸。<br>";
echo $str;
$keywords=["馬斯克","火星","地球","火箭","NASA"];
$style=["font-size:1.1em;color:green;",
        "font-size:1em;color:red;",
        "font-size:1.2em;color:blue;",
        "font-size:1.3em;color:orange;",
        "font-size:1.4em;color:purple;"];
//在指定的關鍵字中加上url連結
$url=["https://en.wikipedia.org/wiki/Elon_Musk","","","","https://en.wikipedia.org/wiki/NASA"];


/* $keywords=[
           ["馬斯克","font-size:1.1em;color:green;","https://en.wikipedia.org/wiki/Elon_Musk"],
           ["火星","font-size:1em;color:red;",""],
           []
        ]; */
/* $keywords=[
           ['content'=>'馬斯克',
            'style'=>'font-size:1.1em;color:green;',
            'url'=>'https://en.wikipedia.org/wiki/Elon_Musk'],
           ['content'=>'火星',
            'style'=>'font-size:1em;color:red;',
            'url'=>''],
           ['content'=>'地球',
            'style'=>'font-size:1.2em;color:blue;',
            'url'=>''],
           ['content'=>'火箭',
            'style'=>'font-size:1.3em;color:orange;',
            'url'=>''],
           ['content'=>'NASA',
            'style'=>'font-size:1.4em;color:purple;',
            'url'=>'https://en.wikipedia.org/wiki/NASA']
        ]; */

foreach($keywords as $index => $keyword){
        if($url[$index]!=""){
            $strwithurl="<a href='$url[$index]'>$keyword</a>";
        }else{
            $strwithurl=$keyword;
        }

        $strwithstyle="<span style='$style[$index]'>$strwithurl</span>";

        $str=str_replace("$keyword","$strwithstyle",$str);
}        

echo "<hr>";
echo $str;
?>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>