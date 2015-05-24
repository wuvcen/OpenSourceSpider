<?php
include 'libs.php';
ini_set("display_errors", 0);
error_reporting(E_ALL^E_NOTICE);
header('Content-Type:application/json;charset=utf-8 ');
$StuNum = $_POST["StuNum"];
$Password = $_POST["Password"];
$Query_Pwd = $_POST["QueryPwd"];
$Amount = $_POST["Amount"];
$login_url = "http://ucard.nuist.edu.cn:8070/Account/Login";
$TransferUrl = "http://ucard.nuist.edu.cn:8070/SynCard/Manage/TransferPost";
$updateCookieUrl = "http://ucard.nuist.edu.cn:8070/SynCard/Manage/Transfer";
//Set Cookie storage url
$cookie = dirname(__FILE__) . '/cookie_ucard_' . $StuNum . '.txt';

$post = array('SignType' => 'SynSno', 'UserAccount' => $StuNum, 'Password' => $Password, 'NextUrl' => '');
//begin login
login_post($login_url, $cookie, $post);
//update cookie
$rs = get_content($updateCookieUrl, $cookie);

$FromCard = "bcard";
$ToCard = "card";
$transpost = array('Amount' => $Amount, 'Password' => $Query_Pwd, 'FromCard' => 'bcard', 'ToCard' => 'card');

post_with_cookie($TransferUrl, $cookie, $transpost);
unlink($cookie);
?>
