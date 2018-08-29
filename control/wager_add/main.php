<?
$uid=$_GET['uid'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<frameset cols="240,*" frameborder="NO" border="0" framespacing="0">
<frame id="framebet" name="framebet" noresize scrolling="NO" src="bet.php?uid=<?=$uid?>">
<frame id="framelist" name="framelist" src="game_list.php?uid=<?=$uid?>">
</frameset>
<noframes><body bgcolor="#FFFFFF"></body></noframes>
</html>
