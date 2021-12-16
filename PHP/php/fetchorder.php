<?php
    require_once 'connect.php';
    $qrcode = isset($_POST["qrcode"])? $_POST["qrcode"] : "";
    $sql = "SELECT * FROM tools_order  where qrcode LIKE '$qrcode' AND `status` LIKE '1'  ";

    // $sql = "SELECT tool.*,img.site FROM `tools` as tool LEFT JOIN `tools_image` as img ON tool.QRcode = img.QRcode  ORDER BY sort DESC  ";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $num_of_rows = mysqli_num_rows($result);
    if($con){
        if($result){//判斷是否至少有一組資料達到要求

            echo json_encode($row);

        }else{
            echo ("notfound");
            echo ($qrcode);
        }
    }else{
        echo('error');
    }

?>