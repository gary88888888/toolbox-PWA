<?php
    require_once 'connect.php';

    $qrcode = isset($_GET["QRcode"])? $_GET["QRcode"] : "";


    // $sql = "SELECT * FROM tools   ORDER BY sort DESC  ";

    $sql = "SELECT `site` FROM tools_image WHERE QRcode LIKE '$qrcode'    ";
    $res = mysqli_query($con,$sql);
    $response =array();
    while($row = mysqli_fetch_assoc($res)){

        $response[] = $row;
    }

    echo json_encode($response);

    exit;

?>
