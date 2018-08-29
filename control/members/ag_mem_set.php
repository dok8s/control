<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");

$uid=$_REQUEST["uid"];
$mid=$_REQUEST["id"];
$aid=$_REQUEST["agents_id"];

$sql = "select id from web_sytnet where uid='".$uid."' and status=1";
$result = mysql_query( $sql );
$cou = mysql_num_rows( $result );
if ( $cou == 0 ){
	echo "<script>window.open('".$site."/index.php','_top')</script>";
	exit( );
}

$langx='zh-cn';
require ("../../member/include/traditional.$langx.inc.php");
require ("../../member/include/define_function_list.inc.php");
require ("../../inc/ag_mem_set.inc.php");
?>