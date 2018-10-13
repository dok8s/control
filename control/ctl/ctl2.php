<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");

$gdate			=	$_REQUEST['gdate'];
$uid				=	$_REQUEST['uid'];
$gtype			=	$_REQUEST['gtype'];
$action			=	$_REQUEST['action']+0;
$gid				=	$_REQUEST['gid']+0;
$act				=	$_REQUEST['act'];
$zhd			=	$_REQUEST['zhd'];
if ($gtype==''){$gtype='FT';}

$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

if ($gdate==''){$gdate=date('m-d');}

if ($action==2){
	$mtype	=	$_REQUEST['mtype']+0;
	switch($gtype){
	case 'FT':
		$sql="update foot_match set fopen=$mtype where mid=$gid";
		break;
	case 'BK':
		$sql="update bask_match set fopen=$mtype where mid=$gid";
		break;
	case 'TN':
		$sql="update tennis set fopen=$mtype where mid=$gid";
		break;
	case 'VB':
		$sql="update volleyball set fopen=$mtype where mid=$gid";
		break;
	case 'OP':
		$sql="update other_play set fopen=$mtype where mid=$gid";
		break;
	case 'BS':
		$sql="update baseball set fopen=$mtype where mid=$gid";
		break;
		}
	mysql_query($sql) or die ("error");
	echo "<script languag='JavaScript'>self.location='ctl.php?uid=$uid&gtype=$gtype'</script>";
}else if ($action==3){
	$id=$_REQUEST['fswin'];
	$mt=date('Y-m-d H:i:s');

	$lf=$_REQUEST['LF'];

	$sql="update sp_match set QQ526738=1,win=-1 where mid=$gid";
	mysql_query($sql) or die ("error2");

	for($i=0;$i<count($lf);$i++){
		$id=$lf[$i];
		$sql="update sp_match set QQ526738=1,win=1 where id=$id";
		mysql_query($sql) or die ("error2");
	
	}
	echo "<script languag='JavaScript'>self.location='ctl.php?uid=$uid&gtype=FS'</script>";
}

if($act=='Y'){
	switch($gtype){
	case 'BK':
		$table='bask_match';
		break;
	case 'FS':
		$table='bask_match';
		break;
	case 'TN':
		$table='tennis';
		break;
	case 'VB':
		$table='volleyball';
		break;
	case 'BS':
		$table='baseball';
		break;
	case 'OP':
		$table='other_play';
		break;
	default:
		$table='foot_match';
		$gtype='FT';
		break;
	}

	$maxgold				=	$_REQUEST['maxgold'];
	$sql="update $table set maxgold='$maxgold' where mid=$gid";
	mysql_query($sql) or die ("error2");
	echo "<script languag='JavaScript'>self.location='ctl.php?uid=$uid&gtype=$gtype'</script>";
}
?>
<html style="width: 98%;margin: 0 auto;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<SCRIPT>
 function onLoad()
 {
  var gtype = document.getElementById('gtype');
  gtype.value = '<?=$gtype?>';
 }
 function Chk_acc(){
	rs_form.act.value='Y';
	close_win();
}
function gtype()
 {
  document.location='ctl.php?uid=<?=$uid?>&gtype='+document.all.gtype.value+'&gdate='+document.all.gdate.value;
 }
 function CheckSTOP(str)
 {
  if(confirm("确实要取消本场比赛吗?"))
  document.location=str;
 } function CheckCLOSE(str)
 {
  if(confirm("确实要关闭本场比赛所有投注项目吗?"))
  document.location=str;
 }

 function show_win(gid,team_h,team_c,maxgold) {
	document.all["r_title"].innerHTML = '<font color="#FFFFFF">' + team_h+'vs' + team_c+'</font>';
	rs_form.gid.value=gid;
	rs_form.maxgold.value=maxgold;
	//rs_form.gtype.value=gtype;
	rs_window.style.top=document.body.scrollTop+event.clientY+15;
	rs_window.style.left=document.body.scrollLeft+event.clientX-20;
	document.all["rs_window"].style.display = "block";
}
function close_win() {
	document.all["rs_window"].style.display = "none";
}
function Chg_Sc_Mcy(){

}
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF"  onload="onLoad()";>
  <table width="873" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="746">&nbsp;线上数据－<font color="#CC0000">点击显示<? if($zhd<>"all"){?><a href="ctl.php?uid=<?=$uid?>&gtype=<?=$gtype?>&gdate=<?=$gdate?>&zhd=all" target="_self">全部赛程数据</a><? }else{?><a href="ctl.php?uid=<?=$uid?>&gtype=<?=$gtype?>&gdate=<?=$gdate?>"  target="_self" >有注单赛程</a><? }?>&nbsp;</font>&nbsp;&nbsp;&nbsp;类别:
       <select class=za_select onChange="return gtype()"; name=gtype>
		      <option value="FT">足球</option>
		      <option value="BK">篮球</option>
		      <option value="TN">网球</option>
		      <option value="VB">排球</option>
		      <option value="BS">棒球</option>
		      <option value="OP">其他</option>
		      <option value="FS">冠軍</option>
		    </select>
        日期:
     <select class=za_select onChange="return gtype()" name=gdate>
			<?
			switch($gtype){
			case 'BK':
				$sql = "select DATE_FORMAT(m_start,'%Y-%m-%d') as m_date,DATE_FORMAT(m_start,'%m-%d') as gdate from bask_match where m_date<>'' and mb_inball='' group by m_date order by m_date";
				break;
			case 'FS':
				$sql = "select DATE_FORMAT(mstart,'%Y-%m-%d') as m_date,DATE_FORMAT(mstart,'%m-%d') as gdate from sp_match where QQ526738=0 group by m_date order by m_date";
				break;
			case 'TN':
				$sql = "select DATE_FORMAT(m_start,'%Y-%m-%d') as m_date,DATE_FORMAT(m_start,'%m-%d') as gdate from tennis where m_date<>'' and mb_inball='' group by m_date order by m_date";
				break;
			case 'VB':
				$sql = "select DATE_FORMAT(m_start,'%Y-%m-%d') as m_date,DATE_FORMAT(m_start,'%m-%d') as gdate from volleyball where m_date<>'' and mb_inball='' group by m_date order by m_date";
				break;
			case 'BS':
				$sql = "select DATE_FORMAT(m_start,'%Y-%m-%d') as m_date,DATE_FORMAT(m_start,'%m-%d') as gdate from baseball where m_date<>'' and mb_inball='' group by m_date order by m_date";
				break;
			case 'OP':
				$sql = "select DATE_FORMAT(m_start,'%Y-%m-%d') as m_date,DATE_FORMAT(m_start,'%m-%d') as gdate from other_play where m_date<>'' and mb_inball='' group by m_date order by m_date";
				break;
			default:
				$sql = "select DATE_FORMAT(m_start,'%Y-%m-%d') as m_date,DATE_FORMAT(m_start,'%m-%d') as gdate from foot_match where m_date<>'' and mb_inball='' group by m_date order by m_date";
				$gtype='FT';
				break;
			}
