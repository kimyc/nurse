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

		//로그인한 간호사의 rec_key를 변수에 저장
		$n_key = $_SESSION['sess_rec_key']; 

		//DB에서 내가 입력한 환자 목록 불러오기
		$plist_sql = mysql_query("
						SELECT nurse2016_patient.rec_key, p_name, p_gender, p_age, p_char
						FROM nurse2016_patient
						INNER JOIN nurse2016_care
						ON nurse2016_patient.rec_key = nurse2016_care.p_key and nurse2016_care.n_key='$n_key';
						" , $db_info); 
		//$plist = mysql_fetch_array($plist_sql);   

		//DB에서 불러온 환자의 수
		$pcount_sql = "
				SELECT count(p_name)
				FROM nurse2016_patient
				INNER JOIN nurse2016_care
				ON nurse2016_patient.rec_key = nurse2016_care.p_key and nurse2016_care.n_key='$n_key';
			   ";
		$pcount_result = @mysql_query($pcount_sql);
		$p_count = mysql_result($pcount_result, 0);


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

</head>
<body>
	


<!-- 본 내용 //-->


<br>

	<!-- 설문내용 시작-->
	
	<table width="950" height="130" align="center" border="0" cellspacing="0">

	<!--
	<tr>
		<td align="right">
			<font size = 4 color="blue" text-align="right">
				<?
					if($logout==1){
						
						//echo $_SESSION['sess_id'];
					
					}
				?>
			</font>		
			
			
			<font size = 4 color="black" text-align="right">
				<?						
						echo "님 안녕하세요";					
				?>
			</font>				


			<a href = "./logout.php"><img src="./img/btn_logout.png" style="width: 30px; height: 30px; text-align: center; vertical-align: middle;" /></a>
			
		</td>
	


	</tr>

	<tr>
		<td>
			<br>			
		</td>
	</tr>
	-->



	<tr>
		<td>

		<!--질문 시작-->
		<table width="950" height="40" align="center" border="0" cellspacing="0"">
			<tr>
				<td width = "950" height="20" align="left" bgcolor="FFFFFF"><font size=4><b>담당 환자 목록</b></font></td>			
			</tr>
		</table>

		<table width="950" height="130" align="center" border="1" cellspacing="0">

			<tr>
				<td width = "5%" height="40" align="center" bgcolor="F9F9FB"><b>환자번호</b></td>	
				<td width = "5%"  align="center" bgcolor="F9F9FB"><b>잔존</b></td>
				<td width = "25%"  align="center" bgcolor="F9F9FB"><b>사정</b></td>
				<td width = "5%"  align="center" bgcolor="F9F9FB"><b>우선순위</b></td>
				<td width = "5%"  align="center" bgcolor="F9F9FB"><b>목표설정</b></td>
				<td width = "5%"  align="center" bgcolor="F9F9FB"><b>중재항목</b></td>
				<td width = "5%"  align="center" bgcolor="F9F9FB"><b>중재</b></td>
				<td width = "5%"  align="center" bgcolor="F9F9FB"><b>평가</b></td>
			</tr>

			<?
			for($i=0; $i<$p_count; $i++)
			{
			?>

			<tr>

			<?				
				//환자 목록 출력
				for($j=0; $j<1; $j++)
				{

			?>			
					<td align = "center" height="70">
			<?
					mysql_data_seek($plist_sql, $i);
					$plist = mysql_fetch_array($plist_sql);
					echo $plist[$j];
			?>
					</td>
			<?
				}						
			?>
					<!--환자별 체크리스트 페이지로 이동-->
					<td align="center">
						
						<?
							//현재 간호사의 해당 환자 ck1 입력여부
							
							/*
							//내가 입력한 환자의 리스트
							$ckList1_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck1_remain
									WHERE n_key = '$n_key' and p_key = $plist[0];
								   ";
							*/

							//내 환자를 다른 사람이 입력했는지 여부
							$ckList1_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck1_remain
									WHERE p_key = $plist[0];
								   ";


							$ckList1_result = @mysql_query($ckList1_sql);
							$ckList1 = mysql_result($ckList1_result, 0);
							
						
							//아무도 입력하지 않았으면 "입력"버튼
							
							if($ckList1 == 0)
							{
						?>
						
							<input type = "image" src="./img/btn_m_input.png"  width="51" height="20" onclick="location.href='./ckList1_remain.php?p_key=<?=$plist[0]?>' ">
						
						<?
							}
							
							//누군가 입력했으면 "수정"버튼
							else
							{
								
							
						?>
							<input type = "image" src="./img/btn_m_modify.png"  width="51" height="20" onclick="location.href='./ckList1_remain_modify.php?p_key=<?=$plist[0]?>' ">
						<?
							}

							
						?>
						
							
						
					</td>				

					<td align="left">
						
						<?
							//현재 간호사의 해당 환자 ck2 입력여부
							$ckList2_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck2_view
									WHERE p_key = $plist[0];
								   ";
							$ckList2_result = @mysql_query($ckList2_sql);
							$ckList2 = mysql_result($ckList2_result, 0);
							
							//만약 잔존기능을 입력하기 전이면 "입력"버튼, 입력후면 "수정"버튼 보이기
							
							if($ckList2 == 0)
							{
						?>
						
						&nbsp;&nbsp;<input type = "image" src="./img/sa_input_1_2.png"  width="74" height="20" onclick="location.href='./ckList2_view.php?p_key=<?=$plist[0]?>' ">
						
						<?
							}
							
							else 
							{
								
							
						?>
							&nbsp;&nbsp;<input type = "image" src="./img/sa_modify_1_2.png"  width="74" height="20" onclick="location.href='./ckList2_view_modify.php?p_key=<?=$plist[0]?>' ">
						<?
							}
						?>
				
						<!--==========================================================================================================-->
						
						<?
							//현재 간호사의 해당 환자 ck3 입력여부
							$ckList3_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck3_view
									WHERE p_key = $plist[0];
								   ";
							$ckList3_result = @mysql_query($ckList3_sql);
							$ckList3 = mysql_result($ckList3_result, 0);
							
							//만약 잔존기능을 입력하기 전이면 "입력"버튼, 입력후면 "수정"버튼 보이기
							
							if($ckList3 == 0)
							{
						?>
						
						<input type = "image" src="./img/sa_input_3.png"  width="50" height="20" onclick="location.href='./ckList3_view.php?p_key=<?=$plist[0]?>' ">
						
						<?
							}
							
							else 
							{
								
							
						?>
							<input type = "image" src="./img/sa_modify_3.png"  width="50" height="20" onclick="location.href='./ckList3_view_modify.php?p_key=<?=$plist[0]?>' ">
						<?
							}
						?>						

						<!--==========================================================================================================-->
						
						<?
							//현재 간호사의 해당 환자 ck4 입력여부
							$ckList4_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck4_view
									WHERE p_key = $plist[0];
								   ";
							$ckList4_result = @mysql_query($ckList4_sql);
							$ckList4 = mysql_result($ckList4_result, 0);
							
							//만약 잔존기능을 입력하기 전이면 "입력"버튼, 입력후면 "수정"버튼 보이기
							
							if($ckList4 == 0)
							{
						?>
						
						<input type = "image" src="./img/sa_input_4.png"  width="50" height="20" onclick="location.href='./ckList4_view.php?p_key=<?=$plist[0]?>' ">
						
						<?
							}
							
							else 
							{
								
							
						?>
							<input type = "image" src="./img/sa_modify_4.png"  width="50" height="20" onclick="location.href='./ckList4_view_modify.php?p_key=<?=$plist[0]?>' ">
						<?
							}
						?>			
						
						<!--==========================================================================================================-->
						
						<?
							//현재 간호사의 해당 환자 ck5 입력여부
							$ckList5_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck5_view
									WHERE p_key = $plist[0];
								   ";
							$ckList5_result = @mysql_query($ckList5_sql);
							$ckList5 = mysql_result($ckList5_result, 0);
							
							//만약 잔존기능을 입력하기 전이면 "입력"버튼, 입력후면 "수정"버튼 보이기
							
							if($ckList5 == 0)
							{
						?>
						
						<input type = "image" src="./img/sa_input_5.png"  width="50" height="20" onclick="location.href='./ckList5_view.php?p_key=<?=$plist[0]?>' ">
						
						<?
							}
							
							else 
							{
								
							
						?>
							<input type = "image" src="./img/sa_modify_5.png"  width="50" height="20" onclick="location.href='./ckList5_view_modify.php?p_key=<?=$plist[0]?>' ">
						<?
							}
						?>	
							
						<!--==========================================================================================================-->
						
						<?
							//현재 간호사의 해당 환자 ck6 입력여부
							$ckList6_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck6_view
									WHERE p_key = $plist[0];
								   ";
							$ckList6_result = @mysql_query($ckList6_sql);
							$ckList6 = mysql_result($ckList6_result, 0);
							
							//만약 잔존기능을 입력하기 전이면 "입력"버튼, 입력후면 "수정"버튼 보이기
							
							if($ckList6 == 0)
							{
						?>
						
						<input type = "image" src="./img/sa_input_6.png"  width="50" height="20" onclick="location.href='./ckList6_view.php?p_key=<?=$plist[0]?>' ">
						
						<?
							}
							
							else 
							{
								
							
						?>
							<input type = "image" src="./img/sa_modify_6.png"  width="50" height="20" onclick="location.href='./ckList6_view_modify.php?p_key=<?=$plist[0]?>' ">
						<?
							}
						?>	
						

						<!--==========================================================================================================-->
						
						<?
							//현재 간호사의 해당 환자 ck7 입력여부
							$ckList7_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck7_view
									WHERE p_key = $plist[0];
								   ";
							$ckList7_result = @mysql_query($ckList7_sql);
							$ckList7 = mysql_result($ckList7_result, 0);
							
							//만약 잔존기능을 입력하기 전이면 "입력"버튼, 입력후면 "수정"버튼 보이기
							
							if($ckList7 == 0)
							{
						?>
						
						<input type = "image" src="./img/sa_input_7.png"  width="50" height="20" onclick="location.href='./ckList7_view.php?p_key=<?=$plist[0]?>' ">
						
						<?
							}
							
							else 
							{
								
							
						?>
							<input type = "image" src="./img/sa_modify_7.png"  width="50" height="20" onclick="location.href='./ckList7_view_modify.php?p_key=<?=$plist[0]?>' ">
						<?
							}
						?>	

						<!--==========================================================================================================-->
						<br>&nbsp;&nbsp;&nbsp;
						<?
							//현재 간호사의 해당 환자 ck8 입력여부
							$ckList8_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck8_view
									WHERE p_key = $plist[0];
								   ";
							$ckList8_result = @mysql_query($ckList8_sql);
							$ckList8 = mysql_result($ckList8_result, 0);
							
							//만약 잔존기능을 입력하기 전이면 "입력"버튼, 입력후면 "수정"버튼 보이기
							
							if($ckList8 == 0)
							{
						?>
						
						&nbsp;&nbsp;<input type = "image" src="./img/sa_input_8.png"  width="50" height="20" onclick="location.href='./ckList8_view.php?p_key=<?=$plist[0]?>' ">
						
						<?
							}
							
							else 
							{
								
							
						?>
							&nbsp;&nbsp;<input type = "image" src="./img/sa_modify_8.png"  width="50" height="20" onclick="location.href='./ckList8_view_modify.php?p_key=<?=$plist[0]?>' ">
						<?
							}
						?>	

						<!--==========================================================================================================-->
						
						<?
							//현재 간호사의 해당 환자 ck9 입력여부
							$ckList9_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck9_view
									WHERE p_key = $plist[0];
								   ";
							$ckList9_result = @mysql_query($ckList9_sql);
							$ckList9 = mysql_result($ckList9_result, 0);
							
							//만약 잔존기능을 입력하기 전이면 "입력"버튼, 입력후면 "수정"버튼 보이기
							
							if($ckList9 == 0)
							{
						?>
						
						<input type = "image" src="./img/sa_input_9.png"  width="50" height="20" onclick="location.href='./ckList9_view.php?p_key=<?=$plist[0]?>' ">
						
						<?
							}
							
							else 
							{
								
							
						?>
							<input type = "image" src="./img/sa_modify_9.png"  width="50" height="20" onclick="location.href='./ckList9_view_modify.php?p_key=<?=$plist[0]?>' ">
						<?
							}
						?>	

						<!--==========================================================================================================-->
						
						<?
							//현재 간호사의 해당 환자 ck10 입력여부
							$ckList10_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck10_view
									WHERE p_key = $plist[0];
								   ";
							$ckList10_result = @mysql_query($ckList10_sql);
							$ckList10 = mysql_result($ckList10_result, 0);
							
							//만약 잔존기능을 입력하기 전이면 "입력"버튼, 입력후면 "수정"버튼 보이기
							
							if($ckList10 == 0)
							{
						?>
						
						<input type = "image" src="./img/sa_input_10.png"  width="50" height="20" onclick="location.href='./ckList10_view.php?p_key=<?=$plist[0]?>' ">
						
						<?
							}
							
							else 
							{
								
							
						?>
							<input type = "image" src="./img/sa_modify_10.png"  width="50" height="20" onclick="location.href='./ckList10_view_modify.php?p_key=<?=$plist[0]?>' ">
						<?
							}
						?>	

						<!--==========================================================================================================-->
						
						<?
							//현재 간호사의 해당 환자 ck11 입력여부
							$ckList11_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck11_view
									WHERE p_key = $plist[0];
								   ";
							$ckList11_result = @mysql_query($ckList11_sql);
							$ckList11 = mysql_result($ckList11_result, 0);
							
							//만약 잔존기능을 입력하기 전이면 "입력"버튼, 입력후면 "수정"버튼 보이기
							
							if($ckList11 == 0)
							{
						?>
						
						<input type = "image" src="./img/sa_input_11.png"  width="50" height="20" onclick="location.href='./ckList11_view.php?p_key=<?=$plist[0]?>' ">
						
						<?
							}
							
							else 
							{
								
							
						?>
							<input type = "image" src="./img/sa_modify_11.png"  width="50" height="20" onclick="location.href='./ckList11_view_modify.php?p_key=<?=$plist[0]?>' ">
						<?
							}
						?>	

						<!--==========================================================================================================-->

		
						<?
							//현재 간호사의 해당 환자 ck12 입력여부
							$ckList12_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck12_view
									WHERE p_key = $plist[0];
								   ";
							$ckList12_result = @mysql_query($ckList12_sql);
							$ckList12 = mysql_result($ckList12_result, 0);
							
							//만약 잔존기능을 입력하기 전이면 "입력"버튼, 입력후면 "수정"버튼 보이기
							
							if($ckList12 == 0)
							{
						?>
						
						<input type = "image" src="./img/sa_input_12.png"  width="50" height="20" onclick="location.href='./ckList12_view.php?p_key=<?=$plist[0]?>' ">
						
						<?
							}
							
							else 
							{
								
							
						?>
							<input type = "image" src="./img/sa_modify_12.png"  width="50" height="20" onclick="location.href='./ckList12_view_modify.php?p_key=<?=$plist[0]?>' ">
						<?
							}
						?>	

						<!--==========================================================================================================-->

		
						<?
							//현재 간호사의 해당 환자 ck13 입력여부
							$ckList13_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck13_view
									WHERE p_key = $plist[0];
								   ";
							$ckList13_result = @mysql_query($ckList13_sql);
							$ckList13 = mysql_result($ckList13_result, 0);
							
							//만약 잔존기능을 입력하기 전이면 "입력"버튼, 입력후면 "수정"버튼 보이기
							
							if($ckList13 == 0)
							{
						?>
						
						<input type = "image" src="./img/sa_input_13.png"  width="50" height="20" onclick="location.href='./ckList13_view.php?p_key=<?=$plist[0]?>' ">
						
						<?
							}
							
							else 
							{
								
							
						?>
							<input type = "image" src="./img/sa_modify_13.png"  width="50" height="20" onclick="location.href='./ckList13_view_modify.php?p_key=<?=$plist[0]?>' ">
						<?
							}
						?>	

						<!--==========================================================================================================-->


					</td>		

					<td align="center">
						
						<?

							//내가 입력했는지 여부
							$ckListRank_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck_rank
									WHERE n_key = '$n_key' and p_key = $plist[0];
								   ";


							$ckListRank_result = @mysql_query($ckListRank_sql);
							$ckListRank = mysql_result($ckListRank_result, 0);
							
						
							$total = $ckList1 + $ckList2 + $ckList3 + $ckList4 + $ckList5 + $ckList6 + $ckList7 + $ckList8 + $ckList9 + $ckList10 + $ckList11 + $ckList12 + $ckList13;



							//입력하지 않았으면 "입력"버튼
							
							if($ckListRank == 0)
							{
								if($total>=13){
						?>
						
							<input type = "image" src="./img/btn_m_input.png"  width="51" height="20" onclick="location.href='./ckList_rank.php?p_key=<?=$plist[0]?>' ">
						<?
								}

								else
								{
									echo "<font size=2><b>사정입력<br>미완료<b></font>";
								}
							}
							
							//한번 입력했으면 "수정"버튼
							else
							{
								if($total>=13){
								
							
						?>
							<input type = "image" src="./img/btn_m_modify.png"  width="51" height="20" onclick="location.href='./ckList_rank_modify.php?p_key=<?=$plist[0]?>' ">
						<?
								}

								else
								{
									echo "<font size=2><b>사정입력<br>미완료<b></font>";
								}
							}

							
						?>

					</td>		

					<td align="center">
						
						<?
							//우선순위를 모두 입력했는지 확인		
							$ck_rank_sql = "
									SELECT count(rec_key) FROM nurse2016_ck_rank where p_key = $plist[0];
								   ";		
							$ck_rank_result = @mysql_query($ck_rank_sql);
							$ck_count_rank = mysql_result($ck_rank_result, 0);
							


							//내가 입력했는지 여부
							$ckListGoal_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck_goal
									WHERE n_key = '$n_key' and p_key = $plist[0];
								   ";


							$ckListGoal_result = @mysql_query($ckListGoal_sql);
							$ckListGoal = mysql_result($ckListGoal_result, 0);
							
						
							//입력하지 않았으면 "입력"버튼
							
							if($ckListGoal == 0)
							{
								if($total>=13){
									if($ck_count_rank==3){
						?>
										<input type = "image" src="./img/btn_m_input.png"  width="51" height="20" onclick="location.href='./ckList_goal.php?p_key=<?=$plist[0]?>' ">
						<?
									}
									
									else
									{
										echo "<font size=2><b>우선순위<br>입력자<b></font>";
										echo "<font size=2><b><br>($ck_count_rank<b></font>";
										echo "<font size=2><b>명)</font>";
									}
								}

								else
								{
									echo "<font size=2><b>사정입력<br>미완료<b></font>";
								}
							}
							
							//한번 입력했으면 "수정"버튼
							else
							{
								if($total>=13){
									if($ck_count_rank==3){
								
							
						?>
										<input type = "image" src="./img/btn_m_modify.png"  width="51" height="20" onclick="location.href='./ckList_goal_modify.php?p_key=<?=$plist[0]?>' ">
						<?
									}

									else
									{
										echo "<font size=2><b>우선순위<br>입력자<b></font>";
										echo "<font size=2><b><br>($ck_count_rank<b></font>";
										echo "<font size=2><b>명)</font>";
									}
								}

								else
								{
									echo "<font size=2><b>사정입력<br>미완료<b></font>";
								}
							}

							
						?>
					</td>		
	
					<td align="center">
						
						<?

							//내가 입력했는지 여부
							$ckListDoing_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck_doing
									WHERE n_key = '$n_key' and p_key = $plist[0];
								   ";


							$ckListDoing_result = @mysql_query($ckListDoing_sql);
							$ckListDoing = mysql_result($ckListDoing_result, 0);
							
						
							//입력하지 않았으면 "입력"버튼
							
							if($ckListDoing == 0)
							{
								if($total>=13){
						?>
						
							<input type = "image" src="./img/btn_m_input.png"  width="51" height="20" onclick="location.href='./ckList_doing.php?p_key=<?=$plist[0]?>' ">
						
						<?
								}

								else
								{
									echo "<font size=2><b>사정입력<br>미완료<b></font>";
								}
							}
							
							//한번 입력했으면 "수정"버튼
							else
							{
								if($total>=13){
								
							
						?>
							<input type = "image" src="./img/btn_m_modify.png"  width="51" height="20" onclick="location.href='./ckList_doing_modify.php?p_key=<?=$plist[0]?>' ">
						<?
								}

								else
								{
									echo "<font size=2><b>사정입력<br>미완료<b></font>";
								}
							}

							
						?>
					</td>	

					<td align="center">
						
						<?

							//내가 입력했는지 여부
							$ckListAct_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck_act
									WHERE n_key = '$n_key' and p_key = $plist[0];
								   ";


							$ckListAct_result = @mysql_query($ckListAct_sql);
							$ckListAct = mysql_result($ckListAct_result, 0);
							
						
							//입력하지 않았으면 "입력"버튼
							
							if($ckListAct == 0)
							{
								if($total>=13){
						?>
						
							<input type = "image" src="./img/btn_m_input.png"  width="51" height="20" onclick="location.href='./ckList_act.php?p_key=<?=$plist[0]?>' ">
						
						<?
								}

								else
								{
									echo "<font size=2><b>사정입력<br>미완료<b></font>";
								}
							}
							
							//한번 입력했으면 "수정"버튼
							else
							{
								if($total>=13){
								
							
						?>
							<input type = "image" src="./img/btn_m_modify.png"  width="51" height="20" onclick="location.href='./ckList_act_modify.php?p_key=<?=$plist[0]?>' ">
						<?
								}

								else
								{
									echo "<font size=2><b>사정입력<br>미완료<b></font>";
								}
							}

							
						?>
					</td>	

					<td align="center">
						
						<?

							//내가 입력했는지 여부
							$ckListEval_sql = "
									SELECT count(p_name)
									FROM nurse2016_ck_eval
									WHERE n_key = '$n_key' and p_key = $plist[0];
								   ";


							$ckListEval_result = @mysql_query($ckListEval_sql);
							$ckListEval = mysql_result($ckListEval_result, 0);
							
						
							//입력하지 않았으면 "입력"버튼
							
							if($ckListEval == 0)
							{
								if($total>=13){
						?>
						
							<input type = "image" src="./img/btn_m_input.png"  width="51" height="20" onclick="location.href='./ckList_eval.php?p_key=<?=$plist[0]?>' ">
						
						<?
								}

								else
								{
									echo "<font size=2><b>사정입력<br>미완료<b></font>";
								}
							}
							
							//한번 입력했으면 "수정"버튼
							else
							{
								if($total>=13){
								
							
						?>
							<input type = "image" src="./img/btn_m_modify.png"  width="51" height="20" onclick="location.href='./ckList_eval_modify.php?p_key=<?=$plist[0]?>' ">
						<?
								}

								else
								{
									echo "<font size=2><b>사정입력<br>미완료<b></font>";
								}
							}

							
						?>
					</td>	
			<?
			}
			?>


			</tr>

		</table>

		</td>
	</tr>




	</table>


	
</body>
</html>