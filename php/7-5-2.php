<?php
//判斷上傳是否成功 (error === 0)
if( $_FILES["fileUpload"]["error"] === 0 ) {
    /**
     * 上傳檔案有副檔名的情況下，可以用簡單的方法取得副檔名
     */
    //1. 先取得完整的檔案名稱
    $fileName = $_FILES["fileUpload"]["name"];
    //2. 將完整檔案名稱依特定字元切割，轉為陣列
    $arr = explode(".", $fileName);
    //3. 特定字元切割後的陣列最後一個元素，即為副檔名
    $extension = $arr[ count($arr) - 1 ];

    /**
     * 取得副檔名，還有下面這種寫法：
     * $extension = pathinfo($_FILES["studentImg"]["name"], PATHINFO_EXTENSION);
     */

    /**
     * 使用時間函式，定義上傳檔案名稱
     * 用法 -> date("格式化字串")
     * 例如 -> date("Y-m-d H:i:s") -> 2021-12-31 13:14:00
     * Y: 西元年
     * m: 兩位數的月份
     * d: 兩位數的日
     * H: 兩位數(24小時制)的時
     * i: 兩位數(24小時制)的分
     * s: 兩位數(24小時制)的秒
     */
    //1. 建立時間字串
    $fileName = date("YmdHis");
    //2. 將時間字串結合副檔名
    $fileName = $fileName . "." . $extension;

    //若上傳成功，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    $isSuccess = move_uploaded_file(
        $_FILES["fileUpload"]["tmp_name"], //上傳暫存路徑
        "./tmp/".$fileName //實際存放路徑與自訂檔名
    );

    //判斷上傳是否成功
    if( $isSuccess ) {
        echo "上傳成功!!<br />";
        echo "檔案名稱: ".$fileName."<br />";
        echo "檔案類型: ".$_FILES["fileUpload"]["type"]."<br />";
        echo "檔案大小: ".$_FILES["fileUpload"]["size"]."<br />";
    } else { //檔案移動失敗，則顯示錯誤訊息
        echo "上傳失敗…<br />";
        echo "<a href='javascript:window.history.back();'>回上一頁</a>";
    }
}