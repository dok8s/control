<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require( "../../member/include/config.inc.php" );
require( "../../member/include/define_function_list.inc.php" );

$uid = $_GET['uid'];
$categories = $_GET['c'];
$minclass = $_GET['mc'];
!in_array($categories, array('FT','BK')) && $categories='FT';
!in_array($minclass, array('oldsingle','nowsingle','running')) && $minclass='nowsingle';
$cou=mysql_num_rows(mysql_query("select id from web_sytnet where uid='$uid' and status=1"));
if($cou==0){
	exit( "<script>window.open('$site/index.php','_top')</script>");
}
$i = strtotime($_GET['ldate']);
$i<strtotime('2010-01-01') && $i=time();
$ldate = date('Y-m-d',$i);
$mdate = date('m-d',$i);

$whereadd = '';
if($minclass=='nowsingle'){
	$whereadd .= ' and r_show=1 and m_start>now()';
}elseif($minclass=='running'){
	$whereadd .= ' and re_show=1';
}

$rts = array();
if($categories=='FT'){
	//
	$hr_rts = array();
	$sqlhr="select mid,mb_mid,tg_mid,showtype,m_letb,mb_letb_rate,tg_letb_rate,mb_dime_rate,tg_dime_rate,concat('O',m_dime) as mb_dime,concat('U',m_dime) as tg_dime,mb_win,tg_win,m_flat from foot_match where is_hr='1'";
	$resulthr = mysql_query($sqlhr) or exit('error GL02');
	while ($row=mysql_fetch_array($resulthr)){
		$hr_rts[$row['mid']]=$row;
	}
	//
	$sql = "select mid,mb_mid,tg_mid,m_date,m_time,m_league,mb_team,tg_team, mb_win,tg_win,m_flat, showtype,m_letb,mb_letb_rate,tg_letb_rate, concat('O',m_dime) as mb_dime,concat('U',m_dime) as tg_dime,mb_dime_rate,tg_dime_rate, s_single,s_double, m_type from foot_match where m_date='$mdate' $whereadd and is_hr='0' and mb_team<>'' and mb_team<>'' order by display limit 0,1000";

	$result = mysql_query($sql) or exit('error GL01');
	while ($row=mysql_fetch_array($result)){
		if(strpos($row['m_time'],':')==false) $row['m_time']='<font color=red>走</font>'.$row['m_time'];
		$row['m_letb']=str_replace(' ','',$row['m_letb']);
		$row['mb_dime']=str_replace(' ','',$row['mb_dime']);
		$row['tg_dime']=str_replace(' ','',$row['tg_dime']);
		$row['showtype']=='H' && $row['m_letb_h']=$row['m_letb'];
		$row['showtype']=='C' && $row['m_letb_c']=$row['m_letb'];
		$mid=$row['mid']+1;
		if(isset($hr_rts[$mid])){
			$row2=$hr_rts[$mid];
			$row2['m_letb']=str_replace(' ','',$row2['m_letb']);
			$row2['mb_dime']=str_replace(' ','',$row2['mb_dime']);
			$row2['tg_dime']=str_replace(' ','',$row2['tg_dime']);
			$row2['showtype']=='H' && $row2['m_letb_h']=$row2['m_letb'];
			$row2['showtype']=='C' && $row2['m_letb_c']=$row2['m_letb'];
			foreach($row2 as $k=>$v){
				$row["hr_$k"] = $v;
			}
		}
		$rts[] = $row;
	}
}
elseif($categories=='BK'){
	$sql = "select mid,mb_mid,tg_mid,m_date,m_time,m_league,mb_team,tg_team, showtype,m_letb,mb_letb_rate,tg_letb_rate, concat('O',m_dime) as mb_dime,concat('U',m_dime) as tg_dime,mb_dime_rate,tg_dime_rate, s_single,s_double from bask_match where m_date='$mdate' $whereadd  and mb_team<>'' and mb_team<>'' order by m_start limit 0,1000";

	$result = mysql_query($sql) or exit('error GL05'.mysql_error());
	while ($row=mysql_fetch_array($result)){
		if(strpos($row['m_time'],':')==false) $row['m_time']='<font color=red>走</font>'.$row['m_time'];
		$row['m_letb']=str_replace(' ','',$row['m_letb']);
		$row['mb_dime']=str_replace(' ','',$row['mb_dime']);
		$row['tg_dime']=str_replace(' ','',$row['tg_dime']);
		$row['showtype']=='H' && $row['m_letb_h']=$row['m_letb'];
		$row['showtype']=='C' && $row['m_letb_c']=$row['m_letb'];
		$rts[] = $row;
	}
}

