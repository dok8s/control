<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$active	=	$_REQUEST['active'];
$uid		=	$_REQUEST['uid'];
$id			=	$_REQUEST['id'];
$gdate		=	$_REQUEST["gdate"];

if($gdate==''){$gdate=date('Y-m-d');}

$gtype	=	$_REQUEST['gtype'];
$voucher=strtoupper($_REQUEST["voucher"]);
$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$search=$_REQUEST['search'];
$search_value=$_REQUEST['search_data'];

if($gdate==''){
	$gdate=date('Y-m-d');
}
if($active==10){
	$sql="update web_db_io set danger=3,status=10,result_type=0 where id=$id";
	mysql_db_query($dbname, $sql);
}else if($active==11){
	$sql="update web_db_io set danger=2,status=11,result_type=0 where id=$id";
	mysql_db_query($dbname, $sql);
}else{
	$sql="update web_db_io set status=$active,result_type=0 where id=$id";
	mysql_db_query($dbname, $sql);
}
switch($search){
case 2:
	$sql=" corprator='$search_value'";
	break;
case 3:
	$sql=" world='$search_value'";
	break;
case 4:
	$sql=" agents='$search_value'";
	break;
case 5:
	$sql=" m_name='$search_value'";
	break;
case 6:
	$voucher=strtoupper($search_value);
	if(substr($voucher,0,1)=='P'){
		if(substr($voucher,0,2)=='PR'){
			$id=substr($voucher,2,strlen($voucher)-2)+965782;
		}else{
			$id=substr($voucher,1,strlen($voucher)-1)+988782;
		}
	}else if(substr($voucher,0,2)=='OU'){
		$id=substr($voucher,2,strlen($voucher)-2);
	}else if(substr($voucher,0,2)=='DT'){
		$id=substr($voucher,2,strlen($voucher)-2)+902714;
	}
	$id=$id+100000000;
	$sql="	date_format(BetTime,'%m%d%H%i%s')+id=$id";
	break;
case 7:
	$sql=" result_type=1 ";
	break;
case 8:
	$sql=" bettime='$search_value' ";
	break;
}
$tt=" m_date='$gdate' and ".$sql;

$mysql="select gwin,status,qq10000,result_type,danger,cancel,id,mid,linetype,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as bid,M_Name,TurnRate,BetType,M_result,Middle,BetScore from web_db_io where $tt order by bettime desc";
$result = mysql_db_query($dbname, $mysql);

?>
<html style="width: 98%;margin: 0 auto;">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/css.css" type="text/css">
<style type="text/css">
<!--
.m_ag_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
<SCRIPT>
function onLoad()
 {
  var obj_enable = document.getElementById('search');
  obj_enable.value = '<?=$search?>';
 }
function reload()
{

	self.location.href='real_list_manage.php?uid=<?=$uid?>&search=<?=$search?>&search_data=<?=$search_value?>&gdate=<?=$gdate?>';
}
</script></head>
<SCRIPT>window.setTimeout("reload()", 60000);</SCRIPT>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()";>
<form name=FTR action="" method=post>
<table width="880" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="850">&nbsp;线上操盘－
      	<input name=button type=button class="za_button" onClick="reload()" value="更新">
    <font color="#cc0000">请输入查询条件:</font>
      	<select name="search" class="za_select">
            <option value="">不指定</option>
            <option value="2">股东</option>
            <option value="3">总代理</option>
            <option value="4">代理商</option>
            <option value="5">会员</option>
            <option value="6">注单号</option>
            <option value="7">已结算</option>
            <option value="8">投注时间</option>
          </select>
          <input type="text" size=16 name="search_data" value="<?=$search_value?>">
					投注日期
					<select name="gdate" class="za_select">
					<?
					$dd = 24*60*60;
					$t = time();
					for($i=0;$i<=7;$i++)
					{
						$today=date('Y-m-d',$t);
						if ($gdate==date('Y-m-d',$t)){
							echo "<option value='$today' selected>".date('Y-m-d',$t)."</option>";
						}else{
							echo "<option value='$today'>".date('Y-m-d',$t)."</option>";
						}
					$t -= $dd;
					}
					?>
          </select>

					<INPUT class=za_button type=submit value=查询 name=SUBMIT>
        	</td>
					<td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
    </tr>
      <tr>
    <td colspan="3" height="4"></td>
  </tr>
  </table>
</form>
<table width="920" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">
 <tr class="m_title_ft">
  <td width="70"align="center">投注时间</td>
  <td width="100" align="center">流水单号</td>
  <td width="100" align="center">用户名称</td>
  <td width="100" align="center">球赛种类</td>
  <td width="230" align="center">内容</td>
  <td width="60" align="center">投注</td>
  <td width="70" align="center">结果</td>
</tr>
        <?
					while ($row = mysql_fetch_array($result)){
						$url1='';
					?>
        <tr class="m_rig">
          <td align="center"><?=$row['BetTime']?></td>
 					<td align="center"><?=show_voucher($row['linetype'],$row['bid'])?></td>
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
						?>
					</td>
					<td align="right"><?
						if ($row['linetype']==7 or $row['linetype']==8){
							$midd=explode('<br>',$row['Middle']);
							$ball=explode('<br>',$row['qq10000']);

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
								echo '<font color="#009900"><b>'.$row['qq10000'].'</b></font>  ';
							}else{
								echo getscore($row['mid'],$row['active'],$row['showtype'],$row['LineType'],$dbname);
							}
							echo $midd[sizeof($midd)-1];
						}
						?></td>
           <td><?
    	if($row['status']>0){
    		echo '<s>'.number_format($row['BetScore'],1).'</s>';
    	}else{
    		echo number_format($row['BetScore'],1);
    	}?></td>

      <td>
      	<DIV class=menu2 onMouseOver="this.className='menu1'" onMouseOut="this.className='menu2'">
          <div align="center"><FONT color=red><b><?=$wager_vars[$row['status']]?><b></FONT></div>
          <UL style="LEFT: 28px">
					<?

					if($row['LineType']==9 || $row['LineType']==10 || $row['LineType']==19 || $row['LineType']==30 || $row['linetype']==51 || $row['linetype']==52){
						$wager=$wager_vars_re;
					}else if($row['LineType']==7 || $row['LineType']==8){
						$wager=$wager_vars_p;
					}else{
						$wager=$wager_vars;
					}
					while (list($key, $value) = each($wager)) {
						if($value<>''){
					?>
             <LI><A href="real_list_manage.php?uid=<?=$uid?>&id=<?=$row['id']?>&active=<?=$key?>&search_data=<?=$search_value?>&gdate=<?=$gdate?>&search=<?=$search?>" target=_self><?=$value?></A>
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

