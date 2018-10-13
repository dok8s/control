<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
?>
<html style="width: 98%;margin: 0 auto;">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<script>if(self == top) top.location='/'</script>
<?
require ("../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$type	=	$_REQUEST["type"];
$dates	=	$_REQUEST["dates"];
if($type=='RP'){
	$sql="ANALYZE TABLE `baseball`,`bask_match`,`foot_match`,`message`,`sp_match`,`sys800`,`tennis`,`volleyball`,`web_agents`,`web_corprator`,`web_db_io`,`web_marquee`,`web_mem_log`,`web_member`,`web_super`,`web_system`,`web_sytnet`,`web_world`,`agents_log`;";
	mysql_query($sql);
	
	$sql="CHECK TABLE `baseball`,`bask_match`,`foot_match`,`other_play`,`message`,`sp_match`,`sys800`,`tennis`,`volleyball`,`web_agents`,`web_corprator`,`web_db_io`,`web_marquee`,`web_mem_log`,`web_member`,`web_super`,`web_system`,`web_sytnet`,`web_world`,`agents_log`;";
	mysql_query($sql);
	$sql="REPAIR TABLE `baseball`,`bask_match`,`foot_match`,`other_play`,`message`,`sp_match`,`sys800`,`tennis`,`volleyball`,`web_agents`,`web_corprator`,`web_db_io`,`web_marquee`,`web_mem_log`,`web_member`,`web_super`,`web_system`,`web_sytnet`,`web_world`,`agents_log`;";
	mysql_query($sql);
	$sql="FLUSH TABLE `baseball`;
FLUSH TABLE `bask_match`;
FLUSH TABLE `foot_match`;
FLUSH TABLE `message`;
FLUSH TABLE `sp_match`;
FLUSH TABLE `other_play`;
FLUSH TABLE `sys800`;
FLUSH TABLE `tennis`;
FLUSH TABLE `volleyball`;
FLUSH TABLE `web_agents`;
FLUSH TABLE `web_corprator`;
FLUSH TABLE `web_db_io`;
FLUSH TABLE `web_marquee`;
FLUSH TABLE `web_mem_log`;
FLUSH TABLE `web_member`;
FLUSH TABLE `web_super`;
FLUSH TABLE `web_system`;
FLUSH TABLE `web_sytnet`;
FLUSH TABLE `web_world`;
FLUSH TABLE `agents_log`;";

	mysql_query($sql);
	$sql="OPTIMIZE TABLE `baseball`,`bask_match`,`foot_match`,`message`,`sp_match`,`sys800`,`tennis`,`volleyball`,`web_agents`,`web_corprator`,`web_db_io`,`web_marquee`,`web_mem_log`,`web_member`,`web_super`,`web_system`,`web_sytnet`,`web_world`,`agents_log`;";
	mysql_query($sql);
	
	echo "<script>alert('数据表修复完成!')</script>";
}
elseif($type=='truncate_800'){
	mysql_query("truncate sys800");
	echo "<script>alert('所有存款、提款记录已被清除!')</script>";
}
elseif($type=='DB'){
	if ( $dates < date("Y-m-d", time()-1296000) ){
		$sql = "delete from web_db_io where m_date<'".$dates."'";
		mysql_query( $sql );
		echo "<script>alert('".$dates."之前的投注纪录已经清除！')</script>";
	}else{
		echo "<script>alert('投注纪录清除失败！')</script>";
	}
}
elseif($type<>'' and $dates<>''){
	if(date('Y-m-d')<$dates){
		echo 'delete faile';
		exit;
	}

	switch($type){
		case 'FT':
			$sql="delete from foot_match where m_start<='$dates'";
			mysql_query($sql);
			$sql="delete from bask_match where m_start<='$dates'";
			mysql_query($sql);
			$sql="delete from tennis where m_start<='$dates'";
			mysql_query($sql);
			$sql="delete from volleyball where m_start<='$dates'";
			mysql_query($sql);
			$sql="delete from baseball where m_start<='$dates'";
			mysql_query($sql);
			$sql="delete from other_play where m_start<='$dates'";
			mysql_query($sql);
			$sql="delete from sp_match where mstart<'$dates' and QQ526738=1";
			mysql_query($sql);
			echo "<script>alert('$dates 之前的赛程纪录已被清除！')</script>";
			break;
		
		case 'aglog':
			$sql="delete from web_mem_log where logtime<='$dates'";
			mysql_query($sql);
			echo "<script>alert('$dates 之前的代理日志已被清除！')</script>";
			break;
		case 'agentslog':
			$sql="delete from agents_log where M_DateTime<='$dates 23:59:59'";
			mysql_query($sql);
			echo "<script>alert('$dates 之前的代理日志已被清除！')</script>";
			break;
	}
}
?>
<style type="text/css">
<!--
.m_ag_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<table width="775" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="m_tline">&nbsp;&nbsp; 系统管理 -- 数据清理&nbsp;&nbsp;&nbsp; </td>
		<td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
    <td colspan="6" height="4"></td>
  </tr>
</table>
<br>
<table width="770" border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
    <tr class="m_bc_ed"><td colspan="6" align="center" bgcolor="6EC13E"><b>数据清理</b></td></tr>
    <TR class=m_title_edit>
      <td>数据项</td>
      <td>日期范围</td>
      <td>功能</td>
    </tr>
    <form name=FTR action="" method=post>
    <tr class=m_cen>
      <td width="80" align=right class=m_ag_ed>赛程</td>
      <td>删除日期:
        <select class=za_select name=dates>
				<?
				$dd = 24*60*60;
				$t = time();
				for($i=1;$i<=8;$i++)
				{
					$today=date('Y-m-d',$t-$i*$dd);
					if (date('Y-m-d')==date('Y-m-d',$t)){
						echo "<option value='$today' selected>".$today."</option>";
					}else{
						echo "<option value='$today'>".$today."</option>";
					}
				}
				?>
			</select>日0时之前的赛程纪录</td>
      <td width="50"><input class=za_button  type=submit value="删除" name=ft_ch_ok33></td>
      <input type=hidden value="FT" name=type>
    </TR>
    </form>
    
	
    <form name=FTR action="" method=post><TR class=m_cen>
      <td align=right class=m_ag_ed>投注纪录</td>
      <td>删除日期:
        <select class=za_select name=dates>
				<option value=""></option>
				<?
					$dd = 24*60*60;
					$t = time();
					for($i=0;$i<=42;$i++)
					{
						$today=date('Y-m-d',$t-$i*$dd);
						if (date('Y-m-d')==date('Y-m-d',$t)){
							echo "<option value='$today' selected>".$today."</option>";
						}else{
							echo "<option value='$today'>".$today."</option>";
						}
					}
					?>
			</select>日0时之前的投注纪录</td>
      <td><input class=za_button type=submit value="删除" name=ft_ch_ok334></td>
    <input type=hidden value="DB" name=type></TR></form>
  </form>

    <form name=FTR action="" method=post><TR class=m_cen>
      <td align=right class=m_ag_ed>代理日志</td>
      <td>删除日期:
        <select class=za_select name=dates>
				<option value=""></option>
				<?
					$dd = 24*60*60;
					$t = time();
					for($i=0;$i<=3;$i++)
					{
						$today=date('Y-m-d',$t-$i*$dd);
						if (date('Y-m-d')==date('Y-m-d',$t)){
							echo "<option value='$today' selected>".$today."</option>";
						}else{
							echo "<option value='$today'>".$today."</option>";
						}
					}
					?>
			</select>日0时之前的代理日志纪录</td>
      <td><input class=za_button type=submit value="删除" name=ft_ch_ok334></td>
    <input type=hidden value="aglog" name=type></TR></form>
  </form>
  
  <form name=FTR action="" method=post><TR class=m_cen>
      <td align=right class=m_ag_ed>事务日志</td>
      <td>删除日期:
        <select class=za_select name=dates>
				<option value=""></option>
				<?
					$dd = 24*60*60;
					$t = time();
					for($i=0;$i<=30;$i++)
					{
						$today=date('Y-m-d',$t-$i*$dd);
						if (date('Y-m-d')==date('Y-m-d',$t)){
							echo "<option value='$today' selected>".$today."</option>";
						}else{
							echo "<option value='$today'>".$today."</option>";
						}
					}
					?>
			</select>日0时之前的代理日志纪录</td>
      <td><input class=za_button type=submit value="删除" name=ft_ch_ok334></td>
    <input type=hidden value="agentslog" name=type></TR></form>
  </form>

    <form name=FTR action="" method=post><TR class=m_cen>
      <td align=right class=m_ag_ed>现金日志</td>
      <td>删除所有存款、提款记录</td>
      <td><input class=za_button type=submit value="删除" name=ft_ch_ok334></td>
    <input type=hidden value="truncate_800" name=type></TR></form>
  </form>

</table>

<br>
<table width="770" border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
  <form name=FTR action="" method=post>
    <tr class="m_bc_ed"><td colspan="6" align="center" bgcolor="6EC13E"><b>数据表修复</b></td></tr>
    <form name=FTR action="" method=post>
    <TR class=m_cen>
      <td width="80" align=right class=m_ag_ed>数据项</td>
      <td>        修复范围:
        <select class=za_select name=tables>
				<option value="">全部</option>
			</select>数据表</td>
      <td width="50"><input class=za_button  type=submit value="修复" name=ft_ch_ok33></td>
      <input type=hidden value="RP" name=type>
    </TR>
    </form>
</table>
</head>
</html>