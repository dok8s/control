<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$ltype=$_REQUEST['ltype'];
$pct=$_REQUEST['pct'];
$page_no=$_REQUEST['page_no'];
$league=$_REQUEST['league_id'];
if ($league==''){
	$sleague="";
}else{
	$sleague=" and m_league_tw='".$league."'";
}

if ($page_no==''){
	$page_no=0;
}

$rtype=strtoupper(trim($_REQUEST['rtype']));

if ($ltype=='' or $ltype==3){
	$ltype=3;
	$open='C';
}else if($ltype==1){
	$open='A';
}else if($ltype==2){
	$open='B';
}else if($ltype==4){
	$open='D';
}


$sql = "select id from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

require ("../../member/include/traditional.zh-tw.inc.php");

$mDate=date('m-d');
$bdate=date('Y-m-d');

?>
<html style="width: 98%;margin: 0 auto;">
<head>
<title>���y�ܼƭ�</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<script language="JavaScript">
<!--
if(self == top) location='/app/control/agents/'
parent.uid='<?=$uid?>';
parent.ltype = <?=$ltype?>;
parent.stype_var = 'fs';
parent.aid = '';
parent.dt_now = '<?=date('Y-m-d H:i:s')?>';
parent.gmt_str = '���F�ɶ�';
parent.draw = '�M��';
<?
$K=0;
$sql = "select mdate,mtime,mcount,gid,gtype,league_tw as league from sp_match where mstart>now() and mshow=1 and team_tw<>'' group by gid order by mstart asc,mid";

	$result1 = mysql_db_query($dbname, $sql);
	$cou=mysql_num_rows($result1);
	echo "parent.retime=0;\n";
	echo "parent.gamount=$cou;\n";
	while ($row1=mysql_fetch_array($result1)){
		$gid=$row1['gid'];
		$mcount=$row1['mcount'];//count
		$gtype=$row1['gtype'];
		$league=$row1['league'];
		$mdate=$row1['mdate'].'<br>'.$row1['mtime'];
		$mysql = "select id,mid,team_tw as team,rate from sp_match where mstart>now() and mshow=1 and `gid`=$gid order by `rate` ASC";
		$result = mysql_db_query($dbname, $mysql);
		$str_data='';
		while ($row=mysql_fetch_array($result)){
			$id=$row['id'];
			$sql="select count(*) as count,sum(betscore) as score from web_db_io where linetype=16 and mid=$id  ";

			$result2 = mysql_db_query($dbname, $sql);
			$row2=mysql_fetch_array($result2);

			$c=$row2['count']+0;
			$s=$row2['score']+0;
			if ($str_data==''){
				$str_data="'Y','$row[team]','$row[rate]','$c/$s','$row[id]'";
			}else{
				$str_data=$str_data.",'Y','$row[team]','$row[rate]','$c/$s','$row[id]'";
			}
		}
		echo "parent.GameFT[$K] = Array('$gid','$mdate','$row1[league]','$mcount',$str_data,'N','123152','N','$gtype');\n";
		$K=$K+1;
	}
	?>
