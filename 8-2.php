<?php
//這裡的全域變數 $msg，與區域變數 $msg 互不影響
$msg = "這是全域變數<br />";

function showMsg(){
    //同樣的名稱，這裡的 $msg，不會影響到全域變數
    $msg = "這是區域變數<br />"; 
    echo $msg;
}

echo $msg; //先輸出全域變數的值
showMsg(); //透過函式輸出區域變數的值
echo $msg; //最後再輸出全域變數的值