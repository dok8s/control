<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../member/include/config.inc.php");

$langx		=$_REQUEST['langx'];

$uid			=$_REQUEST['uid'];
$active		=$_REQUEST['active'];
$filename	=$_REQUEST['filename'];

$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

require ("../member/include/traditional.$langx.inc.php");
switch($langx){
	case 'en-us':
		$ss="_en";
		break;
	case 'zh-tw':
		$ss="_tw";
		break;
}
$msg_member='message'.$ss;

$j=1;
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
  
<table width="485" border="0" cellspacing="1" cellpadding="0"  bgcolor="2A73AC" class="m_tab">
  <tr><td colspan="3"></td></tr>
  <tr><td colspan="3">跑马灯_历史讯息</td></tr>
  <tr class="m_title_bk" > 
    <td width="50"  align="center">编号</td>
    <td width="55"  align="center">时间</td>
    <td width="380" >公告內容</td>
  </tr>
<?
$sql = "select * from web_marquee order by ntime desc";
$result = mysql_db_query($dbname,$sql);
while ($row = mysql_fetch_array($result))
{	

?>
  <tr class="m_cen"> 
      <td align="center"><?=$j?></td>
      <td align="center"><?=$row['ndate']?></td>
      <td align="left"><font color="#CC0000"><?=$row[$msg_member]?></font></td>
  </tr>
<? 
	$j=$j+1;
}?> 	
 
</table>
</body>
</html>
