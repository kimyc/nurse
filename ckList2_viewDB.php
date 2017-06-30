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

	$sur_gend=$_POST['sur_gend'];
	$sur_birth_y=$_POST['sur_birth_y'];
	$sur_birth_m=$_POST['sur_birth_m'];
	$sur_birth_d=$_POST['sur_birth_d'];
	$sur_age = 2016 - $sur_birth_y + 1;

	$sur_god=$_POST['sur_god'];
	$sur_god_txt=$_POST['sur_god_txt'];
	$sur_pain=$_POST['sur_pain'];
	$sur_nrs=$_POST['sur_nrs'];
	
	$sur_edu=$_POST['sur_edu'];
	$sur_edu_txt=$_POST['sur_edu_txt'];

	$sur_fm1 = implode('&!#', $_POST['sur_fm1']);
	$sur_fm2 = implode('&!#', $_POST['sur_fm2']);
	$sur_fm3 = implode('&!#', $_POST['sur_fm3']);	
	$sur_fm1_txt=$_POST['sur_fm1_txt'];
	$sur_fm2_txt=$_POST['sur_fm2_txt'];
	$sur_fm3_txt=$_POST['sur_fm3_txt'];		

	$sur_vigo1=$_POST['sur_vigo1'];
	$sur_vigo2=$_POST['sur_vigo2'];
	$sur_vigo3=$_POST['sur_vigo3'];
	$sur_vigo4=$_POST['sur_vigo4'];

	$sur_height=$_POST['sur_height'];
 	$sur_weight=$_POST['sur_weight'];
	
	$sur_state=$_POST['sur_state'];
		
 	//==================================================================
	//입소날짜 구하기
	//==================================================================
	
	//오늘 날짜 구하기
	$today_y = date("Y");
	$today_m = date("m");
	$today_d = date("d");
	
	//입력한 날짜
	$sur_enter_y=$_POST['sur_enter_y'];
	$sur_enter_m=$_POST['sur_enter_m'];
	$sur_enter_d=$_POST['sur_enter_d'];

	//날짜 계산하기
	$date_today = $today_y."-".$today_m."-".$today_d;
	$date_enter = $sur_enter_y."-".$sur_enter_m."-".$sur_enter_d;
			 
	$start = new DateTime($date_enter); 
	$end = new DateTime($date_today);
	
	$diff = date_diff($start, $end);

	//입소일자 계산
	$sur_enter_day = $diff->days;
	//echo $sur_enter_day;
	//==================================================================
	//입소날짜 구하기 끝
	//==================================================================
 	

 	$sur_ck2_1 = implode('&!#', $_POST['sur_ck2_1']);
	$sur_ck2_2 = implode('&!#', $_POST['sur_ck2_2']);	
	$sur_ck2_1_txt=$_POST['sur_ck2_1_txt'];
	$sur_ck2_2_txt=$_POST['sur_ck2_2_txt'];
 
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
		$sql = "INSERT INTO nurse2016_ck2_view
				(n_key, n_name, p_key, p_name, 
				sur_gend,		sur_birth_y,		sur_birth_m,		sur_birth_d,		sur_age, 		sur_god, 		sur_god_txt,
				sur_pain,		sur_nrs,
				sur_edu,		sur_edu_txt,
				sur_fm1, 		sur_fm1_txt,		sur_fm2,			sur_fm2_txt, 		sur_fm3, 		sur_fm3_txt, 	sur_vigo1, 	sur_vigo2,		sur_vigo3,
				sur_vigo4,		sur_height,			sur_weight,			sur_state,			sur_enter_y,	sur_enter_m,	sur_enter_d,	sur_enter_day,
				sur_ck2_1, 		sur_ck2_1_txt,		sur_ck2_2, 			sur_ck2_2_txt,
				input_time
				)
				
				VALUES
		
				('$n_key', '$n_id', '$p_key', '$p_name',								
				'$sur_gend',	'$sur_birth_y',		'$sur_birth_m',		'$sur_birth_d',		'$sur_age',		'$sur_god',		'$sur_god_txt',		
				'$sur_pain',	'$sur_nrs',
				'$sur_edu',		'$sur_edu_txt',
				'$sur_fm1',		'$sur_fm1_txt',		'$sur_fm2',			'$sur_fm2_txt',		'$sur_fm3',		'$sur_fm3_txt',	'$sur_vigo1',	'$sur_vigo2',	'$sur_vigo3',
				'$sur_vigo4',	'$sur_height',		'$sur_weight',		'$sur_state',		'$sur_enter_y',	'$sur_enter_m',	'$sur_enter_d',	'$sur_enter_day',
				'$sur_ck2_1',	'$sur_ck2_1_txt',	'$sur_ck2_2',		'$sur_ck2_2_txt', 	
				'$input_time'
				);
		";
		echo $sql;
		
	}

	else
	{	
		//DB에 설문 값을 수정
		$sql = "UPDATE nurse2016_ck2_view SET	 
				
				n_key = '$n_key',		n_name = '$n_id',	
				sur_gend = '$sur_gend',			sur_birth_y = '$sur_birth_y',		sur_birth_m = '$sur_birth_m',		sur_birth_d = '$sur_birth_d',		sur_age = '$sur_age',
				sur_god = '$sur_god',			sur_god_txt = '$sur_god_txt',		
				sur_pain = '$sur_pain',			sur_nrs = '$sur_nrs',
				sur_edu = '$sur_edu',				sur_edu_txt = '$sur_edu_txt',
				sur_fm1 = '$sur_fm1',			sur_fm1_txt = '$sur_fm1_txt',		sur_fm2 = '$sur_fm2',				sur_fm2_txt = '$sur_fm2_txt',		sur_fm3 = '$sur_fm3',
				sur_fm3_txt = '$sur_fm3_txt',	sur_vigo1 = '$sur_vigo1',			sur_vigo2 = '$sur_vigo2',			sur_vigo3 = '$sur_vigo3',
				sur_vigo4 = '$sur_vigo4',		sur_height = '$sur_height',			sur_weight = '$sur_weight',			sur_state = '$sur_state',			sur_enter_y = '$sur_enter_y',
				sur_enter_m = '$sur_enter_m',	sur_enter_d = '$sur_enter_d',		sur_enter_day = '$sur_enter_day',
				sur_ck2_1 = '$sur_ck2_1', 		sur_ck2_1_txt = '$sur_ck2_1_txt',	sur_ck2_2 = '$sur_ck2_2', 			sur_ck2_2_txt = '$sur_ck2_2_txt',
				input_time = '$input_time'
				
				WHERE p_key = '$p_key';				
		";
	}
	

	//입력이든, 수정이든 모든 입력값을 백업		
	$sql_bk = "INSERT INTO nurse2016_ck2_view_bk 
			(n_key, n_name, p_key, p_name, 
				sur_gend,		sur_birth_y,		sur_birth_m,		sur_birth_d,		sur_age, 		sur_god, 		sur_god_txt,
				sur_pain,		sur_nrs,
				sur_edu,		sur_edu_txt,
				sur_fm1, 		sur_fm1_txt,		sur_fm2,			sur_fm2_txt, 		sur_fm3, 		sur_fm3_txt, 	sur_vigo1, 			sur_vigo2,		sur_vigo3,
				sur_vigo4,		sur_height,			sur_weight,			sur_state,			sur_enter_y,	sur_enter_m,	sur_enter_d,		sur_enter_day,
				sur_ck2_1, 		sur_ck2_1_txt,		sur_ck2_2, 			sur_ck2_2_txt,
				input_time

			)
					
			VALUES
	
			('$n_key', '$n_id', '$p_key', '$p_name',								
				'$sur_gend',	'$sur_birth_y',		'$sur_birth_m',		'$sur_birth_d',		'$sur_age',		'$sur_god',		'$sur_god_txt',		
				'$sur_pain',	'$sur_nrs',
				'$sur_edu',		'$sur_edu_txt',
				'$sur_fm1',		'$sur_fm1_txt',		'$sur_fm2',			'$sur_fm2_txt',		'$sur_fm3',		'$sur_fm3_txt',	'$sur_vigo1',		'$sur_vigo2',	'$sur_vigo3',
				'$sur_vigo4',	'$sur_height',		'$sur_weight',		'$sur_state',		'$sur_enter_y',	'$sur_enter_m',	'$sur_enter_d',		'$sur_enter_day',
				'$sur_ck2_1',	'$sur_ck2_1_txt',	'$sur_ck2_2',		'$sur_ck2_2_txt', 	
				'$input_time'
			);
	"; 
	
	
	
	
//print ($_SESSION["uID"]);
//print_r ($sql); 



$result = mysql_query($sql);
$result_bk = mysql_query($sql_bk);

	if($result){
		echo "<script language='javaScript'>     
				
                document.location.href='ckList2_view_modify.php?p_key=$p_key';
			</script>";
	}else{
		 echo "<script language='javaScript'>
                alert('DB오류입니다.\\n잠시후에 다시 시도해 주세요');
                document.location.href='main.php';
				</script>";
	}
 


?>

