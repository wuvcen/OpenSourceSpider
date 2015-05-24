<?php
include 'libs.php';
ini_set("display_errors", 0);
error_reporting(E_ALL^E_NOTICE);
header('Content-Type:application/json;charset=utf-8 ');
function post_score($url1, $post1) {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url1);
	//登录提交的地址
	curl_setopt($curl, CURLOPT_HEADER, 0);
	//是否显示头信息
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);
	//自动显示返回的信息,不要轻易修改
	curl_setopt($curl, CURLOPT_POST, 1);
	//post方式提交
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post1));
	//要提交的信息
	curl_exec($curl);
	//执行cURL
	curl_close($curl);
	//关闭cURL资源，并且释放系统资源
}

$StuNum = $_POST["StuNum"];
$Password = $_POST["Password"];
$pageIndex = $_POST["pageIndex"];
$ScoreURI = "http://ucard.nuist.edu.cn:8070/Api/Score/Query";
$iPlanet = get_iP($StuNum, base64_decode($Password));
$post_data = array('xn' => '', 'iPlanetDirectoryPro' => $iPlanet, 'pageIndex' => $pageIndex);
post_score($ScoreURI, $post_data);
?>
