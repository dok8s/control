<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
echo "<script>if(self == top) location='/'</script>\r\n";
require( "../../member/include/config.inc.php" );
$gdate = $_REQUEST['gdate'];
$uid = $_REQUEST['uid'];
$gid = $_REQUEST['gid'] + 0;
$gtype = $_REQUEST['gtype'];
$r_show	=	$_REQUEST['r_show'];


if($gtype=='') $gtype='FT';
if($r_show=='') $r_show='all';

$sql = "select id from web_sytnet where uid='".$uid."' and status=1";
$result = mysql_db_query( $dbname, $sql );
$row = mysql_fetch_array( $result );
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
				echo "<script>window.open('".$site."/index.php','_top')</script>";
				exit( );
}
if ( $gdate == "" )
{
				$gdate = date( "m-d" );
}
$action = $_REQUEST['active'];
echo "<html style=\"width: 98%;margin: 0 auto;\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<title></title>\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n<SCRIPT>\r\n<!--\r\n function onLoad()\r\n {\r\n  var gtype = document.getElementById('gtype');\r\n  gtype.value = '";
echo $gtype;
echo "';\r\n }\r\nfunction CheckCLOSE(str)\r\n {\r\n  if(confirm(\"确实要取消本场比赛吗?\"))\r\n  document.location=str;\r\n }\r\n// -->\r\n</SCRIPT>\r\n</head>\r\n\r\n<body bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"10\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\"  onload=\"onLoad()\";>\r\n<FORM NAME=\"myFORM\" ACTION=\"\" METHOD=POST>\r\n  <table width=\"775\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n    <tr>\r\n      <td class=\"m_tline\" width=\"746\">&nbsp;线上数据－<font color=\"#CC0000\">比分审核&nbsp;</font>&nbsp;&nbsp;&nbsp;类别:\r\n       <select class=za_select onchange=document.myFORM.submit(); name=gtype>\r\n\t      <option value=\"FT\">足球</option>\r\n\t\t\t\t<option value=\"BK\">篮球</option>\r\n\t\t\t\t<option value=\"TN\">网球</option>\r\n\t\t\t\t<option value=\"VB\">排球</option>\r\n<option value=\"BS\">棒球</option>\r\n<option value=\"OP\">其他</option>\r\n\t      <option value=\"FS\">特殊</option>\r\n\t\t\t </select>\r\n        日期:\r\n        <select class=za_select onchange=document.myFORM.submit(); name=gdate>\r\n\t\t\t\t<option value=\"\"></option>";
$udate = date("Y-m-d", time()-(3600*24*14));
switch ( $gtype ){
	
	case "TN" :
				$sql = "select DATE_FORMAT(m_start,'%Y-%m-%d') as m_date,DATE_FORMAT(m_start,'%m-%d') as gdate from tennis where m_start>'$udate' and m_date<>'' and mb_inball<>'' group by m_date order by m_date desc";
				break;
	case "BK" :
				$sql = "select DATE_FORMAT(m_start,'%Y-%m-%d') as m_date,DATE_FORMAT(m_start,'%m-%d') as gdate from bask_match where m_start>'$udate' and m_date<>'' and mb_inball<>'' group by m_date order by m_date desc";
				break;
	case "FS" :
				$sql = "select DATE_FORMAT(mstart,'%Y-%m-%d') as m_date,DATE_FORMAT(mstart,'%m-%d') as gdate from sp_match where mstart>'$udate' and QQ526738=1 group by mdate order by mdate desc";
				break;
	case "VB" :
				$sql = "select DATE_FORMAT(m_start,'%Y-%m-%d') as m_date,DATE_FORMAT(m_start,'%m-%d') as gdate from volleyball where m_start>'$udate' and m_date<>'' and mb_inball<>'' group by m_date order by m_date desc";
				break;
	case "BS" :
				$sql = "select DATE_FORMAT(m_start,'%Y-%m-%d') as m_date,DATE_FORMAT(m_start,'%m-%d') as gdate from baseball where m_start>'$udate' and m_date<>'' and mb_inball<>'' group by m_date order by m_date desc";
				break;
	case "OP" :
				$sql = "select DATE_FORMAT(m_start,'%Y-%m-%d') as m_date,DATE_FORMAT(m_start,'%m-%d') as gdate from other_play where m_start>'$udate' and m_date<>'' and mb_inball<>'' group by m_date order by m_date desc";
				break;
	default :
				$sql = "select DATE_FORMAT(m_start,'%Y-%m-%d') as m_date,DATE_FORMAT(m_start,'%m-%d') as gdate from foot_match where m_start>'$udate' and m_date<>'' and ((is_hr=1 and MB_Inball_hr<>'') or (is_hr<>1 and MB_Inball<>'')) group by m_date order by m_date desc";
				$gtype = "FT";
				break;
}

				$result = mysql_db_query( $dbname, $sql );
				$cou = mysql_num_rows( $result );
				if ( $cou == 0 )
				{
								echo "<option value='".$gdate."'>".date( "Y-" )."{$gdate}</option>";
				}
				else
				{
								while ( $row = mysql_fetch_array( $result ) )
								{
												if ( $gdate == $row['gdate'] )
												{
																echo "<option value='".$row['gdate']."' selected>".$row['m_date']."</option>";
												}
												else
												{
																echo "<option value='".$row['gdate']."'>".$row['m_date']."</option>";
												}
								}
				}
			echo "</select> -- 管理模式:WEB页面 ";
			if($gtype=='FT'){
				$rshtml  = $r_show=='all' ? " -- [ 全部 " : " -- [ <a href='?uid=$uid&gtype=$gtype&gdate=$gdate&r_show=all'>全部</a> ";
				$rshtml .= $r_show=='hr' ? "/ 上半 " : "/ <a href='?uid=$uid&gtype=$gtype&gdate=$gdate&r_show=hr'>上半</a> ";
				$rshtml .= $r_show=='r' ? "/ 全场 ]" : "/ <a href='?uid=$uid&gtype=$gtype&gdate=$gdate&r_show=r'>全场</a> ]";
				echo $rshtml;
			}
			echo " -- <a href=\"javascript:history.go( -1 );\">回上一頁</a></td>\r\n      <td width=\"34\"><img src=\"/images/control/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n    </tr>\r\n  </table>\r\n  <table width=\"774\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n    <tr>\r\n      <td width=\"774\" height=\"4\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td ></td>\r\n    </tr>\r\n  </table>\r\n  <table id=\"glist_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"006255\" class=\"m_tab\" width=\"800\">\r\n\t\t";
				if ( $gtype != "FS" )
				{
								$r_show_sql = '';
								if($r_show=='r'){
									$r_show_sql = " and is_hr<>1";
								}elseif($r_show=='hr'){
									$r_show_sql = " and is_hr=1";
								}
								switch ( $gtype )
								{
								case "FT" :
												$sql = "select status,lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6)) as gdate,M_Date,MB_Team,TG_Team,M_League,M_Time,MID,if(mid%2<>0,mb_inball_hr,mb_inball) as MB_Inball,if(mid%2<>0,tg_inball_hr,tg_inball) as TG_Inball,MB_Inball_HR,TG_Inball_HR,MB_MID,TG_MID from foot_match where m_date='".$gdate."' $r_show_sql and ((is_hr=1 and MB_Inball_hr<>'') or (is_hr<>1 and MB_Inball<>'')) order by m_start,tg_mid,mid";
												break;
								case "OP" :
												$sql = "select status,lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6)) as gdate,M_Date,MB_Team,TG_Team,M_League,M_Time,MID,if(mid%2=0,mb_inball_hr,mb_inball) as MB_Inball,if(mid%2=0,tg_inball_hr,tg_inball) as TG_Inball,MB_Inball_HR,TG_Inball_HR from other_play where m_date='".$gdate."' and mb_inball<>'' order by m_start,tg_mid,mid";
												break;
								case "TN" :
												$sql = "select mid,status,lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6)) as gdate,M_Date,MB_Team,TG_Team,M_League,M_Time,MID, MB_Inball, TG_Inball,MB_Inball_HR,TG_Inball_HR from tennis where m_date='".$gdate."' and mb_inball<>'' order by m_start,tg_mid,mid";
												break;
								case "BS" :
												$sql = "select status,lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6)) as gdate,M_Date,MB_Team,TG_Team,M_League,M_Time,MID,if(mid%2=0,mb_inball_hr,mb_inball) as MB_Inball,if(mid%2=0,tg_inball_hr,tg_inball) as TG_Inball,MB_Inball_HR,TG_Inball_HR from baseball where m_date='".$gdate."' and mb_inball<>'' order by m_start,tg_mid,mid";
												break;
								case "VB" :
												$sql = "select status,lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6)) as gdate,M_Date,MB_Team,TG_Team,M_League,M_Time,MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from volleyball where m_date='".$gdate."' and mb_inball<>'' order by m_start,tg_mid,mid";
												break;
								case "BK" :
												$sql = "select status,mid,TG_MID,MB_MID,status,lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6)) as gdate,M_Date,MB_Team,TG_Team,M_League,M_Time,MID,MB_Inball,TG_Inball from bask_match where m_date='".$gdate."' and mb_inball<>'' order by m_start,mb_team,mb_mid asc";
								}
								$result = mysql_db_query( $dbname, $sql );
								echo "\t\t<tr class=\"m_title_ft\">\r\n      <td width=\"150\">";
								echo $gdate;
								echo "</td>\r\n      <td width=\"50\">KO时间</td>\r\n      <td width=\"200\">主场队伍</td>\r\n      <td width=\"100\">比分</td>\r\n      <td width=\"200\">客场队伍</td>\r\n      <td width=\"100\">比分</td>\r\n    </tr>\r\n    ";
								while ( $row = mysql_fetch_array( $result ) )
								{
												echo "    <tr class=\"m_cen\">\r\n      <td>";
												echo $row['M_League'];//."<BR>".$row['MID'];
												echo "</td>\r\n      <td>";
												echo $row['gdate'];
												echo "</td>\r\n      <td align=\"right\">";
												echo $row['MB_Team'];
												echo "</td>\r\n      <td>\r\n      \t<a href=\"ctl_list.php?uid=";
												echo $uid;
												echo "&gid=";
												echo $row['MID'];
												echo "&gtype=";
												echo $gtype;
												echo "\">\r\n\t\t\t\t";
												if ( 0 < $row['status'] and ($row['MB_Inball']=="-1" and $row['TG_Inball']=="-1" ) )
												{
																echo "<font color=\"red\"><b>".$match_status[$row['status']]."</b></font>";
												}
												else
												{
																echo "<font color=\"red\"><b>".$row['MB_Inball']."</b> - <b>".$row['TG_Inball']."</b></font>";
												}
												echo "\t\t\t\t</a>\r\n\t\t\t</td>\r\n      <td align=\"left\">";
												echo $row['TG_Team'];
												echo "</td>\r\n      <td><a href=\"ctl_score.php?uid=";
												echo $uid;
												echo "&gid=";
												echo $row['MID'];
												echo "&gtype=";
												echo $gtype;
												echo "&active=2&r_show=$r_show\">更改</a></td>\r\n    </tr>\r\n    ";
								}
				}
				else
				{
								echo "\t\t<tr class=\"m_title_ft\">\r\n      <td width=\"150\">";
								echo $gdate;
								echo "</td>\r\n      <td width=\"50\">KO时间</td>\r\n      <td width=\"200\">比赛队伍</td>\r\n      <td width=\"200\">胜出队伍</td>\r\n      <td width=\"100\">功能</td>\r\n    </tr>\r\n    ";
								$sql = "select gtype,mid,mstart,mshow,concat(sleague,'<br>',league) as league,team,DATE_FORMAT(mstart,'%m-%d<br>%h:%i%p') as gdate,DATE_FORMAT(mstart,'%Y-%m-%d') as m_date from sp_match where DATE_FORMAT(mstart,'%m-%d')='".$gdate."' and QQ526738=1 group by mid order by m_date";
								$result = mysql_db_query( $dbname, $sql );
								while ( $row = mysql_fetch_array( $result ) )
								{
												$sql = "select * from sp_match where mid='".$row['mid']."' order by mid";
												$winteam = "";
												echo "  \t<tr class=\"m_cen\" >\r\n       <td >";
												echo $row['gdate'];
												echo "</td>\r\n       <td >";
												echo $row['league'];
												echo "</td>\r\n       <td align=\"center\"  >\r\n       \t";
												$res_lea = mysql_db_query( $dbname, $sql );
												$idd = "";
												while ( $row_lea = mysql_fetch_array( $res_lea ) )
												{
																if ( $idd == "" )
																{
																				$idd = $row_lea['id'];
																}
																else
																{
																				$idd = $idd."|".$row_lea['id'];
																}
																if ( $row_lea['win'] == 1 )
																{
																				$winteam = $row_lea['team'];
																}
																echo "<a href='ctl_fs.php?uid=".$uid."&gid=".$row_lea['id']."'>".$row_lea['team']."</a><BR>";
												}
												echo "      </td>\r\n      <td align=\"center\"><font color=red>";
												$sql = "select team from sp_match where mid='".$row['mid']."' and win=1 order by mid";
												$res_lea1 = mysql_db_query( $dbname, $sql );
												while ( $row_lea1 = mysql_fetch_array( $res_lea1 ) )
												{
																echo $row_lea1['team']."<br>";
												}
												echo "\r\n</font></td>\r\n      <td></td>\r\n    </tr>\r\n    ";
								}
				}
				echo "  </table>\r\n</form>\r\n&nbsp;<BR><BR><BR><BR></body>\r\n</html>";
?>
