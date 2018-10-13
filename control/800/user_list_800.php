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

$loginname=$_SESSION["loginname"];
require ("../../member/include/traditional.zh-cn.inc.php");
$uid=$_REQUEST["uid"];
$sql = "select id,agname from web_sytnet where uid='".$uid."' and status<>'0'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
  echo "<script>window.open('/index.php','_top')</script>";
  exit;
}
else{
	$name=$row['agname'];
}
$active=$_REQUEST['active'];
$memname=$_REQUEST['mid'];
//echo $memname;
$id=$_REQUEST['id'];
$gold=abs($_REQUEST['gold']);
$rtype=$_REQUEST['type'];
$date_start=$_REQUEST['date_start'];
$date_end=$_REQUEST['date_end'];
$page=$_REQUEST["page"];
if ($memname==''){
	$mem="";
}else{
	$mem="and sys800.memname='$memname'";
}
if ($date_start==''){
	$date_start=date('Y-m-d');
}
if ($date_end==''){
	$date_end=date('Y-m-d');
}
if ($rtype==''){
	$type="";
}else{
	$type="and sys800.type='$rtype'";
}
if ($page==''){
	$page=0;
}
$date=date('Y-m-d H:i:s');
if ($active=='Y'){
	$mysql="select `type` from sys800 where ID=".$id;
	$rs=mysql_query($mysql);
	$rows=@mysql_fetch_array($rs);
	if($rows['type']!='T'){
		$mysql="update web_member set Money=Money+$gold,Credit=Credit+$gold where Memname='".$memname."'";
		mysql_query($mysql);
	}
	$mysql="update sys800 set checked=1,user='$name',date='$date' where id=".$id;
	mysql_query($mysql);
}else if ($active=='N'){
	$mysql="delete from sys800 where id=".$id;
	mysql_query($mysql);
}

	$sql="select sys800.*,web_member.money from sys800,web_member where sys800.Memname=web_member.Memname ".$mem.$type." and sys800.inDate>='$date_start' and sys800.inDate<='$date_end' order by id desc";

