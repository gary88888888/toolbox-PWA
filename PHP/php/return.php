<?php
    require_once 'connect.php';


    $qrcode = isset($_GET["QRcode"])? $_GET["QRcode"] : "";


    $sql = "SELECT * FROM tools where qrcode LIKE '$qrcode' ";
    $return = "UPDATE `tools` SET `status` = '0' WHERE `tools`.`QRcode` LIKE  '$qrcode'";
    $return2 = "UPDATE `tools_order` SET `status` = '0' WHERE `tools`.`QRcode` LIKE  '$qrcode' AND `tools`.`status` LIKE '1'" ;
    $result = mysqli_query($con,$return);
    // $row = mysqli_fetch_assoc($result);
    // $num_of_rows = mysqli_num_rows($result);

    if (mysqli_affected_rows($con) == 1 ) {
        echo("success");
    }else{
        echo("error");
    }




?>
