<?php
    require_once '../connect.php';
    $qrcode = isset($_POST["QRcode"])? $_POST["QRcode"] : "";
    $newBox_id = isset($_POST["box_id"])? $_POST["box_id"] : "";
    $sql = "UPDATE tools SET box_id = '$newBox_id' WHERE QRcode = '$qrcode'";

    // $sql = "SELECT tool.*,img.site FROM `tools` as tool LEFT JOIN `tools_image` as img ON tool.QRcode = img.QRcode  ORDER BY sort DESC  ";
    $res = mysqli_query($con,$sql);
    if (mysqli_affected_rows($con) == 1 ) {
        echo("success");
    }else{
        echo("error");
    }

    exit;

?>