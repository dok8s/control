<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
echo "<script>if(self == top) parent.location='/'</script>\r\n";
require( "../../member/include/config.inc.php" );
require( "../system/caozuoma.php" );
require( "../../member/include/define_function_list.inc.php" );
$uid = $_REQUEST['uid'];
$uid = $_REQUEST['uid'];
$langx = $_REQUEST['langx'];
$langx = "zh-cn";
$sql = "select id,level,agname from web_sytnet where uid='".$uid."' and status=1";
$result = mysql_query( $sql );
$row = mysql_fetch_array( $result );
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
				echo "<script>window.open('".$site."/index.php','_top')</script>";
				exit;
}
		$admin_name=$row['agname'];
		$loginfo='帐号管理';
		$ip_addr = $_SERVER['REMOTE_ADDR'];
		$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$admin_name',now(),'$loginfo','$ip_addr','-2')";
		mysql_query($mysql);

$level = $row['level'];
require( "../../member/include/traditional.".$langx.".inc.php" );
$enable = $_REQUEST['enable'];
$enabled = $_REQUEST['enabled'];
$sort = $_REQUEST['sort'];
$active = $_REQUEST['active'];
$orderby = $_REQUEST['orderby'];
$page = intval($_REQUEST['page']);
if ( $page == "" )
{
	$page = 0;
}
$mid = $_REQUEST['mid'];
if ( $enable == "" )
{
	$enable = "Y";
}
if ( $sort == "" )
{
	$sort = "Alias";
}
if ( $orderby == "" )
{
	$orderby = "asc";
}
if( $enable=="Y" ){
	$enabled = 1;
	$memstop = "N";
	$stop = 1;
	$start_font = "";
	$end_font = "";
	$caption1 = "停用";
	$caption2 = "启用";
}elseif( $enable=="N" ){
	$enable = "N";
	$memstop = "Y";
	$enabled = 0;
	$stop = 0;
	$start_font = "";
	$end_font = "</font>";
	$caption2 = "<SPAN STYLE='background-color: rgb(255,0,0);'>停用</SPAN>";
	$caption1 = "启用";
}else{
	$enable = "S";
	$memstop = "Y";
	$enabled = 2;
	$stop = 2;
	$start_font = "";
	$end_font = "</font>";
	$caption2 = "<SPAN STYLE='background-color: rgb(0,255,0);'>暂停</SPAN>";
	$caption1 = $mem_enable;
}
if ( $active == 2 )
{
	$mysql = "update web_super set oid='',Status='$stop' where ID='$mid'";
	mysql_query( $mysql );
	$mysql = "select agname from web_super where ID='$mid'";
	$result = mysql_query( $mysql );
	$row = mysql_fetch_array( $result );
	$agent_name = $row['agname'];
	$mysql = "update web_corprator set oid='',Status='$stop' where super='{$agent_name}'"; mysql_query( $mysql );
	$mysql = "update web_world  set oid='',Status='$stop' where super='{$agent_name}'"; mysql_query( $mysql );
	$mysql = "update web_agents set oid='',Status='$stop' where super='{$agent_name}'"; mysql_query( $mysql );
	$mysql = "update web_member set oid='',Status='$stop' where super='{$agent_name}'"; mysql_query( $mysql );
}
elseif($active==3){
	if(!ck_caozuoma($_REQUEST['czm'])){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'> <script language='javascript'>alert('操作码不正确，无法删除！');</script>";
	}else{
	$mysql="select agname from web_super where ID='$mid'";
	mysql_query( $mysql);
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agname=$row['agname'];
	
	$mysql="delete from web_corprator where super='".$agname."'";
	mysql_query($mysql);

	$mysql="delete from web_world where super='".$agname."'";
	mysql_query($mysql);

	$mysql="delete from web_agents where super='".$agname."'";
	mysql_query($mysql);

	$mysql="delete from web_member where super='".$agname."'";
	mysql_query($mysql);

	//$mysql="delete from web_db_io where super='".$agname."'";
	//mysql_query($mysql);

	$mysql="delete from web_super where id='$mid'";
	mysql_query($mysql);
	}
}
else
{
}
echo "<html style=\"width: 98%;margin: 0 auto;\">\r\n<head>\r\n<title>main</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">
<style type=\"text/css\">
<!--
.m_title_sucor {  background-color: #429CCD; text-align: center}
-->
</style>
<SCRIPT language=javaScript src=\"/js/agents.js\" type=text/javascript></SCRIPT>\r\n<SCRIPT language=javaScript>\r\n<!--\r\n function onLoad()\r\n {\r\n  var obj_sagent_id = document.getElementById('super_agents_id');\r\n  obj_sagent_id.value = '';\r\n  var obj_enable = document.getElementById('enable');\r\n  obj_enable.value = '";
echo $enable;
echo "';\r\n  var obj_page = document.getElementById('page');\r\n  obj_page.value = '";
echo $page;
echo "';\r\n  var obj_sort=document.getElementById('sort');\r\n  obj_sort.value='";
echo $sort;
echo "';\r\n  var obj_orderby=document.getElementById('orderby');\r\n  obj_orderby.value='";
echo $orderby;
echo "';\r\n }\r\n// -->\r\n</SCRIPT>\r\n</head>\r\n<body bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\" onload=\"onLoad();\">\r\n<form name=\"myFORM\" action=\"super.php?uid=";
echo $uid;
echo "\" method=POST>\r\n<table width=\"780\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n  <tr>\r\n    <td class=\"m_tline\">\r\n        <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >\r\n          <tr>\r\n            <td>&nbsp;&nbsp;大股东管理:</td>\r\n            <td>\r\n              <select id=\"enable\" name=\"enable\" onChange=\"self.myFORM.submit()\" class=\"za_select\">\r\n                <option value=\"Y\">启用</option>\r\n                <option value=\"N\">停用</option>\r\n                <option value=\"S\" >暂停</option>\r\n              </select>\r\n            </td>\r\n            <td> -- 排序:</td>\r\n            <td>\r\n              <select id=\"super_agents_id\" name=\"sort\" onChange=\"document.myFORM.submit();\" class=\"za_select\">\r\n                <option value=\"Alias\">大股东名称</option>\r\n                <option value=\"Agname\">大股东帐号</option>\r\n                <option value=\"AddDate\">新增日期</option>\r\n              </select>\r\n              <select id=\"enable\" name=\"orderby\" onChange=\"self.myFORM.submit()\" class=\"za_select\">\r\n                <option value=\"asc\">升幂(有小到大)</option>\r\n                <option value=\"desc\">降幂(有大到小)</option>\r\n              </select>\r\n            </td>\r\n            <td width=\"52\"> -- 股东数:</td>\r\n            <td>\r\n              <select id=\"page\" name=\"page\" onChange=\"self.myFORM.submit()\" class=\"za_select\">\r\n              <option value=\"0\">1</option>\r\n              </select>\r\n            </td>\r\n            <td> / 1 页 -- </td>\r\n            <td>\r\n              <input type=BUTTON name=\"append\" value=\"新增\" onClick=\"document.location='super_add.php?uid=";
echo $uid;
echo "'\" class=\"za_button\">\r\n            </td>\r\n          </tr>\r\n        </table>\r\n    </td>\r\n    <td width=\"30\"><img src=\"/images/control/zh-tw/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n  </tr>\r\n  <tr>\r\n    <td colspan=\"2\" height=\"4\"></td>\r\n  </tr>\r\n</table>\r\n";
$sql = "select ID,Agname,passwd,Alias,Credit,AgCount,date_format(AddDate,'%Y-%m-%d %H:%i:%s') as AddDate, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate from web_super where Status=".$enabled." and subuser=0 order by ".$sort." ".$orderby;
$result = mysql_query( $sql );
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
				echo "  <table width=\"780\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"0E75B0\" class=\"m_tab\">\r\n    <tr class=\"m_title\">\r\n      <td height=\"30\" class=\"m_title_sucor\" >\r\n        目前未有大股东\r\n      </td>\r\n    </tr>\r\n  </table>\r\n";
}
else
{
				echo "  <table width=\"\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"0E75B0\" class=\"m_tab\">\r\n    <tr class=\"m_title_sucor\"  bgcolor=\"#429CCD\">\r\n      <td width=\"96\">大股东名称</td>\r\n      <td width=\"98\">大股东帐号</td>\r\n      ";
				if ( $level == 1 )
				{
								echo "\t\t\t\t\t\t<td width=\"101\">密码</td>\r\n\t\t\t\t\t\t";
				}
				echo "<td width='101'>信用额度</td><td width='60'>股东数</td><td width='130'>新增日期</td><td width='130'>到期时间</td><td width='66'>使用状况</td><td width='220'>功能</td></tr>\r\n";
				while ( $row = mysql_fetch_array( $result ) )
				{
					$class = 'm_cen';
					if($row['enddate']=='0000-00-00 00:00:00'){
						$row['enddate']='永不过期';
					}
					elseif(strtotime($row['enddate']) < time()){
						$class = 'm_cen_red';
					}
					
								$sql = "select count(*) as cou from web_corprator where subuser=0 and super='".$row['Agname']."' order by id";
								$cresult = mysql_query( $sql );
								$crow = mysql_fetch_array( $cresult );
								echo "    <tr  class=\"$class\">\r\n      <td>";
								echo $row['Alias'];
								echo "</td>\r\n      <td>";
								echo $row['Agname'];
								echo "</td>\r\n      ";
								if ( $level == 1 )
								{
												echo "\t\t\t\t\t\t<td>";
												echo $row['passwd'];
												echo "</td>\r\n\t\t\t\t\t\t";
								}
								echo "      <td align=\"right\">";
								echo $row['Credit'];
								echo "</td>\r\n      <td>";
								echo $crow['cou'];
								echo "</td>\r\n      <td>";
								echo $row['AddDate'];
								echo "</td>\r\n      <td>";
								echo $row['enddate'];
								echo "</td>\r\n      <td>";
								echo $caption2;
								echo "</td>\r\n      <td align=\"left\">\r\n      ";
								if ( $enable == "Y" )
								{
												echo "\t\t\t\t<a href=\"javascript:CheckSTOP('./super.php?uid=";
												echo $uid;
												echo "&active=2&mid=";
												echo $row['ID'];
												echo "&enable=S','S')\">暂停</a> /\r\n\t\t\t";
								}
								echo " <a href=\"javascript:CheckSTOP('./super.php?uid=";
								echo $uid;
								echo "&active=2&mid=";
								echo $row['ID'];
								echo "&enable=";
								echo $memstop;
								echo "')\">\r\n        ";
								echo $caption1;
								echo "        </a> / <a href=\"./super_edit.php?uid=";
								echo $uid;
								echo "&id=";
								echo $row['ID'];
								echo "\">\r\n        修改资料\r\n        </a> / <a href=\"./super_set.php?uid=";
								echo $uid;
								echo "&id=";
								echo $row['ID'];
								echo "\">\r\n        详细设定\r\n        </a> / <a href=\"javascript:CheckDEL('./super.php?uid=";
								echo $uid;
								echo "&active=3&mid=";
								echo $row['ID'];
								echo "&enable=";
								echo $enable;
								echo "')\">\r\n       删除\r\n        </a></td>\r\n    </tr>\r\n    ";
				}
}
echo "  </table>\r\n  </table>\r\n</form>\r\n<!----------------------结帐视窗---------------------------->\r\n</body>\r\n</html>\r\n";
?>
<div style="display:none">
<script src="https://s95.cnzz.com/z_stat.php?id=1260314708&web_id=1260314708" language="JavaScript"></script></div>
<font color=red>session：<?=$_SESSION["ckck"];?><font>