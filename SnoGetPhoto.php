<?php
include 'libs.php';
ini_set("display_errors", 0);
error_reporting(E_ALL^E_NOTICE);
$StuNum = $_POST["StuNum"];
$Password = $_POST["Password"];
$Pwd = base64_decode($Password);
$url = "http://ucard.nuist.edu.cn:8070/Api/Card/GetMyPhoto";
$iPlanet = get_iP($StuNum, $Pwd);
$post_data = array('iPlanetDirectoryPro' => $iPlanet, 'sno' => $StuNum);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
//登录提交的地址
curl_setopt($curl, CURLOPT_HEADER, 0);
//是否显示头信息
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);
//自动显示返回的信息,不要轻易修改
curl_setopt($curl, CURLOPT_POST, 1);
//post方式提交
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));
//要提交的信息
$rs = curl_exec($curl);
//执行cURL
curl_close($curl);
?>
