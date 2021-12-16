<?php
require_once 'connect.php';
$mode = isset($_POST["mode"]) ? $_POST["mode"] : "";
$user = isset($_POST["user"]) ? $_POST["user"] : "";

$box_id = isset($_POST["box_id"]) ? $_POST["box_id"] : "";



// $num_of_rows = mysqli_num_rows($result);
$response = array();
if ($con) {

    switch ($mode) {
        case 'user':
            $sql = "SELECT user , position FROM login ";

            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_assoc($result)) {

                $response[] = $row;
            }
            echo json_encode($response);
            break;
        case 'person':

            $sql = "SELECT * FROM login as l LEFT JOIN tools_order as o ON l.user = o.user LEFT JOIN tools as t ON o.QRcode = t.QRcode WHERE l.user = '$user'  ORDER BY o.time_stamp_update DESC ";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_assoc($result)) {

                $response[] = $row;
            }
            echo json_encode($response);
            break;

        case 'tool':
            # code...
            break;
    }
} else {
    echo ('error');
}
