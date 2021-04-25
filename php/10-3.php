<?php
//preg_match_all() 比對所有結果
$regex = "/.+\s--\s([a-zA-Z]+)/";
$test = '"You are the only one we love." -- Darren';

//判斷是否比對成功
if( preg_match_all($regex, $test, $matches) ){
    echo "比對成功！ 結果為: <br>";

    //格式化輸出所有比對結果
    echo "<pre>";
    print_r($matches);
    echo "</pre>";

    //第一組 full match
    echo "matches[0][0] => {$matches[0][0]} <br>";

    //第一組 group
    echo "matches[1][0] => {$matches[1][0]} <br>";
} else {
    echo "比對失敗…";
}