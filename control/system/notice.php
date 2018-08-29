<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");

$date_start	=	$_REQUEST['date_start'];
$uid	=	$_REQUEST['uid'];
$id		=	$_REQUEST['id'];
$show	=	$_REQUEST['show'];
$set	=	$_REQUEST['scroll_set'];

if($set=='set'){
	$kkk=' level=1';
	$kkkk=1;
}else{
	$kkk=' level=4';
	$kkkk=4;
}

if ($show==1){
	$show=0;
}else{
	$show=1;
}

$level	=	$_REQUEST['form_action'];
$level_action	=	$_REQUEST['level_action'];
$scoll_news	=	$_REQUEST['scoll_news'];

if ($level==1){
	
	$msg=$scoll_news;
	$msg_tw=$scoll_news_tw;

	$msg_en=$scoll_news_en;
	$ndate=date('Y-m-d');
	$ntime=date('Y-m-d H:i:s');
	unset($gb);
	unset($big5);
	$mysql="insert into web_marquee (level,message,message_tw,message_en,ntime,ndate) values ('$level_action','$msg','$msg_tw','$msg_en','$ntime','$ndate')";
	mysql_db_query($dbname,$mysql);
	echo "<Script language=javascript>self.location='./notice.php?uid=$uid&scroll_set=$set';</script>";
}
$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);

$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$sql = "select * from web_system limit 0,1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$tt=$row['msg_member'];
$tt_tw=$row['msg_member_tw'];
$tt_en=$row['msg_member_en'];
if ($date_start=='') {
	$date_start=date('Y-m-d');
}
$action=$_REQUEST['action'];
if ($action==1){
	$sql="update web_marquee set mshow='$show' where id='$id'";
	mysql_db_query($dbname,$sql);
	echo "<Script language=javascript>self.location='./notice.php?uid=$uid&scroll_set=$set';</script>";
}
else if ($action==2){
	$sql="delete from web_marquee where id='$id'";
	mysql_db_query($dbname,$sql);
	echo "<Script language=javascript>self.location='./notice.php?uid=$uid&scroll_set=$set';</script>";
}
else if ($action==3 && is_array($_POST['delid'])){
	$ids = join("','",$_POST['delid']);
	$sql="delete from web_marquee where id in('$ids')";
	mysql_db_query($dbname,$sql);
	echo "<Script language=javascript>self.location='./notice.php?uid=$uid&scroll_set=$set';</script>";
}
else if ($action==4){
	$deldate = date('Y-m-d', time()-3600*24*7);
	$sql="delete from web_marquee where ndate<'$deldate'";
	mysql_db_query($dbname,$sql);
	echo "<Script language=javascript>self.location='./notice.php?uid=$uid&scroll_set=$set';</script>";
}
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
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
function checkSel(){
	var aa = document.getElementsByName("delid[]");
	for (var i=0; i<aa.length; i++)
	{
	   aa[i].checked = frmlist.chk.checked;
	}
}
function delete7(){
	if(confirm('您确定要删除七天前的所有记录吗？')){
		self.location="notice.php?uid=<?=$uid?>&scroll_set=<?=$set?>&action=4";
	}
}
</script>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="m_tline" width="750">&nbsp;&nbsp;&quot;简体&quot;<font color='#FF0000'>即时公告（必须输入简体公告，自动翻译为繁体）</font></td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="2" height="4"></td>
  </tr>
</table>
<?

$sql = "select level,id,date_format(ntime,'%y-%m-%d <br> %H:%i:%s') as ntime,message,mshow from web_marquee where $kkk order by id desc limit 0,1";

$result = mysql_db_query($dbname, $sql);
$row = mysql_fetch_array($result);

?>
<form method="post" name='SCROLL_FROM' >
  <table width="750" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed" >
    <tr>
    <td width="160" align="right">目前&quot;简体&quot;即时公告内容:</td>
    <td colspan="3"><marquee scrollDelay=200><?=$row['message']?></marquee></td>
  </tr>
  <tr >
    <td width="160" align="right">更新简体即时公告内容:<br>
    </td>
    <td colspan="3">
      <input type="text" name="scoll_news" size="100" class="za_text" value="<?=$tt?>">
    </td>
 </tr>
  <tr >
    <td width="160" align="right">更新繁体体即时公告内容:<br>
    </td>
    <td colspan="3">
      <input type="text" name="scoll_news_tw" size="100" class="za_text" value="<?=$tt_tw?>">
    </td>
 </tr>
 <tr >
    <td width="160" align="right">更新英文体即时公告内容:<br>
    </td>
    <td colspan="3">
      <input type="text" name="scoll_news_en" size="100" class="za_text" value="<?=$tt_en?>">
    </td>
 </tr>
  <tr align="center" >
    <td colspan="4" bgcolor="6EC13E">
        <input type="submit" value="确定输入"  name="Submit" class="za_button" onclick='return news_chk();'>
	<input type="reset" value="取消重填"  name="Reset" class="za_button">
 <input type="hidden" name="form_action" value="Y">
 <input type="hidden" name="level_action" value="<?=$kkkk?>">
      </td>
  </tr>
</table>
  <iframe border=0 name=lantk src="http://www.hao123.com/haoserver/jianfanzh.htm" width=800 height=400 allowTransparency scrollbars=yes frameBorder="0"></iframe>
</form>
<BR>
<form method="post" name='frmlist' >
<INPUT TYPE="hidden" NAME="action" value="3">
<table width="750" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
	<tr class="m_bc_ed"><td colspan="4" align="center"><b>历史讯息</b> (<a href="javascript:delete7()">删除七天前的</a>)</td></tr>
	<tr class="m_title_edit"><td width="10" >编号</td><td width="55">时间</td><td>公告内容</td>
	<td width="70"> &nbsp; &nbsp;<input type="submit" name="Submit2" value="删除" onClick="javascript:return confirm('您确定要删除选定记录吗？');"><input name="chk" type="checkbox" value="yes" onClick="checkSel();"></td></tr>
  <?

$sql = "select level,id,date_format(ntime,'%y-%m-%d <br> %H:%i:%s') as ntime,message,mshow from web_marquee where $kkk order by ntime desc limit 25";

$result = mysql_db_query($dbname, $sql);
while ($row = mysql_fetch_array($result))
{
if ($row['mshow']==0){
	$soption='<a href="notice.php?uid='.$uid.'&id='.$row[id].'&show=0&action=1&level='.$row[level].'">显示</a>';
}else{
	$soption='<a href="notice.php?uid='.$uid.'&id='.$row[id].'&show=1&action=1&level='.$row[level].'"><font color=red>关闭</font></a>';
}
?>
  <tr bgcolor="#FFFFFF" onMouseOver="colorTRx(0)" onMouseOut="colorTRx(1)" style="display: {SHOW_TR}">

    <td align="center"><?=$row['id']?></td>
	<td align="center"><?=$row['ntime']?></td>
    <td align="left"><?=$row['message']?></td>
    <td align="center"><INPUT TYPE="checkbox" NAME="delid[]" value="<?=$row['id']?>"></td>
    <?
}
?>
  </tr>

</table>
</form>
</body>
</html>