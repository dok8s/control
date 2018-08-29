<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
echo "<script>if(self == top) location='/'</script>\r\n";
require( "../../member/include/config.inc.php" );
$date_start = $_REQUEST['date_start'];
$agents_id = $_REQUEST['agents_id'];
$uid = $_REQUEST['uid'];
$user = $_REQUEST['user'];
$active = $_REQUEST['active'];
$so_log_name=trim($_REQUEST['so_log_name']);
$sql = "select id,level,agname from web_sytnet where uid='".$uid."' and status=1";
$result = mysql_query( $sql );
$row = mysql_fetch_array( $result );
$level = $row['level'];
$cou = mysql_num_rows( $result );
if ( $cou == 0 ){
	echo "<script>window.open('".$site."/index.php','_top')</script>";
	exit( );
}


$sql = "select setdata from web_system limit 0,1";
$result = mysql_query( $sql );
$rt = mysql_fetch_array( $result );
$setdata = @unserialize($rt['setdata']);
$update_sec = intval($setdata['memlog_update_sec']);
if($update_sec<3) $update_sec=120;

if(isset($_GET['update_sec'])){
	$memlog_update_sec = intval($_GET['update_sec']);
	if($memlog_update_sec>=3){
		$setdata['memlog_update_sec']=$memlog_update_sec;
		$mysql = "update web_system set setdata='".serialize($setdata)."'";
		mysql_query( $mysql );
	}
	echo "<script language='javascript'>self.location='memlog.php?uid=".$uid."';</script>";
}

$admin_name=$row['agname'];
$pqow = $result_type=='Y' ? '有结果' : '无结果';
$loginfo="查询会员在线";
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$admin_name',now(),'$loginfo','$ip_addr','-2')";
mysql_query($mysql);

if ( $date_start == "" )
{
	$date_start = date( "m-d" );
}
if ( $active == 1 )
{
	$sql = "update web_member set oid='',active='2008-01-01 12:00:00',logdate='2008-01-01 12:00:00' where memname='".$user."'";
	mysql_query( $sql );
	echo "<script language='javascript'>self.location='memlog.php?uid=".$uid."';</script>";
}
?>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<script>
<!--
var limit="<?=$update_sec?>";
var parselimit=limit;

function $(name){
	return document.getElementById(name);
}

function beginrefresh(){
	if (!document.images) return
	if (parselimit<=1){
		window.location.reload();
	}else{
		parselimit-=1
		curmin=Math.floor(parselimit)
		if (curmin!=0){
			curtime="("+curmin+")更新";
		}else{
			curtime="("+cursec+")更新";
		}
		$('F5').value=curtime;
		setTimeout("beginrefresh()",1000)
	}
}

function reload(){
	window.location.reload();
}

function report_bg(){
	$('mem_num').innerText=cou;
}

function so_log()
{
	var so_log_name = $('so_log_name').value;
	if(so_log_name!=''){
		self.location.href='memlog.php?uid=<?=$uid?>&so_log_name='+so_log_name;
	}
	
}

function update_sec_save(){
	self.location.href='memlog.php?uid=<?=$uid?>&update_sec='+$('update_sec').value;
}

window.onload=beginrefresh

