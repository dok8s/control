<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require_once('../../member/include/config.inc.php');
$action	=$_REQUEST['action'];
$active	=$_REQUEST['active'];

$uid   = $_REQUEST['uid'];
$gid   = $_REQUEST['gid']+0;
$gtype = $_REQUEST['gtype'];
$score = $_REQUEST['score'];
$gdate = $_REQUEST['gdate'];

$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

if($action==2){

	$mb_in		=	$_REQUEST['result_h'];
	$tg_in		=	$_REQUEST['result_c'];
	$mb_in_hr	=	$_REQUEST['result_h1'];
	$tg_in_hr	=	$_REQUEST['result_c1'];
	$state	=	$_REQUEST['score']+0;
	if($state==1){
		$status=1;
	}elseif($state==2){
		$status=1;
	}elseif($state==3){
		$status=2;
	}elseif($state==4){
		$status=2;
	}elseif($state==5){
		$status=3;
	}elseif($state==6){
		$status=3;
	}elseif($state==7){
		$status=4;
	}elseif($state==8){
		$status=5;
	}elseif($state==9){
		$status=6;
	}elseif($state==10){
		$status=7;
	}else{
		$status=0;
	}

	//需直接传递过来比分：上半和全场，可根据实际情况分别分批传递

	$tables = array('FT'=>'foot_match', 'OP'=>'other_play', 'BS'=>'baseball', 'BK'=>'bask_match', 'TN'=>'tennis', 'VB'=>'volleyball');
	$setarr = array();
	$setarr[]="status='$status'";
	is_numeric($mb_in) && $setarr[]="mb_inball='$mb_in'";
	is_numeric($tg_in) && $setarr[]="tg_inball='$tg_in'";
	is_numeric($mb_in_hr) && $gtype!='BK' && $setarr[]="mb_inball_hr='$mb_in_hr'";
	is_numeric($tg_in_hr) && $gtype!='BK' && $setarr[]="tg_inball_hr='$tg_in_hr'";
	if($gtype=='FT' || $gtype=='BK'){
		$rt = mysql_fetch_array(mysql_query("select moredata from {$tables[$gtype]} where mid='$gid'"));
		$moredata = @unserialize($rt['moredata']);
		$moredata['inball_lock'] = intval($_REQUEST['inball_lock']);
		$setarr[]="moredata='".serialize($moredata)."'";
	}
	if(isset($tables[$gtype])){
		$mysql="update {$tables[$gtype]} set ".join(',', $setarr)." where mid='$gid'";
		mysql_query($mysql) or die ("error 1");
	}
	$url="ctl.php?uid=$uid&gtype=$gtype&gdate=$gdate";
	if($active==2){
		$url="ctl_result.php?uid=$uid&gtype=$gtype&gdate=$gdate";
	}
	$url="settlement.php?uid=$uid&active=resettlement&gtype=$gtype&gid=$gid&referer=".urlencode($url);
	echo "<script language='javascript'>self.location='$url';</script>";
	exit;
//echo  $mysql;
}

switch($gtype){
	case 'FT':
		$sql = "select mid,DATE_FORMAT(m_start,'%m-%d') as gdate2,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mb_team,tg_team,m_league,mb_inball,tg_inball,mb_inball_hr,tg_inball_hr,moredata from foot_match where mid='$gid'";
		break;
	case 'BK':
		$sql = "select mid,DATE_FORMAT(m_start,'%m-%d') as gdate2,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mb_team,tg_team,m_league,mb_inball,tg_inball,'0' as mb_inball_hr,'0' as tg_inball_hr,moredata from bask_match where mid='$gid'";
		break;
	case 'OP':
		$sql = "select mid,DATE_FORMAT(m_start,'%m-%d') as gdate2,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mb_team,tg_team,m_league,mb_inball,tg_inball,mb_inball_hr,tg_inball_hr from other_play where mid='$gid'";
		break;
	case 'BS':
		$sql = "select mid,DATE_FORMAT(m_start,'%m-%d') as gdate2,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mb_team,tg_team,m_league,mb_inball,tg_inball,mb_inball_hr,tg_inball_hr from baseball where mid='$gid'";
		break;
	case 'VB':
		$sql = "select mid,DATE_FORMAT(m_start,'%m-%d') as gdate2,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mb_team,tg_team,m_league,mb_inball,tg_inball,mb_inball_hr,tg_inball_hr from volleyball where mid='$gid'";
		break;
	case 'TN':
		$sql = "select mid,DATE_FORMAT(m_start,'%m-%d') as gdate2,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mb_team,tg_team,m_league,mb_inball,tg_inball,mb_inball_hr,tg_inball_hr from tennis where mid='$gid'";
		break;
}
$result = mysql_query($sql) or exit('error 1');
$row=mysql_fetch_array($result);
$moredata = @unserialize($row['moredata']);
$inball_lock = $moredata['inball_lock'];

