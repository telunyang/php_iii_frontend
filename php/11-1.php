<?php
//使用 fwrite 寫入檔案
$fp = fopen("tmp/test01.txt", "w");
fwrite($fp, "這是 fwrite()\n這是 fwrite()");
fclose($fp);

//使用 fgets 讀取 test01.txt 檔案中的每一行
$fp = fopen("tmp/test01.txt", "r");
while( $line = fgets($fp) ) {
    echo $line. "<br />";
}
fclose($fp);

//使用 fputs 寫入檔案
$fp = fopen("tmp/test02.txt", "w");
fputs($fp, "這是 fputs()\n這是 fputs()");
fclose($fp);

//使用 fread 讀取 test02.txt 全部內容
$fp = fopen("tmp/test02.txt", "r");
$contents = fread($fp, filesize("tmp/test02.txt"));
echo nl2br($contents);
fclose($fp);