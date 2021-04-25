<?php
echo "我的姓名: ".$_POST['myName']."<br />";
echo "我的年紀: ".$_POST['myAge']."<br />";
echo "我的身高: ".$_POST['myHeight']."<br />";
echo "我的體重: ".$_POST['myWeight'];

echo "<hr>";

//判斷某個 key 是否存在於 POST 變數當中
if(isset($_POST['myName'])) {
    echo '有 $_GET["myName"]';
} else {
    echo '沒有 $_GET["myName"]';
}