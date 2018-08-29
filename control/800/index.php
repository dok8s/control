<?
session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");  
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");    
header("Cache-Control: no-store, no-cache, must-revalidate");    
header("Cache-Control: post-check=0, pre-check=0", false);    
header("Pragma: no-cache"); 
header("Content-type: text/html; charset=utf-8");

include ("../../member/include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php"); 

$uid=$_REQUEST["uid"];
require ("../../member/include/traditional.zh-cn.inc.php");

$uid=$_REQUEST["uid"];
$sql = "select id from web_sytnet where uid='".$uid."' and status<>'0'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
  echo "<script>window.open('/index.php','_top')</script>";
  exit;
}
$sql = "select * from web_member where Status='1'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou<>0){
	echo "<script languag='JavaScript'>self.location='user_list_800.php?uid=$uid'</script>";
}else{
	echo "<script languag='JavaScript'>alert('目前还没有会员，请添加后再操作!!');history.go( -1 );</script>";
}
?>