<?php
//preg_match_all() 比對所有結果
$regex = "/https?:\/\/stickershop\.line-scdn\.net\/stickershop\/v1\/sticker\/([0-9]+)\/iPhone\/sticker@2x\.png/";
$test = 'background-image:url(https://stickershop.line-scdn.net/stickershop/v1/sticker/315548646/iPhone/sticker@2x.png;compress=true);
background-image:url(https://stickershop.line-scdn.net/stickershop/v1/sticker/315548647/iPhone/sticker@2x.png;compress=true);
background-image:url(https://stickershop.line-scdn.net/stickershop/v1/sticker/315548648/iPhone/sticker@2x.png;compress=true);';

//判斷是否比對成功
if( preg_match_all($regex, $test, $matches) ){
    echo "比對成功！ 結果為: <br>";

    //格式化輸出所有比對結果
    echo "<pre>";
    print_r($matches);
    echo "</pre>";

    echo "<hr>";

    //將所有比對結果，以及透過群組取得的文字，進行輸出
    for($i = 0; $i < count($matches[0]); $i++){
        echo "照片連結為: <a href='{$matches[0][$i]}' target='_blank'>{$matches[0][$i]}</a> <br>";
        echo "照片代號為: {$matches[1][$i]} <br>";
        echo "<img src='{$matches[0][$i]}'>";
        echo "<hr>";
    }
} else {
    echo "比對失敗…";
}