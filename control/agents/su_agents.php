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
$sql = "select * from `web_system` where sysuid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
/*if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
}*/


$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
$langx='zh-cn';
require ("../../member/include/traditional.$langx.inc.php");

$enable=$_REQUEST["enable"];
$enabled=$_REQUEST["enabled"];
$sort=$_REQUEST["sort"];
$active=$_REQUEST["active"];
$orderby=$_REQUEST["orderby"];
$super_agents_id=$_REQUEST['super_agents_id'];
$corprator_id=$_REQUEST['corprator_id'];
$world_id=$_REQUEST['world_id'];
$mid=$_REQUEST["mid"];

$active=$_REQUEST["active"];
if ($enable==""){
	$enable='Y';
}

if ($sort==""){
	$sort='Agname';
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
	$mysql="update web_agents set oid='',Status=$stop where ID=$mid";
	mysql_query( $mysql);
	$mysql="select agname from web_agents where ID=$mid";
	mysql_query( $mysql);
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agent_name=$row['agname'];

	$mysql="update web_member set oid='0',Status=$stop where agents='$agent_name'";
	mysql_query( $mysql);

}elseif($active==3){
	if(!ck_caozuoma($_REQUEST['czm'])){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
		<script language='javascript'>alert('操作码不正确，无法删除！');</script>";
	}else{
		$mysql="select agname from web_agents where ID='$mid'";
		$result = mysql_query( $mysql);
		$row = mysql_fetch_array($result);
		$agname=$row['agname'];

		$mysql="delete from web_member where agents='$agname'";
		mysql_query($mysql);

		//$mysql="delete from web_db_io where agents='$agname'";
		//mysql_query($mysql);

		$mysql="delete from web_agents where ID='$mid'";
		mysql_query($mysql);
	}

}

$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
if ($super_agents_id==''){
	$super='';
}else{
	$super=" and super='$super_agents_id'";
}
if ($corprator_id==''){
	$corprator='';
}else{
	$corprator=" and corprator='$corprator_id'";
}
if ($world_id==''){
	$world='';
}else{
	$world=" and world='$world_id'";
}

$sql = "select passwd,ID,Agname,passwd_safe,Alias,Credit,mCount,date_format(AddDate,'%Y-%m-%d %H:%i:%s') as AddDate, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate,super,corprator,world  from web_agents where Status='$enabled' and subuser=0 ".$super.$corprator.$world."  order by ".$sort." ".$orderby;

$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
$page_size=25;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_query( $mysql);
$cou=mysql_num_rows($result);

