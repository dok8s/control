<?php

function p3_update($row,$admin_name)
{
	$_P = $_POST['_P'];	//print_r($_P);
	$BetTime = trim($_POST['BetTime']);
	$BetScore = trim($_POST['BetScore']);
	$BetIP = trim($_POST['BetIP']);	
	$ss=sizeof(explode('<div class=statement_textbox2></div><br>',$row['Middle']));
	
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
	foreach(explode('<div class=statement_textbox2></div><br>',$row['Middle']) as $k=>$v){
		$dataarr[$k]['Middle'] = $v;
		$s=explode('&nbsp;-&nbsp;',$v);
		if(sizeof($s)>1){
			$s=explode('&nbsp;@',$s[1]);
			$dataarr[$k]['bottom']="&nbsp;-&nbsp;".$s[0];
		}else{
			$dataarr[$k]['bottom']="";
		}
	}
	foreach(explode('<div class=statement_textbox2></div><br>',$row['Middle_tw']) as $k=>$v){
		$dataarr[$k]['Middle_tw'] = $v;
		$s=explode('&nbsp;-&nbsp;',$v);
		if(sizeof($s)>1){
			$s=explode('&nbsp;@',$s[1]);
			$dataarr[$k]['bottom_tw']="&nbsp;-&nbsp;".$s[0];
		}else{
			$dataarr[$k]['bottom_tw']="";
		}
	}
	foreach(explode('<div class=statement_textbox2></div><br>',$row['Middle_en']) as $k=>$v){
		$dataarr[$k]['Middle_en'] = $v;
		$s=explode('&nbsp;-&nbsp;',$v);
		if(sizeof($s)>1){
			$s=explode('&nbsp;@',$s[1]);
			$dataarr[$k]['bottom_en']="&nbsp;-&nbsp;".$s[0];
		}else{
			$dataarr[$k]['bottom_en']="";
		}
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

	$team=array('N'=>'和');
	
	$middle="";
	$middle_tw="";
	$middle_en="";
	$middle1="";
	$middle1_tw="";
	$middle1_en="";
	$jj=0;
	foreach($dataarr as $k=>$data){
	//echo "<script>alert('".$k."')<script>";
		//$jj=$jj+1;
		
		//简体
		$Middle=str_replace("<BR>","<br>",$data['Middle']);
		$Middle=explode('<br>',$Middle);
		//联盟
		$Middle11=str_replace("</font>","",$Middle[0]);
		$league=str_replace("<div><font class=today_league>","",$Middle11);
		//队名
		$Middle=explode('&nbsp;',str_replace("</font>","",$Middle[1]));
		$l_team=str_replace("<font class=his_h>","",$Middle[0]);
		$r_team=str_replace("<font class=his_a>","",$Middle[2]);
		
		
		if($sign==""){
			$sign="vs.";
		}	
		if ($data['ShowType']=='C' && in_array($data['mtype'],array('R_H','R_C'))){
			$team['H']=$r_team;
			$team['C']=$l_team;
		}else{
			$team['H']=$l_team;
			$team['C']=$r_team;
		}
		$mtarr = explode('_',$data['mtype']);
		if($mtarr[0]=='M'){
			$data['sign'] = "vs.</font>";
			$data['w_m_place'] = $team[$mtarr[1]];
		}
		elseif($mtarr[0]=='R'){
			$data['sign'] = "<font class=\"his_con\"> <span class=\"radio\">".$data['m_place']."</span> </font>";
			$data['w_m_place'] = $team[$mtarr[1]];
		}
		elseif($mtarr[0]=='OU'){
			$data['m_place'] = strtoupper($data['m_place']);
			$data['sign'] = "vs.";
			$data['mtype'] = $data['m_place'][0]=='U' ? 'OU_H' : 'OU_C';
			
			$data['w_m_place'] = str_replace(array('O','U'), array('大','小'), $data['m_place']);
		}
		elseif($mtarr[0]=='OE'){
			$data['sign'] = "vs.";
			$arr = array('OE_ODD'=>'单',  'OE_EVEN'=>'双');
			$data['w_m_place'] = $arr[$data['mtype']];
		}
		$bottom=$data['bottom'];
		//$data[$k] = $data;
		if($k==($ss-1)){
			$middle .= p3_get_info_one2($data,$l_team,$r_team,$league,$bottom);
			$middle1 .= p3_get_info_one3($data,$l_team,$r_team,$league,$bottom);
			
		}else{
			$middle .= p3_get_info_one($data,$l_team,$r_team,$league,$bottom);
			$middle1 .= p3_get_info_one1($data,$l_team,$r_team,$league,$bottom);
		
		}
		
		//繁体
		$Middle_tw=str_replace("<BR>","<br>",$data['Middle_tw']);
		
		$Middle_tw=explode('<br>',$Middle_tw);
		//联盟
		$Middle11_tw=str_replace("</font>","",$Middle_tw[0]);
		$league_tw=str_replace("<div><font class=today_league>","",$Middle11_tw);
		//队名
		$Middle_tw=explode('&nbsp;',str_replace("</font>","",$Middle_tw[1]));
		$l_team_tw=str_replace("<font class=his_h>","",$Middle_tw[0]);
		$r_team_tw=str_replace("<font class=his_a>","",$Middle_tw[2]);
		
		$bottom_tw=$data['bottom_tw'];
		
		if ($data['ShowType']=='C' && in_array($data['mtype'],array('R_H','R_C'))){
			$team['H']=$r_team_tw;
			$team['C']=$l_team_tw;
		}else{
			$team['H']=$l_team_tw;
			$team['C']=$r_team_tw;
		}
		$mtarr = explode('_',$data['mtype']);
		if($mtarr[0]=='M'){
			$data['sign'] = "<font class=\"his_con\"> <span class=\"radio\">vs.</span> </font>";
			$data['w_m_place'] = $team[$mtarr[1]];
		}
		elseif($mtarr[0]=='R'){
			$data['sign'] = "<font class=\"his_con\"> <span class=\"radio\">".$data['m_place']."</span> </font>";
			$data['w_m_place'] = $team[$mtarr[1]];
		}
		elseif($mtarr[0]=='OU'){
			$data['m_place'] = strtoupper($data['m_place']);
			$data['sign'] = "<font class=\"his_con\"> <span class=\"radio\">vs.</span> </font>";
			$data['mtype'] = $data['m_place'][0]=='U' ? 'OU_H' : 'OU_C';
			$data['w_m_place'] = str_replace(array('O','U'), array('大','小'), $data['m_place']);
		}
		elseif($mtarr[0]=='OE'){
			$data['sign'] = "<font class=\"his_con\"> <span class=\"radio\">vs.</span> </font>";
			$arr = array('OE_ODD'=>'單',  'OE_EVEN'=>'雙');
			$data['w_m_place'] = $arr[$data['mtype']];
		}
		//$data[$k] = $data;
		if($k==($ss-1)){
			$middle_tw .= p3_get_info_one2($data,$l_team_tw,$r_team_tw,$league_tw,$bottom_tw);
			$middle1_tw .= p3_get_info_one3($data,$l_team_tw,$r_team_tw,$league_tw,$bottom_tw);
		}else{
			$middle_tw .= p3_get_info_one($data,$l_team_tw,$r_team_tw,$league_tw,$bottom_tw);
			$middle1_tw .= p3_get_info_one1($data,$l_team_tw,$r_team_tw,$league_tw,$bottom_tw);
		}
		
		
		//英文
		$Middle_en=str_replace("<BR>","<br>",$data['Middle_en']);
		$Middle_en=explode('<br>',$Middle_en);
		//联盟
		$Middle11_en=str_replace("</font>","",$Middle_en[0]);
		$league_en=str_replace("<div><font class=today_league>","",$Middle11_en);
		//队名
		$Middle_en=explode('&nbsp;',str_replace("</font>","",$Middle_en[1]));
		$l_team_en=str_replace("<font class=his_h>","",$Middle_en[0]);
		$r_team_en=str_replace("<font class=his_a>","",$Middle_en[2]);
		$bottom_en=$data['bottom_en'];
		
		
		if ($data['ShowType']=='C' && in_array($data['mtype'],array('R_H','R_C'))){
			$team['H']=$r_team_en;
			$team['C']=$l_team_en;
		}else{
			$team['H']=$l_team_en;
			$team['C']=$r_team_en;
		}
		$mtarr = explode('_',$data['mtype']);
		if($mtarr[0]=='M'){
			$data['sign'] = "<font class=\"his_con\"> <span class=\"radio\">vs.</span> </font>";
			$data['w_m_place'] = $team[$mtarr[1]];
		}
		elseif($mtarr[0]=='R'){
			$data['sign'] = "<font class=\"his_con\"> <span class=\"radio\">".$data['m_place']."</span> </font>";
			$data['w_m_place'] = $team[$mtarr[1]];
		}
		elseif($mtarr[0]=='OU'){
			$data['m_place'] = strtoupper($data['m_place']);
			$data['sign'] = "<font class=\"his_con\"> <span class=\"radio\">vs.</span> </font>";
			$data['mtype'] = $data['m_place'][0]=='U' ? 'OU_H' : 'OU_C';
			$data['w_m_place'] = str_replace(array('O','U'), array('Over','Under'), $data['m_place']);
			$data['w_m_place'] = $data['m_place'];
		}
		elseif($mtarr[0]=='OE'){
			$data['sign'] = "<font class=\"his_con\"> <span class=\"radio\">vs.</span> </font>";
			$data['w_m_place'] = $data['mtype'];
		}
		//$data[$k] = $data;
		if($k==($ss-1)){
			$middle_en .= p3_get_info_one2($data,$l_team_en,$r_team_en,$league_en,$bottom_en);
			$middle1_en .= p3_get_info_one3($data,$l_team_en,$r_team_en,$league_en,$bottom_en);
		}else{
			$middle_en .= p3_get_info_one($data,$l_team_en,$r_team_en,$league_en,$bottom_en);
			$middle1_en .= p3_get_info_one1($data,$l_team_en,$r_team_en,$league_en,$bottom_en);
		}
	}
	
	

	$new_rate_tmp = 1;
	$mtype_arr = array();
	$m_place_arr = array();
	$m_rate_arr = array();
	foreach($dataarr as $k=>$data){
	
		if(in_array(strtoupper($data['m_place'][0]),array('O','U'))){
			$data['mtype']=$data['m_place'][0]=='U' ? 'OU_H' : 'OU_C';		
		}
		$new_rate_tmp   *= $data['m_rate'];
		$mtype_arr[$k]   = $data['mtype'];
		$m_place_arr[$k] = $data['m_place'];
		$m_rate_arr[$k]  = $data['m_rate'];
		
	}

	$gwin = $new_rate_tmp>1 ? $BetScore*$new_rate_tmp-$BetScore : 0;
	$gwin = round($gwin,2);
	
	
	
	
	
	
	
	
	$mtype     = join(',', $mtype_arr);
	$m_place   = join(',', $m_place_arr);
	$m_rate    = join(',', $m_rate_arr);
	$auth_code = md5( trim($middle_tw).$BetScore.$mtype );
	$more = serialize($dataarr);

	$sql = "update web_db_io set auth_code='{$auth_code}',vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0, BetTime='{$BetTime}',BetScore='{$BetScore}',gwin='{$gwin}',mtype='$mtype',m_place='$m_place',m_rate='{$m_rate}',middle='$middle',middle_tw='$middle_tw',middle_en='$middle_en',middle2='$middle1',middle2_tw='$middle1_tw',middle2_en='$middle1_en',BetIP='$BetIP',more='$more' where id='$row[ID]' ";
	mysql_query($sql) or exit('error 192');
	
	if($row['result_type']==1 and $row['pay_type']==1){
		$aa=$row['BetScore']+$row['M_Result'];
		$sql="update web_members set money=money-$aa where m_name='".$row['M_Name']."'";
		mysql_db_query($dbname, $sql);
	}
}

function p3_get_edit_html($dataarr)
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
		
		//$info = p3_get_info_one($data);
		$rt = p3_get_edit_html_one($data);
		$html[]="<tr class='m_rig'> <td align='center'>$id</td> <td><nobr>".$data['Middle']."</nobr></td> <td><nobr>$rt</nobr></td> </tr>";
	}
	$html[]="</table><BR><BR>";
	return join('',$html);
}

