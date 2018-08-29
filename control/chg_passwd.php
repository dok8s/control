<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../member/include/config.inc.php");
$uid=$_REQUEST["uid"];
$action=$_REQUEST["action"];
$password=$_REQUEST["password"];
$sql = "select * from web_sytnet where uid='".$uid."' and status=1";
$result = mysql_query( $sql );
$row = mysql_fetch_array( $result );
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
	echo "<script>window.open('".$site."/index.php','_top')</script>";
	exit;
}

if($action=="1"){
	$sql="update web_sytnet set passwd='$password' where uid='$uid'";
	mysql_query($sql);
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'><script>alert('密码已修改，请从新登陆!');window.open('".$site."/index.php','_top')</script>";
	exit;
}
?>
<html>
<head>
<title>更改密码</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body.css" type="text/css">
<style type="text/css">
<!--
a {
	font-size: 12px;
}
-->
</style></head>
 
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<script language="JavaScript" src="/js/mem_chk_pass.js"> 
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td valign="middle">
      <table width="250" border="0" cellspacing="0" cellpadding="0" bgcolor="#98B3C2" align="center" style="font-size:12px;">
        <tr>
          <td>
            <table width="250" border="0" cellspacing="1" cellpadding="0">
              <tr align="center">
                <td colspan="2" height="25"  bgcolor="#004080"><font color="#FFFFFF">请输入密码</font></td>
              </tr>
              <form method=post onSubmit="return SubChk();">
                <tr bgcolor="#C2E1E7" >
                  <td class="b_rig_02">密码</td>
                  <td height="30" width="120">
                    <input type=PASSWORD name="password" value="" size=8 maxlength=20  class="za_text_02">
                  </td>
                </tr>
                <tr bgcolor="#C2E1E7" >
                  <td height="30" class="b_rig_02" >确认密码</td>
                  <td >
                    <input type=PASSWORD name="REpassword" value="" size=8 maxlength=20 class="za_text_02">
                  </td>
                </tr>
                <tr  bgcolor="#C2E1E7"  align="center">
                  <td colspan="2" height="40" >
                    <input type=submit name="OK" value="确定" class="za_button_01">
                    <input type="reset" name="button" id="button" value="重置" />
                    <input type="hidden" name="action" value="1">
                    <input type="hidden" name="uid" value="<?=$uid?>">
                  </td>
                </tr>
              </form>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>

