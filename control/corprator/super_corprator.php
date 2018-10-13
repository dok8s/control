<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
require( "../system/caozuoma.php" );

$uid=$_REQUEST["uid"];
$sql = "select Agname,ID,language from web_super where Oid='$uid'";

$result = mysql_query($sql);
$cou=mysql_num_rows($result);


$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
$langx='zh-cn';
require ("../../member/include/traditional.$langx.inc.php");
$super_agents_id=$_REQUEST["super_agents_id"];
$enable=$_REQUEST["enable"];
$enabled=$_REQUEST["enabled"];
$sort=$_REQUEST["sort"];
$active=$_REQUEST["active"];
$orderby=$_REQUEST["orderby"];
$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
$mid=$_REQUEST["mid"];

if ($enable==""){
$enable='Y';
}

if ($sort==""){
	$sort='Alias';
}

if ($orderby==""){
	$orderby='asc';
}

if ($enable=="Y")
{
	$enabled=1;
	$memstop='N';
    $memstop1='S';
	$stop=1;
	$start_font="";
	$end_font="";
	$caption1=$mem_disable;
	$caption2=$mem_enable;
	$caption3="暂停";
}else if ($enable=="S"){
	$enabled=2;
	$memstop='Y';
	$memstop1='Y';
	$stop=2;
	$start_font="";
	$end_font="";
	$caption2="<SPAN STYLE='background-color: #00FF00;'>暂停</SPAN>";
	$caption3="启用";
	//$caption4="启用";
}elseif($enable=="DEL"){
	$enabled=9;
	$memstop='Y';
	$memstop1='Y';
	$stop=1;
	$start_font="";
	$end_font="";
	$caption1="启用";
	$caption2="<SPAN STYLE='background-color:#FF0000;'>已删除</SPAN>";
	$caption3="暂停";
}else{
	$enable='N';
	$memstop='Y';
	$enabled=0;
	$stop=0;
	//$start_font="<font color=#999999>";
	$start_font="";
	$end_font="</font>";
	$caption2="<SPAN STYLE='background-color: rgb(255,255,0);'>$mem_disable</SPAN>";
	$caption1=$mem_enable;
	$caption3="";
}

if ($active==2){
	$mysql="update web_corprator set Status=$stop where ID=$mid";
	mysql_query($mysql);
	
	$mysql="select agname from web_corprator where ID=$mid";
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agname=$row['agname'];

	$mysql="update web_world set Status=$stop where corprator='$agname'";
	mysql_query($mysql);
	$mysql="update web_agents set Status=$stop where corprator='$agname'";
	mysql_query($mysql);
	$mysql="update web_member set Status=$stop where corprator='$agname'";
	mysql_query($mysql);
	
}elseif($active==3){
	if(!ck_caozuoma($_REQUEST['czm'])){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
		<script language='javascript'>alert('操作码不正确，无法删除！');</script>";
		exit;
	}else{
	$mysql="select agname from web_corprator where ID='$mid'";
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agname=$row['agname'];

	$mysql="delete from web_corprator where id='$mid'";
	mysql_query($mysql);
	
	$mysql="delete from web_world where corprator='".$agname."'";
	mysql_query($mysql);
	$mysql="delete from web_agents where corprator='".$agname."'";
	mysql_query($mysql);
	$mysql="delete from web_member where corprator='".$agname."'";

	mysql_query($mysql);
	//$mysql="delete from web_db_io where corprator='".$agname."'";

	//mysql_query($mysql);
	}
}

