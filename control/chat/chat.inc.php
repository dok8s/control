<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
function chat_list($pagesize,$page){
	global $dbname;
	
	$mysql = "select id,from_id,to_id,from_name,to_name,message,state,time from web_chat ORDER BY id DESC LIMIT 0,100";
	$result = mysql_query( $mysql );
	$rt['count'] = mysql_num_rows( $result );
	$rt['rows'] = array();
	while ( $row = mysql_fetch_array( $result ) ){
		$rt['rows'][] = $row;
	}
	return $rt;
}

function chat_send($from_name,$to_name,$subject,$message){
	global $dbname;
	$mysql = "select id from web_member where memname='$to_name'";
	$result = mysql_query( $mysql );
	$row = mysql_fetch_array( $result );
	$to_id = intval($row['id']);
	if($to_id<1){
		return -1;
	}
	$from_id = 199999999;
	$time = date("Y-m-d H:i:s");
	mysql_query( "insert into web_chat (from_id,to_id,from_name,to_name,message,state,time) values ('$from_id','$to_id','$from_name','$to_name','$message','0','$time')" );
	return '';
}

function chat_get(){
}

function chat_del($id){	
	global $dbname;
	$mysql="delete from web_chat where id='$id'";
	mysql_query($mysql) ;
	//echo $mysql;exit;
}

?>