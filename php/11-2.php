<?php
$filePath01 = "tmp/test01.txt";
$filePath03 = "tmp/test03.txt";

//確認檔案存在，則進行檔案刪除
if( file_exists($filePath01) ) {
    $isDeleted = unlink($filePath01 );
    if( $isDeleted ){
        echo "{$filePath01} 刪除成功!!";
    } else {
        echo "{$filePath01} 刪除失敗…";
    }
} else {
    echo "沒有 tmp/test01.txt 這個檔案…";
}

echo "<hr>";

//檔案不存在，則顯示相關訊息
if(file_exists("tmp/test03.txt")) {
    unlink("./tmp/test01.txt");
} else {
    echo "沒有 tmp/test03.txt 這個檔案…";
}