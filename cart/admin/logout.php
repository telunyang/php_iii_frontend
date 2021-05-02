<?php
session_start();
session_destroy();

//3 秒後跳頁
header("Refresh: 3; url=../index.php");

//預設訊息 (錯誤先行)
$objResponse['success'] = true;
$objResponse['info'] = "您已登出…3秒後自動回登入頁";
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);