function p3_get_edit_html_one($data)
{
	extract($data);

	$Middle=str_replace("<BR>","<br>",$data['Middle']);
	$Middle=explode('<br>',$Middle);
	
	//艾菲斯&nbsp;<font class="his_con"> <span class="radio">2.5</span> </font>&nbsp;<font class=his_a>比锡达斯</font>
	$Middle=str_replace("</font>","",$Middle[1]);
	$Middle=str_replace("<font class=\"his_con\">","",$Middle);
	$Middle=explode('&nbsp;',str_replace("<fontcolor=gray>","",$Middle));
	$l_team=str_replace("<font class=his_h>","",$Middle[0]);
	$r_team=str_replace("<font class=his_a>","",$Middle[2]);
	$sign=$Middle[1];
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
			$select = array('M_H'=>$mb_team, 'M_C'=>$tg_team, 'M_N'=>'和');
		}elseif($mtype[1]=='C'){
			$select = array('M_C'=>$tg_team, 'M_H'=>$mb_team, 'M_N'=>'和');
		}else{
			$select = array('M_N'=>'和', 'M_H'=>$mb_team, 'M_C'=>$tg_team);
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
		$m_place=str_replace("Under","U",$m_place);
		$m_place=str_replace("Over","O",$m_place);
		
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
	
	$m_rate = "<input type='text' name='_P[$id][m_rate]' value='".$data['M_Rate']."' size='".strlen($m_rate)."'>";

	$html  = "$l_team $sign $r_team<br>";
	$html .= "<FONT color=#CC0000>$w_m_place</FONT>".$data['bottom']."&nbsp;@&nbsp;<FONT color=#cc0000><b>$m_rate</b></FONT>";
	return $html;
}

