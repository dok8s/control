<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
require ("../../member/include/traditional.zh-cn.inc.php");

$report_kind = $_REQUEST['report_kind'];
$pay_type    = $_REQUEST['pay_type'];
$wtype       = $_REQUEST['wtype'];
$date_start  = $_REQUEST['date_start'];
$date_end    = $_REQUEST['date_end'];
$gtype       = $_REQUEST['gtype'];
$cid         = $_REQUEST['cid'];
$aid         = $_REQUEST['aid'];
$sid         = $_REQUEST['sid'];
$mid         = $_REQUEST['mid'];
$uid         = $_REQUEST['uid'];
$result_type = $_REQUEST['result_type'];

$sql = "select id from web_sytnet where uid='$uid' and uid<>'' and status=1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$date_start	=	cdate($date_start);
$date_end		=	cdate($date_end);
$where			=	get_report($gtype,$wtype,$result_type,$report_kind,$date_start,$date_end);

switch ($pay_type){
case "0":
	$credit="block";
	$sgold="block";
	break;
case "1":
	$credit="block";
	$sgold="block";
	break;
case "":
	$credit="block";
	$sgold="block";
	break;
}

$wager_vars_re=array('正常注单',
										'非正常注单',
										'进球取消',
										'红卡取消',
										'赛事腰折',
                    '赛事延期',
										'赔率错误',
                    '赛事无pk/加时',
                    '球员弃权',
                    '队名错误',
										'确认注单',
										'未确认注单',
										'取消');
$match_status=array('','賽事取消',
'赛事延期',
'赛事腰折',
'赛事无pk/加时',
'球员弃权',
'队名错误','先发投手更换');

$sql = "select agents from web_member where memname='$mid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$aid=$row['agents'];

$sql="select odd_type,mid,showtype,active,status,corpor_point,date_format(BetTime,'%m%d%H%i%s')+id as ID,Agents,BETIP,id,result_type,danger,QQ526738,LineType,cancel,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,OpenType,M_Result,TurnRate,M_Name,bettype1 as BetType, Middle,BetScore,a_result,agent_point,world_point from web_db_io where ".$where." and M_Name='$mid' order by orderby,BetTime desc";

?>
<html style="width: 98%;margin: 0 auto;">
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
<SCRIPT language=javaScript src="/js/report_func.js" type=text/javascript></SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<FORM NAME="LAYOUTFORM" ACTION="" METHOD=POST>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="750" class="m_tline">&nbsp;&nbsp;报表管理: <?=$aid?>--<font color="#CC0000"><?=$mid?></font>&nbsp;&nbsp;&nbsp;&nbsp;日期管理:<?=$date_start?>~<?=$date_end?>
        -- 下注管道：网络下注 -- <a href="javascript:history.go( -2 );">回上一页</a> -- <a href="./report.php?uid=<?=$uid?>">回报表查询</a></td>
      <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr>
      <td colspan="2" height="4"></td>
    </tr>
  </table>
