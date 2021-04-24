<?php
//while迴圈
$i = 0;
while ($i < 10) {
    echo $i . "&nbsp;"; //&nbsp; 為空白字元
    $i++;
}

echo "<hr>";

//do…while迴圈
$i = 0;
do {
    echo $i . "&nbsp;"; //&nbsp; 為空白字元
    $i++;
} while ($i < 10);


echo "<hr>";

//for迴圈
for($i = 0; $i < 10; $i++) {
    echo $i . "&nbsp;"; //&nbsp; 為空白字元
}