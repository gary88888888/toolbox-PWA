<?php
    require_once 'connect.php';
    $box_id = isset($_GET["box_id"])? $_GET["box_id"] : "";

    $sql = "UPDATE toolsbox.tools SET status=666 WHERE box_id = '$box_id'";
    $result = mysqli_query($con,$sql);
    if ($result) {
        echo("success");
    }else{
        echo("error");
    }

?>