<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//預設訊息
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";

header("Refresh: 3; url=./category.php");

//刪除類別
if( isset($_GET['deleteCategoryId']) ){
    $sql = "DELETE FROM `categories` WHERE `categoryId` = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([(int)$_GET['deleteCategoryId']]);
    if($stmt->rowCount() > 0) {
        $objResponse['success'] = true;
        $objResponse['info'] = "刪除成功";

    }
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);