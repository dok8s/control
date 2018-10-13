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
$mid=$_REQUEST["id"];
$sql = "select Agname,ID,language from web_super where Oid='$uid'";

$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	
}

$row = mysql_fetch_array($result);
//本总代理商
	$mysql="select credit,corprator,Winloss_S from web_world where id=$mid";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit1=$row['credit'];
	$agname=$row['corprator'];
	$Winloss_S=$row['Winloss_S'];
//股东
	$mysql="select credit,Winloss_D,Winloss_C from web_corprator where agname='$agname'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit=$row['credit'];
	$Winloss_D=$row['Winloss_D'];
	$Winloss_C=$row['Winloss_C'];
$langx=$row['language'];
$langx='zh-cn';
require ("../../member/include/traditional.$langx.inc.php");

$keys=$_REQUEST['keys'];
if ($keys=='upd'){
	$AddDate=date('Y-m-d H:i:s');
	$memname=$_REQUEST['username'];
	if($_REQUEST['password']<>""){
		$mempasd=substr(md5(md5($_REQUEST['password']."abc123")),0,16);
	}
	$maxcredit=$_REQUEST['maxcredit'];
	$alias=$_REQUEST['alias'];
	$alias_tw=$_REQUEST['alias'];
	$wager=$_REQUEST['type'];
	$enddate = strtotime($_REQUEST['enddate']);
	$enddate = $enddate>strtotime('2008-08-08') ? date('Y-m-d H:i:s', $enddate) : '';
	if($_REQUEST['password']<>""){
		$mysql="update web_world set passwd='$mempasd',Credit='$maxcredit',Alias='$alias_tw',Wager='$wager',enddate='$enddate' where id=$mid";
	}else{
		$mysql="update web_world set Credit='$maxcredit',Alias='$alias_tw',Wager='$wager',enddate='$enddate' where id=$mid";
	}
	mysql_query($mysql) or die ("操作失败!");
	//判断额度是否超过限制
	//$mysql="update web_corprator set passwd='$mempasd',Credit='$maxcredit',Alias='$alias_tw',Wager='$wager' where id=$mid";
	//mysql_query($mysql) or die ("操作失败!");
	//开始
	$sql2 = "select admin from  web_system  where sysuid='$uid'";
$result2 = mysql_query($sql2);
$row2 = mysql_fetch_array($result2);
if ($row2['admin']){
	
	$agname=$row2['admin'];
	$loginfo='修改总代理'.$memname.'资料';
}

$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','2')";
mysql_query($mysql);
//结束
	echo "<script languag='JavaScript'>self.location='body_super_agents.php?uid=$uid'</script>";
}else{
	$sql = "select ID,Agname,Passwd,Alias,Wager,Credit, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate  from web_world where ID=$mid";
	$result = mysql_query($sql) or exit('error 998332'.mysql_error());
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
.m_suag_ed {  background-color: #D3C9CB; text-align: right}
-->
</style>
<SCRIPT>
<!--
function SubChk()
{
// if(document.all.username.value=='')
// { document.all.username.focus(); alert("<?=$mem_alert1?>"); return false; }
 //if(document.all.password.value=='' )
// { document.all.password.focus(); alert("<?=$mem_alert5?>"); return false; }
//  if(document.all.repassword.value=='')
// { document.all.repassword.focus(); alert("<?=$mem_alert6?>"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("<?=$mem_alert7?>"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("请输入名称!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("请输入总信用额度!"); return false; }
// if(document.all.winloss_s.value=='')
// { document.all.winloss_s.focus(); alert("叫匡拒羆瞶坝Θ计!!"); return false; }  
// if (eval(document.all.winloss_c.value) > eval(document.all.winloss_s.value))  
// { document.all.winloss_s.focus(); alert("羆瞶坝Θ计禬筁狥Θ计!!"); return false; }    
 if(!confirm("是否确定修改?"))
 {
  return false;
 }
}


 function onLoad()
 {
  var obj_type_id = document.getElementById('type');
  obj_type_id.value = '';
 }
// -->
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
<FORM NAME="myFORM" ACTION="body_super_agents_edit.php" METHOD=POST onSubmit="return SubChk()">
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$mid?>">
 <INPUT TYPE=HIDDEN NAME="adddate" VALUE="">
  <INPUT TYPE=HIDDEN NAME="keys" VALUE="upd">
  <INPUT TYPE=HIDDEN NAME="enable" VALUE="Y">
  <input TYPE=HIDDEN NAME="s_type" VALUE="">
  <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
  <input TYPE=HIDDEN NAME="winloss_c" VALUE="10"> 
  <input TYPE=HIDDEN NAME="username" VALUE="<?=$row['Agname']?>"> 
  <table width="800" border="0" cellspacing="0" cellpadding="0">
<tr> 
    <td class="m_tline">&nbsp;&nbsp;<?=$cor_agents?>--<?=$mem_addnewuser?></td>
      
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

<input type="HIDDEN" value="" name="type">
  <tr class="m_bc_ed"> 
      <td class="m_suag_ed" width="120"> <?=$sub_user?>:</td>
    <td> 
      <?=$row['Agname']?>
    </td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_suag_ed"><?=$sub_pass?>:</td>
    <td> 
      <input type=PASSWORD name="password" value="" size=8 maxlength=10 class="za_text">
    </td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_suag_ed"><?=$acc_repasd?>:</td>
    <td> 
      <input type=PASSWORD name="repassword" value="" size=8 maxlength=10 class="za_text">
    </td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_suag_ed">总代理名称:</td>
    <td> 
      <input type=TEXT name="alias" value="<?=$row['Alias']?>" size=10 maxlength=10 class="za_text">名称只能有数字(0-9)，及英文大小写字母 
    </td>
  </tr>
</table>
  
  <table width="770" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit"> 
      <td colspan="2" ><?=$mem_betset?></td>
    </tr>
    <tr class="m_bc_ed"> 
      <td width="120" class="m_suag_ed"><span class="m_suag_ed"><?=$real_wager?>:</span></td>
      <td><select id="type" name="type" class="za_select">
        <option value="0" <? if ($row['Wager']==0){ echo "selected";}?>>
        <?=$mem_disable?>
        </option>
        <option value="1" <? if ($row['Wager']==1){ echo "selected";}?>>
        <?=$mem_enable?>
        </option>
        </select>
	  </td>
	</tr>
	

    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">到期時間:</td>
		<td>
			<input type=TEXT name="enddate" value="<?=$enddate?>" size=20 class="za_text">
			例：2010-12-30 或 2010-12-30 23:59:59 。注：0為永不過期。
		</td>
    </tr>

    <tr class="m_bc_ed"> 
      <td width="120" class="m_suag_ed"><?=$mem_maxcredit?>:</td>
       <?
$sql2="select sum(credit) as credit from web_agents where world='".$row['Agname']."' and status=1";
$sresult = mysql_query($sql2);
$srow = mysql_fetch_array($sresult);

$sql3="select sum(credit) as credit from web_agents where world='".$row['Agname']."' and status=0";
$eresult = mysql_query($sql3);
$erow = mysql_fetch_array($eresult);

?><td> 
        <input type=TEXT name="maxcredit" value="<?=$row['Credit']?>" size=10 maxlength=10 class="za_text">
        <?=$mem_status?>
        〓
        <?=$mem_enable?>
        :<?=number_format($srow['credit'],0)?> &nbsp;
        <?=$mem_disable?>
        :<?=number_format($erow['credit'],0)?>
        <?=$mem_havecredit?>
      :<?=$row['Credit']-$erow['credit']-$srow['credit']?> </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_suag_ed"><span class="m_suag_ed">总代理商占成:</span></td>
      <td><?=(100-$Winloss_C-$Winloss_D-$Winloss_S)?>%</td>
    </tr>   
    <tr class="m_bc_ed" align="center"> 
      <td colspan="2">    
        <input type=SUBMIT name="OK" value="<?=$submit_ok?>" class="za_button">
        &nbsp; &nbsp; &nbsp; 
        <input type=BUTTON name="FormsButton2" value="<?=$submit_cancle?>" id="FormsButton2" onClick="javascript:history.go(-1)" class="za_button">      </td>
    </tr>
  </table>
  
</form>
</body>
</html>

<?
}
?>