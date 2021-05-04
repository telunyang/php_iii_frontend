<?php
//讀取 composer 所下載的套件
require_once 'plugins/phpQuery-onefile.php';

//轉成 json 用的 associative array
$obj = [];
$obj['success'] = false;
$obj['info'] = '下載失敗'; 

try{
    //自訂 Request 標頭
    $headers = [
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
        'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
    ];

    //LINE 官方貼圖網址
    $url = 'https://store.line.me/stickershop/product/19461/zh-Hant';

    //設定 cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); //設定網址
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //若網站導向其它頁面，自動導到正確可讀取的頁面
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //設置自訂標頭

    //透過 curl 取得 LINE 官方貼圖的 html 原始碼
    $html = curl_exec($ch);

    //關閉 cURL 連線
    curl_close($ch);

    //指定圖片下載路徑
    $folderPath = './line_stickers';

    //若是沒有圖片下載路徑所指定的資料夾
    if( !file_exists($folderPath) ){
        //新增路徑所在的資料夾
        mkdir($folderPath);
    }

    //下載筆數
    $count = 0;

    //將 html 原始碼作為 phpQuery 的資料來源
    $doc = phpQuery::newDocumentHTML($html);

    //取得所有放置圖貼的 li 元素
    $li_elms = $doc->find('ul.mdCMN09Ul.FnStickerList li.mdCMN09Li.FnStickerPreviewItem');
    
    //走訪所有的 li，取得其屬性 data-preview
    $li_elms->each(function(DOMElement $li){
        /**
         * 因為此處 function 為 callback function，
         * 讀不到外部變數，需要將 $count 跟 $folderPath 視為全域變數來存取 
         */
        global $count;
        global $folderPath;

        /*
        data-preview 內容類似:
        {
            "type" : "static", 
            "id" : "370641702", 
            "staticUrl" : "https://stickershop.line-scdn.net/stickershop/v1/sticker/370641702/android/sticker.png;compress=true", 
            "fallbackStaticUrl" : "https://stickershop.line-scdn.net/stickershop/v1/sticker/370641702/android/sticker.png;compress=true", 
            "animationUrl" : "", 
            "popupUrl" : "", 
            "soundUrl" : "" 
        }
        */

        //取得 data-preview 屬性的值，將其 JSON 文字轉成物件來存取
        $obj = json_decode(pq($li)->attr('data-preview'), true);

        //下載貼圖
        shell_exec("curl {$obj["staticUrl"]} -o {$folderPath}\\{$obj["id"]}.png");
        $count++;
    });

    if($count > 0){
        $obj['success'] = true;
        $obj['info'] = "下載完成，共 {$count} 張貼圖";
    }
} catch(Exception $e){
    $obj['info'] = "程式出錯: {$e->getMessage()}";
}

echo json_encode($obj, JSON_UNESCAPED_UNICODE);