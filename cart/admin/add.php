<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//回傳狀態
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "新增失敗";

//上傳成功的
if( $_FILES["itemImg"]["error"] === 0 ) {
    //為上傳檔案命名
    $strDatetime = "item_".date("YmdHis");
        
    //找出副檔名
    $extension = pathinfo($_FILES["itemImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $imgFileName = $strDatetime.".".$extension;

    //移動暫存檔案到實際存放位置
    $isSuccess = move_uploaded_file($_FILES["itemImg"]["tmp_name"], "../images/items/".$imgFileName);

    //若上傳失敗，則不會繼續往下執行，回到管理頁面
    if( !$isSuccess ) {
        header("Refresh: 3; url=./admin.php");
        $objResponse['info'] = "圖片上傳失敗";
        exit();
    }
}

//SQL 敘述
$sql = "INSERT INTO `items` (`itemName`, `itemImg`, `itemPrice`, `itemQty`, `itemCategoryId`) 
        VALUES (?, ?, ?, ?, ?)";

//繫結用陣列
$arrParam = [
    $_POST['itemName'],
    $imgFileName,
    $_POST['itemPrice'],
    $_POST['itemQty'],
    $_POST['itemCategoryId']
];

//取得 PDOstatement 物件
$stmt = $pdo->prepare($sql);

//執行預處理後的 SQL 語法
$stmt->execute($arrParam);

header("Refresh: 3; url=./admin.php");

//影響列數大於0，代表新增成功
if($stmt->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "新增成功";  
}
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);