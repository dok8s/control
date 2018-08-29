<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>-</title>
<style type="text/css">
html {overflow-y:hidden;overflow-x:hidden;}
body,td,th {
	font-size: 12px;
}
body {
	margin-left: 4px;
	margin-right: 4px;
	margin-top: 5px;
	margin-bottom: 5px;
	background-color: #413C15;
}
form { margin:0; padding:0;}
input,select {vertical-align:middle;	background-color: #FFFFFF;	border: 1px solid #C0C0C0;}
.Red {color: #cc0000;}
.b {
	border: 3px solid #808080;
}
.l {
	background-color: #FFFFFF;
	border-bottom-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-bottom-color: #CC3300;
	line-height: 25px;
	vertical-align: middle;
	text-align: center;
}
</style>
</head>

<body>
<?
require( "../../member/include/config.inc.php" );
require( "../../member/include/define_function_list.inc.php" );

$BET_TYPES = array(
	'letb' => array('zh'=>'让球', 'tw'=>'讓球', 'en'=>'Handicap','zh1'=>'让球', 'tw1'=>'讓球', 'en1'=>'Handicap'),
	'dime' => array('zh'=>'大小', 'tw'=>'大小', 'en'=>'Over/Under','zh1'=>'大小', 'tw1'=>'大小', 'en1'=>'Over/Under'),
	);

$RUNNING = array('zh'=>'滚球', 'tw'=>'滾球', 'en'=>'Running','zh1'=>'滚球 - ', 'tw1'=>'讓球 - ', 'en1'=>'Running ');
$HALF = array('zh'=>'半场', 'tw'=>'半場', 'en'=>'Half','zh1'=>'半场<br>', 'tw1'=>'半場<br>', 'en1'=>'Half<br>');
$HALF1 = array('zh'=>'全场', 'tw'=>'全場', 'en'=>'Full','zh1'=>'全场<br>', 'tw1'=>'全場<br>', 'en1'=>'Full<br>');

$CATEGORIES = array();
$CATEGORIES['FT'] = array(
	'active' => 1, 
	'name' => array('zh'=> '足球', 'tw'=> '足球', 'en'=> 'Soccer','zh1'=> '足球<br>', 'tw1'=> '足球<br>', 'en1'=> 'Soccer<br>'),
	'bet_types' => $BET_TYPES
	);
$CATEGORIES['BK'] = array(
	'active'=>3, 
	'name'=> array('zh'=> '篮球', 'tw'=> '籃球', 'en'=> 'Basket','zh1'=> '篮球<br>', 'tw1'=> '籃球<br>', 'en1'=> 'Basket<br>'),
	'bet_types' => $BET_TYPES
	);
$CATEGORIES['BK']['bet_types']['letb']=array('zh'=>'让分', 'tw'=>'讓分', 'en'=>'Handicap','zh1'=>'让分<br>', 'tw1'=>'讓分<br>', 'en1'=>'Handicap<br>');

$LINE_TYPES = array(
	'R'=>2, 'HR'=>12, 'RE'=>9, 'HRE'=>19,
	'OU'=>3, 'HOU'=>13, 'ROU'=>10, 'HROU'=>30,
	'M'=>1, 'HM'=>11, 'RM'=>51, 'HRM'=>52
	);


$uid = $_GET['uid'];
$gid = intval($_POST['gid']);
$gnum = intval($_POST['gnum']);
$hc = $_POST['hc']== 'H' ? 'H' : 'C';
$categories = $_POST['c'];
$minclass = $_POST['mc'];
$type = $_POST['type'];

$sql = "select * from web_sytnet where uid='$uid' and status=1 and level=1";
$result = mysql_query( $sql );
$row = mysql_fetch_array( $result );
$cou = mysql_num_rows( mysql_query( $sql ) );
if($cou==0){
	exit( "<script>window.open('$site/index.php','_top')</script>");
}
$admin_name = $row['agname'];
if (!in_array($categories, array('FT','BK')) ||
	!in_array($minclass, array('single','running')) ||
	!in_array($type, array('letb','dime')) ) {
	sohwerror('数据不完整，请返回');
}

$m_letb  = trim($_POST['m_letb']);
$m_place = trim($_POST['m_place']);
$m_rate  = trim($_POST['m_rate']);
$odd_type = trim($_POST['odd_type']);
$memname = trim($_POST['memname']);
$gold    = trim($_POST['gold']);
$bettime = trim($_POST['bettime']);
$ip      = trim($_POST['ip']);
$now_inball = trim($_POST['now_inball']);
$bottom = null;

$odd_type = in_array($odd_type, array('H','M','I','E')) ? $odd_type : 'H';
if($m_rate=='') sohwerror('陪率不能为空');
if($memname=='') sohwerror('会员账号不能为空');
if($gold=='') sohwerror('交易金额不能为空');
if($bettime=='') sohwerror('交易时间不能为空');
if($ip=='') sohwerror('IP地址不能为空');
$arr = explode(':', $now_inball);
$now_inball = intval($arr[0]).':'.intval($arr[1]);

if(strpos($m_place,'/') && !strpos($m_place,' / ')){
	$m_place=str_replace('/', ' / ', $m_place);
}

$sql = "SELECT tick,pretick,status,cancel,hidden,id,money,memname,agents,world,corprator,super,pay_type,opentype from web_member WHERE memname='$memname'";
$result = mysql_query($sql);
$memrow = mysql_fetch_assoc($result);
if(intval($memrow['id'])==0){
	sohwerror('会员($memname)不存在');
}
$memrow['cancel'] = 0;
$opentype = $memrow['opentype']; //ABCD盘

if($categories=='BK'){
	$sql = "SELECT * FROM bask_match WHERE mid='$gid'";
}else{
	$sql = "SELECT * FROM foot_match WHERE mid='$gid'";
}
$result = mysql_query($sql);
$gamerow = mysql_fetch_assoc($result);
if(mysql_num_rows($result)==0) {
	sohwerror('赛事不存在');
}

if($categories=='BK'){
	foreach(array('上半','下半','第1节','第2节','第3节','第4节') as $v){
		if (strstr($gamerow['MB_Team_tw'],$v)){
			$bottom = array('zh'=>"[$v]",'tw'=>"[$v]",'en'=>'','zh1'=>"[$v]",'tw1'=>"[$v]",'en1'=>'');
			$bottom['zh'] = $bottom['zh'];
			$bottom['zh1'] = $bottom['zh1'];
			break;
		}
	}
}
$gamerow['M_League']=trim($gamerow['M_League']);
$gamerow['M_League_tw']=trim($gamerow['M_League_tw']);
$gamerow['M_League_en']=trim($gamerow['M_League_en']);
$gamerow['MB_Team']=filiter_team(trim($gamerow['MB_Team']));
$gamerow['TG_Team']=filiter_team(trim($gamerow['TG_Team']));
$gamerow['MB_Team_tw']=filiter_team(trim($gamerow['MB_Team_tw']));
$gamerow['TG_Team_tw']=filiter_team(trim($gamerow['TG_Team_tw']));
$gamerow['MB_Team_en']=filiter_team(trim($gamerow['MB_Team_en']));
$gamerow['TG_Team_en']=filiter_team(trim($gamerow['TG_Team_en']));

$gtype = $hc;

$ishr = $gamerow['is_hr'];
if($type=='letb'){
	$sign = $m_place;
	$w_m_place = array(
		'zh'=> $gtype=='H' ? $gamerow['MB_Team'] : $gamerow['TG_Team'],
		'tw'=> $gtype=='H' ? $gamerow['MB_Team_tw'] : $gamerow['TG_Team_tw'],
		'en'=> $gtype=='H' ? $gamerow['MB_Team_en'] : $gamerow['TG_Team_en']
		);
	$sline = $minclass=='running' ? 'RE' : 'R';
}elseif($type=='dime'){
	$sign = 'vs.';	
	$w_m_place = array(
		'zh'=> $gtype=='C' ? '大'.$m_place : '小'.$m_place,
		'tw'=> $gtype=='C' ? '大'.$m_place : '小'.$m_place,
		'en'=> $gtype=='C' ? 'Over'.$m_place : 'Under'.$m_place
		);
	$m_place = $gtype=='C' ? 'Over'.$m_place : 'Uder'.$m_place;
	$sline = $minclass=='running' ? 'ROU' : 'OU';
}
if($ishr){
	$sline='H'.$sline;
	$bottom = array('zh'=>'[上半]','tw'=>'[上半]','en'=>'[1st]','zh1'=>'[上半]','tw1'=>'[上半]','en1'=>'[1st]');
	$bottom['zh'] = $bottom['zh'];
	$bottom['zh1'] = $bottom['zh1'];
}
$cate = $CATEGORIES[$categories];
$BET_TYPES = $cate['bet_types'];;
$active = $cate['active'];
$line_type = $LINE_TYPES[$sline];

$bet_type = $cate['name'];
if($ishr){
	foreach($HALF as $k=>$v){
		$bet_type[$k] .= $v;
	}
}else{
	foreach($HALF1 as $k=>$v){
		$bet_type[$k] .= $v;
	}
}
if($minclass=='running'){
	foreach($RUNNING as $k=>$v){
		$bet_type[$k] .= $v;
	}
}
foreach($BET_TYPES[$type] as $k=>$v){
	$bet_type[$k] .= $v;
}

$R = $ishr ? substr($sline,1) : $sline;
$turn_rate="{$categories}_Turn_{$R}_{$opentype}";
$turn="{$categories}_Turn_{$R}";
$gwin=$gold*$m_rate;
if($type=='letb' || $type=='dime'){
	if($odd_type=='M'){
		$gwin=$gold;
	}elseif($odd_type=='I'){
		
	}elseif($odd_type=='E'){
		$gwin=$gold*($m_rate-1);
	}
}

$wtype=$sline;
$now_inball = $minclass=='running' ? $now_inball : '';
$danger = $minclass=='running' ? 3 : 0;

$oid = betsave($gamerow,$memrow, $bottom, $turn, $turn_rate, $sign, $m_rate, $active, $line_type, $gtype, $bettime, $gold, $m_place, $w_m_place, $bet_type, $gwin, $ip, $wtype, $odd_type, $now_inball, $danger);

//echo $oid;

$result = mysql_query("select date_format(BetTime,'%m%d%H%i%s')+id as ouid from web_db_io where id='$oid'");
$row = mysql_fetch_array($result);
$ouid = $row['ouid'];
$ouid = show_voucher($line_type,$ouid);


function betsave($gamerow,$memrow, $bottom, $turn, $turn_rate, $sign, $m_rate, $active, $line_type, $gtype, $bettime, $gold, $m_place, $w_m_place, $bet_type, $gwin, $ip, $wtype, $odd_type, $now_inball='', $danger=0){

	if(!in_array($odd_type, array('H','M','I','E')))exit('odd_type error');
	$Y = date('Y');
	$now= time();
	$time1 = strtotime($Y."-$gamerow[M_Date]");
	$time2 = strtotime(($Y-1)."-$gamerow[M_Date]");
	$time3 = strtotime(($Y+1)."-$gamerow[M_Date]");
	$i1 = abs($time1-$now);
	$i2 = abs($time2-$now);
	$i3 = abs($time3-$now);
	if($i1<$i2){
		$time = $i1<$i3 ? $time1 : $time3;
	}else{
		$time = $i2<$i3 ? $time2 : $time3;
	}
	$gdate = date('Y-m-d',$time);
	
	$memname = $memrow['memname'];

	$nowin = $now_inball!='' ? "<FONT color=red><b>$now_inball</b></FONT>" : '';
	if(is_array($bottom)){
		foreach($bottom as $k=>$v){
			if($v!='') $bottom[$k] = "<font color=red>-&nbsp;</font><font color=#666666>$v</font>&nbsp;";
		}
	}
	$rearr_zh = array($gamerow['M_League'],$gamerow['MB_Team'],$gamerow['TG_Team'],$w_m_place['zh'],$bottom['zh']);
	$rearr_tw = array($gamerow['M_League_tw'],$gamerow['MB_Team_tw'],$gamerow['TG_Team_tw'],$w_m_place['tw'],$bottom['tw']);
	$rearr_en = array($gamerow['M_League_en'],$gamerow['MB_Team_en'],$gamerow['TG_Team_en'],$w_m_place['en'],$bottom['en']);
	$find=array('(league)','(mb_team)','(tg_team)','(w_m_place)','(bottom)');
	$middle_temp = "(league)<br>[$gamerow[MB_MID]]vs[$gamerow[TG_MID]]<br>";
	$middle_temp .= "(mb_team)&nbsp;&nbsp;<FONT COLOR=#0000BB><b>$sign</b></FONT>&nbsp;&nbsp;(tg_team)&nbsp;&nbsp;{$nowin}<br>";
	$middle_temp .= "<FONT color=#cc0000>(w_m_place)</FONT>&nbsp;(bottom)@&nbsp;<FONT color=#cc0000><b>$m_rate</b></FONT>";
	$middle_temp1 = "(league)<br>";
	$middle_temp1 .= "(mb_team)&nbsp;&nbsp;<FONT COLOR=#CC0000><b>$sign</b></FONT>&nbsp;&nbsp;(tg_team)&nbsp;&nbsp;{$nowin}<br>";
	$middle_temp1 .= "<FONT color=#cc0000><b>(w_m_place)</b></FONT>&nbsp;(bottom)@&nbsp;<FONT color=#cc0000><b>$m_rate</b></FONT>";
	$middle_zh = str_replace($find, $rearr_zh, $middle_temp);
	$middle_tw = str_replace($find, $rearr_tw, $middle_temp);
	$middle_en = str_replace($find, $rearr_en, $middle_temp);
	
	$middle1_zh = str_replace($find, $rearr_zh, $middle_temp1);
	$middle1_tw = str_replace($find, $rearr_tw, $middle_temp1);
	$middle1_en = str_replace($find, $rearr_en, $middle_temp1);

	$sql="SELECT web_member.$turn as turn,web_agents.winloss_s,web_agents.winloss_a,web_agents.winloss_c,web_agents.$turn_rate as ag_turn,web_world.$turn_rate as wd_turn,web_corprator.$turn_rate AS cop_turn FROM web_member, web_agents,web_world,web_corprator WHERE (web_member.Memname='$memname' and web_member.Agents=web_agents.Agname and web_member.corprator=web_corprator.agname )AND web_agents.world = web_world.Agname AND web_agents.corprator = web_corprator.Agname";

	$result = mysql_query($sql) or exit('error 88392<br>'.mysql_error());
	$rt = mysql_fetch_array($result);
	$mem_turn=$rt['turn']+0;
	$agent_rate=$rt['ag_turn']+0;
	$world_rate=$rt['wd_turn']+0;
	$corpor_rate=$rt['cop_turn']+0;
	$agent_point=$rt['winloss_a']+0;
	$world_point=$rt['winloss_s']+0;
	$corpor_point=$rt['winloss_c']+0;


	$arr=array('MID'=>$gamerow['MID']
		,'Active'=>$active
		,'LineType'=>$line_type //$line
		,'Mtype'=>$gtype
		,'pay_type'=>$memrow['pay_type']
		,'M_Date'=>$gdate
		,'BetTime'=>$bettime
		,'BetScore'=>$gold
		,'Middle'=>$middle1_zh
		,'Middle_tw'=>$middle1_tw
		,'Middle_en'=>$middle1_en
		,'M_Place'=>$m_place //$grape
		,'M_Rate'=>$m_rate
		,'M_Name'=>$memname
		,'BetType1'=>$bet_type['zh']
		,'BetType1_tw'=>$bet_type['tw']
		,'BetType1_en'=>$bet_type['en']
		,'BetType'=>$bet_type['zh1']
		,'BetType_tw'=>$bet_type['tw1']
		,'BetType_en'=>$bet_type['en1']
		,'Gwin'=>$gwin
		,'ShowType'=>$gamerow["ShowType"]
		,'OpenType'=>$memrow['opentype']
		,'Agents'=>$memrow['agents']
		,'world'=>$memrow['world']
		,'corprator'=>$memrow['corprator']
		,'super'=>$memrow['super']
		,'TurnRate'=>$mem_turn
		,'agent_rate'=>$agent_rate
		,'world_rate'=>$world_rate
		,'corpor_turn'=>$corpor_rate //$corpro_rate
		,'agent_point'=>$agent_point
		,'world_point'=>$world_point
		,'corpor_point'=>$corpor_point
		,'BetIP'=>$ip //$ip_addr
		,'wtype'=>$wtype
		,'orderby'=>'A'
		,'QQ526738'=>$now_inball
		,'hidden'=>$memrow['hidden']
		,'auth_code'=>md5($middle_tw.$gold.$gtype)
		,'status'=>$memrow['cancel']
		,'tick'=>$memrow['tick']
		,'pretick'=>$memrow['pretick']
		,'odd_type'=>$odd_type
		,'danger'=>$danger
		,'G_Name'=>$admin_name
	);

	$keys = join(',', array_keys($arr));
	$values = join("','", $arr);
	$sql = "INSERT INTO web_db_io($keys) values ('$values')";

	mysql_query($sql) or exit("error bet!".mysql_error());
	return mysql_insert_id();
}

function sohwerror($str){
	$str=str_replace("'","\'",$str);
	echo "<SCRIPT>alert('$str'); history.back(1)</script></body></html>";
	exit;
}
?>
<table width="232" border="0" cellpadding="5" cellspacing="0" class="b">
  <tr>
    <td class="l"><p><br></p>
		操作成功！<br>
		单注号：<font color=#0000bb><b><?=$ouid?></b></font>
		<p></p>
	</td>
  </tr>
</table>
</body></html>