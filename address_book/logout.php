<?php
//引入登入判斷
require_once('./checkSession.php');

//關閉 session
session_destroy();

//3 秒後跳頁
header("Refresh: 9; url=./index.php");
echo "登出成功";