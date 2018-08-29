<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
require ("../../member/include/traditional.zh-cn.inc.php");
$uid			=	$_REQUEST["uid"];
$id				=	$_REQUEST["id"];
$sort			=	$_REQUEST["sort"];
$orderby	=	$_REQUEST["orderby"];
$active		=	$_REQUEST["active"]+0;
$page			=	$_REQUEST["page"]+0;
$gdate	=	$_REQUEST['gdate'];
$date_s=$_REQUEST['date_start'];
$date_e=$_REQUEST['date_end'];

$sql = "select * from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$admin_name = $row['agname'];
if(empty($gdate)){$gdate=date('Y-m-d');}
$date_start=date('Y-m-d');
$mdate=Date('Y-m-d');
if ($sort==""){
	$sort='bettime';
}

if ($orderby==""){
	$orderby='desc';
}
$gid=$_REQUEST['gid'];
$key=$_REQUEST['key'];
$enable=$_REQUEST['enable'];
$usern=$_REQUEST['username'];
//$active=$_REQUEST['active'];
$danger=$_REQUEST['danger'];
//$page=$_REQUEST["page"];
if ($enable=='')
{
$enable=0;	
}
$select=$enable;

if ($key=='cancel'){
	$id=$_REQUEST['id'];
	$pay_type=$_REQUEST['pay_type'];
	$score=$_REQUEST['score'];
	$result=-$_REQUEST['result'];
	
if ($pay_type==1){
  $rsql = "select m_result,M_Name,BetScore from web_db_io where mid='$gid' and id='$id' and pay_type=1";
  $rresult = mysql_db_query($dbname, $rsql);
  while ($rrow = mysql_fetch_array($rresult))
 {
 $username=$rrow['M_Name'];
 $usermoney=$rrow['BetScore'];
 $m_result=$rrow['m_result'];
 if ($m_result==''){
 $u_sql = "UPDATE web_member SET money=money+$usermoney where Memname='$username' and pay_type=1";
 mysql_db_query($dbname,$u_sql) or die ("操作失败!!!!");
 }
 else
	 {
$u_sql = "UPDATE web_member SET money=money-$m_result where Memname='$username' and pay_type=1";
 mysql_db_query($dbname,$u_sql) or die ("操作失败!!");
	 }
 }
 }
//结算之后的现金返回

	$sql="update web_db_io set m_result='0',a_result='0',result_a='0',result_s='0',result_c='0',cancel=1,status='$danger',danger=0 where id=$id";
	mysql_db_query($dbname, $sql) or die ("操作失败!");
	echo "<script languag='JavaScript'>self.location='/control/reallist/voucher.php?uid=$uid&date_start=$date_s&date_end=$date_e'</script>";
}
if ($key=='ok'){
$sql="update web_db_io set danger='$danger' where id=$id";
	mysql_db_query($dbname, $sql) or die ("操作失败!");
}


//恢复取消的注单
if ($key=='upd'){
	$id=$_REQUEST['id'];
	$pay_type=$_REQUEST['pay_type'];
	$score=$_REQUEST['score'];
	$result=-$_REQUEST['result'];
	
if ($pay_type==1){
  $rsql = "select m_result,M_Name,BetScore from web_db_io where mid='$gid' and id='$id' and pay_type=1";
  $rresult = mysql_db_query($dbname, $rsql);
  while ($rrow = mysql_fetch_array($rresult))
 {
 $username=$rrow['M_Name'];
 $usermoney=$rrow['BetScore'];
 $m_result=$rrow['m_result'];

 $u_sql = "UPDATE web_member SET money=money-$usermoney where Memname='$username' and pay_type=1";
 mysql_db_query($dbname,$u_sql) or die ("操作失败!");

 }
 }
//结算之后的现金返回

	$sql="update web_db_io set m_result='',a_result='',result_a='',result_s='',result_c='',cancel=0,status=0 where id=$id";
	mysql_db_query($dbname, $sql);
	echo "<script languag='JavaScript'>self.location='/control/reallist/voucher.php?uid=$uid&date_start=$date_s&date_end=$date_e'</script>";
}


