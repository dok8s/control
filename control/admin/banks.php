<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include ("../../member/include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'\n;</script>";
require ("../../member/include/config.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
//include ("../../member/include/online.php");
require ("../../member/include/traditional.zh-tw.inc.php");

$sql = "select id from web_sytnet where uid='".$uid."' and status<>'0'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
exit;
}

$type=$_REQUEST['type'];
$che=$_REQUEST['chk'];

if ($type=='add'){
	$username=$_REQUEST['username'];//收款人
	$bankname=$_REQUEST['bankname'];//银行名称
	$banknum=$_REQUEST['banknum'];//银行卡号
	$address=$_REQUEST['Address'];//开户地址
	$url=$_REQUEST['url'];//银行网址
	$mysql="insert into `banks`(`username`,`bankname`,`banknum`,`address`,`url`)values('$username','$bankname','$banknum','$address','$url')";
	mysql_db_query($dbname,$mysql);
	echo "<script>alert('新增加一条内容');</script>";
}else if ($type=='edit'){
	if (empty($che)){
		echo "<script>alert('请选择要修改的内容');history.back(-1);</script>";
		exit;
	}
	foreach($che as $values){
		$username=$_REQUEST['username'.$values];//收款人
		$bankname=$_REQUEST['bankname'.$values];//银行名称
		$banknum=$_REQUEST['banknum'.$values];//银行卡号
		$address=$_REQUEST['Address'.$values];//开户地址
		$url=$_REQUEST['url'.$values];//银行网址
		$mysql="update `banks` set username='$username',bankname='$bankname',banknum='$banknum' ,address='$address',url='$url' where id='$values'";
		mysql_db_query($dbname,$mysql);
		echo "<script>alert('更新ID ".$values." 成功');</script>";
	}
}else if ($type=='del'){
	foreach($che as $values){
		$mysql="delete from `banks` where `id`='$values'";
		mysql_db_query($dbname,$mysql);
		echo "<script>alert('删除ID ".$values." 成功');</script>";
	}
}
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script>
function sbar(st){
st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
st.style.backgroundColor='';
}

function SubChk(){
	if (document.all.username.value==''){
		document.all.username.focus();
		alert("请输入收款人!!");
		return false;
	}
	if (document.all.bankname.value==''){
		document.all.bankname.focus();
		alert("请输入银行名称!!");
		return false;
	}
	if (document.all.banknum.value==''){
		document.all.banknum.focus();
		alert("请输入银行卡号!!");
		return false;
	}
	
}
function edit(){
	document.getElementById("type").value='edit';
}
function del(){
	if(!confirm("确认要删除吗")){
		return false;
	}
	document.getElementById("type").value='del';
	return true;
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline">&nbsp;&nbsp;支付方式&nbsp;&nbsp;&nbsp;&nbsp;<a href="?uid=<?=$uid?>&type=Y">新增</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="payment.php?uid=<?=$uid?>">网银支付</a></td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<?
if ($type=='Y'){
?>
<table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">
<form name="myform" action="" method="post" onSubmit="return SubChk();">  
  <tr class="m_title"> 
    <td width=30>ID</td>
	<td width="80">收款人</td>
    <td width=100>银行名称</td>
    <td width=230>开户网点</td>
    <td width="229">银行卡号</td>
	<td width="300">银行网址</td>
    </tr>
  <tr class=m_cen>
    <td>1</td>
    <td><input name="username" id="username" type="text" value="" style="width:80px;"></td>
	<td><input name="bankname" id="bankname" type="text" value="" style="width:100px;"></td>
    <td><input name="Address" id="Address" type="text" value="" style="width:230px;"></td>
    <td><input name="banknum" id="banknum" type="text" value="" style="width:229px;"></td>
    <td><input name="url" id="url" type="text" value="" style="width:300px;"></td>
  </tr>
  <tr class=m_cen>
    <td colspan="6"><input class="za_button" type="submit" value="提交" name="cmdsubmit">&nbsp;&nbsp;&nbsp;&nbsp;<input class="za_button" type="reset" value="取消" name="cmdcancel"><input type="hidden" name="type" value="add"></td>
    </tr>
</form>
</table>
<?
}else{
?>
<table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">
<form name="myform" action="" method="post">  
  <tr class="m_title"> 
    <td width=30>ID</td>
    <td width=30>选中</td>
	<td width="80">收款人</td>
    <td width=90>银行名称</td>
    <td width=217>开户网点</td>
    <td width="218">银行卡号</td>
	<td width="300">银行网址</td>
    </tr>
<?
$i=1;
$mysql="select * from banks";
$result=mysql_db_query($dbname,$mysql);
while($row=mysql_fetch_array($result)){
?>
  <tr class=m_cen>
    <td><?=$i?></td>
    <td><input type="checkbox" value="<?=$row['id']?>" name="chk[<?=$row['id']?>]"></td>
    <td><input name="username<?=$row['id']?>" id="username<?=$row['id']?>" type="text" value="<?=$row['username']?>" style="width:80px;"></td>
	<td><input name="bankname<?=$row['id']?>" id="bankname<?=$row['id']?>" type="text" value="<?=$row['bankname']?>" style="width:90px;"></td>
    <td><input name="Address<?=$row['id']?>" id="Address<?=$row['id']?>" type="text" value="<?=$row['address']?>" style="width:217px;"></td>
    <td><input name="banknum<?=$row['id']?>" id="banknum<?=$row['id']?>" type="text" value="<?=$row['banknum']?>" style="width:218px;"></td>
    <td><input name="url<?=$row['id']?>" id="url<?=$row['id']?>" type="text" value="<?=$row['url']?>" style="width:465px;"></td>  
  </tr>
<?
$i++;
}
?>
  <tr class=m_cen>
    <td colspan="9"><input type="hidden" name="type"><input type="submit" name="submit" value="修改选中" class="za_button" onClick="edit()">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="删除选中" class="za_button" onClick="return del();"></td>
    </tr>
</form>
</table>
<?
}
?>
</body>
</html>