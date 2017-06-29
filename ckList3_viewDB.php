<!-- UTF-8 형식으로 저장 -->
<meta http-equiv="content-type" content="text/html; charset=UTF-8">


<?

	include "conf.php";

	//세션 시작
	session_start();

	//로그인한 간호사의 정보를 변수에 저장
	$n_key = $_SESSION['sess_rec_key']; 
	$n_id = $_SESSION['sess_id']; 
	
	//전달받은 값
	$p_key=$_POST['p_key'];
	$p_name=$_POST['p_name'];
	$which_i_m=$_POST['which_i_m'];	
	$input_time=$_POST['input_time'];

 	$sur_ck3_1 = implode('&!#', $_POST['sur_ck3_1']);
	$sur_ck3_2 = implode('&!#', $_POST['sur_ck3_2']);
	$sur_ck3_3 = implode('&!#', $_POST['sur_ck3_3']);
	$sur_ck3_4 = implode('&!#', $_POST['sur_ck3_4']);			
	$sur_ck3_5 = implode('&!#', $_POST['sur_ck3_5']);
	$sur_ck3_6 = implode('&!#', $_POST['sur_ck3_6']);
	$sur_ck3_7 = implode('&!#', $_POST['sur_ck3_7']);
	$sur_ck3_8 = implode('&!#', $_POST['sur_ck3_8']);
	$sur_ck3_9 = implode('&!#', $_POST['sur_ck3_9']);
	$sur_ck3_10 = implode('&!#', $_POST['sur_ck3_10']);
	$sur_ck3_1_txt=$_POST['sur_ck3_1_txt'];
	$sur_ck3_2_txt=$_POST['sur_ck3_2_txt'];
	$sur_ck3_3_txt=$_POST['sur_ck3_3_txt'];
	$sur_ck3_4_txt=$_POST['sur_ck3_4_txt'];
	$sur_ck3_5_txt=$_POST['sur_ck3_5_txt'];
	$sur_ck3_6_txt=$_POST['sur_ck3_6_txt'];
	$sur_ck3_7_txt=$_POST['sur_ck3_7_txt'];
	$sur_ck3_8_txt=$_POST['sur_ck3_8_txt'];
	$sur_ck3_9_txt=$_POST['sur_ck3_9_txt'];
	$sur_ck3_10_txt=$_POST['sur_ck3_10_txt'];
 
	/*
	echo "n_key=".$n_key."<br>";
	echo "n_id=".$n_id."<br>";
	echo "p_key=".$p_key."<br>";
	echo "p_name=".$p_name."<br>";
	*/

	//sur_ck_sum
	
	
	//만약 신규입력이면 insert 아니면 modify
	if($which_i_m == 'i')
	{	
		//DB에 설문 값을 입력
		$sql = "INSERT INTO nurse2016_ck3_view
				(n_key, n_name, p_key, p_name,
				sur_ck3_1, 		sur_ck3_1_txt,		sur_ck3_2, 			sur_ck3_2_txt,			sur_ck3_3, 			sur_ck3_3_txt,		sur_ck3_4, 			sur_ck3_4_txt,
				sur_ck3_5, 		sur_ck3_5_txt,		sur_ck3_6, 			sur_ck3_6_txt,			sur_ck3_7, 			sur_ck3_7_txt,		sur_ck3_8, 			sur_ck3_8_txt,
				sur_ck3_9, 		sur_ck3_9_txt,		sur_ck3_10, 		sur_ck3_10_txt,		
				input_time
				)
				
				VALUES
		
				('$n_key', '$n_id', '$p_key', '$p_name',
				'$sur_ck3_1',	'$sur_ck3_1_txt',	'$sur_ck3_2',		'$sur_ck3_2_txt', 		'$sur_ck3_3',		'$sur_ck3_3_txt',	'$sur_ck3_4',		'$sur_ck3_4_txt',
				'$sur_ck3_5',	'$sur_ck3_5_txt',	'$sur_ck3_6',		'$sur_ck3_6_txt', 		'$sur_ck3_7',		'$sur_ck3_7_txt',	'$sur_ck3_8',		'$sur_ck3_8_txt',
				'$sur_ck3_9',	'$sur_ck3_9_txt',	'$sur_ck3_10',		'$sur_ck3_10_txt', 	
				'$input_time'
				);
		";
		
		
	}

	else
	{	
		//DB에 설문 값을 수정
		$sql = "UPDATE nurse2016_ck3_view SET	
		
				n_key = '$n_key',		n_name = '$n_id',	
				sur_ck3_1 = '$sur_ck3_1', 		sur_ck3_1_txt = '$sur_ck3_1_txt',	sur_ck3_2 = '$sur_ck3_2', 			sur_ck3_2_txt = '$sur_ck3_2_txt',
				sur_ck3_3 = '$sur_ck3_3', 		sur_ck3_3_txt = '$sur_ck3_3_txt',	sur_ck3_4 = '$sur_ck3_4', 			sur_ck3_4_txt = '$sur_ck3_4_txt',
				sur_ck3_5 = '$sur_ck3_5', 		sur_ck3_5_txt = '$sur_ck3_5_txt',	sur_ck3_6 = '$sur_ck3_6', 			sur_ck3_6_txt = '$sur_ck3_6_txt',
				sur_ck3_7 = '$sur_ck3_7', 		sur_ck3_7_txt = '$sur_ck3_7_txt',	sur_ck3_8 = '$sur_ck3_8', 			sur_ck3_8_txt = '$sur_ck3_8_txt',
				sur_ck3_9 = '$sur_ck3_9', 		sur_ck3_9_txt = '$sur_ck3_9_txt',	sur_ck3_10 = '$sur_ck3_10', 		sur_ck3_10_txt = '$sur_ck3_10_txt',
				
				input_time = '$input_time'
				
				WHERE p_key = '$p_key';				
		";
	}
	

	//입력이든, 수정이든 모든 입력값을 백업		
	$sql_bk = "INSERT INTO nurse2016_ck3_view_bk 
				(n_key, n_name, p_key, p_name,
				sur_ck3_1, 		sur_ck3_1_txt,		sur_ck3_2, 			sur_ck3_2_txt,			sur_ck3_3, 			sur_ck3_3_txt,		sur_ck3_4, 			sur_ck3_4_txt,
				sur_ck3_5, 		sur_ck3_5_txt,		sur_ck3_6, 			sur_ck3_6_txt,			sur_ck3_7, 			sur_ck3_7_txt,		sur_ck3_8, 			sur_ck3_8_txt,
				sur_ck3_9, 		sur_ck3_9_txt,		sur_ck3_10, 		sur_ck3_10_txt,		
				input_time
				)
				
				VALUES
		
				('$n_key', '$n_id', '$p_key', '$p_name',
				'$sur_ck3_1',	'$sur_ck3_1_txt',	'$sur_ck3_2',		'$sur_ck3_2_txt', 		'$sur_ck3_3',		'$sur_ck3_3_txt',	'$sur_ck3_4',		'$sur_ck3_4_txt',
				'$sur_ck3_5',	'$sur_ck3_5_txt',	'$sur_ck3_6',		'$sur_ck3_6_txt', 		'$sur_ck3_7',		'$sur_ck3_7_txt',	'$sur_ck3_8',		'$sur_ck3_8_txt',
				'$sur_ck3_9',	'$sur_ck3_9_txt',	'$sur_ck3_10',		'$sur_ck3_10_txt', 	
				'$input_time'
				);
	"; 
	
	
	
	
//print ($_SESSION["uID"]);
//print_r ($sql); 



$result = mysql_query($sql);
$result_bk = mysql_query($sql_bk);

	if($result){
		echo "<script language='javaScript'>     
				
                document.location.href='ckList3_view_modify.php?p_key=$p_key';
			</script>";
	}else{
		 echo "<script language='javaScript'>
                alert('DB오류입니다.\\n잠시후에 다시 시도해 주세요');
                document.location.href='main.php';
				</script>";
	}
 


?>

