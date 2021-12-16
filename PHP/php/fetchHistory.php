<?php
    require_once 'connect.php';
    $qrcode = isset($_GET["qrcode"])? $_GET["qrcode"] : "";
    $sql = "SELECT * FROM toolsorder  where qrcode LIKE '$qrcode' ORDER BY time_stamp DESC";

    // $sql = "SELECT tool.*,img.site FROM `tools` as tool LEFT JOIN `tools_image` as img ON tool.QRcode = img.QRcode  ORDER BY sort DESC  ";
    $res = mysqli_query($con,$sql);
    $response =array();
    while($row = mysqli_fetch_assoc($res)){

        $response[] = $row;
    }
    if($response){
        echo json_encode($response);
    }else{
        echo("error");
    }


    exit;

?>