<?php
//只要 $i 不是偶數(即為奇數)，就會執行 break，直接跳出 for 迴圈
for($i = 1; $i <= 10; $i++) {
    if($i % 2 != 0) {
        echo $i."&nbsp;";
    } else {
        break;
    }
}

echo "<hr>";

/**
 * 只要 $i 不是偶數(即為奇數)，不會立刻結束迴圈，
 * 而是 $i++ 後，繼續執行迴圈內的程式內容
 */
for($i = 1; $i <= 10; $i++) {
    if($i % 2 != 0) {
        echo $i."&nbsp;";
    } else {
        continue;
    }
}