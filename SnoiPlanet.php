<?php
include 'libs.php';
ini_set("display_errors", 0);
error_reporting(E_ALL^E_NOTICE);
header('Content-Type:application/json;charset=utf-8 ');
$StuNum = $_POST["StuNum"];
$Password = base64_decode($_POST["Password"]);
$rs = get_iP($StuNum, $Password);
echo '{"msg":' . '"' . $rs . '"}';
?>