function p3_get_info($dataarr)
{
	$info = array();
	foreach($dataarr as $k=>$data){
		$id = $k+1;
		$info[] = p3_get_info_one($data);
	}
	return join('<br>', $info);
}

function p3_get_info_one($data,$w_l_team,$w_r_team,$s_sleague,$bottom)
{

	$info  ="<div><font class=today_league>".$s_sleague."</font><br><font class=his_h>".$w_l_team."</font>&nbsp;". $data['sign'] ."&nbsp;<font class=his_a>".$w_r_team."</font><BR>";
	$info .= "<FONT class=his_result>".$data['w_m_place']."</FONT>".$bottom."&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($data['m_rate'],2)."</b></FONT></div><div class=statement_textbox2></div><br>";
	return $info;
}

function p3_get_info_one1($data,$w_l_team,$w_r_team,$s_sleague,$bottom)
{
	if(sizeof(explode("<font",$w_r_team))>1 and sizeof(explode("</font>",$w_r_team))<=1){
		$w_r_team=$w_r_team."</font>";
	}
	if(sizeof(explode("<font",$w_l_team))>1 and sizeof(explode("</font>",$w_l_team))<=1){
		$w_l_team=$w_l_team."</font>";
	}
	$info  =$w_l_team." <font color=#cc0000>". $data['sign'] ."</font> ".$w_r_team."<br>";
	$info .= "<FONT color=#CC0000>".$data['w_m_place']."</FONT>".$bottom."&nbsp;@&nbsp;<FONT color=#cc0000><b>".number_format($data['m_rate'],2)."</b></FONT><br>";
	return $info;
}
function p3_get_info_one2($data,$w_l_team,$w_r_team,$s_sleague,$bottom)
{
	$info  ="<div><font class=today_league>".$s_sleague."</font><br><font class=his_h>".$w_l_team."</font>&nbsp;". $data['sign'] ."&nbsp;<font class=his_a>".$w_r_team."</font><BR>";
	$info .= "<FONT class=his_result>".$data['w_m_place']."</FONT>".$bottom."&nbsp;@&nbsp;<FONT class=his_odd><b>".number_format($data['m_rate'],2)."</b></FONT></div>";
	return $info;
}

function p3_get_info_one3($data,$w_l_team,$w_r_team,$s_sleague,$bottom)
{
	if(sizeof(explode("<font",$w_r_team))>1 and sizeof(explode("</font>",$w_r_team))<=1){
		$w_r_team=$w_r_team."</font>";
	}
	if(sizeof(explode("<font",$w_l_team))>1 and sizeof(explode("</font>",$w_l_team))<=1){
		$w_l_team=$w_l_team."</font>";
	}
	$info  =$w_l_team." <font color=#cc0000>". $data['sign'] ."</font> ".$w_r_team."<br>";
	$info .= "<FONT color=#CC0000>".$data['w_m_place']."</FONT>".$bottom."&nbsp;@&nbsp;<FONT color=#cc0000><b>".number_format($data['m_rate'],2)."</b></FONT>";
	return $info;
}
?>