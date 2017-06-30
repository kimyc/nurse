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

	$index = 1;

	//설문문항 개수
	$max=22;

	for($i=1; $i<=$max ; $i++){
		$sur= "sur_".$i;	
		
		switch($i) {	
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
			case 7:
			case 8:
			case 9:
			case 10:
			case 11:
			case 12:
			case 13:
			case 14:
			case 15:
			case 16:
			case 17:
			case 18:
			case 19:
			case 20:
			case 21:
			case 22:

			$field = $sur;
			$sur_frm[$index++] = trim($_POST[$field]);		
		break;	
		}

	}



	/*
	echo "n_key=".$n_key."<br>";
	echo "n_id=".$n_id."<br>";
	echo "p_key=".$p_key."<br>";
	echo "p_name=".$p_name."<br>";
	*/
	//설문입력 합
	$index2 = 1;
	$score = 0;

	for($i=1; $i<=$max ; $i++)
	{
		$score = $score + $sur_frm[$index2];
		$index2++;
	}
	
	echo "score=".$score;
	

	//만약 신규입력이면 insert 아니면 modify
	if($which_i_m == 'i')
	{	
		//DB에 설문 값을 입력
		$sql = "INSERT INTO nurse2016_ck8_view
				(n_key, n_name, p_key, p_name, 
				sur_ck8_1,             sur_ck8_2,            sur_ck8_3,            sur_ck8_4,           sur_ck8_5, 
				sur_ck8_6,             sur_ck8_7,            sur_ck8_8,            sur_ck8_9,			sur_ck8_10,
				sur_ck8_11,            sur_ck8_12,           sur_ck8_13,           sur_ck8_14,          sur_ck8_15,           
				sur_ck8_16,            sur_ck8_17,           sur_ck8_18,           sur_ck8_19,          sur_ck8_20,           
				sur_ck8_21,            sur_ck8_22,
				sur_ck8_sum,
				input_time
				)
				
				VALUES
		
				('$n_key', '$n_id', '$p_key', '$p_name',
				'$sur_frm[1]',		'$sur_frm[2]',		'$sur_frm[3]',		'$sur_frm[4]',		'$sur_frm[5]',
				'$sur_frm[6]',		'$sur_frm[7]',		'$sur_frm[8]',      '$sur_frm[9]',      '$sur_frm[10]',
				'$sur_frm[11]',		'$sur_frm[12]',		'$sur_frm[13]',		'$sur_frm[14]',		'$sur_frm[15]',		
				'$sur_frm[16]',		'$sur_frm[17]',		'$sur_frm[18]',		'$sur_frm[19]',		'$sur_frm[20]',		
				'$sur_frm[21]',		'$sur_frm[22]',   
				'$score',
				'$input_time'
				);
		";
	}

	else
	{	
		//DB에 설문 값을 수정
		$sql = "UPDATE nurse2016_ck8_view SET		 
				
				n_key = '$n_key',		n_name = '$n_id',	
				sur_ck8_1 = '$sur_frm[1]',		sur_ck8_2 = '$sur_frm[2]',		sur_ck8_3 = '$sur_frm[3]',		sur_ck8_4 = '$sur_frm[4]',		sur_ck8_5 = '$sur_frm[5]',
				sur_ck8_6 = '$sur_frm[6]',		sur_ck8_7 = '$sur_frm[7]',		sur_ck8_8 = '$sur_frm[8]',      sur_ck8_9 = '$sur_frm[9]',      sur_ck8_10 = '$sur_frm[10]', 
				sur_ck8_11 = '$sur_frm[11]',	sur_ck8_12 = '$sur_frm[12]',	sur_ck8_13 = '$sur_frm[13]',	sur_ck8_14 = '$sur_frm[14]',	sur_ck8_15 = '$sur_frm[15]',
				sur_ck8_16 = '$sur_frm[16]',	sur_ck8_17 = '$sur_frm[17]',	sur_ck8_18 = '$sur_frm[18]',    sur_ck8_19 = '$sur_frm[19]',    sur_ck8_20 = '$sur_frm[20]',
				sur_ck8_21 = '$sur_frm[21]',	sur_ck8_22 = '$sur_frm[22]',	
				sur_ck8_sum = '$score',

				input_time = '$input_time'
				
				WHERE p_key = '$p_key';					
		";
	}

	//입력이든, 수정이든 모든 입력값을 백업		
	$sql_bk = "INSERT INTO nurse2016_ck8_view_bk
			(n_key, n_name, p_key, p_name, 
				sur_ck8_1,             sur_ck8_2,            sur_ck8_3,            sur_ck8_4,           sur_ck8_5, 
				sur_ck8_6,             sur_ck8_7,            sur_ck8_8,            sur_ck8_9,			sur_ck8_10,
				sur_ck8_11,            sur_ck8_12,           sur_ck8_13,           sur_ck8_14,          sur_ck8_15,           
				sur_ck8_16,            sur_ck8_17,           sur_ck8_18,           sur_ck8_19,          sur_ck8_20,           
				sur_ck8_21,            sur_ck8_22,
				sur_ck8_sum,
				input_time
			)
			
			VALUES
	
			('$n_key', '$n_id', '$p_key', '$p_name',
				'$sur_frm[1]',		'$sur_frm[2]',		'$sur_frm[3]',		'$sur_frm[4]',		'$sur_frm[5]',
				'$sur_frm[6]',		'$sur_frm[7]',		'$sur_frm[8]',      '$sur_frm[9]',      '$sur_frm[10]',
				'$sur_frm[11]',		'$sur_frm[12]',		'$sur_frm[13]',		'$sur_frm[14]',		'$sur_frm[15]',		
				'$sur_frm[16]',		'$sur_frm[17]',		'$sur_frm[18]',		'$sur_frm[19]',		'$sur_frm[20]',		
				'$sur_frm[21]',		'$sur_frm[22]',   
				'$score',
				'$input_time'
			);
	"; 
	
	
//print ($_SESSION["uID"]);
//print_r ($sql); 


$result = mysql_query($sql);
$result_bk = mysql_query($sql_bk);


	if($result){
		echo "<script language='javaScript'>     
				
                document.location.href='ckList8_view_modify.php?p_key=$p_key';
			</script>";
	}else{
		 echo "<script language='javaScript'>
                alert('DB오류입니다.\\n잠시후에 다시 시도해 주세요');
                document.location.href='main.php';
				</script>";
	}
            




?>

