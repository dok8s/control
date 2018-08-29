<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$enable=$_REQUEST["enable"];
$enabled=$_REQUEST["enabled"];
$sort=$_REQUEST["sort"];
$orderby=$_REQUEST["orderby"];
$mid=$_REQUEST["id"];
$active=$_REQUEST["active"];
$page=$_REQUEST["page"];
if ($page==''){	$page=0;}
if ($enable==""){	$enable='Y';}

if ($sort==""){	$sort='alias';}

if ($orderby==""){	$orderby='asc';}

if ($enable=="Y"){
	$enabled=1;
	$memstop='N';
	$stop=1;
	$start_font="";
	$end_font="";
	$caption1='停用';
	$caption2='启用';
}else{
	$enable='N';
	$memstop='Y';
	$enabled=0;
	$stop=0;
	$start_font="";
	$end_font="</font>";
	$caption2="<SPAN STYLE='background-color: rgb(255,255,0);'>停用</SPAN>";
	$caption1='启用';
}
switch ($active){
case 2:
	$mysql="update web_member set Status=$stop where id=$mid";
	mysql_db_query($dbname, $mysql);
	break;
case 3:
	$sql="update web_member set hidden=0 where id=$mid";
	mysql_db_query($dbname, $sql);
	break;
}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title {  background-color: #FEF5B5; text-align: center}
-->
</style>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<SCRIPT language="javascript" src="/js/member.js"></script>
<SCRIPT>

 function onLoad()
 {
  //var obj_sagent_id = document.getElementById('agent_id');
  //obj_sagent_id.value = '<?=$agid?>';
  var obj_enable = document.getElementById('enable');
  obj_enable.value = '<?=$enable?>';
  var obj_page = document.getElementById('page');
  obj_page.value = '<?=$page?>';
  var obj_sort=document.getElementById('sort');
  obj_sort.value='<?=$sort?>';
  var obj_orderby=document.getElementById('orderby');
  obj_orderby.value='<?=$orderby?>';
 }
// -->
</SCRIPT>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()";>
<FORM NAME="myFORM" ACTION="wager_hide.php?uid=<?=$uid?>" METHOD=POST>
<input type="hidden" name="agent_id" value="<?=$agid?>">
<?
$sql = "select passwd,ID,Memname,pay_type,money,Alias,Credit,ratio,date_format(AddDate,'%m-%d / %H:%i') as AddDate,pay_type,Agents,OpenType from web_member where hidden=1 and Status=$enabled order by ".$sort." ".$orderby;
$result = mysql_db_query($dbname, $sql);
$cou=mysql_num_rows($result);
$page_size=15;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_db_query($dbname, $mysql);
?>
<table width="775" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td>&nbsp;&nbsp;改单会员            <select name="enable" onChange="self.myFORM.submit()" class="za_select" >
                <option value="Y" >启用</option>
                <option value="N" >停用</option></td>

            <td width="40"> -- 排序</td>
            <td>
              <select id="super_agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="alias">会员名称</option>
                <option value="memname">会员帐号</option>
                <option value="adddate">加入日期</option>
              </select>
              <select id="enable" name="orderby" onChange="self.myFORM.submit()" class="za_select">
                <option value="asc">升幂(由小到大)</option>
                <option value="desc">降幂(由大到小)</option>
              </select>
            </td>
            <td width="52"> -- 总页数:</td>
            <td>
              <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
		<?
		for($i=0;$i<$page_count;$i++){
			echo "<option value='$i'>".($i+1)."</option>";
		}
		?>

              </select>
            </td>
            <td> / <?=$page_count?> 页 -- </td>
            <td>
              <input type=BUTTON name="append" value="新增" onClick="document.location='./mem_add.php?uid=<?=$uid?>&keys=hidden'" class="za_button">
            </td>
          </tr>
        </table>
	</td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
</tr>
<tr>
	<td colspan="2" height="4"></td>
</tr>
</table>
<?
if ($cou==0){
?>
  <table width="775" border="0" cellspacing="1" cellpadding="0"  bgcolor="E3D46E" class="m_tab">
    <tr class="m_title">
      <td height="30" ><?=$mem_nomem?></td>
    </tr>
  </table>
<?
}else{
 ?>
  <table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="E3D46E" class="m_tab">
    <tr class="m_title">
      <td width="60">会员名称</td>
      <td width="70">会员帐号</td>
      <td width="60">密码</td>
	  <td width="110">信用额度</td>
	  <td width="30">盘口</td>
      <td width="80">新增日期</td>
      <td width="70">使用状况</td>
      <td width="240">功能</td>
    </tr>
<?
	while ($row = mysql_fetch_array($result)){
	?>
<tr class="m_cen">
      <td><?=$start_font?><?=$row['Alias'];?><?=$end_font?></td>
      <td><?=$start_font?><?=$row['Memname'];?><?=$end_font?></td>
<td><?=$start_font?><?=$row['passwd'];?><?=$end_font?></td>
	  <td align="right">
      <p align="right"><?=$start_font?><? if ($row['pay_type']==1){
	echo number_format($row['money']*$row['ratio'],2);
	}else{
	echo number_format($row['Credit']*$row['ratio'],2);
	}?>
<?=$end_font?></td>
      <td><?=$start_font?><?=$row['OpenType']?><?=$end_font?></td>
	  <td><?=$row['AddDate'];?></td>
	  <td><?=$caption2?></td>
      <td align="left"><font color="#0000FF"><a style="cursor: hand">
		&nbsp;&nbsp;<a href="javascript:CheckSTOP('wager_hide.php?uid=<?=$uid?>&active=2&id=<?=$row['ID']?>&enable=<?=$memstop?>')"><?=$caption1?></a>&nbsp;
        /&nbsp; <a href="javascript:CheckDEL('wager_hide.php?uid=<?=$uid?>&active=3&id=<?=$row['ID']?>')">删除</a>&nbsp; /&nbsp; <a href="hide_list.php?uid=<?=$uid?>&username=<?=$row['Memname']?>">详细投注</a></td>
    </tr>
<?
	}
?>
	</table>
</form>

<?
}
?>
</body>
</html>