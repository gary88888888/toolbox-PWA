<?php
    require_once 'connect.php';


    $qrcode = isset($_POST["qrcode"])? $_POST["qrcode"] : "";


    $sql = "SELECT * FROM tools where qrcode LIKE '$qrcode' ";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $num_of_rows = mysqli_num_rows($result);
    if($con){
        if($num_of_rows==1){//判斷是否至少有一組資料達到要求

            echo json_encode($row);

        }else{
            echo ("notfound");
            echo ($qrcode);
        }
    }else{
        echo('error');
    }




?>

