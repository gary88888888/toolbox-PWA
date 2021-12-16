<?php
require_once 'connect.php';
$mode = isset($_POST["mode"]) ? $_POST["mode"] : "";

$box_id = isset($_POST["box_id"]) ? $_POST["box_id"] : "";




$response = array();
if ($con) {

    switch ($mode) {
        case 'all':
            $sql = "SELECT * FROM tools_order as o LEFT JOIN tools as t ON o.QRcode = t.QRcode  ORDER BY o.time_stamp_update DESC ";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_assoc($result)) {

                $response[] = $row;
            }
            echo json_encode($response);
            break;
        case 'person':
            # code...
            break;

        case 'tool':
            # code...
            break;
    }
} else {
    echo ('error');
}
