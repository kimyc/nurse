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
	<form name="form" action="ckList_actDB.php" method ="POST">

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
					<font color="white" size=4><b>중재(환자이름 : <font color=white><?echo $p_name?><?echo " / "; 
						if($ck_RemainType==1) echo "신체기능과 인지기능 비교적 양호";
						if($ck_RemainType==2) echo "신체기능 양호하나 중등도 치매";
						if($ck_RemainType==3) echo "와상상태이나 인지기능 양호";
						if($ck_RemainType==4) echo "와상상태이면서 중등도 치매";?></font>)
					</font></b>
				</td>			
			</tr>
		</table>
		


		<!--문제리스트 불러오기(유형별)-->
		<?


		//DB에 입력된 문제리스트 불러오기		
		$pbDoing_sql = "
				SELECT * FROM nurse2016_ck_doing where n_key = '$n_key' and  p_key = '$p_key' order by rec_key asc;
			   ";
		$pbDoing_result = @mysql_query($pbDoing_sql, $db_info);

		

		//DB에 입력된 항목의 개수 불러오기
		$pbListCount_sql = "
				SELECT count(rec_key) FROM nurse2016_ck_doing where n_key = '$n_key' and  p_key = '$p_key' order by rec_key asc;
			   ";
		$pbListCount_result = @mysql_query($pbListCount_sql);
		$pbList_count = mysql_result($pbListCount_result, 0);

		//echo $pbList_count;

		//echo "sql=".$pbDoing_sql."<br>";


		//DB에 입력된 문제리스트 개수 불러오기(group by)
		$pbListGroup_sql = "
				select count(c.rec_key) from(
					SELECT rec_key FROM nurse2016_ck_doing where n_key = '$n_key' and  p_key = '$p_key' group by pbList_num order by rec_key asc
				) as c
			   ";
		$pbListGroup_result = @mysql_query($pbListGroup_sql);
		$pbList_Group = mysql_result($pbListGroup_result, 0);

		//echo $pbListGroup_sql;

		//echo $pbList_Group;
		//echo $pbList_count;

		//echo "sql=".$pbDoing_sql."<br>";


		echo "<br>";
		?>
	
		<table width="100%" align="center" border="1" cellspacing="0" class="bbs_wm">		

			<tr>
				<td align = "center" width = "20%" bgcolor="dddddd">
					<b>
						 문제리스트
					</b>
				</td>

				<td align = "center" width = "15%" bgcolor="dddddd">
					<b>
						 중재대분류
					</b>
				</td>

				<td align = "center" width = "10%"  bgcolor="dddddd">
					<b>
						 소분류
					</b>
				</td>

				<td align = "center" width = "18%"  bgcolor="dddddd">
					<b>
						 기간
					</b>
				</td>

				<td align = "center" width = "20%"  bgcolor="dddddd">
					<b>
						 횟수
					</b>
				</td>

				<td align = "center" width = "20%"  bgcolor="dddddd">
					<b>
						 수행시간
					</b>
				</td>

				<td align = "center" width = "5%"  bgcolor="dddddd">
					<b>
						 수행자
					</b>
				</td>
	
			</tr>

			<?
			$pbListCountNum = 0;
			$bf_pbList[$pbListCountNum] = 0;

			for($i=0; $i<$pbList_count; $i++)
			{	
				//중재 소항목에 체크된 것만 불러오기
				$pbListDoingS_sql = "
						SELECT DoingS FROM nurse2016_ck_doing where n_key = '$n_key' and  p_key = '$p_key' order by rec_key asc;
					   ";
				$pbListDoingS_result = @mysql_query($pbListDoingS_sql);
				$pbListDoingS = mysql_result($pbListDoingS_result, $i);				
				
				//echo $pbListDoingS;
				//중재 소항목에 체크된 문제리스트만 출력하기
				if($pbListDoingS != null)
				{

			?>

				
				<tr>
					<td align="left">					
						<b>
							<font size = 2>
							<?
								mysql_data_seek($pbDoing_result, $i);
								$pbList = mysql_fetch_array($pbDoing_result);
								$pbList_Num = $pbList['pbList_num'];

								$bf_pbList[$pbListCountNum+1] = $pbList_Num;

								//같은 문제 리스트가 반복적으로 보이는 것을 방지
								if($bf_pbList[$pbListCountNum] != $bf_pbList[$pbListCountNum+1])
								{
									$bf_pbList[$pbListCountNum+1] = $pbList_Num;

									//화면에 표시되는 문제 번호
									$pbListCountNum++;
									echo "&nbsp;".$pbListCountNum.". ".$pbList['pbList_txt'];
									
								}


							?>
							<input type="hidden" name="pbList_<?=$i?>" size=5% value="<?=$pbList_Num?>">
							</font>
						</b>
					</td>


					<td>
						<font size = 2>
						<b>
							 <?
								//대항목 치환
								if($pbList['DoingL'] == 1){$DoingS_txt = '1.신체기능의 훈련';}
								if($pbList['DoingL'] == 2){$DoingS_txt = '2.기본동작 훈련';}
								if($pbList['DoingL'] == 3){$DoingS_txt = '3.일상생활동작 훈련';}
								if($pbList['DoingL'] == 4){$DoingS_txt = '4.물리치료';}
								if($pbList['DoingL'] == 5){$DoingS_txt = '5.작업치료';}
								if($pbList['DoingL'] == 6){$DoingS_txt = '6.인지 및 정심기능 훈련';}
								if($pbList['DoingL'] == 7){$DoingS_txt = '7.언어치료';}
								if($pbList['DoingL'] == 8){$DoingS_txt = '8.통증치료';}
								if($pbList['DoingL'] == 9){$DoingS_txt = '9.치료 레크레이션';}
								if($pbList['DoingL'] == 10){$DoingS_txt = '10.사회복지 프로그램';}
								if($pbList['DoingL'] == 11){$DoingS_txt = '11.심리 및 정신 재활프로그램';}
								if($pbList['DoingL'] == 12){$DoingS_txt = '12.영적치료';}
								echo "&nbsp;".$DoingS_txt;
								$DoingL_Num = $pbList['DoingL'];

							 ?>
							 <input type="hidden" name="DoingL_<?=$i?>" size=5% value="<?=$DoingL_Num?>">
						</b>
						</font>
					</td>


					<td>
						<font size = 2>
						<b>
							 <?
								//echo "&nbsp;".$pbList['DoingS'];
								$DoingS_Num = $pbList['DoingS'];
								
								//소분류를 불러와서 배열에 저장
								$DoingS_row = explode("&!#",$DoingS_Num);

								//소분류의 개수 불러오기
								$DoingSCount_sql = "
										select round((length(DoingS) - length(replace(DoingS, '&!#', '')))/3+1,0) 'DoingScount' from nurse2016_ck_doing where n_key='$n_key' and p_key='$p_key' and pbList_num = '$pbList_Num' and DoingL = '$DoingL_Num';
									   ";
								$DoingSCount_result = @mysql_query($DoingSCount_sql);
								$DoingSCount = mysql_result($DoingSCount_result, 0);
								


								for($ss = 0; $ss<$DoingSCount; $ss++)
								{
									//소분류의 내용 불러오기
									$DoingStxt_sql = "
											SELECT DoingS_txt FROM nurse2016_DoingList where DoingL_num= '$DoingL_Num' and DoingS_num = '$DoingS_row[$ss]';
										   ";
									$DoingStxt_result = @mysql_query($DoingStxt_sql);
									$DoingStxt = mysql_result($DoingStxt_result, 0);
									
									//echo $DoingStxt_sql;

							?>
								<table border="0">
									<tr>
										<td height = "70">
											<font size = 2>
											<b>
												<?
													//echo $DoingS_row[$ss]."<br>";
													$DoingS_rowNum = $DoingS_row[$ss];
													echo $DoingStxt;
												?>
											
											</b>
											</font>
										</td>
									</tr>
								</table>
								<input type="hidden" name="DoingS_<?=$i?>_<?=$ss?>" size=5% value="<?=$DoingS_rowNum?>">
							<?
								}
							?>

							 

						</b>
						</font>
					</td>


					<td align = "left">
						<?
							for($ss = 0; $ss<$DoingSCount; $ss++)
							{
						?>
							<table border = "0">
								<tr>
									<td height = "70">

						<font size = 2>
						<b>	&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_1_<?=$i?>_<?=$ss?>" value= "1">
								1개월
							</label>

							&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_1_<?=$i?>_<?=$ss?>" value= "2">
								2개월
							</label>

							&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_1_<?=$i?>_<?=$ss?>" value= "3">
								3개월
							</label>

							<br>&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_1_<?=$i?>_<?=$ss?>" value= "4">
								4개월
							</label>

							&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_1_<?=$i?>_<?=$ss?>" value= "5">
								5개월
							</label>

							&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_1_<?=$i?>_<?=$ss?>" value= "6">
								6개월
							</label>
						</b>
						</font>

									</td>
								</tr>
							</table>
							<?
								}
							?>

					</td>

					<td>

						<?
							for($ss = 0; $ss<$DoingSCount; $ss++)
							{
						?>
							<table>
								<tr>
									<td height = "70">

						<font size = 2>
						<b>	&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_2_<?=$i?>_<?=$ss?>" value= "1">
								수시로
							</label>

							&nbsp;&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_2_<?=$i?>_<?=$ss?>" value= "2">
								매일
							</label>

							&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_2_<?=$i?>_<?=$ss?>" value= "3">
								주5-6회
							</label>

							<br>&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_2_<?=$i?>_<?=$ss?>" value= "4">
								주3-4회
							</label>

							&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_2_<?=$i?>_<?=$ss?>" value= "5">
								주1-2회
							</label>

							&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_2_<?=$i?>_<?=$ss?>" value= "6">
								필요시
							</label>
						</b>
						</font>

									</td>
								</tr>
							</table>
							<?
								}
							?>

					</td>

					<td>
						<?
							for($ss = 0; $ss<$DoingSCount; $ss++)
							{
						?>
							<table>
								<tr>
									<td height = "70">


						<font size = 2>
						<b>	&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_3_<?=$i?>_<?=$ss?>" value= "1">
								10분
							</label>

							&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_3_<?=$i?>_<?=$ss?>" value= "2">
								20분
							</label>

							&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_3_<?=$i?>_<?=$ss?>" value= "3">
								30분
							</label>

							<br>&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_3_<?=$i?>_<?=$ss?>" value= "4">
								40분
							</label>

							&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_3_<?=$i?>_<?=$ss?>" value= "5">
								50분
							</label>

							&nbsp;
							<label>
								<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_3_<?=$i?>_<?=$ss?>" value= "6">
								60분이상
							</label>
						</b>
						</font>

									</td>
								</tr>
							</table>
							<?
								}
							?>

					</td>

					<td align = "center">
						<font size = 2>
						<b>
							<?echo $n_id;?>
						</b>
						</font>
					</td>				

				</tr>
			
			<?
				}
			}
			?>


		<input type="hidden" name="pbList_Group" size=5% value="<?=$pbList_Group?>">
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