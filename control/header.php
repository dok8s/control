<?php
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require( "../member/include/config.inc.php" );
$uid = $_REQUEST['uid'];
$langx = "zh-cn";
$sql = "select id,level,agname from web_sytnet where uid='".$uid."' and status=1";
$result = mysql_query( $sql );
$row = mysql_fetch_array( $result );
$admin_name = $row['agname'];
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
	echo "<script>window.open('".$site."/index.php','_top')</script>";
	exit;
}
?>
<html>
<head>
<title>皇冠线上管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_header.css" type="text/css">
<script src="/js/lock.js" type="text/javascript"></script>
<script src="/js/wmenu.js" type="text/javascript"></script>

<script language="JavaScript" src="/js/ctl_header.js"></script>
</head>
<script type="text/javascript">

document.onmousedown = initDown;
document.onmouseup   = initUp;
document.onmousemove = initMove;
function initDown() {
	doDown();
	moveme_onmousedown();
}
function initUp() {
	doUp();
	moveme_onmouseup();
}
function initMove() {
	moveme_onmousemove();
}

function show_webs(sw) {
	ad_list.style.display='none';
	mo_list.style.display='none';
	op_list.style.display='none';
	ot_list.style.display='none';
	bk_list.style.display='none';
	rl_list.style.display='none';

	switch(sw){
		case'ad':ad_list.style.display='block';break;
		case'mo':mo_list.style.display='block';break;
		case'op':op_list.style.display='block';break;
		case'ot':ot_list.style.display='block';break;
		case'bk':bk_list.style.display='block';break;
		case'rl':rl_list.style.display='block';break;

	}
}
function go_web(sw1,sw2,sw3) {
	//alert(sw3);
	if(sw1==2){
		Go_Chg_pass(1);
	}else if(sw1==5){
		Go_real(1);
	}	else{
		//window.open(sw3,'main');
		parent.main.location.href=sw3;
	}
}
function Go_real(a){
  var uid="<?=$uid?>";
  Real_Win=window.open("/control/real_lock/index.php"+"?uid=<?=$uid?>","_blank");
}
function Go_Chg_pass(a){
 var uid="<?=$uid?>";
  Real_Win=window.open("chg_passwd.php"+"?uid=<?=$uid?>&flag="+a,"main","width=255,height=135,status=no");
}
</script>
<base target="net_ctl_main"><!-- oncontextmenu="window.event.returnValue=false"-->
<body onLoad="show_webs();"  bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="D8B20C" alink="D8B20C">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="183"><img src="/images/control/zh-tw/top_01.gif" width="183" height="31"></td>
    <td bgcolor="#9dafc3"   class="sline"><font color="#ffffff">Administrator管理系统</font>&nbsp;<font color=yellow>[<?=$row['agname']?>]</font><font color=red>session：<?=$_SESSION["ckck"];?><font></td>
  </tr>
  <tr height="19">
    <td><img src="/images/control/zh-tw/top_02.gif" width="183" height="20"></td>
    <td bgcolor="2F4540">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
         	<table border='0' CELLPADDING=0 CELLSPACING=0 class="coolBar" style="position: relative; z-index: 99; top: 0px; left: 0px;" id="toolbar1" width="100%">
			<tr>
			  <td class="coolButton" onClick="show_webs('op');" nowrap>&nbsp;<nobr>[线上操盘]</nobr>&nbsp;</td>
              <td id=op_list style="color: blue;">
			   <nobr>
               <a onClick="go_web(1,0,'/control/ctl/ctl.php?uid=<?=$uid?>')" style="cursor:hand"><img src="/images/control/tri.gif">赛程</a>
			   <a onClick="go_web(1,0,'/control/ctl/ctl_result.php?uid=<?=$uid?>')" style="cursor:hand"><img src="/images/control/tri.gif">比分</a>
			   </nobr>
			 </td>
             <td class="coolButton" onClick="show_webs('ad');" nowrap>&nbsp;<nobr>[即时注单]</nobr>&nbsp;</td>
             <td id=ad_list style="color: blue;">
			   <nobr>
				<a onClick="go_web(1,0,'/control/real_wager/index.php?uid=<?=$uid?>');" style='cursor:hand'><img src='/images/control/tri.gif'>足球</a>
				<a onClick="go_web(1,1,'/control/real_wager_BK/index.php?uid=<?=$uid?>');" style='cursor:hand'><img src='/images/control/tri.gif'>篮球</a>
				<a onClick="go_web(1,1,'/control/real_wager_TN/index.php?uid=<?=$uid?>');" style='cursor:hand'><img src='/images/control/tri.gif'>网球</a>
				<a onClick="go_web(1,1,'/control/real_wager_VB/index.php?uid=<?=$uid?>');" style='cursor:hand'><img src='/images/control/tri.gif'>排球</a>
				<a onClick="go_web(1,1,'/control/real_wager_BS/index.php?uid=<?=$uid?>');" style='cursor:hand'><img src='/images/control/tri.gif'>棒球</a>
				<a onClick="go_web(1,1,'/control/real_wager_NFS/loadgame_R.php?uid=<?=$uid?>');" style='cursor:hand'><img src='/images/control/tri.gif'>冠军</a>
			  </nobr>
			</td>
			<td class="coolButton" onClick="show_webs('mo');" nowrap>&nbsp;<nobr>[帐号管理]</nobr>&nbsp;</td>
		    <td id=mo_list style="color: blue;">
			  <nobr>
				<a onClick="go_web(1,3,'/control/super/super.php?uid=<?=$uid?>');" style='cursor:hand;'> <img src='/images/control/tri.gif'>大股东</a>
				<a onClick="go_web(1,4,'/control/corprator/super_corprator.php?uid=<?=$uid?>');" style='cursor:hand;'> <img src='/images/control/tri.gif'>股东</a>
				<a onClick="go_web(1,5,'/control/super_agent/body_super_agents.php?uid=<?=$uid?>');" style='cursor:hand;'> <img src='/images/control/tri.gif'>总代理</a>
				<a onClick="go_web(1,6,'/control/agents/su_agents.php?uid=<?=$uid?>');" style='cursor:hand;'> <img src='/images/control/tri.gif'>代理</a>
				<a onClick="go_web(1,7,'/control/members/ag_members.php?uid=<?=$uid?>');" style='cursor:hand;'> <img src='/images/control/tri.gif'>会员</a>
				<a onClick="go_web(1,8,'/control/members/ag_members1.php?uid=<?=$uid?>');" style='cursor:hand;'> <img src='/images/control/tri.gif'>异常会员</a>
				<?
				if ( $row['level'] == 1 )
				{
				
					echo "<a onclick=\"go_web(1,8,'/control/system/set_user_ip.php?uid=$uid');\" style='cursor:hand'><img src='/images/control/tri.gif'>会员绑IP</a>";
				}
				if ( $row['level'] == 1 )
				{
					echo "\t\t\t\t\t\t<a onclick=\"go_web(1,3,'/control/super/subuser.php?uid=";
					echo $uid;
					echo "');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">管理帐号</a>\r\n\t\t\t\t\t\t<a onclick=\"go_web(1,3,'/control/wager/wager_add.php?uid=";
					echo $uid;
					echo "');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">添单账号</a>\r\n\t\t\t\t\t\t<a onclick=\"go_web(1,3,'/control/wager/wager_hide.php?uid=";
					echo $uid;
					echo "');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">隐单账号</a>\r\n\t\t\t\t\t\t";
				}
				
				?>
				<a onClick="go_web(2,5,'');" style="cursor:hand"><img src="/images/control/tri.gif">变更密码</a>
			  </nobr>
			</td>
			
			<td id=bk_list style="color: blue;">
			  <nobr>
				  <a onClick="go_web(1,3,'/control/data/tick.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">抛码账号</a>
				  <a onClick="go_web(1,3,'/control/data/tick_gold.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">盈亏统计</a>
				  <a onClick="go_web(1,3,'/control/data/tick_list.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">抛码跟踪</a>
			 </nobr>
		   </td>
           <td class="coolButton" onClick="show_webs('rl');" nowrap>&nbsp;<nobr>[注单管理]</nobr>&nbsp;</td>
           <td id=rl_list style="color: blue;"><nobr>
				<a onClick="go_web(1,0,'/control/reallist/voucher.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">流水注单</a>
				<a onClick="go_web(1,0,'/control/reallist/gaidan.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">改单注单</a>
				<a onClick="go_web(1,0,'/control/reallist/aceept.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">异常注单</a>
				<a onClick="go_web(1,0,'/control/reallist/danger_list.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">走地危险球</a>
				<a onClick="go_web(1,0,'/control/reallist/real_list.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">注单查询</a>
				<?
				if ( $row['level'] == 1 )
				{
					echo "<a onclick=\"go_web(1,0,'/control/wager_add/main.php?uid=$uid');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">手工添单</a>
				\t\t\t\t\t\t";
					echo "<a onclick=\"go_web(1,0,'/control/wager_add1/main.php?uid=$uid');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">过关添单</a>
				\t\t\t\t\t\t";
				}
				?>
			  </nobr>
			</td>
            <td class="coolButton" onClick="show_webs('ot');" nowrap>&nbsp;<nobr>[系统管理]</nobr>&nbsp;</td>
            <td id=ot_list style="color: blue;">
			  <nobr>
				<?
				if ( $row['level'] == 1 )
				{
								echo "<a onclick=\"go_web(1,0,'/control/system/system.php?uid=";
								echo $uid;
								echo "');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">参数</a>
				                <a onclick=\"go_web(1,0,'/control/data/deldata.php?uid=";
								echo $uid;
								echo "');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">清理数据</a>\t\t\t\t\t\t";
				}
				?>
 				<a onClick="go_web(1,1,'/control/system/notice.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">即时公告</a>
				<a onClick="go_web(1,0,'/control/system/notice.php?uid=<?=$uid?>&scroll_set=set');" style="cursor:hand"><img src="/images/control/tri.gif">股东历史讯息</a>
                <a onClick="go_web(1,0,'/control/system/showlog.php?level=-2&uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">超管日志</a>
				<a onClick="go_web(1,0,'/control/system/syslog.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">代理在线</a>
				<a onClick="go_web(1,0,'/control/system/memlog.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">会员在线</a>
			  </nobr>
			</td>
			<td nowrap><a href="/control/report/report.php?uid=<?=$uid?>" style="cursor:hand;color:#bb0000" target="main" onMouseOver="window.status='报表'; return true;" onMouseOut="window.status='';return true;">&nbsp;[报表]&nbsp;</a></td>
			<td nowrap><a href="800/index.php?uid=<?=$uid?>" style="cursor:hand;color:#bb0000"  target="main" onMouseOver="window.status='现金系統'; return true;" onMouseOut="window.status='';return true;">&nbsp;[现金系統]</a></td>
			<td nowrap><a href="admin/payment.php?uid=<?=$uid?>" style="cursor:hand;color:#bb0000"  target="main" onMouseOver="window.status='支付方式'; return true;" onMouseOut="window.status='';return true;">&nbsp;[支付方式]</a></td>
			<?
			if ( $row['level'] == 1 )
			{
				echo "<td nowrap><a href=\"chat/chat.php?uid=$uid\" target=\"main\" style=\"cursor:hand;color:#bb0000\" onMouseOver=\"window.status='会话'; return true;\" onMouseOut=\"window.status='';return true;\">&nbsp;[会话]&nbsp;</a></td>
			\t\t\t\t\t\t";
			}
			?>
			<td nowrap><a href="body_home.php?uid=<?=$uid?>&langx=zh-cn" style="cursor:hand;color:#bb0000"  target="main" onMouseOver="window.status='支付方式'; return true;" onMouseOut="window.status='';return true;">&nbsp;[公告]</a></td>
			<td nowrap><a href="/index.php" target="_top" style="cursor:hand;color:#bb0000" onMouseOver="window.status='登出'; return true;" onMouseOut="window.status='';return true;">&nbsp;[登出]&nbsp;</a></td>
			<td width='100%'></td>
			</tr>
			</table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
