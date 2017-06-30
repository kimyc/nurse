<?
	//DB접속정보
	$host = "localhost";
	$db = "kimyc30";
	$user = "kimyc30";
	$pwd = "qwer1223";

	$db_info = mysql_connect ($host, $user, $pwd);

	mysql_select_db ($db , $db_info);
	
?>
