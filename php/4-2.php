<?php
//邏輯運算子
$a = true;
$b = true;
echo ($a && $b) ? '$a && $b 為真' : '$a && $b 為假';

echo "<hr>";

$a = true;
$b = false;
echo ($a || $b) ? '$a && $b 為真' : '$a && $b 為假';

echo "<hr>";

$c = true;
echo (!$c) ? '$c 為真' : '$c 為假';

echo "<hr>";

//複合運算子
$x1 = 10;
$y1 = 5;
$x1 = $x1 + $y1; //可以改寫成 $x1 += $y1;
echo $x1;

echo "<hr>";

$x2 = 10;
$y2 = 5;
$x2 = $x2 / $y2; //可以改寫成 $x2 /= $y2;
echo $x2;

echo "<hr>";

//遞增、遞減運算子
$x3 = 1;
$x3++;
echo $x3;

echo "<hr>";

$x4 = 7;
$x4--;
echo $x4;