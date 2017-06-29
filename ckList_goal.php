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
	<form name="form" action="ckList_goalDB.php" method ="POST">

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
					<font color="white" size=4><b>목표 설정(환자이름 : <font color=white><?echo $p_name?><?echo " / "; 
						if($ck_RemainType==1) echo "신체기능과 인지기능 비교적 양호";
						if($ck_RemainType==2) echo "신체기능 양호하나 중등도 치매";
						if($ck_RemainType==3) echo "와상상태이나 인지기능 양호";
						if($ck_RemainType==4) echo "와상상태이면서 중등도 치매";?></font>)
					</font></b>
				</td>			
			</tr>
		</table>


		<!--문제리스트 불러오기(중요한 순으로 정렬)-->
		<?
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

		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">		
			<tr>
				<td width = "4%" height="20" align="center" bgcolor="F9F9FB"><b><font size = "3">번호</font></b></td>			
				<td width = "25%"  align="center" bgcolor="F9F9FB"><b><font size = "3">내용</font></b></td>
				<td width = "33%"  align="center" bgcolor="F9F9FB"><b><font size = "3">학제별 목표설정</font></b></td>
				<td width = "38%"  align="center" bgcolor="F9F9FB"><b><font size = "3">공동의 목표설정</font></b></td>
			</tr>

			<?

			for($i=0; $i<$pbList_count; $i++)
			{	
				if($pblist_num[$i]!=null)
				{
			?>

				<tr>

					<td height="20" align="center"><b><font size = "3"><?echo $i+1?></font></b></td>			
					<td align="center">					
						<b><font size = "3">
							<?
								//문제리스트의 출력
								$pbList_txt_sql = "
										SELECT pbList_txt from nurse2016_pbList where pbList_num = '$pblist_num[$i]';
									   ";
								$pbList_txt_result = @mysql_query($pbList_txt_sql);
								$pbList_txt = mysql_result($pbList_txt_result, 0);
								echo $pbList_txt;		
								
								$pbNum = $pblist_num[$i];
							?>

						</font></b>				
					</td>

					<td align="left">
						<font size = "3">
							&nbsp;&nbsp;<input type="text" style="width:420px;height:30px;vertical-align: middle;"  name="sur_txt_<?=$pbNum?>">	
							
							<?

								
								//공동목표 DB에 다른 사람이 입력한 값 불러오기		
								$ck_goal_sql = "
										SELECT * FROM nurse2016_ck_goal where n_key != '$n_key' and p_key = '$p_key' and pbList_num = '$pbNum' and pbList_num = '$pbNum';
									   ";		
								$ck_goal_result = @mysql_query($ck_goal_sql,$db_info);
								
								echo "<br>";

								//입력자1의 입력내용
								mysql_data_seek($ck_goal_result, 0);
								$ck_goal1_db = mysql_fetch_array($ck_goal_result);
								$ckGoalNum = 'ckRank_'.$pbNum;
								echo "&nbsp;&nbsp;*".$ck_goal1_db['pbList_goal'];

								echo "<br>";

								//입력자2의 입력내용
								mysql_data_seek($ck_goal_result, 1);
								$ck_goal2_db = mysql_fetch_array($ck_goal_result);
								$ckGoalNum = 'ckRank_'.$pbNum;
								echo "&nbsp;&nbsp;*".$ck_goal2_db['pbList_goal'];
							?>
						</font>
					</td>
					
					<?
						
						//문제 리스트에 따른 공동의 목표 설정 내용 변경
						if($pbNum>=1 && $pbNum<=12){

					?>

						<td align="left">
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "1"><b>&nbsp;<font size = "3">현재 기능 유지</font></b></label>
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "2"><b>&nbsp;<font size = "3">ADL 수행능력평가에서 한단계 향상</label></font></b></label>		
						</td>
			
					<?
						}

						if($pbNum==13){
				
					?>
						<td align="left">
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "1"><b>&nbsp;<font size = "3">현재 기능 유지</font></b></label>
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "2"><b>&nbsp;<font size = "3">MMSE 점수(지남력, 기억력 등)  향상</font></b></label>		
						</td>

					<?
						}

						if($pbNum==14){
					?>

						<td align="left">
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "1"><b>&nbsp;<font size = "3">현재 기능 유지</font></b></label>
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "2"><b>&nbsp;<font size = "3">의사소통 기능(청취능력, 발음능력 등) 향상</font></b></label>		
						</td>

					<?
						}

						if($pbNum==15){
					?>
						<td align="left">
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "1"><b>&nbsp;<font size = "3">현재 기능 유지</font></b></label>
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "2"><b>&nbsp;<font size = "3"> 사회적 지지기능(가족, 환경) 향상</font></b></label>		
						</td>

					<?
						}

						if($pbNum==16){
					?>

						<td align="left">
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "1"><b>&nbsp;<font size = "3">현재 기능 유지</font></b></label>
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "2"><b>&nbsp;<font size = "3">정서기능(불안, 우울, 초초 감소 등) 향상</font></b></label>		
						</td>

					<?
						}

						if($pbNum==17){
					?>

						<td align="left">
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "1"><b>&nbsp;<font size = "3">현재 기능 유지</font></b></label>
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "2"><b>&nbsp;<font size = "3">영적기능(종교활동 참여 증가 등) 향상</font></b></label>		
						</td>

					<?
						}

						if($pbNum==18){
					?>

						<td align="left">
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "1"><b>&nbsp;<font size = "3">통증 완화/감소</font></b></label>
							&nbsp;&nbsp;<label><input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_<?=$pbNum?>" value= "2"><b>&nbsp;<font size = "3">통증이 사라짐</font></b></label>		
						</td>

					<?
						}
					?>


				</tr>
			
			<?
				}
			}
			?>


		<input type="hidden" name="pbList_count" size=5% value="<?=$pbList_count?>">
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