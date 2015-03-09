<?php
session_start();
$s = isset($_SESSION['s']) ? $_SESSION['s'] : '';
unset($_SESSION['s']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>密码表</title>
	<link rel="stylesheet" href="./bootstrap-3.3.2-dist/css/bootstrap.min.css">
	<style type="text/css">
		.content{width: 760px; margin: 100px auto;}
		.tab-content{border-bottom: 1px solid #ddd;border-left: 1px solid #ddd;border-right: 1px solid #ddd;padding: 10px;border-radius: 0 0 4px 4px;}
		.alert{display: none;}
	</style>
</head>
<body>
	<div class="content">
		<ul id="myTab" class="nav nav-tabs">
		   <li class="active"><a href="#find" data-toggle="tab">查询</a></li>
		   <li><a href="#add" data-toggle="tab">添加</a></li>
		</ul>
		<div id="myTabContent" class="tab-content">
		   <div class="tab-pane fade in active" id="find">
		   		<form class="form-horizontal" action="./check.php" method="post" id="find-form" onSubmit="return check()">
			        <div class="form-group">
					    <label for="url" class="col-sm-3 control-label">网址</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="url" name="url" placeholder="url" autocomplete="off" autofocus="true">
					    </div>
					</div>
					<div class="form-group">
					    <label for="password" class="col-sm-3 control-label">密码</label>
					    <div class="col-sm-8">
					      <input type="password" class="form-control" id="password" name="password" placeholder="password">
					    </div>
					</div>
					<div class="form-group">
					    <label for="cap" class="col-sm-3 control-label">验证码</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="code" name="code" placeholder="code" autocomplete="off">
					    </div>
					    <!-- <button type="submit" class="col-sm-1 btn btn-primary" id="receive">接收</button>-->
					</div>
					<div class="form-group">
					    <label for="content" class="col-sm-3 control-label">内容</label>
					    <div class="col-sm-8">
					      <textarea name="content" id="content" class="form-control" rows="4"></textarea>
					    </div>
					</div>
					<div class="form-group text-right">
						<div class="col-sm-offset-3 col-sm-8 text-right">
							<input type="reset" class="btn btn-default"  value="重置" />
							<input type="submit" class="btn btn-primary" value="确定" />
						</div>
					</div>
				</form>
				<div class="alert col-sm-offset-2 <?php if(!empty($s)){ if($s['status']==0){ ?> alert-success <?php }else{ ?> alert-warning <?php }}  ?>" <?php if(!empty($s)){ ?> style="display:block;" <?php } ?> role="alert" id="alert"><?php if(!empty($s)){ echo $s['msg']; } ?></div>
		   </div>
		   <div class="tab-pane fade" id="add">
		      <form class="form-horizontal" id="add-form" onSubmit="acheck(); return false;">
			        <div class="form-group">
					    <label for="url" class="col-sm-3 control-label">网址</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="aurl" name="url" placeholder="url" autocomplete="off" autofocus="true">
					    </div>
					</div>
					<div class="form-group">
					    <label for="password" class="col-sm-3 control-label">内容</label>
					    <div class="col-sm-8">
					      <input type="password" class="form-control" id="acontent"  placeholder="content">
					    </div>
					</div>
					<div class="form-group">
					    <label for="password" class="col-sm-3 control-label">确认内容</label>
					    <div class="col-sm-8">
					      <input type="password" class="form-control" id="arecontent"  placeholder="content">
					    </div>
					</div>
					<div class="form-group">
					    <label for="password" class="col-sm-3 control-label">密码</label>
					    <div class="col-sm-8">
					      <input type="password" class="form-control" id="apassword" name="password" placeholder="password">
					    </div>
					</div>
					<div class="form-group">
					    <label for="password" class="col-sm-3 control-label">确认密码</label>
					    <div class="col-sm-8">
					      <input type="password" class="form-control" id="arepassword" name="password" placeholder="password">
					    </div>
					</div>
					<div class="form-group text-right">
						<div class="col-sm-offset-3 col-sm-8 text-right">
							<input type="reset" class="btn btn-default"  value="重置" />
							<input type="submit" class="btn btn-primary" id="addsubmit" value="确定" />
						</div>
					</div>
				</form>
				<div class="alert col-sm-offset-2" role="alert" id="aalert"></div>
		   </div>
		</div>
	</div>
	
</body>
<script type="text/javascript" src="./js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="./bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
function acheck(){
	var aurl = $("#aurl").val(),
		acontent = $("#acontent").val(),
		arecontent = $("#arecontent").val(),
		apassword = $("#apassword").val(),
		arepassword = $("#arepassword").val();

	Tips.elem = $("#aalert");
	if(aurl==="" || acontent==="" || arecontent==="" || apassword==="" || arepassword===""){
		Tips.warning("输入框不能为空");
		return false;
	}else if(acontent!=arecontent){
		$("#arecontent").val("");
		Tips.warning("内容不一致");
		return false;
	}else if(apassword!=arepassword){
		$("#arepassword").val("");
		Tips.warning("密码不一致");
		return false;
	}

	$("#addsubmit").attr("disabled", "disabled");
	$.ajax({
		url : './add.php',
		data : {'url':aurl, 'content':acontent, 'password':apassword},
		dataType : 'json',
		type : 'get',
		success : function(result){
			$("#addsubmit").removeAttr("disabled");
			$('#add-form')[0].reset();
			if(result.status==0){
				Tips.success(result.msg);
			}else{
				Tips.warning(result.msg);
			}
		}
	})
}

function check(){
	var url = $("#url").val(),
		password = $("#password").val(),
		code = $("#code").val(),
		content = $("#content").val();

	Tips.elem = $("#alert");
	if(url==="" || password==="" || code==="" || content===""){
		Tips.warning("输入框不能为空");
		return false;
	}
	return true;
}
var Tips = {
	elem : null,
	success : function(msg){
		var $password = $("#password"),
			$parent = $password.parent();
		$parent.removeClass('has-error');
		this.elem.removeClass('alert-warning').addClass( 'alert-success' ).html(msg).show();
	},
	warning : function(msg){
		this.elem.removeClass('alert-success').addClass( 'alert-warning' ).html(msg).show();
	},
	hide : function(){
		this.clear();
		this.elem.hide();
	},
	clear : function(){
		var $password = $("#password"),
			$parent = $password.parent();
		$parent.removeClass('has-error');
		this.elem.removeClass('alert-success alert-warning');
	}
}
</script>
</html>