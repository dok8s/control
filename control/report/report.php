<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require( "../../member/include/config.inc.php" );
require( "../../member/include/define_function_list.inc.php" );
$uid = $_REQUEST['uid'];
$sql = "select id from web_sytnet where uid='".$uid."' and status=1";
$result = mysql_db_query( $dbname, $sql );
$cou = mysql_num_rows( $result ) + 0;
if ( $cou == 0 )
{
				echo "<script>window.open('".$site."/index.php','_top')</script>";
				exit( );
}
$week1 = date( "w+1" );
$row = mysql_fetch_array( $result );
if ( $row['subuser'] == 1 )
{
				$agname = $row['subname'];
				$loginfo = $agname."子帐号:".$row['Agname']."查询期间报表";
}
else
{
				$agname = $row['Agname'];
				$loginfo = "查询期间".$date_start."至".$date_end."报表";
}
$agid = $row['ID'];
$super = $row['super'];
require( "../../member/include/traditional.zh-cn.inc.php" );
$langx = $row['language'];
$date_s = date( "Y-m-d");
$date_e = date( "Y-m-d");
$today = date( "Y-m-d" );
$nowday = TDate( );
$week1 = date( "w" );
if ( $week1 == 0 )
{
				$week1 = 6;
}
else
{
				$week1 -= 1;
}
echo "<html style=\"width: 98%;margin: 0 auto;\">\r\n<head>\r\n<title>reports</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<style type=\"text/css\">\r\n<!--\r\n.m_title_re {  background-color: #577176; text-align: right; color: #FFFFFF}\r\n.m_bc { background-color: #C9DBDF; padding-left: 7px }\r\n.small {\r\n\tfont-size: 11px;\r\n\tbackground-color: #7DD5D2;\r\n\ttext-align: center;\r\n}\r\n.small_top {\r\n\tfont-size: 11px;\r\n\tcolor: #FFFFFF;\r\n\tbackground-color: #669999;\r\n\ttext-align: center;\r\n}\r\n.show_ok {background-color: gold; color: blue}\r\n.show_no {background-color: yellow; color: red}\r\n-->\r\n</style>\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n<link rel=\"stylesheet\" href=\"/style/control/calendar.css\">\r\n<SCRIPT>\r\n<!--\r\nfunction onSubmit(){\r\n\tkind_obj = document.getElementById(\"report_kind\");\r\n\tform_obj = document.getElementById(\"myFORM\");\r\n\t//if(kind_obj.value == \"A\")\r\n\t\tform_obj.action = \"report_all.php\";\r\n\t//else\r\n\t\t//form_obj.action = \"report_all.php?report_kind=\"+kind_obj.value;\r\n\treturn true;\r\n}\r\n-->\r\n</SCRIPT>\r\n<style type=\"text/css\">\r\n<!--\r\n.m_title_ce {background-color: #669999; text-align: center; color: #FFFFFF}\r\n-->\r\n</style>\r\n</head>\r\n<script language=\"JavaScript\" src=\"/js/simplecalendar.js\"></script>\r\n<script language=\"JavaScript\">\r\n\r\nfunction chg_date(range,num1,num2){\r\n\t//alert(num1+'-'+num2);\r\n\tif(range=='t' || range=='w' || range=='lw' || range=='r'){\r\n\t\tFrmData.date_start.value ='";
echo $today;
echo "';\r\n\t\tFrmData.date_end.value =FrmData.date_start.value;\r\n\t}\r\n\r\n\tif(range!='t'){\r\n\t\tif(FrmData.date_start.value!=FrmData.date_end.value){\r\n\t\t\tFrmData.date_start.value ='";
echo $today;
echo "';\r\n\t\t\tFrmData.date_end.value =FrmData.date_start.value;\r\n\t\t}\r\n\t\tvar aStartDate = FrmData.date_start.value.split('-');\r\n\t\tvar newStartDate = new Date(parseInt(aStartDate[0], 10),parseInt(aStartDate[1], 10) - 1,parseInt(aStartDate[2], 10) + num1);\r\n\t\tFrmData.date_start.value = newStartDate.getFullYear()+ '-' + padZero(newStartDate.getMonth() + 1)+ '-' + padZero(newStartDate.getDate());\r\n\t\tvar aEndDate = FrmData.date_end.value.split('-');\r\n\t\tvar newEndDate = new Date(parseInt(aEndDate[0], 10),parseInt(aEndDate[1], 10) - 1,parseInt(aEndDate[2], 10) + num2);\r\n\t\tFrmData.date_end.value = newEndDate.getFullYear()+ '-' + padZero(newEndDate.getMonth() + 1)+ '-' + padZero(newEndDate.getDate());\r\n\t}\r\n}\r\nfunction report_bg(){\r\n\tdocument.getElementById(date_num).className=\"report_c\";\r\n}\r\n</script>\r\n<body  bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\" onLoad=\"cal_init();\">\r\n<FORM id=\"myFORM\" ACTION=\"\" METHOD=POST onSubmit=\"return onSubmit();\" name=\"FrmData\">\r\n<input type=HIDDEN name=\"uid\" value=\"";
echo $uid;
echo "\">\r\n<table width=\"780\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\t<tr>\r\n\t\t<td class=\"m_tline\">\r\n\t\t\t<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td width=\"60\">&nbsp;&nbsp;报表管理:</td>\r\n\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<select name=\"gtype\" class=\"za_select\">\r\n\t\t\t\t\t\t\t<option value=\"\">全部</option>\r\n\t\t\t\t\t\t\t\t<option value=\"FT\">足球</option>\r\n\t\t\t\t\t\t\t\t<option value=\"BK\">篮球</option>\r\n\t\t\t\t\t\t\t\t<option value=\"TN\">网球</option>\r\n\t\t\t\t\t\t\t\t<option value=\"VB\">排球</option>\r\n\t\t\t\t\t\t\t\t<option value=\"BS\">棒球</option>\r\n\t\t\t\t\t\t\t\t<option value=\"OP\">其它</option>\r\n\t\t\t\t\t\t\t\t<option value=\"FS\">冠军</option>\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t\t</td>\r\n<td width=\"80\"></td>\r\n\t\t\t\t\t\t<td nowrap>\r\n\t\t\t\t\t\t\t&nbsp;<a href=\"./report.php?uid=";
echo $uid;
echo "\" onMouseOver=\"window.status='报表'; return true;\" onMouseOut=\"window.status='';return true;\"style=\"background-color:#3399FF\">报表</a>\r\n\t\t\t\t\t\t\t&nbsp;<a href=\"./report_cancel_wager.php?uid=";
echo $uid;
echo "\" onMouseOver=\"window.status='取消单分析'; return true;\" onMouseOut=\"window.status='';return true;\"style=\"background-color:\">取消单分析</a>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t</td>\r\n\t\t<td width=\"30\"><img src=\"/images/control/zh-tw/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td colspan=\"2\" height=\"4\"></td>\r\n\t</tr>\r\n</table>\r\n\r\n<table><tr><td>\r\n\r\n<table width=\"660\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"m_tab_ed\">\r\n\t<tr class=\"m_bc\">\r\n\t\t<td width=\"100\" class=\"m_title_re\"> 日期区间: </td>\r\n\t\t<td colspan=\"5\">\r\n\t\t\t<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td><input type=TEXT name=\"date_start\" value=\"";
echo $date_s;
echo "\" size=10 maxlength=11 class=\"za_text\"></td>\r\n\t\t\t\t\t<td><a href=\"javascript: void(0);\" onMouseOver=\"if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;\" onMouseOut=\"if (timeoutDelay) calendarTimeout();window.status='';\" onClick=\"g_Calendar.show(event,'FrmData.date_start',true,'yyyy-mm-dd'); return false;\">&nbsp;&nbsp;<img src=\"/images/control/calendar.gif\" name=\"imgCalendar\" width=\"34\" height=\"21\" border=\"0\"></a></td>\r\n\t\t\t\t\t<td width=\"20\" align=\"center\"> ~</td>\r\n\t\t\t\t\t<td><input type=TEXT name=\"date_end\" value=\"";
echo $date_e;
echo "\" size=10 maxlength=10 class=\"za_text\"></td>\r\n\t\t\t\t\t<td><a href=\"javascript: void(0);\" onMouseOver=\"if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;\" onMouseOut=\"if (timeoutDelay) calendarTimeout();window.status='';\" onClick=\"g_Calendar.show(event,'FrmData.date_end',true,'yyyy-mm-dd'); return false;\">&nbsp;&nbsp;<img src=\"/images/control/calendar.gif\" name=\"imgCalendar\" width=\"34\" height=\"21\" border=\"0\"></a></td>\r\n\t\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<input name=\"Submit\" type=\"Button\" class=\"za_button\" onClick=\"chg_date('t',0,0)\" value=\"今日\">\r\n\t\t\t\t\t\t<input name=\"Submit\" type=\"Button\" class=\"za_button\" onClick=\"chg_date('l',-1,-1)\" value=\"昨日\">\r\n\t\t\t\t\t\t<input name=\"Submit\" type=\"Button\" class=\"za_button\" onClick=\"chg_date('n',1,1)\" value=\"明日\">\r\n\t\t\t\t\t\t<input name=\"Submit\" type=\"Button\" class=\"za_button\" onClick=\"chg_date('w',-";
echo $week1;
echo ",6-";
echo $week1;
echo ")\" value=\"本星期\">\r\n\t\t\t\t\t\t<input name=\"Submit\" type=\"Button\" class=\"za_button\" onClick=\"chg_date('lw',-";
echo $week1;
echo "-7,6-";
echo $week1;
echo "-7)\" value=\"上星期\">\r\n\t\t\t\t\t\t<input name=\"Submit\" type=\"Button\" class=\"za_button\" onClick=\"FrmData.date_start.value='";
echo $nowday[0];
echo "';FrmData.date_end.value='";
echo $nowday[1];
echo "'\" value=\"本期\">\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr class=\"m_bc\">\r\n\t\t<td class=\"m_title_re\"> 报表分类: </td>\r\n\t\t<td colspan=\"4\">\r\n\t\t\t<select name=\"report_kind\" class=\"za_select\">\r\n\t\t\t\t<option value=\"A\" SELECTED>总帐</option>\r\n\t\t\t\t<!--option value=\"D\">取消</option>\r\n\t\t\t\t<option value=\"D4\">非正常投注单</option-->\r\n\t\t\t\t<!--option value=\"C\">分类帐</option-->\r\n\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<!--tr class=\"m_bc\">\r\n\t\t<td class=\"m_title_re\"> 币值: </td>\r\n\t\t<td colspan=\"4\">\r\n\t\t\t<select name=\"currency\" class=\"za_select\"-->\r\n\t\t\t\t<!-- BEGIN DYNAMIC BLOCK: currency -->\r\n\t\t\t\t<!--option value=\"{CUR_VALUE}\">{CUR_NAME}</option-->\r\n\t\t\t\t<!-- END DYNAMIC BLOCK: currency -->\r\n\t\t\t<!--/select>\r\n\t\t</td>\r\n\t</tr-->\r\n\t<tr class=\"m_bc\">\r\n\t\t<td class=\"m_title_re\"> 投注方式: </td>\r\n\t\t<td colspan=\"4\">\r\n\t\t\t<select name=\"pay_type\" class=\"za_select\">\r\n\t\t\t\t<option value=\"\" SELECTED>全部</option>\r\n\t\t\t\t<option value=\"0\">信用额度</option>\r\n\t\t\t\t<option value=\"1\">现金</option>\r\n\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr class=\"m_bc\">\r\n\t\t<td class=\"m_title_re\"> 投注种类: </td>\r\n\t\t<td colspan=\"4\">\r\n\t\t\t<select name=\"wtype\" class=\"za_select\">\r\n\t\t\t\t<option value=\"\" SELECTED>全部</option>\r\n\t\t\t\t<option value=\"R\">让球(分)</option>\r\n\t\t\t\t<option value=\"RE\">滚球</option>\r\n\t\t\t\t<option value=\"P\">标准过关</option>\r\n\t\t\t\t<option value=\"PR\">让球(分)过关</option>\r\n\t\t\t\t<option value=\"PC\">综合过关</option>\r\n\t\t\t\t<option value=\"OU\">大小</option>\r\n\t\t\t\t<option value=\"ROU\">滚球大小</option>\r\n\t\t\t\t<option value=\"PD\">波胆</option>\r\n\t\t\t\t<option value=\"T\">入球</option>\r\n\t\t\t\t<option value=\"M\">独赢</option>\r\n\t\t\t\t<option value=\"F\">半全场</option>\r\n\t\t\t\t<option value=\"HR\">上半场让球(分)</option>\r\n\t\t\t\t<option value=\"HOU\">上半场大小</option>\r\n\t\t\t\t<option value=\"HM\">上半场独赢</option>\r\n\t\t\t\t<option value=\"HRE\">上半滚球让球(分)</option>\r\n\t\t\t\t<option value=\"HROU\">上半滚球大小</option>\r\n                                <option value=\"HPD\">上半波胆</option>\r\n\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t";
$mdate_t = date( "m-d" );
$mdate_y = date( "m-d", time( ) - 86400 );
$mysql = "select * from foot_match where mid%2=1 and m_Date='".$mdate_t."' and MB_Inball<>''";
$result = mysql_db_query( $dbname, $mysql );
$ft_cou = mysql_num_rows( $result ) + 0;
$mysql = "select * from foot_match where mid%2=1 and m_Date='".$mdate_t."' and MB_Inball=''";
$result = mysql_db_query( $dbname, $mysql );
$ft_cou1 = mysql_num_rows( $result ) + 0;
$mysql = "select * from foot_match where mid%2=1 and m_Date='".$mdate_y."' and MB_Inball<>''";
$result = mysql_db_query( $dbname, $mysql );
$ft_cou2 = mysql_num_rows( $result ) + 0;
$mysql = "select * from foot_match where mid%2=1 and m_Date='".$mdate_y."' and MB_Inball=''";
$result = mysql_db_query( $dbname, $mysql );
$ft_cou3 = mysql_num_rows( $result ) + 0;
$mysql = "select * from bask_match where m_Date='".$mdate_t."' and MB_Inball<>'' and mb_mid<100000";
$result = mysql_db_query( $dbname, $mysql );
$bk_cou = mysql_num_rows( $result ) + 0;
$mysql = "select * from bask_match where m_Date='".$mdate_t."' and MB_Inball='' and mb_mid<100000";
$result = mysql_db_query( $dbname, $mysql );
$bk_cou1 = mysql_num_rows( $result ) + 0;
$mysql = "select * from bask_match where m_Date='".$mdate_y."' and MB_Inball<>'' and mb_mid<100000";
$result = mysql_db_query( $dbname, $mysql );
$bk_cou2 = mysql_num_rows( $result ) + 0;
$mysql = "select * from bask_match where m_Date='".$mdate_y."' and MB_Inball='' and mb_mid<100000";
$result = mysql_db_query( $dbname, $mysql );
$bk_cou3 = mysql_num_rows( $result ) + 0;
$mysql = "select * from tennis where m_Date='".$mdate_t."' and MB_Inball<>''";
$result = mysql_db_query( $dbname, $mysql );
$tn_cou = mysql_num_rows( $result ) + 0;
$mysql = "select * from tennis where m_Date='".$mdate_t."' and MB_Inball=''";
$result = mysql_db_query( $dbname, $mysql );
$tn_cou1 = mysql_num_rows( $result ) + 0;
$mysql = "select * from tennis where m_Date='".$mdate_y."' and MB_Inball<>''";
$result = mysql_db_query( $dbname, $mysql );
$tn_cou2 = mysql_num_rows( $result ) + 0;
$mysql = "select * from tennis where m_Date='".$mdate_y."' and MB_Inball=''";
$result = mysql_db_query( $dbname, $mysql );
$tn_cou3 = mysql_num_rows( $result ) + 0;
$mysql = "select * from volleyball where m_Date='".$mdate_t."' and MB_Inball<>''";
$result = mysql_db_query( $dbname, $mysql );
$vb_cou = mysql_num_rows( $result ) + 0;
$mysql = "select * from volleyball where m_Date='".$mdate_t."' and MB_Inball=''";
$result = mysql_db_query( $dbname, $mysql );
$vb_cou1 = mysql_num_rows( $result ) + 0;
$mysql = "select * from volleyball where m_Date='".$mdate_y."' and MB_Inball<>''";
$result = mysql_db_query( $dbname, $mysql );
$vb_cou2 = mysql_num_rows( $result ) + 0;
$mysql = "select * from volleyball where m_Date='".$mdate_y."' and MB_Inball=''";
$result = mysql_db_query( $dbname, $mysql );
$vb_cou3 = mysql_num_rows( $result ) + 0;
$mysql = "select * from baseball where m_Date='".$mdate_t."' and MB_Inball<>''";
$result = mysql_db_query( $dbname, $mysql );
$bs_cou = mysql_num_rows( $result ) + 0;
$mysql = "select * from baseball where m_Date='".$mdate_t."' and MB_Inball=''";
$result = mysql_db_query( $dbname, $mysql );
$bs_cou1 = mysql_num_rows( $result ) + 0;
$mysql = "select * from baseball where m_Date='".$mdate_y."' and MB_Inball<>''";
$result = mysql_db_query( $dbname, $mysql );
$bs_cou2 = mysql_num_rows( $result ) + 0;
$mysql = "select * from baseball where m_Date='".$mdate_y."' and MB_Inball=''";
$result = mysql_db_query( $dbname, $mysql );
$bs_cou3 = mysql_num_rows( $result ) + 0;
$mysql = "select * from sp_match where date_format(mstart,'%m-%d')='".$mdate_t."' and QQ526738=1 group by mid";
$result = mysql_db_query( $dbname, $mysql );
$sp_cou = mysql_num_rows( $result ) + 0;
$mysql = "select * from sp_match where date_format(mstart,'%m-%d')='".$mdate_t."' and QQ526738=0 group by mid";
$result = mysql_db_query( $dbname, $mysql );
$sp_cou1 = mysql_num_rows( $result ) + 0;
$mysql = "select * from sp_match where date_format(mstart,'%m-%d')='".$mdate_y."' and QQ526738=1 group by mid";
$result = mysql_db_query( $dbname, $mysql );
$sp_cou2 = mysql_num_rows( $result ) + 0;
$mysql = "select * from sp_match where date_format(mstart,'%m-%d')='".$mdate_y."' and QQ526738=0 group by mid";
$result = mysql_db_query( $dbname, $mysql );
$sp_cou3 = mysql_num_rows( $result ) + 0;
$mysql = "select * from other_play where m_Date='".$mdate_t."' and MB_Inball<>''";
$result = mysql_db_query( $dbname, $mysql );
$op_cou = mysql_num_rows( $result ) + 0;
$mysql = "select * from other_play where m_Date='".$mdate_t."' and MB_Inball=''";
$result = mysql_db_query( $dbname, $mysql );
$op_cou1 = mysql_num_rows( $result ) + 0;
$mysql = "select * from other_play where m_Date='".$mdate_y."' and MB_Inball<>''";
$result = mysql_db_query( $dbname, $mysql );
$op_cou2 = mysql_num_rows( $result ) + 0;
$mysql = "select * from other_play where m_Date='".$mdate_y."' and MB_Inball=''";
$result = mysql_db_query( $dbname, $mysql );
$op_cou3 = mysql_num_rows( $result ) + 0;
if ( $ft_cou1 + $bk_cou1 + $tn_cou1 + $vb_cou1 + $bs_cou1 + $sp_cou1 + $op_cou1 == 0 )
{
				$kkk1 = "<b><font class='show_ok'>完成</font></b>";
}
else
{
				$kkk1 = "<b><font class='show_no'>未完成</font></b>";
}
/*if ( $ft_cou3 + $bk_cou3 + $tn_cou3 + $vb_cou3 + $bs_cou3 + $sp_cou3 + $op_cou3 == 0 )
{
				$kkk3 = "<b><font class='show_ok'>完成</font></b>";
}
else
{*/
				$kkk3 = "<b><font class='show_no'>未完成</font></b>";
