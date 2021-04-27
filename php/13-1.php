<?php
//資料庫主機設定
const DRIVER_NAME = "mysql"; //使用哪一家資料庫
const DB_HOST = "localhost"; //資料庫網路位址 (127.0.0.1)
const DB_USERNAME = "test"; //資料庫連線帳號
const DB_PASSWORD = "T1st@localhost"; //資料庫連線密碼
const DB_NAME = "address_book"; //指定資料庫
const DB_CHARSET = "utf8mb4"; //指定字元集，亦即是文字的編碼來源
const DB_COLLATE = "utf8mb4_unicode_ci"; //在字元集之下的排序依據

//資料庫連線變數
$pdo = null;

//錯誤處理
try {
    //設定 PDO 屬性 (Array 型態)
    $options = [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . DB_CHARSET . ' COLLATE ' . DB_COLLATE
    ];

    //PDO 連線
    $pdo = new PDO(
        DRIVER_NAME. ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' .DB_CHARSET, 
        DB_USERNAME, 
        DB_PASSWORD, 
        $options
    );
} catch (PDOException $e) {
    echo "資料庫連結失敗，訊息: " . $e->getMessage();
    exit();
}