<?php
    require_once 'connect.php';
    $mode = isset($_POST["mode"])? $_POST["mode"] : "";
    $box_id = isset($_POST["box_id"])? $_POST["box_id"] : "";
    $locateOpen = "UPDATE `tools` SET `isLocate` = '1' WHERE `tools`.`box_id` LIKE  '$box_id'";
    $locateClose = "UPDATE `tools` SET `isLocate` = '0' WHERE `tools`.`box_id` LIKE  '$box_id'";



    switch($mode){
        case "open":
            $result = mysqli_query($con,$locateOpen);
            echo("success");
            break;
        case "close":
            $result = mysqli_query($con,$locateClose);
            echo("success");
            break;
    };








?>