?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_title {  background-color: #86C0A6; text-align: center}
-->
</style>
<SCRIPT language=javaScript src="/js/agents<?=$body_js?>.js" type=text/javascript></SCRIPT>
<SCRIPT language=javaScript>
<!--
 function onLoad()
 {
  var obj_sagent_id = document.getElementById('super_agents_id');
  obj_sagent_id.value = '<?=$super_agents_id?>';
  var obj_world_id = document.getElementById('corprator_id');
  obj_world_id.value = '<?=$corprator_id?>';
  var obj_agent_id = document.getElementById('world_id');
  obj_agent_id.value = '<?=$world_id?>';
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
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
<form name="myFORM" action="./su_agents.php?uid=<?=$uid?>" method=POST>
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline"> 
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr> 
            <td>&nbsp;&nbsp;代理商管理:</td>
            <td> 
<select class=za_select id=super_agents_id onchange=document.myFORM.submit(); name=super_agents_id>
				<option value="" selected><?=$rep_pay_type_all?></option> 
				<?
	$mysql = "select ID,Agname from web_super where Status=1 and subuser=0 order by agname";
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
			</select><select class=za_select id=corprator_id onchange=document.myFORM.submit(); name=corprator_id>
				<option value="" selected><?=$rep_pay_type_all?></option> 
				<?
	$mysql = "select ID,Agname from web_corprator where Status=1 and subuser=0".$super." order by agname";
	$ag_result = mysql_query( $mysql);
	$ag_cou=mysql_num_rows($ag_result);
				while ($ag_row = mysql_fetch_array($ag_result)){
					if ($corprator_id==$ag_row['Agname']){
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
				if ($ag_cou>0){
				$mysql="select ID,Agname from web_world where Status=1 and subuser=0".$corprator." order by agname";
				$ag_result = mysql_query( $mysql);
				while ($ag_row = mysql_fetch_array($ag_result)){
					if ($world_id==$ag_row['ID']){
						echo "<option value=".$ag_row['Agname']." selected>".$ag_row['Agname']."</option>";				
						$sel_agents=$ag_row['Agname'];
					}else{
						echo "<option value=".$ag_row['Agname'].">".$ag_row['Agname']."</option>";
					
					}
				}
}
				?>

			</select>
			  <select id="enable" name="enable" onChange="self.myFORM.submit()" class="za_select">
                <option value="Y" ><?=$mem_enable?></option>
                <option value="N" ><?=$mem_disable?></option>
				<option value="S">暂停</option>
				<option value="DEL">已删除</option>
			  </select>
            </td>
            <td> -- <?=$mem_orderby?></td>
            <td>
              <select id="agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="Agname"><?=$mem_uid?></option>
                <option value="alias"><?=$mem_name?></option>
                <option value="Adddate"><?=$mem_adddate?></option>
              </select>
              <select id="enable" name="orderby" onChange="self.myFORM.submit()" class="za_select">
                <option value="asc"><?=$mem_order_asc?></option>
                <option value="desc"><?=$mem_order_desc?></option>
              </select>
            </td>
            <td width="52"> -- <?=$mem_pages?></td>
            <td> 
              <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
		<?
		if ($page_count==0){$page_count=1;}
		for($i=0;$i<$page_count;$i++){
			echo "<option value='$i'>".($i+1)."</option>";
		}
		?>
              </select>
            </td>
            <td> / <?=$page_count?> <?=$mem_page?> </td>
            <td> 
              <!--<input type=BUTTON name="append" value="<?=$mem_add?>" onClick="document.location='./su_ag_add.php?uid=<?=$uid?>'" class="za_button">-->
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
<table width="770" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">

<?

if ($cou==0){
?>
<table width="770" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">    <tr class="m_title"> 
      <td height="30" ><?=$mem_nomem?></td>
    </tr>
  </table>
<?
}else{
?>  
<table width="" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">
   <tr class="m_title"> 
      <td width="80"><?=$rcl_agent?><?=$sub_name?></td>
      <td width="80"><?=$rcl_agent?><?=$sub_user?></td>
	  <td width="60">登录帐号</td>
	  <td width="60">密码</td>
	  <td width="90"><?=$rep_pay_type_c?></td>
      <td width="60">会员数</td>
      <td width="130"><?=$mem_adddate?></td>
      <td width="130">到期时间</td>
	  <td width="100">上级</td>
      <td width="64"><?=$mem_status?></td>
      <td width="230"><?=$mem_option?></td>
    </tr>
	<?
	while ($row = mysql_fetch_array($result)){
		$sql = "select count(*) as mCount from web_member where agents='".$row['Agname']."'";
		$cresult = mysql_query( $sql);
		$crow = mysql_fetch_array($cresult);
		$row['mCount'] = $crow['mCount'];
		
		$class = 'm_cen';
		if($row['enddate']=='0000-00-00 00:00:00'){
			$row['enddate']='永不过期';
		}
		elseif(strtotime($row['enddate']) < time()){
			$class = 'm_cen_red';
		}
		
		
	?>
    <tr class="<?=$class?>"> 
      <td><?=$row['Alias']?></td>
      <td><?=$row['Agname']?></td>
      <td><?=$row['passwd_safe']?></td>
      <td><font color=red><?=$row['passwd']?></font></td>
	  <td align="right"><?=$row['Credit']?></td>
      <td><?=$row['mCount']?></td>
      <td><?=$row['AddDate']?></td>
      <td><?=$row['enddate']?></td>
	  <td><?="$row[super] / $row[corprator] / $row[world]"?> </td>
      <td><?=$caption2?></td>
      <td align="left">
	     <a href="javascript:CheckSTOP('su_agents.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=<?=$memstop?>','<?=$memstop?>')"><?=$caption1?></a>/ 
		<? if ($enable!="N"){?>
		<a href="javascript:CheckSTOP('su_agents.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=<?=$memstop1?>','<?=$memstop1?>')"><?=$caption3?>
		</a>
		 /
		<?
		}
		?><a href="su_ag_edit.php?uid=<?=$uid?>&id=<?=$row['ID']?>&agents_id=<?=$row['world']?>"><?=$mem_acount?></a> 
        / <a href="su_ag_set.php?uid=<?=$uid?>&id=<?=$row['ID']?>&agents_id=<?=$row['world']?>"><?=$mem_setopt?></a>
        / <a href="javascript:CheckDEL('su_agents.php?uid=<?=$uid?>&mid=<?=$row['ID']?>&active=3')">
       <?=$mem_delete?>
        </a>
      </td>
	</tr>
<?
}
}
?>  
</table>  
  </table>
</form>
<!----------------------结帐视窗---------------------------->
<div id=acc_window style="display: none;position:absolute">
<form name=agAcc action="../acc_proc.php?uid=<?=$uid?>&url=agents/su_agents.php?uid=<?=$uid?>" method=post onSubmit="return Chk_acc();" target="win_agAcc">
<input type=hidden name=aid value="">
<table width="220" border="0" cellspacing="1" cellpadding="2" bgcolor="0163A2">
  <tr>
    <td bgcolor="#FFFFFF">
    <table width="220" border="0" cellspacing="0" cellpadding="0" bgcolor="0163A2" class="m_tab_fix">
      <tr bgcolor="0163A2"> 
        <td id=acc_title><font color="#FFFFFF">请输入结帐日期</font></td>
    <td align="right" valign="top" ><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
      </tr>
       <tr bgcolor="#000000"> 
          <td colspan="2" height="1"></td>
        </tr>
      <tr> 
        <td colspan="2">日　期:
          <input type=text name=acc_date value="2005-06-06" class="za_text" size="12" maxlength="10" >
          &nbsp;&nbsp; 
          <input type=submit name=acc_ok value="确定" class="za_button">
          &nbsp; </td>
      </tr>
    </table>
   </td>
  </tr>
</table>
</form>
</div>
<!----------------------结帐视窗---------------------------->
<!----------------------回复视窗---------------------------->
<div id=re_window style="display: none;position:absolute">
<form name=agre action="../recover_credit.php?uid=<?=$uid?>" method=post onSubmit="return Chk_acc();" target="win_agAcc">
<input type=hidden name=aid value="">
<input type=hidden name=cdate value="">
<table width="220" border="0" cellspacing="1" cellpadding="2" bgcolor="0163A2">
  <tr>
    <td bgcolor="#FFFFFF">
      <table width="220" border="0" cellspacing="0" cellpadding="0" class="m_tab_fix" >
        <tr bgcolor="0163A2"> 
          <td width="200" id=re_title><font color="#FFFFFF">&nbsp;请输入回复日期</font></td>
          <td align="right" valign="top" ><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
        </tr>
        <tr bgcolor="#000000"> 
          <td colspan="2" height="1"></td>
        </tr>
        <tr> 
          <td colspan="2">日　期：
          <input type=text name=acc_date value="2005-06-06" class="za_text" size="12" maxlength="10">
          &nbsp;&nbsp; 
          <input type=submit name=acc_ok value="确定" class="za_button"></td>
       </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</div>
<font color=red>session：<?=$_SESSION["ckck"];?><font>
<!----------------------回复视窗---------------------------->
</body>
</html>