switch ($active){
case 1:
	$mysql="select * from web_db_io where id='$id'";
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$middle		=	explode("<br>",$row['Middle']);
	$middle_tw	=	explode("<br>",$row['Middle_tw']);
	$middle_en	=	explode("<br>",$row['Middle_en']);

	$arr = explode('.', $row['M_Rate']);
	$ratelen = strlen($arr[1])==2 ? 2 : 3;
	$count=count($middle);
	if($count==4){
		$sid=explode('vs', $middle[1]);
		$sid=$sid[0].'vs'.$sid[1].'<br>';
		$middle1	=	$middle[0].'<br>(****)'.$middle[2].'<br>';
		$middle_tw1	=	$middle_tw[0].'<br>(****)'.$middle_tw[2].'<br>';
		$middle_en1	=	$middle_en[0].'<br>(****)'.$middle_en[2].'<br>';
		
	}else{
		$middle1	=	$middle[0].'<br>'.$middle[1].'<br>';
		$middle_tw1	=	$middle_tw[0].'<br>'.$middle_tw[1].'<br>';
		$middle_en1	=	$middle_en[0].'<br>'.$middle_en[1].'<br>';
	}
	
	switch ($row['OpenType']){
	case "A":
		$arate=1.84;
		break;
	case "B":
		$arate=1.86;
		break;
	default:
		$arate=1.90;
		break;
	}
	$arate=1.84;
	switch($row['odd_type']){
	case 'E':
		$rate=2+$arate-$row['M_Rate'];
		break;
	case 'I':
		if($row['M_Rate']>1){
			$rate=$arate-$row['M_Rate'];
		}else{
			$rate=$arate+round(1/$row['M_Rate'],$ratelen);
		}
		if($rate<1){

			$rate=-round(1/$rate,$ratelen);
		}

		break;
	case 'M':
		if($row['M_Rate']<0){
			$rate=$arate+round(1/$row['M_Rate'],$ratelen);
		}else{
			$rate=$arate-$row['M_Rate'];
			if($rate>1){
				$rate=round(-1/$rate,$ratelen);
			}
		}

		break;
	default:
		switch ($row['OpenType']){
		case "A":
			$rate=1.84-$row['M_Rate'];
			break;
		case "B":
			$rate=1.86-$row['M_Rate'];
			break;
		default:
			$rate=1.90-$row['M_Rate'];
			break;
		}

	}

	$rate = number_format($rate,$ratelen,'.','');
	$gwin = $row['BetScore']*$rate;
	switch ($row['LineType']){
	case 2:
		$gwin			=	$row['BetScore']*$rate;
		$team			=	explode("&nbsp;&nbsp;",$middle[$count-2]);
		$team_tw	=	explode("&nbsp;&nbsp;",$middle_tw[$count-2]);
		$team_en	=	explode("&nbsp;&nbsp;",$middle_en[$count-2]);

		if ($row['ShowType']=='H'){
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}else{
				$mtype='H';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}
		}else{
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}else{
				$mtype='H';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}
		}
		$team=$middle[$count-1];
		if (strstr($team,'上半')){
			if($row['Active']<>3){
				$j10='半场';
				$j10_tw='半場';
				$j10_en='1st Half';
			}else{
				$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			}
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[1st]</font>&nbsp;";
		}else if(strstr($team,'下半')){
			$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[2st]</font>&nbsp;";
		}else if(strstr($team,'第1节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第1節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第1节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q1]</font>&nbsp;";
		}else if(strstr($team,'第2节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第2節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第2节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q2]</font>&nbsp;";
		}else if(strstr($team,'第3节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第3節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第3节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q3]</font>&nbsp;";
		}else if(strstr($team,'第4节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第4節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第4节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q4]</font>&nbsp;";
		}else{
			$bottom1_tw	=	'';
			$bottom1		=	'';
			$bottom1_en	=	'';
			$j10='全场';
			$j10_tw='全場';
			$j10_en='Full';
		}
		
		$st_old='<FONT COLOR=#0000BB><b>';
		$st_new='<FONT COLOR=#CC0000><b>';
		$middle12=str_replace($st_old,$st_new,$middle1);
		$middle_tw12=str_replace($st_old,$st_new,$middle_tw1);
		$middle_en12=str_replace($st_old,$st_new,$middle_en1);
		
		$lines2		=	str_replace('(****)','',$middle12).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',$middle_tw12).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',$middle_en12).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		
		if($row['m_result']==''){
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		
		}
		
		mysql_db_query($dbname,$mysql);

		break;
	case 3:
		$row['M_Place']=str_replace('UNDER','U',strtoupper($row['M_Place']));
		$row['M_Place']=str_replace('OVER','O',strtoupper($row['M_Place']));

		$pan=substr($row['M_Place'],1,strlen($row['M_Place']));
		if ($row[Mtype]=='C'){
			$mtype			=	'H';
			$m_place		=	'小'.$pan;
			$m_place_tw	=	'小'.$pan;
			$m_place_en	=	'Under'.$pan;
		}else{
			$mtype='C';
			$m_place		=	'大'.$pan;
			$m_place_tw	=	'大'.$pan;
			$m_place_en	=	'Over'.$pan;
		}

		$team=$middle[$count-1];
		if (strstr($team,'上半')){
			if($row['Active']<>3){
				$j10='半场';
				$j10_tw='半場';
				$j10_en='1st Half';
			}else{
				$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			}
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[1st]</font>&nbsp;";
		}else if(strstr($team,'下半')){
			$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[2st]</font>&nbsp;";
		}else if(strstr($team,'第1节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第1節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第1节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q1]</font>&nbsp;";
		}else if(strstr($team,'第2节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第2節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第2节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q2]</font>&nbsp;";
		}else if(strstr($team,'第3节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第3節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第3节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q3]</font>&nbsp;";
		}else if(strstr($team,'第4节')){
		$j10='全场';
				$j10_tw='全場';
				$j10_en='Full';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第4節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第4节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q4]</font>&nbsp;";
		}else{
			$bottom1_tw	=	'';
			$bottom1		=	'';
			$bottom1_en	=	'';
			$j10='全场';
			$j10_tw='全場';
			$j10_en='Full';
		}

		$lines2		=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle1)).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_tw1)).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_en1)).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		
		
		

		if($row['m_result']==''){
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		mysql_db_query($dbname,$mysql);
		break;
	case 9:
		$team			=	explode("&nbsp;&nbsp;",$middle[$count-2]);
		$team_tw	=	explode("&nbsp;&nbsp;",$middle_tw[$count-2]);
		$team_en	=	explode("&nbsp;&nbsp;",$middle_en[$count-2]);

		if ($row['ShowType']=='H'){
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}else{
				$mtype='H';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}
		}else{
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}else{
				$mtype='H';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}
		}
		$team=$middle[$count-1];
		if (strstr($team,'上半')){
			if($row['Active']<>3){
				$j10='半场 滚球';
				$j10_tw='半場 滾球';
				$j10_en='1st Half Running Ball';
			}else{
				$j10='全场';
				$j10_tw='全場 滾球';
				$j10_en='FT.Running Ball';
			}
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[1st]</font>&nbsp;";
		}else if(strstr($team,'下半')){
			$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FT.Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[2st]</font>&nbsp;";
		}else if(strstr($team,'第1节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FT.Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第1節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第1节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q1]</font>&nbsp;";
		}else if(strstr($team,'第2节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FT.Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第2節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第2节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q2]</font>&nbsp;";
		}else if(strstr($team,'第3节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FT.Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第3節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第3节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q3]</font>&nbsp;";
		}else if(strstr($team,'第4节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FT.Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第4節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第4节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q4]</font>&nbsp;";
		}else{
			$bottom1_tw	=	'';
			$bottom1		=	'';
			$bottom1_en	=	'';
			$j10='全场 滚球';
			$j10_tw='全場 滾球';
			$j10_en='FT.Running Ball';
		}

		$st_old='<FONT COLOR=#0000BB><b>';
		$st_new='<FONT COLOR=#CC0000><b>';
		$middle12=str_replace($st_old,$st_new,$middle1);
		$middle_tw12=str_replace($st_old,$st_new,$middle_tw1);
		$middle_en12=str_replace($st_old,$st_new,$middle_en1);
		
		$lines2		=	str_replace('(****)','',$middle12).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',$middle_tw12).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',$middle_en12).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		
		
		if($row['m_result']==''){
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		
		}
		mysql_db_query($dbname,$mysql);

		break;
	case 19:
		$gwin			=	$row['BetScore']*$rate;
		$team			=	explode("&nbsp;&nbsp;",$middle[$count-2]);
		$team_tw	=	explode("&nbsp;&nbsp;",$middle_tw[$count-2]);
		$team_en	=	explode("&nbsp;&nbsp;",$middle_en[$count-2]);

		if ($row['ShowType']=='H'){
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}else{
				$mtype='H';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}
		}else{
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}else{
				$mtype='H';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}
		}
		$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[]</font>&nbsp;";
		$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
		$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[1st]</font>&nbsp;";
		$j10='半场 滚球';
		$j10_tw='半場 滾球';
		$j10_en='1st Half Running Ball';
		

		$st_old='<FONT COLOR=#0000BB><b>';
		$st_new='<FONT COLOR=#CC0000><b>';
		$middle12=str_replace($st_old,$st_new,$middle1);
		$middle_tw12=str_replace($st_old,$st_new,$middle_tw1);
		$middle_en12=str_replace($st_old,$st_new,$middle_en1);
		
		$lines2		=	str_replace('(****)','',$middle12).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',$middle_tw12).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',$middle_en12).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		if($row['m_result']==''){
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		
		}
		mysql_db_query($dbname,$mysql);
		break;
	case 10:
		$row['M_Place']=str_replace('UNDER','U',strtoupper($row['M_Place']));
		$row['M_Place']=str_replace('OVER','O',strtoupper($row['M_Place']));
		$pan=substr($row['M_Place'],1,strlen($row['M_Place']));
		if ($row[Mtype]=='C'){
			$mtype			=	'H';
			$m_place		=	'小'.$pan;
			$m_place_tw	=	'小'.$pan;
			$m_place_en	=	'Under'.$pan;
		}else{
			$mtype='C';
			$m_place		=	'大'.$pan;
			$m_place_tw	=	'大'.$pan;
			$m_place_en	=	'Over'.$pan;
		}

		$team=$middle[$count-1];
		if (strstr($team,'上半')){
			if($row['Active']<>3){
				$j10='半场 滚球';
				$j10_tw='半場 滾球';
				$j10_en='1st Half Running Ball';
			}else{
				$j10='全场';
				$j10_tw='全場 滾球';
				$j10_en='FT.Running Ball';
			}
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[1st]</font>&nbsp;";
		}else if(strstr($team,'下半')){
			$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FT.Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[下半]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[2st]</font>&nbsp;";
		}else if(strstr($team,'第1节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FT.Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第1節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第1节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q1]</font>&nbsp;";
		}else if(strstr($team,'第2节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FT.Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第2節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第2节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q2]</font>&nbsp;";
		}else if(strstr($team,'第3节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FT.Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第3節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第3节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q3]</font>&nbsp;";
		}else if(strstr($team,'第4节')){
		$j10='全场 滚球';
				$j10_tw='全場 滾球';
				$j10_en='FT.Running Ball';
			$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[第4節]</font>&nbsp;";
			$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[第4节]</font>&nbsp;";
			$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[Q4]</font>&nbsp;";
		}else{
			$bottom1_tw	=	'';
			$bottom1		=	'';
			$bottom1_en	=	'';
			$j10='全场 滚球';
			$j10_tw='全場 滾球';
			$j10_en='FT.Running Ball';
		}

		$lines2		=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle1)).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_tw1)).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_en1)).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		
		
		

		if($row['m_result']==''){
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		mysql_db_query($dbname,$mysql);
		break;
	case 30:
		$row['M_Place']=str_replace('UNDER','U',strtoupper($row['M_Place']));
		$row['M_Place']=str_replace('OVER','O',strtoupper($row['M_Place']));
		$pan=substr($row['M_Place'],1,strlen($row['M_Place']));
		if ($row[Mtype]=='C'){
			$mtype			=	'H';
			$m_place		=	'小'.$pan;
			$m_place_tw	=	'小'.$pan;
			$m_place_en	=	'Under'.$pan;
		}else{
			$mtype='C';
			$m_place		=	'大'.$pan;
			$m_place_tw	=	'大'.$pan;
			$m_place_en	=	'Over'.$pan;
		}


		$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
		$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
		$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[1st]</font>&nbsp;";
		$j10='半场 滚球';
		$j10_tw='半場 滾球';
		$j10_en='1st Half Running Ball';

		$lines2		=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle1)).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_tw1)).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_en1)).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		
		

		if($row['m_result']==''){
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		mysql_db_query($dbname,$mysql);
		break;
	case 12:
		$gwin			=	$row['BetScore']*$rate;
		$team			=	explode("&nbsp;&nbsp;",$middle[$count-2]);
		$team_tw	=	explode("&nbsp;&nbsp;",$middle_tw[$count-2]);
		$team_en	=	explode("&nbsp;&nbsp;",$middle_en[$count-2]);

		if ($row['ShowType']=='H'){
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}else{
				$mtype='H';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}
		}else{
			$mb_team=$team[0];
			$tg_team=$team[2];
			$mb_team_tw=$team_tw[0];
			$tg_team_tw=$team_tw[2];
			$mb_team_en=$team_en[0];
			$tg_team_en=$team_en[2];
			if ($row[Mtype]=='H'){
				$mtype='C';
				$m_place=$mb_team;
				$m_place_tw=$mb_team_tw;
				$m_place_en=$mb_team_en;
			}else{
				$mtype='H';
				$m_place=$tg_team;
				$m_place_tw=$tg_team_tw;
				$m_place_en=$tg_team_en;
			}
		}

		$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
		$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
		$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[1st]</font>&nbsp;";
		$j10='半场';
		$j10_tw='半場';
		$j10_en='1st Half';

		$st_old='<FONT COLOR=#0000BB><b>';
		$st_new='<FONT COLOR=#CC0000><b>';
		$middle12=str_replace($st_old,$st_new,$middle1);
		$middle_tw12=str_replace($st_old,$st_new,$middle_tw1);
		$middle_en12=str_replace($st_old,$st_new,$middle_en1);
		
		$lines2		=	str_replace('(****)','',$middle12).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',$middle_tw12).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',$middle_en12).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		
		
		
		if($row['m_result']==''){
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		
		}
		mysql_db_query($dbname,$mysql);

		break;
	case 13:
		$row['M_Place']=str_replace('UNDER','U',strtoupper($row['M_Place']));
		$row['M_Place']=str_replace('OVER','O',strtoupper($row['M_Place']));
		$pan=substr($row['M_Place'],1,strlen($row['M_Place']));
		if ($row[Mtype]=='C'){
			$mtype			=	'H';
			$m_place		=	'小'.$pan;
			$m_place_tw	=	'小'.$pan;
			$m_place_en	=	'Under'.$pan;
		}else{
			$mtype='C';
			$m_place		=	'大'.$pan;
			$m_place_tw	=	'大'.$pan;
			$m_place_en	=	'Over'.$pan;
		}


		$bottom1_tw	="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
		$bottom1		="<font color=red>-&nbsp;</font><font color=gray>[上半]</font>&nbsp;";
		$bottom1_en="<font color=red>-&nbsp;</font><font color=gray>[1st Half]</font>&nbsp;";
		$j10='半场';
		$j10_tw='半場';
		$j10_en='1st Half';
		
		
		
		$lines2		=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle1)).'<FONT color=#cc0000>'.$m_place.'</FONT>&nbsp;'.$bottom1.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_tw	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_tw1)).'<FONT color=#cc0000>'.$m_place_tw.'</FONT>&nbsp;'.$bottom1_tw.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		$lines2_en	=	str_replace('(****)','',str_replace('<FONT COLOR=#0000BB><b>vs.</b></FONT>','vs.',$middle_en1)).'<FONT color=#cc0000>'.$m_place_en.'</FONT>&nbsp;'.$bottom1_en.'@&nbsp;<FONT color=#cc0000><b>'.$rate.'</b></FONT>';
		
		
		

		if($row['m_result']==''){
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		else{
			$mysql="update web_db_io set G_Name='".$admin_name."',G_Type=3,vgold=0,m_place='$m_place_en',result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='$gwin',m_rate='$rate',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."' where id='$id'";
		}
		mysql_db_query($dbname,$mysql);

		break;
	}
	$edit = $row['edit']==1 ? 0 : 1;
	$sql = "update web_db_io set edit='$edit' where id='$id'";
	mysql_query( $sql );

	echo "<script languag='JavaScript'>self.location='voucher.php?uid=$uid&username=$username&gdate=$gdate&date_start=$date_s&date_end=$date_e'</script>";
	break;
