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

<script language="javascript">
		
//==========================//입력여부 확인 함수 시작==========================
function checkIt(form){
<?
	//설문문항개수
	//$max_mun = 1;
	$max_mun = 10;

	for($i=1; $i<=$max_mun; $i++)
	{		

		$sur_ck3="sur_ck3_".$i;

?>
			//체크 개수 저장하는 변수 chk_count
			var chk_count = 0;
			var chk = document.getElementsByName('sur_ck3_<?echo $i;?>[]'); 

			//체크박스의 개수
			//alert(chk.length);

			for(i=0;i<chk.length;i++)
			{ 
				if(chk[i].checked==true) 
				{ 
					chk_count++;
				} 
			} 

			//선택된 개수
			//alert(chk_count);

			//선택된 것이 없으면 에러 메시지
			if(chk_count==0)
			{
				alert("<?echo $i;?>번) 질문에 답변하지 않으셨습니다!");
				return;
			}
<?
	}
?>


<!--============================================-->	

	if(confirm("작성하신 정보를 제출하시겠습니까?") ) 
	{
		form.submit();
	} 
	
	else
	{
		return;
	}
}



<!--==========================//입력여부 확인 함수 끝==========================-->		
	
	

</script>
	

<body>
	
<!-- 본 내용 //-->


