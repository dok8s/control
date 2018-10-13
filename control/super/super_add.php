<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
echo "<script>if(self == top) parent.location='/'</script>\r\n";
require( "../../member/include/config.inc.php" );
require( "../../member/include/define_function_list.inc.php" );
$uid = $_REQUEST['uid'];
$sql = "select id from web_sytnet where uid='".$uid."' and status=1";
$result = mysql_query( $sql );
$row = mysql_fetch_array( $result );
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
				echo "<script>window.open('".$site."/index.php','_top')</script>";
				exit( );
}
$row = mysql_fetch_array( $result );
$agname = $row['Agname'];
$agid = $row['ID'];
$langx = "zh-cn";
require( "../../member/include/traditional.".$langx.".inc.php" );
$keys = $_REQUEST['keys'];
if ( $keys == "add" )
{
				$AddDate = date( "Y-m-d H:i:s" );
				$memname = $_REQUEST['username'];
				$mempasd = substr(md5(md5($_REQUEST['password']."abc123")),0,16);
				$edit = intval($_REQUEST['edit']);
				$d1edit = intval($_REQUEST['d1edit']);
				$credit_balance = intval($_REQUEST['credit_balance']);				
				$maxcredit = $_REQUEST['maxcredit'];
				$alias = $_REQUEST['alias'];
				$winloss = $_REQUEST['winloss'];

				$setdata = array();
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

				$mysql = "select * from web_super where Agname='".$memname."'";
				$result = mysql_query( $mysql );
				$count = mysql_num_rows( $result );
				if ( 0 < $count )
				{
								echo wterror( "您输入的帐号 ".$memname." 已经有人使用了，请回上一页重新输入" );
								exit( );
				}
				$mysql = "insert into web_super(Agname,Passwd,Alias,AddDate,edit,d1edit,credit_balance,credit,winloss,setdata) values ('".$memname."','{$mempasd}','{$alias}','{$AddDate}','$edit','$d1edit','$credit_balance','{$maxcredit}','$winloss','".serialize($setdata)."')";
				if ( !mysql_query( $mysql ) )
				{
								exit( "error 1" );
				}
				echo "<script languag='JavaScript'>self.location='super.php?uid=".$uid."'</script>";
}
else
{
				echo "<html style=\"width: 98%;margin: 0 auto;\">\r\n<head>\r\n<title>main</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n<style type=\"text/css\">\r\n<!--\r\n.m_suag_ed {  background-color: #BACBC1; text-align: right}\r\n-->\r\n</style>\r\n<SCRIPT>\r\n<!--\r\n\r\nfunction SubChk(){\r\n\r\n\tif(document.all.username.value=='')\r\n\t\t{ document.all.username.focus(); alert(\"";
				echo $mem_alert3;
				echo "\"); return false; }\r\n\tif(document.all.password.value=='')\r\n\t\t{ document.all.password.focus(); alert(\"";
				echo $mem_alert5;
				echo "\"); return false; }\r\n\tif(document.all.repassword.value=='')\r\n\t{ document.all.repassword.focus(); alert(\"";
				echo $mem_alert6;
				echo "\"); return false; }\r\n\tif(document.all.password.value != document.all.repassword.value)\r\n\t\t{ document.all.password.focus(); alert(\"";
				echo $mem_alert7;
				echo "\"); return false; }\r\n\tif(document.all.alias.value=='')\r\n\t\t{ document.all.alias.focus(); alert(\"";
				echo $mem_alert8;
				echo "\"); return false; }\r\n\tif(!confirm(\"";
				echo $mem_alert10;
				echo "\")){return false;}\r\n\r\n}\r\n\r\n\r\n function onLoad()\r\n {\r\n  var obj_type_id = document.getElementById('type');\r\n  obj_type_id.value = '';\r\n }\r\n// -->\r\n</SCRIPT>\r\n</head>\r\n\r\n<body bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\">\r\n<FORM NAME=\"myFORM\" ACTION=\"super_add.php\" METHOD=POST onsubmit=\"return SubChk()\">\r\n <INPUT TYPE=HIDDEN NAME=\"id\" VALUE=\"";
				echo $agid;
				echo "\">\r\n  <input TYPE=HIDDEN NAME=\"uid\" VALUE=\"";
				echo $uid;
				echo "\">\r\n<INPUT TYPE=HIDDEN NAME=\"keys\" VALUE=\"add\">\r\n  <table width=\"780\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tr>\r\n    <td class=\"m_tline\">&nbsp;&nbsp;大";
				echo $cor_manage;
				echo "--";
				echo $mem_addnewuser;
				echo "</td>\r\n    <td width=\"30\"><img src=\"/images/control/zh-tw/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"2\" height=\"4\"></td>\r\n</tr>\r\n</table>\r\n<table width=\"780\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"m_tab_ed\">\r\n  <tr class=\"m_title_edit\">\r\n    <td colspan=\"2\" >";
				echo $mem_accset;
				echo "</td>\r\n  </tr>\r\n<!--\r\n  <tr class=\"m_bc_ed\">\r\n    <td width=\"120\" class=\"m_suag_ed\">身份:</td>\r\n    <td>\r\n      <select name=\"type\" class=\"za_select\">\r\n        <option value=\"1\">股东</option>\r\n        <option value=\"2\">总代理 ／半退</option>\r\n        <option value=\"3\">总代理 ／全退</option>\r\n        <option value=\"8\">外调</option>\r\n      </select>\r\n    </td>\r\n  </tr>\r\n-->\r\n<input type=\"HIDDEN\" value=\"\" name=\"type\">\r\n  <tr class=\"m_bc_ed\">\r\n      <td class=\"m_suag_ed\" width=\"120\">\r\n        ";
				echo $sub_user;
				echo ":</td>\r\n      <td><input name=\"username\" type=text class=\"za_text\" id=\"username\" value=\"\" size=8 maxlength=10>\r\n      </td>\r\n  </tr>\r\n  <tr class=\"m_bc_ed\">\r\n    <td class=\"m_suag_ed\">";
				echo $sub_pass;
				echo ":</td>\r\n    <td>\r\n      <input type=PASSWORD name=\"password\" value=\"\" size=8 maxlength=10 class=\"za_text\">\r\n    </td>\r\n  </tr>\r\n  <tr class=\"m_bc_ed\">\r\n    <td class=\"m_suag_ed\">";
				echo $acc_repasd;
				echo ":</td>\r\n    <td>\r\n      <input type=PASSWORD name=\"repassword\" value=\"\" size=8 maxlength=10 class=\"za_text\">\r\n    </td>\r\n  </tr>\r\n  <tr class=\"m_bc_ed\">\r\n    <td class=\"m_suag_ed\">";
				echo $rcl_corp;
				echo $sub_name;
				echo ":</td>\r\n    <td>\r\n      <input type=TEXT name=\"alias\" value=\"\" size=10 maxlength=10 class=\"za_text\">\r\n    </td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width=\"780\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"m_tab_ed\">\r\n    <tr class=\"m_title_edit\">\r\n      <td colspan=\"2\" >资料设定</td>\r\n    </tr>
				<tr class='m_bc_ed'>
				  <td class='m_suag_ed' width='120'>(登0)添单账号:</td>
					<td>
						<select class='za_select' name='d0_wager_add'>
							<option value='0' selected>禁用</option>
							<option value='1' >启用</option>
						</select>
						&nbsp;&nbsp;<input type='checkbox' name='d0_wager_add_deluser' value='1'>帐号删除
						&nbsp;&nbsp;<input type='checkbox' name='d0_wager_add_edit' value='1'>详细投注
					</td>
				</tr>
				<tr class='m_bc_ed'>
				  <td class='m_suag_ed' width='120'>(登0)隐单账号:</td>
					<td>
						<select class='za_select' name='d0_wager_hide'>
							<option value='0' selected>禁用</option>
							<option value='1' >启用</option>
						</select>
						&nbsp;&nbsp;<input type='checkbox' name='d0_wager_hide_deluser' value='1'>帐号删除
						&nbsp;&nbsp;<input type='checkbox' name='d0_wager_hide_edit' value='1'>详细投注
					</td>
				</tr>
				<tr class='m_bc_ed'>
				  <td class='m_suag_ed' width='120'>(登0)代理在线:</td>
					<td>
						<select class='za_select' name='d0_ag_online_show'>
							<option value='0' selected>禁用</option>
							<option value='1' >启用</option>
						</select>
					</td>
				</tr>
				<tr class='m_bc_ed'>
				  <td class='m_suag_ed' width='120'>(登0)会员在线:</td>
					<td>
						<select class='za_select' name='d0_mem_online_show'>
							<option value='0' selected>禁用</option>
							<option value='1' >启用</option>
						</select>
						&nbsp;&nbsp;<input type='checkbox' name='d0_mem_online_aglog' value='1'>代理历史记录
						&nbsp;&nbsp;<input type='checkbox' name='d0_mem_online_domain' value='1'>网址
						&nbsp;&nbsp;<input type='checkbox' name='edit' value='1'>投注
					</td>
				</tr>
				<tr class='m_bc_ed'>
				  <td class='m_suag_ed' width='120'>(登0)改单列表:</td>
					<td>
						&nbsp;&nbsp;<input type='checkbox' name='d0_edit_list_re' value='1'>对调
						&nbsp;&nbsp;<input type='checkbox' name='d0_edit_list_edit' value='1'>修改
						&nbsp;&nbsp;<input type='checkbox' name='d0_edit_list_del' value='1'>删除
						&nbsp;&nbsp;<input type='checkbox' name='d0_edit_list_hide' value='1'>隐藏
					</td>
				</tr>

				<tr class='m_bc_ed'>
				  <td class='m_suag_ed' width='120'>(登1)添单账号:</td>
					<td>
						<select class='za_select' name='d1_wager_add'>
							<option value='0' selected>禁用</option>
							<option value='1' >启用</option>
						</select>
						&nbsp;&nbsp;<input type='checkbox' name='d1_wager_add_deluser' value='1'>帐号删除
						&nbsp;&nbsp;<input type='checkbox' name='d1_wager_add_edit' value='1'>详细投注
					</td>
				</tr>
				<tr class='m_bc_ed'>
				  <td class='m_suag_ed' width='120'>(登1)隐单账号:</td>
					<td>
						<select class='za_select' name='d1_wager_hide'>
							<option value='0' selected>禁用</option>
							<option value='1' >启用</option>
						</select>
						&nbsp;&nbsp;<input type='checkbox' name='d1_wager_hide_deluser' value='1'>帐号删除
						&nbsp;&nbsp;<input type='checkbox' name='d1_wager_hide_edit' value='1'>详细投注
					</td>
				</tr>
				<tr class='m_bc_ed'>
				  <td class='m_suag_ed' width='120'>(登1)代理在线:</td>
					<td>
						<select class='za_select' name='d1_ag_online_show'>
							<option value='0' selected>禁用</option>
							<option value='1' >启用</option>
						</select>
					</td>
				</tr>
				<tr class='m_bc_ed'>
				  <td class='m_suag_ed' width='120'>(登1)会员在线:</td>
					<td>
						<select class='za_select' name='d1_mem_online_show'>
							<option value='0' selected>禁用</option>
							<option value='1' >启用</option>
						</select>
						&nbsp;&nbsp;<input type='checkbox' name='d1_mem_online_aglog' value='1'>代理历史记录
						&nbsp;&nbsp;<input type='checkbox' name='d1_mem_online_domain' value='1'>网址
						&nbsp;&nbsp;<input type='checkbox' name='d1edit' value='1'>投注
					</td>
				</tr>
				<tr class='m_bc_ed'>
				  <td class='m_suag_ed' width='120'>(登1)改单列表:</td>
					<td>
						&nbsp;&nbsp;<input type='checkbox' name='d1_edit_list_re' value='1'>对调
						&nbsp;&nbsp;<input type='checkbox' name='d1_edit_list_edit' value='1'>修改
						&nbsp;&nbsp;<input type='checkbox' name='d1_edit_list_del' value='1'>删除
						&nbsp;&nbsp;<input type='checkbox' name='d1_edit_list_hide' value='1'>隐藏
					</td>
				</tr>

				<tr class='m_bc_ed'>
				  <td class='m_suag_ed' width='120'>登0、登1显示会员IP:</td>
					<td>
						<select class='za_select' name='d0show_memip'>
							<option value='0' >禁止</option>
							<option value='1' selected>开启</option>
						</select>
					</td>
				</tr>
				<tr class='m_bc_ed'>
				  <td class='m_suag_ed' width='120'>信用余额提示:</td>
					<td>
						<select class='za_select' name='credit_balance'>
							<option value='0' selected>禁用</option>
							<option value='1' >启用</option>
						</select>
					</td>
				</tr>
				<tr class='m_bc_ed'>
				  <td class='m_suag_ed' width='120'>短信息:</td>
					<td>
						<select class='za_select' name='sendmsg'>
							<option value='0' selected>禁用</option>
							<option value='1' >启用</option>
						</select>
					</td>
				</tr>";
				
				echo "<tr class=\"m_bc_ed\">\r\n      <td class=\"m_suag_ed\" width=\"120\">";
				echo $mem_maxcredit;
				echo ":</td>\r\n      <td>\r\n        <input type=TEXT name=\"maxcredit\" value=\"0\" size=10 maxlength=10 class=\"za_text\">\r\n        ";
				echo $mem_status;
				echo " / ";
				echo $mem_enable;
				echo ":0　";
				echo $mem_disable;
				echo ":0　";
				echo $mem_havecredit;
				echo ":0 </td>\r\n    </tr>\r\n    <tr class=\"m_bc_ed\">\r\n      <td class=\"m_suag_ed\" width=\"120\">占成数:</td>\r\n      <td>
        <select name=\"winloss\" class=\"za_select\">
          <option value=\"100\">10 成</option>
\t \t\t\t  <option value=\"95\">9.5 成</option>
          <option value=\"90\" selected>9 成</option>
          <option value=\"85\">8.5 成</option>
          <option value=\"80\">8 成</option>
          <option value=\"75\">7.5 成</option>
          <option value=\"70\">7 成</option>
          <option value=\"65\">6.5 成</option>
          <option value=\"60\">6 成</option>
          <option value=\"55\">5.5 成</option>
          <option value=\"50\">5 成</option>
          </select>
      </td>\r\n    </tr>\r\n\r\n    <tr class=\"m_bc_ed\" align=\"center\">\r\n      <td colspan=\"2\">\r\n        <input type=SUBMIT name=\"OK\" value=\"";
				echo $submit_ok;
				echo "\" class=\"za_button\">\r\n        &nbsp; &nbsp; &nbsp;\r\n        <input type=BUTTON name=\"FormsButton2\" value=\"";
				echo $submit_cancle;
				echo "\" id=\"FormsButton2\" onClick=\"javascript:history.go(-1)\" class=\"za_button\">\r\n      </td>\r\n    </tr>\r\n  </table>\r\n\r\n</form>\r\n</body>\r\n</html>\r\n\r\n";
}
?>