//}
echo "    <tr class=\"m_bc\">\r\n      <td class=\"m_title_re\">日期</td>\r\n      <td colspan=\"2\" class=\"m_title_ce\">";
echo date( "Y-m-d", time( ) - 86400 );
echo $kkk3;
echo "</td>\r\n      <td colspan=\"2\" class=\"m_title_ce\">";
echo date( "Y-m-d" );
echo $kkk1;
echo "</td>\r\n    </tr>\r\n    <tr class=\"m_bc\">\r\n      <td class=\"m_title_re\">目前状态</td>\r\n      <td style=\"color:#FF0000\">有结果</td>\r\n      <td style=\"color:#FF0000\">无结果</td>\r\n      <td>有结果</td>\r\n      <td>无结果</td>\r\n    </tr>\r\n    <tr class=\"m_bc\">\r\n      <td class=\"m_title_re\">足球</td>\r\n      <td style=\"color:#FF0000\">";
echo $ft_cou2;
echo "</td>\r\n      <td style=\"color:#FF0000\">";
echo "0" ;//$ft_cou3;
echo "</td>\r\n      <td>";
echo $ft_cou;
echo "</td>\r\n      <td>";
echo $ft_cou1;
echo "</td>\r\n    </tr>\r\n\r\n    <tr class=\"m_bc\">\r\n      <td class=\"m_title_re\">篮球</td>\r\n      <td style=\"color:#FF0000\">";
echo $bk_cou2;
echo "</td>\r\n      <td style=\"color:#FF0000\">";
echo "0";//$bk_cou3;
echo "</td>\r\n      <td>";
echo $bk_cou;
echo "</td>\r\n      <td>";
echo $bk_cou1;
echo "</td>\r\n    </tr>\r\n\r\n    <tr class=\"m_bc\">\r\n      <td class=\"m_title_re\">网球</td>\r\n      <td style=\"color:#FF0000\">";
echo $tn_cou2;
echo "</td>\r\n      <td style=\"color:#FF0000\">";
echo "0";//$tn_cou3;
echo "</td>\r\n      <td>";
echo $tn_cou + 0;
echo "</td>\r\n      <td>";
echo $tn_cou1;
echo "</td>\r\n    </tr>\r\n\r\n    <tr class=\"m_bc\">\r\n      <td class=\"m_title_re\">排球</td>\r\n      <td style=\"color:#FF0000\">";
echo $vb_cou2;
echo "</td>\r\n      <td style=\"color:#FF0000\">";
echo "0"; //$vb_cou3;
echo "</td>\r\n      <td>";
echo $vb_cou;
echo "</td>\r\n      <td>";
echo $vb_cou1;
echo "</td>\r\n    </tr>\r\n\t<tr class=\"m_bc\">\r\n\t\t<td class=\"m_title_re\">棒球</td>\r\n\t\t<td style=\"color:#FF0000\">";
echo $bs_cou2;
echo "</td>\r\n\t\t<td style=\"color:#FF0000\">";
echo "0";//$bs_cou3;
echo "</td>\r\n\t\t<td>";
echo $bs_cou;
echo "</td>\r\n\t\t<td>";
echo $bs_cou1;
echo "</td>\r\n\t</tr>\r\n    <tr class=\"m_bc\">\r\n      <td class=\"m_title_re\">特殊</td>\r\n      <td style=\"color:#FF0000\">";
echo $sp_cou2;
echo "</td>\r\n\t\t<td style=\"color:#FF0000\">";
echo "0";//$sp_cou3;
echo "</td>\r\n\t\t<td>";
echo $sp_cou;
echo "</td>\r\n\t\t<td>";
echo $sp_cou1;
echo "</td>\r\n    </tr>\r\n\r\n<tr class=\"m_bc\">\r\n\t\t\t\t\t\t<td class=\"m_title_re\">其他</td>\r\n\t\t\t\t\t\t<td style=\"color:#FF0000\">";
echo $op_cou2;
echo "</td>\r\n\t\t\t\t\t\t<td style=\"color:#FF0000\">";
echo "0";//$op_cou3;
echo "</td>\r\n\t\t\t\t\t\t<td>";
echo $op_cou;
echo "</td>\r\n\t\t\t\t\t\t<td>";
echo $op_cou1;
echo "</td>\r\n\t\t\t\t\t</tr>\r\n\t<tr bgcolor=\"#FFFFFF\">\r\n\t\t<td height=\"30\" colspan=\"6\">\r\n\t\t\t<table>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td align=\"right\" width=\"60\"> 注单状态: </td>\r\n\t\t\t\t\t<td width=\"250\">\r\n\t\t\t\t\t\t<select name=\"result_type\" class=\"za_select\">\r\n\t\t\t\t\t\t\t<OPTION VALUE=\"Y\">有结果</OPTION>\r\n\t\t\t\t\t\t\t<OPTION VALUE=\"N\">未有结果</OPTION>\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<input type=SUBMIT name=\"SUBMIT\" value=\"查询\" class=\"za_button\">\r\n\t\t\t\t\t\t&nbsp;&nbsp;&nbsp;\r\n\t\t\t\t\t\t<input type=BUTTON name=\"CANCEL\" value=\"取消\" onClick=\"javascript:history.go(-1)\" class=\"za_button\">\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n\r\n </td><td>\r\n<table width=246 border=0 cellpadding=0 cellspacing=1 class=\"m_tab_ed\">\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td height=\"9\" colspan=2 class=\"small_top\">2016年月帐期数</td>\r\n\t\t\t\t\t</tr>";

$timestart = strtotime('2015-12-28');
$D = 3600*24;
$Q = $D*7*4;
for($i=1; $i<=13; $i++){
	$d_s = date('Y/m/d', $timestart+($i-1)*$Q);
	$d_e = date('Y/m/d', $timestart+$i*$Q-$D);
	echo "
<tr><td width='70' height='10' class='small'>第{$i}期</td><td width='174' class='m_cen_top' id='Y_{$i}'>$d_s ~ $d_e</td></tr>";
}

//echo "</table>\r\n</td>\r\n\r\n</td></tr></table>\r\n</form>\r\n</body>\r\n</html>\r\n<script>\r\nvar date_num='";
//echo $nowday[2];
//echo "';\r\nreport_bg();\r\n</script>";
?>
