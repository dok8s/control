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
$cid = $_REQUEST['cid'];
$aid = $_REQUEST['aid'];
$sid = $_REQUEST['sid'];
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
		$loginfo='查询代理商<font color=red>'.$aid.'</font> : '.$date_start.'至'.$date_end.'<font color=green>'.$pqow.'</font>报表投注明细';
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
echo "<html>\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<style type=\"text/css\">\r\n<!--\r\n.m_title_reag { background-color: #687780; text-align: center; color: #FFFFFF}\r\n-->\r\n</style>\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n<SCRIPT language=javaScript src=\"/js/report_func.js\" type=text/javascript></SCRIPT>\r\n<script language=\"javascript\">\r\nvar WData=new Array();\r\nvar gamount=0;\r\nfunction Show_winloss_DETAIL(obj_table,WinlossData,data_amount){\r\n\twith(obj_table){\r\n\t\twhile(rows.length> 1) deleteRow(rows.length-1);\r\n\t\tif (data_amount==0){\r\n\t\t\tnowTR = insertRow();\r\n\t\t\tnowTR.align = 'center';\r\n\t\t\tnowTR.bgColor = '#FFFFFF';\r\n\t\t\twith(nowTR){\r\n\t\t\t\tnowTD = insertCell();\r\n\t\t\t\tnowTD.vAlign = 'top';\r\n\t\t\t\twith(nowTD){\r\n\t\t\t\t\tinnerHTML = '<font color=\\\"#FF0000\\\">没有修改纪录</font>';\r\n\t\t\t\t\tcolSpan='3';\r\n\t\t\t\t}\r\n\t\t\t}\r\n\t\t}\r\n\t\tfor(i=0; i<data_amount; i++){\r\n\t\t\tnowTR = insertRow();\r\n\t\t\tnowTR.align = 'right';\r\n\t\t\tnowTR.bgColor = '#FFFFFF';\r\n\t\t\twith(nowTR){\r\n\t\t\t\t//成数\r\n\t\t\t\tnowTD = insertCell();\r\n\t\t\t\tnowTD.vAlign = 'top';\r\n\t\t\t\tnowTD.innerHTML = '<font color=\\\"#FF0000\\\">'+WinlossData[i][0]+'</font>';\r\n\t\t\t\t//日期\r\n\t\t\t\tnowTD = insertCell();\r\n\t\t\t\tnowTD.vAlign = 'top';\r\n\t\t\t\tnowTD.innerHTML = '<font color=\\\"#FF0000\\\">'+WinlossData[i][1]+'</font>';\r\n\t\t\t\t//时间\r\n\t\t\t\tnowTD = insertCell();\r\n\t\t\t\tnowTD.vAlign = 'top';\r\n\t\t\t\tnowTD.innerHTML = '<font color=\\\"#FF0000\\\">'+WinlossData[i][2]+'</font>';\r\n\t\t\t}//with(TR)\r\n\t\t}\r\n\t}//with(obj_table);\r\n}\r\nfunction show_detail(sid,aid){\r\n\tself.winloss_window.style.position='absolute';\r\n\tself.winloss_window.style.top=event.clientY+15;\r\n\tself.winloss_window.style.left=event.clientX-300;\r\n\twinloss_form.sid.value=sid;\r\n\twinloss_form.aid.value=aid;\r\n\tself.winloss_window.style.visibility='visible';\r\n\twinloss_form.submit();\r\n}\r\nfunction show_one(){\r\n\tshow_table = document.getElementById(\"winloss_table\");\r\n\tShow_winloss_DETAIL(show_table,WData,gamount);\r\n}\r\n</script>\r\n</head>\r\n\r\n<body oncontextmenu=\"window.event.returnValue=false\" bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\">\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\t<tr class=\"m_tline\">\r\n\t\t<td>&nbsp;&nbsp;代理商:";
echo $aid;
echo " -- 日期:";
echo $date_start;
echo "~";
echo $date_end;
echo "      -- 报表分类:总帐 -- 投注方式:";
echo $rep_pay;
echo " -- 投注总类:全部 -- 下注管道:网路下注 -- <a href=\"javascript:history.go( -2 );\">回上一页</a></td>\r\n    <td width=\"30\"><img src=\"/images/control/zh-tw/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n  </tr>\r\n  <tr>\r\n    <td colspan=\"2\" height=\"4\"></td>\r\n  </tr>\r\n</table>\r\n<!-----------------↓ 信用额度资料区段 ↓------------------------->\r\n";
$sql = "select count(*) as coun,sum(BetScore) as score,sum(M_Result) as result,sum(a_result) as a_result,sum(result_a) as result_a,sum(result_s) as result_s,sum(vgold) as vgold,M_Name as name,agent_point from web_db_io where ".$where.( " and agents='".$aid."'" );
$mysql = $sql." and pay_type=".$pay_type." group by M_Name order by m_name asc";
$result = mysql_query( $mysql );
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
				$credit = "none";
				$cash = "block";
}
else
{
				$credit = "block";
				$cash = "none";
}
echo "<table width=\"900\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"m_tab\" style=\"display: ";
echo $credit;
echo "\" bgcolor=\"#000000\">\r\n\t<tr class=\"m_title_reag\">\r\n\t\t<td colspan=\"9\">";
echo $rep_pay;
echo "</td>\r\n\t</tr>\r\n\t<tr class=\"m_title_reag\">\r\n\t\t<td width=\"120\">会员</td>\r\n\t\t<td width=\"50\">笔数</td>\r\n\t\t<td width=\"120\">下注金额</td>\r\n\t\t<td width=\"100\">有效金额</td>\r\n\t\t<td width=\"110\">结果</td>\r\n\t\t<td width=\"90\">代理商成数</td>\r\n\t\t<td width=\"110\">代理商结果A</td>\r\n\t\t<td width=\"100\">原币值</td>\r\n\t\t<td width=\"100\">备注1</td>\r\n\t</tr>\r\n\r\n";
while ( $row = mysql_fetch_array( $result ) )
{
				$c_score += $row['score'];
				$c_num += $row['coun'];
				$c_m_result += $row['result'];
				$c_vscore += $row['vgold'];
				$c_a_result += $row['a_result'];
				$c_result_a += $row['result_a'];
				$c_result_s += $row['result_s'];
				$c_sgold += $row['result'] * ( 1 - $row['agent_point'] / 100 );
				echo "  <tr  class=\"m_rig\" onmouseover=\"setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');\" onmouseout=\"setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');\">\r\n    <td align=\"left\">";
				echo $row['name'];
				echo "(";
				echo $mem_current;
				echo ")</td>\r\n    <td>";
				echo $row['coun'];
				echo "</td>\r\n    <td><A HREF=\"report_member.php?uid=";
				echo $uid;
				echo "&result_type=";
				echo $result_type;
				echo "&mid=";
				echo $row['name'];
				echo "&pay_type=";
				echo $pay_type;
				echo "&date_start=";
				echo $date_start;
				echo "&date_end=";
				echo $date_end;
				echo "&report_date=";
				echo date( "Y-m-d" );
				echo "&report_kind=";
				echo $report_kind;
				echo "&gtype=";
				echo $gtype;
				echo "&wtype=";
				echo $wtype;
				echo "\">";
				echo number_format( $row['score'], 1 );
				echo "</a></td>\r\n    <td>";
				echo number_format( $row['vgold'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['result'], 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['agent_point'] / 100, 2 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['result'] * ( 1 - $row['agent_point'] / 100 ), 1 );
				echo "</td>\r\n    <td>";
				echo number_format( $row['result'], 1 );
				echo "</td>\r\n    <td></td>\r\n";
}
echo "   <tr class=\"m_rig_re\">\r\n    <td></td>\r\n    <td >";
echo $c_num;
echo "</td>\r\n    <td >";
echo number_format( $c_score, 1 );
echo "</td>\r\n    <td >";
echo number_format( $c_vscore, 1 );
echo "</td>\r\n    <td bgcolor=\"#000033\"><font color=\"#FFFFFF\">";
echo number_format( $c_m_result, 1 );
echo "</font></td>\r\n    <td></td>\r\n    <td>";
echo number_format( $c_sgold, 1 );
echo "</td>\r\n    <td></td>\r\n    <td></td>\r\n  </tr>\r\n</table>\r\n<table width=\"780\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tr>\r\n<td height=\"15\"></td>\r\n</tr>\r\n</table>\r\n\r\n<table width=\"780\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tr>\r\n<td height=\"15\"></td>\r\n</tr>\r\n</table>\r\n<table width=\"900\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"m_tab\" style=\"display: ";
echo $credit;
echo "\" bgcolor=\"#000000\">\r\n\t<tr class=\"m_title_reag\">\r\n\t\t<td width=\"120\">会员</td>\r\n\t\t<td width=\"50\">笔数</td>\r\n\t\t<td width=\"120\">下注金额</td>\r\n\t\t<td width=\"100\">有效金额</td>\r\n\t\t<td width=\"110\">结果</td>\r\n\t\t<td width=\"90\">代理商成数</td>\r\n\t\t<td width=\"110\" bgcolor=\"#990000\">代理商结果</td>\r\n\t\t<td width=\"100\">备注</td>\r\n\t\t<td width=\"70\">备注1</td>\r\n\t\t<td width=\"30\">功\能</td>\r\n\t</tr>\r\n\t<!-- BEGIN DYNAMIC BLOCK: row2 -->\r\n\t<tr class=\"m_rig\">\r\n\t\t<td align=\"left\">";
echo $aid;
echo "</td>\r\n\t\t<td>";
echo $c_num;
echo "</td>\r\n\t\t<td>";
echo number_format( $c_score, 1 );
echo "</td>\r\n\t\t<td>";
echo number_format( $c_vscore, 1 );
echo "</td>\r\n\t\t<td>";
echo number_format( $c_a_result, 1 );
echo "</td>\r\n\t\t<td></td>\r\n\t\t<td>";
echo number_format( $c_result_a, 1 );
echo "</td>\r\n\t\t<td>";
echo number_format( $c_result_s, 1 );
echo "</td>\r\n\t\t<td></td>\r\n\t\t<td><A href=\"javascript:\" onClick=\"show_detail('{SID}','{AID}');\">详细</A></td>\r\n\t</tr>\r\n\t\t<!-- END DYNAMIC BLOCK: row2 -->\r\n</table>\r\n<!-----------------↓ 无资料讯息区段 ↓------------------------->\r\n<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" style=\"display: ";
echo $cash;
echo "\">\r\n\t<tr>\r\n\t\t<td align=center height=\"30\" bgcolor=\"#CC0000\"><marquee align=\"middle\" behavior=\"alternate\" width=\"200\"><font color=\"#FFFFFF\">查无任何资料</font></marquee></td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td align=center height=\"20\" bgcolor=\"#CCCCCC\"><a href=\"javascript:history.go(-1);\">离开</a></td>\r\n\t</tr>\r\n</table>\r\n<!-----------------↑ 无资料区段 ↑------------------------->\r\n<form name=\"winloss_form\" id=winloss_form action=\"report_winloss_detail.php\" method=\"post\" target=showdata>\r\n\t<div class=\"t_div\" id=\"winloss_window\" style=\"visibility:hidden;position: absolute;\">\r\n\t\t<input type=hidden name='uid' value='{UID}'>\r\n\t\t<input type=hidden name='sid' value=''>\r\n\t\t<input type=hidden name='aid' value=''>\r\n\t\t<input type=hidden name='date_start' value='{DATE_START}'>\r\n\t\t<input type=hidden name='date_end' value='{DATE_END}'>\r\n\t\t<input type=hidden name='id_type' value='aid'>\r\n\t\t<table id=\"winloss_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"006255\" class=\"m_tab\" width=\"300\">\r\n\t\t\t<tr class=\"m_title_ft\">\r\n\t\t\t\t<td nowrap>成数</td>\r\n\t\t\t\t<td nowrap>修改日期</td>\r\n\t\t\t\t<td nowrap>修改时间</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t<input type='button' class=\"za_button\" onClick=\"self.winloss_window.style.visibility='hidden';\" value='关闭'>\r\n\t</div>\r\n</form>\r\n<iframe id=showdata name=showdata src='../../../ok.html' scrolling='no' width=\"0\"></iframe>\r\n</body>\r\n</html>";
?>
