<?php
    require_once 'connect.php';


    $account = isset($_POST["account"]) ? $_POST["account"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    if($account && $password){

        $result = mysqli_query($con,"SELECT * FROM login WHERE account LIKE '$account' AND passwords LIKE '$password'");

        $num_of_rows = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);

        if($num_of_rows==1){//判斷是否至少有一組資料達到要求

            echo json_encode($row);
            //echo "登入成功";
        }else{
            echo ("error");
        };

    }else{





    };




?>