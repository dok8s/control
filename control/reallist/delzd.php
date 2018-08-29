<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$id=$_REQUEST['id'];
$action=$_REQUEST['action'];
$langx=$_REQUEST["langx"];
$username=$_REQUEST['user'];
$Money_bet=$_REQUEST['Money_bet'];
$date_s=$_REQUEST['date_start'];
$date_e=$_REQUEST['date_end'];
$mysql="delete from web_db_io where id=".$id;
mysql_db_query($dbname,$mysql);
	$sql1="update web_member set Money=Money+'$Money_bet' where M_Name='$username'";
	mysql_db_query($dbname, $sql1);

	echo "<script language=JavaScript>";
	echo "alert(\"É¾³ý³É¹¦ \");";
	echo "location='voucher.php?uid=$uid&date_start=$date_s&date_end=$date_e';";
	echo "</script>";
mysql_close();

?>
