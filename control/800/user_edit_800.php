<?
Session_start();
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
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
require ("../../member/include/traditional.zh-cn.inc.php");
$sql = "select * from web_sytnet where uid='".$uid."'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
  echo "<script>window.open('/index.php','_top')</script>";
  exit;
}

$memname=$_REQUEST["UserName"];
if($memname<>''){
	$msql = "select ID,memname,Agents,world,corprator,super,Admin from web_member where memname='$memname' ";

	$result = mysql_db_query($dbname,$msql);
	$mrow = mysql_fetch_array($result);
	$agents=$mrow['Agents'];
	$world=$mrow['world'];
	$corprator=$mrow['corprator'];
	$super=$mrow['wuper'];
	$admin=$mrow['Admin'];
}
$payway=$_REQUEST["payway"];
$type=$_REQUEST["type"];
$gold=$_REQUEST["gold"];
$send_form=$_REQUEST["send_form"];

if ($send_form=='OK'){
	switch($payway){
	case 'C':
		$no=$_REQUEST[cc1]."-".$_REQUEST[cc2]."-".$_REQUEST[cc3]."-".$_REQUEST[cc4]."-".$_REQUEST[authorize];
		break;
	case 'A':
		$no=$_REQUEST[atm_no];
		break;
	case 'W':
		$no=$_REQUEST[water_no];
		break;
	}
	$adddate=date('Y-m-d');	
	$date=date('Y-m-d H:i:s');	
	if ($type=='T'){
		$money="$gold";
		$mysql="insert into sys800(payway,gold,AddDate,type,memname,agents,world,corprator,super,Admin,curtype,name,Bank_Account,checked,user,date) values ('$payway','$money','$adddate','$type','$memname','$agents','$world','$corprator','$super','$admin','RMB','$memname','$no',1,'$memname','$date')";//echo $mysql;
		mysql_db_query($dbname,$mysql);
		$mysql="update web_member set Money=(Money-$money),Credit=(Credit-$money) where Memname='".$memname."'";
		mysql_db_query($dbname,$mysql);
	}else{
		$money="$gold";
		$mysql="insert into sys800(payway,gold,AddDate,type,memname,agents,world,corprator,super,admin,curtype,name,Bank_Account) values ('$payway','$money','$adddate','$type','$memname','$agents','$world','$corprator','$super','$admin','RMB','$memname','$no')";
		mysql_db_query($dbname,$mysql);	
	}
	
	
	
	echo "<script languag='JavaScript'>self.location='user_list_800.php?uid=$uid&langx=$langx'</script>";	
}
?>

<script language=javascript>
function showParentb(){ 
  document.forms[0].Corprator.options.length=1;
  document.forms[0].Corprator.options[0].text="<?=$corprator?>";
  document.forms[0].Corprator.options[0].value="<?=$corprator?>";
}
function showParentc(){ 
  document.forms[0].World.options.length=1;
  document.forms[0].World.options[0].text="<?=$world?>";
  document.forms[0].World.options[0].value="<?=$world?>";
}
function showParentd(){ 
  document.forms[0].Agents.options.length=1;
  document.forms[0].Agents.options[0].text="<?=$agents?>";
  document.forms[0].Agents.options[0].value="<?=$agents?>";
}
</script>

<html style="width: 98%;margin: 0 auto;">
<head>
<title>800系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_800main.css" type="text/css">
</head>
<!--<base target="net_ctl_main">-->
<script language="JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
// -->

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>

<script language="JavaScript">
function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("存入金额仅能输入数字!!"); return false;}
}

function Chg_Mcy(){
curr=new Array();
curr['RMB']=1;
curr['HKD']=1.045;
curr['USD']=8.12;
curr['MYR']=2.18;
curr['SGD']=4.9;
curr['THB']=0.21;
curr['GBP']=14.5;
curr['JPY']=0.078;
curr['EUR']=9.93;
curr['IND']=0.0009;

    /*tmp=document.all.UserName.options[document.all.UserName.selectedIndex].value;
	alert(tmp);
    tmp=tmp.split("-");
	str=tmp[1];
	
	ratio=eval(curr[str]);*/
	ratio=eval(curr['RMB']);
    tmp_count=ratio*eval(document.all.gold.value);
    document.all.mcy_gold.innerHTML=tmp_count;
}

function SubChk()
{
 if (document.all.type[0].checked==true){
 if (document.all.payway[0].checked==true) //选择信用卡
 {
   if (document.all.cc1.value.length < 4)
   {
     alert('请输入信用卡号第1组数字，补满四位');
     document.all.cc1.focus();
     return false;
   }
   if (document.all.cc2.value.length < 4)
   {
     alert('请输入信用卡号第2组数字，补满四位');
     document.all.cc2.focus();
     return false;
   }
   if (document.all.cc3.value.length < 4)
   {
     alert('请输入信用卡号第3组数字，补满四位');
     document.all.cc3.focus();
     return false;
   }
   if (document.all.cc4.value.length < 4)
   {
     alert('请输入信用卡号第4组数字，补满四位');
     document.all.cc4.focus();
     return false;
   }
   if (document.all.cc5.value.length < 3)
   {
     alert('请输入信用卡号第3组数字，补满三位');
     document.all.cc5.focus();
     return false;
   }
   if (document.all.authorize.value.length==0)
   {
     alert('请输入授权码');
     document.all.authorize.focus();
     return false;
   }
 }

 if (document.all.payway[1].checked==true)//ATM
 {
   if (document.all.atm_no.value.length ==0)
   {
     alert('请输入ATM号码');
     document.all.atm_no.focus();
     return false;
   }
 }

 if (document.all.payway[2].checked==true)//水单
 {
   if (document.all.water_no.value.length ==0)
   {
     alert('请输入水单号码');
     document.all.water_no.focus();
     return false;
   }
 }
}
 if (document.all.gold.value.length==0 || document.all.gold.value==0){
     alert('请输入金额');
     document.all.gold.focus();
     return false;
 }

 if (confirm('确定 存入/提出 该帐号??'))
 {
	 return true;
 }else{
	 return false;
 }
}


