<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//回傳狀態
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";

//將所有 id 透過「,」結合在一起，例如「1,2,3」
$strIds = join(",", $_POST['chk']);

//記錄資料表刪除數量
$count = 0;

//先查詢出所有 id 資料欄位中的大頭貼檔案名稱
$sqlGetImg = "SELECT `itemImg` FROM `items` WHERE FIND_IN_SET(`itemId`, ?) ";
$stmtGetImg = $pdo->prepare($sqlGetImg);
$stmtGetImg->execute([$strIds]);
if( $stmtGetImg->rowCount() > 0 ){
    //取得所有大頭貼檔案名稱
    $arrImg = $stmtGetImg->fetchAll();

    //各別刪除大頭貼實際檔案
    for($i = 0; $i < count($arrImg); $i++){
        //若是 itemImg 裡面不為空值，代表過去有上傳過
        if($arrImg[$i]['itemImg'] !== NULL){
            //刪除實體檔案
            @unlink("../images/items/".$arrImg[$i]['itemImg']);
        }  
    }

    //在這裡刪除資料表記錄
    $sqlDelete = "DELETE FROM `items` WHERE FIND_IN_SET(`itemId`, ?) ";
    $stmtDelte = $pdo->prepare($sqlDelete);
    $stmtDelte->execute([$strIds]);
    $count = $stmtDelte->rowCount();
}

header("Refresh: 3; url=./admin.php");

//累計每次刪除的次數大於0，代表刪除成功
if($count > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "刪除成功";  
}
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);