//echo $sql;
			$result = mysql_query($sql) or exit(mysql_error());
			$cou=mysql_num_rows($result);
			if ($cou==0){
				echo "<option value='$gdate'>$gdate</option>";
			}else{
				while ($row = mysql_fetch_array($result)){
					if ($gdate==$row['gdate']){
						echo "<option value='".$row['gdate']."' selected>".$row['m_date']."</option>";
					}else{
						echo "<option value='".$row['gdate']."'>".$row['m_date']."</option>";
					}
				}
			}
			?>
			</select>
    -- 管理模式:WEB页面 -- <a href="javascript:history.go( -1 );">回上一頁</a></td>
      <td width="34"><img src="/images/control/top_04.gif" width="30" height="24"></td>
    </tr>
  </table>
  <table width="775" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="775"></td>
    </tr>
    <tr>
      <td ></td>
    </tr>
  </table>
  <table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab" width="950">
    <tr class="m_title_ft">
    	<td width="75">时间</td>
      <td width="100">联盟</td>
      <td width="75">场次</td>
      <td width="400">队伍</td>
      <td width="300">操作</td>
    </tr>
    <?
	if($zhd<>"all"){
		switch($gtype){
		default:
			echo $sql = "select f.mid,f.maxgold,f.m_type,concat(f.m_date,'<br>',lower(substring(DATE_FORMAT(f.m_start,'%h:%i%p'),1,6))) as gdate,f.m_league,f.mb_mid,f.tg_mid,f.mb_team,f.tg_team,f.fopen from foot_match as f,web_db_io as w where f.m_date='".$gdate."' and f.MB_Inball='' and  FIND_IN_SET(f.mid,w.mid)>0 and w.hidden=0 order by m_start,f.tg_mid,f.mid";
			$gtype='FT';
			break;
		case 'OP':
			$sql = "select maxgold,m_type,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mid,m_league,mb_mid,tg_mid,mb_team,tg_team,fopen from other_play where m_date='".$gdate."' and MB_Inball='' order by m_start,tg_mid,mid";
			break;
		case 'TN':
			$sql = "select maxgold,m_type,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mid,m_league,mb_mid,tg_mid,mb_team,tg_team,fopen from tennis where m_date='".$gdate."' and MB_Inball='' order by m_start,tg_mid,mid";
			break;

		case 'VB':
			$sql = "select maxgold,m_type,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mid,m_league,mb_mid,tg_mid,mb_team,tg_team,fopen from volleyball where m_date='".$gdate."' and MB_Inball='' order by m_start,tg_mid,mid";
			break;
		case 'BS':
			$sql = "select maxgold,m_type,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mid,m_league,mb_mid,tg_mid,mb_team,tg_team,fopen from baseball where m_date='".$gdate."' and MB_Inball='' order by m_start,tg_mid,mid";
			break;
		case 'BK':
			$sql = "select mid,maxgold,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mid,m_league,mb_mid,tg_mid,mb_team,tg_team,fopen from bask_match where m_date='".$gdate."' and MB_Inball='' order by m_start,m_league,mid";
			break;
		case 'FS':
			$sql = "select maxgold,gtype,mid,mstart,mshow,concat(sleague,'<br>',league) as league,team,DATE_FORMAT(mstart,'%m-%d<br>%h:%i%p') as gdate,DATE_FORMAT(mstart,'%Y-%m-%d') as m_date from sp_match where DATE_FORMAT(mstart,'%m-%d')='$gdate' and QQ526738=0 group by mid order by m_date";
			break;
		}
	}else{
		switch($gtype){
		default:
			$sql = "select mid,maxgold,m_type,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mid,m_league,mb_mid,tg_mid,mb_team,tg_team,fopen from foot_match where m_date='".$gdate."' and MB_Inball='' order by m_start,tg_mid,mid";
			$gtype='FT';
			break;
		case 'OP':
			$sql = "select maxgold,m_type,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mid,m_league,mb_mid,tg_mid,mb_team,tg_team,fopen from other_play where m_date='".$gdate."' and MB_Inball='' order by m_start,tg_mid,mid";
			break;
		case 'TN':
			$sql = "select maxgold,m_type,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mid,m_league,mb_mid,tg_mid,mb_team,tg_team,fopen from tennis where m_date='".$gdate."' and MB_Inball='' order by m_start,tg_mid,mid";
			break;

		case 'VB':
			$sql = "select maxgold,m_type,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mid,m_league,mb_mid,tg_mid,mb_team,tg_team,fopen from volleyball where m_date='".$gdate."' and MB_Inball='' order by m_start,tg_mid,mid";
			break;
		case 'BS':
			$sql = "select maxgold,m_type,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mid,m_league,mb_mid,tg_mid,mb_team,tg_team,fopen from baseball where m_date='".$gdate."' and MB_Inball='' order by m_start,tg_mid,mid";
			break;
		case 'BK':
			$sql = "select mid,maxgold,concat(m_date,'<br>',lower(substring(DATE_FORMAT(m_start,'%h:%i%p'),1,6))) as gdate,mid,m_league,mb_mid,tg_mid,mb_team,tg_team,fopen from bask_match where m_date='".$gdate."' and MB_Inball='' order by m_start,m_league,mid";
			break;
		case 'FS':
			$sql = "select maxgold,gtype,mid,mstart,mshow,concat(sleague,'<br>',league) as league,team,DATE_FORMAT(mstart,'%m-%d<br>%h:%i%p') as gdate,DATE_FORMAT(mstart,'%Y-%m-%d') as m_date from sp_match where DATE_FORMAT(mstart,'%m-%d')='$gdate' and QQ526738=0 group by mid order by m_date";
			break;
		}
	}
		$result = mysql_query( $sql);exit;
		if ($gtype<>'FS'){
			while ($row = mysql_fetch_array($result)){
				if ($row['fopen']==0){
					$caption1="<font color=red>开启投注</font>";
					$mtype=1;
					$style='_close';
				}else{
					$caption1="关闭投注";
					$mtype=0;
					$style='';
				}
		?>
		<? 
		if($zhd<>"all"){
		/* 	$gmid=$row['mid'];
			$mysql123="select * from web_db_io where FIND_IN_SET($gmid,mid)>0 and hidden=0 ";
			$result1 = mysql_query( $mysql123);
			$cou1=mysql_num_rows($result1);
			if($cou1>0){
		*/
		?>
		<tr class="m_cen<?=$style?>">
			<td><?=$row['gdate'];?></td>
		  <td align="center"><?=$row['m_league']?><Br><?=$row['mid']?></td>
		  <td><?=$row['mb_mid']?><br><?=$row['tg_mid']?></td>
		  <td align="left"><?=$row['mb_team'];?><br><?=$row['tg_team'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=# onClick="show_win('<?=$row['mid'];?>','<?=$row['mb_team'];?>','<?=$row['tg_team'];?>','<?=$row['maxgold']?>');">单场:<font color=red>(<?=$row['maxgold']?>)</font></a></td>
		  <td align="left">&nbsp;&nbsp;
		  	 <a href="ctl_score.php?uid=<?=$uid?>&gid=<?=$row['mid']?>&gtype=<?=$gtype?>">设置比分</a>&nbsp;/&nbsp;
		    <a href=javascript:CheckCLOSE('ctl.php?uid=<?=$uid?>&gid=<?=$row[mid]?>&action=2&gtype=<?=$gtype?>&mtype=<?=$mtype?>')><?=$caption1?></a>&nbsp;/&nbsp;
		    <a href="ctl_list.php?uid=<?=$uid?>&gid=<?=$row['mid']?>&gtype=<?=$gtype?>">相关注单</a>&nbsp;

				<?
				if ($row['m_type']==1){
					echo '<font color=red>(走地)</font>';
				}
				?>
			</td>
    </tr>
	<? 
	 
		//}
	 }else{
	?>
		<tr class="m_cen<?=$style?>">
			<td><?=$row['gdate'];?></td>
		  <td align="center"><?=$row['m_league']?><Br><?=$row['mid']?></td>
		  <td><?=$row['mb_mid']?><br><?=$row['tg_mid']?></td>
		  <td align="left"><?=$row['mb_team'];?><br><?=$row['tg_team'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=# onClick="show_win('<?=$row['mid'];?>','<?=$row['mb_team'];?>','<?=$row['tg_team'];?>','<?=$row['maxgold']?>');">单场:<font color=red>(<?=$row['maxgold']?>)</font></a></td>
		  <td align="left">&nbsp;&nbsp;
		  	 <a href="ctl_score.php?uid=<?=$uid?>&gid=<?=$row['mid']?>&gtype=<?=$gtype?>">设置比分</a>&nbsp;/&nbsp;
		    <a href=javascript:CheckCLOSE('ctl.php?uid=<?=$uid?>&gid=<?=$row[mid]?>&action=2&gtype=<?=$gtype?>&mtype=<?=$mtype?>')><?=$caption1?></a>&nbsp;/&nbsp;
		    <a href="ctl_list.php?uid=<?=$uid?>&gid=<?=$row['mid']?>&gtype=<?=$gtype?>">相关注单</a>&nbsp;

				<?
				if ($row['m_type']==1){
					echo '<font color=red>(走地)</font>';
				}
				?>
			</td>
    </tr>
	<? }?>
   <?
		}
	}else{
		while ($row = mysql_fetch_array($result)){
 			$sql="select * from sp_match where mid='$row[mid]' order by id";
 		 	?>
  		<tr class="m_cen" >
       <td ><?=$row['gdate']?></td>
       <td ><?=$row['league']?></td>
       <td ><?=$row['gid']?></td>
       <td align="center"  >
       	<?
	     	$res_lea = mysql_query($sql);
	  		while ($row_lea = mysql_fetch_array($res_lea)){
	  			echo "<a href='ctl_fs.php?uid=$uid&gid=".$row_lea['id']."'>".$row_lea['team']."</a><BR>";
	  		}
	  		$sql="select id,team from sp_match where mid='$row[mid]' order by id";
	  		$res_win = mysql_query($sql);

  		?>
      	</td>
      	<td >
			<form name="FS" method="post" action="ctl.php?uid=<?=$uid?>&action=3&gtype=FS">
			<?
			while ($row_win = mysql_fetch_array($res_win)){
				$team=$row_win['team'];
				?>	<input type="checkbox" name="LF[]" value="<?=$row_win['id']?>">
			
				<?echo $team;
	echo '<br>';
			}
			?>
			<input type="hidden" name="gid" value="<?=$row[mid]?>">
			<input type="submit" name="fsok" value="胜出" class="za_button">
			</form></td>
    </tr>
  <?
  	}
	}
?>
</table>
<div id=rs_window style="display: none;position:absolute">
  <form name=rs_form action="" method=post onSubmit="return Chk_acc();">

<input type=hidden name=act value="N">
<input type=hidden name=gid value="">

      <table width="250" border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
        <tr>
          <td bgcolor="#FFFFFF">
            <table width="250" border="0" cellspacing="0" cellpadding="0" bgcolor="#A4C0CE" class="m_tab_fix">
              <tr bgcolor="0163A2">
                <td  id=r_title width="200"><font color="#FFFFFF"></font></td>
                <td align="right" valign="top"><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
              </tr>
              <tr>
                <td colspan="2" height="1" bgcolor="#000000"></td>
              </tr>

              <tr>
                <td colspan="2">请输入单场限额&nbsp;&nbsp;
                <input type=TEXT id=ft_b4_1 name="maxgold" value="" size=12 maxlength=12 class="za_text">
				</td>
              </tr>
              <tr bgcolor="#000000">
                <td colspan="2" height="1"></td>
              </tr>


            <tr align="center">
              <td colspan="2">
                <input type=submit name=rs_ok value="确认" class="za_button">
                  &nbsp;&nbsp; </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
  </form>
</div>
</body>
</html>