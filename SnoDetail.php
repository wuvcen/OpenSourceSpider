<?php
include 'libs.php';
//get info from POST require
header('Content-Type:application/json;charset=utf-8 ');
ini_set("display_errors", 0);
error_reporting(E_ALL^E_NOTICE);
$StuNum = $_POST["StuNum"];
$Password = $_POST["Password"];
//$StuNum = "20121308084";
//$Password = base64_encode("931105");

$login_url = "http://ucard.nuist.edu.cn:8070/Account/Login";
//Set Cookie storage url
$cookie = dirname(__FILE__) . '/cookie_ucard_' . $StuNum . '.txt';
$post = array('SignType' => 'SynSno', 'UserAccount' => $StuNum, 'Password' => $Password, 'NextUrl' => '');
//begin login
login_post($login_url, $cookie, $post);


//grab data from url
$getinfourl = "http://ucard.nuist.edu.cn:8070/SynCard/Manage/BasicInfo";
$content = get_content($getinfourl, $cookie);

$match = '/<td class="first">(.*?)<\/td>/is';
$match2 = '/<td class="second">(.*?)<\/td>/is';
preg_match_all($match, $content, $outcome1);
preg_match_all($match2, $content, $outcome2);

//export json
echo "{";
if (count($outcome1[0]) > 1) {
	unlink($cookie);
	echo '"status":"OK",';
	for ($x = 0; $x < count($outcome1[0]); $x++) {
		echo '"' . trim(strip_tags($outcome1[0][$x])) . '"';
		echo ":";
		echo '"' . trim(strip_tags($outcome2[0][$x])) . '"';
		if ($x != count($outcome1[0]) - 1) {
			echo ",";
		}
	}
} else {
	echo '"status":"failed"';
}
echo "}";

?>
