<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("./chat.inc.php");

$uid=$_REQUEST["uid"];
$sql = "select id,level,agname from `web_sytnet` where uid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array( $result );
$cou=mysql_num_rows($result);
if($cou==0 || $row['level']!=1){
  //echo "<script>window.open('/','_top')<script>";
  exit;
}

$id = intval($_REQUEST['id']);
$page = intval($_REQUEST['page']);
$action = $_REQUEST['action'];
$username = $_REQUEST['username'];

if($action=='send'){
	$from_name='sys';
	$to_name = $username;
	$subject = ''; 
	$message = str_replace(array('<','>'),array('&lt;','&gt;'),$_REQUEST['message']);
	$rt=chat_send($from_name,$to_name,$subject,$message);
	if($rt!=''){
		$rt==-1 && $rt="用户($to_name)不存在";
		echo "<script>alert('$rt');</script>";
	}else{
		echo "<script>self.location='?uid=$uid';</script>";
		exit;
	}

}elseif($action=='del'){
	chat_del($id);
	echo "<script>self.location='?uid=$uid';</script>";
	exit;
}

	$pagesize=100;
	$rt=chat_list($pagesize,$page);
	$rows = $rt['rows'];


?>
<html>
<head>
<title>会话</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
td {word-break : break-all}
.tablestyle tr{
				onmouseover:expression(
					onmouseover=function(){
						this.style.backgroundColor='#FFCC66'
					}
				);
				onmouseout:expression(
					onmouseout=function(){
						this.style.backgroundColor=''
					}
				);
}
</style>

<script>

function send_chk(){
	if(SCROLL_FROM.username.value==''){
		SCROLL_FROM.username.focus();
		alert('会员不要为空');
		return false;
	}
	if(SCROLL_FROM.message.value==''){
		SCROLL_FROM.message.focus();
		alert('内容不要为空');
		return false;
	}
}
function setUserName(username){
	SCROLL_FROM.username.value=username;
}
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >

<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="m_tline" width="750">&nbsp;&nbsp;会话</td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="2" height="4"></td>
  </tr>
</table>

<a name="re">
<form method="post" name='SCROLL_FROM' >
	<INPUT TYPE="hidden" NAME="action" value="send">
  <table width="750" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed" >
    <tr >
      <td width="160" align="right">会员:</td>
      <td colspan="3"> <INPUT TYPE="text" NAME="username" value="<?=$username?>"></td>
	</tr>
    <tr >
      <td width="160" align="right">内容:<br> </td>
      <td colspan="3"> <textarea name="message" cols="85" rows="3" wrap="PHYSICAL"><?=$message?></textarea></td>
	</tr>
    <tr align="center" >
      <td colspan="4" bgcolor="6EC13E"> <input type="submit" value=" 发送 "  name="Submit" class="za_button" onclick='return send_chk();'>
      </td>
    </tr>
  </table>
</form>

<BR>
<table width="750" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000" class="tablestyle">
	<tr class="m_bc_ed"><td colspan="4" align="center"><b>会话信息</b></td></tr>
	<tr class="m_title_edit"><td>内容</td><td width="50">状态</td><td width="100">操作</td></tr>
<?php
	foreach($rows as $row){
		$row['from_name']=='sys' && $row['from_name']='管理员';
		$row['to_name']=='sys'   && $row['to_name']='管理员';
		$st = $row['state']>0 ? "已读" : "<font color='#FF00FF'>未读</font>";
		$st = ($row['to_name']=='0' || $row['to_name']=='管理员') ? '' : $st;
		$rehtml = $row['from_name']=='管理员' ? '回复' : "<a onClick='setUserName(\"$row[from_name]\")' href='#re'>回复</a>";
		echo "<tr class='m_bc_ed'><td> $row[time] &nbsp; <font color='#FF0000'> $row[from_name] </font>对 <font color='#0000CC'>$row[to_name] </font>说：<font color='#006600'>$row[message] </font> </td><td align=center>$st</td><td width=100 align=center>$rehtml&nbsp; |&nbsp; <a href='?uid=$uid&id=$row[id]&action=del'>删除</a></td></tr>";
	}

?>
</table>
</body>
</html>