/*
parent.GameFT[0] = Array('462','06-10<BR>12:00a','F1�[���j��-����Ʀ�<BR>�`�a�x','22','Y','F.���K��[F.Alonso] ','2.8','0/0','123073','N','F.����[F. Massa] ','3','0/0','125619','N','L.�~�̺��y[L. Hamilton] ','3.6','0/0','127965','N','K.�p�J�n[K.Raikkonen] ','4','0/0','123078','N','N.���w�Ẹ�w[N.Heidfeld] ','36','0/0','123149','N','G.�O������[G.Fisichella] ','51','0/0','123074','N','R.�w��d[R.Kubica] ','51','0/0','125660','N','J.�S�|�Q[J.Trulli] ','81','0/0','123076','N','M.���B[M.Webber] ','81','0/0','123079','N','N.ù���B��[N.Rosberg] ','101','0/0','123148','N','D.�w�w���w[D.Coulthard] ','121','0/0','123145','N','H.��˵ܹ�[Heikki Kovalainen] ','121','0/0','127966','N','R.�ڨ���ù[R.Barrichello] ','151','0/0','123081','N','A.���[A. Wurz] ','181','0/0','127967','N','J.�ڹy[J.Button] ','181','0/0','125620','N','R.�Ժ���-�ΰ���[R.Schumacher] ','181','0/0','123082','N','A.������[A.Davidson] ','351','0/0','127968','N','A.Ĭ�Һ�[A. Sutil] ','351','0/0','127969','N','C.�����մ�[C.Albers] ','351','0/0','123138','N','S.�v�Ǽw[S.Speed] ','351','0/0','123150','N','T.����Z�i[Takuma Sato] ','351','0/0','123083','N','V.���ׯ�[V.Liuzzi] ','351','0/0','123152','N','123152','N','FT');
parent.GameFT[1] = Array('459','06-11<BR>00:01a','F1�[���j�j����- ����<BR>�`�a�x','22','Y','F.���K��[F.Alonso] ','2.6','0/0','123073','N','F.����[F. Massa] ','3.2','0/0','125619','N','K.�p�J�n[K.Raikkonen] ','3.8','0/0','123078','N','L.�~�̺��y[L. Hamilton] ','4','0/0','127965','N','G.�O������[G.Fisichella] ','41','0/0','123074','N','N.���w�Ẹ�w[N.Heidfeld] ','41','0/0','123149','N','R.�w��d[R.Kubica] ','51','0/0','125660','N','D.�w�w���w[D.Coulthard] ','101','0/0','123145','N','M.���B[M.Webber] ','101','0/0','123079','N','N.ù���B��[N.Rosberg] ','111','0/0','123148','N','H.��˵ܹ�[Heikki Kovalainen] ','126','0/0','127966','N','J.�S�|�Q[J.Trulli] ','126','0/0','123076','N','R.�ڨ���ù[R.Barrichello] ','201','0/0','123081','N','A.���[A. Wurz] ','251','0/0','127967','N','J.�ڹy[J.Button] ','251','0/0','125620','N','R.�Ժ���-�ΰ���[R.Schumacher] ','301','0/0','123082','N','A.������[A.Davidson] ','501','0/0','127968','N','S.�v�Ǽw[S.Speed] ','501','0/0','123150','N','T.����Z�i[Takuma Sato] ','501','0/0','123083','N','V.���ׯ�[V.Liuzzi] ','501','0/0','123152','N','A.Ĭ�Һ�[A. Sutil] ','801','0/0','127969','N','C.�J�ܮ�[C.Klien] ','801','0/0','123135','N','123135','N','FT');
parent.GameFT[2] = Array('463','06-11<BR>00:02a','F1�[���j�j���� -����<BR>�`�a�x','11','Y','�ڳͽ�(McLaren) ','1.6','0/0','128160','N','�k�ԧQ(Ferrari) ','1.7','0/0','128159','N','�_��-���B(BMW Sauber) ','21','0/0','128162','N','�p��(Renault) ','41','0/0','128161','N','����(Red Bull) ','51','0/0','128308','N','�ץ�(Toyota) ','66','0/0','128163','N','�·G�i��(WilliamsF1) ','71','0/0','128164','N','����(Honda) ','151','0/0','128165','N','�Ȥ[��(Super Aguri) ','201','0/0','128309','N','�q�j�Q����(Toro Rosso) ','201','0/0','128310','N','�v���J(Spyker) ','251','0/0','128311','N','128311','N','FT');
parent.GameFT[3] = Array('427','06-18<BR>12:00a','���<BR>�`�a�x','6','Y','�Ӯa���w�� ','1.68','0/0','101799','N','�ڶ붩�� ','2.15','0/0','101470','N','����� ','15.5','0/0','122936','N','�ĩԤ��� ','2001','0/0','102165','Y','���w����|�| ','2001','0/0','101922','Y','�حۦ�� ','2001','0/0','102009','Y','122936','N','FT');
parent.GameFT[4] = Array('444','06-23<BR>12:02a','���<BR>�`�a�x','2','Y','����� ','1.4','0/0','122936','N','�[�� ','2.65','0/0','101498','N','101498','N','FT');
parent.GameFT[5] = Array('460','06-25<BR>12:00a','���w����<BR>�`�a�x','12','Y','���� ','2.35','0/0','122833','N','����� ','2.4','0/0','122855','N','�����F���[ ','6.5','0/0','122914','N','�d���F�Φh�ڭ� ','11','0/0','122901','N','�x���Դ� ','14.5','0/0','122899','N','�[���j ','26','0/0','122885','N','�ڮ��� ','31','0/0','122850','N','�ʦa���� ','41','0/0','122906','N','���a ','41','0/0','122659','N','�j�� ','51','0/0','122929','N','�ĺ��˦h ','181','0/0','122852','N','�ʼwù�� ','181','0/0','128831','N','128831','N','FT');
parent.GameFT[6] = Array('440','07-05<BR>02:01p','���w��a��<BR>A�իa�x','4','Y','�Q�Ԧc ','1.9','0/0','122933','N','�e����� ','2.55','0/0','122887','N','���| ','6.5','0/0','122894','N','���Q���� ','13','0/0','123690','N','123690','N','FT');
parent.GameFT[7] = Array('442','07-05<BR>02:02p','���w��a��<BR>B�իa�x','4','Y','�ڦ� ','1.5','0/0','122866','N','����� ','4','0/0','122855','N','���Q ','8.25','0/0','122935','N','�̥ʦh�� ','11.5','0/0','122905','N','122905','N','FT');
parent.GameFT[8] = Array('443','07-05<BR>02:03p','���w��a��<BR>C�իa�x','4','Y','���ڧ� ','1.65','0/0','122882','N','�کԦc ','4.75','0/0','122854','N','���ۤ�� ','5.5','0/0','122895','N','���� ','8','0/0','122833','N','122833','N','FT');
parent.GameFT[9] = Array('441','07-16<BR>02:00p','���w��a��<BR>�`�a�x','12','Y','���ڧ� ','2.4','0/0','122882','N','�ڦ� ','2.5','0/0','122866','N','����� ','9.5','0/0','122855','N','�Q�Ԧc ','11','0/0','122933','N','�e����� ','16','0/0','122887','N','�کԦc ','18','0/0','122854','N','���ۤ�� ','18','0/0','122895','N','���Q ','20','0/0','122935','N','���� ','23','0/0','122833','N','�̥ʦh�� ','30','0/0','122905','N','���| ','38','0/0','122894','N','���Q���� ','101','0/0','123690','N','123690','N','FT');
parent.GameFT[10] = Array('457','07-30<BR>07:35a','AFC �Ȭw��<BR>�`�a�x','16','Y','�D�w ','3.05','0/0','122829','N','�饻 ','3.8','0/0','122847','N','�n�� ','5','0/0','122848','N','��� ','5.8','0/0','122851','N','�F�a���ԧB ','8.5','0/0','122856','N','���� ','21','0/0','122836','N','�d�� ','28','0/0','122634','N','��ԧJ ','51','0/0','122900','N','���p�� ','51','0/0','122843','N','���� ','53','0/0','122937','N','�Q���O�J ','61','0/0','123008','N','�ڪL ','81','0/0','122853','N','���� ','81','0/0','122849','N','�L�� ','120','0/0','122903','N','���Ӧ�� ','120','0/0','122924','N','�V�n ','120','0/0','125108','N','125108','N','FT');
*/

function onLoad(){
	if(parent.retime > 0){
		parent.retime_flag = "Y";
	}else{
		parent.retime_flag = "N";
	}
	parent.loading_var = "N";

	if(parent.loading == "N" && parent.ShowType != ""){
		parent.ShowGameList();
		obj_layer = parent.body_browse.document.getElementById("LoadLayer");
		obj_layer.style.display = "none";
	}
}
// -->
</script>
</head>
<body bgcolor="#000000" onLoad="onLoad()">
</body>
</html>