?>
<html style="width: 98%;margin: 0 auto;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
<!--
body,td,th {
	font-size: 12px;
	color: #000000;
}
body {
	background-color: #FFFFFF;
}
a {
	font-weight: bold;
}
a:link {
	color: #CC0000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #CC0000;
}
a:hover {
	text-decoration: none;
	color: #0000FF;
}
a:active {
	text-decoration: none;
	color: #0000FF;
}
-->
</style>
<script language="JavaScript">

var NS4 = (document.layers); // Which browser?
var IE4 = (document.all);
var win = window; // window to search.
var n = 0;

function findInPage(str) {
	var txt, i, found;
	if (str == "")
		return false;
	if (NS4) {
		if (!win.find(str))
			while(win.find(str, false, true))
			n++;
		else
			n++;
		if (n == 0) alert("Not found.");
	}

	if (IE4) {
		txt = win.document.body.createTextRange();
		for (i = 0; i <= n && (found = txt.findText(str)) != false; i++) {
			txt.moveStart("character", 1);
			txt.moveEnd("textedit");
		}
		if (found) {
			txt.moveStart("character", -1);
			txt.findText(str);
			txt.select();
			txt.scrollIntoView();
			n++;
		}
		else {
			if (n > 0) {
				n = 0;
				findInPage(str);
			}
			else
				alert("Not found.");
		}
	}
	return false;
}
function $(name){
	return document.getElementById(name);
}

function bet(gid,gnum,hc,type){
	parent.framebet.location = 'bet.php?uid=<?=$uid?>&c=<?=$categories?>&mc=<?=$minclass?>' +'&gid='+gid+'&gnum='+gnum+'&hc='+hc+'&type='+type;
}

function go(){
	location = '?uid=<?=$uid?>&c='+$('c').value+'&mc='+$('mc').value;
}
</script>
</head>

<body>

<table width='700' border='0' cellpadding='5' cellspacing='0'>
	<tr>
		<td>
		<select id="c" name="c" onchange='go();'>
			<option value="FT" <? if($categories=='FT')echo 'selected'; ?>>足球
			<option value="BK" <? if($categories=='BK')echo 'selected'; ?>>蓝球
		</select>
		&nbsp;
		<select id='mc' name='mc' onchange='go();'>
			<option value='nowsingle' <? if($minclass=='nowsingle')echo 'selected'; ?>>当前单式
			<option value='running' <? if($minclass=='running')echo 'selected'; ?>>当前滚球
			<?
			$time = time();
			for($i=0; $i<7; $i++){
				$d = date('Y-m-d',$time);
				$time -= 3600*24;
				$selected = $ldate==$d && $minclass=='oldsingle' ? 'selected' : '';
				echo "<option value='oldsingle&ldate=$d' $selected>$d";
			}

			?>
		</select>
		</td>		
		<form name="search" onSubmit="return findInPage(this.string.value);">
		<td>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;关键词：<input name="string" type="text" size=15 onChange="n = 0;"><input type="submit" value="查找">
		</td></form>
	</tr>
	<tr><td colspan='2'><hr></td></tr>
</table>

