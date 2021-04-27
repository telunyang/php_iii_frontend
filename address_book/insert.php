<?php
require_once('./checkSession.php'); //引入判斷是否登入機制
require_once('./db.inc.php'); //引用資料庫連線

//SQL 敘述
$sql = "INSERT INTO `students` 
        (`studentId`, `studentName`, `studentGender`, `studentBirthday`, `studentPhoneNumber`, `studentDescription`, `studentImg`) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

if( $_FILES["studentImg"]["error"] === 0 ) {
    //為上傳檔案命名
    $studentImg = date("YmdHis");
    
    //找出副檔名
    $extension = pathinfo($_FILES["studentImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $imgFileName = $studentImg.".".$extension;

    //移動暫存檔案到實際存放位置
    $isSuccess = move_uploaded_file($_FILES["studentImg"]["tmp_name"], "./files/".$imgFileName);

    //若上傳失敗，則不會繼續往下執行，回到管理頁面
    if( !$isSuccess ) {
        header("Refresh: 3; url=./admin.php");
        echo "圖片上傳失敗";
        exit();
    }
}

//繫結用陣列
$arr = [
    $_POST['studentId'],
    $_POST['studentName'],
    $_POST['studentGender'],
    $_POST['studentBirthday'],
    $_POST['studentPhoneNumber'],
    $_POST['studentDescription'],
    $imgFileName
];

$pdo_stmt = $pdo->prepare($sql);
$pdo_stmt->execute($arr);
if($pdo_stmt->rowCount() === 1) {
    header("Refresh: 3; url=./admin.php");
    echo "新增成功";
} else {
    header("Refresh: 3; url=./admin.php");
    echo "新增失敗";
}