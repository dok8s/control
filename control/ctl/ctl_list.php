<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
require ("../../inc/wager_edit.inc.php");
$active	=	$_REQUEST['active'];
$uid		=	$_REQUEST['uid'];
$id			=	intval($_REQUEST['id']);
$gid		=	intval($_REQUEST['gid']);
$gtype	=	$_REQUEST['gtype'];
$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

if($active==10 && $id>0){
	$sql="update web_db_io set danger=3,status=10,result_type=0 where id='$id'";
	wager_update( $sql, $id);
}elseif($active==11 && $id>0){
	$sql="update web_db_io set danger=2,status=11,result_type=0 where id='$id'";
	wager_update( $sql, $id);
}elseif($active!='' && $id>0){
	$sql="update web_db_io set status='$active',result_type=0 where id='$id'";
	wager_update( $sql, $id);
}

$mysql="select mid,MB_Team,TG_Team,MB_Inball,MB_Inball_HR,TG_Inball,TG_Inball_HR from foot_match where mid='$gid'";
$result1 = mysql_query( $mysql);
$mrow = mysql_fetch_array($result1);
$mysql="select odd_type,status,QQ526738,result_type,danger,cancel,id,mid,linetype,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as bid,M_Name,TurnRate,BetType,M_result,Middle,BetScore from web_db_io where FIND_IN_SET($gid,mid)>0 and hidden=0 order by bettime,linetype,mtype";
$result = mysql_query( $mysql);
?>
<HTML style="width: 98%;margin: 0 auto;">
<HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/css.css" type="text/css">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<META content="Microsoft FrontPage 4.0" name=GENERATOR>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<table width="880" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <td class="m_tline" width="744">注单核查 --主队：
			<?=$mrow['MB_Team']?>上半场:<font color=red>(<?=$mrow['MB_Inball_HR']?>)</font>全场:<font color=red>(<?=$mrow['MB_Inball']?>)</font>客队：<?=$mrow['TG_Team']?>上半场:<font color=red>(<?=$mrow['TG_Inball_HR']?>)</font>全场:<font color=red>(<?=$mrow['TG_Inball']?>)
			<font color="#cc0000">&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:history.go( -1 );">回上一页</a>&nbsp;&nbsp;</font></font></td>
    <td width="32"><img src="/images/control/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="2" height="4" width="778">
	<table width="769" border="0" align="left" cellPadding="0" cellSpacing="0" background="/images/body_title_ph12b.gif" class="b_title">
	  <tbody>
	    <tr>
	       <td width="394"><div align="right"></div></td>
	       <td width="375">&nbsp;</td>
	    </tr>
	  </tbody>
	</table>
    </td>
  </tr>
</table>
  <table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab" width="95%">
    <tr class="m_title_ft">
          <td width="50">投注时间</td>
          <td width="100">流水单号</td>
          <td width="100">用户名称</td>
          <td width="100">球赛种类</td>
          <td width="330">內容</td>
          <td width="100">投注</td>
          <td width="100">会员结果</td>
          <td width="120">注单状态</td>
        </tr>
        <?
					while ($row = mysql_fetch_array($result)){
				?>
        <tr class="m_rig">
          <td align="center"><?=$row['BetTime']?></td>
 					<td align="center"><?=show_voucher($row['linetype'],$row['bid'])?><br><font color=green><?=$ODD[$row['odd_type']]?></font></td>
          <td align="center"><?=$row['M_Name']?>&nbsp;&nbsp;<font color="#cc0000"> <?=$row['TurnRate']?></font></td>
          <td align="center"><?=$row['BetType']?>
          <?
					switch($row['danger']){
					case 1:
						echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认中&nbsp;</b></font></font>';
						break;
					case 2:
						echo '<br><font color=#ffffff style=background-color:#ff0000><b>未确认</b></font></font>';
						break;
					case 3:
						echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认&nbsp;</b></font></font>';
						break;
					default:
						break;
					}
					?></td>
					<td align="right">
						<?
						if ($row['linetype']==7 or $row['linetype']==8 or $row['linetype']==17){
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
							}
							echo $midd[sizeof($midd)-1];
						}
if($row['linetype']==9 || $row['linetype']==10 || $row['linetype']==19 || $row['linetype']==30){
						$wager=$wager_vars_re;
					}else if($row['linetype']==7 || $row['linetype']==8){
						$wager=$wager_vars_p;
					}else{
						$wager=$wager_vars;
					}

						?></td>
          <td align="center"><?=$row['BetScore']?></td>
          <td align="center"><?=number_format($row['M_result'],1)?></td>
          <td align="left">
          <DIV class=menu2 onMouseOver="this.className='menu1'" onMouseOut="this.className='menu2'">
          <div align="center"><FONT color=red><b><?=$wager[$row['status']]?><b></FONT></div>
          <UL style="LEFT: 28px">
					<?

					
					while (list($key, $value) = each($wager)) {
						if($value<>''){
					?>
             <LI><A href="ctl_list.php?uid=<?=$uid?>&gid=<?=$gid?>&id=<?=$row['id']?>&active=<?=$key?>&gtype=<?=$gtype?>" target=_self><?=$value?></A>
					<?
						}
					}
					?>
					</UL>
					</DIV>
					</td>
        </tr>
				<?
				}
				?>

</table>

</BODY>
</html>