//echo $sql;
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
$page_size=50;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
//echo $mysql;
$result = mysql_query($mysql);
if ($cou==0){
	$page_count=1;
}
?>
<html style="width: 98%;margin: 0 auto;">
<head>
<title>800系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
<script language="JavaScript" src="/js/agents/simplecalendar.js"></script>
<link rel="stylesheet" href="/style/agents/control_800main.css" type="text/css">
<link rel="stylesheet" href="/style/agents/control_calendar.css">
<style type="text/css">
<!--
.m_rig2 { background-color: #CCCCCC; text-align: right}
-->
</style>
</head>
<!--<base target="net_ctl_main">
<base target="_top">-->
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="D8B20C" alink="D8B20C" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div id="Layer1" style="position:absolute; left:0px; top:17px; width:65px; height:40px; z-index:1; visibility: hidden" onMouseOver="MM_showHideLayers('Layer1','','show')" 

onMouseOut="MM_showHideLayers('Layer1','','hide')"> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" >
    <tr> 
      <td  class="mou"><a href="user_list_800.php?uid=<?=$uid?>&langx=<?=$langx?>">帐户查询</a></td>
    </tr>
    <tr> 
      <td class="mou"  ><a href="user_edit_800.php?uid=<?=$uid?>&langx=<?=$langx?>">存入帐户</a></td>
    </tr>
  </table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <FORM id="myFORM" ACTION="" METHOD=POST  name="FrmData">
  <tr> 
    <td class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr> 
		    <td width="70" >&nbsp;&nbsp;&nbsp;<a href="user_list_800.php?uid=<?=$uid?>&langx=<?=$langx?>" onMouseOver="MM_showHideLayers

('Layer1','','show')" onMouseOut="MM_showHideLayers('Layer1','','hide')"><font color="#990000">帐户作业</font></a></td>
            <td width="50" >&nbsp;&nbsp;帐户别:</td>
            <td width="49"> 
		<select name="mid" class="za_select">
		<option value="">全部</option>
<?
$msql = "select Memname,curtype from web_member where  Pay_Type=1";
$mresult = mysql_query($msql);
while ($mrow = mysql_fetch_array($mresult)){
	echo "<option value=$mrow[Memname]>".$mrow['Memname']."==".$mrow['curtype']."</option>";
}
?>              </select>
            </td>
            <td width="68">&nbsp;--&nbsp;日期区间:</td>
            <td>
              <input type=TEXT name="date_start" size=10 maxlength=11 class="za_text" value="<?=$date_start?>">
              &nbsp;</td>
            <td><a href="javascript:void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) 

calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_start',true,'yyyy-mm-dd'); return false;"><img src="/images/agents/top/calendar.gif" 

name="imgCalendar" width="34" height="21" border="0"></a>&nbsp;</td>
            <td>~&nbsp;</td>
            <td>
              <input type=TEXT name="date_end" size=10 maxlength=10 class="za_text" value="<?=$date_end?>">
              &nbsp;</td>
            <td><a href="javascript:void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) 

calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_end',true,'yyyy-mm-dd'); return false;"><img src="/images/agents/top/calendar.gif" 

name="imgCalendar" width="34" height="21" border="0"></a>&nbsp;</td>
            <td width="70">&nbsp;--&nbsp;审核方式:</td>
            <td>
              <select name="type" class="za_select">
			  <option value="">全部</option>
			  <option value="S">存入</option>
			  <option value="T">提出</option>
			  <option value="O">下注</option>
			  <option value="W">赢</option>
			  <option value="L">输</option>
			  <option value="N">和局</option>
			  <option value="M">修正</option>

              </select>
            </td>
            <td > &nbsp; 
              <input type=SUBMIT name="SUBMIT" value="查询" class="za_button">
            </td>
            <td width="58">&nbsp;--&nbsp;总页数:</td>
            <td> 
              <select id="page" name="page"  class="za_select" onChange="self.myFORM.submit()">
              <?
		      if ($page_count==0){
			      $page_count=1;
			  }
		      for($i=0;$i<$page_count;$i++){
			      echo "<option value='$i'>".($i+1)."</option>";
		       }
		      ?>
              </select>
            </td>
            <td> / <?=$page_count?> 页</td>
          </tr>
        </table>
      </td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</FORM>
</table>
<table width="1087" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_top">
      <table border="0" cellspacing="0" cellpadding="0" >
        <tr> 
          <td >&nbsp;<img src="/images/agents/top/main_dot.gif" width="13" height="15">&nbsp; 
          </td>
          <td ><font color="#000099">帐户查询</font></td>
        </tr>
      </table>
    </td>
    <td width="221"><img src="/images/agents/800/800_title_p1.gif" width="221" height="31"></td>
  </tr>
</table>
<table width="1080" border="0" cellspacing="0" cellpadding="0" class="m_tab">
  <tr>
    <td>
      <table width="1080" border="1" cellspacing="2" cellpadding="0" class="m_tab_main" bordercolor="#CCCCCC">
        <tr class="m_title"> 
          <td width="80">会员帐号</td>
          <td width="90">姓名-电话</td>
          <td width="180">银行资料</td>
          <td width="50">币别</td>
          <td width="70">金额</td>
          <td width="70">用户余额</td>
          <td width="140">日期</td>
          <td width="80">审核帐号</td>
          <td width="140">审核日期</td>
          <td colspan="2">操作操作</td>
        </tr>
        <!-- BEGIN DYNAMIC BLOCK: row -->
<?
if ($cou==0){
?>
<tr class="m_cen"> 
          <td>目前没有记录</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
<?
}else{
while ($row = mysql_fetch_array($result)){
if($row['type']=='T')
{

$gold1-=$row['gold'];

}
else
{
$gold1+=$row['gold'];
}

switch($row['type']){
case 'S':
   $type='存入';
break;
case 'T':
   $type='提出';
break;
}
?>
        <form  method=post target='_self'>
        <tr class="m_cen"> 
          <td><?=$row['memname']?>&nbsp;</td>
          <td><?=$row['name']?><?=$row['notes'] ?><br><?=$row['Phone']?>&nbsp;</td>
          <td><?=$row['Bank']?><br><?=$row['Bank_Address']?><br><?=$row['Bank_Account']?>&nbsp;</td>
          <td><?=$row['curtype']?>&nbsp;</td>

          <td align="right"><font color="<?=$row['checked']!=0?"red":""?>"><?=$row['type']=='T'?"-":""?><?=abs($row['gold'])?></font>&nbsp;</td>
          <td align="right"><?=$row['money'] ?>&nbsp;</td>
          <td><?=$row['indate']?>&nbsp;</td>
<?
if ($row['checked']==0){
?>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>
<? if($row['Type']!='T'){?>
          <input type=submit name=send value='<?=$type?>审核' onClick="return confirm('确定审核此笔单')" class="za_button"><br />
          <a href="#" onClick="javascript:location.href='?id=<?=$row['id']?>&mid=<?=$row['memname']?>&gold=<?=$row['gold']?>&type=<?=$row['type']?>&uid=<?=$uid?>&active=N';"><font color="#333333">删除</font></a>

<?}else{
if($row['Gold']<0){
?>
<input type=submit name=send value='<?=$type?>审核' onClick="return confirm('确定审核此笔单')" class="za_button"><br />
          <a href="#" onClick="javascript:location.href='?id=<?=$row['id']?>&mid=<?=$row['memname']?>&gold=<?=$row['gold']?>&type=<?=$row['type']?>&uid=<?=$uid?>&active=N';"><font color="#333333">删除</font></a>
<?}else{?>
未审核
<?}}?>
		   
          <input type=hidden name=id value=<?=$row['id']?>>
          <input type=hidden name=mid value=<?=$row['memname']?>>
          <input type=hidden name=gold value=<?=$row['gold']?>>
          <input type=hidden name=type value=<?=$row['type']?>>
          <input type=hidden name=uid value=<?=$uid?>>
          <input type=hidden name=active id="active" value=Y>&nbsp;</td>
<?
}else{
?>
          <td><?=$name?>&nbsp;</td>
          <td><?=$row['date']?>&nbsp;</td>
          <td width="96"><?=$type?>&nbsp;</td>

<?
}    
?>
<?
if ($lv=='M'){    
?>
          <td width="40" bgcolor="#3366FF" style='display:none;'><a href="user_list_800.php?uid=<?=$uid?>&langx=<?=$langx?>&id=<?=$row['id']?>&active=N">删除

</a></td>
<?
}    
?>         
        </tr>
        </form>
<?
} 
}      
?>
        <!-- END DYNAMIC BLOCK: row -->
        <tr class="m_rig2"> 
          <td colspan="4" >总计</td>
          <td colspan="1" bgcolor="#990000"><font color="#FFFFFF"><?=$gold1?></font></td>
          <td colspan="6" >&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="1087" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td background="/images/agents/800/800_title_p21b.gif">&nbsp;</td>
    <td width="18"><img src="/images/agents/800/800_title_p22.gif" width="18" height="15"></td>
    <td width="200" class="m_foot">Copyrignt by SYTNET Online Corporation</td>
  </tr>
</table>
</body>
</html>