</script> 
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type='text/css'>
form { margin:0; padding:0;}
input,select {vertical-align:middle;}
.m_cen2 {  background-color: #FFEBB5; text-align: center}
</style>
</head>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<div style="display:none">
<script src="https://s95.cnzz.com/z_stat.php?id=1260314708&web_id=1260314708" language="JavaScript"></script></div>
 <table width="1000" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline">&nbsp;会员在线－<font color="#CC0000">日志</font>&nbsp;
	  <input name="buttonF5" id="F5" value="更新" type="button" onClick="reload()">&nbsp;&nbsp;
	  设置为<input type="text" id='update_sec' name="update_sec" value='<?=$update_sec?>' size='3'>秒自动更新&nbsp;
	  <input name="buttonF5" value="保存" type="button" onClick="update_sec_save()">&nbsp;&nbsp;
        <span id="timeinfo"></span>-- 20分内在线人数<font color=red><b>(<span id="mem_num"></span>)</b></font>&nbsp;&nbsp;&nbsp;-- 会员帐号或其部分:<INPUT type="text" size="10" name="so_log_name" value="" id="so_log_name" > <input name="button" type="button" onClick="so_log()" value="搜索" name="buttonF6"> -- <a href="javascript:history.go( -1 );">回上一页</a></td>
      <td width="34"><img src="/images/control/top_04.gif" width="30" height="24"></td>
    </tr>
  </table>
 <table width="774" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="774" height="4"></td>
   </tr>
 </table>


<table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab" width="900">
  <tr class="m_title_ft">
    <td width="100">代理 </td>
		<td width="100">会员帐号 </td><td width="100">登陆帐号 </td>
    <td width="150">最后活动时间</td>
    <td width="150">登陆IP</td>
    <td width="150">网址</td>
    <td width="150">操作</td>
  </tr>
<?
require ("ip.php");
$date = date('Y-m-d H:i:s',time()-60*20);
$sql_where="m.active>'$date' AND m.oid!='' AND m.oid!='out' ";
if($so_log_name){
	$sql_where="(m.memname like '%$so_log_name%' OR m.loginname like '%$so_log_name%') ";
}
$sql = "SELECT m.id, m.memname, m.loginname, m.active, m.logip, m.domain, m.agents, a.logip AS logip_a, w.logip AS logip_w, c.logip AS logip_c, s.logip AS logip_s FROM web_member AS m, web_agents AS a, web_world AS w, web_corprator AS c, web_super AS s
WHERE $sql_where AND a.agname = m.agents AND w.agname = m.world AND c.agname = m.corprator AND s.agname = m.super ORDER BY agents, memname";
$i=0;
$upagent='';
$bj='m_cen2';
$result = mysql_query( $sql );
while ( $row = mysql_fetch_array( $result ) )
{
	if($upagent!=$row['agents']){
		$upagent=$row['agents'];
		$bj = $bj=="m_cen2" ? "m_cen" : "m_cen2";
	}
	$iptong = "不同";
	if($row['logip']==$row['logip_a'] || $row['logip']==$row['logip_w']  || $row['logip']==$row['logip_c']  || $row['logip']==$row['logip_s'] ){
		$iptong = "<font color='#CC0000'>相同</font>";
	}
	$iipp=$row['logip'];
	$ccc=convertip_full($iipp, 'QQWry.Dat');
    $ccc=iconv('GBK','UTF-8',$ccc);
	echo "  <tr class='$bj'><td><a href='./showlog.php?uid=$uid&agents_id={$row[agents]}&level=3' target='_blank'>$row[agents]</a></td>
		<td><font color='#CC0000'>$row[memname]</font></td>
		<td><font color='#CC0000'>$row[loginname]</font></td>
		<td>$row[active] </td>
		<td align=center width='160'><a href='http://ip138.com/ips138.asp?action=2&ip=$row[logip]' target=_blank>$row[logip]</a> / <a href='/control/system/showlog.php?uid=$uid&level=4&agents_id=$row[id]' target=_blank>$iptong</a>&nbsp;/&nbsp;$ccc</td>
		<td>$row[domain] </td>
		<td align='center'><a href='./memlog.php?uid=$uid&active=1&user=$row[memname]'>踢线</a>";
	if ( $level == 1 ){
		echo " / <a href='./memsg.php?uid=$uid&user=$row[memname]'>短消息</a>";
		echo " / <a href='../wager/hide_list.php?uid=$uid&username=$row[memname]'>投注</a>";
	}
	echo "</td></tr>";
	$i++;
}
echo "</table>\r\n</form></body>\r\n</html>\r\n<script>\r\nvar cou='";
echo $i;
echo "';\r\nreport_bg();\r\n</script>\r\n";
?>
<font color=red>session：<?=$_SESSION["ckck"];?><font>