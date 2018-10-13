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

$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

require ("../../member/include/traditional.zh-cn.inc.php");

$keys=$_REQUEST['keys'];
if ($keys=='upd'){
	$AddDate=date('Y-m-d H:i:s');
	$memname=$_REQUEST['username'];
	if($_REQUEST['password']<>""){
		$mempasd=substr(md5(md5($_REQUEST['password']."abc123")),0,16);
	}
	$edit = intval($_REQUEST['edit']);
	$d1edit = intval($_REQUEST['d1edit']);
	$credit_balance = intval($_REQUEST['credit_balance']);
	$gold=$_REQUEST['maxcredit'];
	$alias=$_REQUEST['alias'];
	$winloss_c=100-$_REQUEST['winloss_c'];

	$enddate = strtotime($_REQUEST['enddate']);
	$enddate = $enddate>strtotime('2008-08-08') ? date('Y-m-d H:i:s', $enddate) : '';
	
	
		$row = mysql_fetch_array(mysql_query("select setdata from web_super where id='$mid'"));
		$setdata = @unserialize($row['setdata']);
		$setdata['d0_voucher_f5'] = intval($_POST['d0_voucher_f5']);
		$setdata['d0_wager_add'] = intval($_POST['d0_wager_add']);
		$setdata['d0_wager_add_deluser'] = intval($_POST['d0_wager_add_deluser']);
		$setdata['d0_wager_add_edit'] = intval($_POST['d0_wager_add_edit']);
		$setdata['d0_wager_hide'] = intval($_POST['d0_wager_hide']);
		$setdata['d0_wager_hide_deluser'] = intval($_POST['d0_wager_hide_deluser']);
		$setdata['d0_wager_hide_edit'] = intval($_POST['d0_wager_hide_edit']);
		$setdata['d0_ag_online_show'] = intval($_POST['d0_ag_online_show']);
		$setdata['d0_mem_online_show'] = intval($_POST['d0_mem_online_show']);
		$setdata['d0_mem_online_aglog'] = intval($_POST['d0_mem_online_aglog']);
		$setdata['d0_mem_online_domain'] = intval($_POST['d0_mem_online_domain']);
		$setdata['d0_edit_list_re'] = intval($_POST['d0_edit_list_re']);
		$setdata['d0_edit_list_edit'] = intval($_POST['d0_edit_list_edit']);
		$setdata['d0_edit_list_del'] = intval($_POST['d0_edit_list_del']);
		$setdata['d0_edit_list_hide'] = intval($_POST['d0_edit_list_hide']);

		$setdata['d1_wager_add'] = intval($_POST['d1_wager_add']);
		$setdata['d1_wager_add_deluser'] = intval($_POST['d1_wager_add_deluser']);
		$setdata['d1_wager_add_edit'] = intval($_POST['d1_wager_add_edit']);
		$setdata['d1_wager_hide'] = intval($_POST['d1_wager_hide']);
		$setdata['d1_wager_hide_deluser'] = intval($_POST['d1_wager_hide_deluser']);
		$setdata['d1_wager_hide_edit'] = intval($_POST['d1_wager_hide_edit']);
		$setdata['d1_ag_online_show'] = intval($_POST['d1_ag_online_show']);
		$setdata['d1_mem_online_show'] = intval($_POST['d1_mem_online_show']);
		$setdata['d1_mem_online_aglog'] = intval($_POST['d1_mem_online_aglog']);
		$setdata['d1_mem_online_domain'] = intval($_POST['d1_mem_online_domain']);
		$setdata['d1_edit_list_re'] = intval($_POST['d1_edit_list_re']);
		$setdata['d1_edit_list_edit'] = intval($_POST['d1_edit_list_edit']);
		$setdata['d1_edit_list_del'] = intval($_POST['d1_edit_list_del']);
		$setdata['d1_edit_list_hide'] = intval($_POST['d1_edit_list_hide']);

		$setdata['d0show_memip'] = intval($_POST['d0show_memip']);
		$setdata['sendmsg'] = intval($_POST['sendmsg']);
		
		if($_REQUEST['password']<>""){
			$mysql="update web_super set passwd='$mempasd',edit='$edit',d1edit='$d1edit',credit_balance='$credit_balance',Credit='$gold',Alias='$alias',enddate='$enddate',winloss='$winloss_c', setdata='".serialize($setdata)."' where id='$mid'";
		}else{
			$mysql="update web_super set edit='$edit',d1edit='$d1edit',credit_balance='$credit_balance',Credit='$gold',Alias='$alias',enddate='$enddate',winloss='$winloss_c', setdata='".serialize($setdata)."' where id='$mid'";
		}
		mysql_query($mysql) or die ("error 2!");
		echo "<script languag='JavaScript'>self.location='super.php?uid=$uid'</script>";
#	}
}else{
	$sql = "select ID,Agname,Passwd,edit,d1edit,credit_balance,credit,Alias,winloss,setdata, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate from web_super where id=$mid";
	$result = mysql_query($sql);
	$cou=mysql_num_rows($result);
	if($cou==0){
		echo "<script>window.open('$site/index.php','_top')</script>";
		exit;
	}

	$row = mysql_fetch_array($result);

	$credit=$row['credit'];
	$agname=$row['Agname'];
	$winloss=$row['winloss'];
	$enddate = $row['enddate']=='0000-00-00 00:00:00' ? '0' : $row['enddate'];
	$setdata = @unserialize($row['setdata']);
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
 //{ document.all.password.focus(); alert("<?=$mem_alert5?>"); return false; }
 // if(document.all.repassword.value=='')
 //{ document.all.repassword.focus(); alert("<?=$mem_alert6?>"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("<?=$mem_alert7?>"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("股东名称请务必输入!!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("股东信用额度请务必输入!!"); return false; }
// if(document.all.winloss_s.value=='')
// { document.all.winloss_s.focus(); alert("请选择总代理商佔成数!!"); return false; }
// if (eval(document.all.winloss_c.value) > eval(document.all.winloss_s.value))
// { document.all.winloss_s.focus(); alert("总代理商佔成数超过股东佔成数!!"); return false; }
 if(!confirm("是否确定写入?"))
 {
  return false;
 }
}


 function onLoad()
 {
  var winloss = document.getElementById('winloss_c');
  winloss.value = '<?=100-$winloss?>';
  var obj_type_id = document.getElementById('type');
  obj_type_id.value = '';
 }
