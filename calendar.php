<?php 
$now = new DateTime();    //DateTime is a core PHP class as of version 5.2.0 

$formatter = new IntlDateFormatter('ja_JP', IntlDateFormatter::FULL, 
        IntlDateFormatter::FULL, 'Asia/Tokyo', IntlDateFormatter::GREGORIAN); 

echo 'It is now: "' . $formatter->format($now) . '" in Tokyo' . "\n"; 
//above gives [It is now: "2011年8月19日金曜日 23時32分27秒JST" in Tokyo] 

$formatter = new IntlDateFormatter('ja_JP@calendar=japanese', IntlDateFormatter::FULL, 
        IntlDateFormatter::FULL, 'Asia/Tokyo', IntlDateFormatter::TRADITIONAL); 

echo 'It is now: "' . $formatter->format($now) . '" in Tokyo' . "\n"; 
//above gives [It is now: "平成23年8月19日金曜日 23時32分27秒JST" in Tokyo] 
?>