<?php
require_once 'connect.php';

$sql = "SELECT * FROM tools   ORDER BY `status` ASC  ";
$result = mysqli_query($con, $sql);
$num_of_rows = mysqli_num_rows($result);
$response = array();
if ($con) {

    while ($row = mysqli_fetch_assoc($result)) {

        $response[] = $row;
    }
    echo json_encode($response);
} else {
    echo ('error');
}
