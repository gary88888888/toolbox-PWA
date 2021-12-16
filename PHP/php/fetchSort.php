<?php
    require_once 'connect.php';

    $sql = "SELECT * FROM sort ORDER BY id DESC  ";
    $res = mysqli_query($con,$sql);
    $response =array();
    while($row = mysqli_fetch_assoc($res)){

        $response[] = $row;
    }

    echo json_encode($response);

    exit;

?>
