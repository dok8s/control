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
$keys=$_REQUEST["keys"];
$mid=$_REQUEST["mid"];
if ($keys=='upd'){
	$gold=$_REQUEST["maxcredit"];
	$pasd=$_REQUEST["password"];
	$alias=$_REQUEST["alias"];
	$alias_tw=$_REQUEST['alias'];
	$address=$_REQUEST["address"];
	$phone=$_REQUEST["phone"];
	$notes=$_REQUEST['notes'];
	$opentype=$_REQUEST["type"];
	$mem_line=$_REQUEST["mem_line"];
	$memname=$_REQUEST['username'];
	$mysql="select sum(BetScore) as betscore from web_db_io where M_Name='".$_REQUEST[username]."' and M_Date='".date('Y-m-d')."'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$betscore=$row['betscore'];
	$betscore=$row['betscore']+0;
	
	if ($gold-$betscore>0){
		$betscore=$gold-$betscore;
	}else{
		$betscore=0;
	}

	$mysql="update web_member set oid='',Credit='$gold',money='$betscore',Passwd='$pasd',Alias='$alias_tw',phone='$phone',notes='$notes',address='$address' where id=$mid";
	
	mysql_query($mysql) or die ("mysql error 1!");
	

	$sql2 = "select admin from  web_system  where sysuid='$uid'";
$result2 = mysql_query($sql2);
$row2 = mysql_fetch_array($result2);
if ($row2['admin']){
	
	$agname=$row2['admin'];
	$loginfo='修改会员'.$memname.'资料';
}	$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','2')";
mysql_query($mysql);

	
	echo "<Script language=javascript>self.location='./ag_members.php?uid=$uid';</script>";
}
else{
	$sql = "select Agname,ID,language,CurType from web_super where Oid='$uid'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$cou=mysql_num_rows($result);
	if($cou==0){
		//echo "<script>window.open('$site/index.php','_top')<script>";
	}
	$addmeney=$row['CurType'];
	$agname=$row['Agname'];
	$agid=$row['ID'];
	$langx=$row['language'];
	$langx='zh-cn';
	require ("../../member/include/traditional.$langx.inc.php");
	$sql = "select * from web_member where ID='$mid'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	switch ($row['OpenType']){
	case "A":
		$type=1;
		break;
	case "B":
		$type=2;
		break;	
	case "C":
		$type=3;
		break;
	case "D":
		$type=4;
		break;
	}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_mem_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
