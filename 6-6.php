<?php
//建立一個空陣列
$arr = [];

$arr[0] = "";
$arr[1] = 0;
$arr[2] = false;
$arr[3] = 10;
$arr[4] = NULL;

echo '$a[0] = "" ... 是否為空? ';
echo empty($arr[0]) ? '為空' : '不為空';

echo "<hr />";

echo '$a[1] = 0 ... 是否為空? ';
echo empty($arr[1]) ? '為空' : '不為空';

echo "<hr />";

echo '$a[2] = false ... 是否為空? ';
echo empty($arr[2]) ? '為空' : '不為空';

echo "<hr />";

echo '$a[3] = 10 ... 是否為空? ';
echo empty($arr[3]) ? '為空' : '不為空';

echo "<hr />";

echo '$a[4] = NULL ... 是否為空? ';
echo empty($arr[4]) ? '為空' : '不為空';