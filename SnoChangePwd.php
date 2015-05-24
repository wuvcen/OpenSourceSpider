<?php
include 'libs.php';
ini_set("display_errors", 0);
error_reporting(E_ALL^E_NOTICE);
header('Content-Type:application/json;charset=utf-8 ');
$StuNum = $_POST["StuNum"];
$Password = $_POST["Password"];
$ChangePwd = $_POST["NewPassword"];

$login_post_data = array('SignType' => 'SynSno', 'UserAccount' => $StuNum, 'Password' => $Password, 'NextUrl' => '');
$cookie = dirname(__FILE__) . '/cookie_ucard_' . $StuNum . '.txt';

$LoginUrl = "http://ucard.nuist.edu.cn:8070/Account/Login";
$updateCookieUrl = "http://ucard.nuist.edu.cn:8070/SynCard/Manage/ChangeQueryPwd";
$postPwdUrl = "http://ucard.nuist.edu.cn:8070/SynCard/Manage/ChangeQueryPwd";

//login
login_post($LoginUrl, $cookie, $login_post_data);
//update cookie
get_content($updateCookieUrl, $cookie);
$changQueryPwd = array('Password' => $Password, 'NewPassword' => $ChangePwd, 'ConfirmPassword' => $ChangePwd);

post_with_cookie($postPwdUrl, $cookie, $changQueryPwd);
$rs = unlink($cookie);
?>
