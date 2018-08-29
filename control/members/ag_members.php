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
$sql = "select id from web_sytnet where uid='".$uid."'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	exit;
  echo "<script>window.open('/index.php','_top')</script>";
}

$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
$langx='zh-cn';
require ("../../member/include/traditional.$langx.inc.php");
$enable=$_REQUEST["enable"];
$enabled=$_REQUEST["enabled"];
$sort=$_REQUEST["sort"];
$orderby=$_REQUEST["orderby"];
$mid=$_REQUEST["id"];
$super_id=$_REQUEST['super_id'];
$corprator_id=$_REQUEST['corprator_id'];
$world_id=$_REQUEST['world_id'];
$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
$agent_id=$_REQUEST['agent_id'];
$active=$_REQUEST["active"];
if ($enable==''){
	$enable='Y';
}

if ($sort==""){
	$sort='Memname';
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
	$caption2="<SPAN STYLE='background-color: #FF0000;'>暂停</SPAN>";
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
switch ($active){
case 2:
	$mysql="update web_member set Status='$stop' where id='$mid'";
	mysql_query( $mysql);
	break;
case 3:
	if(!ck_caozuoma($_REQUEST['czm'])){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=gbk'>
		<script language='javascript'>alert('操作码不正确，无法删除！');</script>";
	}else{
		$mysql="select memname from web_world where ID='$mid'";
		$result = mysql_query( $mysql);
		$row = mysql_fetch_array($result);
		$memname=$row['memname'];

		$mysql="delete from web_report where m_name='".$memname."'";
		mysql_query($mysql);
		$sql="delete from web_member where id='$mid'";
		mysql_query( $sql);
	}
	break;
}

$sel_agents='';
if ($super_id==''){
	$super='';
}else{
	$super=" and super='$super_id'";
}

if ($corprator_id==''){
	$scorprator='';
}else{
	$scorprator=" and corprator='$corprator_id'";
}

if ($world_id==''){
	$aworld='';
}else{
	$aworld=" and world='$world_id'";
}

if ($agent_id==''){
	$sagent='';
}else{
	$sagent=" and agents='$agent_id'";
}


$abcd=$super.$scorprator.$aworld.$sagent;
if ($_GET['so_username']!=''){
	$abcd="  and (memname like '%$_GET[so_username]%' or loginname like '%$_GET[so_username]%')";
}
 $sql = "select ID,Memname,loginname,passwd,Alias,Credit,money,ratio,date_format(AddDate,'%Y / %m-%d') as AddDate,pay_type,OpenType,Agents,super,world,corprator, (oid!='' and oid!='out' and DATE_ADD(Active, INTERVAL 20 MINUTE)>now()) as online from web_member where Status='$enabled' ".$abcd." order by ".$sort." ".$orderby;
$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
//echo $sql;

$page_size=25;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_query( $mysql);
if ($cou==0){
	$page_count=1;
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
<SCRIPT language="javascript" src="/js/member_gb.js"></script>
<SCRIPT>

 function onLoad()
 {
  //var obj_super_id = document.getElementById('super_id');
  //obj_super_id.value = '<?=$super_id?>';
  var obj_corprator_id = document.getElementById('corprator_id');
  obj_corprator_id.value = '<?=$corprator_id?>';
  var obj_world_id = document.getElementById('world_id');
  obj_world_id.value = '<?=$world_id?>';
  var obj_agent_id = document.getElementById('agent_id');
  obj_agent_id.value = '<?=$agent_id?>';

  var obj_enable = document.getElementById('enable');
  obj_enable.value = '<?=$enable?>';
  var obj_page = document.getElementById('page');
 obj_page.value = '<?=$page?>';
  var obj_sort=document.getElementById('sort');
  obj_sort.value='<?=$sort?>';
  var obj_orderby=document.getElementById('orderby');
  obj_orderby.value='<?=$orderby?>';
 }
 function so()
{
	var so_username=document.getElementById('so_username').value;
	if(so_username==''){
		alert('请输入要搜索的会员帐号或会员帐号的一部分');
	}else{
		location='./ag_members.php?uid=<?=$uid?>&so_username='+so_username;
	}
}
// -->
</SCRIPT>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()";>
<FORM NAME="myFORM" ACTION="ag_members.php?uid=<?=$uid?>" METHOD=POST>
<table width="960" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td class="m_tline"> 
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="60">&nbsp;&nbsp;<?=$mem_caption?></td>
            <td><select class=za_select id=corprator_id onchange=document.myFORM.submit(); name=corprator_id>
				<option value="" selected><?=$rep_pay_type_all?></option> 
				<?
				$mysql = "select ID,Agname from web_corprator where Status=1 and subuser=0".$super." order by agname";
				$ag_result = mysql_query( $mysql);
				$ag_cou=mysql_num_rows($ag_result);
				while ($ag_row = mysql_fetch_array($ag_result)){
					if ($agents_id==$ag_row['Agname']){
						echo "<option value=".$ag_row['Agname']." selected>".$ag_row['Agname']."</option>";				
						$sel_agents=$ag_row['Agname'];
					}else{
						echo "<option value=".$ag_row['Agname'].">".$ag_row['Agname']."</option>";
					}
				}
				?>
			</select>
	              <select class=za_select id=world_id onchange=document.myFORM.submit(); name=world_id>
				<option value="" selected><?=$rep_pay_type_all?></option> 
				<?
				$mysql="select ID,Agname from web_world where Status=1".$scorprator." and subuser=0";

				$ag_result = mysql_query( $mysql);
				while ($ag_row = mysql_fetch_array($ag_result)){
					if ($agent_id==$ag_row['ID']){
						echo "<option value=".$ag_row['Agname']." selected>".$ag_row['Agname']."</option>";				
						$sel_agents=$ag_row['Agname'];
					}else{
						echo "<option value=".$ag_row['Agname'].">".$ag_row['Agname']."</option>";
					}
				}
				?>

			</select>
			<select class=za_select id=agent_id onchange=document.myFORM.submit(); name=agent_id>
				<option value="" selected><?=$rep_pay_type_all?></option> 
				<?
				$mysql="select ID,Agname from web_agents where Status=1 ".$aworld." and subuser=0";
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
              <option value="Y">
                <?=$mem_enable?>
                </option>
              <option value="N">
                <?=$mem_disable?>
                </option>
              <option value="S">暂停</option>
				<option value="DEL">已删除</option>
            </select></td>
            <td width="40"> -- <?=$mem_orderby?></td>
            <td>
              <select id="super_agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="alias"><?=$mem_name?></option>
                <option value="memname"><?=$mem_uid?></option>
                <option value="adddate"><?=$mem_adddate?></option>
              </select>
              <select id="orderby" name="orderby" onChange="self.myFORM.submit()" class="za_select">
                <option value="asc"><?=$mem_order_asc?></option>
                <option value="desc"><?=$mem_order_desc?></option>
              </select>
            </td>
            <td width="52"> -- <?=$mem_pages?></td>
            <td> 
              <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
		<?
		for($i=0;$i<$page_count;$i++){
			echo "<option value='$i'>".($i+1)."</option>";
		}
		?>
                
              </select>
            </td>
            <td> / <?=$page_count?> <?=$mem_page?>&nbsp;&nbsp;</td>
			<td>会员帐号(或部分)：<INPUT TYPE="text" size=6 NAME="so_username" id="so_username" value='<?=$_GET['so_username']?>'> <INPUT TYPE="button" VALUE="搜索" ONCLICK="so();"></td>
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
  <table width="770" border="0" cellspacing="1" cellpadding="0"  bgcolor="E3D46E" class="m_tab">
    <tr class="m_title"> 
      <td height="30" ><?=$mem_nomem?></td>
    </tr>
  </table>
<?
}else{
 ?>
  <table width="" border="0" cellspacing="1" cellpadding="0"  bgcolor="E3D46E" class="m_tab">
    <tr class="m_title"> 
      <td width="70"><?=$mem_agents?></td>
      <td width="70"><?=$mem_name?></td>
      <td width="70"><?=$mem_uid?></td>
      <td width="70">登录帐号</td>
      <td width="70">密码</td>
	  <td width="70"><?=$mem_credit?></td>
	  <td width="30"><?=$mem_otypes?></td>	
      <td width="70"><?=$mem_adddate?></td>
	  <td width="140">上级</td>
	  <td width="50">状况</td>
      <td width="60"><?=$mem_status?></td>
      <td width="230"><?=$mem_option?></td>
      <!--<td width="70">┿絏铬笆</td>-->
    </tr>
<?
	
	while ($row = mysql_fetch_array($result)){
	?> <tr class="m_cen">
      <td><?=$start_font?><?=$row['Agents'];?><?=$end_font?></td>
      <td><?=$start_font?><?=$row['Alias']?><?=$end_font?></td>   
      <td><?=$start_font?><?=$row['Memname'];?><?=$end_font?></td>   
	  <td><?=$start_font?><?=$row['loginname'];?><?=$end_font?></td>
      <td><font color=red><?=$row['passwd'];?></font></td>   
      <? if($edit==1) echo "<td>$row[passwd] </td>"; ?>
      <td align="right"><?=$start_font?><?=$row['pay_type']==1? number_format($row['money']*$row['ratio'],2) : number_format($row['Credit']*$row['ratio'],2);?> <?=$end_font?></td>
      <td><?=$start_font?><?=$row['OpenType']?><?=$end_font?></td>
	  <td><?=$row['AddDate'];?></td>
	  <td><?="$row[super] / $row[corprator] / $row[world] / $row[Agents]"?> </td>
	  <td><?=$row['online'] ? "在线" : '<font color=#8E8E8E>离开</font>'?></td>
	  <td><?=$caption2?></td>    
      <td align="left"><a href="javascript:CheckSTOP('ag_members.php?uid=<?=$uid?>&active=2&id=<?=$row['ID']?>&enable=<?=$memstop?>','<?=$memstop?>')">
        <?=$caption1?>
      </a>/
      <? if ($enable!="N"){?>
      <a href="javascript:CheckSTOP('ag_members.php?uid=<?=$uid?>&active=2&id=<?=$row['ID']?>&enable=<?=$memstop1?>','<?=$memstop1?>')">
      <?=$caption3?>
      </a> /
      <?
		}
		?>
      <a href="ag_mem_edit.php?uid=<?=$uid?>&mid=<?=$row['ID']?>">
      <?=$mem_acount?>
      </a> </a> / <a href="ag_mem_set.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['pay_type']?>&agents_id=<?=$row['Agents']?>">
      <?=$mem_setopt?>
      </a>
      / <a href="javascript:CheckDEL('ag_members.php?uid=<?=$uid?>&id=<?=$row['ID']?>&active=3')"><?=$mem_delete?></a>
     </td>                                                                                                    
    </tr> 
<?
}
}
?>  
</table>
</form>
</body>
</html>