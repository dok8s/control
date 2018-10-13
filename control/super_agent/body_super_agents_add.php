<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
function check_name($username,$dbname){
	$mysql="select Agname from web_super_data where Agname='$username'";
	$result = mysql_query($mysql);
	$count=mysql_num_rows($result);
	if ($count>0){
	echo wterror("您输入的帐号 $username 已经有人使用了，请回上一页重新输入");
		exit();
	}
	$mysql="select Agname from web_corprator_data where Agname='$username'";
	$result = mysql_query($mysql);
	$count=mysql_num_rows($result);
	if ($count>0){
		echo wterror("您输入的帐号 $username 已经有人使用了，请回上一页重新输入");
		exit();
	}
	$mysql="select Agname from web_world_data where Agname='$username'";
	$result = mysql_query($mysql);
	$count=mysql_num_rows($result);
	if ($count>0){
		echo wterror("您输入的帐号 $username 已经有人使用了，请回上一页重新输入");
		exit();
	}
	$mysql="select Agname from web_agents_data where Agname='$username'";
	$result = mysql_query($mysql);
	$count=mysql_num_rows($result);
	if ($count>0){
		echo wterror("您输入的帐号 $username 已经有人使用了，请回上一页重新输入");
		exit();
	}
}
$uid=$_REQUEST["uid"];
$agents_id=$_REQUEST['agents_id'];
$sql = "select Agname,ID,language,credit,CurType from web_super_data where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
$row = mysql_fetch_array($result);

$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
//股东
if ($agents_id!=""){
$a_sql="and Agname='$agents_id'";
}else{
$a_sql="";
$agents_id='___';
}
$mysql="select * from web_corprator_data where super='$agname' $a_sql limit 1";
		//echo $mysql;
		$cresult = mysql_query($mysql);
		$crow = mysql_fetch_array($cresult);
		$credit=$crow['Credit'];
    	$Winloss_D=$crow['Winloss_D'];
		$Winloss_C=$crow['winloss_C'];
