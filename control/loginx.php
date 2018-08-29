<?
Session_start();
require ("../member/include/config.inc.php");
$username=$_REQUEST["username"];
$password=$_REQUEST["passwd"];

$sql = "select id,agname from web_sytnet where agname ='$username' and passwd='$password' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$id		=	$row['id'];
$count=mysql_num_rows($result);
if ($count==0){
	echo "<script>alert('LOGIN ERROR!!\\nPlease check username/passwd and try again!!');window.open('index.php','_top')</script>";
	exit;
}

$uid=md5(time().rand(0,99999).$row['agname']);
$sql="update web_sytnet set uid='$uid' where id='$id'";
mysql_query($sql);

$pu=rand(1345515,8345915);
$_SESSION["ckck"]=$pu;

$loginfo='登入成功';
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$username',now(),'$loginfo','$ip_addr','-2')";
mysql_query($mysql);
?>
<html>
<head>
<title>login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<frameset rows="50,*" frameborder="NO" border="0" framespacing="0">
<frame name="topFrame" scrolling="NO" noresize src="/control/header.php?langx=<?=$langx?>&uid=<?=$uid?>">
<frame name="main" src="/control/body_home.php?langx=zh-cn&uid=<?=$uid?>">
</frameset>
<noframes>
<body bgcolor="#FFFFFF" text="#000000">
</body>
</noframes>
</html>