case 2:
	$sql='update web_db_io set vgold=0,m_result=0,a_result=0,w_result=0,c_result=0,cancel=1,result_a=0,result_s=0,result_type=0 where id='.$id;
	wager_update($sql, $id);
	echo "<script languag='JavaScript'>self.location='voucher.php?uid=$uid&username=$username&gdate=$gdate&date_start=$date_s&date_end=$date_e'</script>";
	break;
case 3:
	$sql="select result_type,if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore) as betscore,m_result,m_name,pay_type from web_db_io where id=".$id;
	$result = mysql_query( $sql);
	$row = mysql_fetch_array($result);
	if ($row['pay_type']==1){
		if ($row['result_type']==0){
			$sql="update web_member set money=money+$row[betscore] where memname='".$row[m_name]."'";
		}else{
			$sql="update web_member set money=money-$row[m_result] where memname='".$row[m_name]."'";
		}
		mysql_query( $sql);
	}else{
		$sql="update web_member set money=money+$row[betscore] where memname='".$row[m_name]."'";
		mysql_query( $sql);
	}
	$mysql="delete from web_db_io where id=".$id;
	mysql_query($mysql);
	echo "<script languag='JavaScript'>self.location='voucher.php?uid=$uid&username=$username&gdate=$gdate&date_start=$date_s&date_end=$date_e'</script>";
	break;
