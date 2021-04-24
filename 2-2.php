<?php
//陣列變數
$arrName = ["Alex", "Bill", "Carl", "Darren"];
echo $arrName[0]."<br />";
echo $arrName[1]."<br />";
echo $arrName[2]."<br />";
echo $arrName[3];

//可以整合 HTML 標籤
echo "<br /><br />";

//物件變數
$obj = ["name" => "Alex", "age" => 17];
echo "姓名: " . $obj["name"] . "，年齡: " . $obj["age"];