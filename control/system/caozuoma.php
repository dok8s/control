<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require_once( dirname(__FILE__)."/../../member/include/config.inc.php" );

$active = $_REQUEST['active9939'];

$sql = "select setdata from web_system LIMIT 0, 1";
$result = mysql_query( $sql );
$rt = mysql_fetch_array( $result );
$setdata = @unserialize($rt['setdata']);
if($active=='set'){
	if($_POST['save']=='yes'){
		if(get_md5($_POST['caozuoma1'])==$setdata['caozuoma'] or !isset($setdata['caozuoma'])){
			$setdata['caozuoma'] = get_md5($_POST['caozuoma2']);
			 $mysql = "update web_system set setdata='".serialize($setdata)."'";
			mysql_query( $mysql );
			echo "<script>alert('保存成功')</script>";
		}else{
			echo "<script>alert('保存失败')<script>";
		}
	}
	echo "
		<html><title></title><body><FORM METHOD=POST>
		<INPUT TYPE='hidden' NAME='save' VALUE='yes'>
		原操作码：<INPUT TYPE='text' NAME='caozuoma1' VALUE='$_POST[caozuoma1]'>
		新操作码：<INPUT TYPE='text' NAME='caozuoma2' VALUE='$_POST[caozuoma2]'>
		<INPUT TYPE='submit' VALUE=' 保存 '>
		</FORM></body></html>
		";
}

function ck_caozuoma($str){
	global $setdata;
	
	return $setdata['caozuoma'] == get_md5($str) ? TRUE : FALSE;
}

function get_md5($str){
	return $str."wiso.hk";
}
?>