<?php
require_once 'connect.php';

$qrcode = isset($_GET["QRcode"]) ? $_GET["QRcode"] : "";
$date = isset($_GET["date"]) ? $_GET["date"] : "";
$time = isset($_GET["time"]) ? $_GET["time"] : "";
$status = 0;
$user = isset($_GET["user"]) ? $_GET["user"] : "";


$insert = "INSERT INTO tools_order (QRcode,return_date,return_time,`order_status`,`user`)
VALUES('$qrcode','$date','$time','$status','$user') ";
$res = mysqli_query($con, $insert);
echo ("success");


exit;
