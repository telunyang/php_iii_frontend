<?php
//讀取 composer 所下載的套件
require_once('vendor/autoload.php');

//資料庫主機設定
const DRIVER_NAME = "mysql"; //使用哪一家資料庫
const DB_HOST = "localhost"; //資料庫網路位址 (127.0.0.1)
const DB_USERNAME = "test"; //資料庫連線帳號
const DB_PASSWORD = "T1st@localhost"; //資料庫連線密碼
const DB_NAME = "shopping_cart"; //指定資料庫
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


/**
 * 官方範例
 * URL: https://phpspreadsheet.readthedocs.io/en/latest/
 */


//你的 excel 檔案路徑 (含檔名)
$inputFileName = './products.xlsx';

//透過套件功能來讀取 excel 檔
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

//讀取當前工作表(sheet)的資料列數
$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();

//依序讀取每一列，若是第一列為標題，建議 $i 從 2 開始
for($i = 2; $i <= $highestRow; $i++) {
    //若是某欄位值為空，代表那一列可能都沒資料，便跳出迴圈
    if( $spreadsheet->getActiveSheet()->getCell('A'.$i)->getValue() === '' || 
        $spreadsheet->getActiveSheet()->getCell('A'.$i)->getValue() === null ) break;
    
    //讀取 cell 值
    $itemName =         $spreadsheet->getActiveSheet()->getCell('A'.$i)->getValue();
    $itemImg =          $spreadsheet->getActiveSheet()->getCell('B'.$i)->getValue();
    $itemPrice =        $spreadsheet->getActiveSheet()->getCell('C'.$i)->getValue();
    $itemQty =          $spreadsheet->getActiveSheet()->getCell('D'.$i)->getValue();
    $itemCategoryId =   $spreadsheet->getActiveSheet()->getCell('E'.$i)->getValue();
    
    //寫入資料
    $sql = "INSERT INTO `items` 
            (`itemName`,`itemImg`,`itemPrice`,`itemQty`,`itemCategoryId`) 
            VALUES 
            (?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $arrParam = [
        $itemName,
        $itemImg,
        $itemPrice,
        $itemQty,
        $itemCategoryId
    ];

    //繫結資料並執行
    $stmt->execute($arrParam);

    //若是成功寫入資料
    if( $stmt->rowCount() > 0 ){
        //印出 AutoIncrement 的流水號碼 (若沒設定，預設為 0)
        echo $pdo->lastInsertId() . "\n";
    }
}