?>
<html style="width: 98%;margin: 0 auto;">
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_title_sucor {  background-color: #429CCD; text-align: center}
-->
</style>

<SCRIPT language=javaScript src="/js/corprator<?=$body_js?>.js" type=text/javascript></SCRIPT>
<SCRIPT language=javaScript>
<!--
 function onLoad()
 {
  var obj_sagent_id = document.getElementById('super_agents_id');
  obj_sagent_id.value = '<?=$super_agents_id?>';
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
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad();">
<form name="myFORM" action="super_corprator.php?uid=<?=$uid?>" method=POST>
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline"> 
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr> 
            <td>&nbsp;&nbsp;股东管理:</td>
            <td><select class=za_select id=super_agents_id onchange=document.myFORM.submit(); name=super_agents_id>
				<option value="" selected><?=$rep_pay_type_all?></option> 
				<?
	$mysql = "select ID,Agname from web_super where Status=1  and subuser=0";
	$ag_result = mysql_query( $mysql);
				while ($ag_row = mysql_fetch_array($ag_result)){
					if ($super_agents_id==$ag_row['Agname']){
						echo "<option value=".$ag_row['Agname']." selected>".$ag_row['Agname']."</option>";				
						$sel_agents=$ag_row['Agname'];
					}else{
						echo "<option value=".$ag_row['Agname'].">".$ag_row['Agname']."</option>";
					
					}
				}
				?>
			</select> 
              <select id="enable" name="enable" onChange="self.myFORM.submit()" class="za_select">
                <option value="Y"><?=$mem_enable?></option>
                <option value="N"><?=$mem_disable?></option>
				<option value="S">暂停</option>
				<option value="DEL">已删除</option>
              </select>
            </td>
            <td> -- <?=$mem_orderby?>:</td>
            <td>
              <select id="super_agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="Alias"><?=$cor_name1?></option>
                <option value="Agname"><?=$cor_user?></option>
                <option value="AddDate"><?=$mem_adddate?></option>
              </select>
              <select id="enable" name="orderby" onChange="self.myFORM.submit()" class="za_select">
                <option value="asc"><?=$mem_order_asc?></option>
                <option value="desc"><?=$mem_order_desc?></option>
              </select>
            </td>
            <td width="52"> -- <?=$mem_pages?>:</td>
            <td> 
              <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
              <option value="0">1</option>
              </select>
            </td>
            <td> / 1 <?=$mem_page?> </td>
            <td> <!--
              <input type=BUTTON name="append" value="<?=$mem_add?>" onClick="document.location='super_corprator_add.php?uid=<?=$uid?>'" class="za_button"> -->
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
if ($super_agents_id==''){
	$sql = "select passwd,ID,Agname,passwd_safe,Alias,Credit,AgCount,date_format(AddDate,'%Y-%m-%d %H:%i:%s') as AddDate, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate,super from web_corprator where Status=$enabled and subuser='0' order by ".$sort." ".$orderby;
}else{
	$sql = "select passwd,ID,Agname,passwd_safe,Alias,Credit,AgCount,date_format(AddDate,'%Y-%m-%d %H:%i:%s') as AddDate, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate,super from web_corprator where super='".$super_agents_id."'and subuser='0'and Status='$enabled' order by ".$sort." ".$orderby;

}
$result = mysql_query( $sql) or exit(mysql_error());
$cou=mysql_num_rows($result);

if ($cou==0){
?>
  <table width="770" border="0" cellspacing="1" cellpadding="0"  bgcolor="0E75B0" class="m_tab">
    <tr class="m_title"> 
      <td height="30" class="m_title_sucor" >
        <?=$mem_nomem?>
      </td>
    </tr>
  </table>
<?
}else{
 ?>
  <table width="" border="0" cellspacing="1" cellpadding="0"  bgcolor="0E75B0" class="m_tab">
      <tr class="m_title_sucor"  bgcolor="#429CCD"> 
      <td width="80">股东名称</td>
      <td width="80">股东帐号</td>
	  <td width="60">安全代码</td>
	  <td width="80">密码</td>
	  <td width="80">信用额度</td>
      <td width="60">总代理数</td>
      <td width="130">新增日期</td>
      <td width="130">到期时间</td>
	  <td width="100">上级</td>
      <td width="64">使用状况</td>
      <td width="230">功能</td>
    </tr>
	<?
	while ($row = mysql_fetch_array($result)){
		$sql = "select count(*) as AgCount from web_world where subuser=0 and corprator='".$row['Agname']."'";
		$cresult = mysql_query( $sql);
		$crow = mysql_fetch_array($cresult);
		$row['AgCount'] = $crow['AgCount'];
		
		$class = 'm_cen';
		if($row['enddate']=='0000-00-00 00:00:00'){
			$row['enddate']='永不过期';
		}
		elseif(strtotime($row['enddate']) < time()){
			$class = 'm_cen_red';
		}
	?>
    <tr  class="<?=$class?>"> 
      <td><?=$row['Alias']?></td>
      <td><?=$row['Agname']?></td>
      <td><?=$row['passwd_safe']?></td>
      <td><font color=red><?=$row['passwd']?></font></td>
	  <td align="right"><?=$row['Credit']?></td>
      <td><?=$row['AgCount']?></td>
      <td><?=$row['AddDate']?></td>
	  <td><?=$row['super']?></td>
      <td><?=$row['enddate']?></td>
      <td><?=$caption2?></td>
      <td align="left"><!--<a style="cursor:hand;" onClick="show_win('34418','yya000');"><font color="#0000FF">结帐</font></a> 
        / <a style="cursor:hand;" onClick="show_win1('34418','yya000');"><font color="#0000FF">回复</font></a>
        /  --><a href="javascript:CheckSTOP('super_corprator.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=<?=$memstop?>','<?=$memstop?>')"><?=$caption1?></a> /
		<? if ($enable!="N"){?>
		<a href="javascript:CheckSTOP('super_corprator.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=<?=$memstop1?>','<?=$memstop1?>')"><?=$caption3?></a> /
		<?
		}
		?>
         <a href="super_corprator_edit.php?uid=<?=$uid?>&id=<?=$row['ID']?>&super_agents_id=<?=$agid?>"><?=$mem_acount?></a> 
        / <a href="super_corprator_set.php?uid=<?=$uid?>&id=<?=$row['ID']?>&super_agents_id=<?=$agid?>"><?=$mem_setopt?></a>
		/ <a href="javascript:CheckDEL('super_corprator.php?uid=<?=$uid?>&mid=<?=$row['ID']?>&active=3')"><?=$mem_delete?></a>
      </td>
    </tr>
<?
}
}
?>  
</table>  
  </table>
</form>

<!----------------------回复视窗---------------------------->
</body>
</html>