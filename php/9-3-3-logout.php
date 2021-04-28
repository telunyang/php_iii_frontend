<?php
//開啟 session
session_start();

//關閉 session
session_destroy();

//3 秒後跳頁
header("Refresh: 3; url=./9-3.php");
echo "您已登出…3秒後自動回登入頁";