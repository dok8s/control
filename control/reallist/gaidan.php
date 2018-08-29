<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid			=	$_REQUEST["uid"];
$id				=	$_REQUEST["id"];
$sort			=	$_REQUEST["sort"];
$gdate			=	$_REQUEST["gdate"];
$orderby	=	$_REQUEST["orderby"];
$page			=	$_REQUEST["page"]+0;
$danger		=	$_REQUEST["danger"]+0;
$active		=	$_REQUEST["active"];
$result_type		=	$_REQUEST["result"]+0;

if($gdate==''){$gdate=date('Y-m-d');}
if($danger==0){$danger=1;}

if ($sort==""){
	$sort='bettime';
}

if ($orderby==""){
	$orderby='desc';
}

$sql = "select * from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$sql="select G_Name,G_Type,edit,odd_type,status,date_format(BetTime,'%m%d%H%i%s')+id as WID,danger,QQ526738,result_type,cancel,id,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,M_Name,TurnRate,BetType,BetIP,M_result,Middle,BetScore,pay_type,linetype,hidden,Agents  from web_db_io where m_date='$gdate' and G_Name<>'' and  G_Type<>0 and G_Name<>'system' order by bettime desc,linetype,mtype";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);

$page_size=20;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";

$result = mysql_db_query($dbname, $mysql);

?>
<script>if(self == top) parent.location='/'</script>
<HTML>
<HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/css.css" type="text/css">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">

<META content="Microsoft FrontPage 4.0" name=GENERATOR>
<SCRIPT>

 function onLoad()
 {

  var obj_page = document.getElementById('page');
  obj_page.value = '<?=$page?>';
  //var obj_sort=document.getElementById('sort');
  //obj_sort.value='<?=$sort?>';
  //var obj_orderby=document.getElementById('orderby');
  //obj_orderby.value='<?=$orderby?>';
  var obj_orderby=document.getElementById('gdate');
  obj_orderby.value='<?=$gdate?>';
 //var obj_result=document.getElementById('result');
  //obj_result.value='<?=$result_type?>';

 //var obj_danger=document.getElementById('danger');
  //obj_danger.value='<?=$danger?>';

 }

 function Chk_acc(){
	rs_form.act.value='Y';
	close_win();
}

 function CheckSTOP(str)
{
if(confirm("确认更改本注单状态吗?"))
 		document.location=str;
	}
	function CheckDEL(str)
	{
		if(confirm("确实删除本注单吗?"))
		document.location=str;
	}
	function reload()
{

	self.location.href='gaidan.php?uid=<?=$uid?>&gdate=<?=$gdate?>&page=<?=$page?>';
}
</script>
<SCRIPT>window.setTimeout("self.location.href='gaidan.php?uid=<?=$uid?>&gdate=<?=$gdate?>&result=<?=$result_type?>&sort=<?=$sort?>&orderby=<?=$orderby?>&page=<?=$page?>&danger=<?=$danger?>'", 60000);</SCRIPT>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" onLoad="onLoad()">
<form name="myFORM" method="post" action="gaidan.php?uid=<?=$uid?>">
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td>&nbsp;</td>
    <td class="m_tline">改单注单 --
	  <input name=button type=button class="za_button" onClick="reload()" value="更新"></td>
    <td class="m_tline">日期:
        <select class=za_select onchange=document.myFORM.submit(); name=gdate>
		<?
		$sql1 = "select DATE_FORMAT(m_date,'%Y-%m-%d') as m_date from web_db_io where  G_Name<>'' and  G_Type<>0 group by m_date order by m_date";
		$result1 = mysql_query($sql1) or exit(mysql_error());
			$cou1=mysql_num_rows($result1);
			if ($cou1==0){
				echo "<option value='$gdate'>$gdate</option>";
			}else{
				while ($row1 = mysql_fetch_array($result1)){
					if ($gdate==$row1['m_date']){
						echo "<option value='".$row1['m_date']."' selected>".$row1['m_date']."</option>";
					}else{
						echo "<option value='".$row1['m_date']."'>".$row1['m_date']."</option>";
					}
				}
			}
		?>
				
			</select>
          <!--select name="result" onChange="self.myFORM.submit()" class="za_select">
            <option value="0">非法注单</option>
            <option value="1">取消</option>
          </select-->
</td>
        <td class="m_tline" align="right">显示第1-25条记录，共 <?=$cou?> 条记录　到第 <select name='page' onChange="self.myFORM.submit()">
<?
		if ($page_count==0){$page_count=1;}
		for($i=0;$i<$page_count;$i++){
			if ($i==$page){
				echo "<option selected value='$i'>".($i+1)."</option>";
			}else{
				echo "<option value='$i'>".($i+1)."</option>";
			}
		}
		?></select>
页，共 <?=$page_count?> 页 </td>
    <td width="33"><img src="/images/control/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="3" height="4"></td>
  </tr>
</table>
<table width="790" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">
 <tr class="m_title_ft">
          <td width="60"align="center">投注时间</td>
          <td width="80" align="center">用户名称</td>
          <td width="100" align="center">球赛种类</td>
          <td width="300" align="center">內容</td>
          <td width="70" align="center">投注</td>
          <td width="70" align="center">输赢</td>
		  <td width="70" align="center">改单类型</td>
		  <td width="200" align="center">改单用户</td>
  </tr>
       
				<?
			while ($row = mysql_fetch_array($result)){
				
				?>
        <tr class="m_rig<?=$css?>">
          <td align="center"><?=$row['BetTime']?></td>
          <td align="center"><?=$row['M_Name']?>&nbsp;&nbsp;<font color="#cc0000"> <?=$row['TurnRate']?></font><br><font color=blue><?=show_voucher($row['linetype'],$row['WID'])?><br><font color=green><?=$ODD[$row['odd_type']]?></font></td>
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
			<BR>(<?=$row['linetype']?>)
</td>
  <td align="right">
  <?
	if ($row['linetype']==7 or $row['linetype']==8){
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
			echo '<font color="#009900"><b>'.$row['QQ526738'].'</b></font>  ';
		}
		echo $midd[sizeof($midd)-1];
	}
if($row['linetype']==9 || $row['linetype']==10 || $row['linetype']==19 || $row['linetype']==30 || $row['linetype']==51 || $row['linetype']==52){
						$wager=$wager_vars_re;
					}else if($row['linetype']==7 || $row['linetype']==8){
						$wager=$wager_vars_p;
					}else{
						$wager=$wager_vars;
					}

	?>
	</td>
  <td align="center"><?=$row['BetScore']?></td>
  <td><?=number_format($row['M_result'],1)?></td>
 <td align="center"><font color="#FF0000">
 <?
 if($row['G_Type']==1){
 	echo "结算";
	}
	if($row['G_Type']==2){
 	echo "修改";
	}
	if($row['G_Type']==3){
 	echo "对调";
	}	
 ?>
 </font>
 </td>
  <td align="center"><font color="#FF0000"><?=$row['G_Name']?></font></td>
        </tr>
        <?
$gold+=$row['BetScore'];
$wingold+=$row['M_result'];
$mcount++;
}
?>

      </table>


</form>

</BODY>
</html>