<?php
    require_once 'connect.php';
    $user = isset($_POST["user"])? $_POST["user"] : "";
    $order_status = isset($_POST["order_status"])? $_POST["order_status"] : "";
    $mode = isset($_POST["mode"])? $_POST["mode"] : "";
    $status = 1;
    $sql = "SELECT * FROM tools_order as o LEFT JOIN tools as t ON o.QRcode = t.QRcode WHERE o.user = '$user' AND t.status = '$status' AND o.order_status = '$order_status'";
    $sql0 = "SELECT * FROM tools WHERE status = 0";
    $sql1 = "SELECT * FROM tools WHERE status = 1";
    $sql2 = "SELECT * FROM tools WHERE status = 2";
    $sql3 = "SELECT * FROM tools WHERE status = 3";






    switch ($mode) {
        case 'data':
            $result = mysqli_query($con,$sql);
            $response =array();
            while($row = mysqli_fetch_assoc($result)){
                $response[] = $row;
            }
            echo json_encode($response);
            break;

        case 'number':
            $result = mysqli_query($con,$sql);
            $num_of_rows = mysqli_num_rows($result);
            echo $num_of_rows;
            break;
        case 'count':
            $result0 = mysqli_query($con,$sql0);
            $result1 = mysqli_query($con,$sql1);
            $result2 = mysqli_query($con,$sql2);
            $result3 = mysqli_query($con,$sql3);
            $num_of_rows0 = mysqli_num_rows($result0);
            $num_of_rows1 = mysqli_num_rows($result1);
            $num_of_rows2 = mysqli_num_rows($result2);
            $num_of_rows3 = mysqli_num_rows($result3);
            $responseCount =array();


            $responseCount =[
                '0'=>$num_of_rows0,
                '1'=>$num_of_rows1,
                '2'=>$num_of_rows2,
                '3'=>$num_of_rows3,
            ];

            echo json_encode($responseCount) ;
            break;



    }






?>