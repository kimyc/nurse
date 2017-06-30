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
				SELECT * FROM nurse2016_ck13_view where p_key = '$p_key';
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
	$max_mun = 6;

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
	<form name="form" action="ckList13_viewDB.php" method ="POST">

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
					<font color="black" size=4><b>13. 욕창 위험도 평가 도구(Braden Scale) </b></font>
				</td>			
			</tr>
		</table>

		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">

			<tr>
				<td width = "5%" height="20" align="center" bgcolor="F9F9FB"><b>번호</b></td>			
				<td width = "10%" align="center" bgcolor="F9F9FB"><b>구분</b></td>
				<td width = "17%" align="center" bgcolor="F9F9FB"><b>척도</b></td>
				<td width = "61%" align="center" bgcolor="F9F9FB"><b>내용</b></td>
				<td width = "7%" align="center" bgcolor="F9F9FB"><b>점수</b></td>
			</tr>

			<tr>
				<td rowspan = "4" align="center"><b>1</b></td>			
				<td rowspan = "4" align="center"><b>감각인지정도</b></td>
				<td align="left"><b>&nbsp;1. 감각 완전 제한됨<br>&nbsp;&nbsp;&nbsp;&nbsp;(완전히 못 느낌)</b></td>
				<td align="left"><b>의식수준이 떨어지거나 진정/안정제 복용/투여 등으로 통증 자극에 반응이 없다(통증자극에 대해 신음하거나 주먹을 쥔다거나 할 수 없음), 신체 대부분에서 통증을 느끼지 못한다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1" value= "1"<? if($ck_db[5][0] == "1") echo "checked"?>><b>&nbsp;1점</b></td>
			</tr>

			<tr>		
				<td align="left"><b>&nbsp;2. 감각 매우 제한됨</font></b></td>
				<td align="left"><b>통증자극에만 반응(신음하거나 불안정한 양상으로 통증이 있음을 나타냄) 또는 신체의 1/2 이상에 통증이나 불편감을 느끼지 못한다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1" value= "2"<? if($ck_db[5][0] == "2") echo "checked"?>><b>&nbsp;2점</b></td>
			</tr>

			<tr>
				<td align="left"><b>&nbsp;3. 감각 약간 제한됨</font></b></td>
				<td align="left"><b>말로 지시하면 반응하지만, 체위변경을 해달라고 하거나 불편하다고 항상 말할 수 있는 것이 아니다. 또는 1-2개 사지에 통증이나 불편감을 느끼지 못한다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1" value= "3"<? if($ck_db[5][0] == "3") echo "checked"?>><b>&nbsp;3점</b></td>
			</tr>

			<tr>
				<td align="left"><b>&nbsp;4. 감각손상 없음</font></b></td>
				<td align="left"><b>말로 지시하면 반응을 보이며 통증이나 불편감을 느끼고 말로 표현할 수 있다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1" value= "4"<? if($ck_db[5][0] == "4") echo "checked"?>><b>&nbsp;4점</b></td>
			</tr>

			<!--=============================================================================================-->


			<tr>
				<td rowspan = "4" align="center"><b>2</b></td>			
				<td rowspan = "4" align="center"><b>습기 여부</b></td>
				<td align="left"><b>&nbsp;1. 항상 젖어있음</b></td>
				<td align="left"><b>피부가 땀, 소변으로 항상 축축하다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2" value= "1"<? if($ck_db[6][0] == "1") echo "checked"?>><b>&nbsp;1점</b></td>
			</tr>

			<tr>		
				<td align="left"><b>&nbsp;2. 자주 젖어있음</b></td>
				<td align="left"><b>늘 축축한 것은 아니지만 자주 축축해져 8시간에 한번은 린넨을 갈아주어야 한다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2" value= "2"<? if($ck_db[6][0] == "2") echo "checked"?>><b>&nbsp;2점</b></td>
			</tr>

			<tr>
				<td align="left"><b>&nbsp;3. 가끔 젖어있음</b></td>
				<td align="left"><b>가끔 축축하다. 하루에 한 번 정도 린넨 교환이 필요하다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2" value= "3"<? if($ck_db[6][0] == "3") echo "checked"?>><b>&nbsp;3점</b></td>
			</tr>

			<tr>
				<td align="left"><b>&nbsp;4. 거의 젖지 않음</b></td>
				<td align="left"><b>피부는 보통 건조하며 린넨은 평상시대로만 교환해주면 된다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2" value= "4"<? if($ck_db[6][0] == "4") echo "checked"?>><b>&nbsp;4점</b></td>
			</tr>

			<!--=============================================================================================-->

			<tr>
				<td rowspan = "4" align="center"><b>3</b></td>			
				<td rowspan = "4" align="center"><b>활동상태</b></td>
				<td align="left"><b>&nbsp;1. 항상 침대에만 누워있음</b></td>
				<td align="left"><b>도움없이는 몸은 물론 손, 발을 조금도 움직이지 못한다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3" value= "1"<? if($ck_db[7][0] == "1") echo "checked"?>><b>&nbsp;1점</b></td>
			</tr>

			<tr>		
				<td align="left"><b>&nbsp;2. 의자에 앉아 있을 수 있음</b></td>
				<td align="left"><b>걸을 수 없거나 걷는 능력이 상당히 제한되어 있다. 체중부하를 할 수 없어 의자나 휠체어로 이동시 도움을 필요로 한다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3" value= "2"<? if($ck_db[7][0] == "2") echo "checked"?>><b>&nbsp;2점</b></td>
			</tr>

			<tr>
				<td align="left"><b>&nbsp;3. 가끔 걸을 수 있음</b></td>
				<td align="left"><b>낮동안에 도움을 받거나 도움 없이 매우 짧은 거리를 걸을 수 있다. 그러나 대부분의 시간은 침상이나 의자에서 보낸다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3" value= "3"<? if($ck_db[7][0] == "3") echo "checked"?>><b>&nbsp;3점</b></td>
			</tr>

			<tr>
				<td align="left"><b>&nbsp;4. 자주 걸을 수 있음</b></td>
				<td align="left"><b>적어도 하루에 두 번 방 밖을 걷고, 방은은 적어도 2시간 마다 걷는다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3" value= "4"<? if($ck_db[7][0] == "4") echo "checked"?>><b>&nbsp;4점</b></td>
			</tr>

			<!--=============================================================================================-->

			<tr>
				<td rowspan = "4" align="center"><b>4</b></td>			
				<td rowspan = "4" align="center"><b>움직임</b></td>
				<td align="left"><b>&nbsp;1. 완전히 못 움직임</b></td>
				<td align="left"><b>도움없이는 신체나 사지를 전혀 움직이지 못한다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_4" value= "1"<? if($ck_db[8][0] == "1") echo "checked"?>><b>&nbsp;1점</b></td>
			</tr>

			<tr>		
				<td align="left"><b>&nbsp;2. 매우 제한됨</b></td>
				<td align="left"><b>신체나 사지의 체위를 가끔 조금 변경시킬 수 있지만 자주하거나 많이 변경시키지 못한다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_4" value= "2"<? if($ck_db[8][0] == "2") echo "checked"?>><b>&nbsp;2점</b></td>
			</tr>

			<tr>
				<td align="left"><b>&nbsp;3. 약간 제한됨</b></td>
				<td align="left"><b>혼자서 신체나 사지의 체위를 조금이기는 하지만 자주 변경시킨다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_4" value= "3"<? if($ck_db[8][0] == "3") echo "checked"?>><b>&nbsp;3점</b></td>
			</tr>

			<tr>
				<td align="left"><b>&nbsp;4. 제한 없음</b></td>
				<td align="left"><b>도움 없이도 체위를 자주 변경시킨다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_4" value= "4"<? if($ck_db[8][0] == "4") echo "checked"?>><b>&nbsp;4점</b></td>
			</tr>

			<!--=============================================================================================-->

			<tr>
				<td rowspan = "4" align="center"><b>5</b></td>			
				<td rowspan = "4" align="center"><b>영양상태</b></td>
				<td align="left"><b>&nbsp;1. 매우 나쁨</b></td>
				<td align="left"><b>제공된 음식의 1/3이하를 섭취한다. 단백질(고기나 유제품)을 하루에 2회 섭취량 이하를 먹는다. 수분을 잘 섭취안함. 유동성 영양보충액도 섭취하지 않음. 또는 5일 이상 동안 금식상태이거나 유동식으로 유지한다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_5" value= "1"<? if($ck_db[9][0] == "1") echo "checked"?>><b>&nbsp;1점</b></td>
			</tr>

			<tr>		
				<td align="left"><b>&nbsp;2. 부족함</b></td>
				<td align="left"><b>제공된 음식의 1/2를 먹는다. 단백질(고기나 유제품)을  하루에 3회 섭취량을 먹는다. 가끔 영양보충식이를 섭취한다. 또는 유동식이나 위관영양을 적당량 미만으로 투여받는다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_5" value= "2"<? if($ck_db[9][0] == "2") echo "checked"?>><b>&nbsp;2점</b></td>
			</tr>

			<tr>
				<td align="left"><b>&nbsp;3. 적당함</b></td>
				<td align="left"><b>식사의 반 이상을 먹는다. 단백질(고기나 유제품)을 하루에 4회섭취량을 먹는다. 가끔 식사를 거부하지만 보통 영양보충식이는 섭취한다. 또는 위관영양이나 TPN으로 대부분의 영양요구량이 중족된다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_5" value= "3"<? if($ck_db[9][0] == "3") echo "checked"?>><b>&nbsp;3점</b></td>
			</tr>

			<tr>
				<td align="left"><b>&nbsp;4. 우수함</b></td>
				<td align="left"><b>대부분의 식사를 섭취하며, 절대 거절하는 일이 없다. 단백질(고기나 유제품)을 하루에 4회 섭취량 이상을 먹으며,  가끔 식간에도 먹는다. 영양보충식이는 필요로 되지 않는다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_5" value= "4"<? if($ck_db[9][0] == "4") echo "checked"?>><b>&nbsp;4점</b></td>
			</tr>

			<!--=============================================================================================-->

						<tr>
				<td rowspan = "3" align="center"><b>6</b></td>			
				<td rowspan = "3" align="center"><b>마찰력과 응전력</b></td>
				<td align="left"><b>&nbsp;1. 문제 있음</b></td>
				<td align="left"><b>움직이는데 응전도 이상의 많은 도움을 필요로한다. 린넨으로 끌어당기지 않고 완전히 들어올리는 것은 불가능하다. 자주 침대나 의자에서 미끄러져 내려가 다시 제 위치로 옮기는데 많은 도움이 필요로 한다. 관절 구축이나 강직, 움직임 등으로 항상 마찰이 생긴다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_6" value= "1"<? if($ck_db[10][0] == "1") echo "checked"?>><b>&nbsp;1점</b></td>
			</tr>

			<tr>		
				<td align="left"><b>&nbsp;2. 잠적적으로 문제 있음</b></td>
				<td align="left"><b>자유로이 움직이나 약간의 도움을 필요로 한다. 움직이는 동안 의자억제대나 린넨 또는 다른 장비에 의해 마찰이 생길 수 있다. 의자나 침대에서 대부분 좋은 체위를 유지하고 있지만 가끔은 미끄러져 내려온다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_6" value= "2"<? if($ck_db[10][0] == "2") echo "checked"?>><b>&nbsp;2점</b></td>
			</tr>

			<tr>
				<td align="left"><b>&nbsp;3. 문제 없음</b></td>
				<td align="left"><b>침대나 의자에서 자유로이 움직이며, 움직일 떄 스스로 자신을 들어올릴 수 있을 정도로 충분한 근력이 있다. 침대나 의자에 누워 있을 떄 항상 좋은 체위를 유지한다.</b></td>
				<td align="center">&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_6" value= "3"<? if($ck_db[10][0] == "3") echo "checked"?>><b>&nbsp;3점</b></td>
			</tr>


			<!--=============================================================================================-->



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