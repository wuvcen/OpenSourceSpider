<?php
include 'libs.php';
//get info from POST require
ini_set("display_errors", 0);
error_reporting(E_ALL^E_NOTICE);
header('Content-Type:application/json;charset=utf-8 ');
$StuNum = $_POST["StuNum"];
$Password = $_POST["Password"];
$login_url = "http://ucard.nuist.edu.cn:8070/Account/Login";

//Set Cookie storage url
$cookie = dirname(__FILE__) . '/cookie_ucard_' . $StuNum . '.txt';
$post = array('SignType' => 'SynSno', 'UserAccount' => $StuNum, 'Password' => $Password, 'NextUrl' => '');
//begin login
login_post($login_url, $cookie, $post);
$url = "http://ucard.nuist.edu.cn:8070/SynCard/Manage/SubsidyTrjn";
$content = get_content($url, $cookie);

$matchfrist = '/<td class="first">(.*?)<\/td>/is';
$matchseconde = '/<td class="second">(.*?)<\/td>/is';

preg_match_all($matchfrist, $content, $outcome1);
preg_match_all($matchseconde, $content, $outcome2);
$sum = count($outcome1[0]) / 6;

echo "{";
if ($sum > 0) {
	echo '"status":"OK","Array":[';
	for ($x = 0; $x < $sum; $x++) {
		echo "{";
		echo '"' . trim(strip_tags($outcome1[0][$x * 6])) . '"';
		echo ":";
		echo '"' . trim(strip_tags($outcome2[0][$x * 6])) . '",';
		echo '"' . trim(strip_tags($outcome1[0][$x * 6 + 1])) . '"';
		echo ":";
		echo '"' . trim(strip_tags($outcome2[0][$x * 6 + 1])) . '",';
		echo '"' . trim(strip_tags($outcome1[0][$x * 6 + 2])) . '"';
		echo ":";
		echo '"' . trim(strip_tags($outcome2[0][$x * 6 + 2])) . '",';
		echo '"' . trim(strip_tags($outcome1[0][$x * 6 + 3])) . '"';
		echo ":";
		echo '"' . trim(strip_tags($outcome2[0][$x * 6 + 3])) . '",';
		echo '"' . trim(strip_tags($outcome1[0][$x * 6 + 4])) . '"';
		echo ":";
		echo '"' . trim(strip_tags($outcome2[0][$x * 6 + 4])) . '",';
		echo '"' . trim(strip_tags($outcome1[0][$x * 6 + 5])) . '"';
		echo ":";
		echo '"' . trim(strip_tags($outcome2[0][$x * 6 + 5])) . '"';
		echo "}";
		if ($x != $sum - 1) {
			echo ",";
		}
		if($x == $sum-1){
			echo "]";
		}
	}
} else {
	echo '"status":"failed"';
}
echo "}";
unlink($cookie);
	?>
