<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//預設訊息
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "新增商品種類失敗";

//若沒填寫商品種類時的行為
if( $_POST['categoryName'] == '' ){
    header("Refresh: 3; url=./category.php");
    $objResponse['info'] = "請填寫商品種類";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

header("Refresh: 3; url=./category.php");

$sql = "INSERT INTO `categories` (`categoryName`) VALUES (?)";
$stmt = $pdo->prepare($sql);
$arrParam = [$_POST['categoryName']];
$stmt->execute($arrParam);
if($stmt->rowCount() > 0) {
    
    $objResponse['success'] = true;
    $objResponse['info'] = "新增商品種類成功";
} 

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);