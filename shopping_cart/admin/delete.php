<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//回傳狀態
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";

//累計每次刪除的次數
$count = 0;

//將勾選的 checkbox 背後代表的
for($i = 0; $i < count($_POST['chk']); $i++){
    //加入繫結陣列
    $arrParam = [
        $_POST['chk'][$i]
    ];

    //找出特定 itemId 的資料
    $sqlImg = "SELECT `itemImg` FROM `items` WHERE `itemId` = ? ";
    $stmt_img = $pdo->prepare($sqlImg);
    $stmt_img->execute($arrParam);

    //有資料，則進行檔案刪除
    if($stmt_img->rowCount() > 0) {
        //取得檔案資料 (單筆)
        $arr = $stmt_img->fetchAll()[0];
        
        //刪除檔案，回傳布林值
        $bool = unlink("../images/items/".$arr['itemImg']);

        //若檔案刪除成功，則刪除資料
        if($bool === true){
            //SQL 語法
            $sql = "DELETE FROM `items` WHERE `itemId` = ? ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);

            //累計每次刪除的次數
            $count += $stmt->rowCount();
        };
    }
}

//累計每次刪除的次數大於0，代表刪除成功
if($count > 0) {
    header("Refresh: 3; url=./admin.php");
    $objResponse['success'] = true;
    $objResponse['info'] = "刪除成功";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
} else {
    header("Refresh: 3; url=./admin.php");
    $objResponse['success'] = false;
    $objResponse['info'] = "刪除失敗";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
}