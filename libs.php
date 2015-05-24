<?php
function login_post($url, $cookie, $post) {
	$curl = curl_init();
	//初始化curl模块
	curl_setopt($curl, CURLOPT_URL, $url);
	//登录提交的地址
	curl_setopt($curl, CURLOPT_HEADER, 0);
	//是否显示头信息
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	//是否自动显示返回的信息
	curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
	//设置Cookie信息保存在指定的文件中
	curl_setopt($curl, CURLOPT_POST, 1);
	//post方式提交
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
	//要提交的信息
	curl_exec($curl);
	//执行cURL
	curl_close($curl);
	//关闭cURL资源，并且释放系统资源
}

function get_content($url, $cookie) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
	//读取cookie
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
	//更新cookie
	$rs = curl_exec($ch);
	//执行cURL抓取页面内容
	curl_close($ch);
	return $rs;
}

function post_with_cookie($url1, $cookie1, $post1) {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url1);
	//登录提交的地址
	curl_setopt($curl, CURLOPT_HEADER, 0);
	//是否显示头信息
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);
	//自动显示返回的信息,不要轻易修改
	curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie1);
	//读取cookie
	curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie1);
	//更新cookie
	curl_setopt($curl, CURLOPT_POST, 1);
	//post方式提交
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post1));
	//要提交的信息
	curl_exec($curl);
	//执行cURL
	curl_close($curl);
	//关闭cURL资源，并且释放系统资源
}

function get_iP($StuNum, $Password) {
	$data = array('phone' => '', 'clientMark' => 'MI 2sc', 'cardimsi' => '460036361308923', 'signType' => 'SynSno', 'account' => $StuNum, 'simCode' => 'null', 'password' => $Password, 'clientType' => 'Anroid');
	$url = "http://ucard.nuist.edu.cn:8070/Api/Account/SignInAndGetUser";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	//登录提交的地址
	curl_setopt($curl, CURLOPT_HEADER, 0);
	//是否显示头信息
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	//post方式提交
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	//要提交的信息
	$rs = curl_exec($curl);
	//执行cURL
	curl_close($curl);
	//	echo $rs;
	$obj = json_decode($rs);
	return $obj -> msg;
}

function grab_content($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$rs = curl_exec($ch);
	//执行cURL抓取页面内容
	curl_close($ch);
	return $rs;
}
?>