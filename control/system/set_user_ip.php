<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");

$uid=$_REQUEST["uid"];
$cou=mysql_num_rows(mysql_query("select id from web_sytnet where uid='$uid'"));
if ($cou==0){
	echo "<script language=javascript>top.location='/';</script>";
	exit;
}

if($_GET['set']=='Y'){
	$isupok = 0;
	$memname = $_POST['memname'];
	$ip = long2ip(ip2long($_POST['ip']));
	if($memname!='' && $ip!='0.0.0.0'){
		$sql="update web_member set setip='$ip' where memname='$memname'"; 
		mysql_query($sql);
		$isupok=mysql_affected_rows();
	}
	
	$upmsg = $isupok==0 ? '保存失败，请重新输入！' : '保存成功';
	echo "<script>alert('$upmsg');</script>";
}

if($_GET['del']=='Y'){
	$memname = $_GET['memname'];
		$sql="update web_member set setip='' where memname='$memname'"; 
		mysql_query($sql);
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
.m_title { background-color: #86C0A6; text-align: center}
.m_left {margin-left: 20px;}
</style>
</head>
<body  bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">

<table width="780" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="m_tline" width="750" >会员绑IP</td>
		<td><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
	</tr>
	<tr>
		<td colspan="2" height="4"></td>
	</tr>
</table>

<table width="" border="0" cellspacing="1" cellpadding="0" bgcolor="#4B8E6F" class="m_tab m_left">
	<tr class="m_title">
		<td width="150">会员</td>
		<td width="200">IP</td>
		<td width="100">操作</td>
	</tr>
	<tr class="m_cen">
		<form name="form1" action="?set=Y&uid=<?=$uid?>" method="POST">
		<td><input type="text" name="memname"></td>
		<td><input type="text" name="ip"></td>
		<td><input type="submit" value=' 保存 '></td>
		</form>
	</tr>
	<?
		$sql = "SELECT memname,setip FROM web_member WHERE setip!=''";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result)){
			echo "<tr class='m_cen'><td>$row[memname]</td><td>$row[setip]</td><td><a href='?del=Y&memname=$row[memname]&uid=$uid'>删除</a></td></tr>";
		}
	?>
</table>
</body>
</html>