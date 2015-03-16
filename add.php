<?php
require 'aes.php';

$g = $_REQUEST;

$url = isset($g['url']) ? $g['url'] : '';
$password = isset($g['password']) ? $g['password'] : '';
$content = isset($g['content']) ? $g['content'] : '';

if(empty($url) || empty($password) || empty($content)){
	$s = array('status'=>1, 'msg'=>"输入框不能为空");
}else{
	$aes = new Security();
	$code = substr(md5(time()."wenzi".rand(1000, 9999)), 4, 10);
	$key = md5($password.'wenzi'.$code);
	$res = $aes->encrypt($url.$content, $key);

	$e1=""; $e2="";
	for($i=0; $i<strlen($code); $i++) {
		if($i%2==0){
			$e1 .= $code[$i];
		}else{
			$e2 .= $code[$i];
		}
	}
	// $e = $e1.$e2;
	$e = $code;

	$s = array('status'=>0, 'msg'=>$url.'&nbsp;&nbsp;'.$e.'&nbsp;&nbsp;'.$res);
}
echo json_encode($s);
