<?php
//定義一個未設定參數、沒有回傳結果，直接輸出結果的函式
function sayHelloWorld(){
    echo "Hello World!";
}

//執行 sayHelloWorld()
sayHelloWorld();

echo "<hr>";

//定義一個有設定參數、有回傳結果的函式
function getGreeting($strMyName){
    $str = "你好，{$strMyName}。";
    return $str;

    //也可以寫成 return "你好，{$strMyName}。";
}

//透過引數的設定，回傳函式的執行結果
$strName = "Darren";
$strResult = getGreeting($strName);
echo $strResult;

echo "<hr>";

//定義一個變數相乘的函式
function get_X_times_Y($a, $b){
    return $a * $b;
}

//計算變數相乘後的結果
$x = 3;
$y = 4;
echo get_X_times_Y($x, $y);