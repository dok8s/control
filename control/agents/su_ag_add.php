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
$agents_id=$_REQUEST[agents_id];
if ($agents_id<>''){
	$sql = "select winloss_a,winloss_c,winloss_s from web_world_data where agname='$agents_id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	$abcdef=$row['winloss_a'];
	$winloss_c=$row['winloss_c'];
	$winloss_s=$row['winloss_s'];


}else{
	$winloss_c=100;
	$agents_id='____';
}

$sql = "select Agname,ID,language from web_super_data where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
}

$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
$langx='zh-cn';

$abcd=100-$row['winloss'];
require ("../../member/include/traditional.$langx.inc.php");

$keys=$_REQUEST['keys'];
if ($keys=='add'){
	$AddDate=date('Y-m-d H:i:s');
	$memname='d'.$_REQUEST['username'];
	$mempasd=$_REQUEST['password'];
	$maxcredit=$_REQUEST['maxcredit'];
	//�����ö��
	$wager=$_REQUEST['type'];// ��ʱע��
	$alias=$_REQUEST['alias'];
	$agents_id=$_REQUEST['agents_id'];
	if ($agents_id==''){
		echo wterror("��Ա���Ʋ���Ϊ�գ������һ����������");
		exit();
	}

	$winloss_c=$_REQUEST['winloss_c'];
	$winloss_s=$_REQUEST['winloss_s'];
	$winloss_a=$_REQUEST['winloss_a']-$winloss_c-$winloss_s;
	
	$mysql="select * from web_agents_data where Agname='$memname'";
	$result = mysql_query($mysql);
	$count=mysql_num_rows($result);
	if ($count>0){
		echo wterror("��������ʺ� $memname �Ѿ�����ʹ���ˣ������һҳ��������");
		exit();
	}

	$mysql="select credit,corprator from web_world_data where agname='$_REQUEST[agents_id]'";
	
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit=$row['credit'];
	$corprator=$row['corprator'];
	$mysql="select sum(Credit) as credit from web_agents_data where world='$_REQUEST[agents_id]'";
	$result = mysql_query($mysql);
	
	$row = mysql_fetch_array($result);
	if ($row['credit']+$maxcredit>$credit){
		echo wterror("Ŀǰ������ ������ö��Ϊ$maxcredit<br>Ŀǰ�ܴ����� ������ö��Ϊ$credit<br>,�����������ۼ����ö��Ϊ".number_format($row[credit],0)."<br>�ѳ����ܴ��������ö�ȣ������һ����������");
		exit();
	}
	$mysql="insert into web_agents(Agname,Passwd,Credit,Alias,AddDate,Wager,Winloss_c,Winloss_S,Winloss_A,world,corprator,super) values ('$memname','$mempasd','$maxcredit','$alias','$AddDate','$wager','$winloss_c','$winloss_s','$winloss_a','$agents_id','$corprator','$agname')";	
	mysql_query($mysql) or die ("����ʧ��!");
	$mysql="update web_world_data set agCount=agCount+1 where agname='$agents_id'";
	mysql_query($mysql) or die ("����ʧ��!");
	echo "<script languag='JavaScript'>self.location='./su_agents.php?uid=$uid'</script>";		
}else{
?>
<html style="width: 98%;margin: 0 auto;">
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_ag_ed {  background-color: #baccc1; text-align: right}
-->
</style>
<SCRIPT>
function LoadBody(){
document.all.num_1.selectedIndex=document.all.num_1[0];
document.all.num_2.selectedIndex=document.all.num_2[0];
document.all.num_3.selectedIndex=document.all.num_3[0];
document.all.num_4.selectedIndex=document.all.num_4[0];
document.all.keys.value = '';
}
function SubChk()
{
if(document.all.num_1.value=='')
{ document.all.num_1.focus(); alert("�b���аȥ���J!!"); return false; }
if(document.all.num_2.value=='')
{ document.all.num_2.focus(); alert("�b���аȥ���J!!"); return false; }
if(document.all.num_3.value=='')
{ document.all.num_3.focus(); alert("�b���аȥ���J!!"); return false; }
if(document.all.num_4.value=='')
{ document.all.num_4.focus(); alert("�b���аȥ���J!!"); return false; }
 if(document.all.password.value=='')
 { document.all.password.focus(); alert("�K�X�аȥ���J!!"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("�T�{�K�X�аȥ���J!!"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("�K�X�T�{���~,�Э��s��J!!"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("�N�z�ӦW�ٽаȥ���J!!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("�`�H���B�׽аȥ���J!!"); return false; }

//  if(document.all.winloss_a.value=='' )
// { document.all.winloss_a.focus(); alert("�п�ܥN�z�Ӧ�����!!"); return false; } 
 document.all.keys.value = 'add';
// var winloss_a,winloss_s;
// winloss_s=eval(document.all.winloss_s.value);
// winloss_a=eval(document.all.winloss_a.value); 
 
// if ((winloss_s+winloss_a-100) != <?=100-$abcd?> )
// {
//   if (winloss_s==0 && winloss_a==100)
//   {

//   }else{
//     alert("�W�L����~~�Э��s���");
//     document.all.winloss_s.focus();
//     return false;
//   }
// }
 if(!confirm("�O�_�T�w�g�J�N�z��?"))
 {
  return false;
 }
 document.all.username.value = document.all.ag_count.innerHTML;
}

function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
}
function show_count(w,s) {
	//alert(w+' - '+s);
	var org_str=document.all.ag_count.innerHTML;//org_str.substr(1,5)
	if (s!=''){
		switch(w){
			case 0:	document.all.ag_count.innerHTML = s.substr(1,3)+org_str.substr(3,4);break;
			case 1:document.all.ag_count.innerHTML = org_str.substr(0,3)+s+org_str.substr(4,3);break;
			case 2:document.all.ag_count.innerHTML = org_str.substr(0,4)+s+org_str.substr(5,2);break;
			case 3:document.all.ag_count.innerHTML = org_str.substr(0,5)+s+org_str.substr(6,1);break;
			case 4:document.all.ag_count.innerHTML = org_str.substr(0,6)+s;break;
		}
	}
}
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="LoadBody();">
 <FORM NAME="myFORM" ACTION="" METHOD=POST onSubmit="return SubChk()">
 <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$agid?>">
 <input TYPE=HIDDEN NAME="keys" VALUE="">
 <input TYPE=HIDDEN NAME="username" VALUE="">
 <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
 <input type="hidden" name="winloss_c" value="<?=$winloss_c?>">
 <input type="hidden" name="winloss_s" value="<?=$winloss_s?>">


 <input type="hidden" name="checkpay" value="Y">
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td class="m_tline">&nbsp;&nbsp;<?=$cor_agents?><?=$mem_add?>&nbsp;&nbsp;<select name="agents_id" class="za_select" onChange="self.myFORM.submit();">
          <option value=""></option>
          	<?
			$mysql="select ID,Agname from web_world_data where Status=1 and super='".$agname."'";
			$ag_result = mysql_query( $mysql);
			while ($ag_row = mysql_fetch_array($ag_result)){
			if ($agents_id==$ag_row['Agname']){
						echo "<option value=".$ag_row['Agname']." selected>".$ag_row['Agname']."</option>";				
						$sel_agents=$ag_row['Agname'];
					}else{
						echo "<option value=".$ag_row['Agname'].">".$ag_row['Agname']."</option>";
					
					}
			}
			?>
        </select></td>
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
      <td width="120" class="m_ag_ed"> <?=$sub_user?>d<font id=ag_count><?=substr($agents_id,1,3)?>____</font></td>
      <td>
	  <select size="1" name="num_1" style="border-style: solid; border-width: 0" onChange="show_count(1,this.value);" class="za_select_t">
                <option value=""></option>
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
		</select>
              <select size="1" name="num_2" style="border-style: solid; border-width: 0" onChange="show_count(2,this.value);" class="za_select_t">
                <option value=""></option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>
              <select size="1" name="num_3" style="border-style: solid; border-width: 0" onChange="show_count(3,this.value);" class="za_select_t">
                <option value=""></option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>
			  <select size="1" name="num_4" style="border-style: solid; border-width: 0" onChange="show_count(4,this.value);" class="za_select_t">
                <option value=""></option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>
      </td>
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
        <input type=TEXT name="alias" value="" size=10 maxlength=10 class="za_text">
      </td>
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
        </select>
      </td>
    </tr>
    <tr class="m_bc_ed"> 
      <td class="m_ag_ed"><?=$mem_maxcredit?>:</td>
      <td> 
        <input type=TEXT name="maxcredit" value="" size=10 maxlength=10 class="za_text">
	<?=$mem_status?>/<?=$mem_enable?>:0&nbsp;&nbsp;&nbsp;&nbsp;<?=$mem_disable?>:0&nbsp;&nbsp;&nbsp;&nbsp;<?=$mem_havecredit?>:0
      </td>
    </tr>
    <TR class=m_bc_ed>
      <TD class=m_ag_ed><?=$wld_percent3?>:</TD>
      	<TD><select class=za_select name=winloss_a> 
	<?
	$abcde=$abcd;
	for($i=$abcdef;$i>=0;$i=$i-5){
		$abc=100-$i;
		if ($i==0){
			echo "<option value=$abc selected>".($i/10).$wor_percent."</option>\n";
		}else{
			echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";
		}
	}
	?>
		</select>
       <!--[&nbsp;�����A�����G
	<input type=RADIO name="checkpay" value="N" class="za_dot" {WX_N}>NO&nbsp;&nbsp;&nbsp;
	<input type=RADIO name="checkpay" value="Y" class="za_dot" Y>YES&nbsp;]-->

	</TD></TR>
	 
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
<?
}
?>