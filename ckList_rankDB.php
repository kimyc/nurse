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

	//사정항목에 체크한 대로 문제리스트가 보이는 SQL구문
	$pbList_sql=$_POST['pbList_sql'];

	$index = 1;

	//설문문항 개수
	$max=18;

	for($i=1; $i<=$max ; $i++){
		$sur= "sur_rank_".$i;	
		
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

	//만약 신규입력이면 insert 아니면 modify
	if($which_i_m == 'i')
	{	
		//DB에 설문 값을 입력
		$sql = "INSERT INTO nurse2016_ck_rank
				(n_key, n_name, p_key, p_name, 
				ckRank_1,            ckRank_2,            ckRank_3,           ckRank_4,           ckRank_5, 
				ckRank_6,            ckRank_7,            ckRank_8,           ckRank_9,			  ckRank_10,
				ckRank_11,           ckRank_12,           ckRank_13,          ckRank_14,          ckRank_15,           
				ckRank_16,           ckRank_17,			  ckRank_18,	
				input_time
				)
				
				VALUES
		
				('$n_key', '$n_id', '$p_key', '$p_name',
				'$sur_frm[1]',		'$sur_frm[2]',		'$sur_frm[3]',		'$sur_frm[4]',		'$sur_frm[5]',
				'$sur_frm[6]',		'$sur_frm[7]',		'$sur_frm[8]',      '$sur_frm[9]',      '$sur_frm[10]',
				'$sur_frm[11]',		'$sur_frm[12]',		'$sur_frm[13]',		'$sur_frm[14]',		'$sur_frm[15]',		
				'$sur_frm[16]',		'$sur_frm[17]',		'$sur_frm[18]',		
				'$input_time'
				);
		";

		//사정항목에 체크한 대로 문제리스트가 보이는 SQL구문을 저장	
		$sql_view = "INSERT INTO nurse2016_view_SQL
					(n_key, n_name, p_key, p_name, 
					ViewSQL,		
					input_time
					)
				
					VALUES
		
					('$n_key', '$n_id', '$p_key', '$p_name',
					'$pbList_sql',	
					'$input_time'
					);
		"; 
		$result_view = mysql_query($sql_view);

	}

	else
	{	
		//DB에 설문 값을 수정
		$sql = "UPDATE nurse2016_ck_rank SET		 
				
				n_key = '$n_key',		n_name = '$n_id',	
				ckRank_1 = '$sur_frm[1]',		ckRank_2 = '$sur_frm[2]',		ckRank_3 = '$sur_frm[3]',		
				ckRank_4 = '$sur_frm[4]',		ckRank_5 = '$sur_frm[5]',		ckRank_6 = '$sur_frm[6]',		
				ckRank_7 = '$sur_frm[7]',		ckRank_8 = '$sur_frm[8]',		ckRank_9 = '$sur_frm[9]',     
				ckRank_10 = '$sur_frm[10]',		ckRank_11 = '$sur_frm[11]',		ckRank_12 = '$sur_frm[12]',
				ckRank_13 = '$sur_frm[13]',		ckRank_14 = '$sur_frm[14]',		ckRank_15 = '$sur_frm[15]',
				ckRank_16 = '$sur_frm[16]',		ckRank_17 = '$sur_frm[17]',		ckRank_18 = '$sur_frm[18]',
				input_time = '$input_time'
				
				WHERE n_key = '$n_key' and p_key = '$p_key';				
		";

		//사정항목에 체크한 대로 문제리스트가 보이는 SQL구문을 수정	
		$sql_view = "UPDATE nurse2016_view_SQL SET
					
					ViewSQL = '$pbList_sql', 
					input_time = '$input_time'
					
					WHERE n_key = '$n_key' and p_key = '$p_key';	
				
					;
		"; 
		$result_view = mysql_query($sql_view);
	}

	//입력이든, 수정이든 모든 입력값을 백업		
	$sql_bk = "INSERT INTO nurse2016_ck_rank_bk
				(n_key, n_name, p_key, p_name, 
				ckRank_1,            ckRank_2,            ckRank_3,           ckRank_4,           ckRank_5, 
				ckRank_6,            ckRank_7,            ckRank_8,           ckRank_9,			  ckRank_10,
				ckRank_11,           ckRank_12,           ckRank_13,          ckRank_14,          ckRank_15,           
				ckRank_16,           ckRank_17,			  ckRank_18,		  	
				input_time
				)
			
				VALUES
	
				('$n_key', '$n_id', '$p_key', '$p_name',
				'$sur_frm[1]',		'$sur_frm[2]',		'$sur_frm[3]',		'$sur_frm[4]',		'$sur_frm[5]',
				'$sur_frm[6]',		'$sur_frm[7]',		'$sur_frm[8]',      '$sur_frm[9]',      '$sur_frm[10]',
				'$sur_frm[11]',		'$sur_frm[12]',		'$sur_frm[13]',		'$sur_frm[14]',		'$sur_frm[15]',		
				'$sur_frm[16]',		'$sur_frm[17]',		'$sur_frm[18]',		
				'$input_time'
				);
	"; 
	
	//입력이든, 수정이든 모든 SQL구문을 백업	
	$sql_view_bk = "INSERT INTO nurse2016_view_SQL_bk
					(n_key, n_name, p_key, p_name, 
					ViewSQL,		
					input_time
					)
				
					VALUES
		
					('$n_key', '$n_id', '$p_key', '$p_name',
					'$pbList_sql',	
					'$input_time'
					);
	"; 
	$result_view_bk = mysql_query($sql_view_bk);


	
	//echo $sql_view;
//print ($_SESSION["uID"]);
//print_r ($sql); 


$result = mysql_query($sql);
$result_bk = mysql_query($sql_bk);




	if($result){
		echo "<script language='javaScript'>     
				
                document.location.href='ckList_rank_modify.php?p_key=$p_key';
			</script>";
	}else{
		 echo "<script language='javaScript'>
                alert('DB오류입니다.\\n잠시후에 다시 시도해 주세요');
                document.location.href='main.php';
				</script>";
	}
         




?>

