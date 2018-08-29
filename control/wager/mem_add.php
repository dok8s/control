<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$keys=$_REQUEST["keys"];//HIDDEN
$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$username=$_REQUEST["username"];
$password=$_REQUEST["password"];
$action=$_REQUEST["action"];
if($action==1){
	if($keys<>""){
		$mysql="select * from web_member where Memname='$username' and Passwd='$password'";
		$result = mysql_db_query($dbname,$mysql);
		$cou=mysql_num_rows($result);
		if($cou==0){
			echo "<script>alert('LOGIN ERROR!!\\nPlease check username/passwd and try again!!');</script>";
		}else{
			if($keys=='hidden'){
				$upsql="update web_member set hidden=1 where  Memname='$username' and Passwd='$password' ";
				mysql_db_query($dbname, $upsql);
				echo "<script>document.location='./wager_hide.php?uid=$uid';</script>";
			}else{
				$upsql="update web_member set edtvou=1 where  Memname='$username' and Passwd='$password' ";
				mysql_db_query($dbname, $upsql);
				echo "<script>document.location='./wager_add.php?uid=$uid';</script>";
			}
		}
	}
}
?>
<html>
<head>
<title>更改密码</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/mem_body.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<script language="JavaScript" src="/js/mem_chk_pass.js"> 
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td valign="middle">
      <table width="250" border="0" cellspacing="0" cellpadding="0" bgcolor="#98B3C2" align="center">
        <tr>
          <td>
            <table width="250" border="0" cellspacing="1" cellpadding="0">
              <tr align="center">
                <td colspan="2" height="25"  bgcolor="#004080"><font color="#FFFFFF">请输入会员帐号密码</font></td>
			</tr>
              <form method=post onSubmit="return SubChk();">
                <tr bgcolor="#C2E1E7" >
                  <td class="b_rig_02">帐号</td>
                  <td height="30" width="120">
				  	<input type=text name="username" value=""  size=8 maxlength=8  class="za_text_02">
            	  </td>
                </tr>
                <tr bgcolor="#C2E1E7" >
                  <td height="30" class="b_rig_02" >密码</td>
                  <td >
		            <input type=PASSWORD name="password" value="" size=8 maxlength=8 class="za_text_02">
                   </td>
                </tr>
                <tr  bgcolor="#C2E1E7"  align="center">
                  <td colspan="2" height="40" >
                    <input type=submit name="OK" value="确定" class="za_button_01">
                    <input type=button name="cancel" value="取消" class="za_button_01" onClick="javascript:window.close();">
                    <input type="hidden" name="action" value="1">
					<input type="hidden" name="keys" value="<?=$keys?>">
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
