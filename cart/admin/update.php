<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//回傳狀態
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "沒有任何更新";

//用在繫結 SQL 用的陣列
$arrParam = [];

//SQL 語法
$sql = "UPDATE `items` SET ";

//itemName SQL 語句和資料繫結
$sql.= "`itemName` = ? ,";
$arrParam[] = $_POST['itemName'];

if( $_FILES["itemImg"]["error"] === 0 ) {
    //為上傳檔案命名
    $strDatetime = "item_".date("YmdHis");
        
    //找出副檔名
    $extension = pathinfo($_FILES["itemImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $itemImg = $strDatetime.".".$extension;

    //若上傳成功 (有夾帶檔案上傳)，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    $isSuccess = move_uploaded_file($_FILES["itemImg"]["tmp_name"], "../images/items/{$itemImg}");
    
    if( $isSuccess ) {
        //先查詢出特定 id (itemId) 資料欄位中的大頭貼檔案名稱
        $sqlGetImg = "SELECT `itemImg` FROM `items` WHERE `itemId` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        //加入繫結陣列
        $arrGetImgParam = [
            (int)$_POST['itemId']
        ];

        //執行 SQL 語法
        $stmtGetImg->execute($arrGetImgParam);

        //若有找到 itemImg 的資料
        if($stmtGetImg->rowCount() > 0) {
            //取得指定 id 的商品資料 (1筆)
            $arrImg = $stmtGetImg->fetchAll()[0];

            //若是 itemImg 裡面不為空值，代表過去有上傳過
            if($arrImg['itemImg'] !== NULL){
                //刪除實體檔案
                @unlink("../images/items/".$arrImg['itemImg']);
            } 

            //itemImg SQL 語句字串
            $sql.= "`itemImg` = ? ,";

            //僅對 itemImg 進行資料繫結
            $arrParam[] = $itemImg;
            
        }
    }
}

//itemPrice SQL 語句和資料繫結
$sql.= "`itemPrice` = ? , 
        `itemQty` = ? , 
        `itemCategoryId` = ? 
        WHERE `itemId` = ? ";
$arrParam[] = $_POST['itemPrice'];
$arrParam[] = $_POST['itemQty'];
$arrParam[] = $_POST['itemCategoryId'];
$arrParam[] = (int)$_POST['itemId'];
$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);


header("Refresh: 3; url=./edit.php?itemId={$_POST['itemId']}");

if( $stmt->rowCount()> 0 ){
    $objResponse['success'] = true;
    $objResponse['info'] = "更新成功";
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);