// -->
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
<FORM NAME="myFORM" ACTION="super_edit.php" METHOD=POST onSubmit="return SubChk()">
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$mid?>">
 <INPUT TYPE=HIDDEN NAME="adddate" VALUE="">
  <INPUT TYPE=HIDDEN NAME="keys" VALUE="upd">
  <INPUT TYPE=HIDDEN NAME="enable" VALUE="Y">
  <input TYPE=HIDDEN NAME="s_type" VALUE="">
  <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
  <input TYPE=HIDDEN NAME="winloss_c" VALUE="10">
  <table width="780" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td class="m_tline">&nbsp;&nbsp;大股东管理--修改</td>

      <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
</tr>
<tr>
<td colspan="2" height="4"></td>
</tr>
</table>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td colspan="2" >基本资料设定</td>
  </tr>
<!--
  <tr class="m_bc_ed">
    <td width="120" class="m_suag_ed">身份:</td>
    <td>
      <select name="type" class="za_select">
        <option value="1">股东</option>
        <option value="2">总代理 ／半退</option>
        <option value="3">总代理 ／全退</option>
        <option value="8">外调</option>
      </select>
    </td>
  </tr>
-->
<input type="HIDDEN" value="" name="type">
  <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120"> <?=$sub_user?>:</td>
    <td><?=$row['Agname']?></td>
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
    <td class="m_suag_ed"><?=$rcl_corp?><?=$sub_name?>:</td>
    <td>
      <input type=TEXT name="alias" value="<?=$row['Alias']?>" size=10 maxlength=10 class="za_text">
    </td>
  </tr>

