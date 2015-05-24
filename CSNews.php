<?php
include 'libs.php';
ini_set("display_errors", 0);
error_reporting(E_ALL ^ E_NOTICE);
header('Content-Type:application/json;charset=utf-8 ');
$prefixUrl = "http://cs.nuist.edu.cn";
//$type = $_POST["type"];
//dnews,keyan,jiaowu,xuesheng,zhaojiu
//$page = $_POST["page"];
$type = "dnews";
$page = "1";
$url = null;
$dynamicNews = "http://cs.nuist.edu.cn/toColumn.action?cid=11&pageNum=";
$keyanNews = "http://cs.nuist.edu.cn/toColumn.action?cid=12&pageNum=";
$jiaowuNews = "http://cs.nuist.edu.cn/toColumn.action?cid=14&pageNum=";
$xueshengNews = "http://cs.nuist.edu.cn/toColumn.action?cid=13&pageNum=";
$zhaojiuNews = "http://cs.nuist.edu.cn/toColumn.action?cid=15&pageNum=";
if ($type == "dnews") {
	$url = $dynamicNews . $page;
} elseif ($type == "keyan") {
	$url = $keyanNews . $page;
} elseif ($type == "jiaowu") {
	$url = $jiaowuNews . $page;
} elseif ($type == "xuesheng") {
	$url = $xueshengNews . $page;
} elseif ($type == "zhaojiu") {
	$url = $zhaojiuNews . $page;
}
$rs = grab_content($url);

$matchTitle = '/<div class="list_m_tltle">(.*?)<\/div>/is';

$matchref = '/<a.*?(?: \\t\\r\\n)?href=[\'"]?(.+?)[\'"]?(?:(?: \\t\\r\\n)+.*?)?>(.+?)<\/a.*?>/sim';

$matchZhaiYao = '/<div class="list_m_content">(.*?)<\/div>/is';

$locateart = '/<li>(.*?)<\/li>/is';
preg_match_all($locateart, $rs, $contentOut);
$num = count($contentOut[0]);
echo '{"status":';
if ($num > 0) {
	echo '"OK","Array":[';
	for ($x = 34; $x < $num; $x++) {
		echo "{";
		preg_match($matchTitle, $contentOut[0][$x], $title);
		echo '"title":';
		echo '"' . trim(strip_tags($title[0])) . '",';
		preg_match($matchref, $title[0], $hrefout);
		echo '"link":';
		echo '"' . $prefixUrl . substr($hrefout[1], 0, -16) . '"';
//		preg_match($matchZhaiYao, $contentOut[0][$x], $zhaiyao);
//		echo '"zhaiyao":';
//		echo '"' . trim(strip_tags($zhaiyao[0])) . '"';
		echo '}';
		if ($x != $num - 1) {
			echo ",";
		}
	}
	echo "]";
} else {
	echo "failed";
}
echo '}';
?>
