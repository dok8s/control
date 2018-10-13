<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
echo "<script>if(self == top) location='/';</script>\r\n";
require( "../../member/include/config.inc.php" );
require( "../../member/include/define_function_list.inc.php" );
require( "../../member/include/traditional.zh-cn.inc.php" );
$report_kind = $_REQUEST['report_kind'];
$pay_type = $_REQUEST['pay_type'];
$wtype = $_REQUEST['wtype'];
$date_start = $_REQUEST['date_start'];
$date_end = $_REQUEST['date_end'];
$gtype = $_REQUEST['gtype'];
$aid = $_REQUEST['aid'];
$sid = $_REQUEST['report_kind'];
$uid = $_REQUEST['uid'];
$result_type = $_REQUEST['result_type'];
$sql = "select id,agname from web_sytnet where uid='".$uid."' and status=1";
$result = mysql_query( $sql );
$row = mysql_fetch_array( $result );
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
				echo "<script>window.open('".$site."/index.php','_top')</script>";
				exit( );
}
		$admin_name=$row['agname'];
		$pqow = $result_type=='Y' ? '有结果' : '无结果';
		$loginfo="查询 $date_start 至 $date_end <font color=green>$pqow</font>的总报表";
		$ip_addr = $_SERVER['REMOTE_ADDR'];
		$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$admin_name',now(),'$loginfo','$ip_addr','-2')";
		mysql_query($mysql);

$date_start = cdate( $date_start );
$date_end = cdate( $date_end );
$where = get_report( $gtype, $wtype, $result_type, $report_kind, $date_start, $date_end );
switch ( $pay_type )
{
case "0" :
				$credit = "block";
				$sgold = "block";
				break;
case "1" :
				$credit = "block";
				$sgold = "block";
				break;
case "" :
				$credit = "block";
				$sgold = "block";
}
$sql = "select super as name,count(*) as coun,sum(betscore) as score,sum(m_result) as result,sum(result_c) as result_c,sum(a_result) as a_result,sum(vgold) as vgold,sum(result_a) as result_a,sum(result_s) as result_s from web_db_io where  ".$where;