</table>

  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" >资料设定</td>
    </tr>
	<tr class='m_bc_ed'>
	  <td class='m_suag_ed' width='120'>(登0)流水单注:</td>
		<td>
		<?
			$selected[0] = $setdata['d0_voucher_f5']==1 ? '' : 'selected';
			$selected[1] = $setdata['d0_voucher_f5']==1 ? 'selected' : '';
		?>
			<select class='za_select' name='d0_voucher_f5'>
				<option value='0' <?=$selected[0]?>>自动更新</option>
				<option value='1' <?=$selected[1]?>>手动更新</option>
			</select>
		</td>
	</tr>

	<tr class='m_bc_ed'>
	  <td class='m_suag_ed' width='120'>(登0)添单账号:</td>
		<td>
		<?
			$selected[0] = $setdata['d0_wager_add']==1 ? '' : 'selected';
			$selected[1] = $setdata['d0_wager_add']==1 ? 'selected' : '';
			$deluser_checked = $setdata['d0_wager_add_deluser']==1 ? 'checked' : '';
			$edit_checked = $setdata['d0_wager_add_edit']==1 ? 'checked' : '';
		?>
			<select class='za_select' name='d0_wager_add'>
				<option value='0' <?=$selected[0]?>>禁用</option>
				<option value='1' <?=$selected[1]?>>启用</option>
			</select>
			&nbsp;&nbsp;<input type="checkbox" name="d0_wager_add_deluser" value='1' <?=$deluser_checked?>>帐号删除
			&nbsp;&nbsp;<input type="checkbox" name="d0_wager_add_edit" value='1' <?=$edit_checked?>>详细投注
		</td>
	</tr>

	<tr class='m_bc_ed'>
	  <td class='m_suag_ed' width='120'>(登0)隐单账号:</td>
		<td>
		<?
			$selected[0] = $setdata['d0_wager_hide']==1 ? '' : 'selected';
			$selected[1] = $setdata['d0_wager_hide']==1 ? 'selected' : '';
			$deluser_checked = $setdata['d0_wager_hide_deluser']==1 ? 'checked' : '';
			$edit_checked = $setdata['d0_wager_hide_edit']==1 ? 'checked' : '';
		?>
			<select class='za_select' name='d0_wager_hide'>
				<option value='0' <?=$selected[0]?>>禁用</option>
				<option value='1' <?=$selected[1]?>>启用</option>
			</select>
			&nbsp;&nbsp;<input type="checkbox" name="d0_wager_hide_deluser" value='1' <?=$deluser_checked?>>帐号删除
			&nbsp;&nbsp;<input type="checkbox" name="d0_wager_hide_edit" value='1' <?=$edit_checked?>>详细投注
		</td>
	</tr>

    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">(登0)代理在线:</td>
		<td>
		<?
			$selected[0] = $setdata['d0_ag_online_show']==1 ? '' : 'selected';
			$selected[1] = $setdata['d0_ag_online_show']==1 ? 'selected' : '';
		?>
			<select class='za_select' name='d0_ag_online_show'>
				<option value='0' <?=$selected[0]?>>禁用</option>
				<option value='1' <?=$selected[1]?>>启用</option>
			</select>
		</td>
    </tr>

    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">(登0)会员在线:</td>
		<td>
		<?
			$selected[0] = $setdata['d0_mem_online_show']==1 ? '' : 'selected';
			$selected[1] = $setdata['d0_mem_online_show']==1 ? 'selected' : '';
			$checked2 = $setdata['d0_mem_online_aglog']==1 ? 'checked' : '';
			$checked3 = $setdata['d0_mem_online_domain']==1 ? 'checked' : '';
			$checked = $row['edit']==1 ? 'checked' : '';
		?>
			<select class='za_select' name='d0_mem_online_show'>
				<option value='0' <?=$selected[0]?>>禁用</option>
				<option value='1' <?=$selected[1]?>>启用</option>
			</select>
			&nbsp;&nbsp;<input type="checkbox" name="d0_mem_online_aglog" value='1' <?=$checked2?>>代理历史记录
			&nbsp;&nbsp;<input type="checkbox" name="d0_mem_online_domain" value='1' <?=$checked3?>>网址
			&nbsp;&nbsp;<input type="checkbox" name="edit" value='1' <?=$checked?>>投注
		</td>
    </tr>

    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">(登0)改单列表:</td>
		<td>
		<?
			$checked1 = $setdata['d0_edit_list_re']==1 ? 'checked' : '';
			$checked2 = $setdata['d0_edit_list_edit']==1 ? 'checked' : '';
			$checked3 = $setdata['d0_edit_list_del']==1 ? 'checked' : '';
			$checked4 = $setdata['d0_edit_list_hide']==1 ? 'checked' : '';
		?>
			&nbsp;&nbsp;<input type="checkbox" name="d0_edit_list_re" value='1' <?=$checked1?>>对调
			&nbsp;&nbsp;<input type="checkbox" name="d0_edit_list_edit" value='1' <?=$checked2?>>修改
			&nbsp;&nbsp;<input type="checkbox" name="d0_edit_list_del" value='1' <?=$checked3?>>删除
			&nbsp;&nbsp;<input type="checkbox" name="d0_edit_list_hide" value='1' <?=$checked4?>>隐藏
		</td>
    </tr>

	<tr class='m_bc_ed'>
	  <td class='m_suag_ed' width='120'>(登1)添单账号:</td>
		<td>
		<?
			$selected[0] = $setdata['d1_wager_add']==1 ? '' : 'selected';
			$selected[1] = $setdata['d1_wager_add']==1 ? 'selected' : '';
			$deluser_checked = $setdata['d1_wager_add_deluser']==1 ? 'checked' : '';
			$edit_checked = $setdata['d1_wager_add_edit']==1 ? 'checked' : '';
		?>
			<select class='za_select' name='d1_wager_add'>
				<option value='0' <?=$selected[0]?>>禁用</option>
				<option value='1' <?=$selected[1]?>>启用</option>
			</select>
			&nbsp;&nbsp;<input type="checkbox" name="d1_wager_add_deluser" value='1' <?=$deluser_checked?>>帐号删除
			&nbsp;&nbsp;<input type="checkbox" name="d1_wager_add_edit" value='1' <?=$edit_checked?>>详细投注
		</td>
	</tr>

	<tr class='m_bc_ed'>
	  <td class='m_suag_ed' width='120'>(登1)隐单账号:</td>
		<td>
		<?
			$selected[0] = $setdata['d1_wager_hide']==1 ? '' : 'selected';
			$selected[1] = $setdata['d1_wager_hide']==1 ? 'selected' : '';
			$deluser_checked = $setdata['d1_wager_hide_deluser']==1 ? 'checked' : '';
			$edit_checked = $setdata['d1_wager_hide_edit']==1 ? 'checked' : '';
		?>
			<select class='za_select' name='d1_wager_hide'>
				<option value='0' <?=$selected[0]?>>禁用</option>
				<option value='1' <?=$selected[1]?>>启用</option>
			</select>
			&nbsp;&nbsp;<input type="checkbox" name="d1_wager_hide_deluser" value='1' <?=$deluser_checked?>>帐号删除
			&nbsp;&nbsp;<input type="checkbox" name="d1_wager_hide_edit" value='1' <?=$edit_checked?>>详细投注
		</td>
	</tr>


    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">(登1)代理在线:</td>
		<td>
		<?
			$selected[0] = $setdata['d1_ag_online_show']==1 ? '' : 'selected';
			$selected[1] = $setdata['d1_ag_online_show']==1 ? 'selected' : '';
		?>
			<select class='za_select' name='d1_ag_online_show'>
				<option value='0' <?=$selected[0]?>>禁用</option>
				<option value='1' <?=$selected[1]?>>启用</option>
			</select>
		</td>
    </tr>

    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">(登1)会员在线:</td>
		<td>
		<?
			$selected[0] = $setdata['d1_mem_online_show']==1 ? '' : 'selected';
			$selected[1] = $setdata['d1_mem_online_show']==1 ? 'selected' : '';
			$checked2 = $setdata['d1_mem_online_aglog']==1 ? 'checked' : '';
			$checked3 = $setdata['d1_mem_online_domain']==1 ? 'checked' : '';
			$checked = $row['d1edit']==1 ? 'checked' : '';
		?>
			<select class='za_select' name='d1_mem_online_show'>
				<option value='0' <?=$selected[0]?>>禁用</option>
				<option value='1' <?=$selected[1]?>>启用</option>
			</select>
			&nbsp;&nbsp;<input type="checkbox" name="d1_mem_online_aglog" value='1' <?=$checked2?>>代理历史记录
			&nbsp;&nbsp;<input type="checkbox" name="d1_mem_online_domain" value='1' <?=$checked3?>>网址
			&nbsp;&nbsp;<input type="checkbox" name="d1edit" value='1' <?=$checked?>>投注
		</td>
    </tr>


    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">(登1)改单列表:</td>
		<td>
		<?
			$checked1 = $setdata['d1_edit_list_re']==1 ? 'checked' : '';
			$checked2 = $setdata['d1_edit_list_edit']==1 ? 'checked' : '';
			$checked3 = $setdata['d1_edit_list_del']==1 ? 'checked' : '';
			$checked4 = $setdata['d1_edit_list_hide']==1 ? 'checked' : '';
		?>
			&nbsp;&nbsp;<input type="checkbox" name="d1_edit_list_re" value='1' <?=$checked1?>>对调
			&nbsp;&nbsp;<input type="checkbox" name="d1_edit_list_edit" value='1' <?=$checked2?>>修改
			&nbsp;&nbsp;<input type="checkbox" name="d1_edit_list_del" value='1' <?=$checked3?>>删除
			&nbsp;&nbsp;<input type="checkbox" name="d1_edit_list_hide" value='1' <?=$checked4?>>隐藏
		</td>
    </tr>

	<tr class='m_bc_ed'>
	  <td class='m_suag_ed' width='120'>登0、登1显示会员IP:</td>
		<td>
		<?php
			$selected[0] = $setdata['d0show_memip']==1 ? '' : 'selected';
			$selected[1] = $setdata['d0show_memip']==1 ? 'selected' : '';
		?>
			<select class='za_select' name='d0show_memip'>
				<option value='0' <?=$selected[0]?>>禁止</option>
				<option value='1' <?=$selected[1]?>>开启</option>
			</select>
		</td>
	</tr>

    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">信用馀额提示:</td>
		<td>
		<?php
			$selected[0] = $row['credit_balance']==1 ? '' : 'selected';
			$selected[1] = $row['credit_balance']==1 ? 'selected' : '';
		?>
			<select class='za_select' name='credit_balance'>
				<option value='0' <?=$selected[0]?>>禁用</option>
				<option value='1' <?=$selected[1]?>>启用</option>
			</select>
		</td>
    </tr>

    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">短信息:</td>
		<td>
		<?php
			$selected[0] = $setdata['sendmsg']==1 ? '' : 'selected';
			$selected[1] = $setdata['sendmsg']==1 ? 'selected' : '';
		?>
			<select class='za_select' name='sendmsg'>
				<option value='0' <?=$selected[0]?>>禁用</option>
				<option value='1' <?=$selected[1]?>>启用</option>
			</select>
		</td>
    </tr>

    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">到期时间:</td>
		<td>
			<input type=TEXT name="enddate" value="<?=$enddate?>" size=20 class="za_text">
			例：2010-12-30 或 2010-12-30 23:59:59 。注：0为永不过期。
		</td>
    </tr>

    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120"><?=$mem_maxcredit?>:</td>
      <td>
        <input type=TEXT name="maxcredit" value="<?=$credit?>" size=20 class="za_text">
        <?=$mem_status?><?=$mem_enable?>:0　<?=$mem_disable?>:0　<?=$mem_havecredit?>:0 </td>
    </tr>

    <tr class="m_bc_ed">
      <td class="m_suag_ed">佔成数:</td>
    <td><select class=za_select name=winloss_c >
	<?
	$winloss=100-$winloss;
	for($i=100;$i>=50;$i=$i-5){
		if($i==100-$winloss){
			echo "<option value=".(100-$i)." selected>".($i/10).$wor_percent."</option>\n";
		}else{
			echo "<option value=".(100-$i).">".($i/10).$wor_percent."</option>\n";
		}
	}
	?>
		</select>

      </td>
    </tr>
    <tr class="m_bc_ed" align="center">
      <td colspan="2">
        <input type=SUBMIT name="OK" value="<?=$submit_ok?>" class="za_button">
        &nbsp; &nbsp; &nbsp;
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
