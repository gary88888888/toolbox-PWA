<?php
require_once 'connect.php';


// $date = isset($_POST["date"]) ? $_POST["date"] : "";
// $time = isset($_POST["time"]) ? $_POST["time"] : "";
$data =file_get_contents('php://input');


$obj=json_decode($data,TRUE);
// $time = isset($_POST["backpack"]) ? $_POST["backpack"] : "";
$tools = json_encode($obj{'order'});
$date = json_encode($obj{'date'});
$time = json_encode($obj{'time'});
$number = count((array)json_decode($tools));
$user = $obj{'user'};
$i =0;
$status = 1;

// echo json_encode($test[1]{'name'});
// $delete = "DELETE  FROM tools_order ";

// mysqli_query($con,$delete);


for($i;$i<$number;$i++){

    $name = $test[$i]{"name"};
    $qrcode = $test[$i]{"QRcode"};
    echo($qrcode);
    // $num = $test[$i]{"num"};
    // $updateStatus = "UPDATE `tools` SET `status`='1' WHERE　`tools`.`QRcode` LIKE `$qrcode` ";

    $updateStatus = "UPDATE `tools` SET `status` = '1' WHERE `tools`.`QRcode` LIKE  '$qrcode'"; // 變數的引號要用單引號''

    $insert = "INSERT INTO tools_order (QRcode,tool_name,return_date,return_time,`status`) VALUES('$qrcode','$name','$date','$time','$status') ";
    // mysqli_query($con,$insert);
    mysqli_query($con,$updateStatus);
    mysqli_query($con,$insert);





}

exit;
?>