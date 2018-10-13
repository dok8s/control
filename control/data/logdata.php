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
$username=$_REQUEST['username'];
$active=$_REQUEST['active'];
$sql = "select id,level from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
/*
require ("../../member/include/ctbclass.php");

$text = new CtbClass;
$text->file = 'c:/www/log/user_log/'.date('Y-m-d').'/user_log.'.date('H').'.log';
$list = $text->read_file();
//print_r($list);
*/
?>
<html style="width: 98%;margin: 0 auto;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title></title>
<script>
<!--
var limit="120"
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
		curtime=curmin+"����Զ����£�"
	else
		curtime=cursec+"����Զ����£�"
		timeinfo.innerText=curtime
		setTimeout("beginrefresh()",1000)
	}
}
function reload()
{
  var obj_username = document.getElementById('username');
  var username=obj_username.value;
	self.location.href="logdata.php?uid=<?=$uid?>&username="+username;
}
function report_bg(){
	document.getElementById('mem_num').innerText=cou;
}
window.onload=beginrefresh
file://-->
</script>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
</head>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">

 <table width="773" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="746">&nbsp;�������ݣ�<font color="#CC0000">��־</font><font color="#CC0000">&nbsp;</font><input name=button type=button class="za_button" onclick="reload()" value="����">&nbsp;&nbsp;&nbsp;&nbsp;
        <span id="timeinfo"></span>&nbsp;&nbsp;
              <input type="text" size=16 name="username" value="<?=$username?>">
            &nbsp;--����ģʽ:WEBҳ�� -- <a href="javascript:history.go( -1 );">����һ�</a></td>
      <td width="34"><img src="/images/control/top_04.gif" width="30" height="24"></td>
    </tr>
  </table>
 <table width="774" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="774" height="4"></td>
   </tr>
 </table>

<table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab" width="100%">
  <tr class="m_title_ft">
    <td width="100">���� </td>
		<td width="100">��Ա���� </td>
    <td width="300">���ʱ��</td>
    <td width="150">��½IP</td>
    <!--td width="100">����</td-->
  </tr>
  <?
	for($i=count($list)-1;$i>=0;$i--){
		$log=explode('	',$list[$i]);
		if($log[2]==$username){
	?>
  <tr class="m_cen">
    <td><?=$log[0]?></td>
		<td><font color="#CC0000"><?=$log[2]?></font>
		<td><?=$log[3]?></td>
		<td align=right width="160"><font color="#CC0000"><?=$log[1]?></font></td>
    <!--td align="center">
         <?=$log[4]?>
    </td-->
  </tr>
  <?
}
	}
	?>
</table>
</form></body>
</html>
