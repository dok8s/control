<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
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
				$filename = "../../member/include/big5-gb.table";
				$fp = fopen( $filename, "rb" );
				$big5 = fread( $fp, filesize( $filename ) );
				fclose( $fp );
				$filename = "../../member/include/gb-big5.table";
				$fp = fopen( $filename, "rb" );
				$gb = fread( $fp, filesize( $filename ) );
				fclose( $fp );
				function gb2big5($Text) {
					$filename = "../../member/include/big5-gb.table";
					$fp = fopen($filename, "rb");
					$gb = fread($fp,filesize($filename));
					fclose($fp);
					$max = strlen($Text)-1;
					for($i=0;$i<$max;$i++) {
					$h = ord($Text[$i]);
					if($h>=160) {
					$l = ord($Text[$i+1]);
					if($h==161 && $l==64) {
					$big = "��";
					}else{
					$p = ($h-160)*510+($l-1)*2;
					$big = $gb[$p].$gb[$p+1];
					}
					$Text[$i] = $big[0];
					$Text[$i+1] = $big[1];
					$i++;
					}
					}
					return $Text;
				}
				$type = $_REQUEST['type'];
				switch ( $type )
				{
				case "FT" :
								$mysql = "update web_system set udp_ft_r=".$_REQUEST['SC1'].",udp_ft_hr=".$_REQUEST['SC2'].",udp_ft_re=".$_REQUEST['SC3'].",udp_ft_pd=".$_REQUEST['SC4'].",udp_ft_t=".$_REQUEST['SC5'].",udp_ft_f=".$_REQUEST['SC6'].",udp_ft_pr=".$_REQUEST['SC7'].",udp_ft_p=".$_REQUEST['SC8'];
								mysql_query( $mysql );
								break;
				case "CN" :
								$ruid = $_REQUEST['ruid'] + 0;
								if ( $_REQUEST['PA2'] == "" || $_REQUEST['SC0'] == "" || $_REQUEST['US2'] == "" )
								{
												exit( );
								}
								$mysql = "update web_system set uid=".$ruid.",datasite='".$_REQUEST['SC0']."',username_tw='".$_REQUEST['US2']."',  username_en='".$_REQUEST['US3']."', password='".$_REQUEST['PA2']."', uid_tw='".$_REQUEST['uid_tw']."', uid_en='".$_REQUEST['uid_en']."'";
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
								$mysql = "update web_system set alert_tw='".gb2big5( $_REQUEST['systime'] )."',salert=".$_REQUEST['SC3'];
								mysql_query( $mysql );
								break;
				case "SI2" :
								$mysql = "update web_system set alert2_tw='".gb2big5( $_REQUEST['systime'] )."',s2alert=".$_REQUEST['SC3'];
								mysql_query( $mysql );
								break;
				case "BS" :
								$mysql = "update web_system set alert3_tw='".gb2big5( $_REQUEST['systime'] )."',s3alert=".$_REQUEST['SC3'];
								mysql_query( $mysql );
								break;
				case "NS" :
								$mysql = "update web_system set alert4_tw='".gb2big5( $_REQUEST['systime'] )."',s4alert=".$_REQUEST['SC3'];
								mysql_query( $mysql );
								break;
				case "BN" :
								$mysql = "update web_system set alert5_tw='".gb2big5( $_REQUEST['systime'] )."',s5alert=".$_REQUEST['SC3'];
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
				echo "<html style=\"width: 98%;margin: 0 auto;\">\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n<SCRIPT language=javaScript src=\"/js/report_func.js\" type=text/javascript></SCRIPT>\r\n<style type=\"text/css\">\r\n<!--\r\n.m_ag_ed {  background-color: #bdd1de; text-align: right}\r\n-->\r\n</style>\r\n</head>\r\n<body oncontextmenu=\"window.event.returnValue=false\" bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\" >\r\n<table width=\"775\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n  <tr>\r\n    <td class=\"m_tline\">&nbsp;&nbsp; ϵͳ���� -- ��ϸ����&nbsp;&nbsp;&nbsp; </td>\r\n    <td width=\"30\"><img src=\"/images/control/zh-tw/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n  </tr>\r\n  <tr>\r\n    <td colspan=\"2\" height=\"4\"></td>\r\n  </tr>\r\n</table>\r\n\r\n<table width=\"770\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <tr class=\"m_bc_ed\">\r\n    <td colspan=\"7\" align=\"center\" bgcolor=\"6EC13E\"><b>������Դ </b></td>\r\n  </tr>\r\n  <TR class=m_title_edit>\r\n    <td width=58>&nbsp;</td>\r\n    <td width=180>��ַ </td>\r\n    <!--td width=150>����</td-->\r\n    <td width=200>����</td>\r\n    <td width=200>Ӣ��</td>\r\n    <td width=100>uid���շ�ʽ</td>\r\n    <td width=70>&nbsp; </td>\r\n  </TR>\r\n  <form name=FTR action=\"\" method=post>\r\n    <TR class=m_cen>\r\n      <td height=\"23\" align=right class=m_ag_ed>�û��� </td>\r\n      <td align=center><input class=za_text  size=25 value=\"";
				echo $row['datasite'];
				echo "\" name=SC0></td>\r\n      <!--td align=center><input class=za_text  maxLength=10 size=10 value=\"";
				echo $row['username'];
				echo "\" name=US1></td-->\r\n      <td align=center><input class=za_text  maxlength=10 size=10 value=\"";
				echo $row['username_tw'];
				echo "\" name=US2></td>\r\n      <td align=center><input class=za_text  maxlength=10 size=10 value=\"";
				echo $row['username_en'];
				echo "\" name=US3>\r\n      </td>\r\n      <td><input type=\"radio\" name=\"ruid\" value=0 ";
				if ( $row['uid'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n        �������</td>\r\n      <td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok3></td>\r\n    </TR>
    <TR class=m_cen>
      <td class=m_ag_ed align=right>����/UID</td>
      <td align=center><input class=za_text  size=25 value='".$row['password']."' name=PA2></td>
      <td align=center><input class=za_text  size=28 value='".$row['uid_tw']."' name='uid_tw'></td>
      <td align=center><input class=za_text  size=28 value='".$row['uid_en']."' name='uid_en'></td>
      <td><input name=\"ruid\" type=\"radio\" value=1 ";
				if ( $row['uid'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n        �������</td>\r\n      <td>&nbsp;</td>\r\n    </TR>\r\n    <input type=hidden value=\"CN\" name=type>\r\n  </form>\r\n</table>\r\n<!--<br>\r\n<table width=\"770\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <tr class=\"m_bc_ed\"><td colspan=\"10\" align=\"center\" bgcolor=\"6EC13E\"><b>����ʱ��</b></td></tr>\r\n<TR class=m_title_edit>\r\n    <td width=80>&nbsp;</td>\r\n    <td width=70> ��ʽ</td>\r\n    <td width=70>�ϰ볡</td>\r\n    <td width=70>�ߵ�</td>\r\n    <td width=70>����</td>\r\n    <td width=70>����</td>\r\n    <td width=70>��ȫ��</td>\r\n    <td width=70>�������</td>\r\n    <td width=70>��׼����</td>\r\n    <td width=80>&nbsp; </td>\r\n  </TR>\r\n  <form name=FTR action=\"\" method=post>\r\n    <TR class=m_cen>\r\n      <td class=m_ag_ed align=right> ��(��/��/��)�� </td>\r\n      <td align=right><input class=za_text  maxLength=11 size=5 value=\"";
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
				echo "\" name=SC8></td>\r\n      <td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n\t  <input type=hidden value=\"FT\" name=type>\r\n     </TR>\r\n  </form>\r\n</table>-->\r\n<br>\r\n<table width=\"770\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <tr class=\"m_bc_ed\"><td colspan=\"11\" align=\"center\" bgcolor=\"6EC13E\"><b>��ע������~</b></td></tr>\r\n<TR class=m_title_edit>\r\n    <td width=50>&nbsp;</td>\r\n    <td width=70>��Ӯ</td>\r\n    <td width=70>����</td>\r\n    <td width=70>��С��</td>\r\n    <td width=70>����</td>\r\n    <td width=70>����</td>\r\n    <td width=70>��ȫ��</td>\r\n    <td width=70>����</td>\r\n    <td width=70>�ھ�</td>\r\n    <td width=70>����ɲ�</td>\r\n    <td width=80>&nbsp; </td>\r\n  </TR>\r\n  <form name=FTR action=\"\" method=post>\r\n    <TR class=m_cen>\r\n      <td class=m_ag_ed align=right>���</td>\r\n      <td align=right><input class=za_text  maxLength=11 size=5 value=\"";
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
				echo "\" name=SC9></td>\r\n      <td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n\t  <input type=hidden value=\"BT\" name=type>\r\n     </TR>\r\n  </form>\r\n</table>";

				echo "
				<br>
				<table width=771 border=0 cellpadding=0 cellspacing=1 class=m_tab_ed>
				  <form name=FTR action='' method=post>
				  <tr class=m_bc_ed><td colspan=5 align=center bgcolor=6EC13E><b>��Աע��</b></td></tr>
				  <TR class=m_cen>  <td width=80 align=right class=m_ag_ed>Ĭ�ϴ�����</td>  <td width=600 align=left><input type=text name='default_agent' value='".$setdata['default_agent']."'</td>  <td><input class=za_button  type=submit value='ȷ��' name=ft_ch_ok></td></TR>
					<input type=hidden value='default_agent' name='type'>
				  </form>";
				  $setv1 = $setdata['auto_check']==1 ? "checked" : "";
				  $setv2 = $setv1=="" ? "checked" : "";
				  echo "
				  <form name=FTR action='' method=post>
				  <TR class=m_cen>  <td width=80 align=right class=m_ag_ed>��˷�ʽ</td>  <td width=600 align=left><input type=radio name='auto_check' value='1' $setv1>�Զ���� <input type=radio name='auto_check' value='0' $setv2>�˹����</td> <td><input class=za_button  type=submit value='ȷ��' name=ft_ch_ok></td></TR>
					<input type=hidden value='auto_check' name='type'>
				  </form>
				</table>";

				echo "\r\n<br>\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>�����̿ɷ����õ�ע������~</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> ��ʽ</td>\r\n      <td width=\"600\" align=\"left\"> ";
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
				echo ">\r\n          ��������\r\n          <input type=\"radio\" name=\"setmin\" value=1 ";
				echo $setv2;
				echo ">\r\n          ��������</td>\r\n<td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"setmin\" name=type>\r\n  </form>\r\n</table>";

				echo "\r\n<br>\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>��0���˺Ŷ���ͬʱ����</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> ��ʽ</td>\r\n      <td width=\"600\" align=\"left\"> ";
				$setv1 = $setdata['d0oneonline']==1 ? '' : "checked";
				$setv2 = $setdata['d0oneonline']==1 ? "checked" : '';
				echo "          <input type=\"radio\" name=\"d0oneonline\" value='0' ";
				echo $setv1;
				echo ">\r\n          ����ͬʱ����\r\n          <input type=\"radio\" name=\"d0oneonline\" value='1' ";
				echo $setv2;
				echo ">\r\n          ����ͬʱ����</td>\r\n<td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"d0oneonline\" name=type>\r\n  </form>\r\n</table>";

				echo "\r\n<br>\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>��0�ɷ�ɾ����Ա</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> ��ʽ</td>\r\n      <td width=\"600\" align=\"left\"> ";
				$setv1 = $setdata['opendel']==1 ? '' : "checked";
				$setv2 = $setdata['opendel']==1 ? "checked" : '';
				echo "          <input type=\"radio\" name=\"opendel\" value='0' ";
				echo $setv1;
				echo ">\r\n          ����ɾ��\r\n          <input type=\"radio\" name=\"opendel\" value='1' ";
				echo $setv2;
				echo ">\r\n          ����ɾ��</td>\r\n<td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"opendel\" name=type>\r\n  </form>\r\n</table>";

				echo "\r\n<br>\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>��0�ɷ��޸Ĵ���ռ����</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> ��ʽ</td>\r\n      <td width=\"600\" align=\"left\"> ";
				$setv1 = $setdata['resetwinloss']==1 ? '' : "checked";
				$setv2 = $setdata['resetwinloss']==1 ? "checked" : '';
				echo " <input type='radio' name='resetwinloss' value='0' $setv1>�����޸�
				&nbsp; <input type='radio' name='resetwinloss' value='1' $setv2>�����޸�</td>
				<td><input class='za_button'  type='submit' value='ȷ��' name='ft_ch_ok'></td>
			    </TR><input type='hidden' value='resetwinloss' name='type'>  </form>\r\n</table>";

				echo "\r\n<br>\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>�ߵ�Σ�����Զ�ȷ��</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> ʱ��</td>\r\n      <td width=\"600\" align=\"left\"> ";
				$danger_time = intval($setdata['danger_time']);
				echo "<input name='danger_time' class=za_text size=3 value='".$danger_time."'> �룬0Ϊ�Զ�����Ĭ��ֵ";
				echo "</td>\r\n<td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"danger_time\" name=type>\r\n  </form>\r\n</table>";

				echo "\r\n<br>\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>�ߵ�����Դ</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> ��ʽ</td>\r\n      <td width=\"600\" align=\"left\"> ";
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
				echo ">\r\n          ������\r\n          <input type=\"radio\" name=\"b1\" value=1 ";
				echo $setv2;
				echo ">\r\n          �ӹ���</td>\r\n<td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"B2\" name=type>\r\n  </form>\r\n</table>";

				echo "\r\n<br>\r\n<table width=\"770\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"4\" align=\"center\" bgcolor=\"6EC13E\"><b>Э��������</b></td></tr>\r\n<TR class=m_title_edit>\r\n      <td>ǰ̨ </td>\r\n      <td>����</td>\r\n      <td>�ı�����</td>\r\n      <td>&nbsp;</td>\r\n    </TR><form name=FTR action=\"\" method=post>\r\n    <TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> �ʹ�</td>\r\n      <td width=\"130\" align=\"left\"> <input type=\"radio\" name=\"SC3\" value=1 ";
				if ( $row['s2alert'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n        ��\r\n        <input type=\"radio\" name=\"SC3\" value=0 ";
				if ( $row['s2alert'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n        ��</td>\r\n      <td width=\"544\"> <input class=za_text  maxLength=150 size=100 value=\"";
				echo big52gb( $row['alert2_tw'] );
				echo "\" name=systime> </div>\r\n      </td>\r\n      <td width=\"50\"><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok33></td>\r\n      <input type=hidden value=\"SI2\" name=type>\r\n    </TR></form>\r\n    <form name=FTR action=\"\" method=post><TR class=m_cen>\r\n      <td align=right class=m_ag_ed>����</td>\r\n      <td align=\"left\"> <input type=\"radio\" name=\"SC3\" value=1 ";
				if ( $row['salert'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n        ��\r\n        <input type=\"radio\" name=\"SC3\" value=0 ";
				if ( $row['salert'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n        ��</td>\r\n      <td><input class=za_text  maxlength=150 size=100 value=\"";
				echo big52gb( $row['alert_tw'] );
				echo "\" name=systime></td>\r\n      <td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok332></td>\r\n    <input type=hidden value=\"SI\" name=type></TR></form>\r\n\r\n\r\n    <!--form name=FTR action=\"\" method=post><TR class=m_cen>\r\n      <td align=right class=m_ag_ed>����</td>\r\n      <td align=\"left\"> <input type=\"radio\" name=\"SC3\" value=1 ";
				if ( $row['s3alert'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n        ��\r\n        <input type=\"radio\" name=\"SC3\" value=0 ";
				if ( $row['s3alert'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n        ��</td>\r\n      <td><input class=za_text  maxlength=150 size=100 value=\"";
				echo big52gb( $row['alert3_tw'] );
				echo "\" name=systime></td>\r\n      <td><input class=za_button type=submit value=\"ȷ��\" name=ft_ch_ok334></td>\r\n    <input type=hidden value=\"BS\" name=type></TR></form>\r\n  </form>\r\n\r\n    <form name=FTR action=\"\" method=post><TR class=m_cen>\r\n      <td align=right class=m_ag_ed>����</td>\r\n      <td align=\"left\"> <input type=\"radio\" name=\"SC3\" value=1 ";
				if ( $row['s4alert'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n        ��\r\n        <input type=\"radio\" name=\"SC3\" value=0 ";
				if ( $row['s4alert'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n        ��</td>\r\n      <td><input class=za_text  maxlength=150 size=100 value=\"";
				echo big52gb( $row['alert4_tw'] );
				echo "\" name=systime></td>\r\n      <td><input class=za_button type=submit value=\"ȷ��\" name=ft_ch_ok334></td>\r\n    <input type=hidden value=\"NS\" name=type></TR></form>\r\n  </form>\r\n    <form name=FTR action=\"\" method=post><TR class=m_cen>\r\n      <td align=right class=m_ag_ed>����</td>\r\n      <td align=\"left\"> <input type=\"radio\" name=\"SC3\" value=1 ";
				if ( $row['s5alert'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n        ��\r\n        <input type=\"radio\" name=\"SC3\" value=0 ";
				if ( $row['s5alert'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n        ��</td>\r\n      <td><input class=za_text  maxlength=150 size=100 value=\"";
				echo big52gb( $row['alert5_tw'] );
				echo "\" name=systime></td>\r\n      <td><input class=za_button type=submit value=\"ȷ��\" name=ft_ch_ok334></td>\r\n    <input type=hidden value=\"BN\" name=type></TR></form>\r\n  </form>-->\r\n</table>\r\n<br>\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>ά������</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" height=\"34\" align=right class=m_ag_ed> ά��</td>\r\n      <td width=\"100\" align=\"left\">\r\n          <input type=\"radio\" name=\"SC3\" value=1 ";
				if ( $row['website'] == 1 )
				{
								echo "checked";
				}
				echo ">\r\n          ��\r\n          <input type=\"radio\" name=\"SC3\" value=0 ";
				if ( $row['website'] == 0 )
				{
								echo "checked";
				}
				echo ">\r\n          ��</td><td width=\"304\">ά��ʱ���:����ʱ��<input class=za_text  maxLength=30 size=30 value=\"";
				echo $row[systime];
				echo "\" name=systime>\r\n      </td>\r\n      <td width=\"291\">&nbsp;���ʱ��\r\n        <input class=za_text  maxlength=30 size=30 value=\"";
				echo $row[systime1];
				echo "\" name=systime1></td>\r\n<td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"ST\" name=type>\r\n  </form>\r\n</table>\r\n\r\n<br>\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>��ʱע��ˢ��</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> ��ʽ</td>\r\n      <td width=\"600\" align=\"left\"> ";
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
				echo ">\r\n          �Զ�ˢ��\r\n          <input type=\"radio\" name=\"wager\" value=0 ";
				echo $setv2;
				echo ">\r\n          �ֶ�ˢ��</td>\r\n<td width=\"304\">ˢ������<input class=za_text  maxLength=10 size=10 value=\"";
				echo $row['wager_sec'];
				echo "\" name=wager_sec>\r\n\t<td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n\r\n    </TR><input type=hidden value=\"RW\" name=type>\r\n  </form>\r\n</table>\r\n\r\n<br>\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>�˺�ipsec</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> ��ʽ</td>\r\n      <td width=\"600\" align=\"left\"> ";
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
				echo ">\r\n          ��IP���ʺ�\r\n          <input type=\"radio\" name=\"runball\" value=0 ";
				echo $setv2;
				echo ">\r\n          ��IP���ʺ�</td>\r\n<td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"RB\" name=type>\r\n  </form>\r\n</table>\r\n\r\n<br>\r\n<!--table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>���ĵ�</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> ��ʽ</td>\r\n      <td width=\"600\" align=\"left\"> ";
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
				echo ">\r\n          ����\r\n          <input type=\"radio\" name=\"wageron\" value=0 ";
				echo $setv2;
				echo ">\r\n          �ر�</td>\r\n<td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"WP\" name=type>\r\n  </form>\r\n</table-->\r\n\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>ϵͳ��ѻ�</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> ��ʽ</td>\r\n      <td width=\"600\" align=\"left\"> ";
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
				echo ">\r\n          ����\r\n          <input type=\"radio\" name=\"anop\" value=0 ";
				echo $setv2;
				echo ">\r\n          �ر�</td>\r\n<td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n    </TR><input type=hidden value=\"OP\" name=type>\r\n  </form>\r\n</table>\r\n\r\n<br>\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>�Ƿ�ע��</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> ��ʽ</td>\r\n      <td width=\"600\" align=\"left\">\r\n      \t";
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
				echo ">����\r\n          <input type=\"radio\" name=\"acton\" value=0 ";
				echo $setv2;
				echo ">�ر�\r\n      </td>\r\n\t\t\t<td width=\"304\">Ͷעʱ��������<input class=za_text  maxLength=10 size=10 value=\"";
				echo $row['bet_time'];
				echo "\" name=bet_time>\r\n\t\t\t<td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n\r\n    </TR><input type=hidden value=\"AO\" name=type>\r\n  </form>\r\n</table>\r\n\r\n<br>\r\n<table width=\"771\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"m_tab_ed\">\r\n  <form name=FTR action=\"\" method=post>\r\n    <tr class=\"m_bc_ed\"><td colspan=\"5\" align=\"center\" bgcolor=\"6EC13E\"><b>����ƽ̨����ip����</b></td></tr><TR class=m_cen>\r\n      <td width=\"41\" align=right class=m_ag_ed> ��ʽ</td>\r\n      <td width=\"600\" align=\"left\">\r\n      \t";
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
				echo ">����\r\n          <input type=\"radio\" name=\"allowip\" value=0 ";
				echo $setv2;
				echo ">�ر�\r\n      </td>\r\n\t\t\t<td width=\"304\">ָ��IP��ַ<input class=za_text  maxLength=20 size=20 value=\"";
				echo $row['logip'];
				echo "\" name=logip>\r\n\t\t\t<td><input class=za_button  type=submit value=\"ȷ��\" name=ft_ch_ok></td>\r\n\r\n    </TR><input type=hidden value=\"IP\" name=type></form>\r\n</table>\r\n";

		echo "
		<br>

		<table width='771' border='0' cellpadding='0' cellspacing='1' class='m_tab_ed'>
		  <form name=FTR action='' method=post>
			<tr class='m_bc_ed'><td colspan='5' align='center' bgcolor='6EC13E'><b>�����̵�½IP����</b></td></tr>
			<TR class=m_cen>
			  <td width='41' align=right class=m_ag_ed> </td>
			  <td width='300' align=left>  ������Ҫ��ֹ���ʵ�IP��ÿ��һ��</td>
			  <td width='300' align=left> ";
		echo "<TEXTAREA NAME='agents_ip_drop' ROWS='5' COLS='30'>$setdata[agents_ip_drop]</TEXTAREA>";
		echo "</td>
			  <td><input class='za_button'  type=submit value='ȷ��' name='ft_ch_ok'></td>
			</TR><input type=hidden value='agents_ip_drop' name=type>
		  </form>
		</table>";

				echo "<BR><BR><BR><BR><BR></body>\r\n</html>\r\n";
}
?>
