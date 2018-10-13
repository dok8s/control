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
		$loginfo='查询总代理<font color=red>'.$sid.'</font> : '.$date_start.'至'.$date_end.'<font color=green>'.$pqow.'</font>报表投注明细';
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
$sql = "select sum(vgold) as vgold,agent_point,world_point,count(*) as coun,sum(BetScore) as score,sum(M_Result) as result,sum(a_result) as a_result,sum(result_a) as result_a,sum(result_s) as result_s,agents as name from web_db_io where ".$where.( " and world='".$sid."'" );
echo "<html style=\"width: 98%;margin: 0 auto;\">\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<style type=\"text/css\">\r\n<!--\r\n.m_title_reag { background-color: #687780; text-align: center; color: #FFFFFF}\r\n-->\r\n</style>\r\n\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n<SCRIPT language=javaScript src=\"/js/report_func.js\" type=text/javascript></SCRIPT>\r\n<script language=\"javascript\">\r\nvar WData=new Array();\r\nvar gamount=0;\r\nfunction Show_winloss_DETAIL(obj_table,WinlossData,data_amount)\r\n{\r\n with(obj_table)\r\n  {\r\n while(rows.length> 1)\r\n    deleteRow(rows.length-1);\r\n   if (data_amount==0){\r\n    nowTR = insertRow();\r\n    nowTR.align = 'center';\r\n    nowTR.bgColor = '#FFFFFF';\r\n with(nowTR)\r\n    {\r\n     nowTD = insertCell();\r\n     nowTD.vAlign = 'top';\r\n with(nowTD)\r\n            {\r\n               innerHTML = '<font color=\\\"#FF0000\\\">没有修改纪录</font>';\r\n            colSpan='3';\r\n            }\r\n     }\r\n    }\r\n   for(i=0; i<data_amount; i++)\r\n   {\r\n    nowTR = insertRow();\r\n    nowTR.align = 'right';\r\n    nowTR.bgColor = '#FFFFFF';\r\n with(nowTR)\r\n    {\r\n     //成数\r\n     nowTD = insertCell();\r\n     nowTD.vAlign = 'top';\r\n     nowTD.innerHTML = '<font color=\\\"#FF0000\\\">'+WinlossData[i][0]+'</font>';\r\n     //日期\r\n     nowTD = insertCell();\r\n     nowTD.vAlign = 'top';\r\n     nowTD.innerHTML = '<font color=\\\"#FF0000\\\">'+WinlossData[i][1]+'</font>';\r\n     //时间\r\n     nowTD = insertCell();\r\n     nowTD.vAlign = 'top';\r\n     nowTD.innerHTML = '<font color=\\\"#FF0000\\\">'+WinlossData[i][2]+'</font>';\r\n    }//with(TR)\r\n   }\r\n  }//with(obj_table);\r\n}\r\n\r\nfunction show_detail(sid,aid){\r\n\tself.winloss_window.style.position='absolute';\r\n\tself.winloss_window.style.top=event.clientY+15;\r\n\tself.winloss_window.style.left=event.clientX-300;\r\n\tself.winloss_window.style.visibility='visible';\r\n\twinloss_form.sid.value=sid;\r\n\twinloss_form.aid.value=aid;\r\n\twinloss_form.submit();\r\n}\r\nfunction show_one(){\r\n\tshow_table = document.getElementById(\"winloss_table\");\r\n\tShow_winloss_DETAIL(show_table,WData,gamount);\r\n}\r\n</script>\r\n</head>\r\n<body  bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\">\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\t<tr class=\"m_tline\">\r\n\t\t<td>&nbsp;&nbsp;总代理商:";
echo $sid;//oncontextmenu=\"window.event.returnValue=false\"
echo " -- 日期:";
echo $date_start;
echo "~";
echo $date_end;
echo "\t\t-- 报表分类:总帐 -- 投注方式:";
echo $rep_pay;
echo " -- 投注总类:全部 -- 下注管道:网路下注 -- <a href=\"javascript:history.go( -2 );\">回上一页</a></td>\r\n\t\t<td width=\"30\"><img src=\"/images/control/zh-tw/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td colspan=\"2\" height=\"4\"></td>\r\n\t</tr>\r\n</table>\r\n";
$mysql = $sql." and pay_type=".$pay_type."  group by agents order by name asc";
$result = mysql_query( $mysql );
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
				$credit = "none";
}
else
{
				$credit = "block";
}
echo "<!-----------------↓ 信用额度资料区段 ↓------------------------->\r\n<table width=\"1010\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"m_tab\" style=\"display: {LIST_CREDIT}\" bgcolor=\"#000000\">\r\n\t<tr class=\"m_title_reag\">\r\n\t\t<td colspan=\"13\">";
echo $rep_pay;
echo "</td>\r\n\t</tr>\r\n\t<tr class=\"m_title_reag\">\r\n\t\t<td width=\"70\">代理商</td>\r\n\t\t<td width=\"40\">笔数</td>\r\n\t\t<td width=\"95\">下注金额</td>\r\n\t\t<td width=\"95\">有效金额</td>\r\n\t\t<td width=\"100\">会员</td>\r\n\t\t<td width=\"90\">代理商</td>\r\n\t\t<td width=\"80\">代理商成数</td>\r\n\t\t<td width=\"90\">代理商结果</td>\r\n\t\t<td width=\"80\">总代理成数</td>\r\n\t\t<td width=\"90\">总代理结果</td>\r\n\t\t<td width=\"75\">备注</td>\r\n\t\t<td width=\"75\">备注1</td>\r\n\t\t<td width=\"30\">功\能</td>\r\n\t</tr>\r\n\t";
while ( $row = mysql_fetch_array( $result ) )
{
				$c_score += $row['score'];
				$c_num += $row['coun'];
				$c_m_result += $row['result'];
				$c_vgold += $row['vgold'];
				$c_a_result += $row['a_result'];
				$c_result_a += $row['result_a'];
				$c_result_s += $row['result_s'];
				$abc += $row['vgold'] * ( 100 - $row['agent_point'] ) * 0.01;
				echo "\t<tr class=\"m_rig\" align=\"left\" onMouseOver=\"setPointer(this, 0, 'over', '#FFFFFF', '#FFCC66', '#FFCC99');\" onMouseOut=\"setPointer(this, 0, 'out', '#FFFFFF', '#FFCC66', '#FFCC99');\">\r\n\t\t<td align=\"left\">";
				echo $row['name'];
				echo "</td>\r\n\t\t<td>";
				echo $row['coun'];
				echo "</td>\r\n\t\t<td><A HREF=\"report_agent.php?uid=";
				echo $uid;
				echo "&result_type=";
				echo $result_type;
				echo "&aid=";
				echo $row['name'];
				echo "&pay_type=";
				echo $pay_type;
				echo "&date_start=";
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
				echo "</a></td>\r\n\t\t<td>";
				echo number_format( $row['vgold'], 1 );
				echo "</td>\r\n\t\t<td>";
				echo number_format( $row['result'], 1 );
				echo "</td>\r\n\t\t<td>";
				echo number_format( $row['a_result'], 1 );
				echo "</td>\r\n\t\t<td>";
				echo number_format( $row['agent_point'] / 100, 2 );
				echo "</td>\r\n\t\t<td>";
				echo number_format( $row['result_a'], 1 );
				echo "</td>\r\n\t\t<td >";
				echo number_format( $row['world_point'] / 100, 2 );
				echo "</td>\r\n\t\t<td>";
				echo number_format( $row['result_s'], 1 );
				echo "</td>\r\n\t\t<td>\r\n\t\t\t<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#FFFFFF\" width=\"100%\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td></td>\r\n\t\t\t\t\t<td align=\"right\">";
				echo number_format( $row['result_a'], 1 );
				echo "</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t</td>\r\n\t\t<td>";
				echo number_format( $row['vgold'] * ( 100 - $row['agent_point'] ) * 0.01, 1 );
				echo "</td>\r\n\t\t<td><A href=\"javascript:\" onClick=\"show_detail('{SID0}','{AID0}');\">详细</A></td>\r\n\t</tr>\r\n";
}
echo "\t<!-- END DYNAMIC BLOCK: item0 -->\r\n\t<tr class=\"m_rig_re\">\r\n\t\t<td></td>\r\n\t\t<td>";
echo $c_num;
echo "</td>\r\n\t\t<td>";
echo $c_score;
echo "</td>\r\n\t\t<td>";
echo number_format( $c_vgold, 1 );
echo "</td>\r\n\t\t<td bgcolor=\"#000033\"><font color=\"#FFFFFF\">";
echo number_format( $c_m_result, 1 );
echo "</font></td>\r\n\t\t<td>";
echo number_format( $c_a_result, 1, ".", "" );
echo "</td>\r\n\t\t<td></td>\r\n\t\t<td bgcolor=\"#000033\"><font color=\"#FFFFFF\">";
echo number_format( $c_result_a, 1, ".", "" );
echo "</font></td>\r\n\t\t<td></td>\r\n\t\t<td bgcolor=\"#000033\"><font color=\"#FFFFFF\">";
echo number_format( $c_result_s, 1, ".", "" );
echo "</font></td>\r\n\t\t<td>";
echo number_format( $c_result_a, 1 );
echo "</td>\r\n\t\t<td>";
echo number_format( $abc, 1 );
echo "</td>\r\n\t\t<td></td>\r\n\t</tr>\r\n</table>\r\n<table width=\"780\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\t<tr>\r\n\t\t<td height=\"15\"></td>\r\n\t</tr>\r\n</table>\r\n<!-----------------↑ 现金资料区段 ↑------------------------->\r\n<table width=\"980\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"m_tab\" style=\"display: {LIST_ALL}\" bgcolor=\"#000000\">\r\n\t<tr class=\"m_title_reag\">\r\n\t\t<td width=\"70\">总代理商</td>\r\n\t\t<td width=\"40\">笔数</td>\r\n\t\t<td width=\"95\">下注金额</td>\r\n\t\t<td width=\"90\">有效金额</td>\r\n\t\t<td width=\"100\">会员</td>\r\n\t\t<td width=\"85\">代理商</td>\r\n\t\t<td width=\"80\">代理商成数</td>\r\n\t\t<td width=\"90\">代理商结果</td>\r\n\t\t<td width=\"80\">总代理成数</td>\r\n\t\t<td width=\"90\">总代理结果</td>\r\n\t\t<td width=\"75\">备注</td>\r\n\t\t<td width=\"75\">备注1</td>\r\n\t</tr>\r\n\t<!-- BEGIN DYNAMIC BLOCK: row2 -->\r\n\t<tr class=\"m_rig\">\r\n\t\t<td align=\"left\">";
echo $sid;
echo "</td>\r\n\t\t<td>";
echo $c_num;
echo "</td>\r\n\t\t<td>";
echo $c_score;
echo "</td>\r\n\t\t<td>";
echo number_format( $c_vgold, 1 );
echo "</td>\r\n\t\t<td>";
echo number_format( $c_m_result, 1 );
echo "</td>\r\n\t\t<td>";
echo number_format( $c_a_result, 1, ".", "" );
echo "</td>\r\n\t\t<td></td>\r\n\t\t<td>";
echo number_format( $c_result_a, 1, ".", "" );
echo "</td>\r\n\t\t<td></td>\r\n\t\t<td>";
echo number_format( $c_result_s, 1, ".", "" );
echo "</td>\r\n\t\t<td></td>\r\n\t\t<td></td>\r\n\t</tr>\r\n\t<!-- END DYNAMIC BLOCK: row2 -->\r\n</table>\r\n<br>&nbsp;\r\n";
if ( $credit == "none" && $sgold == "none" )
{
				$nosearch = "block";
}
else
{
				$nosearch = "none";
}
echo "\r\n<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" style=\"display: ";
echo $nosearch;
echo "\">\r\n\t<tr>\r\n\t\t<td align=center height=\"30\" bgcolor=\"#CC0000\"><marquee align=\"middle\" behavior=\"alternate\" width=\"200\"><font color=\"#FFFFFF\">查无任何资料</font></marquee></td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td align=center height=\"20\" bgcolor=\"#CCCCCC\"><a href=\"javascript:history.go(-1);\">离开</a></td>\r\n\t</tr>\r\n</table>\r\n<!-----------------↑ 无资料区段 ↑------------------------->\r\n<form name=\"winloss_form\" id=winloss_form action=\"report_winloss_detail.php\" method=\"post\" target=showdata>\r\n\t<div class=\"t_div\" id=\"winloss_window\" style=\"visibility:hidden;position: absolute;\">\r\n\t\t<input type=hidden name='uid' value='{UID}'>\r\n\t\t<input type=hidden name='sid' value=''>\r\n\t\t<input type=hidden name='aid' value=''>\r\n\t\t<input type=hidden name='date_start' value='{DATE_START}'>\r\n\t\t<input type=hidden name='date_end' value='{DATE_END}'>\r\n\t\t<input type=hidden name='id_type' value='sid'>\r\n\t\t<table id=\"winloss_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"006255\" class=\"m_tab\" width=\"300\">\r\n\t\t\t<tr class=\"m_title_ft\">\r\n\t\t\t\t<td nowrap>成数</td>\r\n\t\t\t\t<td nowrap>修改日期</td>\r\n\t\t\t\t<td nowrap>修改时间</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t<input type='button' class=\"za_button\" onClick=\"self.winloss_window.style.visibility='hidden';\" value='关闭'>\r\n\t</div>\r\n</form>\r\n<iframe id=showdata name=showdata src='../../../ok.html' scrolling='no' width=\"0\"></iframe>\r\n</body>\r\n</html>";
?>
