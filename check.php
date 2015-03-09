<?php
session_start();

require 'aes.php';

$g = $_REQUEST;

$url = isset($g['url']) ? $g['url'] : '';
$password = isset($g['password']) ? $g['password'] : '';
$code = isset($g['code']) ? $g['code'] : '';
$content = isset($g['content']) ? $g['content'] : '';

if(empty($url) || empty($password) || empty($code)){
	$s = array('status'=>1, 'msg'=>"输入框不能为空");
}else{
	$aes = new Security();

	$key = md5($password.'wenzi'.$code);
	$result = $aes->decrypt($content, $key);

	if(strpos($result, $url)>-1){
		$msg = substr($result, strlen($url));
		$s = array('status'=>0, 'msg'=>$msg);
	}else{
		$s = array('status'=>2, 'msg'=>"验证错误");
	}
}

$_SESSION['s'] = $s;
header('Location:./index.1.php');
