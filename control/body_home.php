<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../member/include/config.inc.php");

$uid			=$_REQUEST['uid'];
$active		=$_REQUEST['active'];
$filename	=$_REQUEST['filename'];
$langx		='zh-cn';



$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

require ("../member/include/traditional.$langx.inc.php");

$sql = "select agname from web_sytnet where Oid='$uid'";
$result = mysql_query($sql);
//$row = mysql_fetch_array($result);
$agname=$row['agname'];

$sql = "select agname from web_sytnet where subuser=1 and subname='$agname'";
$result = mysql_query($sql);


$sql = "select * from web_system";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$messages=$row['msg_member'];

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/calendar.css" type="text/css">
<link rel="stylesheet" href="/style/control/control_main1.css" type="text/css">
<style type="text/css">
<!--
.m_title_re {  background-color: #577176; text-align: right; color: #FFFFFF}
.m_bc { background-color: #C9DBDF; padding-left: 7px }

.m_title_ce {background-color: #669999; text-align: center; color: #FFFFFF}

div.bac {
	margin:10;
	width:740px;
	color: #000;
	padding:5px;
	border:1px solid #C00;
	line-height:1.3em;
	font-size:1em;
}
p.title { margin:0; padding:2px; background-color:#900; color:#FFF; text-align:center;}
b { color:#C30;}
-->
</style>
<script>
var current = null
function colorTRx(flag){
	if(flag==1 && current!=null){
		current.style.backgroundColor = current._background;
		current.style.color = current._font;
		current = null
		return;
	}
	if ((self.event.srcElement.parentElement.rowIndex!=0) && (self.event.srcElement.parentElement.tagName=="TR") && (current!=self.event.srcElement.parentElement)) {
		if (current!=null){
			current.style.backgroundColor = current._background
			current.style.color = current._font
		}
		self.event.srcElement.parentElement._background = self.event.srcElement.parentElement.style.backgroundColor
		self.event.srcElement.parentElement._font = self.event.srcElement.parentElement.style.color
		self.event.srcElement.parentElement.style.backgroundColor = "#FFCC66"
		self.event.srcElement.parentElement.style.color = "red"
		current = self.event.srcElement.parentElement
	}
}

function scroll_chk(){
	SCROLL_FROM.form_action.value='Y';
	if(SCROLL_FROM.scoll_text.value=='') return false;
}
function news_chk(){
	SCROLL_FROM.form_action.value='1';
	if(SCROLL_FROM.scoll_news.value=='') return false;
}
function Delete_sure(filename1)
{
 a=confirm("确定删除此笔资料");
 if (a==true)
 {
 	self.location='body_home.php?uid=<?=$uid?>&active=2&filename='+filename1;
   return true;
 }else{
   return false;
 }
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<table width="750" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed" >
  <form name="LoginForm" method="post" action="login.php">
  	<INPUT TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
  </form>
  <tr>
    <td width="100" align="right">系统公告</td>
    <td width="520"><marquee scrollDelay=200><?=$messages?></marquee></td>
    <td align="center"> <A HREF="javascript://" onClick="javascript: window.showModalDialog('scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>','','help:no')">
      历史讯息</a> </td>
  </tr>
  <tr align="center" >
    <td colspan="3" bgcolor="6EC13E">&nbsp; </td>
  </tr>
</table>
<div id="user_msg" class="user_msg">
	<span>帐号新增及密码更改提示</span>
	<div id="table_master">
		<table cellpadding="0" cellspacing="0" id="table_header">
		  <tbody>
			<tr class="msg_td">
				<td>时间</td>
				<td>操作者</td>
				<td>项目</td>
				<td>帐号</td>
				<td>阶层</td>
			</tr>
			<?
$sql="select  * from agents_log  order by M_DateTime desc";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)){
?>
			<tr>
				<td><?=$row["M_DateTime"]?></td>
				<td><?=$row["M_czz"]?></td>
				<td><?=$row["M_xm"]?></td>
				<td><?=$row["M_user"]?></td>
				<td><?=$row["M_jc"]?></td>
			</tr>
<?
}
?>
			</tbody>
		</table>
  </div>
	
</div>
<br>
 
</body>
</html>