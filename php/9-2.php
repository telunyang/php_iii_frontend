<?php
//啟動 session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
//儲存 session 資料
$_SESSION['myName'] = 'Darren';

//取得 session 資料
$myName = $_SESSION['myName'];

echo "我的名字: " . $_SESSION['myName'] . " [從 session] <br />";
echo "我的名字: " . $myName . " [從變數]";

//設定 session 陣列
$_SESSION['student']['name'] = 'Darren Yang';
$_SESSION['student']['age'] = 18;
$_SESSION['student']['height'] = 171;
$_SESSION['student']['weight'] = 80;

echo "全名: ".$_SESSION['student']['name']."<br />";
echo "年齡: ".$_SESSION['student']['age']."<br />";
echo "身高: ".$_SESSION['student']['height']."<br />";
echo "體重: ".$_SESSION['student']['weight']."<br />";
?>
</body>
</html>