<br>

	<!-- 설문내용 시작-->
	<table width="950" height="20" align="center" border="0" cellspacing="0">
	<form name="form" action="ckList3_viewDB.php" method ="POST">

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
				<td width = "100%" height="20" align="left" bgcolor="FFFFFF">
					<font color="black" size=4><b>3. 신체사정, 신체상태 욕구사정</b></font>					
				</td>			
			</tr>
		</table>

		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">
			<!--===========================================================================================================================================-->
			<tr>		 
				<td border="1" rowspan = "2" width = "8%" height="20" align="left" bgcolor="F9F9FB"><b>&nbsp;&nbsp;1) 호흡기계</b></td>												
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_1[]" value= "정상" id="ck_1_1"><label for="ck_1_1">&nbsp;&nbsp;정상&nbsp;&nbsp;&nbsp;</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_1[]" value= "통증" id="ck_1_2"><label for="ck_1_2">&nbsp;&nbsp;통증(운동시)&nbsp;&nbsp;&nbsp;</label>				
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_1[]" value= "지속적인기침" id="ck_1_3"><label for="ck_1_3">&nbsp;&nbsp;지속적인 기침&nbsp;&nbsp;&nbsp;</label>
				</td>
						
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_1[]" value= "잦은감기" id="ck_1_4"><label for="ck_1_4">&nbsp;&nbsp;잦은 감기&nbsp;&nbsp;&nbsp;</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_1[]" value= "객담" id="ck_1_5"><label for="ck_1_5">&nbsp;&nbsp;객담(색깔)&nbsp;&nbsp;&nbsp;</label>		
				</td>

				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_1[]" value= "객혈" id="ck_1_6"><label for="ck_1_6">&nbsp;&nbsp;객혈&nbsp;&nbsp;&nbsp;</label>									
				</td>
			</tr>
			
			<tr>
				<td colspan="6" width = "20%"  align="left">&nbsp;&nbsp;
					기타&nbsp;&nbsp;<input type="text" style="width:500px;height:30px;vertical-align: middle;"  name="sur_ck3_1_txt">&nbsp;(예 : T-tube, O2사용)				
				</td>
			</tr>


			<!--===========================================================================================================================================-->
			<tr>		 
				<td rowspan = "3"  width = "8%" height="20" align="left" bgcolor="F9F9FB"><b>&nbsp;&nbsp;2) 심혈관계</b></td>												
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_2[]" value= "정상" id="ck_2_1"><label for="ck_2_1">&nbsp;&nbsp;정상</label>
				</td>
						
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_2[]" value= "흉통" id="ck_2_2"><label for="ck_2_2">&nbsp;&nbsp;흉통</label>				
				</td>
						
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_2[]" value= "심계항진" id="ck_2_3"><label for="ck_2_3">&nbsp;&nbsp;심계항진</label>
				</td>
						
				<td width = "15%"  align="left">&nbsp;&nbsp;					
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_2[]" value= "청색증" id="ck_2_4"><label for="ck_2_4">&nbsp;&nbsp;청색증</label>
				</td>
						
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_2[]" value= "턱팔" id="ck_2_5"><label for="ck_2_5">턱 또는 팔의 방사통</label>
				</td>

				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_2[]" value= "부정맥" id="ck_2_6"><label for="ck_2_6">&nbsp;&nbsp;부정맥</label>			
				</td>
				
			</tr>
			
			<tr>	
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_2[]" value= "발목부종" id="ck_2_7"><label for="ck_2_7">&nbsp;&nbsp;발목부종</label>
				</td>
						
				<td colspan = "2" width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_2[]" value= "현기증" id="ck_2_8"><label for="ck_2_8">&nbsp;&nbsp;앉거나 설 때의 가벼운 현기증</label>	
				</td>
						
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_2[]" value= "정맥류" id="ck_2_9"><label for="ck_2_9">&nbsp;&nbsp;정맥류</label>	
				</td>
	
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_2[]" value= "다리통증" id="ck_2_10"><label for="ck_2_10">다리의 통증(활동시)</label>	
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_2[]" value= "손발저림" id="ck_2_11"><label for="ck_2_11">&nbsp;&nbsp;손발의 저림</label>											
				</td>
				
			</tr>
			
			<tr>								
				<td colspan="6" width = "20%"  align="left">&nbsp;&nbsp;
					기타&nbsp;&nbsp;<input type="text" style="width:500px;height:30px;vertical-align: middle;"  name="sur_ck3_2_txt">&nbsp;					
				</td>
			</tr>			
	
			<!--===========================================================================================================================================-->
			<tr>		 
				<td rowspan = "4" width = "8%" height="20" align="left" bgcolor="F9F9FB"><b>&nbsp;&nbsp;3) 소화기계</b></td>												
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "정상" id="ck_3_1"><label for="ck_3_1">&nbsp;&nbsp;정상</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "소화불량" id="ck_3_2"><label for="ck_3_2">&nbsp;&nbsp;소화불량</label>					
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "오심" id="ck_3_3"><label for="ck_3_3">&nbsp;&nbsp;오심</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "구토" id="ck_3_4"><label for="ck_3_4">&nbsp;&nbsp;구토</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "설사" id="ck_3_5"><label for="ck_3_5">&nbsp;&nbsp;설사</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "갈증" id="ck_3_6"><label for="ck_3_6">&nbsp;&nbsp;지나친 갈증</label>			
				</td>
				
			</tr>
			
			<tr>				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "복수" id="ck_3_7"><label for="ck_3_7">&nbsp;&nbsp;복수</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "복통" id="ck_3_8"><label for="ck_3_8">&nbsp;&nbsp;복통</label>	
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "속쓰림" id="ck_3_9"><label for="ck_3_9">&nbsp;&nbsp;속쓰림</label>	
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "식욕부진" id="ck_3_10"><label for="ck_3_10">&nbsp;&nbsp;식욕부진</label>	
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "혈변" id="ck_3_11"><label for="ck_3_11">&nbsp;&nbsp;혈변</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "변비" id="ck_3_12"><label for="ck_3_12">&nbsp;&nbsp;변비</label>		
				</td>
			</tr>
			
			<tr>				
				<td width = "15%"  align="left">&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "배변습관" id="ck_3_13"><label for="ck_3_13">최근 배변습관의 변화</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "대변실금" id="ck_3_14"><label for="ck_3_14">&nbsp;&nbsp;대변실금</label>		
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "치질" id="ck_3_15"><label for="ck_3_15">&nbsp;&nbsp;치질</label>		
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "장루" id="ck_3_16"><label for="ck_3_16">&nbsp;&nbsp;장루</label>		
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "위관영양" id="ck_3_17"><label for="ck_3_17">&nbsp;&nbsp;위관영양</label>		
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_3[]" value= "tube유무" id="ck_3_18"><label for="ck_3_18">&nbsp;&nbsp;tube유무</label>													
				</td>				
			</tr>
			
			<tr>				
				<td colspan="6" width = "15%"  align="left">&nbsp;&nbsp;					
					기타&nbsp;&nbsp;<input type="text" style="width:500px;height:30px;vertical-align: middle;"  name="sur_ck3_3_txt">&nbsp;					
				</td>
			</tr>	
	
			<!--===========================================================================================================================================-->
			<tr>		 
				<td rowspan = "2" width = "8%" height="20" align="left" bgcolor="F9F9FB"><b>&nbsp;&nbsp;4) 근골격계</b></td>												
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_4[]" value= "정상" id="ck_4_1"><label for="ck_4_1">&nbsp;&nbsp;정상</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;			
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_4[]" value= "관절통" id="ck_4_2"><label for="ck_4_2">&nbsp;&nbsp;관절통</label>					
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_4[]" value= "요통" id="ck_4_3"><label for="ck_4_3">&nbsp;&nbsp;요통</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_4[]" value= "척추변형" id="ck_4_4"><label for="ck_4_4">&nbsp;&nbsp;골(척추)변형</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_4[]" value= "담결림" id="ck_4_5"><label for="ck_4_5">&nbsp;&nbsp;담 결림</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_4[]" value= "위축강직" id="ck_4_6"><label for="ck_4_6">&nbsp;&nbsp;위축-강직</label>			
				</td>
			</tr>
			
			<tr>				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_4[]" value= "신경통" id="ck_4_7"><label for="ck_4_7">&nbsp;&nbsp;신경통</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_4[]" value= "불안전걸음" id="ck_4_8"><label for="ck_4_8">&nbsp;&nbsp;불안전한 걸음걸이</label>
				</td>
				
				<td colspan="4" width = "15%"  align="left">&nbsp;&nbsp;
					기타&nbsp;&nbsp;<input type="text" style="width:500px;height:30px;vertical-align: middle;"  name="sur_ck3_4_txt">&nbsp;					
				</td>
			</tr>	


			<!--===========================================================================================================================================-->
			<tr>		 
				<td rowspan = "2" width = "8%" height="20" align="left" bgcolor="F9F9FB"><b>&nbsp;&nbsp;5) 신경계</b></td>												
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_5[]" value= "정상" id="ck_5_1"><label for="ck_5_1">&nbsp;&nbsp;정상</label>
				</td>
								
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_5[]" value= "두통" id="ck_5_2"><label for="ck_5_2">&nbsp;&nbsp;두통(지속적,일시적)</label>					
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_5[]" value= "마비" id="ck_5_3"><label for="ck_5_3">&nbsp;&nbsp;마비</label>
				</td>
											
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_5[]" value= "경련" id="ck_5_4"><label for="ck_5_4">&nbsp;&nbsp;경련</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_5[]" value= "의식변화" id="ck_5_5"><label for="ck_5_5">&nbsp;&nbsp;의식변화</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_5[]" value= "감각이상" id="ck_5_6"><label for="ck_5_6">&nbsp;&nbsp;감각이상</label>			
				</td>			
			</tr>
			
			<tr>				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_5[]" value= "기동성장애" id="ck_5_7"><label for="ck_5_7">&nbsp;&nbsp;기동성장애</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_5[]" value= "손떨림증상" id="ck_5_8"><label for="ck_5_8">&nbsp;&nbsp;손떨림증상</label>
				</td>
				
				<td colspan = "4" width = "15%"  align="left">&nbsp;&nbsp;
					기타&nbsp;&nbsp;<input type="text" style="width:500px;height:30px;vertical-align: middle;"  name="sur_ck3_5_txt">&nbsp;					
				</td>
			</tr>		
				
			<!--===========================================================================================================================================-->
			
			<tr>		 
				<td rowspan = "2" width = "8%" height="20" align="left" bgcolor="F9F9FB"><b>&nbsp;&nbsp;6) 심리상태</b></td>												
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_6[]" value= "정상" id="ck_6_1"><label for="ck_6_1">&nbsp;&nbsp;정상</label>
				</td>
								
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_6[]" value= "지남력장애" id="ck_6_2"><label for="ck_6_2">&nbsp;&nbsp;지남력 장애</label>			
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_6[]" value= "환각" id="ck_6_3"><label for="ck_6_3">&nbsp;&nbsp;환각</label>
				</td>
											
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_6[]" value= "우울증" id="ck_6_4"><label for="ck_6_4">&nbsp;&nbsp;우울증</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_6[]" value= "조울증" id="ck_6_5"><label for="ck_6_5">&nbsp;&nbsp;조울증</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_6[]" value= "자살기도" id="ck_6_6"><label for="ck_6_6">&nbsp;&nbsp;자살기도</label>			
				</td>			
			</tr>
			
			<tr>				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_6[]" value= "불안" id="ck_6_7"><label for="ck_6_7">&nbsp;&nbsp;불안</label>
				</td>

				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_6[]" value= "수면장애" id="ck_6_8"><label for="ck_6_8">&nbsp;&nbsp;수면장애</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_6[]" value= "건망증" id="ck_6_9"><label for="ck_6_9">&nbsp;&nbsp;건망증</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_6[]" value= "대인접촉회피증상" id="ck_6_10"><label for="ck_6_10">&nbsp;&nbsp;대인접촉회피증상</label>
				</td>
				
				<td colspan = "2" width = "15%"  align="left">&nbsp;&nbsp;
					기타&nbsp;&nbsp;<input type="text" style="width:300px;height:30px;vertical-align: middle;"  name="sur_ck3_6_txt">&nbsp;					
				</td>
			</tr>			
			
			<!--===========================================================================================================================================-->
			
			<tr>		 
				<td rowspan = "1" width = "8%" height="20" align="left" bgcolor="F9F9FB"><b>&nbsp;&nbsp;7) 피부</b></td>												
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_7[]" value= "정상" id="ck_7_1"><label for="ck_7_1">&nbsp;&nbsp;정상</label>
				</td>
								
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_7[]" value= "발진" id="ck_7_2"><label for="ck_7_2">&nbsp;&nbsp;발진</label>		
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_7[]" value= "황달" id="ck_7_3"><label for="ck_7_3">&nbsp;&nbsp;황달</label>
				</td>
											
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_7[]" value= "소양증" id="ck_7_4"><label for="ck_7_4">&nbsp;&nbsp;소양증</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_7[]" value= "욕창궤양" id="ck_7_5"><label for="ck_7_5">&nbsp;&nbsp;욕창 또는 궤양</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					기타&nbsp;&nbsp;<input type="text" style="width:130px;height:30px;vertical-align: middle;"  name="sur_ck3_7_txt">&nbsp;					
				</td>		
			</tr>			
			
			<!--===========================================================================================================================================-->
			
			<tr>		 
				<td rowspan = "2" width = "8%" height="20" align="left" bgcolor="F9F9FB"><b>&nbsp;&nbsp;8) 눈</b></td>												
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_8[]" value= "정상" id="ck_8_1"><label for="ck_8_1">&nbsp;&nbsp;정상</label>
				</td>
								
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_8[]" value= "부종" id="ck_8_2"><label for="ck_8_2">&nbsp;&nbsp;부종</label>		
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_8[]" value= "감염" id="ck_8_3"><label for="ck_8_3">&nbsp;&nbsp;감염</label>
				</td>
											
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_8[]" value= "통증" id="ck_8_4"><label for="ck_8_4">&nbsp;&nbsp;통증</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_8[]" value= "복시" id="ck_8_5"><label for="ck_8_5">&nbsp;&nbsp;복시</label>
				</td>

				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_8[]" value= "분비물" id="ck_8_6"><label for="ck_8_6">&nbsp;&nbsp;분비물</label>
				</td>			
			</tr>		
			
			<tr>												
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_8[]" value= "시력결손" id="ck_8_7"><label for="ck_8_7">&nbsp;&nbsp;시력결손(L/R)</label>
				</td>
								
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_8[]" value= "약시" id="ck_8_8"><label for="ck_8_8">&nbsp;&nbsp;약시</label>		
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_8[]" value= "난시" id="ck_8_9"><label for="ck_8_9">&nbsp;&nbsp;난시</label>
				</td>
											
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_8[]" value= "백내장" id="ck_8_10"><label for="ck_8_10">&nbsp;&nbsp;백내장</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_8[]" value= "녹내장" id="ck_8_11"><label for="ck_8_11">&nbsp;&nbsp;녹내장</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					기타&nbsp;&nbsp;<input type="text" style="width:130px;height:30px;vertical-align: middle;"  name="sur_ck3_8_txt">&nbsp;					
				</td>		
			</tr>					
			
			<!--===========================================================================================================================================-->
			
			<tr>		 
				<td rowspan = "2" width = "8%" height="20" align="left" bgcolor="F9F9FB"><b>&nbsp;&nbsp;9) 귀</b></td>												
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_9[]" value= "정상" id="ck_9_1"><label for="ck_9_1">&nbsp;&nbsp;정상</label>
				</td>
								
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_9[]" value= "통증" id="ck_9_2"><label for="ck_9_2">&nbsp;&nbsp;통증</label>		
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_9[]" value= "이명" id="ck_9_3"><label for="ck_9_3">&nbsp;&nbsp;이명</label>
				</td>
											
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_9[]" value= "분비물" id="ck_9_4"><label for="ck_9_4">&nbsp;&nbsp;분비물</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_9[]" value= "난청" id="ck_9_5"><label for="ck_9_5">&nbsp;&nbsp;난청</label>
				</td>

				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_9[]" value= "청력상실" id="ck_9_6"><label for="ck_9_6">&nbsp;&nbsp;청력상실(L/R)</label>
				</td>			
			</tr>		
			
			<tr>
				<td colspan = "6" width = "15%"  align="left">&nbsp;&nbsp;
					기타&nbsp;&nbsp;<input type="text" style="width:500px;height:30px;vertical-align: middle;"  name="sur_ck3_9_txt">&nbsp;					
				</td>		
			</tr>					

			<!--===========================================================================================================================================-->
			
			<tr>		 
				<td rowspan = "2" width = "8%" height="20" align="left" bgcolor="F9F9FB"><b>&nbsp;&nbsp;10) 입</b></td>												
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_10[]" value= "정상" id="ck_10_1"><label for="ck_10_1">&nbsp;&nbsp;정상</label>
				</td>
								
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_10[]" value= "병변" id="ck_10_2"><label for="ck_10_2">&nbsp;&nbsp;병변</label>		
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_10[]" value= "백태" id="ck_10_3"><label for="ck_10_3">&nbsp;&nbsp;백태</label>
				</td>
											
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_10[]" value= "구취" id="ck_10_4"><label for="ck_10_4">&nbsp;&nbsp;구취</label>
				</td>
				
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_10[]" value= "저작장애" id="ck_10_5"><label for="ck_10_5">&nbsp;&nbsp;저작장애</label>
				</td>

				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_10[]" value= "충치" id="ck_10_6"><label for="ck_10_6">&nbsp;&nbsp;충치</label>
				</td>			
			</tr>		
			
			<tr>
				<td width = "15%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck3_10[]" value= "의치" id="ck_10_7"><label for="ck_10_7">&nbsp;&nbsp;의치(위/아래)</label>
				</td>					
				
				<td colspan = "5" width = "15%"  align="left">&nbsp;&nbsp;
					기타&nbsp;&nbsp;<input type="text" style="width:500px;height:30px;vertical-align: middle;"  name="sur_ck3_10_txt">&nbsp;					
				</td>		
			</tr>	
											
		</table>		
		
		

		<!--목록보기-->
		<table width="100%" height="50" align="center" border="0" cellspacing="0"">
			<tr>
				<br>
				<td width = "100%" height="20" align="right" bgcolor="FFFFFF">
					&nbsp;<a href="./main.php"><img src="./img/btn_list.png" align="center" width="108" height="40"></a>
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