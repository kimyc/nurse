<!-- UTF-8 형식으로 저장 -->
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<!-- CSS -->
<link type="text/css" rel="stylesheet" href="./css/core.css">

<?
		include "conf.php";

		//세션 시작
		session_start();

		//로그아웃 상태 체크
		if($_SESSION['sess_id']==null) $logout = 0;
		else $logout=1;

		//로그인한 간호사의 정보를 변수에 저장
		$n_key = $_SESSION['sess_rec_key']; 
		$n_id = $_SESSION['sess_id']; 

		//main.php에서 넘어온 값
		$p_key=$_GET['p_key'];
		
		//신규입력인지 수정인지
		$which_i_m = "i";

		//입력시간 저장
		$input_time= date("ymdHis",time());

		//DB에서 환자 이름 불러오기
		$pname_sql = "
				SELECT p_name FROM nurse2016_patient where rec_key='$p_key';
			   ";
		$pname_result = @mysql_query($pname_sql);
		$p_name = mysql_result($pname_result, 0);


		//잔존기능에 따른 유형 불러오기		
		$ck_Remain_sql = "
				SELECT cKRemain_type FROM nurse2016_ck1_remain where p_key = '$p_key';
			   ";
		$ck_Remain_result = @mysql_query($ck_Remain_sql);
		$ck_RemainType = mysql_result($ck_Remain_result, 0);
		
		//echo "b=".$ck_RemainType;


		//유형이 없는 경우 경고 메시지
		if(!$ck_RemainType){
				echo "<script language='javaScript'>
					alert('해당 유형이 없습니다.\\n잔존기능을 입력해주세요');
					document.location.href='main.php';
					</script>";
		}
?>

