<?php
require_once('./checkSession.php'); //引入判斷是否登入機制
require_once('./db.inc.php'); //引用資料庫連線

//將所有 id 透過「,」結合在一起，例如「1,2,3」
$strIds = join(",", $_POST['chk']);

//記錄資料表刪除數量
$count = 0;

//先查詢出所有 id 資料欄位中的大頭貼檔案名稱
$sqlGetImg = "SELECT `studentImg` FROM `students` WHERE FIND_IN_SET(`id`, ?) ";
$stmtGetImg = $pdo->prepare($sqlGetImg);
$stmtGetImg->execute([$strIds]);
if( $stmtGetImg->rowCount() > 0 ){
    //取得所有大頭貼檔案名稱
    $arrImg = $stmtGetImg->fetchAll();

    //各別刪除大頭貼實際檔案
    for($i = 0; $i < count($arrImg); $i++){
        //若是 studentImg 裡面不為空值，代表過去有上傳過
        if($arrImg[$i]['studentImg'] !== NULL){
            //刪除實體檔案
            @unlink("./files/".$arrImg[$i]['studentImg']);
        }  
    }

    //在這裡刪除資料表記錄
    $sqlDelete = "DELETE FROM `students` WHERE FIND_IN_SET(`id`, ?) ";
    $stmtDelte = $pdo->prepare($sqlDelete);
    $stmtDelte->execute([$strIds]);
    $count = $stmtDelte->rowCount();
}

header("Refresh: 3; url=./admin.php");
if($count > 0) {
    echo "刪除成功";
} else {
    echo "刪除失敗";
}