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
$langx=$_REQUEST["langx"];
$keys=$_REQUEST["keys"];
$gold=$_REQUEST["maxcredit"];
$pasd=$_REQUEST["password"];
$wager=$_REQUEST["type"];
$alias=$_REQUEST["alias"];
$Bank_Address=$_REQUEST["Bank_Address"];
$Bank_Account=$_REQUEST["Bank_Account"];
$email=$_REQUEST["email"];
$phone=$_REQUEST["phone"];
$address=$_REQUEST["address"];
$alias_tw=$_REQUEST['alias'];
$opentype=$_REQUEST["open_type"];
$id=$_REQUEST["id"];
$memname=$_REQUEST['username'];
$sql = "select Agname,ID,language,corprator,Credit from web_super where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
//	echo "<script>window.open('$site/index.php','_top')<script>";
}

$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
$corprator=$row['corprator'];
$credit=$row['Credit'];
$langx='zh-cn';
require ("../../member/include/traditional.$langx.inc.php");


if ($keys=="upd"){
	$id=$_REQUEST["super_agents_id"];
	$enddate = strtotime($_REQUEST['enddate']);
	$enddate = $enddate>strtotime('2008-08-08') ? date('Y-m-d H:i:s', $enddate) : '';
	
	if($pasd<>""){
		$pasd=substr(md5(md5($pasd."abc123")),0,16);
		$mysql="update web_agents set Credit='$gold',Passwd='$pasd',Alias='$alias_tw',Bank_Address='$Bank_Address',Bank_Account='$Bank_Account',email='$email',address='$address',phone='$phone',Wager='$wager',enddate='$enddate' where ID='$id'";
	}else{
		$mysql="update web_agents set Credit='$gold',Alias='$alias_tw',Bank_Address='$Bank_Address',Bank_Account='$Bank_Account',email='$email',address='$address',phone='$phone',Wager='$wager',enddate='$enddate' where ID='$id'";
	}
	mysql_query($mysql) or die ("操作失败!");
		//开始
	$sql2 = "select admin from  web_system  where sysuid='$uid'";
$result2 = mysql_query($sql2);
$row2 = mysql_fetch_array($result2);
if ($row2['admin']){
	
	$agname=$row2['admin'];
	$loginfo='修改代理'.$memname.'资料';
}$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','2')";
mysql_query($mysql);
//结束
	echo "<Script language=javascript>self.location='su_agents.php?uid=$uid';</script>";
}
else{

	$sql = "select *, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate from web_agents where ID='$id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$enddate = $row['enddate']=='0000-00-00 00:00:00' ? '0' : $row['enddate'];
?>


<html style="width: 98%;margin: 0 auto;">
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_ag_ed {  background-color: #baccc1; text-align: right}
-->
</style>
<SCRIPT>
<!--
function SubChk()
{
// if(document.all.username.value=='')
// { document.all.username.focus(); alert("<?=$mem_alert1?>"); return false; }
// if(document.all.password.value=='' )
 //{ document.all.password.focus(); alert("<?=$mem_alert5?>"); return false; }
 // if(document.all.repassword.value=='')
// { document.all.repassword.focus(); alert("<?=$mem_alert6?>"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("<?=$mem_alert7?>"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("请输入名称!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("请输入总信用额度!"); return false; }
 if(!confirm("是否确定修改"))
 {
  return false;
 }
}



// -->
</SCRIPT>
<script language="javascript">
 function onLoad()
 {
  //var obj_super_agents_id = document.getElementById('super_agents_id');
  //obj_super_agents_id.value = '<?=$row['ID']?>';
  var obj_winloss_s = document.getElementById('winloss_s');
  obj_winloss_s.value = '<?=$row['Winloss_S']?>';
  var obj_winloss_a = document.getElementById('winloss_a');
  obj_winloss_a.value = '<?=$row['Winloss_A']?>';
  var obj_type = document.getElementById('type');
  obj_type.value = '<?=$row['Wager']?>';
 }
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
 <FORM NAME="myFORM" ACTION="" METHOD=POST onSubmit="return SubChk()">
 <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$row['world']?>">
 <INPUT TYPE=HIDDEN NAME="aid" VALUE="<?=$row['corprator']?>">
 <INPUT TYPE=HIDDEN NAME="enable" VALUE="Y">
 <input type="hidden" name="keys" value="upd">
 <input type="hidden" name="super_agents_id" value="<?=$row['ID']?>">
 <input type="hidden" name="username" value="<?=$row['Agname']?>">
 <INPUT TYPE=HIDDEN NAME="winloss_s">
 <INPUT TYPE=HIDDEN NAME="winloss_a">
 <input type="hidden" name="old_sid" value="<?=$row['ID']?>">
 <input type=HIDDEN name="uid" value="<?=$uid?>">
 <table width="800" border="0" cellspacing="0" cellpadding="0">
<tr> 
  <td class="m_tline">&nbsp;&nbsp; <?=$wld_selagent?></td>
     <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
</tr>
<tr> 
<td colspan="2" height="4"></td>
</tr>
</table>
<table width="770" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td colspan="2" ><?=$mem_accset?></td>
  </tr>
  <tr class="m_bc_ed"> 
      <td width="120" class="m_ag_ed"> <?=$sub_user?>:</td>
      <td><?=$row['Agname']?></td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed"><?=$sub_pass?>:</td>
      <td> 
        <input type=PASSWORD name="password" value="" size=8 maxlength=8 class="za_text">
      </td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed"><?=$acc_repasd?>:</td>
      <td> 
        <input type=PASSWORD name="repassword" value="" size=8 maxlength=8 class="za_text">
      </td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed"><?=$rcl_agent?><?=$sub_name?>:</td>
      <td> 
        <input type=TEXT name="alias" value="<?=$row['Alias']?>" size=10 maxlength=10 class="za_text">
      名称只能有数字(0-9)，及英文大小写字母      </td>
  </tr>
  
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed">开户银行:</td>
      <td> 
        <input type=TEXT name="Bank_Address" value="<?=$row['Bank_Address']?>" size=20  class="za_text">
      </td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed">银行帐号:</td>
      <td> 
        <input type=TEXT name="Bank_Account" value="<?=$row['Bank_Account']?>" size=20 class="za_text">
      </td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed">手机号码:</td>
      <td> 
        <input type=TEXT name="phone" value="<?=$row['phone']?>" size=20 maxlength=12 class="za_text"></td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed">电子邮箱:</td>
      <td> 
        <input type=TEXT name="email" value="<?=$row['email']?>" size=20  class="za_text"></td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed">QQ/Skype:</td>
      <td> 
        <input type=TEXT name="address" value="<?=$row['address']?>" size=20  class="za_text"></td>
  </tr>
</table>
  <table width="770" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit"> 
      <td colspan="2" ><?=$mem_betset?></td>
    </tr>
    <tr class="m_bc_ed"> 
      <td width="120" class="m_ag_ed"><?=$real_wager?>:</td>
      <td> 
        <select id="type" name="type" class="za_select">
          <option value="0"><?=$mem_disable?></option>
          <option value="1"><?=$mem_enable?></option>
        </select>      </td>
    </tr>

    <tr class="m_bc_ed">
      <td class="m_ag_ed" width="120">到期時間:</td>
		<td>
			<input type=TEXT name="enddate" value="<?=$enddate?>" size=20 class="za_text">
			例：2010-12-30 或 2010-12-30 23:59:59 。注：0為永不過期。
		</td>
    </tr>

    <tr class="m_bc_ed"> 
      <td class="m_ag_ed"><?=$mem_maxcredit?>:</td>
      <td>
<?
$sql="select sum(credit) as credit from web_member where agents='$row[Agname]' and status=1";
$sresult = mysql_query($sql);
$srow = mysql_fetch_array($sresult);

$sql="select sum(credit) as credit from web_member where agents='$row[Agname]' and status=0";
$eresult = mysql_query($sql);
$erow = mysql_fetch_array($eresult);

//echo $sql;
//echo $srow['credit'];
?>
        <input type=TEXT name="maxcredit" value="<?=$row['Credit']?>" size=10 maxlength=10 class="za_text">
	<?=$mem_status?>/<?=$mem_enable?>:<?=$srow['credit']?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$mem_disable?>:<?=number_format($erow['credit'],0)?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$mem_havecredit?>:<?=$row['Credit']-$erow['credit']-$srow['credit']?>      </td>
    </tr>
    <tr class="m_bc_ed"> 
      <td class="m_ag_ed"><?=$wld_percent3?>:</td>
      <td><?=$row['Winloss_A']?>%&nbsp;&nbsp;<!--[&nbsp;中国甲A<font color=blue>YES</font>占成]--></td>
    </tr>
  </table>
  <table width="770" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
<tr align="center" bgcolor="#FFFFFF"> 
      <td align="center"> 
        <input type=SUBMIT name="OK" value="<?=$submit_ok?>" class="za_button">
        &nbsp;&nbsp; &nbsp; 
        <input type=BUTTON name="FormsButton2" value="<?=$submit_cancle?>" id="FormsButton2" onClick="javascript:history.go(-1)" class="za_button">
      </td>
    </tr>
  </table>
</form>
</body>
</html>
<script language='javascript'>
function cancelMouse()
{
    return false;
}
document.oncontextmenu=cancelMouse;
</script>
<?
}
?>