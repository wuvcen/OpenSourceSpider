<?php
include 'libs.php';
$StuNum = $_POST["StuNum"];
$Password = $_POST["Password"];
$QueryType = $_POST["QueryType"];
ini_set("display_errors", 0);
error_reporting(E_ALL^E_NOTICE);
header('Content-Type:application/json;charset=utf-8 ');
$LoginUrl = "http://ucard.nuist.edu.cn:8070/Account/Login";
//login
$UpdateCookieUrl = "http://ucard.nuist.edu.cn:8070/SynCard/Manage/TrjnIndex";
$TodayUrl = "http://ucard.nuist.edu.cn:8070/SynCard/Manage/CurrentDayTrjn";
$WeekUrl = "http://ucard.nuist.edu.cn:8070/SynCard/Manage/OneWeekTrjn";

$cookie = dirname(__FILE__) . '/cookie_ucard_' . $StuNum . '.txt';
$login_post = array('SignType' => 'SynSno', 'UserAccount' => $StuNum, 'Password' => $Password, 'NextUrl' => '');
//begin login
login_post($LoginUrl, $cookie, $login_post);
//update cookie
get_content($UpdateCookieUrl, $cookie);
$rs = null;
if ($QueryType == "Today") {
	$rs = get_content($TodayUrl, $cookie);
} else if ($QueryType == "Week") {
	$rs = get_content($WeekUrl, $cookie);
}
//	echo $rs;
$matchfrist = '/<td class="first">(.*?)<\/td>/is';
$matchseconde = '/<td class="second">(.*?)<\/td>/is';

preg_match_all($matchfrist, $rs, $outcome1);
preg_match_all($matchseconde, $rs, $outcome2);
$sum = count($outcome1[0]) / 5;
//	echo $sum;
echo "{";
if ($sum > 0) {
	echo '"status":"OK","Array":[';
	for ($x = 0; $x < $sum; $x++) {
		echo "{";
		echo '"' . trim(strip_tags($outcome1[0][$x * 5])) . '"';
		echo ":";
		echo '"' . trim(strip_tags($outcome2[0][$x * 5])) . '",';
		echo '"' . trim(strip_tags($outcome1[0][$x * 5 + 1])) . '"';
		echo ":";
		echo '"' . trim(strip_tags($outcome2[0][$x * 5 + 1])) . '",';
		echo '"' . trim(strip_tags($outcome1[0][$x * 5 + 2])) . '"';
		echo ":";
		echo '"' . trim(strip_tags($outcome2[0][$x * 5 + 2])) . '",';
		echo '"' . trim(strip_tags($outcome1[0][$x * 5 + 3])) . '"';
		echo ":";
		echo '"' . trim(strip_tags($outcome2[0][$x * 5 + 3])) . '",';
		echo '"' . trim(strip_tags($outcome1[0][$x * 5 + 4])) . '"';
		echo ":";
		echo '"' . trim(strip_tags($outcome2[0][$x * 5 + 4])) . '"';
		echo "}";
		if ($x != $sum - 1) {
			echo ",";
		}
		if ($x == $sum - 1) {
			echo "]";
		}
	}
} else {
	echo '"status":"failed"';
}
echo "}";
unlink($cookie);
?>
