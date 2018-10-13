<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
$date_start=$_REQUEST['date_start'];
$agents_id=$_REQUEST['agents_id'];
$uid=$_REQUEST['uid'];
$user=$_REQUEST['user'];
$level=$_REQUEST['level'];
if($level==''){
	$level=3;
}

$active=$_REQUEST['active'];
$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}else{


if ($date_start=='') {
	$date_start=date('m-d');
}

if ($active==1){
	$sql = "update web_agents set oid='',logintime='2008-01-01 12:00:00' where agname='$user'";
	mysql_db_query($dbname,$sql);

	$sql = "update web_world set oid='',logintime='2008-01-01 12:00:00' where agname='$user'";
	mysql_db_query($dbname,$sql);

	$sql = "update web_corprator set oid='',logintime='2008-01-01 12:00:00' where agname='$user'";
	mysql_db_query($dbname,$sql);

	$sql = "delete from web_mem_log where username='$user'";
	mysql_db_query($dbname,$sql);
	echo "<script language='javascript'>self.location='syslog.php?uid=$uid&level=$level';</script>";

}
?>
<html style="width: 98%;margin: 0 auto;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<script>
 function onLoad()
 {
  var level = document.getElementById('level');
  level.value = '<?=$level?>';
 }

function Changlevl(){
  	var level = document.getElementById('level').value;
	self.location="syslog.php?uid=<?=$uid?>&level="+level;
}
function reload()
{
	var level = document.getElementById('level').value;
	self.location.href="syslog.php?uid=<?=$uid?>&level="+level;
}
var limit="60"
if (document.images){
	var parselimit=limit
}
function beginrefresh(){
if (!document.images)
	return
if (parselimit==1)
	//var obj_agent = document.getElementById('agents_id');
	//alert(obj_agent.value);
	window.location.reload();
else{
	parselimit-=1
	curmin=Math.floor(parselimit)
	if (curmin!=0)
		curtime=curmin+"秒后自动更新！"
	else
		curtime=cursec+"秒后自动更新！"
		timeinfo.innerText=curtime
		setTimeout("beginrefresh()",1000)
	}
}

window.onload=beginrefresh
</script>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
</head><!--oncontextmenu="window.event.returnValue=false"-->
<body  bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" onLoad="onLoad();beginrefresh()">
<form name="myFORM" method="post" action="" >
 <table width="773" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="746">&nbsp;线上数据－<font color="#CC0000">日志</font>&nbsp;&nbsp;&nbsp; <input name=button type=button class="za_button" onClick="reload()" value="更新">&nbsp;&nbsp;&nbsp;
	 <select name="level" onChange="document.myFORM.submit();" class="za_select">
            <option value="3">代理商</option>
            <option value="2">总代理</option>
            <option value="1">股东</option>
            <option value="0">大股东</option>
          </select>
        <span id="timeinfo"></span>-- 管理模式:WEB页面 -- <a href="javascript:history.go( -1 );">回上一頁</a></td>
      <td width="34"><img src="/images/control/top_04.gif" width="30" height="24"></td>
    </tr>
  </table>
  <table width="774" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="774" height="4"></td>
    </tr>
    <tr>
      <td ></td>
    </tr>
  </table>

<table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab" width="100%">
  <tr class="m_title_ft">
    <td width="83" align="middle"> 代理商名称</td>
    <td align="middle" width="161">活动时间</td>
    <td align="right" width="300">活动内容</td>
    <td align="middle" width="82">登陆IP</td>
    <td align="middle" width="82">操作</td>
  </tr>
  <?
  require ("ip.php");
$sql = "select username,max(logtime) as logtime,system,logip,context,level from web_mem_log where level=$level group by username order by logtime desc";

$result = mysql_db_query($dbname, $sql);
$count=mysql_num_rows($result);
if ($count<>0){
while ($row = mysql_fetch_array($result))
{
	$iipp=$row['logip'];
	$ccc=convertip_full($iipp, 'QQWry.Dat');
    $ccc=iconv('GBK','UTF-8',$ccc);
?>
  <tr class="m_cen">
    <td width="83"><?=$row["username"]?></td>
    <td> <font color="#CC0000"><?=$row["logtime"]?></font> </td>
    <td><?=$row["context"]?></td>
    <td><?=$row["logip"]?>/<?=$ccc?></td>
    <td width="120" align="center"><a href="showlog.php?uid=<?=$uid?>&agents_id=<?=$row["username"]?>&level=<?=$level?>">查看</a>
        / <a href="./syslog.php?uid=<?=$uid?>&active=1&user=<?=$row["username"]?>&level=<?=$row["level"]?>">踢线</a></td>
  </tr>
  <?
}
}
?>
</table>
</form>
</form></body>
</html>
<?
}
?>
