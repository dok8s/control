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
<html>
<head>
<title>足球變數值</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<script language="JavaScript">
<!--
if(self == top) location='/app/control/agents/'
parent.uid='<?=$uid?>';
parent.ltype = <?=$ltype?>;
parent.stype_var = 'fs';
parent.aid = '';
parent.dt_now = '<?=date('Y-m-d H:i:s')?>';
parent.gmt_str = '美東時間';
parent.draw = '和局';
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
parent.GameFT[0] = Array('462','06-10<BR>12:00a','F1加拿大站-車手排位<BR>總冠軍','22','Y','F.阿窿索[F.Alonso] ','2.8','0/0','123073','N','F.馬薩[F. Massa] ','3','0/0','125619','N','L.漢米爾頓[L. Hamilton] ','3.6','0/0','127965','N','K.雷克南[K.Raikkonen] ','4','0/0','123078','N','N.海德菲爾德[N.Heidfeld] ','36','0/0','123149','N','G.費斯切拉[G.Fisichella] ','51','0/0','123074','N','R.庫比卡[R.Kubica] ','51','0/0','125660','N','J.特魯利[J.Trulli] ','81','0/0','123076','N','M.韋伯[M.Webber] ','81','0/0','123079','N','N.羅斯伯格[N.Rosberg] ','101','0/0','123148','N','D.庫德哈德[D.Coulthard] ','121','0/0','123145','N','H.科瓦萊寧[Heikki Kovalainen] ','121','0/0','127966','N','R.巴里切羅[R.Barrichello] ','151','0/0','123081','N','A.伍爾茲[A. Wurz] ','181','0/0','127967','N','J.巴頓[J.Button] ','181','0/0','125620','N','R.拉爾夫-舒馬赫[R.Schumacher] ','181','0/0','123082','N','A.戴維森[A.Davidson] ','351','0/0','127968','N','A.蘇帝爾[A. Sutil] ','351','0/0','127969','N','C.阿爾博斯[C.Albers] ','351','0/0','123138','N','S.史匹德[S.Speed] ','351','0/0','123150','N','T.佐籐琢磨[Takuma Sato] ','351','0/0','123083','N','V.里尤茲[V.Liuzzi] ','351','0/0','123152','N','123152','N','FT');
parent.GameFT[1] = Array('459','06-11<BR>00:01a','F1加拿大大獎賽- 車手<BR>總冠軍','22','Y','F.阿窿索[F.Alonso] ','2.6','0/0','123073','N','F.馬薩[F. Massa] ','3.2','0/0','125619','N','K.雷克南[K.Raikkonen] ','3.8','0/0','123078','N','L.漢米爾頓[L. Hamilton] ','4','0/0','127965','N','G.費斯切拉[G.Fisichella] ','41','0/0','123074','N','N.海德菲爾德[N.Heidfeld] ','41','0/0','123149','N','R.庫比卡[R.Kubica] ','51','0/0','125660','N','D.庫德哈德[D.Coulthard] ','101','0/0','123145','N','M.韋伯[M.Webber] ','101','0/0','123079','N','N.羅斯伯格[N.Rosberg] ','111','0/0','123148','N','H.科瓦萊寧[Heikki Kovalainen] ','126','0/0','127966','N','J.特魯利[J.Trulli] ','126','0/0','123076','N','R.巴里切羅[R.Barrichello] ','201','0/0','123081','N','A.伍爾茲[A. Wurz] ','251','0/0','127967','N','J.巴頓[J.Button] ','251','0/0','125620','N','R.拉爾夫-舒馬赫[R.Schumacher] ','301','0/0','123082','N','A.戴維森[A.Davidson] ','501','0/0','127968','N','S.史匹德[S.Speed] ','501','0/0','123150','N','T.佐籐琢磨[Takuma Sato] ','501','0/0','123083','N','V.里尤茲[V.Liuzzi] ','501','0/0','123152','N','A.蘇帝爾[A. Sutil] ','801','0/0','127969','N','C.克萊恩[C.Klien] ','801','0/0','123135','N','123135','N','FT');
parent.GameFT[2] = Array('463','06-11<BR>00:02a','F1加拿大大獎賽 -車隊<BR>總冠軍','11','Y','邁凱輪(McLaren) ','1.6','0/0','128160','N','法拉利(Ferrari) ','1.7','0/0','128159','N','寶馬-索伯(BMW Sauber) ','21','0/0','128162','N','雷諾(Renault) ','41','0/0','128161','N','紅牛(Red Bull) ','51','0/0','128308','N','豐田(Toyota) ','66','0/0','128163','N','威廉姆斯(WilliamsF1) ','71','0/0','128164','N','本田(Honda) ','151','0/0','128165','N','亞久里(Super Aguri) ','201','0/0','128309','N','義大利紅牛(Toro Rosso) ','201','0/0','128310','N','史派克(Spyker) ','251','0/0','128311','N','128311','N','FT');
parent.GameFT[3] = Array('427','06-18<BR>12:00a','西甲<BR>總冠軍','6','Y','皇家馬德里 ','1.68','0/0','101799','N','巴塞隆拿 ','2.15','0/0','101470','N','西維爾 ','15.5','0/0','122936','N','薩拉戈薩 ','2001','0/0','102165','Y','馬德里體育會 ','2001','0/0','101922','Y','華倫西亞 ','2001','0/0','102009','Y','122936','N','FT');
parent.GameFT[4] = Array('444','06-23<BR>12:02a','西盃<BR>總冠軍','2','Y','西維爾 ','1.4','0/0','122936','N','加泰 ','2.65','0/0','101498','N','101498','N','FT');
parent.GameFT[5] = Array('460','06-25<BR>12:00a','美洲金盃<BR>總冠軍','12','Y','美國 ','2.35','0/0','122833','N','墨西哥 ','2.4','0/0','122855','N','哥斯達黎加 ','6.5','0/0','122914','N','千里達及多巴哥 ','11','0/0','122901','N','洪都拉斯 ','14.5','0/0','122899','N','加拿大 ','26','0/0','122885','N','巴拿馬 ','31','0/0','122850','N','瓜地馬拉 ','41','0/0','122906','N','海地 ','41','0/0','122659','N','古巴 ','51','0/0','122929','N','薩爾瓦多 ','181','0/0','122852','N','瓜德羅普 ','181','0/0','128831','N','128831','N','FT');
parent.GameFT[6] = Array('440','07-05<BR>02:01p','美洲國家盃<BR>A組冠軍','4','Y','烏拉圭 ','1.9','0/0','122933','N','委內瑞拉 ','2.55','0/0','122887','N','秘魯 ','6.5','0/0','122894','N','玻利維亞 ','13','0/0','123690','N','123690','N','FT');
parent.GameFT[7] = Array('442','07-05<BR>02:02p','美洲國家盃<BR>B組冠軍','4','Y','巴西 ','1.5','0/0','122866','N','墨西哥 ','4','0/0','122855','N','智利 ','8.25','0/0','122935','N','厄瓜多爾 ','11.5','0/0','122905','N','122905','N','FT');
parent.GameFT[8] = Array('443','07-05<BR>02:03p','美洲國家盃<BR>C組冠軍','4','Y','阿根廷 ','1.65','0/0','122882','N','巴拉圭 ','4.75','0/0','122854','N','哥倫比亞 ','5.5','0/0','122895','N','美國 ','8','0/0','122833','N','122833','N','FT');
parent.GameFT[9] = Array('441','07-16<BR>02:00p','美洲國家盃<BR>總冠軍','12','Y','阿根廷 ','2.4','0/0','122882','N','巴西 ','2.5','0/0','122866','N','墨西哥 ','9.5','0/0','122855','N','烏拉圭 ','11','0/0','122933','N','委內瑞拉 ','16','0/0','122887','N','巴拉圭 ','18','0/0','122854','N','哥倫比亞 ','18','0/0','122895','N','智利 ','20','0/0','122935','N','美國 ','23','0/0','122833','N','厄瓜多爾 ','30','0/0','122905','N','秘魯 ','38','0/0','122894','N','玻利維亞 ','101','0/0','123690','N','123690','N','FT');
parent.GameFT[10] = Array('457','07-30<BR>07:35a','AFC 亞洲盃<BR>總冠軍','16','Y','澳洲 ','3.05','0/0','122829','N','日本 ','3.8','0/0','122847','N','南韓 ','5','0/0','122848','N','伊朗 ','5.8','0/0','122851','N','沙地阿拉伯 ','8.5','0/0','122856','N','中國 ','21','0/0','122836','N','卡塔爾 ','28','0/0','122634','N','伊拉克 ','51','0/0','122900','N','阿聯酋 ','51','0/0','122843','N','阿曼 ','53','0/0','122937','N','烏茲別克 ','61','0/0','123008','N','巴林 ','81','0/0','122853','N','泰國 ','81','0/0','122849','N','印尼 ','120','0/0','122903','N','馬來西亞 ','120','0/0','122924','N','越南 ','120','0/0','125108','N','125108','N','FT');
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
