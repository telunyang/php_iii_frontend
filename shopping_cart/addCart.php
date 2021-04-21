<?php
session_start();
require_once('./db.inc.php');

//預設訊息 (錯誤先行)
$objResponse['success'] = false;
$objResponse['info'] = "加入購物車失敗";
$objResponse['cartItemNum'] = 0;

if( !isset($_POST['cartQty']) || !isset($_POST['itemId']) ){
    header("Refresh: 3; url=./itemList.php");
    $objResponse['info'] = "資料傳遞有誤";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

//先前沒有建立購物車，就直接初始化 (建立)
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

//SQL 敘述
$sql = "SELECT `items`.`itemId`, `items`.`itemName`, `items`.`itemImg`, `items`.`itemPrice`, 
            `items`.`itemQty`, `items`.`itemCategoryId`, `items`.`created_at`, `items`.`updated_at`,
            `categories`.`categoryId`, `categories`.`categoryName`
        FROM `items` INNER JOIN `categories`
        ON `items`.`itemCategoryId` = `categories`.`categoryId`
        WHERE `itemId` = ? ";

$arrParam = [
    (int)$_POST['itemId']
];

//查詢
$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

//若商品項目個數大於 0，則列出商品
if($stmt->rowCount() > 0) {
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //將主要資料放到購物車中
    $_SESSION['cart'][] = [
        "itemId"    => $arr[0]["itemId"],
        "cartQty"   => $_POST["cartQty"]
    ];

    header("Refresh: 3; url=./myCart.php");
    $objResponse['success'] = true;
    $objResponse['info'] = "已加入購物車";
    $objResponse['cartItemNum'] = count($_SESSION['cart']);
} else {
    header("Refresh: 3; url=./itemDetail.php?itemId={$_POST['itemId']}");
    $objResponse['info'] = "查無商品項目";
    $objResponse['cartItemNum'] = count($_SESSION['cart']);
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);