<table width="1000" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">
  <tr class="m_title" >
    <td width="70" > 时间</td>
    <td width="90"> 退水</td>
    <td width="130"> 球赛种类</td>
    <td width="330"> 内容</td>
    <td width="90"> 金额</td>
    <td width="120"> 结果</td>
    <td width="60"> 代理商<br>(占成)</td>
    <td width="60"> 总代理<br>(占成)</td>
    <td width="60"> 股东<br>(占成)</td>
    <td width="60">大股东<br>(占成)</td>
    <td width="60">BETIP</td>
    </tr>
	<?
	$ncount=0;
	$score=0;
	$win=0;
	$result = mysql_query($sql);
	$cou=mysql_num_rows($result);

	while ($row = mysql_fetch_array($result)){
		$ncount+=1;
		$score+=$row['BetScore'];
		$awin+=$row['a_result'];
		$win+=$row['M_Result'];
		$middle=$row['Middle'];
  ?>
  <tr class="m_rig" onMouseOver="setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');" onMouseOut="setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');">
    <td align="center"><?
if($row['danger']>0){
	echo '<font color=#ffffff style=background-color:#ff0000>'.$row['BetTime'].'</font>';
}else{
	echo $row['BetTime'];
}
?>

</td>
    <td align="center"><?=$row['M_Name']?><font color="#CC0000"> <?=$row['TurnRate']?></font></td>
    <td align="center"><font color=green><?=$ODDS[$row['odd_type']]?></font><?=substr(show_voucher($row['LineType'],$row['ID']),2)?><br><?
	$bet=str_replace("半全场","$$",$row['BetType']);
	$bet=str_replace("半场"," 半场",$bet);
	$bet=str_replace("全场"," ",$bet);
	$bet=str_replace("-","",$bet);
	$bet=str_replace("$$","半全场",$bet);
	echo $bet;
			switch($row['danger']){
			case 1:
				echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;'.$zzqrzd.'&nbsp;</b></font></font>';
				break;
			/*case 2:
				echo '<br><font color=#ffffff style=background-color:#ff0000><b>'.$wqrzd.'</b></font></font>';
				break;
			case 3:
				echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;'.$Confirm.'&nbsp;</b></font></font>';
				break;
			default:
				break;*/
			}
			?>
</td>
    <td><?
    	//echo $row['QQ526738'];
	if ($row['LineType']==7 or $row['LineType']==8 or $row['LineType']==17){
		$midd=explode('<br>',$row['Middle']);
		$ball=explode('<br>',$row['QQ526738']);

		for($t=0;$t<(sizeof($midd)-1)/2;$t++){
			echo $midd[2*$t].'<br>';
			if($row['result_type']==1){
				echo '<font color="#009900"><b>'.$ball[$t].'</b></font>  ';
			}
			echo $midd[2*$t+1].'<br>';
		}
	}else{
		$midd=explode('<br>',$row['Middle']);
		for($t=0;$t<sizeof($midd)-1;$t++){
			echo $midd[$t].'<br>';
		}
		if($row['result_type']==1){
			echo '<font color="#009900"><b>';
								if(strlen($row['QQ526738'])<3){
									echo $match_status[$row['QQ526738']];
								}else{
									echo $row['QQ526738'];
								}
								echo '</b></font>  ';
								//echo '<font color="#009900"><b>'.$row['QQ526738'].'</b></font>  ';
		}else{
			echo getscore($row['mid'],$row['active'],$row['showtype'],$row['LineType'],$dbname);
		}
		//echo str_replace(';<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp','', str_replace(';<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp','', $midd[sizeof($midd)-1]));
		echo  $midd[sizeof($midd)-1];
	}
	?>
  </td>
     <td><?
    	if($row['status']>0){
    		echo '<s>'.number_format($row['BetScore'],1).'</s>';
    	}else{
    		echo number_format($row['BetScore'],1);
    	}?></td>

      <td>
      <?
    	if($row['status']>0){
    		echo '<b><font color=red>['.$wager_vars_re[$row['status']].']</td>';
    	}else{
    		echo number_format($row['M_Result'],1);
    	}
    	?>
		</td>
	<td><?=$row['agent_point']?></td>
    <td><?=$row['world_point']?></td>
    <td><?=$row['corpor_point']?></td>
    <td><?=100-$row['agent_point']-$row['world_point']-$row['corpor_point']?></td>
    <td><?=$row['BETIP']?><br>
	<a href='/control/system/showlog.php?uid=<?=$uid?>&level=3&agents_id=<?=$row['Agents']?>&ip=<?=$row['BETIP']?>' target=_blank>IP對比</a></td>

  </tr>
 <?
 }
 ?>
  <tr class="m_rig_re">
   	  <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td ><?=$ncount?></td>
      <td ><?=number_format($score,1)?></td>
      <td bgcolor="#000033"><font color="#FFFFFF"><?=number_format($win,1)?></font></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
<table width="780" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="15"></td>
</tr>
</table>

<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">
  <tr class="m_title_2" >
    <td width="50"></td>
    <td width="90"></td>
    <td width="90">代理商</td>
    <td width="310">筆數</td>
      <td width="120">金額</td>
      <td width="120">結果</td>
    </tr>
  <tr class="m_rig">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><?=$aid?></td>
      <td><?=$ncount?></td>
      <td><?=number_format($score,1)?></td>
      <td><?=number_format($awin,1)?></td>
    </tr>
  </table>
</form>
</body>
</html>