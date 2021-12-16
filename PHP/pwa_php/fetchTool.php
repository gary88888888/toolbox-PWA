<?php
    require_once 'connect.php';


    $box_id = isset($_POST["box_id"]) ? $_POST["box_id"] : "";

    $sql = "SELECT * FROM tools WHERE box_id = '$box_id'  ";
    // $sql = "SELECT tool.*,img.site FROM `tools` as tool LEFT JOIN `tools_image` as img ON tool.QRcode = img.QRcode  ORDER BY sort DESC  ";
    $res = mysqli_query($con,$sql);
    $response =array();
    while($row = mysqli_fetch_assoc($res)){

        $response[] = $row;
    }

    echo json_encode($response);

    exit;

?>
