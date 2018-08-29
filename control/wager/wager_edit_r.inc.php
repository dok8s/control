<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
function r_update($row)
{
	$_P = $_POST['_P'];	//print_r($_P);
	$BetTime = trim($_POST['BetTime']);
	$BetScore = trim($_POST['BetScore']);
	$BetIP = trim($_POST['BetIP']);	
		
	$dataarr = @unserialize($row['more']);
	foreach(explode(',',$row['Mtype']) as $k=>$v){
		$dataarr[$k]['mtype'] = $v;
	}
	foreach(explode(',',$row['ShowType']) as $k=>$v){
		$dataarr[$k]['ShowType'] = $v;
	}
	foreach(explode(',',$row['M_Place']) as $k=>$v){
		$dataarr[$k]['m_place'] = $v;
	}

	$edit_on_array = array('M_H','M_C','M_N','R_H','R_C','OU_H','OU_C','OE_ODD','OE_EVEN');
	$dataarr_old = $dataarr;
	foreach($dataarr_old as $k=>$data){
		$p = $_P[$k];
		if($p['m_rate']>0.01)  $data['m_rate']=$p['m_rate'];
		if(in_array($data['mtype'],$edit_on_array)){
			if(in_array($p['mtype'],$edit_on_array)) $data['mtype']=$p['mtype'];
			if(in_array(strtoupper($data['m_place'][0]),array('O','U'))){
				if(in_array(strtoupper($p['m_place'][0]),array('O','U'))){
					$p['m_place'] = join(' / ', explode('/', str_replace(' ','',$p['m_place'])));
				}else{
					$p['m_place'] = '';
				}
			}
			if($p['m_place']!='')  $data['m_place']=$p['m_place'];
		}
		$dataarr[$k] = $data;
	}

	$team=array('N'=>'和局');
	foreach($dataarr as $k=>$data){		
		if ($data['ShowType']=='C' && in_array($data['mtype'],array('R_H','R_C'))){
			$team['H']=$data['r_team'];
			$team['C']=$data['l_team'];
		}else{
			$team['H']=$data['l_team'];
			$team['C']=$data['r_team'];
		}
		$mtarr = explode('_',$data['mtype']);
		if($mtarr[0]=='M'){
			$data['w_m_place'] = $team[$mtarr[1]];
		}
		elseif($mtarr[0]=='R'){
			$data['sign'] = $data['m_place'];
			$data['w_m_place'] = $team[$mtarr[1]];
		}
		elseif($mtarr[0]=='OU'){
			$data['m_place'] = strtoupper($data['m_place']);
			$data['mtype'] = $data['m_place'][0]=='U' ? 'OU_H' : 'OU_C';
			$data['w_m_place'] = str_replace(array('O','U'), array('大','小'), $data['m_place']);
		}
		elseif($mtarr[0]=='OE'){
			$arr = array('OE_ODD'=>'单',  'OE_EVEN'=>'双');
			$data['w_m_place'] = $arr[$data['mtype']];
		}
		$dataarr[$k] = $data;
	}

	$new_rate_tmp = 1;
	$mtype_arr = array();
	$m_place_arr = array();
	$m_rate_arr = array();
	foreach($dataarr as $k=>$data){
		$new_rate_tmp   *= $data['m_rate'];
		$mtype_arr[$k]   = $data['mtype'];
		$m_place_arr[$k] = $data['m_place'];
		$m_rate_arr[$k]  = $data['m_rate'];
	}

	$gwin = $new_rate_tmp>1 ? $BetScore*$new_rate_tmp-$BetScore : 0;
	$gwin = round($gwin,2);
	$middle_cn = r_get_info($dataarr);
	$middle_tw = gb2big5($middle_cn);
	$middle_en = $middle_tw;
	$mtype     = join(',', $mtype_arr);
	$m_place   = join(',', $m_place_arr);
	$m_rate    = join(',', $m_rate_arr);
	$auth_code = md5( trim($middle_tw).$BetScore.$mtype );
	$more = serialize($dataarr);

	$sql = "update web_db_io set auth_code='{$auth_code}',vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0, BetTime='{$BetTime}',BetScore='{$BetScore}',gwin='{$gwin}',mtype='$mtype',m_place='$m_place',m_rate='{$m_rate}',middle='$middle_cn',middle_tw='$middle_tw',middle_en='$middle_en',BetIP='$BetIP',more='$more' where id='$row[ID]' ";
	mysql_query($sql) or exit('error 192');
	
	if($row['result_type']==1 and $row['pay_type']==1){
		$aa=$row['BetScore']+$row['M_Result'];
		$sql="update web_members set money=money-$aa where m_name='".$row['M_Name']."'";
		mysql_db_query($dbname, $sql);
	}
}

