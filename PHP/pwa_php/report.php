<?php
require_once 'connect.php';
$mode = isset($_POST["mode"]) ? $_POST["mode"] : "";
$user = isset($_POST["user"]) ? $_POST["user"] : "";

$QRcode = isset($_POST["QRcode"]) ? $_POST["QRcode"] : "";
$reportType = isset($_POST["reportType"]) ? $_POST["reportType"] : "";
$remark = isset($_POST["remark"]) ? $_POST["remark"] : "";

//search
$reportStatus = isset($_POST["reportStatus"]) ? $_POST["reportStatus"] : "";
////fix
$report_id = isset($_POST["report_id"]) ? $_POST["report_id"] : "";



$response = array();
if ($con) {
    switch ($mode) {
        case 'report':
            $sql = "INSERT tools_report(QRcode,user,reportType,remark,reportStatus) VALUES ('$QRcode','$user','$reportType','$remark','0')";
            $result = mysqli_query($con, $sql);
            if($result){
                echo "success";
            }
        case 'fix':
            $sql = "UPDATE tools_report SET reportStatus ='1' WHERE report_id ='$report_id'";
            $result = mysqli_query($con, $sql);
            if($result){
                echo "success";
            }
            break;

        case 'search':
            $search = "SELECT * FROM tools_report as r LEFT JOIN tools as t ON r.QRcode = t.QRcode  ORDER BY r.timeStamp DESC";

            $result = mysqli_query($con,$search);
            $response =array();

            while($row = mysqli_fetch_assoc($result)){
                $response[] = $row;
            }
            echo json_encode($response);

            break;
        case 'count':
            $count = "SELECT * FROM tools_report WHERE reportStatus ='0'";

            $result = mysqli_query($con,$count);
            $num_of_rows = mysqli_num_rows($result);
            echo $num_of_rows;
            break;
    }
} else {
    echo ('error');
}
