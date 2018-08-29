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

$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

if($active==10){
	$sql="update web_db_io set danger=3,status=10,result_type=0 where id=$id";
	mysql_db_query($dbname, $sql);
}else if($active==11){
	$sql="update web_db_io set danger=2,status=11,result_type=0 where id=$id";
	mysql_db_query($dbname, $sql);
}else if($active<>''){
	$sql="update web_db_io set status=$active,result_type=0 where id=$id";
	mysql_db_query($dbname, $sql);
	echo "<script language='javascript'>self.location='./aceept.php?uid=$uid';</script>";
}

$sql = "select status,danger,id,M_Name,TurnRate,cancel,M_Date,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,LineType,BetType,Middle,BetScore,Gwin from web_db_io where status>0 and m_date='$gdate' and hidden=0 order by ".$sort." ".$orderby;

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

	self.location.href='aceept.php?uid=<?=$uid?>&gdate=<?=$gdate?>&page=<?=$page?>';
}
</script>
<SCRIPT>window.setTimeout("self.location.href='aceept.php?uid=<?=$uid?>&gdate=<?=$gdate?>&result=<?=$result_type?>&sort=<?=$sort?>&orderby=<?=$orderby?>&page=<?=$page?>&danger=<?=$danger?>'", 60000);</SCRIPT>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" onLoad="onLoad()">
<form name="myFORM" method="post" action="aceept.php?uid=<?=$uid?>">
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td>&nbsp;</td>
    <td class="m_tline">异常注单 --
	  <input name=button type=button class="za_button" onClick="reload()" value="更新"></td>
    <td class="m_tline">日期:
        <select class=za_select onchange=document.myFORM.submit(); name=gdate>
				<option value=""></option>
				<?
$dd = 24*60*60;
$t = time();
$aa=0;
$bb=0;
for($i=0;$i<=7;$i++)
{
	$today=date('Y-m-d',$t);
	if ($date_start==date('Y-m-d',$t)){
		echo "<option value='$today' selected>".date('Y-m-d',$t)."</option>";
	}else{
		echo "<option value='$today'>".date('Y-m-d',$t)."</option>";
	}
$t -= $dd;
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
<table width="90%" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">

        <tr class="m_title_ft">
          <td width="120">投注时间</td>
          <td width="120" >流水号</td>
          <td width="120">用户名称</td>
          <td width="120" align="center">球赛种类</td>
          <td width="450" align="center">內容</td>
          <td width="120" align="center">投注</td>
          <td width="120" align="center">可赢金额</td>
        </tr>
				<?
				while ($row = mysql_fetch_array($result)){
					
					if($row['LineType']==9 || $row['LineType']==10 || $row['LineType']==19 || $row['LineType']==30){
						$wager=$wager_vars_re;
					}else if($row['LineType']==7 || $row['LineType']==8 || $row['LineType']==17){
						$wager=$wager_vars_p;
					}else{
						$wager=$wager_vars;
					}
					
				?>
				<tr class="m_rig">
          <td align="center"><?=$row['BetTime'];?></td>
	  			<td align="center"><?=show_voucher($row['LineType'],$row['ID'])?></td>
          <td align="center"><?=$row['M_Name']?>&nbsp;&nbsp;<font color="#cc0000"> <?=$row['TurnRate']?></font></td>
          <td align="center"><?=str_replace(" ","",$row['BetType']);?></td>
          <td align="right"><?=$row['ShowTop'];?><?=$row['Middle'];?></td>
          <td align="center"><?=number_format($row['BetScore'],2);?></td>
          <td align="left">
          <DIV class=menu2 onMouseOver="this.className='menu1'" onMouseOut="this.className='menu2'">
          <div align="center"><FONT color=red><b><?=$wager[$row['status']]?><b></FONT></div>
          <UL style="LEFT: 28px">
					<?

					while (list($key, $value) = each($wager)) {
						if($value<>''){
					?>
             <LI><A href="aceept.php?uid=<?=$uid?>&id=<?=$row['id']?>&active=<?=$key?>" target=_self><?=$value?></A>
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
</form>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</BODY>
</html>