<?php
session_start();
require_once("./checkSession.php");
require_once('./db.inc.php');

//預設訊息
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "訂單新增失敗";

//先取得訂單編號
$sqlOrder = "INSERT INTO `orders` (`username`) VALUES (?)";
$stmtOrder = $pdo->prepare($sqlOrder);
$arrParamOrder = [
    $_SESSION["username"]
];
$stmtOrder->execute($arrParamOrder);

//取得訂單最後一次新增時的流水號
$orderId = $pdo->lastInsertId();

//新增商品明細成功的數量
$count = 0;

//新增購物車中的每一個項目，變成商品明細
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

header("Refresh: 3; url=./order.php");

//商品明細數量大於0，則釋放存置購物車的 session 變數
if($count > 0) {
    //訂單完成後，注銷購物車資訊
    unset($_SESSION["cart"]);

    $objResponse['success'] = true;
    $objResponse['info'] = "訂單新增成功";
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