<script language="javascript" src="/js/mem_edit_gb.js"></script>
<SCRIPT>
<!--
function SubChk()
{
// if(document.all.username.value=='')
// { document.all.username.focus(); alert("<?=$mem_alert1?>"); return false; }
 if(document.all.password.value=='' )
 { document.all.password.focus(); alert("<?=$mem_alert5?>"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("<?=$mem_alert6?>"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("<?=$mem_alert7?>"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("请输入会员名!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("请输入信额度!"); return false; }
// if(document.all.winloss_s.value=='')
// { document.all.winloss_s.focus(); alert("叫匡拒羆瞶?Θ?!!"); return false; }  
// if (eval(document.all.winloss_c.value) > eval(document.all.winloss_s.value))  
// { document.all.winloss_s.focus(); alert("羆瞶?Θ?禬??Θ?!!"); return false; }    
 if(!confirm("是否确定修改"))
 {
  return false;
 }
}



// -->
</SCRIPT>
<SCRIPT>
function Chg_Mcy(a){
	curr=new Array();
	curr_now=new Array();
	  
    if (document.all.ratio.value==''){
      tmp=document.all.currency.options[document.all.currency.selectedIndex].value;
	  ratio=eval(curr[tmp]);
      ratio_now=eval(curr_now[tmp]);
    }else{
	  ratio=eval(document.all.ratio.value);
      ratio_now=eval(document.all.ratio_now.value);
    }
    if (a=='mx')
    {
      tmp_count=ratio*eval(document.all.maxcredit.value);
      tmp_count=Math.round(tmp_count*100);
	  tmp_count=tmp_count/100;
      document.all.mcy_mx.innerHTML=tmp_count;
    }
    if (a=='now')
    {
      document.all.mcy_now.innerHTML=ratio_now;
    }
}

function onLoad()
 {
  //var obj_sagent_id = document.getElementById('aid');
  //obj_sagent_id.value = '{SAID}';
  var obj_type = document.getElementById('type');
  obj_type.value = '<?=$type?>';
 }

function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("羆獺?肂度??!!"); return false;}
}
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad();Chg_Mcy('now')">
<div id="Layer1" style="position:absolute; width:770px; height:48px; z-index:1; left: 0px; top: 297px; visibility: hidden; background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px none #000000"></div>
<FORM NAME="myFORM" ACTION="" METHOD=POST onSubmit="return SubChk()">
  <input type="hidden" name="keys" value="upd">
  <input type="hidden" name="aid" value="<?=$agid?>">
  <input type="hidden" name="currency" value="<?=$row['CurType']?>">
  <input type="hidden" name="mid" value="<?=$row['ID']?>">
  <input type="hidden" name="pay_type" value="<?=$row['pay_type']?>">
  <input type="hidden" name="mem_line" value="<?=$type?>">
  <input type="hidden" name="ratio" value="<?=$row['ratio']?>">
  <input type="hidden" name="agents_id" value="<?=$agid?>">
  <input type="hidden" name="username" value="<?=$row['Memname']?>">
  <input type="hidden" name="pay" value="0">
  <input type="hidden" name="ratio_now" value="<?=$row['ratio']?>">
  <input type="hidden" name="old_aid" value="<?=$agid?>">
  <input type="hidden" name="uid" value="<?=$uid?>">
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="m_tline">&nbsp;&nbsp;<?=$mem_caption?></td>
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
    <td width="120" class="m_mem_ed"> <?=$sub_user?>:</td>
      <td><?=$row['Memname']?></td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_mem_ed"><?=$sub_pass?>:</td>
      <td> 
        <input type=PASSWORD name="password" size=8 maxlength=8 class="za_text" value="<?=$row['Passwd']?>">
        <?=$mem_pasread?></td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_mem_ed"><?=$acc_repasd?>:</td>
      <td>
        <input type=PASSWORD name="repassword" size=8 maxlength=8 class="za_text" value="<?=$row['Passwd']?>">
      </td>
  </tr>
  <tr class="m_bc_ed"> 
      <td class="m_mem_ed"><?=$mem_name?>:</td>
      <td>
        <input type=TEXT name="alias" size=10 maxlength=10 class="za_text" value="<?=$row['Alias']?>">
      名称只能有数字(0-9)，及英文大小写字母      </td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed">提款密码:</td>
      <td> 
        <input type=TEXT name="address" value="<?=$row['address']?>" size=20 class="za_text">
      </td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed">手机号码:</td>
      <td> 
        <input type=TEXT name="phone" value="<?=$row['phone']?>" size=20 maxlength=12 class="za_text"></td>
  </tr>
  
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed">备注:</td>
      <td> 
        <textarea cols="23"  row="10"  name="notes" id="notes"><?=$row['notes']?></textarea></td>
  </tr>
</table>
  <table width="770" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit"> 
      <td colspan="2" ><?=$mem_betset?></td>
    </tr>
    <tr class="m_bc_ed"> 
      <td width="120" class="m_mem_ed"><?=$mem_otype?>:</td>
      <td><?=$row['OpenType']?><?=$mem_opentype?>
        <input name="type" type="hidden" id="type" value="<?=$row['OpenType']?>">
      </td>
    </tr>
    <tr class="m_bc_ed"> 
      <td class="m_mem_ed"><?=$rep_pay_type?>:</td>
      <td>
	  <table border="0" cellspacing="0" cellpadding=0>
	<tr>
		<td><?
		if ($row['pay_type']==0){
			echo $mem_credit;
		}else{
			echo $mem_moncredit;
		}
		?></td>
	</tr>
</table>
</td>
    </tr>
    <tr class="m_bc_ed"> 
      <td class="m_mem_ed"><?=$mem_radioset?>:</td>
      <td><?=$row['CurType']?> <?
	  $addmeney=$row['CurType'];
	  
	   if($addmeney=='RMB') {echo $mem_radio_RMB." ->".$mem_radio_RMB;}
elseif($addmeney=='RMB') {echo $mem_radio_RMB." ->".$mem_radio_RMB;}
elseif($addmeney=='HKD') {echo $mem_radio_RMB." ->".$mem_radio_HKD;}
elseif($addmeney=='USD') {echo $mem_radio_RMB." ->".$mem_radio_USD;}
elseif($addmeney=='MYR') {echo $mem_radio_RMB." ->".$mem_radio_MYR;}
elseif($addmeney=='SGD') {echo $mem_radio_RMB." ->".$mem_radio_SGD;}
elseif($addmeney=='THB') {echo $mem_radio_RMB." ->".$mem_radio_THB;}
elseif($addmeney=='GBP') {echo $mem_radio_RMB." ->".$mem_radio_GBP;}
elseif($addmeney=='JPY') {echo $mem_radio_RMB." ->".$mem_radio_JPY;}
elseif($addmeney=='EUR') {echo $mem_radio_RMB." ->".$mem_radio_EUR;}
elseif($addmeney=='IND') {echo $mem_radio_RMB." ->".$mem_radio_EIND;}
elseif($addmeney=='NTD') {echo $mem_radio_RMB." ->".$mem_radio_NTD;}
else{echo $mem_radio_RMB." ->".$mem_radio_RMB;}



?> ; <?=$mem_curradio?>:<font color="#FF0033"> <?
	  $mysql2="select * from web_type_class where parent_id='20' order by class_id asc";
  $row2=mysql_query($mysql2);
 // while($result2=mysql_fetch_array($row2))
  {  
  if($addmeney==$result2['p0'])
  echo $result2['value'];
  }
  ?></font>&nbsp;<?=$mem_radiored?></td>
    </tr>
    <tr class="m_bc_ed"> 
      <td class="m_mem_ed"><?=$mem_maxcredit?>:</td>
      <td><?
	if ($row[pay_type]==0){
	$credit=$row['Credit']*$row['ratio'];
?>
        <input type=TEXT name="maxcredit" value="<?=$credit?>" size=12 maxlength=12 class="za_text" onKeyUp="Chg_Mcy('mx');" onKeyPress="return CheckKey();">
<?
}else{
	$credit=$row['Money']*$row['ratio'];
	echo $credit;
}
?>&nbsp; &nbsp; &nbsp;         <?
	switch($addmeney){
	case 'HKD':
		echo $mem_radio_HKD;
		break;
	case 'USD':
		echo $mem_radio_USD;
		break;
	case 'MYR':
		echo $mem_radio_MYR;
		break;
	case 'SGD':
		echo $mem_radio_SGD;
		break;
	case 'THB':
		echo $mem_radio_THB;
		break;
	case 'GBP':
		echo $mem_radio_GBP;
		break;
	case 'JPY':
		echo $mem_radio_JPY;
		break;
	case 'EUR':
		echo $mem_radio_EUR;
		break;
	case 'RMB':
		echo $mem_current;
		break;
		case 'NTD':
		echo $mem_radio_NTD;
		break;
	case '':
		echo $mem_current;
		break;
	}
	?>:<font color="#FF0033" id="mcy_mx"><?=$credit?></font> </td>
    </tr>
  </table>
	<table width="770" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr align="center" bgcolor="#FFFFFF"> 
      <td> 
        <input type=SUBMIT name="OK2" value="<?=$submit_ok?>" class="za_button">
        &nbsp; &nbsp; &nbsp; 
        <input type=BUTTON name="CANCEL2" value="<?=$submit_cancle?>" id="CANCEL" onClick="javascript:history.go(-1)" class="za_button">
      </td>
    </tr>
  </table>
</form>
</body>
</html>

<?
}
?>