case 4:
	
	$sql="update web_db_io set vgold=0,m_result=0,a_result=0,w_result=0,c_result=0,status=0,result_a=0,result_s=0,result_type=0 where id='$id'";

	wager_update($sql, $id);
	echo "<script languag='JavaScript'>self.location='voucher.php?uid=$uid&username=$username&gdate=$gdate&date_start=$date_s&date_end=$date_e'</script>";
	break;
case 5:
	$sql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as betscore from web_db_io where hidden=0 and id<>$id and m_name='$username' and result_type=0 and m_date='".date('Y-m-d')."'";
	$result = mysql_query( $sql);
	$row = mysql_fetch_array($result);

	$betscore=$row['betscore']+0;
	$sql="update web_member set money=money+".$betscore." where memname='$username'";
	mysql_query( $sql);

	$sql="update web_db_io set hidden=1 where id=".$id;

	mysql_query($sql);
	echo "<script languag='JavaScript'>self.location='voucher.php?uid=$uid&username=$username&gdate=$gdate&date_start=$date_s&date_end=$date_e'</script>";
	break;
case 6:
	$sql="select sum(if((odd_type='I' and m_rate<0),abs(m_rate)*betscore,betscore)) as betscore from web_db_io where hidden=0 and id<>$id and m_name='$username' and result_type=0 and m_date='".date('Y-m-d')."'";
	$result = mysql_query( $sql);
	$row = mysql_fetch_array($result);
	$betscore=$row['betscore']+0;
	$sql="update web_member set money=money-".$betscore." where memname='$username'";
	mysql_query( $sql);
	$sql="update web_db_io set hidden=0 where id=".$id;


	mysql_query($sql);
	echo "<script languag='JavaScript'>self.location='voucher.php?uid=$uid&username=$username&gdate=$gdate&date_start=$date_s&date_end=$date_e'</script>";
	break;
}

