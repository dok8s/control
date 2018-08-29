<?php
require( "../../member/include/config.inc.php" );
$date_start = $_REQUEST['date_start'];
$agents_id = $_REQUEST['agents_id'];
$uid = $_REQUEST['uid'];
$level = $_REQUEST['level'];
$user = $_REQUEST['agents_id'];
$active = $_REQUEST['active'];
$logip = $_REQUEST['ip'];
$sql = "select id from web_sytnet where uid='".$uid."' and status=1";
$result = mysql_query( $sql );
$row = mysql_fetch_array( $result );
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
	//echo "<script>window.open('".$site."/index.php','_top')</script>";
	//exit( );
}

$sql = "select setdata from web_system limit 0,1";
$result = mysql_query( $sql );
$rt = mysql_fetch_array( $result );
$setdata = @unserialize($rt['setdata']);
$update_sec = intval($setdata['showlog_update_sec']);
if($update_sec<3) $update_sec=60;
$sound_sec = intval($setdata['showlog_sound_sec']);
$sound_time = time()-$sound_sec;
$is_sound = 0;

if(isset($_GET['update_sec'])){
	$showlog_update_sec = intval($_GET['update_sec']);
	if($showlog_update_sec>=3){
		$setdata['showlog_update_sec']=$showlog_update_sec;
		$mysql = "update web_system set setdata='".serialize($setdata)."'";
		mysql_query( $mysql );
	}
	echo "<script language='javascript'>self.location='?uid=".$uid."&level={$level}&agents_id=$agents_id';</script>";
	exit;
}
if(isset($_GET['sound_sec'])){
	$showlog_sound_sec = intval($_GET['sound_sec']);
	if($showlog_sound_sec>=3){
		$setdata['showlog_sound_sec']=$showlog_sound_sec;
		$mysql = "update web_system set setdata='".serialize($setdata)."'";
		mysql_query( $mysql );
	}
	echo "<script language='javascript'>self.location='?uid=".$uid."&level={$level}&agents_id=$agents_id';</script>";
	exit;
}

if ( $date_start == "" )
{
				$date_start = date( "m-d" );
}
$sqladd = "";
switch ( $level )
{
case -2 :
				$level0 = 0;
				$level1 = 0;
				$level3 = 0;
				$level2 = 0;
				break;
case 0 :
				$level0 = 1;
				$level1 = 0;
				$level3 = 0;
				$level2 = 0;
				$sp = $user;
				break;
case 1 :
				$level0 = 1;
				$level1 = 1;
				$level3 = 0;
				$level2 = 0;
				$co = $user;
				$sql = "select super from web_corprator where agname='".$user."'";
				$result = mysql_query( $sql );
				$row = mysql_fetch_array( $result );
				$sp = $row['super'];
				break;
case 2 :
				$level0 = 1;
				$level1 = 1;
				$level2 = 1;
				$level3 = 0;
				$wd = $user;
				$sql = "select super,corprator from web_world where agname='".$user."'";
				$result = mysql_query( $sql );
				$row = mysql_fetch_array( $result );
				$co = $row['corprator'];
				$sp = $row['super'];
				break;
case 3 :
				$level0 = 1;
				$level1 = 1;
				$level2 = 1;
				$level3 = 1;
				$sql = "select super,world,corprator from web_agents where agname='".$user."'";
				$result = mysql_query( $sql );
				$row = mysql_fetch_array( $result );
				$wd = $row['world'];
				$co = $row['corprator'];
				$sp = $row['super'];
				if($logip!='')$sqladd .= " and logip='$logip' ";
				break;
case 4 :
				$level0 = 1;
				$level1 = 1;
				$level2 = 1;
				$level3 = 1;
				$level4 = 1;
				$sql = "select super,corprator,world,agents,memname,logdate,logip from web_member where id='".$user."'";
				$result = mysql_query( $sql );
				$row = mysql_fetch_array( $result );
				$memname = $row['memname'];
				$logdate = $row['logdate'];
				$logip = $row['logip'];
				$user = $row['agents'];
				$wd = $row['world'];
				$co = $row['corprator'];
				$sp = $row['super'];
				$sqladd .= " and logip='$logip' ";
				break;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
</head><!---->
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
以下日志包含（总后台管理员/登0/登1/2/3）的混合在一起，请注意区别！
 <table width="773" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="m_tline" width="746">&nbsp;线上数据－<font color="#CC0000">日志</font><font color="#CC0000">&nbsp;</font>&nbsp;&nbsp;&nbsp;
		
	  <input name="buttonF5" id="F5" value="更新" type="button" onClick="reload()" class='za_button'>&nbsp;&nbsp;
	  设置为<input type="text" id='update_sec' name="update_sec" value='<?=$update_sec?>' size='3'>秒自动更新&nbsp;
	  <input name="buttonF5" value="保存" type="button" onClick="update_sec_save()"  class='za_button'>&nbsp;&nbsp;

        <span id="timeinfo"></span>-- 上线提醒时间：<input type="text" id='sound_sec' name="sound_sec" value='<?=$sound_sec?>' size='3'>秒&nbsp;
	  <input name="buttonF6" value="保存" type="button" onClick="sound_sec_save()"  class='za_button'> -- <a href="javascript:history.go( -1 );">回上一页</a></td>

      <td width="34"><img src="/images/control/top_04.gif" width="30" height="24"></td>
    </tr>
  </table>
  <table width="774" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="774" height="4"></td>
    </tr>
    <tr>
      <td ></td>
    </tr>
  </table>
<?

	echo "<table id=\"glist_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"006255\" class=\"m_tab\" width=\"860\">
		<tr class='m_title_ft'><td align='middle' width='84'>用户</td><td width='126'>最后活动时间</td><td width='390'>操作</td><td width='173'>登陆IP</td><td width='173'>操作者</td></tr>\r\n  ";

				$sql = "select username,logtime,context,logip,level from web_mem_log where username!='' order by logtime desc limit 0,1000";//and LEFT(username,6)!='system' 
				$result = mysql_query( $sql );
				$count = mysql_num_rows( $result );
				while ( $row = mysql_fetch_array( $result ) )
				{
					$class='';
					if(strtotime($row['logtime'])>$sound_time){
						$class='class=m_cen_red';
						$is_sound=1;
					}
					$ck=$row['level'];
					echo "  <tr class=\"m_cen\">\r\n    <td width=\"84\" $class>";
					echo $row['username'];
					echo "</td>\r\n    <td width=\"156\"><font color=\"#CC0000\">";
					echo $row['logtime'];
					echo "</font></td>\r\n    <td align=right width=\"450\">";
					echo $row['context'];
					echo "</td>\r\n\t<td align=right width=\"113\">";
					echo "<a href='http://ip138.com/ips138.asp?action=2&ip=$row[logip]' target=_blank>$row[logip]</a>";
					echo "</td>\r\n     <td width=\"86\"><font color=\"#CC0000\">";

                   if ($ck<-1)
					{
						echo "<font color=red>管理员</font>";
					}else
					{
					echo "登<font color=red>$row[level]</font>";
					}

					echo "</td>\r\n  </tr>\r\n  ";
				}
				echo "</table>\r\n<br>\r\n";
?>

</body>
</html>