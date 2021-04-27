<?php
//啟動 session
session_start();

//引用資料庫連線
require_once('./db.inc.php');

if( isset($_POST['username']) && isset($_POST['pwd']) ){
    //SQL 語法
    $sql = "SELECT `username`, `pwd` 
            FROM `admin` 
            WHERE `username` = ? 
            AND `pwd` = ? ";

    $arrParam = [
        $_POST['username'],
        sha1($_POST['pwd'])
    ];

    $pdo_stmt = $pdo->prepare($sql);
    $pdo_stmt->execute($arrParam);

    if( $pdo_stmt->rowCount() > 0 ){
        //將傳送過來的 post 變數資料，放到 session，
        $_SESSION['username'] = $_POST['username'];

        //3 秒後跳頁
        header("Refresh: 3; url=./admin.php");
        echo "登入成功!!! 3秒後自動進入後端頁面";
    } else {
        //關閉 session
        session_destroy();

        header("Refresh: 3; url=./index.php");
        echo "登入失敗…3秒後自動回登入頁";
    }
} else {
    //關閉 session
    session_destroy();

    header("Refresh: 3; url=./index.php");
    echo "請確實登入…3秒後自動回登入頁";
}