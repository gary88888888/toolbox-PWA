<?php
    require_once 'connect.php';
    $mode = isset($_POST["mode"])? $_POST["mode"] : "";
    $box_id = isset($_POST["box_id"])? $_POST["box_id"] : "";
    $sql = "SELECT * FROM tools where box_id LIKE '$box_id' ";
    $returnOpen = "UPDATE `tools` SET `status` = '10' WHERE `tools`.`box_id` LIKE  '$box_id'";
    $returnClose = "UPDATE `tools` SET `status` = '0' WHERE `tools`.`box_id` LIKE  '$box_id'";
    $returnError = "UPDATE `tools` SET `status` = '1' WHERE `tools`.`box_id` LIKE  '$box_id'";
    $search = "SELECT status FROM `tools` WHERE `tools`.`box_id` LIKE  '$box_id'";


    switch($mode){
        case "open":
            $result = mysqli_query($con,$returnOpen);
            break;
        case "close":
            $result = mysqli_query($con,$returnClose);
            break;
        case "error":
            $result = mysqli_query($con,$returnError);
            break;
        case "search":
            $result = mysqli_query($con,$search);
            $response =array();

            while($row = mysqli_fetch_assoc($result)){
                $response[] = $row;
            }
            echo json_encode($response);
            break;
    };




    if ($result && $mode!="search") {
        echo("success");
    }else{

    }




?>
