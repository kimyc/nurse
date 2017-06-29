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
				SELECT * FROM nurse2016_ck11_view where p_key = '$p_key';
			   ";
		$ck_result = @mysql_query($ck_sql, $db_info);
		
		for($i=0; $i<16; $i++)
		{
	
			mysql_data_seek($ck_result, 0);
			$ck_db = mysql_fetch_array($ck_result);
			//echo $i."=".$ck_db[$i][0]."<br>";
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
	$max_mun = 9;

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
	<form name="form" action="ckList11_viewDB.php" method ="POST">

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
					<font color="black" size=4><b>11. 자원이용 욕구사정</b></font>
				</td>			
			</tr>
		</table>

		<?
				//체크박스 항목을 불러와서 배열에 저장
				$ck_row1 = explode("&!#",$ck_db[5]);
		?>


		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">
			<tr>
				<td width = "15%"  align="center"><b>현재이용자원</b></td>
				<td width = "85%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_0[]" value= "1" <? $same = 0; for($i=0; $i<3; $i++){if($ck_row1[$i] == "1") $same++;}	if($same==1) echo "checked='checked'"; ?>><label>&nbsp;&nbsp;<b>의료기관</b>&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_0[]" value= "2" <? $same = 0; for($i=0; $i<3; $i++){if($ck_row1[$i] == "2") $same++;}	if($same==1) echo "checked='checked'"; ?>><label>&nbsp;&nbsp;<b>종교활동</b>&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_0[]" value= "3" <? $same = 0; for($i=0; $i<3; $i++){if($ck_row1[$i] == "3") $same++;}	if($same==1) echo "checked='checked'"; ?>><label>&nbsp;&nbsp;<b>자원봉사(이미용 등)</b>&nbsp;&nbsp;&nbsp;</label>		
				</td>
			</tr>

		</table>

		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">

			<tr>
				<td width = "5%" height="20" align="center" bgcolor="F9F9FB"><b>번호</b></td>			
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>구분</b></td>
				<td width = "45%"  align="center" bgcolor="F9F9FB"><b>사정내용</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>아니다</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>간혹 그렇다</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>그렇다</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>측정불능</b></td>
			</tr>

			<tr>
				<td width = "5%" height="20" align="center"><b>1</b></td>			
				<td rowspan = "2" width = "10%"  align="center"><b>참여</b></td>
				<td width = "45%"  align="left">&nbsp;<b>다른사람과 쉽게 어울리고 프로그램 참여를 하는가?</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_1" value= "1"<? if($ck_db[6][0] == "1") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_1" value= "2"<? if($ck_db[6][0] == "2") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_1" value= "3"<? if($ck_db[6][0] == "3") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_1" value= "4"<? if($ck_db[6][0] == "4") echo "checked"?>></td>
			</tr>




			<tr>
				<td width = "5%" height="20" align="center"><b>2</b></td>			
				<td width = "45%"  align="left">&nbsp;<b>다른사람과 함께 진행하는 활동의 내용을 함께 수행하는가?</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_2" value= "1"<? if($ck_db[7][0] == "1") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_2" value= "2"<? if($ck_db[7][0] == "2") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_2" value= "3"<? if($ck_db[7][0] == "3") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_2" value= "4"<? if($ck_db[7][0] == "4") echo "checked"?>></td>
			</tr>

			
			<tr>
				<td width = "5%" height="20" align="center"><b>3</b></td>			
				<td rowspan = "2" width = "10%"  align="center"><b>사회 활동의<br>변화</b></td>
				<td width = "45%"  align="left">&nbsp;<b>지난 90일 전과 비교할 때 종교활동 참여빈도가 줄었는가?</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_3" value= "1"<? if($ck_db[8][0] == "1") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_3" value= "2"<? if($ck_db[8][0] == "2") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_3" value= "3"<? if($ck_db[8][0] == "3") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_3" value= "4"<? if($ck_db[8][0] == "4") echo "checked"?>></td>
			</tr>

			<tr>
				<td width = "5%" height="20" align="center"><b>4</b></td>			
				<td width = "45%"  align="left">&nbsp;<b>지난 90일 전과 비교할 때 좋아하는 활동에 참여가 줄어들었는가?</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_4" value= "1"<? if($ck_db[9][0] == "1") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_4" value= "2"<? if($ck_db[9][0] == "2") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_4" value= "3"<? if($ck_db[9][0] == "3") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_4" value= "4"<? if($ck_db[9][0] == "4") echo "checked"?>></td>
			</tr>

			<tr>
				<td width = "5%" height="20" align="center"><b>5</b></td>			
				<td rowspan = "5" width = "10%"  align="center"><b>사회적 관계</b></td>
				<td width = "45%"  align="left">&nbsp;<b>긍정적 관계 : 동료나 가족이 통화, 방문하는가?</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_5" value= "1"<? if($ck_db[10][0] == "1") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_5" value= "2"<? if($ck_db[10][0] == "2") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_5" value= "3"<? if($ck_db[10][0] == "3") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_5" value= "4"<? if($ck_db[10][0] == "4") echo "checked"?>></td>
			</tr>

			<tr>
				<td width = "5%" height="20" align="center"><b>6</b></td>			
				<td width = "45%"  align="left">&nbsp;<b>부정적 관계: 간호제공자와 주변 사람들과 갈등이나 반복적 비난을 하는가?</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_6" value= "1"<? if($ck_db[11][0] == "1") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_6" value= "2"<? if($ck_db[11][0] == "2") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_6" value= "3"<? if($ck_db[11][0] == "3") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_6" value= "4"<? if($ck_db[11][0] == "4") echo "checked"?>></td>
			</tr>

			<tr>
				<td width = "5%" height="20" align="center"><b>7</b></td>			
				<td width = "45%"  align="left">&nbsp;<b>관계의 강도: 가족(친구) 간호제공자와 지지적인 관계인가?</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_7" value= "1"<? if($ck_db[12][0] == "1") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_7" value= "2"<? if($ck_db[12][0] == "2") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_7" value= "3"<? if($ck_db[12][0] == "3") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_7" value= "4"<? if($ck_db[12][0] == "4") echo "checked"?>></td>
			</tr>

			<tr>
				<td width = "5%" height="20" align="center"><b>8</b></td>			
				<td width = "45%"  align="left">&nbsp;<b>고립: 낮 시간동안 대상자 혼자 있는 시간은 많은가?</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_8" value= "1"<? if($ck_db[13][0] == "1") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_8" value= "2"<? if($ck_db[13][0] == "2") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_8" value= "3"<? if($ck_db[13][0] == "3") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_8" value= "4"<? if($ck_db[13][0] == "4") echo "checked"?>></td>
			</tr>

			<tr>
				<td width = "5%" height="20" align="center"><b>9</b></td>			
				<td width = "45%"  align="left">&nbsp;<b>외출: 은행, 우체국, 시장 등을 정기적으로 이용하기를 원하는가?</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_9" value= "1"<? if($ck_db[14][0] == "1") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_9" value= "2"<? if($ck_db[14][0] == "2") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_9" value= "3"<? if($ck_db[14][0] == "3") echo "checked"?>></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_9" value= "4"<? if($ck_db[14][0] == "4") echo "checked"?>></td>
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