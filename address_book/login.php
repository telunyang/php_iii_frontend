<?php
//引用資料庫連線
require_once('./db.inc.php');

if( isset($_POST['username']) && isset($_POST['pwd']) ){
    //SQL 語法
    $sql = "SELECT `username`, `pwd` 
            FROM `admin` 
            WHERE `username` = ? 
            AND `pwd` = ? ";

    //資料繫結 SQL 字串中的問號(?)
    $arrParam = [
        $_POST['username'],
        sha1($_POST['pwd'])
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    //影響或查詢列數大於 0 ，代表有查詢結果
    if( $stmt->rowCount() > 0 ){
        //啟動 session
        session_start();

        //將傳送過來的 post 變數資料，放到 session，
        $_SESSION['username'] = $_POST['username'];

        //3 秒後跳頁
        header("Refresh: 5; url=./admin.php");
        echo "登入成功!!! 5秒後自動進入後端頁面";
    } else {
        header("Refresh: 5; url=./index.php");
        echo "登入失敗…5秒後自動回登入頁";
    }
} else {
    header("Refresh: 3; url=./index.php");
    echo "請確實登入…3秒後自動回登入頁";
}