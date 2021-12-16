<?php
    require_once 'connect.php';

    $sql = "SELECT * FROM tools   ORDER BY `status` ASC  ";

    // $sql = "SELECT tool.*,img.site FROM `tools` as tool LEFT JOIN `tools_image` as img ON tool.QRcode = img.QRcode  ORDER BY sort DESC  ";
    $res = mysqli_query($con,$sql);
    $response =array();
    while($row = mysqli_fetch_assoc($res)){

        $response[] = $row;
    }

    echo json_encode($response);

    exit;

?>