$addmeney=$crow['CurType'];
$FT_R_Scene=$crow['FT_R_Scene'];
$FT_RE_Scene=$crow['FT_RE_Scene'];
$FT_ROU_Scene=$crow['FT_ROU_Scene'];
$FT_M_Scene=$crow['FT_M_Scene'];
$FT_OU_Scene=$crow['FT_OU_Scene'];
$FT_EO_Scene=$crow['FT_EO_Scene'];
$FT_PD_Scene=$crow['FT_PD_Scene'];
$FT_T_Scene=$crow['FT_T_Scene'];
$FT_PR_Scene=$crow['FT_PR_Scene'];
$FT_F_Scene=$crow['FT_F_Scene'];
$FT_R_Bet=$crow['FT_R_Bet'];
$FT_RE_Bet=$crow['FT_RE_Bet'];
$FT_ROU_Bet=$crow['FT_ROU_Bet'];
$FT_M_Bet=$crow['FT_M_Bet'];
$FT_OU_Bet=$crow['FT_OU_Bet'];
$FT_EO_Bet=$crow['FT_EO_Bet'];
$FT_PD_Bet=$crow['FT_PD_Bet'];
$FT_T_Bet=$crow['FT_T_Bet'];
$FT_PR_Bet=$crow['FT_PR_Bet'];
$FT_F_Bet=$crow['FT_F_Bet'];
$FT_P_Scene=$crow['FT_P_Scene'];
$FT_P_Bet=$crow['FT_P_Bet'];
$FT_Turn_R_A=$crow['FT_Turn_R_A'];
$FT_Turn_R_B=$crow['FT_Turn_R_B'];
$FT_Turn_R_C=$crow['FT_Turn_R_C'];
$FT_Turn_RE_A=$crow['FT_Turn_RE_A'];
$FT_Turn_RE_B=$crow['FT_Turn_RE_B'];
$FT_Turn_RE_C=$crow['FT_Turn_RE_C'];
$FT_Turn_ROU_A=$crow['FT_Turn_ROU_A'];
$FT_Turn_ROU_B=$crow['FT_Turn_ROU_B'];
$FT_Turn_ROU_C=$crow['FT_Turn_ROU_C'];
$FT_Turn_M=$crow['FT_Turn_M'];
$FT_Turn_PD=$crow['FT_Turn_PD'];
$FT_Turn_T=$crow['FT_Turn_T'];
$FT_Turn_F=$crow['FT_Turn_F'];
$FT_Turn_P=$crow['FT_Turn_P'];
$FT_Turn_PR=$crow['FT_Turn_PR'];
$TN_Turn_R_A=$crow['TN_Turn_R_A'];
$TN_Turn_R_B=$crow['TN_Turn_R_B'];
$TN_Turn_R_C=$crow['TN_Turn_R_C'];
$TN_Turn_OU_A=$crow['TN_Turn_OU_A'];
$TN_Turn_OU_B=$crow['TN_Turn_OU_B'];
$TN_Turn_OU_C=$crow['TN_Turn_OU_C'];
$TN_Turn_ROU_A=$crow['TN_Turn_ROU_A'];
$TN_Turn_ROU_B=$crow['TN_Turn_ROU_B'];
$TN_Turn_ROU_C=$crow['TN_Turn_ROU_C'];
$TN_Turn_RE_A=$crow['TN_Turn_RE_A'];
$TN_Turn_RE_B=$crow['TN_Turn_RE_B'];
$TN_Turn_RE_C=$crow['TN_Turn_RE_C'];
$TN_Turn_EO_A=$crow['TN_Turn_EO_A'];
$TN_Turn_EO_B=$crow['TN_Turn_EO_B'];
$TN_Turn_EO_C=$crow['TN_Turn_EO_C'];
$TN_Turn_M=$crow['TN_Turn_M'];
$TN_Turn_T=$crow['TN_Turn_T'];
$TN_Turn_PD=$crow['TN_Turn_PD'];
$TN_Turn_F=$crow['TN_Turn_F'];
$TN_Turn_PR=$crow['TN_Turn_PR'];
$TN_Turn_P=$crow['TN_Turn_P'];
$VB_Turn_R_A=$crow['VB_Turn_R_A'];
$VB_Turn_R_B=$crow['VB_Turn_R_B'];
$VB_Turn_R_C=$crow['VB_Turn_R_C'];
$VB_Turn_OU_A=$crow['VB_Turn_OU_A'];
$VB_Turn_OU_B=$crow['VB_Turn_OU_B'];
$VB_Turn_OU_C=$crow['VB_Turn_OU_C'];
$VB_Turn_ROU_A=$crow['VB_Turn_ROU_A'];
$VB_Turn_ROU_B=$crow['VB_Turn_ROU_B'];
$VB_Turn_ROU_C=$crow['VB_Turn_ROU_C'];
$VB_Turn_RE_A=$crow['VB_Turn_RE_A'];
$VB_Turn_RE_B=$crow['VB_Turn_RE_B'];
$VB_Turn_RE_C=$crow['VB_Turn_RE_C'];
$VB_Turn_EO_A=$crow['VB_Turn_EO_A'];
$VB_Turn_EO_B=$crow['VB_Turn_EO_B'];
$VB_Turn_EO_C=$crow['VB_Turn_EO_C'];
$VB_Turn_M=$crow['VB_Turn_M'];
$VB_Turn_T=$crow['VB_Turn_T'];
$VB_Turn_PD=$crow['VB_Turn_PD'];
$VB_Turn_F=$crow['VB_Turn_F'];
$VB_Turn_PR=$crow['VB_Turn_PR'];
$VB_Turn_P=$crow['VB_Turn_P'];
$VB_R_Bet=$crow['VB_R_Bet'];
$VB_RE_Bet=$crow['VB_RE_Bet'];
$VB_ROU_Bet=$crow['VB_ROU_Bet'];
$VB_OU_Bet=$crow['VB_OU_Bet'];
$VB_M_Bet=$crow['VB_M_Bet'];
$VB_T_Bet=$crow['VB_T_Bet'];
$VB_EO_Bet=$crow['VB_EO_Bet'];
$VB_P_Bet=$crow['VB_P_Bet'];
$VB_PR_Bet=$crow['VB_PR_Bet'];
$VB_PD_Bet=$crow['VB_PD_Bet'];
$VB_F_Bet=$crow['VB_F_Bet'];
$VB_R_Scene=$crow['VB_R_Scene'];
$VB_OU_Scene=$crow['VB_OU_Scene'];
$VB_RE_Scene=$crow['VB_RE_Scene'];
$VB_ROU_Scene=$crow['VB_ROU_Scene'];
$VB_M_Scene=$crow['VB_M_Scene'];
$VB_EO_Scene=$crow['VB_EO_Scene'];
$VB_T_Scene=$crow['VB_T_Scene'];
$VB_PD_Scene=$crow['VB_PD_Scene'];
$VB_F_Scene=$crow['VB_F_Scene'];
$VB_P_Scene=$crow['VB_P_Scene'];
$VB_PR_Scene=$crow['VB_PR_Scene'];
$FT_Turn_EO_A=$crow['FT_Turn_EO_A'];
$FT_Turn_EO_B=$crow['FT_Turn_EO_B'];
$FT_Turn_EO_C=$crow['FT_Turn_EO_C'];
$FT_Turn_OU_A=$crow['FT_Turn_OU_A'];
$FT_Turn_OU_B=$crow['FT_Turn_OU_B'];
$FT_Turn_OU_C=$crow['FT_Turn_OU_C'];
$BK_Turn_R_A=$crow['BK_Turn_R_A'];
$BK_Turn_R_B=$crow['BK_Turn_R_B'];
$BK_Turn_R_C=$crow['BK_Turn_R_C'];
$BK_Turn_EO_A=$crow['BK_Turn_EO_A'];
$BK_Turn_EO_B=$crow['BK_Turn_EO_B'];
$BK_Turn_EO_C=$crow['BK_Turn_EO_C'];
$BK_Turn_OU_A=$crow['BK_Turn_OU_A'];
$BK_Turn_OU_B=$crow['BK_Turn_OU_B'];
$BK_Turn_OU_C=$crow['BK_Turn_OU_C'];
$BK_Turn_RE_A=$crow['BK_Turn_RE_A'];
$BK_Turn_RE_B=$crow['BK_Turn_RE_B'];
$BK_Turn_RE_C=$crow['BK_Turn_RE_C'];
$BK_Turn_ROU_A=$crow['BK_Turn_ROU_A'];
$BK_Turn_ROU_B=$crow['BK_Turn_ROU_B'];
$BK_Turn_ROU_C=$crow['BK_Turn_ROU_C'];
$BK_RE_Scene=$crow['BK_RE_Scene'];
$BK_ROU_Scene=$crow['BK_ROU_Scene'];
$BK_RE_Bet=$crow['BK_RE_Bet'];
$BK_ROU_Bet=$crow['BK_ROU_Bet'];
$BK_Turn_PR=$crow['BK_Turn_PR'];
$BK_R_Scene=$crow['BK_R_Scene'];
$BK_EO_Scene=$crow['BK_EO_Scene'];
$BK_OU_Scene=$crow['BK_OU_Scene'];
$BK_PR_Scene=$crow['BK_PR_Scene'];
$BK_R_Bet=$crow['BK_R_Bet'];
$BK_EO_Bet=$crow['BK_EO_Bet'];
$BK_OU_Bet=$crow['BK_OU_Bet'];
$BK_PR_Bet=$crow['BK_PR_Bet'];
$TN_R_Scene=$crow['TN_R_Scene'];
$TN_OU_Scene=$crow['TN_OU_Scene'];
$TN_RE_Scene=$crow['TN_RE_Scene'];
$TN_ROU_Scene=$crow['TN_ROU_Scene'];
$TN_EO_Scene=$crow['TN_EO_Scene'];
$TN_M_Scene=$crow['TN_M_Scene'];
$TN_PR_Scene=$crow['TN_PR_Scene'];
$TN_P_Scene=$crow['TN_P_Scene'];
$TN_PD_Scene=$crow['TN_PD_Scene'];
$TN_T_Scene=$crow['TN_T_Scene'];
$TN_F_Scene=$crow['TN_F_Scene'];
$TN_R_Bet=$crow['TN_R_Bet'];
$TN_OU_Bet=$crow['TN_OU_Bet'];
$TN_RE_Bet=$crow['TN_RE_Bet'];
$TN_ROU_Bet=$crow['TN_ROU_Bet'];
$TN_EO_Bet=$crow['TN_EO_Bet'];
$TN_M_Bet=$crow['TN_M_Bet'];
$TN_PR_Bet=$crow['TN_PR_Bet'];
$TN_P_Bet=$crow['TN_P_Bet'];
$TN_PD_Bet=$crow['TN_PD_Bet'];
$TN_T_Bet=$crow['TN_T_Bet'];
$TN_F_Bet=$crow['TN_F_Bet'];
$FT_Turn_OU_D=$crow['FT_Turn_OU_D'];
$FT_Turn_R_D=$crow['FT_Turn_R_D'];
$FT_Turn_ROU_D=$crow['FT_Turn_ROU_D'];
$FT_Turn_RE_D=$crow['FT_Turn_RE_D'];
$FT_Turn_EO_D=$crow['FT_Turn_EO_D'];
$BK_Turn_OU_D=$crow['BK_Turn_OU_D'];
$BK_Turn_R_D=$crow['BK_Turn_R_D'];
$BK_Turn_EO_D=$crow['BK_Turn_EO_D'];
$BK_Turn_RE_D=$crow['BK_Turn_RE_D'];
$BK_Turn_ROU_D=$crow['BK_Turn_ROU_D'];
$TN_Turn_OU_D=$crow['TN_Turn_OU_D'];
$TN_Turn_R_D=$crow['TN_Turn_R_D'];
$TN_Turn_ROU_D=$crow['TN_Turn_ROU_D'];
$TN_Turn_RE_D=$crow['TN_Turn_RE_D'];
$TN_Turn_EO_D=$crow['TN_Turn_EO_D'];
$VB_Turn_R_D=$crow['VB_Turn_R_D'];
$VB_Turn_ROU_D=$crow['VB_Turn_ROU_D'];
$VB_Turn_RE_D=$crow['VB_Turn_RE_D'];
$VB_Turn_EO_D=$crow['VB_Turn_EO_D'];
$VB_Turn_OU_D=$crow['VB_Turn_OU_D'];
$FS_Turn_FS=$crow['FS_Turn_FS'];
$FS_FS_Scene=$crow['FS_FS_Scene'];
$FS_FS_Bet=$crow['FS_FS_Bet'];
$BS_Turn_R_A=$crow['BS_Turn_R_A'];
$BS_Turn_R_B=$crow['BS_Turn_R_B'];
$BS_Turn_R_C=$crow['BS_Turn_R_C'];
$BS_Turn_R_D=$crow['BS_Turn_R_D'];
$BS_R_Scene=$crow['BS_R_Scene'];
$BS_R_Bet=$crow['BS_R_Bet'];
$BS_Turn_OU_A=$crow['BS_Turn_OU_A'];
$BS_Turn_OU_B=$crow['BS_Turn_OU_B'];
$BS_Turn_OU_C=$crow['BS_Turn_OU_C'];
$BS_Turn_OU_D=$crow['BS_Turn_OU_D'];
$BS_OU_Scene=$crow['BS_OU_Scene'];
$BS_OU_Bet=$crow['BS_OU_Bet'];
$BS_Turn_RE_A=$crow['BS_Turn_RE_A'];
$BS_Turn_RE_B=$crow['BS_Turn_RE_B'];
$BS_Turn_RE_C=$crow['BS_Turn_RE_C'];
$BS_Turn_RE_D=$crow['BS_Turn_RE_D'];
$BS_RE_Scene=$crow['BS_RE_Scene'];
$BS_RE_Bet=$crow['BS_RE_Bet'];
$BS_Turn_ROU_A=$crow['BS_Turn_ROU_A'];
$BS_Turn_ROU_B=$crow['BS_Turn_ROU_B'];
$BS_Turn_ROU_C=$crow['BS_Turn_ROU_C'];
$BS_Turn_ROU_D=$crow['BS_Turn_ROU_D'];
$BS_ROU_Scene=$crow['BS_ROU_Scene'];
$BS_ROU_Bet=$crow['BS_ROU_Bet'];
$BS_Turn_EO_A=$crow['BS_Turn_EO_A'];
$BS_Turn_EO_B=$crow['BS_Turn_EO_B'];
$BS_Turn_EO_C=$crow['BS_Turn_EO_C'];
$BS_Turn_EO_D=$crow['BS_Turn_EO_D'];
$BS_EO_Scene=$crow['BS_EO_Scene'];
$BS_EO_Bet=$crow['BS_EO_Bet'];
$BS_Turn_M=$crow['BS_Turn_M'];
$BS_M_Scene=$crow['BS_M_Scene'];
$BS_M_Bet=$crow['BS_M_Bet'];
$BS_Turn_P=$crow['BS_Turn_P'];
$BS_P_Scene=$crow['BS_P_Scene'];
$BS_P_Bet=$crow['BS_P_Bet'];
$BS_Turn_PR=$crow['BS_Turn_PR'];
$BS_PR_Scene=$crow['BS_PR_Scene'];
$BS_PR_Bet=$crow['BS_PR_Bet'];
$BS_Turn_PD=$crow['BS_Turn_PD'];
$BS_PD_Scene=$crow['BS_PD_Scene'];
$BS_PD_Bet=$crow['BS_PD_Bet'];
$BS_Turn_T=$crow['BS_Turn_T'];
$BS_T_Scene=$crow['BS_T_Scene'];
$BS_T_Bet=$crow['BS_T_Bet'];
$langx='zh-cn';
require ("../../member/include/traditional.$langx.inc.php");
$keys=$_REQUEST['keys'];
if ($keys=='add'){

	$AddDate=date('Y-m-d H:i:s');
	$memname=$_REQUEST['username'];
	$mempasd=$_REQUEST['password'];
	$addmeney=$_REQUEST['addmeney'];
	$maxcredit=$_REQUEST['maxcredit'];
	$alias=$_REQUEST['alias'];
	$alias_tw=gb2big5($_REQUEST['alias']);
	$wager=$_REQUEST['type'];// 即时注单
	$CurType=$_REQUEST['CurType'];
	if ($agents_id==''){
		echo wterror("用户帐号不能为空，请回上一页重新输入");
		exit();
	}
		
	$username=$memname;
	$mysql="select * from web_world_data where Agname='$username'";
	$result = mysql_query($mysql);
	$count=mysql_num_rows($result);
	check_name($memname,$dbname);
	if ($count>0){
		echo wterror("您输入的帐号 $memname 已经有人使用了，请回上一页重新输入");
	}else{
    	$Winloss_S=$_REQUEST['Winloss_S'];
		$mysql="select sum(Credit) as credit from web_world_data where corprator='$agents_id'";
		$wdresult = mysql_query($mysql);
		$wdrow = mysql_fetch_array($wdresult);
		if ($wdrow['credit']+$maxcredit>$credit){
			echo wterror("此总代理商的信用额度为$maxcredit<br>目前股东最大信用额度为$credit<br>,所属总代理累计信用额度为$row[credit]<br>已超过股东信用额度，请回上一面重新输入");
			exit;
		}else{
$sql="insert into web_world_data set ";
$sql.="Agname='".$memname."',";
$sql.="Passwd='".$mempasd."',";
$sql.="Credit='".$maxcredit."',";
$sql.="Alias='".$alias."',";
$sql.="Alias_tw='".$alias_tw."',";
$sql.="corprator='".$agents_id."',";
$sql.="AddDate='".$AddDate."',";
$sql.="Winloss_C='".intval($Winloss_C)."',";
$sql.="Winloss_D='".intval($Winloss_D)."',";
$sql.="Winloss_S='".intval($Winloss_S)."',";
$sql.="super='".$agname."',";
$sql.="wager='".$wager."',";
$sql.="CurType='".$addmeney."',";
$sql.="FT_R_Scene='".$FT_R_Scene."',";
$sql.="FT_RE_Scene='".$FT_RE_Scene."',";
$sql.="FT_ROU_Scene='".$FT_ROU_Scene."',";
$sql.="FT_M_Scene='".$FT_M_Scene."',";
$sql.="FT_OU_Scene='".$FT_OU_Scene."',";
$sql.="FT_EO_Scene='".$FT_EO_Scene."',";
$sql.="FT_PD_Scene='".$FT_PD_Scene."',";
$sql.="FT_T_Scene='".$FT_T_Scene."',";
$sql.="FT_PR_Scene='".$FT_PR_Scene."',";
$sql.="FT_F_Scene='".$FT_F_Scene."',";
$sql.="FT_R_Bet='".$FT_R_Bet."',";
$sql.="FT_RE_Bet='".$FT_RE_Bet."',";
$sql.="FT_ROU_Bet='".$FT_ROU_Bet."',";
$sql.="FT_M_Bet='".$FT_M_Bet."',";
$sql.="FT_OU_Bet='".$FT_OU_Bet."',";
$sql.="FT_EO_Bet='".$FT_EO_Bet."',";
$sql.="FT_PD_Bet='".$FT_PD_Bet."',";
$sql.="FT_T_Bet='".$FT_T_Bet."',";
$sql.="FT_PR_Bet='".$FT_PR_Bet."',";
$sql.="FT_F_Bet='".$FT_F_Bet."',";
$sql.="FT_P_Scene='".$FT_P_Scene."',";
$sql.="FT_P_Bet='".$FT_P_Bet."',";
$sql.="FT_Turn_R_A='".$FT_Turn_R_A."',";
$sql.="FT_Turn_R_B='".$FT_Turn_R_B."',";
$sql.="FT_Turn_R_C='".$FT_Turn_R_C."',";
$sql.="FT_Turn_RE_A='".$FT_Turn_RE_A."',";
$sql.="FT_Turn_RE_B='".$FT_Turn_RE_B."',";
$sql.="FT_Turn_RE_C='".$FT_Turn_RE_C."',";
$sql.="FT_Turn_ROU_A='".$FT_Turn_ROU_A."',";
$sql.="FT_Turn_ROU_B='".$FT_Turn_ROU_B."',";
$sql.="FT_Turn_ROU_C='".$FT_Turn_ROU_C."',";
$sql.="FT_Turn_M='".$FT_Turn_M."',";
$sql.="FT_Turn_PD='".$FT_Turn_PD."',";
$sql.="FT_Turn_T='".$FT_Turn_T."',";
$sql.="FT_Turn_F='".$FT_Turn_F."',";
$sql.="FT_Turn_P='".$FT_Turn_P."',";
$sql.="FT_Turn_PR='".$FT_Turn_PR."',";
$sql.="TN_Turn_R_A='".$TN_Turn_R_A."',";
$sql.="TN_Turn_R_B='".$TN_Turn_R_B."',";
$sql.="TN_Turn_R_C='".$TN_Turn_R_C."',";
$sql.="TN_Turn_OU_A='".$TN_Turn_OU_A."',";
$sql.="TN_Turn_OU_B='".$TN_Turn_OU_B."',";
$sql.="TN_Turn_OU_C='".$TN_Turn_OU_C."',";
$sql.="TN_Turn_ROU_A='".$TN_Turn_ROU_A."',";
$sql.="TN_Turn_ROU_B='".$TN_Turn_ROU_B."',";
$sql.="TN_Turn_ROU_C='".$TN_Turn_ROU_C."',";
$sql.="TN_Turn_RE_A='".$TN_Turn_RE_A."',";
$sql.="TN_Turn_RE_B='".$TN_Turn_RE_B."',";
$sql.="TN_Turn_RE_C='".$TN_Turn_RE_C."',";
$sql.="TN_Turn_EO_A='".$TN_Turn_EO_A."',";
$sql.="TN_Turn_EO_B='".$TN_Turn_EO_B."',";
$sql.="TN_Turn_EO_C='".$TN_Turn_EO_C."',";
$sql.="TN_Turn_M='".$TN_Turn_M."',";
$sql.="TN_Turn_T='".$TN_Turn_T."',";
$sql.="TN_Turn_PD='".$TN_Turn_PD."',";
$sql.="TN_Turn_F='".$TN_Turn_F."',";
$sql.="TN_Turn_PR='".$TN_Turn_PR."',";
$sql.="TN_Turn_P='".$TN_Turn_P."',";
$sql.="VB_Turn_R_A='".$VB_Turn_R_A."',";
$sql.="VB_Turn_R_B='".$VB_Turn_R_B."',";
$sql.="VB_Turn_R_C='".$VB_Turn_R_C."',";
$sql.="VB_Turn_OU_A='".$VB_Turn_OU_A."',";
$sql.="VB_Turn_OU_B='".$VB_Turn_OU_B."',";
$sql.="VB_Turn_OU_C='".$VB_Turn_OU_C."',";
$sql.="VB_Turn_ROU_A='".$VB_Turn_ROU_A."',";
$sql.="VB_Turn_ROU_B='".$VB_Turn_ROU_B."',";
$sql.="VB_Turn_ROU_C='".$VB_Turn_ROU_C."',";
$sql.="VB_Turn_RE_A='".$VB_Turn_RE_A."',";
$sql.="VB_Turn_RE_B='".$VB_Turn_RE_B."',";
$sql.="VB_Turn_RE_C='".$VB_Turn_RE_C."',";
$sql.="VB_Turn_EO_A='".$VB_Turn_EO_A."',";
$sql.="VB_Turn_EO_B='".$VB_Turn_EO_B."',";
$sql.="VB_Turn_EO_C='".$VB_Turn_EO_C."',";
$sql.="VB_Turn_M='".$VB_Turn_M."',";
$sql.="VB_Turn_T='".$VB_Turn_T."',";
$sql.="VB_Turn_PD='".$VB_Turn_PD."',";
$sql.="VB_Turn_F='".$VB_Turn_F."',";
$sql.="VB_Turn_PR='".$VB_Turn_PR."',";
$sql.="VB_Turn_P='".$VB_Turn_P."',";
$sql.="VB_R_Bet='".$VB_R_Bet."',";
$sql.="VB_RE_Bet='".$VB_RE_Bet."',";
$sql.="VB_ROU_Bet='".$VB_ROU_Bet."',";
$sql.="VB_OU_Bet='".$VB_OU_Bet."',";
$sql.="VB_M_Bet='".$VB_M_Bet."',";
$sql.="VB_T_Bet='".$VB_T_Bet."',";
$sql.="VB_EO_Bet='".$VB_EO_Bet."',";
$sql.="VB_P_Bet='".$VB_P_Bet."',";
$sql.="VB_PR_Bet='".$VB_PR_Bet."',";
$sql.="VB_PD_Bet='".$VB_PD_Bet."',";
$sql.="VB_F_Bet='".$VB_F_Bet."',";
$sql.="VB_R_Scene='".$VB_R_Scene."',";
$sql.="VB_OU_Scene='".$VB_OU_Scene."',";
$sql.="VB_RE_Scene='".$VB_RE_Scene."',";
$sql.="VB_ROU_Scene='".$VB_ROU_Scene."',";
$sql.="VB_M_Scene='".$VB_M_Scene."',";
$sql.="VB_EO_Scene='".$VB_EO_Scene."',";
$sql.="VB_T_Scene='".$VB_T_Scene."',";
$sql.="VB_PD_Scene='".$VB_PD_Scene."',";
$sql.="VB_F_Scene='".$VB_F_Scene."',";
$sql.="VB_P_Scene='".$VB_P_Scene."',";
$sql.="VB_PR_Scene='".$VB_PR_Scene."',";
$sql.="FT_Turn_EO_A='".$FT_Turn_EO_A."',";
$sql.="FT_Turn_EO_B='".$FT_Turn_EO_B."',";
$sql.="FT_Turn_EO_C='".$FT_Turn_EO_C."',";
$sql.="FT_Turn_OU_A='".$FT_Turn_OU_A."',";
$sql.="FT_Turn_OU_B='".$FT_Turn_OU_B."',";
$sql.="FT_Turn_OU_C='".$FT_Turn_OU_C."',";
$sql.="BK_Turn_R_A='".$BK_Turn_R_A."',";
$sql.="BK_Turn_R_B='".$BK_Turn_R_B."',";
$sql.="BK_Turn_R_C='".$BK_Turn_R_C."',";
$sql.="BK_Turn_EO_A='".$BK_Turn_EO_A."',";
$sql.="BK_Turn_EO_B='".$BK_Turn_EO_B."',";
$sql.="BK_Turn_EO_C='".$BK_Turn_EO_C."',";
$sql.="BK_Turn_OU_A='".$BK_Turn_OU_A."',";
$sql.="BK_Turn_OU_B='".$BK_Turn_OU_B."',";
$sql.="BK_Turn_OU_C='".$BK_Turn_OU_C."',";
$sql.="BK_Turn_RE_A='".$BK_Turn_RE_A."',";
$sql.="BK_Turn_RE_B='".$BK_Turn_RE_B."',";
$sql.="BK_Turn_RE_C='".$BK_Turn_RE_C."',";
$sql.="BK_Turn_ROU_A='".$BK_Turn_ROU_A."',";
$sql.="BK_Turn_ROU_B='".$BK_Turn_ROU_B."',";
$sql.="BK_Turn_ROU_C='".$BK_Turn_ROU_C."',";
$sql.="BK_RE_Scene='".$BK_RE_Scene."',";
$sql.="BK_ROU_Scene='".$BK_ROU_Scene."',";
$sql.="BK_RE_Bet='".$BK_RE_Bet."',";
$sql.="BK_ROU_Bet='".$BK_ROU_Bet."',";
$sql.="BK_Turn_PR='".$BK_Turn_PR."',";
$sql.="BK_R_Scene='".$BK_R_Scene."',";
$sql.="BK_EO_Scene='".$BK_EO_Scene."',";
$sql.="BK_OU_Scene='".$BK_OU_Scene."',";
$sql.="BK_PR_Scene='".$BK_PR_Scene."',";
$sql.="BK_R_Bet='".$BK_R_Bet."',";
$sql.="BK_EO_Bet='".$BK_EO_Bet."',";
$sql.="BK_OU_Bet='".$BK_OU_Bet."',";
$sql.="BK_PR_Bet='".$BK_PR_Bet."',";
$sql.="TN_R_Scene='".$TN_R_Scene."',";
$sql.="TN_OU_Scene='".$TN_OU_Scene."',";
$sql.="TN_RE_Scene='".$TN_RE_Scene."',";
$sql.="TN_ROU_Scene='".$TN_ROU_Scene."',";
$sql.="TN_EO_Scene='".$TN_EO_Scene."',";
$sql.="TN_M_Scene='".$TN_M_Scene."',";
$sql.="TN_PR_Scene='".$TN_PR_Scene."',";
$sql.="TN_P_Scene='".$TN_P_Scene."',";
$sql.="TN_PD_Scene='".$TN_PD_Scene."',";
$sql.="TN_T_Scene='".$TN_T_Scene."',";
$sql.="TN_F_Scene='".$TN_F_Scene."',";
$sql.="TN_R_Bet='".$TN_R_Bet."',";
$sql.="TN_OU_Bet='".$TN_OU_Bet."',";
$sql.="TN_RE_Bet='".$TN_RE_Bet."',";
$sql.="TN_ROU_Bet='".$TN_ROU_Bet."',";
$sql.="TN_EO_Bet='".$TN_EO_Bet."',";
$sql.="TN_M_Bet='".$TN_M_Bet."',";
$sql.="TN_PR_Bet='".$TN_PR_Bet."',";
$sql.="TN_P_Bet='".$TN_P_Bet."',";
$sql.="TN_PD_Bet='".$TN_PD_Bet."',";
$sql.="TN_T_Bet='".$TN_T_Bet."',";
$sql.="TN_F_Bet='".$TN_F_Bet."',";
$sql.="FT_Turn_OU_D='".$FT_Turn_OU_D."',";
$sql.="FT_Turn_R_D='".$FT_Turn_R_D."',";
$sql.="FT_Turn_ROU_D='".$FT_Turn_ROU_D."',";
$sql.="FT_Turn_RE_D='".$FT_Turn_RE_D."',";
$sql.="FT_Turn_EO_D='".$FT_Turn_EO_D."',";
$sql.="BK_Turn_OU_D='".$BK_Turn_OU_D."',";
$sql.="BK_Turn_R_D='".$BK_Turn_R_D."',";
$sql.="BK_Turn_EO_D='".$BK_Turn_EO_D."',";
$sql.="BK_Turn_RE_D='".$BK_Turn_RE_D."',";
$sql.="BK_Turn_ROU_D='".$BK_Turn_ROU_D."',";
$sql.="TN_Turn_OU_D='".$TN_Turn_OU_D."',";
$sql.="TN_Turn_R_D='".$TN_Turn_R_D."',";
$sql.="TN_Turn_ROU_D='".$TN_Turn_ROU_D."',";
$sql.="TN_Turn_RE_D='".$TN_Turn_RE_D."',";
$sql.="TN_Turn_EO_D='".$TN_Turn_EO_D."',";
$sql.="VB_Turn_R_D='".$VB_Turn_R_D."',";
$sql.="VB_Turn_ROU_D='".$VB_Turn_ROU_D."',";
$sql.="VB_Turn_RE_D='".$VB_Turn_RE_D."',";
$sql.="VB_Turn_EO_D='".$VB_Turn_EO_D."',";
$sql.="VB_Turn_OU_D='".$VB_Turn_OU_D."',";
$sql.="FS_Turn_FS='".$FS_Turn_FS."',";
$sql.="FS_FS_Scene='".$FS_FS_Scene."',";
$sql.="FS_FS_Bet='".$FS_FS_Bet."',";
$sql.="BS_Turn_R_A='".$BS_Turn_R_A."',";
$sql.="BS_Turn_R_B='".$BS_Turn_R_B."',";
$sql.="BS_Turn_R_C='".$BS_Turn_R_C."',";
$sql.="BS_Turn_R_D='".$BS_Turn_R_D."',";
$sql.="BS_R_Scene='".$BS_R_Scene."',";
$sql.="BS_R_Bet='".$BS_R_Bet."',";
$sql.="BS_Turn_OU_A='".$BS_Turn_OU_A."',";
$sql.="BS_Turn_OU_B='".$BS_Turn_OU_B."',";
$sql.="BS_Turn_OU_C='".$BS_Turn_OU_C."',";
$sql.="BS_Turn_OU_D='".$BS_Turn_OU_D."',";
$sql.="BS_OU_Scene='".$BS_OU_Scene."',";
$sql.="BS_OU_Bet='".$BS_OU_Bet."',";
$sql.="BS_Turn_RE_A='".$BS_Turn_RE_A."',";
$sql.="BS_Turn_RE_B='".$BS_Turn_RE_B."',";
$sql.="BS_Turn_RE_C='".$BS_Turn_RE_C."',";
$sql.="BS_Turn_RE_D='".$BS_Turn_RE_D."',";
$sql.="BS_RE_Scene='".$BS_RE_Scene."',";
$sql.="BS_RE_Bet='".$BS_RE_Bet."',";
$sql.="BS_Turn_ROU_A='".$BS_Turn_ROU_A."',";
$sql.="BS_Turn_ROU_B='".$BS_Turn_ROU_B."',";
$sql.="BS_Turn_ROU_C='".$BS_Turn_ROU_C."',";
$sql.="BS_Turn_ROU_D='".$BS_Turn_ROU_D."',";
$sql.="BS_ROU_Scene='".$BS_ROU_Scene."',";
$sql.="BS_ROU_Bet='".$BS_ROU_Bet."',";
$sql.="BS_Turn_EO_A='".$BS_Turn_EO_A."',";
$sql.="BS_Turn_EO_B='".$BS_Turn_EO_B."',";
$sql.="BS_Turn_EO_C='".$BS_Turn_EO_C."',";
$sql.="BS_Turn_EO_D='".$BS_Turn_EO_D."',";
$sql.="BS_EO_Scene='".$BS_EO_Scene."',";
$sql.="BS_EO_Bet='".$BS_EO_Bet."',";
$sql.="BS_Turn_M='".$BS_Turn_M."',";
$sql.="BS_M_Scene='".$BS_M_Scene."',";
$sql.="BS_M_Bet='".$BS_M_Bet."',";
$sql.="BS_Turn_P='".$BS_Turn_P."',";
$sql.="BS_P_Scene='".$BS_P_Scene."',";
$sql.="BS_P_Bet='".$BS_P_Bet."',";
$sql.="BS_Turn_PR='".$BS_Turn_PR."',";
$sql.="BS_PR_Scene='".$BS_PR_Scene."',";
$sql.="BS_PR_Bet='".$BS_PR_Bet."',";
$sql.="BS_Turn_PD='".$BS_Turn_PD."',";
$sql.="BS_PD_Scene='".$BS_PD_Scene."',";
$sql.="BS_PD_Bet='".$BS_PD_Bet."',";
$sql.="BS_Turn_T='".$BS_Turn_T."',";
$sql.="BS_T_Scene='".$BS_T_Scene."',";
$sql.="BS_T_Bet ='".$BS_T_Bet ."'";
			mysql_query($sql) or die ("操作失败!");
			$mysql="update web_corprator_data set AgCount =AgCount +1 where agname='$agents_id'";
			mysql_query($mysql) or die ("操作失败!");
			//开始
	$loginfo='增加总代理商'.$memname.'成功';
$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','2')";
mysql_query($mysql);
//结束
			echo "<script languag='JavaScript'>self.location='body_super_agents.php?uid=$uid'</script>";
		}	
	}
}
?>
<html style="width: 98%;margin: 0 auto;">
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_ag_ed {  background-color: #baccc1; text-align: right}
-->
</style>
<SCRIPT>
function LoadBody(){
document.all.num_1.selectedIndex=document.all.num_1[0];
document.all.num_2.selectedIndex=document.all.num_2[0];
document.all.num_3.selectedIndex=document.all.num_3[0];
document.all.num_4.selectedIndex=document.all.num_4[0];
document.all.keys.value = '';
}
function SubChk()
{
if(document.all.agents_id.value=='')
{ document.all.agents_id.focus(); alert("<?=$mem_selcorprator?>"); return false; }
if(document.all.num_1.value=='')
{ document.all.num_1.focus(); alert("<?=$mem_alert1?>"); return false; }
if(document.all.num_2.value=='')
{ document.all.num_2.focus(); alert("<?=$mem_alert1?>"); return false; }
if(document.all.num_3.value=='')
{ document.all.num_3.focus(); alert("<?=$mem_alert1?>"); return false; }
if(document.all.num_4.value=='')
{ document.all.num_4.focus(); alert("<?=$mem_alert1?>"); return false; }
 if(document.all.password.value=='')
 { document.all.password.focus(); alert("<?=$mem_alert5?>"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("<?=$mem_alert6?>"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("<?=$mem_alert7?>"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("<?=$mem_alert16?>"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("<?=$mem_alert9?>"); return false; }

 document.all.keys.value = 'add';
 if(!confirm("<?=$mem_alert19?>"))
 {
  return false;
 }
 document.all.username.value = document.all.ag_count.innerHTML;
}

function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
}
function show_count(w,s) {
	//alert(w+' - '+s);
	var org_str=document.all.ag_count.innerHTML
	if (s!=''){
		switch(w){
			case 0:	document.all.ag_count.innerHTML = s.substr(1,5)+org_str.substr(4,4);break;
			case 1:document.all.ag_count.innerHTML = org_str.substr(0,3)+s+org_str.substr(4,3);break;
			case 2:document.all.ag_count.innerHTML = org_str.substr(0,4)+s+org_str.substr(5,2);break;
			case 3:document.all.ag_count.innerHTML = org_str.substr(0,5)+s+org_str.substr(6,1);break;
			case 4:document.all.ag_count.innerHTML = org_str.substr(0,6)+s;break;
		}
	}
}
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="LoadBody();">
 <FORM NAME="myFORM" ACTION="" METHOD=POST onSubmit="return SubChk()">
 <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$agid?>">
 <input TYPE=HIDDEN NAME="keys" VALUE="<?=$keys?>">
 <input TYPE=HIDDEN NAME="username" VALUE="">
 <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
 <input TYPE=HIDDEN NAME="Agname" VALUE="<?=$Agname?>">
 <input type="hidden" name="checkpay" value="Y">
  <input TYPE=HIDDEN NAME="addmeney" VALUE="<?=$addmeney?>">
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td class="m_tline">&nbsp;&nbsp;&nbsp;&nbsp;<?=$mnu_world?>--<?=$mem_addnewuser?>&nbsp;&nbsp;
      <select name="agents_id" class="za_select"  onChange="self.myFORM.submit();">
          <option value=""></option>
          	<?
			$mysql="select ID,Agname from web_corprator_data where Status=1";
			$ag_result = mysql_query( $mysql);
			while ($ag_row = mysql_fetch_array($ag_result)){
				if ($agents_id==$ag_row['Agname']){
						echo "<option value=".$ag_row['Agname']." selected>".$ag_row['Agname']."</option>";				
						$sel_agents=$ag_row['Agname'];
					}else{
						echo "<option value=".$ag_row['Agname'].">".$ag_row['Agname']."</option>";
					
					}
			}
			?>
        </select></td>
	<td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table width="770" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td colspan="2" ><?=$mem_accset?></td>
  </tr>
  <tr class="m_bc_ed"> 
      <td width="120" class="m_ag_ed"> <?=$sub_user?>:<font id=ag_count><?=substr($agents_id,0,3)?>____</font></td>
      <td>
	  <select size="1" name="num_1" style="border-style: solid; border-width: 0" onChange="show_count(1,this.value);" class="za_select_t">
                <option value=""></option>
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
		</select>
              <select size="1" name="num_2" style="border-style: solid; border-width: 0" onChange="show_count(2,this.value);" class="za_select_t">
                <option value=""></option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>
              <select size="1" name="num_3" style="border-style: solid; border-width: 0" onChange="show_count(3,this.value);" class="za_select_t">
                <option value=""></option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>
			  <select size="1" name="num_4" style="border-style: solid; border-width: 0" onChange="show_count(4,this.value);" class="za_select_t">
                <option value=""></option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select> <?=$mem_user?>
      </td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed"><?=$sub_pass?>:</td>
      <td> 
        <input type=PASSWORD name="password" value="" size=8 maxlength=8 class="za_text"> <?=$mem_pasread?>
      </td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed"><?=$acc_repasd?>:</td>
      <td> 
        <input type=PASSWORD name="repassword" value="" size=8 maxlength=8 class="za_text">
      </td>
  </tr>
  <tr class="m_bc_ed"> 
    <td class="m_ag_ed"><?=$cor_namewld?>:</td>
      <td> 
        <input type=TEXT name="alias" value="" size=10 maxlength=10 class="za_text">
      </td>
  </tr>
</table>
  <table width="770" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit"> 
      <td colspan="2" >
        <?=$mem_betset?>      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_ag_ed"><?=$real_wager?>
        :</td>
      <td><select id="type" name="type" class="za_select">
	     <option value="1">
          <?=$mem_enable?>
          </option>
          <option value="0">
          <?=$mem_disable?>
          </option>

        </select>      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_ag_ed"><?=$rag_current?>
        :</td>
      <td><?=$addmeney?></td>
    </tr>
    <tr class="m_bc_ed">
      <td width="120" class="m_ag_ed"><?=$mem_maxcredit?>
:</td>
      <td width="657"><input type=TEXT name="maxcredit" value="" size=10 maxlength=10 class="za_text">&nbsp;&nbsp;
<?php
$echostr = "$agents_id 的总信用额度:{$crow[Credit]} &nbsp; &nbsp; 已用: 可用:";
echo $echostr;
?>
 </td>
    </tr>
    <tr class=m_bc_ed>
      <td class=m_ag_ed><?=$wld_percent2?>
        :</td>
      <td><select name=Winloss_S id="Winloss_S">
          <?
	$abcd=100-$Winloss_D-$Winloss_C;
	for($i=$abcd;$i>=0;$i=$i-5){
		$abc=$abcd-$i;
		if ($i==0){
			echo "<option value=$abc selected>".($i/10).$wor_percent."</option>\n";
		}else{
			echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";
		}
	}
	?>
              </select>      </TD>
    </TR>
  </table>
  <table width="770" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr align="center" bgcolor="#FFFFFF"> 
      <td align="center"> 
        <input type=SUBMIT name="OK" value="<?=$submit_ok?>" class="za_button">
        &nbsp;&nbsp; &nbsp; 
        <input type=BUTTON name="FormsButton2" value="<?=$submit_cancle?>" id="FormsButton2" onClick="javascript:history.go(-1)" class="za_button">
      </td>
    </tr>
  </table>
</form>
</body>
</html>
