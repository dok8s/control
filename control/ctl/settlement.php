<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require_once( "../../member/include/config.inc.php" );
require_once( "../../member/include/define_function_list.inc.php" );
require_once( "../../inc/settlement.inc.php" );

$uid = $_REQUEST['uid'];
$sql = "select id from web_sytnet where uid='$uid' and status=1";
$cou = mysql_num_rows( mysql_query( $sql ) );
if ( $cou == 0 ){
	echo "<script>window.open('/','_top')</script>";
	exit( );
}

$is_settlement=0;
$id = intval($_REQUEST['id']);
$gid = intval($_REQUEST['gid']);
$gtype = $_REQUEST['gtype'];
$active = $_REQUEST['active'];
$referer = $_REQUEST['referer']=='' ? $_SERVER['HTTP_REFERER'] : $_REQUEST['referer'];

if($active=='resettlement'){
	$tables = array('FT'=>'foot_match', 'OP'=>'other_play', 'BS'=>'baseball', 'BK'=>'bask_match', 'TN'=>'tennis', 'VB'=>'volleyball');
	$sqladd = $gtype=='BK' ? '' : ',mb_inball_hr,tg_inball_hr';
	if($gtype<>'BK'){
		$sql="select status,mb_inball,tg_inball $sqladd from $tables[$gtype] where mid='$gid'";
		$result = mysql_query( $sql ) or exit('error 3');
		$match = mysql_fetch_array( $result );
		$mb_inball = is_numeric($match['mb_inball']) ? intval($match['mb_inball']) : '';
		$tg_inball = is_numeric($match['tg_inball']) ? intval($match['tg_inball']) : '';
		$mb_inball_hr = is_numeric($match['mb_inball_hr']) ? intval($match['mb_inball_hr']) : '';
		$tg_inball_hr = is_numeric($match['tg_inball_hr']) ? intval($match['tg_inball_hr']) : '';
		$matche_status = intval($match['status']);
		$more = array($match['mb_inball_hr'],$match['tg_inball_hr']);
		$ball1=$mb_inball_hr.':'.$tg_inball_hr.'<br>'.$mb_inball.':'.$tg_inball;
	}
	else{
		$sql="select status,mid,mb_inball,tg_inball,mb_mid  from  bask_match where mid='$gid'";
		$result = mysql_query( $sql ) or exit('error 3');
		$match = mysql_fetch_array( $result );
		
		$mid1=$match['mid'];
		$mb_mid=$match['mb_mid'];
		$mb_inball=$match['mb_inball'];
		$tg_inball=$match['tg_inball'];
		$matche_status = intval($match['status']);
		$more = array('','');
		if(strlen($mb_mid)==5){
			$mb_mid=$mb_mid+800000;
			$mid1=$mid1+1;
			$sql_h="select mb_inball,tg_inball from bask_match where mid=$mid1 and mb_mid=$mb_mid and tg_inball<>''";
			$result = mysql_query( $sql_h ) or exit('error 2');
			$match1 = mysql_fetch_array( $result );
			$ball1=$match1['mb_inball'].':'.$match1['tg_inball'].'<br>'.$mb_inball.':'.$tg_inball;
		}
		else if($mb_mid>300000 and $mb_mid<400000){
			$mb_mid=$mb_mid-300000;
			$mid1=$mid1-3;
			$sql_h="select mb_inball,tg_inball from bask_match where mid=$mid1 and mb_mid=$mb_mid and tg_inball<>''";
			$result = mysql_query( $sql_h ) or exit('error 2');
			$match1 = mysql_fetch_array( $result );
			$ball1=$mb_inball.':'.$tg_inball.'<br>'.$match1['mb_inball'].':'.$match1['tg_inball'];
		}
		else if($mb_mid>800000 and $mb_mid<900000){
			$mb_mid=$mb_mid-800000;
			$mid1=$mid1-1;
			$sql_h="select mb_inball,tg_inball from bask_match where mid=$mid1 and mb_mid=$mb_mid and tg_inball<>''";
			$result = mysql_query( $sql_h ) or exit('error 2');
			$match1 = mysql_fetch_array( $result );
			$ball1=$mb_inball.':'.$tg_inball.'<br>'.$match1['mb_inball'].':'.$match1['tg_inball'];
		}	
		else{
			$mb_mid=$mb_mid-900000;
			$mid1=$mid1-2;
			$sql_h="select mb_inball,tg_inball from bask_match where mid=$mid1 and mb_mid=$mb_mid and tg_inball<>''";
			$result = mysql_query( $sql_h ) or exit('error 2');
			$match1 = mysql_fetch_array( $result );
			$ball1=$mb_inball.':'.$tg_inball.'<br>'.$match1['mb_inball'].':'.$match1['tg_inball'];
		}
	}
	
	

	$mysql = "select id,Middle from web_db_io where mid='$gid'";
	$result = mysql_query( $mysql ) or exit('error 4');
	while ($row = mysql_fetch_array($result)){
		//$is_h = strpos($row['Middle'],'<font color=gray><b>')!==false;
		$mdiv=explode('font color=gray><b>',$row['Middle']);
		if(sizeof($mdiv)==1 && is_numeric($mb_inball) && is_numeric($tg_inball)){
			settlement($row['id'], $mb_inball, $tg_inball, $matche_status,$more,$ball1);
			
		}
		if(sizeof($mdiv)>1 && is_numeric($mb_inball_hr) && is_numeric($tg_inball_hr)){
			settlement($row['id'], $mb_inball_hr, $tg_inball_hr, $matche_status,$more,$ball1);
		}
	}
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
	echo "<SCRIPT language='javascript'> alert('相关注单已结算！'); self.location='$referer'; </script>";
	exit;
}

?>
