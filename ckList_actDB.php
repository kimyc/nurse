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

	//문제 리스트의 개수
	$pbList_Group=$_POST['pbList_Group'];

	//정렬이 포함된 SQL 구문
	/*
	$pbGoal_sql = "
			SELECT * FROM nurse2016_ck_goal where n_key = '$n_key' and  p_key = '$p_key' order by rec_key asc;
		   ";
	$pbList_result = @mysql_query($pbGoal_sql, $db_info);
	

	for($i=1; $i<=21; $i++)
	{
		if($i<=12) $k=6;
		if($i==13) $k=4;
		if($i==14) $k=1;
		if($i==15) $k=2;
		if($i==16) $k=3;
		if($i==17) $k=1;
		if($i==18) $k=2;
		if($i>=19) $k=12;

		for($j=1; $j<=$k; $j++)
		{
			$sur = "sur_fm".$i."_".$j;
			$doing[$i][$j] = implode('&!#', $_POST[$sur]);
			
			if($doing[$i][$j]!=null)
			{
				//echo "[".$i."][".$j."]=".$doing[$i][$j]."<br>";
			}
		}		
	}
	*/


	
	//중요한 순서대로 정렬된 문제 리스트 목록
	for($i = 0; $i<$pbList_count; $i++){	
		mysql_data_seek($pbList_result, $i);
		$pbList = mysql_fetch_array($pbList_result);
		//echo $pbList['pbList_num']."=".$pbList['pbList_txt']."=".$sur_frm[$i+1].$sur_txt_frm[$i+2]."<br>";
	}
	


	/*
	echo "n_key=".$n_key."<br>";
	echo "n_id=".$n_id."<br>";
	echo "p_key=".$p_key."<br>";
	echo "p_name=".$p_name."<br>";
	*/

	

	for($i=0; $i<$pbList_count; $i++)
	{


		$pbList_key = "pbList_".$i;
		$DoingL_key = "DoingL_".$i;
		

		$pbList[$i]=$_POST[$pbList_key];
		$DoingL[$i]=$_POST[$DoingL_key];


		for($ss = 0; $ss < 21; $ss++)
		{

			$DoingS_temp1[$i][$ss]="DoingS_".$i."_".$ss;
			$DoingS_temp2 = $DoingS_temp1[$i][$ss];
			$DoingS = $_POST[$DoingS_temp2];

			$sur_1_temp1[$i][$ss]="sur_1_".$i."_".$ss;
			$sur_1_temp2 = $sur_1_temp1[$i][$ss];
			$sur_1 = $_POST[$sur_1_temp2];

			$sur_2_temp1[$i][$ss]="sur_2_".$i."_".$ss;
			$sur_2_temp2 = $sur_2_temp1[$i][$ss];
			$sur_2 = $_POST[$sur_2_temp2];

			$sur_3_temp1[$i][$ss]="sur_3_".$i."_".$ss;
			$sur_3_temp2 = $sur_3_temp1[$i][$ss];
			$sur_3 = $_POST[$sur_3_temp2];




			//현재 문제 번호의 문제내용
			$pbList_txt_sql = "
					SELECT pbList_txt FROM nurse2016_pbList where pbList_num = '$pbList[$i]' ;
				   ";
			$pbList_txt_result = @mysql_query($pbList_txt_sql);
			$pbList_txt = mysql_result($pbList_txt_result, 0);


			$col_1 = $pbList[$i];
			$col_2 = $pbList_txt;
			$col_3 = $DoingL[$i];
			$col_4 = $DoingS;

			$col_5 = $sur_1;
			$col_6 = $sur_2;
			$col_7 = $sur_3;

			
			if($col_4 !=null)
			{
				//만약 신규입력이면 insert 아니면 modify
				if($which_i_m == 'i')
				{

					//DB에 설문 값을 입력
					$sql = "INSERT INTO nurse2016_ck_act
							(n_key, n_name, p_key, p_name, 
							pbList_num,            pbList_txt,            DoingL,           DoingS,           sur_1,           sur_2,           sur_3, 
							input_time
							)
							
							VALUES
					
							('$n_key', '$n_id', '$p_key', '$p_name',
							'$col_1',		'$col_2',		'$col_3',		'$col_4',		'$col_5',		'$col_6',		'$col_7',
							'$input_time'
							);
					";
					$result = mysql_query($sql);
					//echo $sql."<br>";
				}

				else
				{
					//DB에 설문 값을 입력
					$sql = "UPDATE nurse2016_ck_act SET
							sur_1 = '$col_5',	sur_2 = '$col_6',	sur_3 = '$col_7' 
						
						WHERE n_key = '$n_key' and p_key = '$p_key' and pbList_num = '$col_1' and DoingL = '$col_3' and DoingS = '$col_4' ;			
					";
					$result = mysql_query($sql);
					//echo "aa=".$sql."<br>";
				}
			}
			
			
				//입력이든, 수정이든 모든 입력값을 백업	
				//DB에 설문 값을 입력
				if($col_4 !=null)
				{
						$sql_bk = "INSERT INTO nurse2016_ck_act_bk
								(n_key, n_name, p_key, p_name, 
								pbList_num,            pbList_txt,            DoingL,           DoingS,           sur_1,           sur_2,           sur_3, 
								input_time
								)
								
								VALUES
						
								('$n_key', '$n_id', '$p_key', '$p_name',
								'$col_1',		'$col_2',		'$col_3',		'$col_4',		'$col_5',		'$col_6',		'$col_7',
								'$input_time'
								);
					";
					$result_bk = mysql_query($sql_bk);
					//echo $sql_bk."<br>";

				}


		}
	}






	
//print ($_SESSION["uID"]);
//print_r ($sql); 


//$result = mysql_query($sql);
//$result_bk = mysql_query($sql_bk);



	if($result){
		echo "<script language='javaScript'>     
				
                document.location.href='ckList_act_modify.php?p_key=$p_key';
			</script>";
	}else{
		 echo "<script language='javaScript'>
                alert('DB오류입니다.\\n잠시후에 다시 시도해 주세요');
                document.location.href='main.php';
				</script>";
	}



?>

