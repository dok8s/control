<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
/*********************/

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
else
{
				
				$type = $_REQUEST['type'];
				switch ( $type )
				{
				case "FT" :
								$mysql = "update web_system set udp_ft_r=".$_REQUEST['SC1'].",udp_ft_hr=".$_REQUEST['SC2'].",udp_ft_re=".$_REQUEST['SC3'].",udp_ft_pd=".$_REQUEST['SC4'].",udp_ft_t=".$_REQUEST['SC5'].",udp_ft_f=".$_REQUEST['SC6'].",udp_ft_pr=".$_REQUEST['SC7'].",udp_ft_p=".$_REQUEST['SC8'];
								mysql_query( $mysql );
								break;
				case "CN" :
								$ruid = $_REQUEST['ruid'] + 0;
								if ( $_REQUEST['PA2'] == "" || $_REQUEST['SC0'] == "" || $_REQUEST['SC0_en'] == "" || $_REQUEST['US2'] == "" )
								{
												exit( );
								}
								$mysql = "update web_system set uid=".$ruid.",datasite='".$_REQUEST['SC0']."',datasite_tw='".$_REQUEST['SC0_tw']."',datasite_en='".$_REQUEST['SC0_en']."',username='".$_REQUEST['US1']."',username_tw='".$_REQUEST['US2']."',  username_en='".$_REQUEST['US3']."', password='".$_REQUEST['PA2']."',zh1='".$_REQUEST['zh1']."',zh2='".$_REQUEST['zh2']."', uid_cn='".$_REQUEST['uid_cn']."', uid_tw='".$_REQUEST['uid_tw']."', uid_en='".$_REQUEST['uid_en']."',old_http='".$_REQUEST['old_http']."',new_http='".$_REQUEST['new_http']."',datasite_old='".$_REQUEST['SC0_old']."',datasite_old_tw='".$_REQUEST['SC0_old_tw']."',datasite_old_en='".$_REQUEST['SC0_old_en']."'";
								mysql_query( $mysql );
								break;
				case "ST" :
								$mysql = "update web_system set website=".intval($_REQUEST['SC3']).", systime='".$_REQUEST['systime']."',systime1='".$_REQUEST['systime1']."'";
								mysql_query( $mysql );
								$mysql = "update web_member set oid=''";
								mysql_query( $mysql );
								$mysql = "update foot_match set r_show=0,hr_show=0,re_show=0,pd_show=0,hpd_show=0,t_show=0,f_show=0,p_show=0,pr_show=0 where m_date='".date( "m-d" )."'";
								mysql_query( $mysql );
								$mysql = "update foot_match set f_r_show=0,f_hr_show=0,f_pd_show=0,f_hpd_show=0,f_t_show=0,f_f_show=0,f_p_show=0,f_pr_show=0 where m_date='".date( "m-d" )."'";
								mysql_query( $mysql );
								$mysql = "update foot_match set r_show=0,pr_show=0 where m_date='".date( "m-d" )."'";
								mysql_query( $mysql );
								$mysql = "update sp_match set mshow=0 where mshow=1 and m_date>='".date( "m-d" )."'";
								mysql_query( $mysql );
								break;
				case "NOUD" :
								$mysql = "update web_system set msg_update=".$_REQUEST['set'];
								mysql_query( $mysql );
								break;
				case "SI" :
								$mysql = "update web_system set alert_tw='".$_REQUEST['systime']."',salert=".$_REQUEST['SC3'];
								mysql_query( $mysql );
								break;
				case "SI2" :
								$mysql = "update web_system set alert2_tw='".$_REQUEST['systime']."',s2alert=".$_REQUEST['SC3'];
								mysql_query( $mysql );
								break;
				case "BS" :
								$mysql = "update web_system set alert3_tw='".$_REQUEST['systime']."',s3alert=".$_REQUEST['SC3'];
								mysql_query( $mysql );
								break;
				case "NS" :
								$mysql = "update web_system set alert4_tw='".$_REQUEST['systime']."',s4alert=".$_REQUEST['SC3'];
								mysql_query( $mysql );
								break;
				case "BN" :
								$mysql = "update web_system set alert5_tw='".$_REQUEST['systime']."',s5alert=".$_REQUEST['SC3'];
								mysql_query( $mysql );
								break;
				case "BT" :
								$mysql = "update web_system set m=".$_REQUEST['SC1'].",r=".$_REQUEST['SC2'].",ou=".$_REQUEST['SC3'].",pd=".$_REQUEST['SC4'].",t=".$_REQUEST['SC5'].",f=".$_REQUEST['SC6'].",p=".$_REQUEST['SC7'].",fs=".$_REQUEST['SC8'].",max=".$_REQUEST['SC9'];
								mysql_query( $mysql );
								break;
				case "RB" :
								$mysql = "update web_system set runball=".$_REQUEST['runball'];
								mysql_query( $mysql );
								break;
				case "RW" :
								$mysql = "update web_system set wager=".$_REQUEST['wager'].",wager_sec=".$_REQUEST['wager_sec'];
								mysql_query( $mysql );
								break;
				case "BO" :
								$mysql = ( "update web_system set beton=".( $_REQUEST['beton'] + 0 ) ).",bet_time=".( $_REQUEST['bet_time'] + 0 );
								mysql_query( $mysql );
								break;
				case "AO" :
								$mysql = ( "update web_system set acton=".( $_REQUEST['acton'] + 0 ) ).",bet_time=".( $_REQUEST['bet_time'] + 0 );
								mysql_query( $mysql );
								break;
				case "OP" :
								$mysql = "update web_system set anop=".( $_REQUEST['anop'] + 0 );
								mysql_query( $mysql );
								break;
				case "WP" :
								$mysql = "update web_system set wageron=".( $_REQUEST['wageron'] + 0 );
								mysql_query( $mysql );
								break;
				case "B2" :
								$mysql = "update web_system set b2=".( $_REQUEST['b1'] + 0 );
								mysql_query( $mysql );
								break;
				case "setmin": 
								$mysql = "update web_system set setmin=".intval($_REQUEST['setmin']);
								mysql_query( $mysql );
								break;
				case "IP" :
								$mysql = ( "update web_system set allowip=".( $_REQUEST['allowip'] + 0 ) ).",logip='".$_REQUEST['logip']."'";
								mysql_query( $mysql );
								break;
								
				case "d0oneonline" : 
								$sql = "select setdata from web_system limit 0,1";
								$result = mysql_query( $sql );
								$rt = mysql_fetch_array( $result );
								$setdata = @unserialize($rt['setdata']);
								$setdata['d0oneonline']=intval($_REQUEST['d0oneonline']);
								$mysql = "update web_system set setdata='".serialize($setdata)."'";
								mysql_query( $mysql );
								break;
				case "opendel" : 
								$sql = "select setdata from web_system limit 0,1";
								$result = mysql_query( $sql );
								$rt = mysql_fetch_array( $result );
								$setdata = @unserialize($rt['setdata']);
								$setdata['opendel']=intval($_REQUEST['opendel']);
								$mysql = "update web_system set setdata='".serialize($setdata)."'";
								mysql_query( $mysql );
								break;
				case "resetwinloss" : 
								$sql = "select setdata from web_system limit 0,1";
								$result = mysql_query( $sql );
								$rt = mysql_fetch_array( $result );
								$setdata = @unserialize($rt['setdata']);
								$setdata['resetwinloss']=intval($_REQUEST['resetwinloss']);
								$mysql = "update web_system set setdata='".serialize($setdata)."'";
								mysql_query( $mysql );
								break;
				case "agents_ip_drop" : 
								$sql = "select setdata from web_system limit 0,1";
								$result = mysql_query( $sql );
								$rt = mysql_fetch_array( $result );
								$setdata = @unserialize($rt['setdata']);
								$setdata['agents_ip_drop']=$_REQUEST['agents_ip_drop'];
								$mysql = "update web_system set setdata='".serialize($setdata)."'";
								mysql_query( $mysql );
								break;
				case "default_agent" : 
								$sql = "select setdata from web_system limit 0,1";
								$result = mysql_query( $sql );
								$rt = mysql_fetch_array( $result );
								$setdata = @unserialize($rt['setdata']);
								$setdata['default_agent']=$_REQUEST['default_agent'];
								$mysql = "update web_system set setdata='".serialize($setdata)."'";
								mysql_query( $mysql );
								break;
				case "auto_check" : 
								$sql = "select setdata from web_system limit 0,1";
								$result = mysql_query( $sql );
								$rt = mysql_fetch_array( $result );
								$setdata = @unserialize($rt['setdata']);
								$setdata['auto_check']=intval($_REQUEST['auto_check']);
								$mysql = "update web_system set setdata='".serialize($setdata)."'";
								mysql_query( $mysql );
								break;
				case "danger_time" : 
								$sql = "select setdata from web_system limit 0,1";
								$result = mysql_query( $sql );
								$rt = mysql_fetch_array( $result );
								$setdata = @unserialize($rt['setdata']);
								$setdata['danger_time']=intval($_REQUEST['danger_time']);
								$mysql = "update web_system set setdata='".serialize($setdata)."'";
								mysql_query( $mysql );
								break;
								
				}
				$sql = "select * from web_system limit 0,1";
				$result = mysql_query( $sql );
				$row = mysql_fetch_array( $result );
				$setdata = @unserialize($row['setdata']);
				echo "<html>\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n<SCRIPT language=javaScript src=\"/js/report_func.js\" type=text/javascript></SCRIPT>\r\n<style type=\"text/css\">\r\n<!--\r\n.m_ag_ed {  background-color: #bdd1de; text-align: right}\r\n-->\r\n</style>\r\n</head>\r\n<body  bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\" >\r\n<table width=\"775\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n  <tr>\r\n    <td class=\"m_tline\">&nbsp;&nbsp; 系统参数 -- 详细设置&nbsp;&nbsp;&nbsp; </td>\r\n    <td width=\"30\"><img src=\"/images/control/zh-tw/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n  </tr>\r\n  <tr>\r\n    <td colspan=\"2\" height=\"4\"></td>\r\n  </tr>\r\n</table>\r\n\r\n<table width=\"770\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <tr class=\"m_bc_ed\">\r\n    <td colspan=\"7\" align=\"center\" bgcolor=\"6EC13E\"><b>数据来源 </b></td>\r\n  </tr>\r\n  <TR class=m_title_edit>\r\n    <td width=88>&nbsp;</td>\r\n    <td width=170>网址 </td>\r\n    <td width=150>简体</td>\r\n    <td width=150>繁体</td>\r\n    <td width=150>英文</td>\r\n    <td width=100>uid接收方式</td>\r\n    <td width=70>&nbsp; </td>\r\n  </TR>\r\n  <form name=FTR  method=post>\r\n    <TR class=m_cen>\r\n      <td height=\"23\" align=right class=m_ag_ed>用户名 </td>\r\n      <td align=center></td>\r\n      <td align=center><input class=za_text  maxLength=10 size=10 value=\"";
				echo $row['username'];
				echo "\" name=US1></td>\r\n      <td align=center><input class=za_text  maxlength=10 size=10 value=\"";
				echo $row['username_tw'];
				echo "\" name=US2></td>\r\n      <td align=center><input class=za_text  maxlength=10 size=10 value=\"";
				echo $row['username_en'];
				echo "\" name=US3>\r\n      </td>\r\n      <td><input type=\"radio\" name=\"ruid\" value=0 ";
				if ( $row['uid'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n        软件接收</td>\r\n      <td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok3></td>\r\n    </TR>
    <TR class=m_cen>
      <td class=m_ag_ed align=right>密码/UID</td>
      <td align=center><input class=za_text  size=23 value='".$row['password']."' name=PA2></td>
	  <td align=center><input class=za_text  size=23 value='".$row['uid_cn']."' name='uid_cn'></td>
      <td align=center><input class=za_text  size=23 value='".$row['uid_tw']."' name='uid_tw'></td>
      <td align=center><input class=za_text  size=23 value='".$row['uid_en']."' name='uid_en'></td>
      <td><input name=\"ruid\" type=\"radio\" value=1 ";
				if ( $row['uid'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n        程序接收</td>\r\n      <td>&nbsp;</td>\r\n    </TR>";
				
				echo "<TR class=m_cen>
      <td class=m_ag_ed align=right>接水网址</td>\r\n<td><input class=za_text  size=18 value=\"";
				echo $row['Old_http'];
				echo "\" name=old_http><span style=\"color=red\">*备用</span> </td>\r\n  ";
				echo "<td align=center><input class=za_text  size=23 value=\"";
				echo $row['datasite'];
				echo "\" name=SC0></td>\r\n      <td align=center><input class=za_text  size=23 value=\"";
				echo $row['datasite_tw'];
				echo "\" name=SC0_tw></td>\r\n      <td align=center><input class=za_text  size=23 value=\"";
				echo $row['datasite_en'];
				echo "\" name=SC0_en></td>\r\n 
      <td>&nbsp;</td>\r\n
	  <td>&nbsp;</td></TR>";

				echo "<TR class=m_cen>
      <td class=m_ag_ed align=right>备用帐号</td>\r\n<td align=left style=\"color:red\">* 多个帐号请用\",\"隔开</td>\r\n  ";
				echo "<td align=center><input class=za_text  size=23 value=\"";
				echo $row['datasite_old'];
				echo "\" name=SC0_old></td>\r\n      <td align=center><input class=za_text  size=23 value=\"";
				echo $row['zh1'];
				echo "\" name=zh1></td>\r\n      <td align=center><input class=za_text  size=23 value=\"";
				echo $row['zh2'];
				echo "\" name=zh2></td>\r\n 
      <td>&nbsp;</td>\r\n
	  <td>&nbsp;</td></TR>";	
	  
	  
				/*echo "<TR class=m_cen>
      <td class=m_ag_ed align=right></td>\r\n";
				echo "<td align=center ><input class=za_text  size=23 value=\"";
				echo $row['datasite_old'];
				echo "\" name=></td>\r\n      <td align=left style=\"color=red\" colspan=\"3\">* 多个帐号请用\",\"隔开</td>\r\n 
	  <td>&nbsp;</td><td>&nbsp;</td></TR>";*/
	  
	  			
	 
				echo "<TR class=m_cen>
      <td class=m_ag_ed align=right>新版网</td>
      <td align=center><input class=za_text  size=23 value='".$row['New_http']."' name=new_http></td>
      <td align=center colspan=\"3\">&nbsp;</td>
	  <td>&nbsp;</td><td>&nbsp;</td></TR>";
				echo "\r\n    <input type=hidden value=\"CN\" name=type>\r\n  </form>\r\n</table>\r\n<!--<br>\r\n<table width=\"770\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <tr class=\"m_bc_ed\"><td colspan=\"10\" align=\"center\" bgcolor=\"6EC13E\"><b>更新时间</b></td></tr>\r\n<TR class=m_title_edit>\r\n    <td width=80>&nbsp;</td>\r\n    <td width=70> 单式</td>\r\n    <td width=70>上半场</td>\r\n    <td width=70>走地</td>\r\n    <td width=70>波胆</td>\r\n    <td width=70>入球</td>\r\n    <td width=70>半全场</td>\r\n    <td width=70>让球过关</td>\r\n    <td width=70>标准过关</td>\r\n    <td width=80>&nbsp; </td>\r\n  </TR>\r\n  <form name=FTR  method=post>\r\n    <TR class=m_cen>\r\n      <td class=m_ag_ed align=right> 足(网/排/篮)球 </td>\r\n      <td align=right><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['udp_ft_r'];
				echo "\" name=SC1></td>\r\n      <td align=right><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['udp_ft_hr'];
				echo "\" name=SC2></td>\r\n      <td align=right><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['udp_ft_re'];
				echo "\" name=SC3></td>\r\n      <td><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['udp_ft_pd'];
				echo "\" name=SC4></td>\r\n      <td><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['udp_ft_t'];
				echo "\" name=SC5></td>\r\n      <td><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['udp_ft_f'];
				echo "\" name=SC6></td>\r\n      <td><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['udp_ft_pr'];
				echo "\" name=SC7></td>\r\n      <td><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['udp_ft_p'];
				echo "\" name=SC8></td>\r\n      <td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n\t  <input type=hidden value=\"FT\" name=type>\r\n     </TR> \r\n  </form>\r\n</table>-->\r\n<br>\r\n<table width=\"770\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <tr class=\"m_bc_ed\"><td colspan=\"11\" align=\"center\" bgcolor=\"6EC13E\"><b>单注最低限額</b></td></tr>\r\n<TR class=m_title_edit>\r\n    <td width=50>&nbsp;</td>\r\n    <td width=70>独赢</td>\r\n    <td width=70>让球</td>\r\n    <td width=70>大小盘</td>\r\n    <td width=70>波胆</td>\r\n    <td width=70>入球</td>\r\n    <td width=70>半全场</td>\r\n    <td width=70>过关</td>\r\n    <td width=70>冠军</td>\r\n    <td width=70>最高派彩</td>\r\n    <td width=80>&nbsp; </td>\r\n  </TR>\r\n  <form name=FTR  method=post>\r\n    <TR class=m_cen>\r\n      <td class=m_ag_ed align=right>金额</td>\r\n      <td align=right><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['m'];
				echo "\" name=SC1></td>\r\n      <td align=right><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['r'];
				echo "\" name=SC2></td>\r\n      <td align=right><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['ou'];
				echo "\" name=SC3></td>\r\n      <td><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['pd'];
				echo "\" name=SC4></td>\r\n      <td><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['t'];
				echo "\" name=SC5></td>\r\n      <td><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['f'];
				echo "\" name=SC6></td>\r\n      <td><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['p'];
				echo "\" name=SC7></td>\r\n      <td><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['fs'];
				echo "\" name=SC8></td>\r\n      <td><input class=za_text  maxLength=11 size=5 value=\"";
				echo $row['max'];
				echo "\" name=SC9></td>\r\n      <td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n\t  <input type=hidden value=\"BT\" name=type>\r\n     </TR>\r\n  </form>\r\n</table>";

				echo "
				<br>
				<table width=771 border=0 cellpadding=0 cellspacing=1 class=m_tab_ed>
				  <form name=FTR action='' method=post>
				  <tr class=m_bc_ed><td colspan=5 align=center bgcolor=6EC13E><b>会员注册</b></td></tr>
				  <TR class=m_cen>  <td width=80 align=right class=m_ag_ed>默认代理商</td>  <td width=600 align=left><input type=text name='default_agent' value='".$setdata['default_agent']."'</td>  <td><input class=za_button  type=submit value='确定' name=ft_ch_ok></td></TR>
					<input type=hidden value='default_agent' name='type'>
				  </form>";
				  $setv1 = $setdata['auto_check']==1 ? "checked" : "";
				  $setv2 = $setv1=="" ? "checked" : "";
				  echo "
				  <form name=FTR action='' method=post>
				  <TR class=m_cen>  <td width=80 align=right class=m_ag_ed>审核方式</td>  <td width=600 align=left><input type=radio name='auto_check' value='1' $setv1>自动审核 <input type=radio name='auto_check' value='0' $setv2>人工审核</td> <td><input class=za_button  type=submit value='确定' name=ft_ch_ok></td></TR>
					<input type=hidden value='auto_check' name='type'>
				  </form>
				</table>";

				echo "\r\n<br>\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>代理商可否设置单注最低限額</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> 方式</td>\r\n      <td width=\"600\" align=\"left\"> ";
				if ( $row['setmin'] == 0 )
				{
								$setv1 = "checked";
								$setv2 = "";
				}
				else
				{
								$setv1 = "";
								$setv2 = "checked";
				}
				echo "          <input type=\"radio\" name=\"setmin\" value=0 ";
				echo $setv1;
				echo ">\r\n          不能设置\r\n          <input type=\"radio\" name=\"setmin\" value=1 ";
				echo $setv2;
				echo ">\r\n          可以设置</td>\r\n<td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"setmin\" name=type>\r\n  </form>\r\n</table>";

				echo "\r\n<br>\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>登0单账号多人同时在线</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> 方式</td>\r\n      <td width=\"600\" align=\"left\"> ";
				$setv1 = $setdata['d0oneonline']==1 ? '' : "checked";
				$setv2 = $setdata['d0oneonline']==1 ? "checked" : '';
				echo "          <input type=\"radio\" name=\"d0oneonline\" value='0' ";
				echo $setv1;
				echo ">\r\n          不能同时在线\r\n          <input type=\"radio\" name=\"d0oneonline\" value='1' ";
				echo $setv2;
				echo ">\r\n          可以同时在线</td>\r\n<td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"d0oneonline\" name=type>\r\n  </form>\r\n</table>";

				echo "\r\n<br>\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>登0可否删除会员</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> 方式</td>\r\n      <td width=\"600\" align=\"left\"> ";
				$setv1 = $setdata['opendel']==1 ? '' : "checked";
				$setv2 = $setdata['opendel']==1 ? "checked" : '';
				echo "          <input type=\"radio\" name=\"opendel\" value='0' ";
				echo $setv1;
				echo ">\r\n          不能删除\r\n          <input type=\"radio\" name=\"opendel\" value='1' ";
				echo $setv2;
				echo ">\r\n          可以删除</td>\r\n<td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"opendel\" name=type>\r\n  </form>\r\n</table>";

				echo "\r\n<br>\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>登0可否修改代理占成数</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> 方式</td>\r\n      <td width=\"600\" align=\"left\"> ";
				$setv1 = $setdata['resetwinloss']==1 ? '' : "checked";
				$setv2 = $setdata['resetwinloss']==1 ? "checked" : '';
				echo " <input type='radio' name='resetwinloss' value='0' $setv1>不能修改
				&nbsp; <input type='radio' name='resetwinloss' value='1' $setv2>可以修改</td>
				<td><input class='za_button'  type='submit' value='确定' name='ft_ch_ok'></td>
			    </TR><input type='hidden' value='resetwinloss' name='type'>  </form>\r\n</table>";

				echo "\r\n<br>\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>走地危险球自动确认</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> 时间</td>\r\n      <td width=\"600\" align=\"left\"> ";
				$danger_time = intval($setdata['danger_time']);
				echo "<input name='danger_time' class=za_text size=3 value='".$danger_time."'> 秒，0为自动采用默认值";
				echo "</td>\r\n<td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"danger_time\" name=type>\r\n  </form>\r\n</table>";

				echo "\r\n<br>\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>走地数据源</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> 方式</td>\r\n      <td width=\"600\" align=\"left\"> ";
				if ( $row['b2'] == 0 )
				{
								$setv1 = "checked";
								$setv2 = "";
				}
				else
				{
								$setv1 = "";
								$setv2 = "checked";
				}
				echo "          <input type=\"radio\" name=\"b1\" value=0 ";
				echo $setv1;
				echo ">\r\n          接正网\r\n          <input type=\"radio\" name=\"b1\" value=1 ";
				echo $setv2;
				echo ">\r\n          接公网</td>\r\n<td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"B2\" name=type>\r\n  </form>\r\n</table>";

				echo "\r\n<br>\r\n<table width=\"770\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"4\" align=\"center\" bgcolor=\"6EC13E\"><b>协议栏公告</b></td></tr>\r\n<TR class=m_title_edit>\r\n      <td>前台 </td>\r\n      <td>弹出</td>\r\n      <td>文本内容</td>\r\n      <td>&nbsp;</td>\r\n    </TR><form name=FTR  method=post>\r\n    <TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> 皇冠</td>\r\n      <td width=\"130\" align=\"left\"> <input type=\"radio\" name=\"SC3\" value=1 ";
				if ( $row['s2alert'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n        是\r\n        <input type=\"radio\" name=\"SC3\" value=0 ";
				if ( $row['s2alert'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n        否</td>\r\n      <td width=\"544\"> <input class=za_text  maxLength=150 size=100 value=\"";
				echo  $row['alert2_tw'];
				echo "\" name=systime> </div>\r\n      </td>\r\n      <td width=\"50\"><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok33></td>\r\n      <input type=hidden value=\"SI2\" name=type>\r\n    </TR></form>\r\n    <form name=FTR  method=post><TR class=m_cen>\r\n      <td align=right class=m_ag_ed>代理</td>\r\n      <td align=\"left\"> <input type=\"radio\" name=\"SC3\" value=1 ";
				if ( $row['salert'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n        是\r\n        <input type=\"radio\" name=\"SC3\" value=0 ";
				if ( $row['salert'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n        否</td>\r\n      <td><input class=za_text  maxlength=150 size=100 value=\"";
				echo $row['alert_tw'];
				echo "\" name=systime></td>\r\n      <td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok332></td>\r\n    <input type=hidden value=\"SI\" name=type></TR></form>\r\n\r\n\r\n    <!--form name=FTR  method=post><TR class=m_cen>\r\n      <td align=right class=m_ag_ed>皇马</td>\r\n      <td align=\"left\"> <input type=\"radio\" name=\"SC3\" value=1 ";
				if ( $row['s3alert'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n        是\r\n        <input type=\"radio\" name=\"SC3\" value=0 ";
				if ( $row['s3alert'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n        否</td>\r\n      <td><input class=za_text  maxlength=150 size=100 value=\"";
				echo  $row['alert3_tw'] ;
				echo "\" name=systime></td>\r\n      <td><input class=za_button type=submit value=\"确定\" name=ft_ch_ok334></td>\r\n    <input type=hidden value=\"BS\" name=type></TR></form>\r\n  </form>\r\n\r\n    <form name=FTR  method=post><TR class=m_cen>\r\n      <td align=right class=m_ag_ed>皇室</td>\r\n      <td align=\"left\"> <input type=\"radio\" name=\"SC3\" value=1 ";
				if ( $row['s4alert'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n        是\r\n        <input type=\"radio\" name=\"SC3\" value=0 ";
				if ( $row['s4alert'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n        否</td>\r\n      <td><input class=za_text  maxlength=150 size=100 value=\"";
				echo $row['alert4_tw'];
				echo "\" name=systime></td>\r\n      <td><input class=za_button type=submit value=\"确定\" name=ft_ch_ok334></td>\r\n    <input type=hidden value=\"NS\" name=type></TR></form>\r\n  </form>\r\n    <form name=FTR  method=post><TR class=m_cen>\r\n      <td align=right class=m_ag_ed>银河</td>\r\n      <td align=\"left\"> <input type=\"radio\" name=\"SC3\" value=1 ";
				if ( $row['s5alert'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n        是\r\n        <input type=\"radio\" name=\"SC3\" value=0 ";
				if ( $row['s5alert'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n        否</td>\r\n      <td><input class=za_text  maxlength=150 size=100 value=\"";
				echo $row['alert5_tw'];
				echo "\" name=systime></td>\r\n      <td><input class=za_button type=submit value=\"确定\" name=ft_ch_ok334></td>\r\n    <input type=hidden value=\"BN\" name=type></TR></form>\r\n  </form>-->\r\n</table>\r\n<br>\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>维护设置</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" height=\"34\" align=right class=m_ag_ed> 维护</td>\r\n      <td width=\"100\" align=\"left\">\r\n          <input type=\"radio\" name=\"SC3\" value=1 ";
				if ( $row['website'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n          是\r\n          <input type=\"radio\" name=\"SC3\" value=0 ";
				if ( $row['website'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n          否</td><td width=\"304\">维护时间段:美东时间<input class=za_text  maxLength=30 size=30 value=\"";
				echo $row[systime];
				echo "\" name=systime>\r\n      </td>\r\n      <td width=\"291\">&nbsp;香港时间\r\n        <input class=za_text  maxlength=30 size=30 value=\"";
				echo $row[systime1];
				echo "\" name=systime1></td>\r\n<td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"ST\" name=type>\r\n  </form>\r\n</table>\r\n\r\n<br>\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>即时注单刷新</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> 方式</td>\r\n      <td width=\"600\" align=\"left\"> ";
				if ( $row['wager'] == 1 )
				{
								$setv1 = "checked";
								$setv2 = "";
				}
				else
				{
								$setv1 = "";
								$setv2 = "checked";
				}
				echo "          <input type=\"radio\" name=\"wager\" value=1 ";
				echo $setv1;
				echo ">\r\n          自动刷新\r\n          <input type=\"radio\" name=\"wager\" value=0 ";
				echo $setv2;
				echo ">\r\n          手动刷新</td>\r\n<td width=\"304\">刷新秒数<input class=za_text  maxLength=10 size=10 value=\"";
				echo $row['wager_sec'];
				echo "\" name=wager_sec>\r\n\t<td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n\r\n    </TR><input type=hidden value=\"RW\" name=type>\r\n  </form>\r\n</table>\r\n\r\n<br>\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>账号ipsec</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> 方式</td>\r\n      <td width=\"600\" align=\"left\"> ";
				if ( $row['runball'] == 1 )
				{
								$setv1 = "checked";
								$setv2 = "";
				}
				else
				{
								$setv1 = "";
								$setv2 = "checked";
				}
				echo "          <input type=\"radio\" name=\"runball\" value=1 ";
				echo $setv1;
				echo ">\r\n          单IP单帐号\r\n          <input type=\"radio\" name=\"runball\" value=0 ";
				echo $setv2;
				echo ">\r\n          单IP多帐号</td>\r\n<td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"RB\" name=type>\r\n  </form>\r\n</table>\r\n\r\n<br>\r\n<!--table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>防改单</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> 方式</td>\r\n      <td width=\"600\" align=\"left\"> ";
				if ( $row['wageron'] == 1 )
				{
								$setv1 = "checked";
								$setv2 = "";
				}
				else
				{
								$setv1 = "";
								$setv2 = "checked";
				}
				echo "          <input type=\"radio\" name=\"wageron\" value=1 ";
				echo $setv1;
				echo ">\r\n          开启\r\n          <input type=\"radio\" name=\"wageron\" value=0 ";
				echo $setv2;
				echo ">\r\n          关闭</td>\r\n<td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"WP\" name=type>\r\n  </form>\r\n</table-->\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>系统最佳化</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> 方式</td>\r\n      <td width=\"600\" align=\"left\"> ";
				if ( $row['anop'] == 1 )
				{
								$setv1 = "checked";
								$setv2 = "";
				}
				else
				{
								$setv1 = "";
								$setv2 = "checked";
				}
				echo "\t\t\t\t          <input type=\"radio\" name=\"anop\" value=1 ";
				echo $setv1;
				echo ">\r\n          开启\r\n          <input type=\"radio\" name=\"anop\" value=0 ";
				echo $setv2;
				echo ">\r\n          关闭</td>\r\n<td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"OP\" name=type>\r\n  </form>\r\n</table>\r\n\r\n<br>\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>非法注单</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> 方式</td>\r\n      <td width=\"600\" align=\"left\">\r\n      \t";
				if ( $row['acton'] == 1 )
				{
								$setv1 = "checked";
								$setv2 = "";
				}
				else
				{
								$setv1 = "";
								$setv2 = "checked";
				}
				echo "          <input type=\"radio\" name=\"acton\" value=1 ";
				echo $setv1;
				echo ">开启\r\n          <input type=\"radio\" name=\"acton\" value=0 ";
				echo $setv2;
				echo ">关闭\r\n      </td>\r\n\t\t\t<td width=\"304\">投注时间间隔秒数<input class=za_text  maxLength=10 size=10 value=\"";
				echo $row['bet_time'];
				echo "\" name=bet_time>\r\n\t\t\t<td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n\r\n    </TR><input type=hidden value=\"AO\" name=type>\r\n  </form>\r\n</table>\r\n\r\n<br>\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR  method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>管理平台登入ip限制</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> 方式</td>\r\n      <td width=\"600\" align=\"left\">\r\n      \t";
				if ( $row['allowip'] == 1 )
				{
								$setv1 = "checked";
								$setv2 = "";
				}
				else
				{
								$setv1 = "";
								$setv2 = "checked";
				}
				echo "          <input type=\"radio\" name=\"allowip\" value=1 ";
				echo $setv1;
				echo ">开启\r\n          <input type=\"radio\" name=\"allowip\" value=0 ";
				echo $setv2;
				echo ">关闭\r\n      </td>\r\n\t\t\t<td width=\"304\">指定IP地址<input class=za_text  maxLength=20 size=20 value=\"";
				echo $row['logip'];
				echo "\" name=logip>\r\n\t\t\t<td><input class=za_button  type=submit value=\"确定\" name=ft_ch_ok></td>\r\n\r\n    </TR><input type=hidden value=\"IP\" name=type></form>\r\n</table>\r\n";

		echo "
		<br>

		<table width='771' border='0' cellpadding='0' cellspacing='1' class='m_tab_ed'>
		  <form name=FTR action='' method=post>
			<tr class='m_bc_ed'><td colspan='5' align='center' bgcolor='6EC13E'><b>代理商登陆IP限制</b></td></tr>
			<TR class=m_cen>
			  <td width='41' align=right class=m_ag_ed> </td>
			  <td width='300' align=left>  请输入要禁止访问的IP，每行一个</td>
			  <td width='300' align=left> ";
		echo "<TEXTAREA NAME='agents_ip_drop' ROWS='5' COLS='30'>$setdata[agents_ip_drop]</TEXTAREA>";
		echo "</td>
			  <td><input class='za_button'  type=submit value='确定' name='ft_ch_ok'></td>
			</TR><input type=hidden value='agents_ip_drop' name=type>
		  </form>
		</table>";

				echo "<BR><BR><BR><BR><BR></body>\r\n</html>\r\n";
}
?>
