<?php
//preg_match_all() 比對所有結果
$regex = "/[a-zA-Z]+/";
$test = "You are the only one we love.";

//判斷是否比對成功
echo preg_match_all($regex, $test, $matches);
if( preg_match_all($regex, $test, $matches) ){
    echo "比對成功！ 結果為: <br>";

    //格式化輸出所有比對結果
    echo "<pre>";
    print_r($matches);
    echo "</pre>";

    //將所有比對結果，透過 for 輸出
    for($i = 0; $i < count($matches[0]); $i++){
        echo "matches[{$i}] 的值: {$matches[0][$i]} <br>";
    }
} else {
    echo "比對失敗…";
}