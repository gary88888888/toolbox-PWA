<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
    header('Content-Type:application/json; charset=utf-8');
    $con = mysqli_connect('192.168.1.103', 'root','0981472880','toolsbox');

?>