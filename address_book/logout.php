<?php
//引入登入判斷
require_once('./checkSession.php');

//判斷是否需要登出
if(isset($_GET['logout']) && $_GET['logout'] === '1'){
    //關閉 session
    session_destroy();

    //3 秒後跳頁
    header("Refresh: 3; url=./index.php");
    echo "登出成功";
}