$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}else{
	if($date_s=='' and $date_e==''){
		$dat="";
	}else{
		if ($date_s==''){
			$dat=" and (M_Date='".date('Y-m-d')."' or M_Date='".date('Y-m-d' , strtotime('-1 day'))."')"; 
		}else{
			$dat=" and BetTime >='".$date_s."' and BetTime<='".$date_e."'";
		}
	}
 $sql = "select odd_type,betip,status,danger,id,M_Name,MID,TurnRate,cancel,M_Date,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime1,if((date_format(bettime,'%Y-%m-%d')<m_date and active<>3),'_re','') as style,date_format(BetTime,'%m%d%H%i%s')+id as ID,LineType,BetType,Middle,BetScore,gwin,BetType_en from web_db_io where result_type=0 ".$dat." order by ".$sort." ".$orderby;

$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
$page_size=50;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";

$result = mysql_db_query($dbname, $mysql);

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/mem_body_ft.css" type="text/css">
<link rel="stylesheet" href="/style/control/mem_body_his.css" type="text/css">
<link rel="stylesheet" href="/style/control/css.css" type="text/css">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/calendar.css">

<META content="Microsoft FrontPage 4.0" name=GENERATOR>

</head>
<script src="/js/prototype.js" type="text/javascript"></script>
<script language=javascript>
	function CheckSTOP(str)
	{
		if(confirm("确实取消/恢复本注单吗?"))
		document.location=str;
	}
	
	function reload()
{
location.reload();
}
</script>
<script> 
 window.onload = function(){
  var obj_page = document.getElementById('page');
  obj_page.value = '<?=$page?>';
  var obj_sort=document.getElementById('sort');
  obj_sort.value='<?=$sort?>';
  var obj_orderby=document.getElementById('orderby');
  obj_orderby.value='<?=$orderby?>';
 }

 function CheckSTOP(str)
{
if(confirm("确实取消本注单吗?"))
 		document.location=str;
	}
	function CheckDEL(str)
	{
		if(confirm("确实删除本注单吗?"))
		document.location=str;
	}
	function reload()
{

	self.location.href='voucher.php?uid=<?=$uid?>&sort=<?=$sort?>&orderby=<?=$orderby?>&page=<?=$page?>&date_start=<?=$date_s?>&date_end=<?=$date_e?>';
}
</script>
<!--oncontextmenu="window.event.returnValue=false
<script language="JavaScript" src="/js/simplecalendar.js"></script>"-->
<SCRIPT>window.setTimeout("self.location.href='voucher.php?uid=<?=$uid?>&sort=<?=$sort?>&orderby=<?=$orderby?>&page=<?=$page?>&date_start=<?=$date_s?>&date_end=<?=$date_e?>'", 60000);</SCRIPT>
<body  bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<form name="myFORM" method="post" action="" >
<table width="1100" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td width="3">&nbsp;
          </td>
    <td class="m_tline">下注流水 --
	  <input name=button type=button class="za_button" onClick="reload()" value="更新"></td>
    <td class="m_tline"> 排序：            <select name="sort" onChange="document.myFORM.submit();" class="za_select">
            <option value="bettime">投注时间</option>
            <option value="betscore">投注金额</option>
            <option value="m_name">会员名称</option>
            <option value="bettype">投注种类</option>

          </select>
              <select name="orderby" onChange="self.myFORM.submit()" class="za_select">
            <option value="asc">升序(由小到大)</option>
            <option value="desc">降序(由大到小)</option>
          </select>
		  
			</td>
	  <td class="m_tline"> 时间段查询：
	  </td>
	   <td class="m_tline"> 
              <input type=TEXT name="date_start" value="<?=$date_s?>" size=19 maxlength=19 title="格式：2012-12-12 00:00:00 (年-月-日 时:分:秒)" class="za_text">&nbsp;
            </td>
           
            <td width="20" align="center" class="m_tline">至</td>
            <td class="m_tline"> 
              <input type=TEXT name="date_end" value="<?=$date_e?>" size=19 maxlength=19 title="格式：2012-12-12 00:00:00 (年-月-日 时:分:秒);" class="za_text">&nbsp;
            </td>
            
	  <td class="m_tline"><input type=SUBMIT name="SUBMIT" value="查询" class="za_button"></td>
      <td class="m_tline" align="right">显示第1-50条记录，共 <?=$cou?> 条记录　到第 <select name='page' onChange="self.myFORM.submit()">
		<?
		if ($page_count==0){$page_count=1;}
		for($i=0;$i<$page_count;$i++){
			if ($i==$page){
				echo "<option selected value='$i'>".($i+1)."</option>";
			}else{
				echo "<option value='$i'>".($i+1)."</option>";
			}
		}
		?></select>
页，共 <?=$page_count?> 页 </td>
    <td width="33"><img src="/images/control/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="3" height="4"></td>
  </tr>
</table>
<table width="1000" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">
        <tr class="m_title_ft">
          <td width="100">投注时间</td>
          <td width="100">用户名称</td>
          <td width="220" align="center">球赛种类</td>
          <td width="400" align="center">內容</td>
          <td width="90" align="center">投注</td>
          <td width="90" align="center">可赢金额</td>
		  <td width="100" align="center">功能</td>
        </tr>
<?
while ($row = mysql_fetch_array($result)){
	
	echo '<tr class="m_rig'.$row['style'].'">
          <td align="center">';
	if($row['danger']>0){
		echo '<font color=#ffffff style=background-color:#ff0000>'.$row['BetTime1'].'</font>';
	}else{
		echo $row['BetTime1'];
	}
	
	echo '<br><b><font color=blue>'.$row['betip'].'<font></b><br>';//.$row['MID'];

	/*if(count(explode('Soccer<br>',$row['BetType_en']))>1){
		$msql="select * from foot_match where mid='".$row['MID']."'";
		$resultm = mysql_db_query($dbname,$msql);
		$rowm=mysql_fetch_array($resultm);
		
		if(strpos($rowm['M_Time'],':')==false and $rowm['RE_Show']==1){
			if($rowm['M_Time']=='H/T'){
				$rowm['M_Time']='中场';
			}
			echo '<font color=red size=2>走&nbsp;'.$rowm['M_Time'].'</font>';
		}
	}*/
 	
?>
</td>
	  <!--td align="center"><?=show_voucher($row['LineType'],$row['ID'])?></td-->
          <td align="center"><?=$row['M_Name']?>&nbsp;&nbsp;<font color="#cc0000"> <?=$row['TurnRate']?></font><br><?=show_voucher($row['LineType'],$row['ID'])?><br><font color=green><?=$ODDS[$row['odd_type']]?></font></td>
          <td align="center"><?=str_replace(" ","",$row['BetType']);?>
<?
switch($row['danger']){
case 1:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认中&nbsp;</b></font></font>';
	break;
case 2:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>未确认</b></font></font>';
	break;
case 3:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认&nbsp;</b></font></font>';
	break;
default:
	break;
}
?>
</td>
          <td align="right"><?=$row['ShowTop'];?><?=$row['Middle'];?></td>
          <td align="center"><?
    	if($row['status']>0){
    		echo '<s>'.number_format($row['BetScore'],1).'</s>';
    	}else{
    		echo number_format($row['BetScore'],1);
    	}?></td>

      <td align="center">
      	<?
    	if($row['status']>0){
    		echo '<b><font color=red>['.$wager_vars_re[$row['status']].']</td>';
    	}else{
    		echo number_format($row['gwin'],1);
    	}?>
		</td>
      <?
//}
?>
 <td width="243"><div align="center">
<?
$url="voucher.php?uid=$uid&id=".$row[id]."&active=1&username=".$row['M_Name']."&date_start=".$date_s."&date_end=".$date_e;
if ($row['cancel']==0){
?>
<a href="../reallist/report/js.php?uid=<?=$uid?>&name=<?=$row['M_Name']?>&time=<?=$row['BetTime']?>&ID=<?=$row['id']?>&bet=<?=$row['BetScore']?>&date_start=<?=$date_s?>&date_end=<?=$date_e?>">结算 </a>/ <a href="../reallist/delzd.php?uid=<?=$uid?>&id=<?=$row['id']?>&user=<?=$row['M_Name']?>&Money_bet=<?=$row['BetScore']?>&date_start=<?=$date_s?>&date_end=<?=$date_e?>">删除</a> / <a href='../wager/wager_edit.php?ret=hide&uid=<?=$uid?>&id=<?=$row['id']?>&username=<?=$row['M_Name']?>&gdate=<?=$gdate?>&urlv=1&date_start=<?=$date_s?>&date_end=<?=$date_e?>'> 改单</a> / <? if($check_url==0){?><a href="<?=$url?>"> 对调</a><?
}else{
?> <font color="#FF9999">对调</font>
<? } ?></div><br>
                  <div class="menu2" onMouseOver="this.className='menu1'"   onmouseout="this.className='menu2'" align="center">
                    <div align="center"><FONT  color=red>注单处理</FONT>   </div>
                    <UL style="left: 28px;top: -100px">
                    <LI><A href="../reallist/voucher.php?uid=<?=$uid?>&id=<?=$row['id']?>&gid=<?=$row['mid']?>&pay_type=<?=$row['pay_type']?>&key=ok&result=<?=$row['M_result']?>&user=<?=$row['M_Name']?>&danger=0&date_start=<?=$date_s?>&date_end=<?=$date_e?>" target=_self>正常注单</A>
                    <LI><A href="../reallist/voucher.php?uid=<?=$uid?>&id=<?=$row['id']?>&gid=<?=$row['mid']?>&pay_type=<?=$row['pay_type']?>&key=cancel&result=<?=$row['M_result']?>&user=<?=$row['M_Name']?>&danger=1&date_start=<?=$date_s?>&date_end=<?=$date_e?>" target=_self>非正常注单</A>
                    <LI><A href="../reallist/voucher.php?uid=<?=$uid?>&id=<?=$row['id']?>&gid=<?=$row['mid']?>&pay_type=<?=$row['pay_type']?>&key=cancel&result=<?=$row['M_result']?>&user=<?=$row['M_Name']?>&danger=2&date_start=<?=$date_s?>&date_end=<?=$date_e?>" target=_self>进球取消</A>
                    <LI><A href="../reallist/voucher.php?uid=<?=$uid?>&id=<?=$row['id']?>&gid=<?=$row['mid']?>&pay_type=<?=$row['pay_type']?>&key=cancel&result=<?=$row['M_result']?>&user=<?=$row['M_Name']?>&danger=3&date_start=<?=$date_s?>&date_end=<?=$date_e?>" target=_self>红卡取消</A>
                    <LI><A href="../reallist/voucher.php?uid=<?=$uid?>&id=<?=$row['id']?>&gid=<?=$row['mid']?>&pay_type=<?=$row['pay_type']?>&key=cancel&result=<?=$row['M_result']?>&user=<?=$row['M_Name']?>&danger=4&date_start=<?=$date_s?>&date_end=<?=$date_e?>" target=_self>赛事腰斩</A>
                    <LI><A href="../reallist/voucher.php?uid=<?=$uid?>&id=<?=$row['id']?>&gid=<?=$row['mid']?>&pay_type=<?=$row['pay_type']?>&key=cancel&result=<?=$row['M_result']?>&user=<?=$row['M_Name']?>&danger=5&date_start=<?=$date_s?>&date_end=<?=$date_e?>" target=_self>赛事延期</A>
					<LI><A href="../reallist/voucher.php?uid=<?=$uid?>&id=<?=$row['id']?>&gid=<?=$row['mid']?>&pay_type=<?=$row['pay_type']?>&key=cancel&result=<?=$row['M_result']?>&user=<?=$row['M_Name']?>&danger=6&date_start=<?=$date_s?>&date_end=<?=$date_e?>" target=_self>赔率错误</A>
                    <LI><A href="../reallist/voucher.php?uid=<?=$uid?>&id=<?=$row['id']?>&gid=<?=$row['mid']?>&pay_type=<?=$row['pay_type']?>&key=cancel&result=<?=$row['M_result']?>&user=<?=$row['M_Name']?>&danger=7&date_start=<?=$date_s?>&date_end=<?=$date_e?>" target=_self>赛事无pk/加时</A>
                    <LI><A href="../reallist/voucher.php?uid=<?=$uid?>&id=<?=$row['id']?>&gid=<?=$row['mid']?>&pay_type=<?=$row['pay_type']?>&key=cancel&result=<?=$row['M_result']?>&user=<?=$row['M_Name']?>&danger=8&date_start=<?=$date_s?>&date_end=<?=$date_e?>" target=_self>球员弃权</A>
                    <LI><A href="../reallist/voucher.php?uid=<?=$uid?>&id=<?=$row['id']?>&gid=<?=$row['mid']?>&pay_type=<?=$row['pay_type']?>&key=cancel&result=<?=$row['M_result']?>&user=<?=$row['M_Name']?>&danger=9&date_start=<?=$date_s?>&date_end=<?=$date_e?>" target=_self>队名错误</A></LI>
					</UL>
					</DIV>

</td>

<?
}else{
?>
<a href="javascript:CheckSTOP('voucher.php?uid=<?=$uid?>&id=<?=$row['id']?>&gid=<?=$row['mid']?>&pay_type=<?=$row['pay_type']?>&key=upd&result=<?=$row['M_result']?>&user=<?=$row['M_Name']?>&date_start=<?=$date_s?>&date_end=<?=$date_e?>')">恢复</a>

<?
}
?>       </tr>
        <?
}
?>
        <?
//endif;
?>
     </table>
</form>
</body>
</html>
<?
}
?>
