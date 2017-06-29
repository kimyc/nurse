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
		$which_i_m = "m";

		//입력시간 저장
		$input_time= date("ymdHis",time());

		//DB에서 환자 이름 불러오기
		$pname_sql = "
				SELECT p_name FROM nurse2016_patient where rec_key='$p_key';
			   ";
		$pname_result = @mysql_query($pname_sql);
		$p_name = mysql_result($pname_result, 0);

		//DB에 입력된 값 불러오기		
		$ck_sql = "
				SELECT * FROM nurse2016_ck12_view where p_key = '$p_key';
			   ";
		$ck_result = @mysql_query($ck_sql, $db_info);
		
		for($i=0; $i<17; $i++)
		{
	
			mysql_data_seek($ck_result, 0);
			$ck_db = mysql_fetch_array($ck_result);
			//echo "a".$ck_db[$i][0];
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

<?

		

	//설문문항개수
	//$max_mun = 1;
	$max_mun = 11;

	for($i=1; $i<=$max_mun; $i++)
	{		

		$sur="sur_".$i;

		switch($i) 
		{
			//라디오 버튼 문항
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
			
				echo "
						for(j=0; j < form." . $sur . ".length; j++){ if(form." . $sur . "[j].checked==true){ break; } }
						if(j== form." .$sur .".length){ alert('" . $i . " 번 질문에 해당하는 답을 입력하지 않으셨습니다!'); return; }
					";

		
			break;	

		}	


	}

?>

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
	<form name="form" action="ckList12_viewDB.php" method ="POST">

	<!--환자 정보-->
	<input type="hidden" name="p_key" size=5% value="<?=$p_key?>">
	<input type="hidden" name="p_name" size=5% value="<?=$p_name?>">

	<!--입력인지 수정인지-->
	<input type="hidden" name="which_i_m" size=5% value="<?=$which_i_m?>">
	
	<!--입력시간-->
	<input type="hidden" name="input_time" size=5% value="<?=$input_time?>">	

	<!--
	<tr>
		<td align="right">
			<font size = 4 color="blue" text-align="right">
				<?
					if($logout==1){
						
						echo $_SESSION['sess_id'];
					
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
		<table width="100%" height="40" align="center" border="0" cellspacing="0"">
			<tr>
				<td width = "100%" height="40" align="left" bgcolor="85a6ff">&nbsp;&nbsp;&nbsp;
					<font color="white" size=4><b>사정 체크리스트(환자이름 : <font color=white><?echo $p_name?></font>)</font></b>
				</td>			
			</tr>
		</table>
		
		<table width="100%" height="40" align="center" border="0" cellspacing="0"">
			<tr>
				<td>
					<font color="black" size=4><b>12. 낙상 위험도 평가도구</b></font>
				</td>			
			</tr>
		</table>

		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">

			<tr>
				<td width = "4%" height="20" align="center" bgcolor="F9F9FB"><b>번호</b></td>			
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>구분</b></td>
				<td align="center" bgcolor="F9F9FB"><b>3점</b></td>
				<td align="center" bgcolor="F9F9FB"><b>2점</b></td>
				<td align="center" bgcolor="F9F9FB"><b>1점</b></td>
				<td align="center" bgcolor="F9F9FB"><b>0점</b></td>
			</tr>

			<tr>
				<td align="center"><b>1</b></td>			
				<td align="center"><b>입원 후 경과</b></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1" value= "3"<? if($ck_db[5][0] == "3") echo "checked"?>>&nbsp;입원 후 7일 이내</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1" value= "2"<? if($ck_db[5][0] == "2") echo "checked"?>>&nbsp;8~14일</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1" value= "1"<? if($ck_db[5][0] == "1") echo "checked"?>>&nbsp;15일 이상</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1" value= "0"<? if($ck_db[5][0] == "0") echo "checked"?>">&nbsp;</td>			
			</tr>

			<tr>
				<td align="center"><b>2</b></td>			
				<td align="center"><b>낙상력</b></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2" value= "3"<? if($ck_db[6][0] == "3") echo "checked"?>>&nbsp;지난 4주 내 낙상</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2" value= "2"<? if($ck_db[6][0] == "2") echo "checked"?>>&nbsp;1~5개월 내 낙상</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2" value= "1"<? if($ck_db[6][0] == "1") echo "checked"?>>&nbsp;6개월 내 낙상</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2" value= "0"<? if($ck_db[6][0] == "0") echo "checked"?>>&nbsp;낙상력 없음</td>			
			</tr>

			<tr>
				<td align="center"><b>3</b></td>			
				<td align="center"><b>균형</b></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3" value= "3"<? if($ck_db[7][0] == "3") echo "checked"?>>&nbsp;도움이 있어야 일어 설 수 있음</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3" value= "2"<? if($ck_db[7][0] == "2") echo "checked"?>>&nbsp;두 명 이상의 도움이 필요</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3" value= "1"<? if($ck_db[7][0] == "1") echo "checked"?>>&nbsp;보조기 사용보행</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3" value= "0"<? if($ck_db[7][0] == "0") echo "checked"?>>&nbsp;혼자 기동 잘 함</td>			
			</tr>

			<tr>
				<td align="center"><b>4</b></td>			
				<td align="center"><b>인지기능</b></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_4" value= "3"<? if($ck_db[8][0] == "3") echo "checked"?>>&nbsp;혼돈 상태</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_4" value= "2"<? if($ck_db[8][0] == "2") echo "checked"?>>&nbsp;사람과 자신에 대한 지남력 있음</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_4" value= "1"<? if($ck_db[8][0] == "1") echo "checked"?>>&nbsp;사람과 장소에 대한 지남력 있음</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_4" value= "0"<? if($ck_db[8][0] == "0") echo "checked"?>>&nbsp;<font size ="3">시간,사람,장소에 대한 지남력 있음</font></td>			
			</tr>

			<tr>
				<td align="center"><b>5</b></td>			
				<td align="center"><b>초조</b></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_5" value= "3"<? if($ck_db[9][0] == "3") echo "checked"?>>&nbsp;심한 정도<font size = "2">(억제대 사용 필요)</font></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_5" value= "2"<? if($ck_db[9][0] == "2") echo "checked"?>>&nbsp;중정도<font size = "2">(소리를 지르고 위협적 언어 사용)</font></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_5" value= "1"<? if($ck_db[9][0] == "1") echo "checked"?>>&nbsp;약한 정도<font size = "2">(욕설함)</font></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_5" value= "0"<? if($ck_db[9][0] == "0") echo "checked"?>>&nbsp;없음</td>			
			</tr>

			<tr>
				<td align="center"><b>6</b></td>			
				<td align="center"><b>불안</b></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_6" value= "3"<? if($ck_db[10][0] == "3") echo "checked"?>>&nbsp;집중 못함</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_6" value= "2"<? if($ck_db[10][0] == "2") echo "checked"?>>&nbsp;수면장애, 식욕부진</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_6" value= "1"<? if($ck_db[10][0] == "1") echo "checked"?>>&nbsp;힘없고 약간 우울</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_6" value= "0"<? if($ck_db[10][0] == "0") echo "checked"?>>&nbsp;없음</td>			
			</tr>

			<tr>
				<td align="center"><b>7</b></td>			
				<td align="center"><b>시력</b></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_7" value= "3"<? if($ck_db[11][0] == "3") echo "checked"?>>&nbsp;시야장애 있음</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_7" value= "2"<? if($ck_db[11][0] == "2") echo "checked"?>>&nbsp;</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_7" value= "1"<? if($ck_db[11][0] == "1") echo "checked"?>>&nbsp;안경착용</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_7" value= "0"<? if($ck_db[11][0] == "0") echo "checked"?>>&nbsp;정상</td>			
			</tr>

			<tr>
				<td align="center"><b>8</b></td>			
				<td align="center"><b>의사소통</b></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_8" value= "3"<? if($ck_db[12][0] == "3") echo "checked"?>>&nbsp;말하기/청력 장애</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_8" value= "2"<? if($ck_db[12][0] == "2") echo "checked"?>>&nbsp;말하기 장애</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_8" value= "1"<? if($ck_db[12][0] == "1") echo "checked"?>>&nbsp;청력장애</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_8" value= "0"<? if($ck_db[12][0] == "0") echo "checked"?>>&nbsp;정상</td>			
			</tr>

			<tr>
				<td align="center"><b>9</b></td>			
				<td align="center"><b>복용 중인 약물</b></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_9" value= "3"<? if($ck_db[13][0] == "3") echo "checked"?>>&nbsp;심혈관/신경계<font size = "2">(정신과약 포함)</font> 모두 복용</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_9" value= "2"<? if($ck_db[13][0] == "2") echo "checked"?>>&nbsp;신경계<font size = "2">(정신과약 포함)</font> 복용</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_9" value= "1"<? if($ck_db[13][0] == "1") echo "checked"?>>&nbsp;심혈관약 복용</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_9" value= "0"<? if($ck_db[13][0] == "0") echo "checked"?>>&nbsp;복용약 없음</td>			
			</tr>

			<tr>
				<td align="center"><b>10</b></td>			
				<td align="center"><b>만성질환</b></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_10" value= "3"<? if($ck_db[14][0] == "3") echo "checked"?>>&nbsp;3가지 이상</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_10" value= "2"<? if($ck_db[14][0] == "2") echo "checked"?>>&nbsp;2가지</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_10" value= "1"<? if($ck_db[14][0] == "1") echo "checked"?>>&nbsp;1가지</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_10" value= "0"<? if($ck_db[14][0] == "0") echo "checked"?>>&nbsp;없음</td>			
			</tr>

			<tr>
				<td align="center"><b>11</b></td>			
				<td align="center"><b>배뇨장애</b></td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_11" value= "3"<? if($ck_db[15][0] == "3") echo "checked"?>>&nbsp;야뇨<font size = "2">(야간2회이상)</font>/빈뇨<font size = "2">(하루 6회 이상)</font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 긴박뇨</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_11" value= "2"<? if($ck_db[15][0] == "2") echo "checked"?>>&nbsp;2가지</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_11" value= "1"<? if($ck_db[15][0] == "1") echo "checked"?>>&nbsp;1가지</td>
				<td align="left">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_11" value= "0"<? if($ck_db[15][0] == "0") echo "checked"?>>&nbsp;없음</td>			
			</tr>

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
					<button type="button" OnClick="checkIt(this.form)" style="cursor:hand; border:0;" ><img  src="./img/btn_modify.png"  border="0" width="144"; height="43"></button>
				</td>
			</tr>

		</table>

		</td>
	</tr>

	</form>


	</table>


	
</body>
</html>