function r_get_edit_html($dataarr)
{
	$html=array();
	$html[]="<table width='' border='0' cellspacing='1' cellpadding='8' class='m_tab' bgcolor='#C0C0C0'>
  <tr class='m_title_ft'>
	  <td width='90' align='center'>序号</td>
	  <td width='' align='center'>原內容</td>
	  <td width='100' align='center'>&nbsp; &nbsp; &nbsp; </td>
  </tr>";
	foreach($dataarr as $k=>$data){
		$id = $k+1;
		$data['id'] = $k;
		$info = r_get_info_one($data);
		$rt = r_get_edit_html_one($data);
		$html[]="<tr class='m_rig'> <td align='center'>$id</td> <td><nobr>$info</nobr></td> <td><nobr>$rt</nobr></td> </tr>";
	}
	$html[]="</table><BR><BR>";
	return join('',$html);
}

function r_get_edit_html_one($data)
{
	extract($data);
	$F = array('H'=>'C','C'=>'H');
	if ($data['ShowType']=='C' && in_array($mtype,array('R_H','R_C'))){
		$mb_team=$r_team;
		$tg_team=$l_team;
	}else{
		$mb_team=$l_team;
		$tg_team=$r_team;
	}
	$select = array();

	$mtype = explode('_',$mtype);
	if($mtype[0]=='M'){
		if($mtype[1]=='H'){
			$select = array('M_H'=>$mb_team, 'M_C'=>$tg_team, 'M_N'=>'和局');
		}elseif($mtype[1]=='C'){
			$select = array('M_C'=>$tg_team, 'M_H'=>$mb_team, 'M_N'=>'和局');
		}else{
			$select = array('M_N'=>'和局', 'M_H'=>$mb_team, 'M_C'=>$tg_team);
		}
	}
	elseif($mtype[0]=='R'){
		$sign = "<input type='text' name='_P[$id][m_place]' value='$m_place' size='".strlen($m_place)."'>";
		if($mtype[1]=='H'){
			$select = array('R_H'=>$mb_team, 'R_C'=>$tg_team);
		}else{
			$select = array('R_C'=>$tg_team, 'R_H'=>$mb_team);
		}
	}
	elseif($mtype[0]=='OU'){
		$w_m_place = "<input type='text' name='_P[$id][m_place]' value='$m_place' size='".strlen($m_place)."'>";
	}
	elseif($mtype[0]=='OE'){
		if($mtype[1]=='ODD'){
			$select = array('OE_ODD'=>'单',  'OE_EVEN'=>'双');
		}else{
			$select = array('OE_EVEN'=>'双', 'OE_ODD'=>'单');
		}
	}

	if(count($select)>1){
		$w_m_place = "<select name='_P[$id][mtype]'>";
		foreach($select as $a=>$b){
			$w_m_place .= "<option value='$a'>$b </option>";
		}
		$w_m_place .= "</select>";
	}
	$m_rate = "<input type='text' name='_P[$id][m_rate]' value='$m_rate' size='".strlen($m_rate)."'>";

	$html  = "$l_team <font color=#cc0000>$sign</font> $r_team<br>";
	$html .= "<FONT color=#CC0000>$w_m_place</FONT>$bottom&nbsp;@&nbsp;<FONT color=#cc0000><b>$m_rate</b></FONT>";
	return $html;
}

function r_get_info($dataarr)
{
	$info = array();
	foreach($dataarr as $k=>$data){
		$id = $k+1;
		$info[] = r_get_info_one($data);
	}
	return join('<br>', $info);
}

function p3_get_info_one($data)
{
	$info  = "$data[l_team] <font color=#cc0000>$data[sign]</font> $data[r_team]<br>";
	$info .= "<FONT color=#CC0000>$data[w_m_place]</FONT>$data[bottom]&nbsp;@&nbsp;<FONT color=#cc0000><b>$data[m_rate]</b></FONT>";
	return $info;
}

?>