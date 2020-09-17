<?php
// $to="小明的信箱";
// 　$subject="這是封測試郵件";
// 　$message="這是測試內容";
// 　$headers = "From: 寄件人信箱" . "\r\n" ;
// 　mail($to,$subject,$message,$headers);　//調用 mail() 函式將此封信件發送出去
$to='jager_ye@mail.chungyo.net';
$subject='測試';
$message='我好棒喔';
$headers="From:ggInInDer@mail.chungyo.net\r\n";
mail($to,$subject,$message,$headers);
