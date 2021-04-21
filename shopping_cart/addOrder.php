<?php
session_start();
require_once("./checkSession.php");
require_once('./db.inc.php');

//預設訊息 (錯誤先行)
$objResponse['success'] = false;
$objResponse['info'] = "訂單新增失敗";

if(!isset($_POST["paymentTypeId"])){
    header("Refresh: 3; url=./myCart.php");
    $objResponse['info'] = "請選擇付款方式…3秒後回購物車列表";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

//先取得訂單編號
$sqlOrder = "INSERT INTO `orders` (`username`,`paymentTypeId`) VALUES (?,?)";
$stmtOrder = $pdo->prepare($sqlOrder);
$arrParamOrder = [
    $_SESSION["username"],
    $_POST["paymentTypeId"]
];
$stmtOrder->execute($arrParamOrder);
$orderId = $pdo->lastInsertId();

$count = 0;

//新增購物車中的每一個項目
$sqlItemList = "INSERT INTO `item_lists` (`orderId`,`itemId`,`checkPrice`,`checkQty`,`checkSubtotal`) VALUES (?,?,?,?,?)";
$stmtItemList = $pdo->prepare($sqlItemList);
for($i = 0; $i < count($_POST["itemId"]); $i++){
    $arrParamItemList = [
        $orderId,
        $_POST["itemId"][$i],
        $_POST["itemPrice"][$i],
        $_POST["cartQty"][$i],
        $_POST["subtotal"][$i]
    ];
    $stmtItemList->execute($arrParamItemList);
    $count += $stmtItemList->rowCount();
}

if($count > 0) {
    header("Refresh: 3; url=./order.php");

    //帳號完成後，注銷購物車資訊
    unset($_SESSION["cart"]);

    $objResponse['success'] = true;
    $objResponse['info'] = "訂單新增成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Refresh: 3; url=./order.php");
    $objResponse['success'] = false;
    $objResponse['info'] = "訂單新增失敗";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
