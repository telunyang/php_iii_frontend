<?php
$headers = [
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.80 Safari/537.36',
];

$sentence = "我每天都被自己帥醒，壓力好大";

$url = "https://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&tl=zh-TW&q=".$sentence;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$raw_data = curl_exec($ch);
curl_close($ch);

$fp = fopen("{$sentence}.mp3", "w");
fwrite($fp, $raw_data);
fclose($fp);

$output = shell_exec("./ffmpeg -i {$sentence}.mp3 -filter:a 'atempo=1.5' {$sentence}_加速.mp3");