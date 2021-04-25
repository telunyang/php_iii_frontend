<?php
//字串變數
$strName = "Alex";

//整數變數
$intStores = 7;

//透過「.」來串接變數或是英數、特殊字元混合的資料 
echo $strName." 開了 ".$intStores." 間店。";

//可以整合 HTML 標籤
echo "<br /><br />";

//浮點數變數
$floatNumber = 3.1415926;

//「.」與變數、資料之間，也可以用空白區隔或排版
echo $floatNumber . " 是浮點數";

//可以整合 HTML 標籤
echo "<br /><br />";

//布林變數
$isActivated = true;
if( $isActivated ){
    echo "已開通。";
} else {
    echo "未開通";
}