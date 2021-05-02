<?php
session_start();

/**
 * 前端功能需求為有無註冊都能暫時使用購物車，
 * 所以在這裡先註銷 username，
 * 前端頁面會自動判斷顯示文字
 */
unset($_SESSION['username']);

//3 秒後跳頁
header("Refresh: 3; url=./index.php");

//預設訊息
$objResponse['success'] = true;
$objResponse['info'] = "您已登出…3秒後自動回登入頁";
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);