echo "<html style=\"width: 98%;margin: 0 auto;\">\r\n<head>\r\n<title>reports_all</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<style type=\"text/css\">\r\n<!--\r\n.m_title_reall {  background-color: #687780; text-align: center; color: #FFFFFF}\r\n-->\r\n</style>\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n<SCRIPT language=javaScript src=\"/js/report_func.js\" type=text/javascript></SCRIPT>\r\n<SCRIPT language=javaScript src=\"/js/report_super_agent.js\" type=text/javascript></SCRIPT>\r\n<script>\r\nfunction showREC(showid) {\r\n\twindow.open(\"show_winloss_rec.php?aid=\"+showid , \"show_WR\",\"top=\"+event.clientX/2+\",left=\"+event.clientY/2+\",width=320,height=400\");\r\n}\r\n</script>\r\n</head>\r\n<body bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\">\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n  <tr>\r\n    <td class=\"m_tline\">&nbsp;&nbsp;日期:";
echo $date_start;
echo "~";
echo $date_end;
echo "      -- 报表分类:总帐 -- 投注方式:全部 -- 投注总类:全部 -- 下注管道:网路下注 -- <a href=\"javascript:history.go( -1 );\">回上一页</a></td>\r\n    <td width=\"30\"><img src=\"/images/control/zh-tw/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n  </tr>\r\n  <tr>\r\n    <td colspan=\"2\" height=\"4\"></td>\r\n  </tr>\r\n</table>\r\n";
if ( $credit == "block" )
{
				$mysql = $sql." and pay_type=0 group by super order by name asc";
				$result = mysql_query( $mysql );
				$cou = mysql_num_rows( $result );
				if ( $cou == 0 )
				{
								$credit = "none";
				}
}
else
{
				$credit = "none";
}
echo "<!-----------------↓ 信用额度资料区段 ↓------------------------->\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#000000\" class=\"m_tab\"  style=\"display: ";
echo $credit;
echo "\" width=\"960\">\r\n  <tr class=\"m_title_reall\" >\r\n    <td colspan=\"11\">信用额度</td>\r\n  </tr>\r\n  <tr class=\"m_title_reall\" >\r\n    <td width=\"70\"  >名称</td>\r\n    <td width=\"50\"  >笔数</td>\r\n    <td width=\"100\"  >下注金额</td>\r\n    <td width=\"100\"  >有效金额</td>\r\n    <td width=\"100\"  >会员</td>\r\n    <td width=\"100\"  >代理商</td>\r\n    <td width=\"100\"  >代理商结果</td>\r\n    <td width=\"90\"  >总代理</td>\r\n    <td width=\"90\"  >股东</td>\r\n    <td width=\"120\"  >备注</td>\r\n    <td width=\"120\"  >备注1</td>\r\n  </tr>\r\n  ";
while ( $row = mysql_fetch_array( $result ) )
{
				$c_score += $row['score'];
				$c_num += $row['coun'];
				$c_vgold += $row['vgold'];
				$c_m_result += $row['result'];
				$c_a_result += $row['a_result'];
				$c_result_a += $row['result_a'];
				$c_result_c += $row['result_c'];
				$c_result_s += $row['result_s'];
				echo "  <tr class=\"m_rig\" onmouseover=\"setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');\" onmouseout=\"setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');\">\r\n    <td align=\"center\">";
				echo $row['name'];
				echo "</td>\r\n    <td>";
				echo $row['coun'];
				echo "</td>\r\n    <td><A HREF=\"report_sucorprator.php?uid=";
				echo $uid;
				echo "&result_type=";
				echo $result_type;
				echo "&cid=";
				echo $row['name'];
				echo "&pay_type=0&date_start=";
				echo $date_start;
				echo "&date_end=";
				echo $date_end;
				echo "&report_kind=";
				echo $report_kind;
				echo "&gtype=";
				echo $gtype;
				echo "&wtype=";
				echo $wtype;
				echo "\">";
				echo $row['score'];
				echo "</a></td>\r\n    <td>";
				echo number_format( $row['vgold'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['result'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['a_result'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['result_a'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['result_s'], 1 );
				echo "</td>\r\n    <td >";
				echo number_format( $row['result_c'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['vgold'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['vgold'], 1 );
				echo "</td>\r\n  </tr>\r\n";
}
echo "  <tr>\r\n    <td height=\"1\" colspan=\"10\"></td>\r\n  </tr>\r\n \t<tr class=\"m_rig_to\" >\r\n    <td>总计</td><td>";
echo $c_num;
echo "</td>\r\n    <td>";
echo $c_score;
echo "</td>\r\n    <td>";
echo number_format( $c_vgold, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_m_result, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_a_result, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_result_a, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_result_s, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_result_c, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_vgold, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_vgold, 1 );
echo "</td>\r\n  </tr>\r\n</table>\r\n<!-----------------↑ 信用额度资料区段 ↑------------------------->\r\n";
$c_score1 = 0;
$c_num1 = 0;
$c_m_result1 = 0;
$c_w_result1 = 0;
$c_vscore1 = 0;
$c_a_result1 = 0;
$c_vgold1 = 0;
if ( $sgold == "block" )
{
				$mysql = $sql." and pay_type=1 group by super order by name asc";
				$result = mysql_query( $mysql );
				$cou = mysql_num_rows( $result );
				if ( $cou == 0 )
				{
								$sgold = "none";
				}
}
else
{
				$sgold = "block";
}
if ( $credit == "block" )
{
				echo "<br>";
}
echo "<!-----------------↓ 现金资料区段 ↓------------------------->\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#000000\" class=\"m_tab\"  style=\"display: ";
echo $sgold;
echo "\" width=\"960\">\r\n  <tr class=\"m_title_reall\" >\r\n    <td colspan=\"11\">现金</td>\r\n  </tr>\r\n  <tr class=\"m_title_reall\" >\r\n    <td width=\"70\"  >名称</td>\r\n    <td width=\"50\"  >笔数</td>\r\n    <td width=\"100\"  >下注金额</td>\r\n    <td width=\"100\"  >有效金额</td>\r\n    <td width=\"100\"  >会员</td>\r\n    <td width=\"100\"  >代理商</td>\r\n    <td width=\"100\"  >代理商结果</td>\r\n    <td width=\"90\"  >总代理</td>\r\n    <td width=\"90\"  >股东</td>\r\n    <td width=\"120\"  >备注</td>\r\n    <td width=\"120\"  >备注1</td>\r\n  </tr>\r\n  ";
while ( $row = mysql_fetch_array( $result ) )
{
				$c_score1 += $row['score'];
				$c_num1 += $row['coun'];
				$c_vgold1 += $row['vgold'];
				$c_m_result1 += $row['result'];
				$c_a_result1 += $row['a_result'];
				$c_result_a1 += $row['result_a'];
				$c_result_c1 += $row['result_c'];
				$c_result_s1 += $row['result_s'];
				echo "  <tr class=\"m_rig\" onmouseover=\"setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');\" onmouseout=\"setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');\">\r\n    <td align=\"center\">";
				echo $row['name'];
				echo "</td>\r\n    <td>";
				echo $row['coun'];
				echo "</td>\r\n    <td><A HREF=\"report_sucorprator.php?uid=";
				echo $uid;
				echo "&result_type=";
				echo $result_type;
				echo "&cid=";
				echo $row['name'];
				echo "&pay_type=1&date_start=";
				echo $date_start;
				echo "&date_end=";
				echo $date_end;
				echo "&report_kind=";
				echo $report_kind;
				echo "&gtype=";
				echo $gtype;
				echo "&wtype=";
				echo $wtype;
				echo "\">";
				echo $row['score'];
				echo "</a></td>\r\n    <td>";
				echo number_format( $row['vgold'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['result'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['a_result'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['result_a'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['result_s'], 1 );
				echo "</td>\r\n    <td >";
				echo number_format( $row['result_c'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['vgold'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['vgold'], 1 );
				echo "</td>\r\n  </tr>\r\n";
}
echo "  <tr>\r\n    <td height=\"1\" colspan=\"10\"></td>\r\n  </tr>\r\n\r\n  <tr class=\"m_rig_to\">\r\n    <td>总计</td><td>";
echo $c_num1;
echo "</td>\r\n    <td>";
echo $c_score1;
echo "</td>\r\n    <td>";
echo number_format( $c_vgold1, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_m_result1, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_a_result1, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_result_a1, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_result_s1, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_result_c1, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_vgold1, 1 );
echo "</td>\r\n    <td>";
echo number_format( $c_vgold1, 1 );
echo "</td>\r\n  </tr>\r\n</table>\r\n<BR>\r\n";
if ( $credit == "block" && $sgold == "block" )
{
				$listall = "block";
}
else
{
				$listall = "none";
}
echo "<!-----------------↓ 加总资料区段 ↓------------------------->\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#000000\" class=\"m_tab\"  style=\"display: ";
echo $listall;
echo "\" width=\"960\">\r\n  <tr class=\"m_title_reall\" >\r\n    <td colspan=\"11\">总计</td>\r\n  </tr>\r\n  <tr class=\"m_rig_to\">\r\n    <td width=\"70\" nowrap>总计</td>\r\n    <td width=\"50\">";
echo $c_num1 + $c_num;
echo "</td>\r\n    <td width=\"100\">";
echo $c_score1 + $c_score;
echo "</td>\r\n    <td width=\"100\">";
echo number_format( $c_vgold1 + $c_vgold, 1 );
echo "</td>\r\n    <td width=\"100\">";
echo number_format( $c_m_result + $c_m_result1, 1 );
echo "</td>\r\n    <td width=\"100\">";
echo number_format( $c_a_result + $c_a_result1, 1 );
echo "</td>\r\n    <td width=\"100\">";
echo number_format( $c_result_a + $c_result_a1, 1 );
echo "</td>\r\n    <td width=\"90\">";
echo number_format( $c_w_result + $c_w_result1, 1 );
echo "</td>\r\n    <td width=\"90\">";
echo number_format( $c_c_result + $c_c_result1, 1 );
echo "</td>\r\n    <td width=\"120\">0</td>\r\n    <td width=\"120\">0</td>\r\n  </tr>\r\n<!-----------------↓ 无资料讯息区段 ↓------------------------->\r\n";
if ( $credit == "none" && $sgold == "none" )
{
				$nosearch = "block";
}
else
{
				$nosearch = "none";
}
echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" style=\"display: ";
echo $nosearch;
echo "\">\r\n  <tr >\r\n    <td align=center height=\"30\" bgcolor=\"#CC0000\"><marquee align=\"middle\" behavior=\"alternate\" width=\"200\"><font color=\"#FFFFFF\">查无任何资料</font></marquee></td>\r\n\r\n  <tr>\r\n    <td align=center height=\"20\" bgcolor=\"#CCCCCC\"><a href=\"javascript:history.go(-1);\">离开</a></td>\r\n\r\n</table>\r\n<!-----------------↑ 无资料区段 ↑------------------------->\r\n<!----------------------结帐视窗---------------------------->\r\n<div id=acc_window style=\"display: none;\">\r\n<form name=agAcc1 action=\"agAccount_proc.php\" method=post onsubmit=\"return Chk_acc();\" target=\"win_agAcc\">\r\n<input type=hidden name=in_who_id value=\"\">\r\n<input type=hidden name=acc_date value=\"2005-10-23\">\r\n\r\n<table width=\"220\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" bgcolor=\"0163A2\">\r\n      <tr>\r\n        <td><font color=\"#FFFFFF\">请输入结帐日期</font></td>\r\n        <td align=\"right\" valign=\"top\" ><a style=\"cursor:hand;\" onClick=\"close_win();\"><img src=\"/images/control/zh-tw/edit_dot.gif\" width=\"16\" height=\"14\"></a></td>\r\n      </tr>\r\n      <tr>\r\n        <td colspan=\"2\"><font color=\"#FFFFFF\">日　期:</font>\r\n          <input type=text name=acc_date2 value=\"\" class=\"za_text\" size=\"12\" maxlength=\"10\">\r\n          <input type=submit name=acc_ok value=\"确定\" class=\"za_text_ed\">\r\n        </td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n</div>\r\n<!----------------------结帐视窗---------------------------->\r\n<!----------------------结帐视窗OLD----------------------------\r\n<div id=input_window style=\"display: none;\" style=\"position:absolute\">\r\n<form name=agAcc action=\"agAccount_proc.php\" method=post onsubmit=\"return Chk_IN();\" target=\"win_agAcc\">\r\n<input type=hidden name=in_who_id value=\"\">\r\n<input type=hidden name=date_start value=\"2005-10-23\">\r\n<input type=hidden name=date_end value=\"2005-10-26\">\r\n<input type=hidden name=wagers_type value=\"{WAGERS_TYPE}\">\r\n<input type=hidden name=super_agents_id value=\"{SUPER_AGENTS_ID}\">\r\n<input type=hidden name=game_type value=\"{GAME_TYPE}\">\r\n  <table width=\"220\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" bgcolor=\"0163A2\">\r\n    <tr>\r\n      <td><font color=\"#FFFFFF\">请输入结帐金额</font></td>\r\n      <td align=\"right\" valign=\"top\" ><a style=\"cursor:hand;\" onClick=\"close_win();\"><img src=\"/images/control/zh-tw/edit_dot.gif\" width=\"16\" height=\"14\"></a></td>\r\n    </tr>\r\n    <tr>\r\n      <td colspan=\"2\"><font color=\"#FFFFFF\">代理商:</font><\r\n        <input type=text name=in_who_name value=\"\" class=\"za_text\" size=\"8\" >\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td colspan=\"2\"><font color=\"#FFFFFF\">金　额:</font>\r\n        <input type=text name=in_gold value=\"\" class=\"za_text\" size=\"8\" maxlength=\"8\">\r\n        <input type=submit name=in_chk value=\"结帐\" class=\"za_text_ed\">\r\n        </td>\r\n    </tr>\r\n  </table>\r\n</form>\r\n</div>\r\n<!----------------------结帐视窗---------------------------->\r\n<SCRIPT language=JavaScript1.2><!--\r\n//document.oncontextmenu=showmenuie5\r\n//if (document.all&&window.print)\r\n//document.body.onclick=hidemenuie5\r\n// -->\r\n</SCRIPT>\r\n</body>\r\n</html>";
?>
