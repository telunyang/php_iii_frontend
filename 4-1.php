<?php
//指派運算子
$myVar01 = 6;
echo $myVar01;

echo "<hr>";

//算數運算子
$myVar02 = 3 + 7;
$myVar03 = 6 * 5;
$myVar04 = 7 % 3;
echo "myVar02 = {$myVar02}, myVar03 = {$myVar03}, myVar04 = {$myVar04}";

echo "<hr>";

//關係運算子
echo (1 == "1") ? '1 == "1" 為真' : '1 == "1" 為假';
echo "<br>";
echo (1 === "1") ? '1 === "1" 為真' : '1 === "1" 為假';
echo "<br>";
echo (5 > 3) ? "5 > 3 為真" : "5 > 3 為假";
echo "<br>";
echo (2 < 6) ? "2 < 6 為真" : "2 < 6 為假";