<html>

	<!--로그인 하지 않고 이 페이지에 바로 접근하면 창 닫기-->
	<?
		
		if($logout==1){
							
		}		
		
		else 
			echo "	<script language=\"JavaScript\">
				alert(\"로그인 해주세요\");
				window.close();
				history.go(-1);
				</script>
				";
				
	?>

<head>
	<title>고려대학교 간호학과</title>
</head>
<body>
	

<script language="javascript">
//입력여부 확인
function checkIt(form){

	//문제리스트 개수 가져오기
	var pbList_count = form.pbList_count.value;

	//문제리스트 개수를 숫자로 변환
	var max_mun = parseInt(pbList_count);

	if(confirm("작성하신 정보를 제출하시겠습니까?") ) 
	{
		form.submit();
	} 
	
	else
	{
		return;
	}
 
}
</script>




<!-- 본 내용 //-->
<br>

	<!-- 설문내용 시작-->
	<table width="950" height="130" align="center" border="0" cellspacing="0">
	<form name="form" action="ckList_doingDB.php" method ="POST">

	<!--환자 정보-->
	<input type="hidden" name="p_key" size=5% value="<?=$p_key?>">
	<input type="hidden" name="p_name" size=5% value="<?=$p_name?>">
	

	<!--입력인지 수정인지-->
	<input type="hidden" name="which_i_m" size=5% value="<?=$which_i_m?>">
	
	<!--입력시간-->
	<input type="hidden" name="input_time" size=5% value="<?=$input_time?>">	

	<tr>
		<td>

		<!--질문 시작-->
		<table width="100%" height="20" align="center" border="0" cellspacing="0"">
			<tr>
				<td width = "100%" height="40" align="left" bgcolor="85a6ff">&nbsp;&nbsp;&nbsp;
					<font color="white" size=4><b>중재 항목(환자이름 : <font color=white><?echo $p_name?><?echo " / "; 
						if($ck_RemainType==1) echo "신체기능과 인지기능 비교적 양호";
						if($ck_RemainType==2) echo "신체기능 양호하나 중등도 치매";
						if($ck_RemainType==3) echo "와상상태이나 인지기능 양호";
						if($ck_RemainType==4) echo "와상상태이면서 중등도 치매";?></font>)
					</font></b>
				</td>			
			</tr>
		</table>
		


		
		<?
/*
우선순위가 반영되지 않았기 때문에 삭제
		//문제리스트 불러오기(유형별)
		//사정에 따른 문제리스트를 보여주기 위한 SQL	
		$pbView_sql = "
				SELECT ViewSQL FROM nurse2016_view_SQL where n_key = '$n_key' and  p_key = '$p_key';
			   ";
		$pbView_result = @mysql_query($pbView_sql, $db_info);
		mysql_data_seek($pbView_result, 0);
		$sql_db = mysql_fetch_array($pbView_result);


//echo $pbGoal_sql;
//echo $sql_db['ViewSQL'];
		
		//문제 리스트 불러오기
		$pbGoal_sql = $sql_db['ViewSQL'];
		$pbGoal_result = @mysql_query($pbGoal_sql, $db_info);


		//DB에 입력된 문제리스트 개수 불러오기
		$ddd = mysql_query($sql_db['ViewSQL'], $db_info);
		$rows = mysql_num_rows($ddd);
		//echo $rows; 

		//$pbList_count = $rows;
		$pbList_count = 21;

		echo "<br>";
*/

		//문제리스트 불러오기(중요한 순으로 정렬)
		$pbGoal_sql = "
				SELECT 
				  round(avg(ckRank_1),2), round(avg(ckRank_2),2), round(avg(ckRank_3),2), round(avg(ckRank_4),2), 
				  round(avg(ckRank_5),2), round(avg(ckRank_6),2), round(avg(ckRank_7),2), round(avg(ckRank_8),2), 
				  round(avg(ckRank_9),2), round(avg(ckRank_10),2), round(avg(ckRank_11),2), round(avg(ckRank_12),2), round(avg(ckRank_13),2), round(avg(ckRank_14),2), round(avg(ckRank_15),2), round(avg(ckRank_16),2), round(avg(ckRank_17),2), round(avg(ckRank_18),2)
				FROM nurse2016_ck_rank where p_key = '$p_key';
			   ";
		$pbGoal_result = @mysql_query($pbGoal_sql, $db_info);
		mysql_data_seek($pbGoal_result, 0);
		$pbGoal_db = mysql_fetch_array($pbGoal_result);
		//echo "aaa=".$pbGoal_db['round(avg(ckRank_10),2)'];


		//평균값에 의해 정렬을 하기 위한 배열에 저장
		$pbGoal_arr[1] = $pbGoal_db['round(avg(ckRank_1),2)'];
		$pbGoal_arr[2] = $pbGoal_db['round(avg(ckRank_2),2)'];
		$pbGoal_arr[3] = $pbGoal_db['round(avg(ckRank_3),2)'];
		$pbGoal_arr[4] = $pbGoal_db['round(avg(ckRank_4),2)'];
		$pbGoal_arr[5] = $pbGoal_db['round(avg(ckRank_5),2)'];
		$pbGoal_arr[6] = $pbGoal_db['round(avg(ckRank_6),2)'];
		$pbGoal_arr[7] = $pbGoal_db['round(avg(ckRank_7),2)'];
		$pbGoal_arr[8] = $pbGoal_db['round(avg(ckRank_8),2)'];
		$pbGoal_arr[9] = $pbGoal_db['round(avg(ckRank_9),2)'];
		$pbGoal_arr[10] = $pbGoal_db['round(avg(ckRank_10),2)'];
		$pbGoal_arr[11] = $pbGoal_db['round(avg(ckRank_11),2)'];
		$pbGoal_arr[12] = $pbGoal_db['round(avg(ckRank_12),2)'];
		$pbGoal_arr[13] = $pbGoal_db['round(avg(ckRank_13),2)'];
		$pbGoal_arr[14] = $pbGoal_db['round(avg(ckRank_14),2)'];
		$pbGoal_arr[15] = $pbGoal_db['round(avg(ckRank_15),2)'];
		$pbGoal_arr[16] = $pbGoal_db['round(avg(ckRank_16),2)'];
		$pbGoal_arr[17] = $pbGoal_db['round(avg(ckRank_17),2)'];
		$pbGoal_arr[18] = $pbGoal_db['round(avg(ckRank_18),2)'];

		$pbView_sql = "
				SELECT * FROM nurse2016_view_SQL where p_key = '$p_key' group by p_key;
			   ";
		$pbView_result = @mysql_query($pbView_sql, $db_info);

		mysql_data_seek($pbView_result, 0);
		$pbViewSQL = mysql_fetch_array($pbView_result);		

		$SQL = $pbViewSQL['ViewSQL'];

		//echo $SQL;

		//문제리스트의 개수
		$pbView_Count_sql = "
				SELECT count(*) from ($SQL) C;
			   ";
		$pbView_Count_result = @mysql_query($pbView_Count_sql);
		$pbList_count = mysql_result($pbView_Count_result, 0);

		//DB에 입력된 문제리스트 불러오기
		$pbList_sql = $pbViewSQL['ViewSQL'];
		$pbList_result = @mysql_query($pbList_sql, $db_info);


		for($i=0; $i<$pbList_count; $i++)
		{
			mysql_data_seek($pbList_result, $i);
			$pbList = mysql_fetch_array($pbList_result);
			$pbList['pbList_num'];
			$kk = $pbList['pbList_num'];

			$ckRank = "round(avg(ckRank_".$kk."),2)";
			
			$sort_arr[$kk] = $pbGoal_db[$ckRank];
		}


			asort($sort_arr);

			echo "<br>";

		$i = 0;

		//평균값이 0이 아닌 문제리스트의 번호만 정렬해서 추출 후 배열에 저장
		foreach($sort_arr as $key => $val){
			if($val != null){
				//echo $key."=".$val."<br>";
				$pblist_num[$i] = $key;				
				$i++;
			}
		}

		for($i=0; $i<$pbList_count; $i++)
		{
			if($pblist_num[$i]!=null)
			{
				//echo $i."=".$pblist_num[$i]."<br>";
			}
		}
		?>
	
		<input type="hidden" name="pbList_sql" size=5% value="<?=$pbList_sql?>">

		<?
			//DB에 입력된 값 불러오기	
			$ckSQL = "
					SELECT n_key FROM nurse2016_care where n_key != '$n_key' and p_key = '$p_key' order by rec_key;
				   ";
			$ckSQL_result = @mysql_query($ckSQL);
			$job1_key = mysql_result($ckSQL_result, 0);
			$job2_key = mysql_result($ckSQL_result, 1);

			//사용자1의 직업
			$ckJob1_sql = "
					SELECT n_job FROM nurse2016_nurse where rec_key = '$job1_key';
				   ";		
			$ckJob1_result = @mysql_query($ckJob1_sql);
			$job1 = mysql_result($ckJob1_result, 0);

			//사용자2의 직업
			$ckJob2_sql = "
					SELECT n_job FROM nurse2016_nurse where rec_key = '$job2_key';
				   ";		
			$ckJob2_result = @mysql_query($ckJob2_sql);
			$job2 = mysql_result($ckJob2_result, 0);

		?>

		<table width="100%" height="20" align="center" border="0" cellspacing="0" class="bbs_wm">		

				<tr>
					<td width = "70%" align="left" bgcolor="white">
						<b>
							<?
								if($job1=="간호사") echo "<font color = red>▣ 간호사</font>";
								if($job1=="물리치료사") echo "<font color = green>● 물리치료사</font>";
								if($job1=="사회복지사") echo "<font color = blue>★ 사회복지사</font>";
							?>
								&nbsp;&nbsp;
							<?
								if($job2=="간호사") echo "<font color = red>■ 간호사</font>";
								if($job2=="물리치료사") echo "<font color = green>● 물리치료사</font>";
								if($job2=="사회복지사") echo "<font color = blue>★ 사회복지사</font>";
							?>
						</b>
					</td>
				</tr>
		</table>

		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">		

			<?

			for($i=0; $i<$pbList_count; $i++)
			{	
				/* 우선순위가 반영되지 않았으므로 삭제
				mysql_data_seek($pbGoal_result, $i);
				$pbList = mysql_fetch_array($pbGoal_result);
				if($pbList['pbList_txt']!=null){
				*/
				if($pblist_num[$i]!=null)
				{
			?>


				<tr>						
					<td width = "70%" align="left" bgcolor="dddddd">					
						<b>
							<?
								echo "&nbsp;".($i+1).". ";
								//$pbList_num = $pbList['pbList_num'];
								$pbList_num = $pblist_num[$i];
								$pbList['pbList_num'] = $pbList_num;

								//문제리스트의 출력
								$pbList_txt_sql = "
										SELECT pbList_txt from nurse2016_pbList where pbList_num = '$pblist_num[$i]';
									   ";
								$pbList_txt_result = @mysql_query($pbList_txt_sql);
								$pbList_txt = mysql_result($pbList_txt_result, 0);
								echo $pbList_txt;	
							?>
						</b>
					</td>
				</tr>
				

				<tr>
					<td>
						<font size = 2>
						<b>
						<?
							//나의 직업	
							$ckSQL0 = "
									SELECT n_key FROM nurse2016_care where n_key = '$n_key' and p_key = '$p_key';
								   ";
							$ckSQL0_result = @mysql_query($ckSQL0);
							$job0_key = mysql_result($ckSQL0_result, 0);

							//사용자1의 직업
							$ckJob0_sql = "
									SELECT n_job FROM nurse2016_nurse where rec_key = '$job0_key';
								   ";		
							$ckJob0_result = @mysql_query($ckJob0_sql);
							$job0 = mysql_result($ckJob0_result, 0);								


							//내가 간호사라면, 나머지 두 명은 물리치료사 & 사회복지사
							if($job0=="간호사") 
							{
								$job1_view = "<font size = 1 color = green>●</font>"; 
								$job2_view = "<font size = 1 color = blue>★</font>"; 
							}

							//내가 물리치료사라면, 나머지 두명은 간호사, 사회복지사
							if($job0=="물리치료사") 
							{
								$job1_view = "<font size = 1 color = red>▣</font>"; 
								$job2_view = "<font size = 1 color = blue>★</font>"; 
							}
							//내가 사회복지사라면, 나머지 두명은 간호사, 물리치료사
							if($job0=="사회복지사") 
							{
								$job1_view = "<font size = 1 color = red>▣</font>"; 
								$job2_view = "<font size = 1 color = green>●</font>"; 
							}

							if($pbList['pbList_num']<=12)
							{
								echo "&nbsp;"."중재 대분류 | 1. 신체기능의 훈련"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 1 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>		
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_1_1"><label for="ck_<?=$pbList['pbList_num']?>_1_1">&nbsp;관절운동범위 평가<? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_1_2"><label for="ck_<?=$pbList['pbList_num']?>_1_2">&nbsp;근력증강운동<? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_1_3"><label for="ck_<?=$pbList['pbList_num']?>_1_3">&nbsp;연하운동<? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_1_4"><label for="ck_<?=$pbList['pbList_num']?>_1_4">&nbsp;상지기능<? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_1_5"><label for="ck_<?=$pbList['pbList_num']?>_1_5">&nbsp;손가락 정교성 운동<? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_1_6"><label for="ck_<?=$pbList['pbList_num']?>_1_6">&nbsp;조화운동<? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;		
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "7" id="ck_<?=$pbList['pbList_num']?>_1_7"><label for="ck_<?=$pbList['pbList_num']?>_1_7">&nbsp;지구력 훈련<? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row1[$d] == "7") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row2[$d] == "7") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "8" id="ck_<?=$pbList['pbList_num']?>_1_8"><label for="ck_<?=$pbList['pbList_num']?>_1_8">&nbsp;기타<? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row1[$d] == "8") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<8; $d++){if($DoingS_Other_row2[$d] == "8") $same++;}	if($same==1) echo $job2_view; ?></label>
								<br><br>

						<?
								echo "&nbsp;"."중재 대분류 | 2. 기본동작 훈련"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 2 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_2_1"><label for="ck_<?=$pbList['pbList_num']?>_2_1">&nbsp;기본동작 평가<? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_2_2"><label for="ck_<?=$pbList['pbList_num']?>_2_2">&nbsp;뒤집기<? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_2_3"><label for="ck_<?=$pbList['pbList_num']?>_2_3">&nbsp;일어나기<? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_2_4"><label for="ck_<?=$pbList['pbList_num']?>_2_4">&nbsp;앉아있기<? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_2_5"><label for="ck_<?=$pbList['pbList_num']?>_2_5">&nbsp;일어서기<? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_2_6"><label for="ck_<?=$pbList['pbList_num']?>_2_6">&nbsp;서있기<? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "7" id="ck_<?=$pbList['pbList_num']?>_2_7"><label for="ck_<?=$pbList['pbList_num']?>_2_7">&nbsp;지구력 훈련<? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row1[$d] == "7") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row2[$d] == "7") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "8" id="ck_<?=$pbList['pbList_num']?>_2_8"><label for="ck_<?=$pbList['pbList_num']?>_2_8">&nbsp;이동<? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row1[$d] == "8") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row2[$d] == "8") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "9" id="ck_<?=$pbList['pbList_num']?>_2_9"><label for="ck_<?=$pbList['pbList_num']?>_2_9">&nbsp;휠체어 조작 및 이동<? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row1[$d] == "9") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row2[$d] == "9") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "10" id="ck_<?=$pbList['pbList_num']?>_2_10"><label for="ck_<?=$pbList['pbList_num']?>_2_10">&nbsp;보행<? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row1[$d] == "10") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row2[$d] == "10") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "11" id="ck_<?=$pbList['pbList_num']?>_2_11"><label for="ck_<?=$pbList['pbList_num']?>_2_11">&nbsp;보장구 장착 등 지켜보기<? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row1[$d] == "11") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row2[$d] == "11") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "12" id="ck_<?=$pbList['pbList_num']?>_2_12"><label for="ck_<?=$pbList['pbList_num']?>_2_12">&nbsp;도움제공<? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row1[$d] == "12") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row2[$d] == "12") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "13" id="ck_<?=$pbList['pbList_num']?>_2_13"><label for="ck_<?=$pbList['pbList_num']?>_2_13">&nbsp;기타<? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row1[$d] == "13") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<13; $d++){if($DoingS_Other_row2[$d] == "13") $same++;}	if($same==1) echo $job2_view; ?></label>
								<br><br>
						<?
								echo "&nbsp;"."중재 대분류 | 3. 일상생활동작 훈련"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 3 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_3_1"><label for="ck_<?=$pbList['pbList_num']?>_3_1">&nbsp;식사동작<? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_3_2"><label for="ck_<?=$pbList['pbList_num']?>_3_2">&nbsp;배설동작<? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_3_3"><label for="ck_<?=$pbList['pbList_num']?>_3_3">&nbsp;옷 갈아입기동작<? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_3_4"><label for="ck_<?=$pbList['pbList_num']?>_3_4">&nbsp;목욕동작<? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_3_5"><label for="ck_<?=$pbList['pbList_num']?>_3_5">&nbsp;몸단장동작<? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_3_6"><label for="ck_<?=$pbList['pbList_num']?>_3_6">&nbsp;이동동작<? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "7" id="ck_<?=$pbList['pbList_num']?>_3_7"><label for="ck_<?=$pbList['pbList_num']?>_3_7">&nbsp;요리동작<? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row1[$d] == "7") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row2[$d] == "7") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "8" id="ck_<?=$pbList['pbList_num']?>_3_8"><label for="ck_<?=$pbList['pbList_num']?>_3_8">&nbsp;가사동작 전화걸기<? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row1[$d] == "8") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row2[$d] == "8") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "9" id="ck_<?=$pbList['pbList_num']?>_3_9"><label for="ck_<?=$pbList['pbList_num']?>_3_9">&nbsp;전화받기<? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row1[$d] == "9") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row2[$d] == "9") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "10" id="ck_<?=$pbList['pbList_num']?>_3_10"><label for="ck_<?=$pbList['pbList_num']?>_3_10">&nbsp;기타<? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row1[$d] == "10") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<10; $d++){if($DoingS_Other_row2[$d] == "10") $same++;}	if($same==1) echo $job2_view; ?></label>
								<br><br>
						<?
								echo "&nbsp;"."중재 대분류 | 4. 물리치료"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 4 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_4_1"><label for="ck_<?=$pbList['pbList_num']?>_4_1">&nbsp;온열치료(핫팩 등)<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_4_2"><label for="ck_<?=$pbList['pbList_num']?>_4_2">&nbsp;수 치료<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_4_3"><label for="ck_<?=$pbList['pbList_num']?>_4_3">&nbsp;견인요법<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_4_4"><label for="ck_<?=$pbList['pbList_num']?>_4_4">&nbsp;IR(적외선)<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_4_5"><label for="ck_<?=$pbList['pbList_num']?>_4_5">&nbsp;TENS(경피신경)<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_4_6"><label for="ck_<?=$pbList['pbList_num']?>_4_6">&nbsp;parallerbar walking<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "7" id="ck_<?=$pbList['pbList_num']?>_4_7"><label for="ck_<?=$pbList['pbList_num']?>_4_7">&nbsp;aircompressure Tx<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "7") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "7") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "8" id="ck_<?=$pbList['pbList_num']?>_4_8"><label for="ck_<?=$pbList['pbList_num']?>_4_8">&nbsp;초음파(US, ultrasound)<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "8") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "8") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "9" id="ck_<?=$pbList['pbList_num']?>_4_9"><label for="ck_<?=$pbList['pbList_num']?>_4_9">&nbsp;Infra red chair<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "9") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "9") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "10" id="ck_<?=$pbList['pbList_num']?>_4_10"><label for="ck_<?=$pbList['pbList_num']?>_4_10">&nbsp;파라핀<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "10") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "10") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;<br><font color = "white">&nbsp;중재 소분류</font> |&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "11" id="ck_<?=$pbList['pbList_num']?>_4_11"><label for="ck_<?=$pbList['pbList_num']?>_4_11">&nbsp;ICT(Interferential current therapy, 간섭전류치료)<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "11") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "11") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "12" id="ck_<?=$pbList['pbList_num']?>_4_12"><label for="ck_<?=$pbList['pbList_num']?>_4_12">&nbsp;전신온열치료기<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "12") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "12") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "13" id="ck_<?=$pbList['pbList_num']?>_4_13"><label for="ck_<?=$pbList['pbList_num']?>_4_13">&nbsp;Ball Ex<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "13") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "13") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "14" id="ck_<?=$pbList['pbList_num']?>_4_14"><label for="ck_<?=$pbList['pbList_num']?>_4_14">&nbsp;Roll Ex<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "14") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "14") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "15" id="ck_<?=$pbList['pbList_num']?>_4_15"><label for="ck_<?=$pbList['pbList_num']?>_4_15">&nbsp;Mat Ex<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "15") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "15") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "16" id="ck_<?=$pbList['pbList_num']?>_4_16"><label for="ck_<?=$pbList['pbList_num']?>_4_16">&nbsp;balance Ex<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "16") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "16") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "17" id="ck_<?=$pbList['pbList_num']?>_4_17"><label for="ck_<?=$pbList['pbList_num']?>_4_17">&nbsp;Gait Ex<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "17") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "17") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "18" id="ck_<?=$pbList['pbList_num']?>_4_18"><label for="ck_<?=$pbList['pbList_num']?>_4_18">&nbsp;Weight registance Ex<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "18") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "18") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "19" id="ck_<?=$pbList['pbList_num']?>_4_19"><label for="ck_<?=$pbList['pbList_num']?>_4_19">&nbsp;ROM Ex(관절가동범위)<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "19") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "19") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;<br><font color = "white">&nbsp;중재 소분류</font> |&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "20" id="ck_<?=$pbList['pbList_num']?>_4_20"><label for="ck_<?=$pbList['pbList_num']?>_4_20">&nbsp;massage<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "20") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "20") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "21" id="ck_<?=$pbList['pbList_num']?>_4_21"><label for="ck_<?=$pbList['pbList_num']?>_4_21">&nbsp;기타<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "21") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "21") $same++;}	if($same==1) echo $job2_view; ?></label>
								<br><br>
						<?
								echo "&nbsp;"."중재 대분류 | 5. 작업치료"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 5 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_5_1"><label for="ck_<?=$pbList['pbList_num']?>_5_1">&nbsp;운동놀이<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_5_2"><label for="ck_<?=$pbList['pbList_num']?>_5_2">&nbsp;미술활동<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_5_3"><label for="ck_<?=$pbList['pbList_num']?>_5_3">&nbsp;놀이지도<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_5_4"><label for="ck_<?=$pbList['pbList_num']?>_5_4">&nbsp;도구적 일상생활 수행동작 훈련<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_5_5"><label for="ck_<?=$pbList['pbList_num']?>_5_5">&nbsp;타이핑<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_5_6"><label for="ck_<?=$pbList['pbList_num']?>_5_6">&nbsp;Stacking cones<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "7" id="ck_<?=$pbList['pbList_num']?>_5_7"><label for="ck_<?=$pbList['pbList_num']?>_5_7">&nbsp;peg board<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "7") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "7") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "8" id="ck_<?=$pbList['pbList_num']?>_5_8"><label for="ck_<?=$pbList['pbList_num']?>_5_8">&nbsp;manipulation board<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "8") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "8") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "9" id="ck_<?=$pbList['pbList_num']?>_5_9"><label for="ck_<?=$pbList['pbList_num']?>_5_9">&nbsp;bilateral sander<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "9") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "9") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "10" id="ck_<?=$pbList['pbList_num']?>_5_10"><label for="ck_<?=$pbList['pbList_num']?>_5_10">&nbsp;ROM arc<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "10") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "10") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;<br><font color = "white">&nbsp;중재 소분류</font> |&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "11" id="ck_<?=$pbList['pbList_num']?>_5_11"><label for="ck_<?=$pbList['pbList_num']?>_5_11">&nbsp;Horizontal Bolt board<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "11") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "11") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "12" id="ck_<?=$pbList['pbList_num']?>_5_12"><label for="ck_<?=$pbList['pbList_num']?>_5_12">&nbsp;의지 활동(치료적 작업활동)<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "12") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "12") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "13" id="ck_<?=$pbList['pbList_num']?>_5_13"><label for="ck_<?=$pbList['pbList_num']?>_5_13">&nbsp;습관 활동(기능유지활동)<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "13") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "13") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_5[]" value= "14" id="ck_<?=$pbList['pbList_num']?>_5_14"><label for="ck_<?=$pbList['pbList_num']?>_5_14">&nbsp;기타<? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row1[$d] == "14") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<14; $d++){if($DoingS_Other_row2[$d] == "14") $same++;}	if($same==1) echo $job2_view; ?></label>
								<br><br>
						<?
								echo "&nbsp;"."중재 대분류 | 6. 통증치료"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 8 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
							
						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_6[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_6_1"><label for="ck_<?=$pbList['pbList_num']?>_6_1">&nbsp;약물요법<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_6[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_6_2"><label for="ck_<?=$pbList['pbList_num']?>_6_2">&nbsp;핫팩<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_6[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_6_3"><label for="ck_<?=$pbList['pbList_num']?>_6_3">&nbsp;전환요법<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_6[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_6_4"><label for="ck_<?=$pbList['pbList_num']?>_6_4">&nbsp;마사지<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_6[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_6_5"><label for="ck_<?=$pbList['pbList_num']?>_6_5">&nbsp;음악요법<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_6[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_6_6"><label for="ck_<?=$pbList['pbList_num']?>_6_6">&nbsp;기타<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<br>
							

						<?
							}

							if($pbList['pbList_num']==13)
							{
								echo "&nbsp;"."중재 대분류 | 1. 인지 및 정신기능 훈련"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 6 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>

								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_1_1"><label for="ck_<?=$pbList['pbList_num']?>_1_1">&nbsp;기억전략 훈련<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_1_2"><label for="ck_<?=$pbList['pbList_num']?>_1_2">&nbsp;시간차 회상훈련<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_1_3"><label for="ck_<?=$pbList['pbList_num']?>_1_3">&nbsp;실생활에서의 지각기능훈련<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_1_4"><label for="ck_<?=$pbList['pbList_num']?>_1_4">&nbsp;판단 및 집행기능훈련<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_1_5"><label for="ck_<?=$pbList['pbList_num']?>_1_5">&nbsp;계산하기<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_1_6"><label for="ck_<?=$pbList['pbList_num']?>_1_6">&nbsp;기타<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<br><br>
						<?


								echo "&nbsp;"."중재 대분류 | 2. 치료 레크레이션"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 9 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_2_1"><label for="ck_<?=$pbList['pbList_num']?>_2_1">&nbsp;신체를 이용한 게임<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_2_2"><label for="ck_<?=$pbList['pbList_num']?>_2_2">&nbsp;도구를 이용한 게임<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_2_3"><label for="ck_<?=$pbList['pbList_num']?>_2_3">&nbsp;단기 기억력 훈련<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_2_4"><label for="ck_<?=$pbList['pbList_num']?>_2_4">&nbsp;회상요법<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_2_5"><label for="ck_<?=$pbList['pbList_num']?>_2_5">&nbsp;체조(기공, 치매 예방)<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_2_6"><label for="ck_<?=$pbList['pbList_num']?>_2_6">&nbsp;기타<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<br><br>

						<?
								echo "&nbsp;"."중재 대분류 | 3. 사회복지 프로그램"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 10 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);

						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_3_1"><label for="ck_<?=$pbList['pbList_num']?>_3_1">&nbsp;원예요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_3_2"><label for="ck_<?=$pbList['pbList_num']?>_3_2">&nbsp;음식요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_3_3"><label for="ck_<?=$pbList['pbList_num']?>_3_3">&nbsp;공예요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_3_4"><label for="ck_<?=$pbList['pbList_num']?>_3_4">&nbsp;독서요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_3_5"><label for="ck_<?=$pbList['pbList_num']?>_3_5">&nbsp;장터<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_3_6"><label for="ck_<?=$pbList['pbList_num']?>_3_6">&nbsp;나들이<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "7" id="ck_<?=$pbList['pbList_num']?>_3_7"><label for="ck_<?=$pbList['pbList_num']?>_3_7">&nbsp;지역친교<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "7") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "7") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "8" id="ck_<?=$pbList['pbList_num']?>_3_8"><label for="ck_<?=$pbList['pbList_num']?>_3_8">&nbsp;기타요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "8") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "8") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "9" id="ck_<?=$pbList['pbList_num']?>_3_9"><label for="ck_<?=$pbList['pbList_num']?>_3_9">&nbsp;보호자 상담<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "9") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "9") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<br><br>
						<?
								echo "&nbsp;"."중재 대분류 | 4. 심리 및 정신 재활 프로그램"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 11 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
							

						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_4_1"><label for="ck_<?=$pbList['pbList_num']?>_4_1">&nbsp;음악요법<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_4_2"><label for="ck_<?=$pbList['pbList_num']?>_4_2">&nbsp;미술요법<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_4_3"><label for="ck_<?=$pbList['pbList_num']?>_4_3">&nbsp;아로마요법<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_4_4"><label for="ck_<?=$pbList['pbList_num']?>_4_4">&nbsp;상담<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_4_5"><label for="ck_<?=$pbList['pbList_num']?>_4_5">&nbsp;역할극<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_4_6"><label for="ck_<?=$pbList['pbList_num']?>_4_6">&nbsp;영화감상<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_4[]" value= "7" id="ck_<?=$pbList['pbList_num']?>_4_7"><label for="ck_<?=$pbList['pbList_num']?>_4_7">&nbsp;기타<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "7") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "7") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<br>
						<?
							}

							if($pbList['pbList_num']==14)
							{
								if($ck_RemainType == 1 || $ck_RemainType == 3)
								{
									echo "&nbsp;"."중재 대분류 | 1. 언어치료"."<br>";
									echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 7 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_1_1"><label for="ck_<?=$pbList['pbList_num']?>_1_1">&nbsp;발성연습<? $same = 0; for($d=0; $d<3; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<3; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_1_2"><label for="ck_<?=$pbList['pbList_num']?>_1_2">&nbsp;구음연습<? $same = 0; for($d=0; $d<3; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<3; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_1_3"><label for="ck_<?=$pbList['pbList_num']?>_1_3">&nbsp;기타<? $same = 0; for($d=0; $d<3; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<3; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<br>
						<?
								}

								else
								{
									echo "&nbsp;"."중재 대분류 | 1. 인지 및 정신기능 훈련"."<br>";
									echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 6 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_1_1"><label for="ck_<?=$pbList['pbList_num']?>_1_1">&nbsp;기억전략 훈련<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_1_2"><label for="ck_<?=$pbList['pbList_num']?>_1_2">&nbsp;시간차 회상훈련<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_1_3"><label for="ck_<?=$pbList['pbList_num']?>_1_3">&nbsp;실생활에서의 지각기능훈련<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_1_4"><label for="ck_<?=$pbList['pbList_num']?>_1_4">&nbsp;판단 및 집행기능훈련<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_1_5"><label for="ck_<?=$pbList['pbList_num']?>_1_5">&nbsp;계산하기<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_1_6"><label for="ck_<?=$pbList['pbList_num']?>_1_6">&nbsp;기타<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<br><br>
						<?
									echo "&nbsp;"."중재 대분류 | 2. 언어치료_"."<br>";
									echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 7 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);

						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_2_1"><label for="ck_<?=$pbList['pbList_num']?>_2_1">&nbsp;발성연습<? $same = 0; for($d=0; $d<3; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<3; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_2_2"><label for="ck_<?=$pbList['pbList_num']?>_2_2">&nbsp;구음연습<? $same = 0; for($d=0; $d<3; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<3; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_2_3"><label for="ck_<?=$pbList['pbList_num']?>_2_3">&nbsp;기타<? $same = 0; for($d=0; $d<3; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<3; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<br>
						<?
								}
							}

							if($pbList['pbList_num']==15)
							{
								echo "&nbsp;"."중재 대분류 | 1. 사회복지 프로그램"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 10 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_1_1"><label for="ck_<?=$pbList['pbList_num']?>_1_1">&nbsp;원예요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_1_2"><label for="ck_<?=$pbList['pbList_num']?>_1_2">&nbsp;음식요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_1_3"><label for="ck_<?=$pbList['pbList_num']?>_1_3">&nbsp;공예요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_1_4"><label for="ck_<?=$pbList['pbList_num']?>_1_4">&nbsp;독서요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_1_5"><label for="ck_<?=$pbList['pbList_num']?>_1_5">&nbsp;장터<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_1_6"><label for="ck_<?=$pbList['pbList_num']?>_1_6">&nbsp;나들이<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "7" id="ck_<?=$pbList['pbList_num']?>_1_7"><label for="ck_<?=$pbList['pbList_num']?>_1_7">&nbsp;지역친교<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "7") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "7") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "8" id="ck_<?=$pbList['pbList_num']?>_1_8"><label for="ck_<?=$pbList['pbList_num']?>_1_8">&nbsp;기타요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "8") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "8") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "9" id="ck_<?=$pbList['pbList_num']?>_1_9"><label for="ck_<?=$pbList['pbList_num']?>_1_9">&nbsp;보호자 상담<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "9") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "9") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<br><br>
						<?
								echo "&nbsp;"."중재 대분류 | 2. 심리 및 정신 재활프로그램"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 11 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_2_1"><label for="ck_<?=$pbList['pbList_num']?>_2_1">&nbsp;음악요법<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_2_2"><label for="ck_<?=$pbList['pbList_num']?>_2_2">&nbsp;미술요법<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_2_3"><label for="ck_<?=$pbList['pbList_num']?>_2_3">&nbsp;아로마요법<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_2_4"><label for="ck_<?=$pbList['pbList_num']?>_2_4">&nbsp;상담<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_2_5"><label for="ck_<?=$pbList['pbList_num']?>_2_5">&nbsp;역할극<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_2_6"><label for="ck_<?=$pbList['pbList_num']?>_2_6">&nbsp;영화감상<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "7" id="ck_<?=$pbList['pbList_num']?>_2_7"><label for="ck_<?=$pbList['pbList_num']?>_2_7">&nbsp;기타<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "7") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "7") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<br>
						<?
							}

							if($pbList['pbList_num']==16)
							{
								echo "&nbsp;"."중재 대분류 | 1. 치료 레크레이션"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 9 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_1_1"><label for="ck_<?=$pbList['pbList_num']?>_1_1">&nbsp;신체를 이용한 게임<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_1_2"><label for="ck_<?=$pbList['pbList_num']?>_1_2">&nbsp;도구를 이용한 게임<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_1_3"><label for="ck_<?=$pbList['pbList_num']?>_1_3">&nbsp;단기 기억력 훈련<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_1_4"><label for="ck_<?=$pbList['pbList_num']?>_1_4">&nbsp;회상요법<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_1_5"><label for="ck_<?=$pbList['pbList_num']?>_1_5">&nbsp;체조(기공, 치매 예방)<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_1_6"><label for="ck_<?=$pbList['pbList_num']?>_1_6">&nbsp;기타<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<br><br>
						<?
								echo "&nbsp;"."중재 대분류 | 2. 사회복지 프로그램"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 10 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);

						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_2_1"><label for="ck_<?=$pbList['pbList_num']?>_2_1">&nbsp;원예요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_2_2"><label for="ck_<?=$pbList['pbList_num']?>_2_2">&nbsp;음식요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_2_3"><label for="ck_<?=$pbList['pbList_num']?>_2_3">&nbsp;공예요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_2_4"><label for="ck_<?=$pbList['pbList_num']?>_2_4">&nbsp;독서요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_2_5"><label for="ck_<?=$pbList['pbList_num']?>_2_5">&nbsp;장터<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_2_6"><label for="ck_<?=$pbList['pbList_num']?>_2_6">&nbsp;나들이<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "7" id="ck_<?=$pbList['pbList_num']?>_2_7"><label for="ck_<?=$pbList['pbList_num']?>_2_7">&nbsp;지역친교<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "7") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "7") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "8" id="ck_<?=$pbList['pbList_num']?>_2_8"><label for="ck_<?=$pbList['pbList_num']?>_2_8">&nbsp;기타요법<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "8") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "8") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "9" id="ck_<?=$pbList['pbList_num']?>_2_9"><label for="ck_<?=$pbList['pbList_num']?>_2_9">&nbsp;보호자 상담<? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row1[$d] == "9") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<9; $d++){if($DoingS_Other_row2[$d] == "9") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<br><br>
						<?
								echo "&nbsp;"."중재 대분류 | 3. 심리 및 정신 재활프로그램"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 11 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);

						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_3_1"><label for="ck_<?=$pbList['pbList_num']?>_3_1">&nbsp;음악요법<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_3_2"><label for="ck_<?=$pbList['pbList_num']?>_3_2">&nbsp;미술요법<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_3_3"><label for="ck_<?=$pbList['pbList_num']?>_3_3">&nbsp;아로마요법<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_3_4"><label for="ck_<?=$pbList['pbList_num']?>_3_4">&nbsp;상담<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_3_5"><label for="ck_<?=$pbList['pbList_num']?>_3_5">&nbsp;역할극<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_3_6"><label for="ck_<?=$pbList['pbList_num']?>_3_6">&nbsp;영화감상<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_3[]" value= "7" id="ck_<?=$pbList['pbList_num']?>_3_7"><label for="ck_<?=$pbList['pbList_num']?>_3_7">&nbsp;기타<? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row1[$d] == "7") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<7; $d++){if($DoingS_Other_row2[$d] == "7") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<br>
						<?
							}

							if($pbList['pbList_num']==17)
							{
								echo "&nbsp;"."중재 대분류 | 1. 영적치료"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 12 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_1_1"><label for="ck_<?=$pbList['pbList_num']?>_1_1">&nbsp;예배<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_1_2"><label for="ck_<?=$pbList['pbList_num']?>_1_2">&nbsp;기도<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_1_3"><label for="ck_<?=$pbList['pbList_num']?>_1_3">&nbsp;찬양<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_1_4"><label for="ck_<?=$pbList['pbList_num']?>_1_4">&nbsp;미사<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_1_5"><label for="ck_<?=$pbList['pbList_num']?>_1_5">&nbsp;불경듣기<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_1_6"><label for="ck_<?=$pbList['pbList_num']?>_1_6">&nbsp;기타<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<br>
						<?
							}

							if($pbList['pbList_num']==18)
							{
								echo "&nbsp;"."중재 대분류 | 1. 물리치료"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 4 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);

						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_1_1"><label for="ck_<?=$pbList['pbList_num']?>_1_1">&nbsp;온열치료(핫팩 등)<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_1_2"><label for="ck_<?=$pbList['pbList_num']?>_1_2">&nbsp;수 치료<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_1_3"><label for="ck_<?=$pbList['pbList_num']?>_1_3">&nbsp;견인요법<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_1_4"><label for="ck_<?=$pbList['pbList_num']?>_1_4">&nbsp;IR(적외선)<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_1_5"><label for="ck_<?=$pbList['pbList_num']?>_1_5">&nbsp;TENS(경피신경)<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_1_6"><label for="ck_<?=$pbList['pbList_num']?>_1_6">&nbsp;parallerbar walking<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "7" id="ck_<?=$pbList['pbList_num']?>_1_7"><label for="ck_<?=$pbList['pbList_num']?>_1_7">&nbsp;aircompressure Tx<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "7") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "7") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "8" id="ck_<?=$pbList['pbList_num']?>_1_8"><label for="ck_<?=$pbList['pbList_num']?>_1_8">&nbsp;초음파(US, ultrasound)<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "8") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "8") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "9" id="ck_<?=$pbList['pbList_num']?>_1_9"><label for="ck_<?=$pbList['pbList_num']?>_1_9">&nbsp;Infra red chair<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "9") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "9") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "10" id="ck_<?=$pbList['pbList_num']?>_1_10"><label for="ck_<?=$pbList['pbList_num']?>_1_10">&nbsp;파라핀<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "10") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "10") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;<br><font color = "white">&nbsp;중재 소분류</font> |&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "11" id="ck_<?=$pbList['pbList_num']?>_1_11"><label for="ck_<?=$pbList['pbList_num']?>_1_11">&nbsp;ICT(Interferential current therapy, 간섭전류치료)<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "11") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "11") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "12" id="ck_<?=$pbList['pbList_num']?>_1_12"><label for="ck_<?=$pbList['pbList_num']?>_1_12">&nbsp;전신온열치료기<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "12") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "12") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "13" id="ck_<?=$pbList['pbList_num']?>_1_13"><label for="ck_<?=$pbList['pbList_num']?>_1_13">&nbsp;Ball Ex<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "13") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "13") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "14" id="ck_<?=$pbList['pbList_num']?>_1_14"><label for="ck_<?=$pbList['pbList_num']?>_1_14">&nbsp;Roll Ex<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "14") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "14") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "15" id="ck_<?=$pbList['pbList_num']?>_1_15"><label for="ck_<?=$pbList['pbList_num']?>_1_15">&nbsp;Mat Ex<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "15") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "15") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "16" id="ck_<?=$pbList['pbList_num']?>_1_16"><label for="ck_<?=$pbList['pbList_num']?>_1_16">&nbsp;balance Ex<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "16") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "16") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "17" id="ck_<?=$pbList['pbList_num']?>_1_17"><label for="ck_<?=$pbList['pbList_num']?>_1_17">&nbsp;Gait Ex<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "17") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "17") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "18" id="ck_<?=$pbList['pbList_num']?>_1_18"><label for="ck_<?=$pbList['pbList_num']?>_1_18">&nbsp;Weight registance Ex<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "18") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "18") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "19" id="ck_<?=$pbList['pbList_num']?>_1_19"><label for="ck_<?=$pbList['pbList_num']?>_1_19">&nbsp;ROM Ex(관절가동범위)<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "19") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "19") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;<br><font color = "white">&nbsp;중재 소분류</font> |&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "20" id="ck_<?=$pbList['pbList_num']?>_1_20"><label for="ck_<?=$pbList['pbList_num']?>_1_20">&nbsp;massage<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "20") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "20") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_1[]" value= "21" id="ck_<?=$pbList['pbList_num']?>_1_21"><label for="ck_<?=$pbList['pbList_num']?>_1_21">&nbsp;기타<? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row1[$d] == "21") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<21; $d++){if($DoingS_Other_row2[$d] == "21") $same++;}	if($same==1) echo $job2_view; ?></label>
								<br><br>
						<?
								echo "&nbsp;"."중재 대분류 | 2. 통증치료"."<br>";
								echo "&nbsp;"."중재 소분류 | ";

								//DB에 입력된 값 불러오기		
								$ckDoingOther_sql = "
										SELECT DoingS FROM nurse2016_ck_doing where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbList_num' and DoingL = 8 order by rec_key;
									   ";		
								$ckDoingOther_result = @mysql_query($ckDoingOther_sql);
								$DoingS_Other1 = mysql_result($ckDoingOther_result, 0);
								$DoingS_Other2 = mysql_result($ckDoingOther_result, 1);;

								//체크박스 항목을 불러와서 배열에 저장
								$DoingS_Other_row1 = explode("&!#",$DoingS_Other1);
								$DoingS_Other_row2 = explode("&!#",$DoingS_Other2);
						?>
								&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "1" id="ck_<?=$pbList['pbList_num']?>_2_1"><label for="ck_<?=$pbList['pbList_num']?>_2_1">&nbsp;약물요법<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "1") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "1") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "2" id="ck_<?=$pbList['pbList_num']?>_2_2"><label for="ck_<?=$pbList['pbList_num']?>_2_2">&nbsp;핫팩<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "2") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "2") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "3" id="ck_<?=$pbList['pbList_num']?>_2_3"><label for="ck_<?=$pbList['pbList_num']?>_2_3">&nbsp;전환요법<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "3") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "3") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "4" id="ck_<?=$pbList['pbList_num']?>_2_4"><label for="ck_<?=$pbList['pbList_num']?>_2_4">&nbsp;마사지<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "4") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "4") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "5" id="ck_<?=$pbList['pbList_num']?>_2_5"><label for="ck_<?=$pbList['pbList_num']?>_2_5">&nbsp;음악요법<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "5") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "5") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;
								<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm<?=$pbList['pbList_num']?>_2[]" value= "6" id="ck_<?=$pbList['pbList_num']?>_2_6"><label for="ck_<?=$pbList['pbList_num']?>_2_6">&nbsp;기타<? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row1[$d] == "6") $same++;}	if($same==1) echo $job1_view; ?><? $same = 0; for($d=0; $d<6; $d++){if($DoingS_Other_row2[$d] == "6") $same++;}	if($same==1) echo $job2_view; ?></label>&nbsp;&nbsp;	
								<br>
						<?
							}
						?>

						</b>
					</font>
					</td>

				
				</tr>
				
			
			<?
				}
			}
			?>


		<input type="hidden" name="pbList_count" size=5% value="<?=$pbList_count?>">
		<input type="hidden" name="ck_RemainType" size=5% value="<?=$ck_RemainType?>">
		</table>



		<!--목록보기-->
		<table width="100%" height="50" align="center" border="0" cellspacing="0"">
			<tr>
				<td width = "100%" height="20" align="right" bgcolor="FFFFFF">
					<a href="./main.php"><img src="./img/btn_list.png" align="center" width="108" height="40"></a>
				</td>			
			</tr>
		</table>



		</td>
	</tr>


	<tr>
		<td>

		<table width="900" height="130" align="center" border="0" cellspacing="0">									

			<tr>
				<td colspan="2" align="center">	
					<button type="button" OnClick="checkIt(this.form)" style="cursor:hand; border:0;" ><img  src="./img/btn_save.png"  border="0" width="144"; height="43"></button>
				</td>
			</tr>

		</table>

		</td>
	</tr>

	</form>


	</table>


	
</body>
</html>