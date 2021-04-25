<?php
$msg = "這是全域變數<br />";

function showMsg(){
    /**
     * 使用 global 關鍵字，
     * 此時函式內的 $msg，就代表全域(外部)變數的 $msg
     */
    global $msg;

    //修改全域變數的值
    $msg = "這是區域變數<br />";
    echo $msg;
}

//先輸出全域變數的值
echo $msg;

//函式中，使用 global 指令，將區域變數 $msg，變成全域變數
showMsg();

//最後輸出 $msg，發現全域 $msg 的值，在函式中被改變了
echo $msg;