?>

<html>
<head>
<title>reports_member</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title {  background-color: #687780; text-align: center; color: #FFFFFF}
.m_title_2 { background-color: #CC0000; text-align: center; color: #FFFFFF}
-->
</style>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function SubChk(){/*
  if (document.all.result_h1.value==''){
    document.all.result_h1.focus();
    alert("请输入主队上半场进球数!!");
    return false;
  }
  if (document.all.result_c1.value==''){
    document.all.result_c1.focus();
    alert("请输入客队上半场进球数!!");
    return false;
  }

  if (document.all.result_h.value==''){
    document.all.result_h.focus();
    alert("请输入主队全场进球数!!");
    return false;
  }
  if (document.all.result_c.value==''){
    document.all.result_c.focus();
    alert("请输入客队全场进球数!!");
    return false;
  }*/
  if(!confirm("请确定输入是否正确?")){return false;}
}

function chk_score(){
	if (document.all.score(0).checked){
		document.all.result_h.value='';
		document.all.result_c.value='';
		document.all.result_h1.value='';
		document.all.result_c1.value='';
	}
	if (document.all.score(1).checked){
		document.all.result_h1.value='';
		document.all.result_c1.value='';
		document.all.result_h.value='-1';
		document.all.result_c.value='-1';
	}
	if (document.all.score(2).checked){
		document.all.result_h1.value='-1';
		document.all.result_c1.value='-1';
		document.all.result_h.value='-1';
		document.all.result_c.value='-1';
	}
	if (document.all.score(3).checked){
		document.all.result_h1.value='';
		document.all.result_c1.value='';
		document.all.result_h.value='-1';
		document.all.result_c.value='-1';
	}
	if (document.all.score(4).checked){
		document.all.result_h1.value='-1';
		document.all.result_c1.value='-1';
		document.all.result_h.value='-1';
		document.all.result_c.value='-1';
	}
	if (document.all.score(5).checked){
		document.all.result_h1.value='';
		document.all.result_c1.value='';
		document.all.result_h.value='-1';
		document.all.result_c.value='-1';
	}
	if (document.all.score(6).checked){
		document.all.result_h1.value='-1';
		document.all.result_c1.value='-1';
		document.all.result_h.value='-1';
		document.all.result_c.value='-1';
	}
	if (document.all.score(7).checked){
		document.all.result_h1.value='-1';
		document.all.result_c1.value='-1';
		document.all.result_h.value='-1';
		document.all.result_c.value='-1';
	}
	if (document.all.score(8).checked){
		document.all.result_h1.value='-1';
		document.all.result_c1.value='-1';
		document.all.result_h.value='-1';
		document.all.result_c.value='-1';
	}
	if (document.all.score(9).checked){
		document.all.result_h1.value='-1';
		document.all.result_c1.value='-1';
		document.all.result_h.value='-1';
		document.all.result_c.value='-1';
	}
if (document.all.score(10).checked){
		document.all.result_h1.value='-1';
		document.all.result_c1.value='-1';
		document.all.result_h.value='-1';
		document.all.result_c.value='-1';
	}
}
function onLoad()
 {
	//document.all.score.value='4';
 }
//-->
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="10" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
<FORM NAME="LAYOUTFORM" onSubmit="return SubChk();" ACTION="ctl_score.php?uid=<?=$uid?>&gid=<?=$gid?>&gtype=<?=$gtype?>&action=2&active=<?=$active?>" METHOD=POST>
  <table width="780" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="750">&nbsp;线上操盘－<font color="#CC0000">添写比分&nbsp;</font>&nbsp;&nbsp;&nbsp;日期:<%=date_start%>~<%=date_end%> -- 下注管道:网路下注 -- <a href="javascript:history.go( -1 );">回上一頁</a>
      </td>
      <td width="30"><img src="/images/control/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr>
      <td colspan="2" height="4"></td>
    </tr>
  </table>
<table width="517" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">
  <tr class="m_title" >
      <td width="71" height="18"> 时间</td>
    <td width="194"> 主客队伍</td>
      <td width="120">上半场进球数</td>
      <td width="120">全场进球数</td>
    </tr>
  <tr class="m_rig">
    <td align="center" colspan="4"><?=$row['m_league']?></td>
    </tr>
  <tr class="m_rig_re">
      <td rowspan="2" width="71">
        <p align="center"><?=$row['gdate']?></p>
      </td>
      <td width="194" rowspan="2">
        <p align="left"><?=$row['mb_team']?>
          <br>
          <?=$row['tg_team']?>
        </p>
				</td>
				<?
				$ballh=$row['mb_inball'];
				$ballc=$row['tg_inball'];
				$ballh_v=$row['mb_inball_hr'];
				$ballc_v=$row['tg_inball_hr'];
				$gdate3=$row['gdate2'];
				if($gtype=='BK'){
					$ballh_v=0;
					$ballc_v=0;
				}
				?>
      <td width="126" align="center"><input name="result_h1" value='<?=$ballh_v?>' type="text" size="5"  class="za_text"></td>
      <td width="121" align="center"><input name="result_h" value='<?=$ballh?>' type="text" size="5" class="za_text"></td>
    </tr>
  <tr class="m_rig_re">
      <td width="126" align="center">
         <input name="result_c1" type="text" value='<?=$ballc_v?>'  size="5" class="za_text">
      </td>
      <td width="121" align="center">
         <input name="result_c" type="text" value='<?=$ballc?>'  size="5" class="za_text">
      </td>
    </tr>
      <tr class="m_rig">
    <td align="center" colspan="4">
		  <input name="score" type="radio" onClick="return chk_score();" value="0" checked>正常比分
		  <input name="score" type="radio" value="1" onClick="return chk_score();">下半取消
		  <input name="score" type="radio" value="2" onClick="return chk_score();">全场取消
		  <input name="score" type="radio" value="3" onClick="return chk_score();">下半延赛
		  <input name="score" type="radio" value="4" onClick="return chk_score();">全场延赛
		  <br>
		  <input name="score" type="radio" value="5" onClick="return chk_score();">下半腰斩
		  <input name="score" type="radio" value="6" onClick="return chk_score();">全场腰斩

		  <input name="score" type="radio" value="7" onClick="return chk_score();">无pk加时
		  <input name="score" type="radio" value="8" onClick="return chk_score();">球员弃权
		  <input name="score" type="radio" value="9" onClick="return chk_score();">队名错误
		  <br><input name="score" type="radio" value="10" onClick="return chk_score();">先发投手更换
		<? if(isset($row['moredata'])){ ?>
	 	<br><br><input type="checkbox" name="inball_lock" value="1" <?=$inball_lock==1 ? 'checked' : ''?>>锁定比分 (注：赛事未结束时无效)
		<? } ?>
		<br><br><font color="#FF0000"><strong>(1)若无比分，请留空  &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;
		<BR>(2)篮球上半比分请添在全场处
		<BR>(3)保存比分之后将会重新结算  </strong></font><BR><BR></td>
  </tr>

  </table>
<table width="438" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="15" width="436">
  <p align="center"><br>
  <input type="hidden" name="gdate" value="<?=$gdate3?>">
  <input type="submit" value=" 提 交 " name="subject" class="za_button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="reset" value=" 清 除 " name="cancel" class="za_button"></td>
</tr>
</table>
</form>
</body>
</html>