<?
if($categories=='FT'){ 
	echo "
		<table width='' border='0' cellpadding='5' cellspacing='1' bgcolor='#CCCCCC'>
		<tr>
		<td rowspan='2' align='center' bgcolor='#FFFFFF'>时间</td>
		<td rowspan='2' align='center' bgcolor='#FFFFFF'>联盟</td>
		<td rowspan='2' align='center' bgcolor='#FFFFFF'>主客队伍</td>
		<td colspan='2' align='center' bgcolor='#FFFFFF'>全场</td>
		<td colspan='2' align='center' bgcolor='#F0FFB4'>上半场</td>
		</tr>
		<tr>
		<td align='center' bgcolor='#FFFFFF'>让球</td>
		<td align='center' bgcolor='#FFFFFF'>大小</td>
		<td align='center' bgcolor='#F0FFB4'>让球</td>
		<td align='center' bgcolor='#F0FFB4'>大小</td>
		</tr>";

	foreach($rts as $row){
		echo "
			<tr>
			<td bgcolor='#FFFFFF'>$row[m_date]<br>$row[m_time]</td>
			<td bgcolor='#FFFFFF'>$row[m_league]</td>
			<td bgcolor='#FFFFFF'>[{$row[mb_mid]}]$row[mb_team]<br>[{$row[tg_mid]}]$row[tg_team]</td>
			<td align='right' bgcolor='#FFFFFF'>
$row[m_letb_h]&nbsp;&nbsp;<a href=\"JavaScript:bet('$row[mid]','$row[mb_mid]','H','letb')\">$row[mb_letb_rate]</a><br>
$row[m_letb_c]&nbsp;&nbsp;<a href=\"JavaScript:bet('$row[mid]','$row[tg_mid]','C','letb');\">$row[tg_letb_rate]</a></td>
			<td align='right' bgcolor='#FFFFFF'>
$row[mb_dime]&nbsp;&nbsp;<a href=\"JavaScript:bet('$row[mid]','$row[tg_mid]','C','dime')\">$row[mb_dime_rate]</a><br>
$row[tg_dime]&nbsp;&nbsp;<a href=\"JavaScript:bet('$row[mid]','$row[mb_mid]','H','dime');\">$row[tg_dime_rate]</a></td>
			<td align='right' bgcolor='#F0FFB4'>
$row[hr_m_letb_h]&nbsp;&nbsp;<a href=\"JavaScript:bet('$row[hr_mid]','$row[hr_mb_mid]','H','letb')\">$row[hr_mb_letb_rate]</a><br>
$row[hr_m_letb_c]&nbsp;&nbsp;<a href=\"JavaScript:bet('$row[hr_mid]','$row[hr_tg_mid]','C','letb')\">$row[hr_tg_letb_rate]</a></td>
			<td align='right' bgcolor='#F0FFB4'>
$row[hr_mb_dime]&nbsp;&nbsp;<a href=\"JavaScript:bet('$row[hr_mid]','$row[hr_tg_mid]','C','dime')\">$row[hr_mb_dime_rate]</a><br>
$row[hr_tg_dime]&nbsp;&nbsp;<a href=\"JavaScript:bet('$row[hr_mid]','$row[hr_mb_mid]','H','dime')\">$row[hr_tg_dime_rate]</a></td>
			</tr>";
	}
	echo "</table>";
}
elseif($categories=='BK'){ 
	echo "
		<table width='' border='0' cellpadding='5' cellspacing='1' bgcolor='#CCCCCC'>
		<tr>
		<td align='center' bgcolor='#FFFFFF'>时间</td>
		<td align='center' bgcolor='#FFFFFF'>联盟</td>
		<td align='center' bgcolor='#FFFFFF'>主客队伍</td>
		<td align='center' bgcolor='#FFFFFF'>让分</td>
		<td align='center' bgcolor='#FFFFFF'>大小</td>
		</tr>";

	foreach($rts as $row){
		echo "
			<tr>
			<td bgcolor='#FFFFFF'>$row[m_date]<br>$row[m_time]</td>
			<td bgcolor='#FFFFFF'>$row[m_league]</td>
			<td bgcolor='#FFFFFF'>[{$row[mb_mid]}]$row[mb_team]<br>[{$row[tg_mid]}]$row[tg_team]</td>
			<td align='right' bgcolor='#FFFFFF'>
$row[m_letb_h]&nbsp;&nbsp;<a href=\"JavaScript:bet('$row[mid]','$row[mb_mid]','H','letb')\">$row[mb_letb_rate]</a><br>
$row[m_letb_c]&nbsp;&nbsp;<a href=\"JavaScript:bet('$row[mid]','$row[tg_mid]','C','letb');\">$row[tg_letb_rate]</a></td>
			<td align='right' bgcolor='#FFFFFF'>
$row[mb_dime]&nbsp;&nbsp;<a href=\"JavaScript:bet('$row[mid]','$row[tg_mid]','C','dime')\">$row[mb_dime_rate]</a><br>
$row[tg_dime]&nbsp;&nbsp;<a href=\"JavaScript:bet('$row[mid]','$row[mb_mid]','H','dime');\">$row[tg_dime_rate]</a></td>
			</tr>";
	}
	echo "</table>";
}
?>
</body>
</html>