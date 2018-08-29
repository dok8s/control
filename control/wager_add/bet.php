<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>-</title>
<style type="text/css">
html {overflow-y:hidden;overflow-x:hidden;}
body,td,th {
	font-size: 12px;
}
body {
	margin-left: 4px;
	margin-right: 4px;
	margin-top: 5px;
	margin-bottom: 5px;
	background-color: #413C15;
}
form { margin:0; padding:0;}
input,select {vertical-align:middle;	background-color: #FFFFFF;	border: 1px solid #C0C0C0;}
.Red {color: #cc0000;}
.b {
	border: 3px solid #808080;
}
.l {
	background-color: #FFFFFF;
	border-bottom-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-bottom-color: #CC3300;
	line-height: 18px;
	vertical-align: middle;
	text-align: center;
}
.lh25 {line-height: 20px;}
</style>
<script language="JavaScript">
function $(name){
	return document.getElementById(name);
}

function mcselected(){
	if($('mc').value=='running'){
		$('nowin').style.display='';
	}else{
		$('nowin').style.display='none';
	}
}
</script>
</head>

<body>
<?php
require( "../../member/include/config.inc.php" );
require( "../../member/include/define_function_list.inc.php" );

//uid=&gid=654847&gnum=70083&type=C
$uid = $_GET['uid'];
$gid = intval($_GET['gid']);
$gnum = intval($_GET['gnum']);
$hc = $_GET['hc']== 'H' ? 'H' : 'C';
$categories = $_GET['c'];
$minclass = $_GET['mc']=='running' ? 'running' : 'single';
$type = $_GET['type'];

$cou=mysql_num_rows(mysql_query("select id from web_sytnet where uid='$uid' and status=1"));
if($cou==0){
	exit( "<script>window.open('$site/index.php','_top')</script>");
}
if (!in_array($categories, array('FT','BK')) ||
	!in_array($type, array('letb','dime')) ) {
	exit();
}

if($categories=='FT'){
	$sql="select mb_mid,tg_mid,m_date,m_league,mb_team,tg_team, showtype,m_letb,mb_letb_rate,tg_letb_rate, m_dime,mb_dime_rate,tg_dime_rate, mb_win,tg_win,m_flat,is_hr from foot_match where mid='$gid'";
	$result=mysql_query($sql) or exit('error GL02');
	$row=mysql_fetch_array($result);
	if($row['is_hr'])$row['m_league'].="<font color='#cc0000'>[上半]</font>";
}
elseif($categories=='BK'){
	$sql="select mb_mid,tg_mid,m_date,m_league,mb_team,tg_team, showtype,m_letb,mb_letb_rate,tg_letb_rate, m_dime,mb_dime_rate,tg_dime_rate from bask_match where mid='$gid'";
	$result=mysql_query($sql) or exit('error GL033');
	$row=mysql_fetch_array($result);
	foreach(array('上半','下半','第1节','第2节','第3节','第4节') as $v){
		if (strstr($row['mb_team'],$v)){
			$row['m_league'].="<font color='#cc0000'>[$v]</font>";
			break;
		}
	}
}

$row['m_letb']=str_replace(' ','',$row['m_letb']);
$row['m_dime']=str_replace(' ','',$row['m_dime']);
$row['mb_team']=filiter_team($row['mb_team']);
$row['tg_team']=filiter_team($row['tg_team']);
$mb_team=$row["mb_team"];
$tg_team=$row["tg_team"];	
$mb_mid=$row["mb_mid"];
$tg_mid=$row["tg_mid"];

if($type=='letb'){
	$size = strlen($row['m_letb']);
	$size<3 && $size=3; 
	$sign="<input type='text' name='m_place' size='$size' class='Red' value='$row[m_letb]'>";
	if ($row['showtype']=='C'){
		$mb_team=$row['tg_team'];
		$tg_team=$row['mb_team'];
	}
	$m_place = $hc=='H' ? $row['mb_team'] : $row['tg_team'];
	$m_rate  = $hc=='H' ? $row['mb_letb_rate'] : $row['tg_letb_rate'];
}
elseif($type=='dime'){
	$sign='VS.';
	$size = strlen($row['m_dime']);
	$size<3 && $size=3; 
	$m_place = $hc=='C' ? '大' : '小';
	$m_place .= "<input type='text' name='m_place' size='$size' class='Red' value='$row[m_dime]'>";
	$m_rate  = $hc=='C' ? $row['mb_dime_rate'] : $row['tg_dime_rate'];
}

$m_rate = "<input type='text' name='m_rate' size='5' class='Red' value='$m_rate'>";
?>
<script language="JavaScript"> 
window.onload = function(){ $('mc').value='<?=$minclass?>'; mcselected();}
</script>
<form name="form1" action="bet_finish.php?uid=<?=$uid?>" method="POST">
<input type="hidden" name="c" value='<?=$categories?>'>
<input type="hidden" name="type" value='<?=$type?>'>
<input type="hidden" name="gid" value='<?=$gid?>'>
<input type="hidden" name="gnum" value='<?=$gnum?>'>
<input type="hidden" name="hc" value='<?=$hc?>'>
<table width="232" border="0" cellpadding="5" cellspacing="0" class="b">
  <tr>
    <td class="l">
		<?=$row['m_league']?>&nbsp;<?=$row['m_date']?><br>
		[<?=$mb_mid?>]vs[<?=$tg_mid?>]<br>
		<?=$mb_team?>&nbsp;<font color='#cc0000'><?=$sign?></font>&nbsp;<?=$tg_team?><br>
		<font color='#cc0000'><?=$m_place?></font>&nbsp;@&nbsp;<font color='#cc0000'><strong><?=$m_rate?></strong></font><br>
	</td>
  </tr>
  <tr>
    <td class='lh25' bgcolor="#ECE9D8">
		<div id='nowin' style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;比分：<input type='text' name='now_inball' size='5' class='Red' value='0:0'></div>
		&nbsp;&nbsp;&nbsp;&nbsp;类型：<select id="mc" name="mc" onChange="mcselected()">
			<option value="single" selected>单式
			<option value="running">滚球
		</select><br>
		&nbsp;&nbsp;&nbsp;&nbsp;盘口：<select name="odd_type">
			<option value="H" selected>香港盘
			<option value="M">马来盘
			<option value="I">印尼盘
			<option value="E">欧洲盘
		</select><br>
		会员账号：<input type='text' name='memname' size='12' value=''><br>
		交易金额：<input type='text' name='gold' size='12' value='0'><br>
		交易时间：<input type='text' name='bettime' size='19' value='<?=date('Y-m-d H:i:s')?>'><br>
		&nbsp;&nbsp;IP地址：<input type='text' name='ip' size='19' value='0.0.0.0'><br>
	</td>
  </tr>
  <tr>
    <td bgcolor="#ECE9D8"><div align="center">
      <input type="button" name="wgCancel" value="取消交易" onClick="location='?uid=<?=$uid?>'">
      <input type="submit" name="wgSubmit" value="确定交易" ><br><br>
	 </td>
  </tr>
</table>
</form>
</body>
</html>
