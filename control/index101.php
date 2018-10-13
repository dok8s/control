<?php
require( "../member/include/config.inc.php" );
$langx = $_REQUEST['langx'];
$str = time( );
$langx = $_REQUEST['langx'];
$uid = $_REQUEST['uid'];
if ( $uid == "" )
{
				$uid = substr( md5( $str ), 0, 14 );
}
if ( $langx == "" )
{
				$langx = "zh-cn";
}

?>
<html style="width: 98%;margin: 0 auto;">
<head>
<TITLE></TITLE>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/style/control/index.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--

if (top.location == self.location) {
	top.location="/";
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

//-->
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.STYLE4 {font-family: Arial, Helvetica, sans-serif}
.STYLE5 {color: #3366cc}
.STYLE6 {color: #3366CC}
-->
</style></head>
<!-- CSS -->
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/form-elements.css">
<link rel="stylesheet" href="assets/css/style.css">

<link rel="shortcut icon" href="assets/ico/favicon.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
<body bgcolor="#ffffff">
<div class="top-content">

    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><strong>欢迎登录</strong> Administrator管理系统</h1>
                    <div class="description">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>总后台</h3>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" name="LoginForm" method="post" action="loginx.php" class="login-form">
                            <INPUT TYPE=HIDDEN NAME="langx" VALUE="zh-cn">
                            <div class="form-group">
                                <label class="sr-only" for="form-username">Username</label>
                                <input type="text" name="username" placeholder="请输入用户名" class="form-username form-control" id="form-username">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="password" name="passwd" placeholder="请输入密码" class="form-password form-control" id="form-password">
                            </div>
                            <button type="submit" class="btn" onClick="chk_type();">登录</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.backstretch.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>

