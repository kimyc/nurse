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

	//잔존 기능 유형
	$ck_RemainType=$_POST['ck_RemainType'];

	//잔존기능이 1또는 3이면 $ck_RemainType = 1개아니면 2개
	if($ck_RemainType == 1 || $ck_RemainType == 3)
	{
		$ck_Remain_count = 1;
	}

	else
		$ck_Remain_count = 2;


	//정렬이 포함된 SQL 구문
	$pbGoal_sql = "
			SELECT * FROM nurse2016_ck_goal where n_key = '$n_key' and  p_key = '$p_key' order by rec_key asc;
		   ";
	$pbList_result = @mysql_query($pbGoal_sql, $db_info);

	$pbList_count = 18;

	for($i=1; $i<=18; $i++)
	{
		if($i<=12) $k=6;
		if($i==13) $k=4;
		if($i==14 && $ck_Remain_count==1) $k=1; 
		if($i==14 && $ck_Remain_count==2) $k=2; 
		if($i==15) $k=2;
		if($i==16) $k=3;
		if($i==17) $k=1;
		if($i==18) $k=2;

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


	/*
	//중요한 순서대로 정렬된 문제 리스트 목록
	for($i = 0; $i<$pbList_count; $i++){	
		mysql_data_seek($pbList_result, $i);
		$pbList = mysql_fetch_array($pbList_result);
		//echo $pbList['pbList_num']."=".$pbList['pbList_txt']."=".$sur_frm[$i+1].$sur_txt_frm[$i+2]."<br>";
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

		for($i=0; $i<$pbList_count; $i++)	
		{

			mysql_data_seek($pbList_result, $i);
			$pbList = mysql_fetch_array($pbList_result);
			$col_1 = $pbList['pbList_num'];
			$col_2 = $pbList['pbList_txt'];

			if($pbList['pbList_num']<=12) $k=6;
			if($pbList['pbList_num']==13) $k=4;
			if($pbList['pbList_num']==14 && $ck_Remain_count==1) $k=1;
			if($pbList['pbList_num']==14 && $ck_Remain_count==2) $k=2;
			if($pbList['pbList_num']==15) $k=2;
			if($pbList['pbList_num']==16) $k=3;
			if($pbList['pbList_num']==17) $k=1;
			if($pbList['pbList_num']==18) $k=2;	

			for($j=1; $j<=$k; $j++)
			{

				//중재 대분류 번호 DB에 입력된 내용으로 변경
				if($pbList['pbList_num']<=12)
				{
					if($j==1) $DoingL_num=1; 
					if($j==2) $DoingL_num=2;
					if($j==3) $DoingL_num=3;
					if($j==4) $DoingL_num=4;
					if($j==5) $DoingL_num=5;
					if($j==6) $DoingL_num=8;
				}

				if($pbList['pbList_num']==13)
				{
					if($j==1) $DoingL_num=6; 
					if($j==2) $DoingL_num=9;
					if($j==3) $DoingL_num=10;
					if($j==4) $DoingL_num=11;
				}

				if($pbList['pbList_num']==14 && $ck_Remain_count==1)
				{
					if($j==1) $DoingL_num=7; 
				}

				if($pbList['pbList_num']==14 && $ck_Remain_count==2)
				{
					if($j==1) $DoingL_num=6; 
					if($j==2) $DoingL_num=7; 
				}

				if($pbList['pbList_num']==15)
				{
					if($j==1) $DoingL_num=10; 
					if($j==2) $DoingL_num=11;
				}

				if($pbList['pbList_num']==16)
				{
					if($j==1) $DoingL_num=9; 
					if($j==2) $DoingL_num=10;
					if($j==3) $DoingL_num=11;
				}

				if($pbList['pbList_num']==17)
				{
					if($j==1) $DoingL_num=12; 
				}

				if($pbList['pbList_num']==18)
				{
					if($j==1) $DoingL_num=4; 
					if($j==2) $DoingL_num=8;
				}

				$col_3 = $DoingL_num;
				$col_4 = $doing[$pbList['pbList_num']][$j];
				
				
				if($col_1!=null)
				{

					//DB에 설문 값을 입력
					$sql = "INSERT INTO nurse2016_ck_doing
							(n_key, n_name, p_key, p_name, 
							pbList_num,            pbList_txt,            DoingL,           DoingS, 
							input_time
							)
							
							VALUES
					
							('$n_key', '$n_id', '$p_key', '$p_name',
							'$col_1',		'$col_2',		'$col_3',		'$col_4',
							'$input_time'
							);
					";
					$result = mysql_query($sql);
					//echo $sql."<br>";
				}
				
			}
		}
	}



	else
	{	

		for($i=0; $i<$pbList_count; $i++)	
		{

			mysql_data_seek($pbList_result, $i);
			$pbList = mysql_fetch_array($pbList_result);
			$col_1 = $pbList['pbList_num'];
			$col_2 = $pbList['pbList_txt'];

			if($pbList['pbList_num']<=12) $k=6;
			if($pbList['pbList_num']==13) $k=4;
			if($pbList['pbList_num']==14 && $ck_Remain_count==1) $k=1;
			if($pbList['pbList_num']==14 && $ck_Remain_count==2) $k=2;
			if($pbList['pbList_num']==15) $k=2;
			if($pbList['pbList_num']==16) $k=3;
			if($pbList['pbList_num']==17) $k=1;
			if($pbList['pbList_num']==18) $k=2;
			if($pbList['pbList_num']>=19) $k=12;		

			for($j=1; $j<=$k; $j++)
			{
				//중재 대분류 번호 DB에 입력된 내용으로 변경
				if($pbList['pbList_num']<=12)
				{
					if($j==1) $DoingL_num=1; 
					if($j==2) $DoingL_num=2;
					if($j==3) $DoingL_num=3;
					if($j==4) $DoingL_num=4;
					if($j==5) $DoingL_num=5;
					if($j==6) $DoingL_num=8;
				}

				if($pbList['pbList_num']==13)
				{
					if($j==1) $DoingL_num=6; 
					if($j==2) $DoingL_num=9;
					if($j==3) $DoingL_num=10;
					if($j==4) $DoingL_num=11;
				}

				if($pbList['pbList_num']==14 && $ck_Remain_count==1)
				{
					if($j==1) $DoingL_num=7; 
				}

				if($pbList['pbList_num']==14 && $ck_Remain_count==2)
				{
					if($j==1) $DoingL_num=6; 
					if($j==2) $DoingL_num=7; 
				}

				if($pbList['pbList_num']==15)
				{
					if($j==1) $DoingL_num=10; 
					if($j==2) $DoingL_num=11;
				}

				if($pbList['pbList_num']==16)
				{
					if($j==1) $DoingL_num=9; 
					if($j==2) $DoingL_num=10;
					if($j==3) $DoingL_num=11;
				}

				if($pbList['pbList_num']==17)
				{
					if($j==1) $DoingL_num=12; 
				}

				if($pbList['pbList_num']==18)
				{
					if($j==1) $DoingL_num=4; 
					if($j==2) $DoingL_num=8;
				}

				$col_3 = $DoingL_num;
				$col_4 = $doing[$pbList['pbList_num']][$j];
				
				if($col_1!=null)
				{

				//DB에 설문 값을 입력
				$sql = "UPDATE nurse2016_ck_doing SET
						DoingS = '$col_4'
					
					WHERE n_key = '$n_key' and p_key = '$p_key' and pbList_num = '$col_1'  and 	DoingL = '$col_3' ;			
				";
				$result = mysql_query($sql);
				//echo "aa=".$sql."<br>";
				}
				
			}
		}
	}





	//입력이든, 수정이든 모든 입력값을 백업	
	for($i=0; $i<$pbList_count; $i++)	
	{

		mysql_data_seek($pbList_result, $i);
		$pbList = mysql_fetch_array($pbList_result);
		$col_1 = $pbList['pbList_num'];
		$col_2 = $pbList['pbList_txt'];

		if($pbList['pbList_num']<=12) $k=6;
		if($pbList['pbList_num']==13) $k=4;
		if($pbList['pbList_num']==14 && $ck_Remain_count==1) $k=1;
		if($pbList['pbList_num']==14 && $ck_Remain_count==2) $k=2;
		if($pbList['pbList_num']==15) $k=2;
		if($pbList['pbList_num']==16) $k=3;
		if($pbList['pbList_num']==17) $k=1;
		if($pbList['pbList_num']==18) $k=2;	

		for($j=1; $j<=$k; $j++)
		{

				//중재 대분류 번호 DB에 입력된 내용으로 변경
				if($pbList['pbList_num']<=12)
				{
					if($j==1) $DoingL_num=1; 
					if($j==2) $DoingL_num=2;
					if($j==3) $DoingL_num=3;
					if($j==4) $DoingL_num=4;
					if($j==5) $DoingL_num=5;
					if($j==6) $DoingL_num=8;
				}

				if($pbList['pbList_num']==13)
				{
					if($j==1) $DoingL_num=6; 
					if($j==2) $DoingL_num=9;
					if($j==3) $DoingL_num=10;
					if($j==4) $DoingL_num=11;
				}

				if($pbList['pbList_num']==14 && $ck_Remain_count==1)
				{
					if($j==1) $DoingL_num=7; 
				}

				if($pbList['pbList_num']==14 && $ck_Remain_count==2)
				{
					if($j==1) $DoingL_num=6; 
					if($j==2) $DoingL_num=7; 
				}

				if($pbList['pbList_num']==15)
				{
					if($j==1) $DoingL_num=10; 
					if($j==2) $DoingL_num=11;
				}

				if($pbList['pbList_num']==16)
				{
					if($j==1) $DoingL_num=9; 
					if($j==2) $DoingL_num=10;
					if($j==3) $DoingL_num=11;
				}

				if($pbList['pbList_num']==17)
				{
					if($j==1) $DoingL_num=12; 
				}

				if($pbList['pbList_num']==18)
				{
					if($j==1) $DoingL_num=4; 
					if($j==2) $DoingL_num=8;
				}

			$col_3 = $DoingL_num;
			$col_4 = $doing[$pbList['pbList_num']][$j];
		
			if($col_1!=null)
			{

				//DB에 설문 값을 입력
				$sql_bk = "INSERT INTO nurse2016_ck_doing_bk
						(n_key, n_name, p_key, p_name, 
						pbList_num,            pbList_txt,            DoingL,           DoingS, 
						input_time
						)
						
						VALUES
				
						('$n_key', '$n_id', '$p_key', '$p_name',
						'$col_1',		'$col_2',		'$col_3',		'$col_4',
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
				
                document.location.href='ckList_doing_modify.php?p_key=$p_key';
			</script>";
	}else{
		 echo "<script language='javaScript'>
                alert('DB오류입니다.\\n잠시후에 다시 시도해 주세요');
                document.location.href='main.php';
				</script>";
	}



?>