</script>  
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="D8B20C" alink="D8B20C" onLoad="showParentb();showParentc();showParentd();" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div id="Layer1" style="position:absolute; left:0px; top:17px; width:65px; height:40px; z-index:1; visibility: hidden" onMouseOver="MM_showHideLayers('Layer1','','show')" onMouseOut="MM_showHideLayers('Layer1','','hide')"> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" >
    <tr> 
      <td  class="mou"><a href="user_list_800.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>">帐户查询</a></td>
    </tr>
    <tr> 
      <td class="mou"  ><a href="user_edit_800.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>">存入帐户</a></td>
    </tr>
  </table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline">&nbsp;&nbsp;&nbsp;<a href="user_edit_800.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>" onMouseOver="MM_showHideLayers('Layer1','','show')" onMouseOut="MM_showHideLayers('Layer1','','hide')"><font color="#990000">帐户作业</font></a></td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table width="770" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_top">
      <table border="0" cellspacing="0" cellpadding="0" >
        <tr> 
          <td >&nbsp;<img src="/images/agents/top/main_dot.gif" width="13" height="15">&nbsp; 
          </td>
          <td ><font color="#000099">存入帐户</font></td>
        </tr>
      </table>
    </td>
    <td width="221"><img src="/images/agents/800/800_title_p1.gif" width="221" height="31"></td>
  </tr>
</table>
<table width="770" border="0" cellspacing="0" cellpadding="0" class="m_tab">
  <tr>
    <td> 
      <form method="post" action="" onSubmit="return SubChk()">
        <table width="700" border="0" cellspacing="1" cellpadding="0" class="m_tab_main">
          <tr bgcolor="E1E1D2"> 
            <td width="110" class="m_title">存入帐号</td>
            <td>
              &nbsp;&nbsp;会员 
			  <select name="UserName"  class="za_select" onChange="showChild();showMem();Chg_Mcy();">
              <option value=''>-----</option>
			  <?
			  $msql = "select Memname,curtype from web_member where  Pay_Type=1";
			  $mresult = mysql_query($msql);
			  while ($mrow = mysql_fetch_array($mresult)){
				echo "<option value=$mrow[Memname]>".$mrow['Memname']."==".$mrow['curtype']."</option>";
				}
				?>
              </select>
            </td>
          </tr>
          <tr bgcolor="E1E1D2"> 
            <td class="m_title">付款类别</td>
            <td > 
              <table width="450" border="0" cellspacing="0" cellpadding="0" class="m_tab_main">
                <tr> 
                  <td width="12"> 
                    <input type="radio" name="payway" value="C" class="za_dot" checked>
                  </td>
                  <td width="40">信用卡</td>
                  <td> 
                    <input type="text" name="cc1" size="4" maxlength="4" class="za_text_card">
                    - 
                    <input type="text" name="cc2" size="4" maxlength="4" class="za_text_card">
                    - 
                    <input type="text" name="cc3" size="4" maxlength="4" class="za_text_card">
                    - 
                    <input type="text" name="cc4" size="4" maxlength="4" class="za_text_card">
					- 
                    <input type="text" name="cc5" size="3" maxlength="3" class="za_text_card">
                  </td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td>授权码</td>
                  <td> 
                    <input type="text" name="authorize" size="4" maxlength="4" class="za_text_card">
                  </td>
                </tr>
                <tr> 
                  <td> 
                    <input type="radio" name="payway" value="A" class="za_dot">
                  </td>
                  <td>ATM</td>
                  <td> 
                    <input type="text" name="atm_no" size="25" maxlength="20" class="za_text">
                  </td>
                </tr>
                <tr> 
                  <td> 
                    <input type="radio" name="payway" value="W" class="za_dot">
                  </td>
                  <td>水单</td>
                  <td> 
                    <input type="text" name="water_no" size="25" maxlength="16" class="za_text">
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr bgcolor="E1E1D2"> 
            <td class="m_title">方式</td>
            <td>
              <input type="radio" name="type" value="S" checked>
              存入 
              <input type="radio" name="type" value="T">
              提出 </td>
          </tr>
          <tr bgcolor="E1E1D2"> 
            <td class="m_title">金额</td>
            <td>&nbsp; 
              <input type="text" name="gold" size="10" maxlength="10" class="za_text" onKeyUp="Chg_Mcy();" onKeyPress="return CheckKey()" value="0">
              美金 :<font color=red id="mcy_gold">0</font></td>
          </tr>
          <tr bgcolor="E1E1D2"> 
            <td class="m_title">&nbsp;</td>
            <td align="center" height="30" > 
              <input type="submit" name="Submit" value="确定" class="za_button">
              &nbsp;&nbsp;&nbsp; 
              <input type="reset" name="Submit2" value="重设" class="za_button">
              <input type="hidden" name="send_form" value="OK">
              <input type="hidden" name="uid" value="<?=$uid?>">
            </td>
          </tr>
        </table>
</form>
    </td>
  </tr>
</table>
<table width="770" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td background="/images/agents/800/800_title_p21b.gif">&nbsp;</td>
    <td width="18"><img src="/images/agents/800/800_title_p22.gif" width="18" height="15"></td>
    <td width="200" class="m_foot">Copyrignt by SYTNET Online Corporation</td>
  </tr>
</table>
</body>
</html>