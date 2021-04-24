<?php
//不使用陣列索引鍵
$arrSeasons = ['春', '夏', '秋', '冬'];
echo "每年的四季分別為： ";
foreach($arrSeasons as $value) {
    echo $value."&nbsp;";
}

echo "<hr>";

//各別輸出陣列的索引鍵key，同時輸對應的值value
$arrPerson = [
    '學號' => '103',
    '姓名' => '孫小美',
    '性別' => '女',
    '生日' => '2000/7/15',
    '手機號碼' => '0939666999'
];

foreach($arrPerson as $key => $value) {
    echo $key.": ".$value."<br />";
}

echo "<hr>";

//輸出二維陣列的結果，其中第二維放置關聯式陣列 (物件)
$arrStudents = [];
$arrStudents[] = ["name" => "Alex", "age" => 18];
$arrStudents[] = ["name" => "Bill", "age" => 21];
$arrStudents[] = ["name" => "Carl", "age" => 13];
$arrStudents[] = ["name" => "Darren", "age" => 19];

foreach($arrStudents as $key => $obj){
    echo "{$obj['name']} 今年 {$obj['age']}<br>";
}