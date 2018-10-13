<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require_once( "../../member/include/config.inc.php" );
require_once( "../../member/include/define_function_list.inc.php" );
require_once( "../../inc/settlement.inc.php" );

$uid = $_REQUEST['uid'];
$sql = "select id from web_sytnet where uid='$uid' and status=1";
$cou = mysql_num_rows( mysql_query( $sql ) );
if ( $cou == 0 ){
	echo "<script>window.open('/','_top')</script>";
	exit( );
}

$is_settlement=0;
$id = intval($_REQUEST['id']);
$active = $_REQUEST['active'];
$referer = $_REQUEST['referer']=='' ? $_SERVER['HTTP_REFERER'] : $_REQUEST['referer'];
$mb_inball = $_POST['mb_inball'];
$tg_inball = $_POST['tg_inball'];
if($active=='save'){
	if(is_numeric($mb_inball) && is_numeric($tg_inball)){
		$mb_inball = intval($mb_inball);
		$tg_inball = intval($tg_inball);
		settlement($id, $mb_inball, $tg_inball);
		$is_settlement=1;
	}
}

$mysql = "select *,date_format(BetTime,'%m%d%H%i%s')+id as WID from web_db_io where id='$id'";
$result = mysql_query( $mysql );
$row = mysql_fetch_array( $result );

$is_h = strpos($row['Middle'],'[�ϰ�]')!==false;
$matche_type = '';
$matche_table = '';
$sqladd='';
if( ($row['Active']==1 || $row['Active']==2) && in_array($row['LineType'],array(1,11,51,52, 2,12,3,13,9,19,10,30, 4,34, 5, 6)) ){
	$matche_type = '����';
	$matche_table = 'foot_match';
	$sqladd = $is_h ? ",mb_inball_hr as mb_inball,tg_inball_hr as tg_inball" : ",mb_inball,tg_inball";
}
elseif( $row['Active']==3 && in_array($row['LineType'],array(2,3,5,9,10)) ){
	$matche_type = '����';
	$matche_table = 'bask_match';
	$sqladd = ",mb_inball,tg_inball";
}

if ($matche_type==''){
	echo "<script>alert('��֧�ִ���!$row[LineType]');location='javascript:history.back(1)';</script>";
}

$sql="select m_start,mb_team,tg_team $sqladd from $matche_table where mid='$row[MID]'";
$result = mysql_query( $sql ) or exit($sql.mysql_error());
$match = mysql_fetch_array( $result );

if(is_numeric($mb_inball) && is_numeric($tg_inball)){
	$match['mb_inball'] = $mb_inball;
	$match['tg_inball'] = $tg_inball;
}
?>

<html style="width: 98%;margin: 0 auto;">
<head>
<title></title>
<meta http-equiv=content-type content="text/html; charset=gb2312">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="20" topmargin="0" vlink="#0000FF" alink="#0000FF">
<form name="myFORM" method="post" action=""><BR>
<table width="802" border="0" cellspacing="1" cellpadding="8" class="m_tab" bgcolor="#000000">
  <tr class="m_title_ft">
	  <td width="90" align="center">��עʱ��</td>
	  <td width="90" align="center">�û�����</td>
	  <td width="90" align="center">��ע����</td>
	  <td width="250" align="center">����</td>
	  <td width="90" align="center">���׽��</td>
	  <td width="90" align="center">��Ӯ���</td>
  </tr>
  <tr class="m_rig">
	  <td align="center"><?=str_replace(' ','<BR>',$row['BetTime'])?></td>
	  <td align="center"><?=$row['M_Name']?>&nbsp;&nbsp;<font color="#cc0000"> <?=$row['TurnRate']?></font>
	  <br><font color=blue><?=show_voucher( $row['linetype'], $row['WID'] )?></font></td>
	  <td align="center"><?=$row['BetType']?> <BR> <font color=#C0C0C0>(<?=$row['LineType']?>)</font></td>
	  <td align="right"><?=$row['Middle']?></td>
	  <td align="center"><?=$row['BetScore']?></td>
	  <td align="center"><?=$row['Gwin']?></td>
  </tr>
</table>
<BR><BR>
<? if($row['result_type']==1){ ?>
     
<table width="" border="0" cellspacing="1" cellpadding="8" class="m_tab" bgcolor="#000000">
  <tr class="m_title_ft">
	  <td width="90" align="center">��Ӯ���</td>
	  <td width="90" align="center">��Ա</td>
	  <td width="90" align="center">������</td>
	  <td width="90" align="center">�ܴ���</td>
	  <td width="90" align="center">�ɶ�</td>
  </tr>
  <tr class="m_rig">
	  <td align="center"><?=$row['VGOLD']?></td>
	  <td align="center"><?=$row['M_Result']?></td>
	  <td align="center"><?=$row['result_a']?> <BR> <font color=blue>(<?=100-$row['agent_point']?>%)</font></td>
	  <td align="center"><?=$row['result_s']?> <BR> <font color=blue>(<?=100-$row['agent_point']-$row['world_point']?>%)</font></td>
	  <td align="center"><?=$row['result_c']?> <BR> <font color=blue>(<?=100-$row['agent_point']-$row['world_point']-$row['corpor_point']?>%)</font></td>
  </tr>
</table>
<BR><BR>
<? } ?>
<table width="695" border="0" cellspacing="1" cellpadding="8" class="m_tab" bgcolor="#000000">
  <tr class="m_title_ft">
	  <td width="90" align="center">ʱ��</td>
	  <td width="90" align="center">��������</td>
	  <td width="357" align="center">���</td>
	  <td width="90" align="center"><?=$is_h?'�ϰ�':''?>�ȷ�</td>
  </tr>
  <tr class="m_rig">
	  <td align="center" rowspan=2><?=str_replace(' ','<BR>',$match['m_start'])?></td>
	  <td align="center" rowspan=2><?=$matche_type?></td>
	  <td align="right"><?=$match['mb_team']?> <font color=blue>(����)</font> </td>
	  <td align="center"><input size=4 type="text" name="mb_inball" value="<?=$match['mb_inball']?>"></td>
  </tr><tr class="m_rig">
	  <td align="right"><?=$match['tg_team']?> <font color=blue>(�Ͷ�)</font> </td>
	  <td align="center"><input size=4 type="text" name="tg_inball" value="<?=$match['tg_inball']?>"></td>
  </tr>
</table>

<BR>
<table width="802" border="0" cellspacing="0" cellpadding="0" class="m_tab" bgcolor="#000000">
  <tr class="m_rig">
	  <td align="center">
		<?=$is_settlement ? '<BR><font color=#ff0000>�ѳɹ�����</font><BR>': ''?>
		<BR><INPUT TYPE="submit" value=" ���� " <?=$is_settlement ? 'disabled=true' :''?>>
		&nbsp; &nbsp; &nbsp;<INPUT TYPE="button" VALUE=" ���� " ONCLICK="self.location='<?=$referer?>'">
		<BR><BR>ע������ıȷ�ֻ�Ա��ν�����Ч
		</td>
  </tr>
</table>
<INPUT TYPE="hidden" NAME="active" value="save">
<INPUT TYPE="hidden" NAME="referer" value="<?=$referer?>">
</form>

</body></html>