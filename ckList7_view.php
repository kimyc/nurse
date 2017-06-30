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
	$max_mun = 10;

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
	<form name="form" action="ckList7_viewDB.php" method ="POST">

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
					<font color="black" size=4><b>7. 균형감 & 걸음걸이 사정 - Tinetti의 균형과 걸음걸이 평가법 (Tinetti Balance & Gait Evaluation)</b></font>
				</td>			
			</tr>
		</table>
		
		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">
			<tr>
				<td width = "5%" height="20" align="center" bgcolor="F9F9FB"><b>번호</b></td>			
				<td width = "20%"  align="center" bgcolor="F9F9FB"><b>요소</b></td>
				<td width = "65%"  align="center" bgcolor="F9F9FB"><b>판정</b></td>
				<td width = "5%"  align="center" bgcolor="F9F9FB"><b>점수</b></td>
				<td width = "5%"  align="center" bgcolor="F9F9FB"><b>선택</b></td>
			</tr>

			<!--=================================================================================================================-->
			<tr>
				<td rowspan = "2" align="center"><b>1</b></td>			
				<td rowspan = "2" align="center"><b>앉아있기</b></td>

				<td align="center">
					<font color="black" size=3><b>의자에 기대거나 미끄러지듯 앉아 있기</b></font>
				</td>

				<td align="center">
					<font color="black" size=3><b>0점</b></font>
				</td>
				
				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_1" value= "0">
						&nbsp;&nbsp;					
					</label>
					
				</td>
			</tr>

			<tr>				
				<td align="center">
					<font color="black" size=3><b>안정적이고 안전하게 앉아 있기</b></font>
				</td>	

				<td align="center">
					<font color="black" size=3><b>1점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_1" value= "1">
						&nbsp;&nbsp;					
					</label>
					
				</td>	
			</tr>
			
			<!--=================================================================================================================-->

			<tr bgcolor="eeeeee">
				<td rowspan = "3" align="center"><b>2</b></td>			
				<td rowspan = "3" align="center"><b>일어나기</b></td>

				<td align="center">
					<font color="black" size=3><b>도움 없이 일어나기가 불가능</b></font>
				</td>

				<td align="center">
					<font color="black" size=3><b>0점</b></font>
				</td>
				
				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_2" value= "0">
						&nbsp;&nbsp;					
					</label>
					
				</td>
			</tr>

			<tr bgcolor="eeeeee">	
				<td align="center">
					<font color="black" size=3><b>팔을 사용하여 일어남</b></font>
				</td>

				<td align="center">
					<font color="black" size=3><b>1점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_2" value= "1">
						&nbsp;&nbsp;					
					</label>
					
				</td>
			</tr>
			
			<tr bgcolor="eeeeee">				
				<td align="center">
					<font color="black" size=3><b>팔을 사용 않고도 일어남</b></font>
				</td>	

				<td align="center">
					<font color="black" size=3><b>2점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_2" value= "2">
						&nbsp;&nbsp;					
					</label>
					
				</td>	
			</tr>
			<!--=================================================================================================================-->			

			<tr>
				<td rowspan = "3" align="center"><b>3</b></td>			
				<td rowspan = "3" align="center"><b>일어나기 시도</b></td>

				<td align="center">
					<font color="black" size=3><b>도움 없이는 불가능</b></font>
				</td>

				<td align="center">
					<font color="black" size=3><b>0점</b></font>
				</td>
				
				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_3" value= "0">
						&nbsp;&nbsp;					
					</label>
					
				</td>
			</tr>

			<tr>	
				<td align="center">
					<font color="black" size=3><b>두 번 이상의 시도로 가능</b></font>
				</td>

				<td align="center">
					<font color="black" size=3><b>1점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_3" value= "1">
						&nbsp;&nbsp;					
					</label>
					
				</td>	
			</tr>
			
			<tr>	
				<td align="center">
					<font color="black" size=3><b>한 번의 시도로 가능</b></font>
				</td>

				<td align="center">
					<font color="black" size=3><b>2점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_3" value= "2">
						&nbsp;&nbsp;					
					</label>
					
				</td>		
			</tr>
			<!--=================================================================================================================-->	
			
			<tr bgcolor="eeeeee">
				<td rowspan = "3" align="center"><b>4</b></td>			
				<td rowspan = "3" align="center"><b>일어선 직후의 균형력<br>(일어선 후 5초 이내)</b></td>

				<td align="center">
					<font color="black" size=3><b>일어선 직후와 서 있을 때 불안정, 비틀거리거나 발이 움직이거나 몸체가 흔들림</b></font>
				</td>

				<td align="center">
					<font color="black" size=3><b>0점</b></font>
				</td>
				
				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_4" value= "0">
						&nbsp;&nbsp;					
					</label>
					
				</td>
			</tr>

			<tr bgcolor="eeeeee">				
				<td align="center">
					<font color="black" size=3><b>지팡이, 보행기, 주변물체 잡으면 안정된 자세 취함</b></font>
				</td>
					
				<td align="center">
					<font color="black" size=3><b>1점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_4" value= "1">
						&nbsp;&nbsp;					
					</label>
					
				</td>	
			</tr>
			
			<tr bgcolor="eeeeee">
				<td align="center">
					<font color="black" size=3><b>발을 가까이 모으거나 주변 물체 잡는 것 없이 안정된 자세 취함</b></font>
				</td>	

				<td align="center">
					<font color="black" size=3><b>2점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_4" value= "2">
						&nbsp;&nbsp;					
					</label>
					
				</td>		
			</tr>
			<!--=================================================================================================================-->
		
			<tr>
				<td rowspan = "2" align="center"><b>5</b></td>			
				<td rowspan = "2" align="center"><b>서서 있을 떄의 균형력</b></td>

				<td align="center">
					<font color="black" size=3><b>서 있을 때 불안정</b></font>
				</td>

				<td align="center">
					<font color="black" size=3><b>0점</b></font>
				</td>
				
				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_5" value= "0">
						&nbsp;&nbsp;					
					</label>
					
				</td>
			</tr>

			<tr>
				<td align="center">
					<font color="black" size=3><b>지팡이, 보행기, 주변물체 잡거나 발을 12인치(약 30cm) 이상 벌리고 서 있으면 안정된 자세 취함</b></font>
				</td>
					
				<td align="center">
					<font color="black" size=3><b>1점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_5" value= "1">
						&nbsp;&nbsp;					
					</label>
					
				</td>	
			</tr>
			
			<!--=================================================================================================================-->

			<tr bgcolor="eeeeee">
				<td rowspan = "3" align="center"><b>6</b></td>			
				<td rowspan = "3" align="center"><b>살짝 밀기<br><font size="2" color="blue">(방법 : 발을 최대한 근접시켜 검사자가<br>손바닥을 이용하여 피검사의 흉골 부위를<br>세번 가볍게 민다)</font></b></td>

				<td align="center">
					<font color="black" size=3><b>넘어지기 시작</b></font>
				</td>

				<td align="center">
					<font color="black" size=3><b>0점</b></font>
				</td>
				
				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_6" value= "0">
						&nbsp;&nbsp;					
					</label>
					
				</td>
			</tr>

			<tr bgcolor="eeeeee">
				<td align="center">
					<font color="black" size=3><b>비틀거리거나 주변 물체 잡고 중심 잡음</b></font>
				</td>
					
				<td align="center">
					<font color="black" size=3><b>1점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_6" value= "1">
						&nbsp;&nbsp;					
					</label>
					
				</td>	
			</tr>
			
			<tr bgcolor="eeeeee">
				<td align="center">
					<font color="black" size=3><b>흔들리지 않고 안정된 중심 잡음</b></font>
				</td>
					
				<td align="center">
					<font color="black" size=3><b>2점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_6" value= "2">
						&nbsp;&nbsp;					
					</label>
					
				</td>		
			</tr>
			<!--=================================================================================================================-->

		
			<tr>
				<td rowspan = "2" align="center"><b>7</b></td>			
				<td rowspan = "2" align="center"><b>눈감은 상태에서 살짝 밀기<br><font size="2" color="blue">(방법 : 발을 최대한 근접시켜 검사자가<br>손바닥을 이용하여 피검사의 흉골 부위를<br>세번 가볍게 민다)</font></b></td>

				<td align="center">
					<font color="black" size=3><b>불안정</b></font>
				</td>

				<td align="center">
					<font color="black" size=3><b>0점</b></font>
				</td>
				
				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_7" value= "0">
						&nbsp;&nbsp;					
					</label>
					
				</td>
			</tr>

			<tr>
				<td align="center">
					<font color="black" size=3><b>안정적</b></font>
				</td>
					
				<td align="center">
					<font color="black" size=3><b>1점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_7" value= "1">
						&nbsp;&nbsp;					
					</label>
					
				</td>	
			</tr>
			
			<!--=================================================================================================================-->

		
			<tr bgcolor="eeeeee">
				<td rowspan = "2" align="center"><b>8</b></td>			
				<td rowspan = "2" align="center"><b>360도 회전하기Ⅰ</b></td>

				<td align="center">
					<font color="black" size=3><b>연속적으로 옮길 수 없다</b></font>
				</td>

				<td align="center">
					<font color="black" size=3><b>0점</b></font>
				</td>

				
				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_8" value= "0">
						&nbsp;&nbsp;					
					</label>
					
				</td>
			</tr>

			<tr bgcolor="eeeeee">
				<td align="center">
					<font color="black" size=3><b>연속적으로 옮긴다</b></font>
				</td>
					
				<td align="center">
					<font color="black" size=3><b>1점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_8" value= "1">
						&nbsp;&nbsp;					
					</label>
					
				</td>	
			</tr>
			
			<!--=================================================================================================================-->

		
			<tr>
				<td rowspan = "2" align="center"><b>9</b></td>			
				<td rowspan = "2" align="center"><b>360도 회전하기Ⅱ</b></td>

				<td align="center">
					<font color="black" size=3><b>비틀거리거나 주변 물체를 잡으면서 불안정</b></font>
				</td>

				<td align="center">
					<font color="black" size=3><b>0점</b></font>
				</td>
				
				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_9" value= "0">
						&nbsp;&nbsp;					
					</label>
					
				</td>
			</tr>

			<tr>
				<td align="center">
					<font color="black" size=3><b>안정적</b></font>
				</td>	

				<td align="center">
					<font color="black" size=3><b>1점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_9" value= "1">
						&nbsp;&nbsp;					
					</label>
					
				</td>	
			</tr>
			
			<!--=================================================================================================================-->


			<tr bgcolor="eeeeee">
				<td rowspan = "3" align="center"><b>10</b></td>			
				<td rowspan = "3" align="center"><b>앉기(앉을 때의 동작)</b></td>

				<td align="center">
					<font color="black" size=3><b>불안정(덥석 주저앉거나 거리 사정을 못함)</b></font>
				</td>

				<td align="center">
					<font color="black" size=3><b>0점</b></font>
				</td>
				
				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_10" value= "0">
						&nbsp;&nbsp;					
					</label>
					
				</td>
			</tr>

			<tr bgcolor="eeeeee">
				<td align="center">
					<font color="black" size=3><b>팔을 이동하거나 동작이 매끄럽지 못함</b></font>
				</td>
					
				<td align="center">
					<font color="black" size=3><b>1점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_10" value= "1">
						&nbsp;&nbsp;					
					</label>
					
				</td>	
			</tr>
			
			<tr bgcolor="eeeeee">				
				<td align="center">
					<font color="black" size=3><b>안전하고 동작이 매끄러움</b></font>
				</td>	

				<td align="center">
					<font color="black" size=3><b>2점</b></font>
				</td>

				<td align="center">
					<label>
						&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_10" value= "2">
						&nbsp;&nbsp;					
					</label>
					
				</td>		
			</tr>
			<!--=================================================================================================================-->

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