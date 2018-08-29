<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../../../member/include/config.inc.php");
require ("../../../member/include/define_function_list.inc.php");
$username=$_REQUEST['name'];
$bet=$_REQUEST['bet'];
$bet_r=-$bet;
$uid=$_REQUEST['uid'];
$ID=$_REQUEST['ID'];
$time=$_REQUEST['time'];
$aaa1=$_REQUEST['result'];///输赢结果(不包本金)
$act=$_REQUEST['act'];
$date_s=$_REQUEST['date_start'];
$date_e=$_REQUEST['date_end'];
$sql = "select id,level,agname from web_sytnet where uid='".$uid."' and status=1";
$result = mysql_query( $sql );
$row = mysql_fetch_array( $result );
$admin_name = $row['agname'];
//$aaa=$_REQUEST['time'];
$mysql="select * from web_db_io where  M_Name='$username' and ID='$ID' and BetScore='$bet'";
//echo $mysql;
$result = mysql_db_query($dbname, $mysql);
$row = mysql_fetch_array($result);
$VGOLD=$bet;
if($aaa1==0){
$VGOLD=0;
}

$bet1="-".$bet;
$bet1=$bet1/2;
if($act=="1"){

		//$vgold=abs($graded)*$row['BetScore'];
        $g_res=$aaa1;
		$turn=abs($aaa1)*$row['TurnRate']/100;
		$agent_point=$row['agent_point']/100;
		$world_point=$row['world_point']/100;
		$corpor_point=$row['corpor_point']/100;

		if ($agent_point==1){//代理占全成，总代理不占成，股东不占成
			$members=$g_res+$turn; //和会员结帐的金额
			$agents=0;
			$world=0;
			$corprator=0;
		}else if($world_point==1){//代理不占成，总代理全成
			$members=$g_res+$turn;//和会员结帐的金额
	    	$corprator=0; //不和公司结帐
			$world=0;//不和股东结帐
			$agents=$g_res+$row['agent_rate']*$row['BetScore']*0.01;    //和总代理结帐的金额
		}else if($corpor_point==1){//代理不占成，总代理不占成,股东全成
			$members=$g_res+$turn;//和会员结帐的金额
    		$corprator=0; //不和公司结帐
			$world=$g_res+$row['world_rate']*$row['BetScore']*0.01; ;//不和股东结帐
			$agents=$g_res+$row['agent_rate']*$row['BetScore']*0.01;    //和总代理结帐的金额
		}else if($agent_point+$world_point==1){
			$members=$g_res+$turn;//和会员结帐的金额
			$corprator=0; //不和公司结帐
			$world=0;//不和股东结帐
			$agents=$g_res*(1-$agent_point)+(1-$agent_point)*$row['agent_rate']/100*$row['BetScore'];    //和总代理结帐的金额
		}else{
			$members=$g_res+$turn;//和会员结帐的金额
			$agents=$g_res*(1-$agent_point)+(1-$agent_point)*$row['agent_rate']/100*$row['BetScore'];   //和总代理结帐的金额
		   	$world=$g_res*(1-$agent_point-$world_point)+(1-$world_point)*$row['world_rate']/100*$row['BetScore'];
			$corprator=$g_res*(1-$agent_point-$world_point)+(1-$agent_point-$world_point)*$row['world_rate']/100*$row['BetScore'];//和公司结帐
		}

    //判断是不是现金会员					
	if($row['pay_type']!=0){
	  echo "此会员为现金会员";
if($aaa1<0)
{
             if($aaa1==$bet1)
				{
                $aaa12=$members;	
				echo "操作完成:输一半".$aaa12."返还金额:".$aaa12;
                $mysql="update web_member set money=money-$aaa12 where memname='$username'";
				mysql_db_query($dbname,$mysql) or die ("操作失败2!123");				
				}
				else
				{
				echo "操作完成:".$aaa12;	
                 $aaa12=$aaa1;			
                }
				
}else{
                     $aaa=$members+$bet;
                     $aaa12=$members;
				$mysql="update web_member set money=money+$aaa where memname='$username'";
				mysql_db_query($dbname,$mysql) or die ("操作失败2!");
      }									
			               }//判断是不是现金会员
						   else
						   {
						   $aaa12=$members;
						   }					
$sql2="update web_db_io set result_type=1,VGOLD=$VGOLD,M_Result=$aaa12,a_result=$agents,result_a=$agents,result_s=$world,result_c=$corprator,G_Name='".$admin_name."',G_Type=1 where M_Name='$username' and ID='$ID' and BetScore='$bet'";
/*$sql="update web_db_io set status=$status,QQ526738='$ball',vgold=$gold_d,m_result=$members,a_result=$agents,result_a=$result_a,result_s=$result_s,result_c=$result_c,result_type=1 where id=".$db->f('id');*/

		mysql_db_query($dbname,$sql2) or die ("操作失败1!");
	
	echo "<script language=JavaScript>{alert('It is OK!!');}</script>"; 
        echo "<Script language=javascript>self.location='../voucher.php?uid=$uid&date_start=$date_s&date_end=$date_e';</script>";		
		
}	
?>
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>

<form name="form1" method="post" action="">
  <table width="792" height="54" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFCCCC">
    <tr>
      <td width="84"><div align="center" class="style1">会员</div></td>
      <td width="95"><div align="center" class="style1">结果</div></td>
      <td width="77"><div align="center" class="style1">本金</div></td>
      <td width="332"><div align="center" class="style1">ID号</div></td>
      <td width="192"><div align="center" class="style1">时间</div></td>
    </tr>
    <tr>
      <td><div align="center" class="style1">
          <?=$username?>
      </div></td>
      <td><div align="center" class="style1">
        <input name="result" type="text" id="result" value="<?=$bet_r?>" size="10" maxlength="10">
		<input name="act" type="hidden" id="act" size="10" maxlength="10" value="1">
      </div></td>
      <td><div align="center" class="style1">
          <?=$bet?>
&nbsp; </div></td>
      <td>
      <div align="center" class="style1"><?=$ID?></div></td>
      <td><div align="center" class="style1">
        <?=$time?>
      </div></td>
    </tr>
    <tr>
      <td><div align="center"></div></td>
      <td><div align="center"></div></td>
      <td><div align="center"></div></td>
      <td><div align="center">
        <input type="submit" name="Submit" value="提交">
      </div></td>
      <td><div align="center"></div></td>
    </tr>
    
  </table>
</form>
