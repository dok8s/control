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
//$gdate		=	$_REQUEST["gdate"];

//if($gdate==''){$gdate=date('Y-m-d');}

$gtype	=	$_REQUEST['gtype'];
$voucher=strtoupper($_REQUEST["voucher"]);
$sql = "select id,subuser,agname,subname,status from web_super where Oid='$uid'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
$agname=$row['agname'];

$search=$_REQUEST['search'];
$search_value=$_REQUEST['search_data'];

$date_s=$_REQUEST['date_start'];
$date_e=$_REQUEST['date_end'];
if ($date_s==''){
	$date_s=date('Y-m-d')." 00:00:00";
	$date_e=date('Y-m-d H:i:s');
}
if($search_value<>""){
switch($search){
case 2: 
	$sql=" corprator='$search_value' and";
	break;
case 3:
	$sql=" world='$search_value' and";
	break;
case 4:
	$sql=" agents='$search_value' and";
	break;
case 5:
	$sql=" m_name='$search_value' and";
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
	$sql=" result_type=1 and";
	break;
case 8:
	$sql=" bettime='$search_value' and";
	break;
}
}else{$sql="";}
$tt=$sql." BetTime >='".$date_s."' and BetTime<='".$date_e."'" ;
$mysql="select QQ526738,result_type,danger,cancel,id,mid,linetype,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as bid,M_Name,TurnRate,BetType,M_result,Middle,BetScore,gwin from web_db_io where $tt order by bettime desc";
$result = mysql_db_query($dbname, $mysql);

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
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

	self.location.href='real_list.php?uid=<?=$uid?>&search=<?=$search?>&search_data=<?=$search_value?>&gdate=<?=$gdate?>&date_start=<?=$date_s?>&date_end=<?=$date_e?>';
}
</script></head>
<SCRIPT>window.setTimeout("reload()", 60000);</SCRIPT>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()";>
<form name=FTR action="" method=post>
<table width="880" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="850">&nbsp;线上操盘－
      	<input name=button type=button class="za_button" onClick="reload()" value="更新"><font color="#cc0000">請輸入查詢条件:</font>
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
					投注日期:
					<input type=TEXT name="date_start" value="<?=$date_s?>" size=19 maxlength=19 class="za_text">&nbsp;至&nbsp;
					<input type=TEXT name="date_end" value="<?=$date_e?>" size=19 maxlength=19 class="za_text">

					<INPUT class=za_button type=submit value=查詢 name=SUBMIT>
        	</td>
					<td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">
 <tr class="m_title_ft">
  <td width="70"align="center">投注时间</td>
  <td width="100" align="center">流水单号</td>
  <td width="100" align="center">用户名称</td>
  <td width="100" align="center">球赛种类</td>
  <td width="230" align="center">內容</td>
  <td width="70" align="center">投注</td>
  <td width="70" align="center">可赢金额</td>
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
							$ball=explode('<br>',$row['QQ526738']);

							for($t=0;$t<(sizeof($midd)-1)/2;$t++){
								echo $midd[2*$t].'<br>';
								if($row['result_type']==1){
									echo '<font color="#009900"><b>'.$ball[$t].'</b></font>  ';
															}else{
								echo getscore($row['mid'],$row['active'],$row['showtype'],$row['LineType'],$dbname);
}
								echo $midd[2*$t+1].'<br>';
							}
						}else{
							$midd=explode('<br>',$row['Middle']);
							for($t=0;$t<sizeof($midd)-1;$t++){
								echo $midd[$t].'<br>';
							}
							if($row['result_type']==1){
								echo '<font color="#009900"><b>'.$row['QQ526738'].'</b></font>  ';
							}
							echo $midd[sizeof($midd)-1];
						}
						?></td>
          <td align="center"><?=$row['BetScore']?></td>
          <td align="center"><?=$row['gwin']?></td>
          <td align="center"><?=number_format($row['M_result'],1)?></td>
        </tr>
<?
}
?>
</table>
</BODY>
</html>

</html>