<html>
	<meta charset="utf-8" />
	<?php
	include 'libs.php';
	//图书馆系统
	$postdata = array('strSearchType' => 'title', 'match_flag' => 'forward', 'historyCount' => '1', 'displaypg' => '20', 'showmode' => 'list', 'sort' => 'CATA_DATE', 'orderby' => 'desc', 'dept' => 'ALL', 'strText' => 'iPhone');
	$url = "http://lib2.nuist.edu.cn/opac/openlink.php";
	$rs = grab_post($url, $postdata);
	$urlPrefix = 'http://lib2.nuist.edu.cn/opac/';
	$pagePrefix = 'http://lib2.nuist.edu.cn/opac/openlink.php';

	$match_book_list = '/<ol id="search_book_list">(.*?)<\/ol>/is';
	preg_match_all($match_book_list, $rs, $contentOut);
	$book_list = $contentOut[0][0];
	$match_book_info = '/<li class="book_list_info">(.*?)<\/li>/is';
	preg_match_all($match_book_info, $book_list, $bookOut);

	$bookNum_thispg = count($bookOut[0]);

	$match_page_indicator = '/<div class="book_article numstyle">(.*?)<\/div>/is';
	$matchNextPageHref = '/<a.*?(?: \\t\\r\\n)?href=[\'"]?(.+?)[\'"]?(?:(?: \\t\\r\\n)+.*?)?>下一页<\/a.*?>/sim';
	$matchPrePageHref = '/<a.*?(?: \\t\\r\\n)?href=[\'"]?(.+?)[\'"]?(?:(?: \\t\\r\\n)+.*?)?>上一页<\/a.*?>/sim';
	preg_match_all($match_page_indicator, $rs, $pageIndicator);
	preg_match_all($matchNextPageHref, $pageIndicator[0][0], $nextHref);
	preg_match_all($matchPrePageHref, $pageIndicator[0][0], $preHref);
	//	echo count($preHref[0]);
	if (count($nextHref[0]) > 0) {
				echo $nextHref[0][0];
				$nextHrefString = strstr($nextHref[0][0], '>',true);
				$nextHrefString = strstr($nextHrefString, '< html',true);
				echo $nextHrefString;
//		echo $nextHref[0][0];
	} else {
		echo '""';
	}

	//中文图书，馆藏
	$match_book_info = '/<span>(.*?)<\/span>/is';
	preg_match_all($match_book_info, $bookOut[0][0], $bookInfo);
	//	echo count($bookInfo[0]);
	//获得图书名称和链接
	$matchref = '/<a.*?(?: \\t\\r\\n)?href=[\'"]?(.+?)[\'"]?(?:(?: \\t\\r\\n)+.*?)?>(.+?)<\/a.*?>/sim';
	preg_match_all($matchref, $bookOut[0][0], $bookTitle);
	//标题
	$title = substr(strstr(strip_tags($bookTitle[0][0]), '.'), 1);
	//链接
	$hrefstring = strstr(strstr($bookTitle[0][0], '>', true), 'href="');
	$hrefstring = trim($hrefstring);
	$hrefstring = substr($hrefstring, 6, -1);
	$hrefstring = $urlPrefix . $hrefstring;
	?>
</html>