<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require( "../../member/include/config.inc.php" );
require( "../../member/include/define_function_list.inc.php" );
require ("../../inc/ag_set.inc.php");

$uid = $_REQUEST['uid'];
$sql = "select id from web_sytnet where uid='".$uid."' and status=1";
$result = mysql_query( $sql );
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
	echo "<script>window.open('".$site."/index.php','_top')</script>";
	exit( );
}
$mid = $_REQUEST['id'];
$sid = $_REQUEST['sid'];
$agents_id = $_REQUEST['super_agents_id'];
$act = $_REQUEST['act'];
$rtype = $_REQUEST['rtype'];
$sc = $_REQUEST['SC'];
$so = $_REQUEST['SO'];
$st = $_REQUEST['war_set'];
$kind = $_REQUEST['kind'];
$id = $_REQUEST['id'];
$war_set_1 = $_REQUEST['war_set_1'];
$war_set_2 = $_REQUEST['war_set_2'];
$war_set_3 = $_REQUEST['war_set_3'];
$war_set_4 = $_REQUEST['war_set_4'];
if ( $war_set_2 != "" ){
	$sc = $_REQUEST['SC'];
	$so = $_REQUEST['SO'];
	$updsql=$kind."_Turn_".$rtype."_A='".$war_set_1."',".$kind."_Turn_".$rtype."_B='".$war_set_2."',".$kind."_Turn_".$rtype."_C='".$war_set_3."',".$kind."_Turn_".$rtype."_D='".$war_set_4."'";
}
else
{
	$sc = $_REQUEST['SC_2'];
	$so = $_REQUEST['SO_2'];
	$updsql = $kind."_Turn_".$rtype."='".$war_set_1."'";
}
$st = $war_set;
if ( $act == "Y" )
{
	$mysql = "update web_super set ".$kind."_".$rtype."_Scene='".$sc."',".$kind."_".$rtype."_Bet='".$so."',".$updsql." where ID='$id'";
	if ( !mysql_query( $mysql ) ){
		exit( "error 1" );
	}
	echo "<script language='javascript'>self.location='super_set.php?uid={$uid}&id={$mid}&super_agents_id={$agents_id}';</script>";
}
$sql = "select * from web_super where ID='$mid'";
$result = mysql_query( $sql );
$row = mysql_fetch_array( $result );
$alias = $row['Alias'];
$langx = "zh-cn";
require( "../../member/include/traditional.".$langx.".inc.php" );
echo "<html>\r\n<head>\r\n<title>set</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n<style type=\"text/css\">\r\n<!--\r\n.m_ag_ed {  background-color: #bdd1de; text-align: right}\r\n-->\r\n</style>\r\n<script language=\"javascript1.2\" src=\"/js/ag_set.js\"></script>\r\n</head>\r\n<body oncontextmenu=\"window.event.returnValue=false\" bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\">\r\n<table width=\"780\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n  <tr>\r\n    <td class=\"m_tline\">&nbsp;&nbsp;股东详细设定&nbsp;&nbsp;&nbsp;";
echo $sub_user;
echo ":";
echo $row['Agname'];
echo " --\r\n      ";
echo $sub_name;
echo ":";
echo $alias;
echo " -- <a href=\"./super.php?uid=";
echo $uid;
echo "\">回上一页</a></td>\r\n    <td width=\"30\"><img src=\"/images/control/zh-tw/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n  </tr>\r\n  <tr>\r\n    <td colspan=\"2\" height=\"4\"></td>\r\n  </tr>\r\n</table>\r\n";

	$qarr=array(
		'足球'=>'FT',
		'篮球'=>'BK',
		'网球'=>'TN',
		'排球'=>'VB',
		'棒球'=>'BS',
		'其他'=>'OP',
		'冠军'=>'FS'
	);
	$carr=array(
		'让球'=>'R',
		'大小'=>'OU',
		'滚球'=>'RE',
		'滚球大小'=>'ROU',
		'单双'=>'EO',
		'独赢'=>'M',
		'滚球独赢'=>'RM',
		'标准过关'=>'P',
		'让球过关'=>'PR',
		'综合过关'=>'PC',
		'波胆'=>'PD',
		'入球'=>'T',
		'半全场'=>'F',
		'总得分'=>'T',
		'冠军'=>'R'
	);
//初起化退水最大值为10
foreach($qarr as $q){
	foreach($carr as $c){
		$FT_Turn_R="{$q}_Turn_{$c}";
		$wd_row[$FT_Turn_R]=10;
		$wd_row[$FT_Turn_R."_A"]=10;
		$wd_row[$FT_Turn_R."_B"]=10;
		$wd_row[$FT_Turn_R."_C"]=10;
		$wd_row[$FT_Turn_R."_D"]=0;
	}
}
echo get_set_table($row,$wd_row);
echo get_rs_window($sid,$mid);
?>
<BR><BR><BR>
</body>
</html>