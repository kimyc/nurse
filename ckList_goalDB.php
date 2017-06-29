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

	//질문의 개수
	$pbList_count=$_POST['pbList_count'];

	
	//정렬이 포함된 SQL 구문
	$pbList_sql=$_POST['pbList_sql'];
	$pbList_result = @mysql_query($pbList_sql, $db_info);	


	//설문문항 개수
	//$max=$pbList_count;
	$max = 18;
	for($i=1; $i<=$max ; $i++){
		$sur= "sur_".$i;	
		$sur_txt= "sur_txt_".$i;
		
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
			$sur_frm[$i] = trim($_POST[$field]);
			
			$field_txt = $sur_txt;
			$sur_txt_frm[$i] = trim($_POST[$field_txt]);

		break;	
		}

	}

/*
	for($i = 0; $i<=18; $i++){	
		mysql_data_seek($pbList_result, $i);
		$pbList = mysql_fetch_array($pbList_result);
		
		$index = $pbList['pbList_num'];

		if($sur_txt_frm[$index]!=null){

			//echo "i=".$i." ".$pbList['pbList_num']."=".$pbList['pbList_txt']."=".$sur_frm[$index]."=".$sur_txt_frm[$index]."<br>";
		}
	}
*/



	/*
	echo "n_key=".$n_key."<br>";
	echo "n_id=".$n_id."<br>";
	echo "p_key=".$p_key."<br>";
	echo "p_name=".$p_name."<br>";
	*/


	//만약 신규입력이면 insert 아니면 modify
	if($which_i_m == 'i')
	{	

		for($i = 0; $i<=18; $i++)	
		{

			mysql_data_seek($pbList_result, $i);
			$pbList = mysql_fetch_array($pbList_result);
			$index = $pbList['pbList_num'];

			$col_1 = $pbList['pbList_num'];
			$col_2 = $pbList['pbList_txt'];
			$col_3 = $sur_txt_frm[$index];
			$col_4 = $sur_frm[$index];
			
			if($sur_txt_frm[$index]!=null){
				//DB에 설문 값을 입력
				$sql = "INSERT INTO nurse2016_ck_goal
						(n_key, n_name, p_key, p_name, 
						pbList_num,            pbList_txt,            pbList_goal,           pbList_same, 
						input_time
						)
						
						VALUES
				
						('$n_key', '$n_id', '$p_key', '$p_name',
						'$col_1',		'$col_2',		'$col_3',		'$col_4',
						'$input_time'
						);
				";
				$result = mysql_query($sql);
			}
		}
	}



	else
	{	
		for($i=0; $i<=18; $i++)	
		{

			mysql_data_seek($pbList_result, $i);
			$pbList = mysql_fetch_array($pbList_result);
			$index = $pbList['pbList_num'];

			$col_1 = $pbList['pbList_num'];
			$col_2 = $pbList['pbList_txt'];
			$col_3 = $sur_txt_frm[$index];
			$col_4 = $sur_frm[$index];



			//문제 번호가 DB에 있으면 수정, 없으면 추가
			$pbList_num_sql = "
					SELECT * FROM nurse2016_ck_goal where n_key = '$n_key' and p_key = '$p_key' and pbList_num = '$col_1';		
				   ";		
			$pbList_num_result = @mysql_query($pbList_num_sql,$db_info);
			
			mysql_data_seek($pbList_num_result, 0);
			$pbList_num_db = mysql_fetch_array($pbList_num_result);
			//echo $pbList_num_db['pbList_num'];


			if($sur_txt_frm[$index]!=null){
				//DB에 설문 값을 수정
				$sql = "UPDATE nurse2016_ck_goal SET		 
						pbList_goal = '$col_3',	pbList_same = '$col_4'
						
						WHERE n_key = '$n_key' and p_key = '$p_key' and pbList_num = '$col_1';				
				";
				$result = mysql_query($sql);

				//echo $sql."<br>";
			}

			if($pbList_num_db['pbList_num']==null){
				//DB에 설문 값을 입력
				$sql = "INSERT INTO nurse2016_ck_goal
						(n_key, n_name, p_key, p_name, 
						pbList_num,            pbList_txt,            pbList_goal,           pbList_same, 
						input_time
						)
						
						VALUES
				
						('$n_key', '$n_id', '$p_key', '$p_name',
						'$col_1',		'$col_2',		'$col_3',		'$col_4',
						'$input_time'
						);
				";
				$result = mysql_query($sql);
			}


		}

		
	}



	//입력이든, 수정이든 모든 입력값을 백업	
	for($i=0; $i<=18; $i++)	
	{

		mysql_data_seek($pbList_result, $i);
		$pbList = mysql_fetch_array($pbList_result);
		$index = $pbList['pbList_num'];

		$col_1 = $pbList['pbList_num'];
		$col_2 = $pbList['pbList_txt'];
		$col_3 = $sur_txt_frm[$index];
		$col_4 = $sur_frm[$index];
		
		if($sur_txt_frm[$index]!=null){
			//DB에 설문 값을 입력
			$sql_bk = "INSERT INTO nurse2016_ck_goal_bk
					(n_key, n_name, p_key, p_name, 
					pbList_num,            pbList_txt,            pbList_goal,           pbList_same, 
					input_time
					)
					
					VALUES
			
					('$n_key', '$n_id', '$p_key', '$p_name',
					'$col_1',		'$col_2',		'$col_3',		'$col_4',
					'$input_time'
					);
			";
			$result_bk = mysql_query($sql_bk);
		}
	}
 
	
	
//print ($_SESSION["uID"]);
//print_r ($sql); 


//$result = mysql_query($sql);
//$result_bk = mysql_query($sql_bk);


	if($result){
		echo "<script language='javaScript'>     
				
                document.location.href='ckList_goal_modify.php?p_key=$p_key';
			</script>";
	}else{
		 echo "<script language='javaScript'>
                alert('DB오류입니다.\\n잠시후에 다시 시도해 주세요');
                document.location.href='main.php';
				</script>";
	}
 


?>

