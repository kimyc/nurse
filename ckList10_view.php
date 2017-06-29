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


	//체크 개수 저장하는 변수 chk_count
	var sur_1_count = 0;
	
	var sur_1 = document.getElementsByName('sur_1[]'); 

	for(i=0;i<sur_1.length;i++)
	{ 
		if(sur_1[i].checked==true) 
		{ 
			sur_1_count++;
		} 
	} 

	//선택된 것이 없으면 에러 메시지
	if(sur_1_count==0)
	{
		alert("치아상태에 답변을 해주세요.");
		return;
	}

<!--============================================-->

	//체크 개수 저장하는 변수 chk_count
	var sur_2_count = 0;
	
	var sur_2 = document.getElementsByName('sur_2[]'); 

	for(i=0;i<sur_2.length;i++)
	{ 
		if(sur_2[i].checked==true) 
		{ 
			sur_2_count++;
		} 
	} 

	//선택된 것이 없으면 에러 메시지
	if(sur_2_count==0)
	{
		alert("식사시 문제점에 답변을 해주세요.");
		return;
	}


<!--============================================-->	

	//체크 개수 저장하는 변수 chk_count
	var sur_3_count = 0;
	
	var sur_3 = document.getElementsByName('sur_3[]'); 

	for(i=0;i<sur_3.length;i++)
	{ 
		if(sur_3[i].checked==true) 
		{ 
			sur_3_count++;
		} 
	} 

	//선택된 것이 없으면 에러 메시지
	if(sur_3_count==0)
	{
		alert("식사형태에 답변을 해주세요.");
		return;
	}

<!--============================================-->	

	//체크 개수 저장하는 변수 chk_count
	var sur_4_count = 0;
	
	var sur_4 = document.getElementsByName('sur_4[]'); 

	for(i=0;i<sur_4.length;i++)
	{ 
		if(sur_4[i].checked==true) 
		{ 
			sur_4_count++;
		} 
	} 

	//선택된 것이 없으면 에러 메시지
	if(sur_4_count==0)
	{
		alert("도구사용에 답변을 해주세요.");
		return;
	}

	<!--============================================-->	

	//체크 개수 저장하는 변수 chk_count
	var sur_5_count = 0;
	
	var sur_5 = document.getElementsByName('sur_5[]'); 

	for(i=0;i<sur_5.length;i++)
	{ 
		if(sur_5[i].checked==true) 
		{ 
			sur_5_count++;
		} 
	} 

	//선택된 것이 없으면 에러 메시지
	if(sur_5_count==0)
	{
		alert("배설양상에 답변을 해주세요.");
		return;
	}

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
	<form name="form" action="ckList10_viewDB.php" method ="POST">

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
				<td width = "100%" height="20" align="left" bgcolor="FFFFFF">
					<font color="black" size=4><b>10. 영양상태</b></font>
				</td>
			</tr>
		</table>

		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">
			<tr>
				<td width = "20%" height="20" align="center" bgcolor="F9F9FB"><b>구분</b></td>			
				<td width = "80%"  align="center" bgcolor="F9F9FB"><b>확인</b></td>
			</tr>

			<tr>		 
				<td align="center"><b>치아상태</b></td>												
				<td align="left">
					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1[]" value= "1">&nbsp;&nbsp;양호&nbsp;&nbsp;&nbsp;
					</label>
					
					<br>
					
					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1[]" value= "2">&nbsp;&nbsp;불량&nbsp;&nbsp;&nbsp;
					</label>	
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1[]" value= "3">&nbsp;&nbsp;의치&nbsp;&nbsp;&nbsp;
					</label>
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1[]" value= "4">&nbsp;&nbsp;잔존치아 없음&nbsp;&nbsp;&nbsp;
					</label>
							
				</td>
			</tr>

			<tr>		 
				<td align="center"><b>식사시 문제점</b></td>												
				<td align="left">
					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2[]" value= "1">&nbsp;&nbsp;식욕저하&nbsp;&nbsp;&nbsp;
					</label>
					
					<br>
					
					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2[]" value= "2">&nbsp;&nbsp;저작곤란&nbsp;&nbsp;&nbsp;
					</label>	
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2[]" value= "3">&nbsp;&nbsp;연하곤란&nbsp;&nbsp;&nbsp;
					</label>
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2[]" value= "4">&nbsp;&nbsp;소화불량&nbsp;&nbsp;&nbsp;
					</label>

					<br>

					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2[]" value= "5">&nbsp;&nbsp;구토&nbsp;&nbsp;&nbsp;
					</label>

					<br>

					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2[]" value= "6">&nbsp;&nbsp;없음&nbsp;&nbsp;&nbsp;
					</label>
							
				</td>
			</tr>

			<tr>		 
				<td align="center"><b>식사형태</b></td>												
				<td align="left">
					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3[]" value= "1">&nbsp;&nbsp;미음&nbsp;&nbsp;&nbsp;
					</label>
					
					<br>
					
					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3[]" value= "2">&nbsp;&nbsp;죽&nbsp;&nbsp;&nbsp;
					</label>	
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3[]" value= "3">&nbsp;&nbsp;일반식&nbsp;&nbsp;&nbsp;
					</label>
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3[]" value= "4">&nbsp;&nbsp;당뇨식&nbsp;&nbsp;&nbsp;
					</label>
							
					<br>

					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3[]" value= "5">&nbsp;&nbsp;경관식&nbsp;&nbsp;&nbsp;
					</label>
				</td>
			</tr>

			<tr>		 
				<td align="center"><b>도구사용</b></td>												
				<td align="left">
					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_4[]" value= "1">&nbsp;&nbsp;숟가락&nbsp;&nbsp;&nbsp;
					</label>
					
					<br>
					
					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_4[]" value= "2">&nbsp;&nbsp;젓가락&nbsp;&nbsp;&nbsp;
					</label>	
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_4[]" value= "3">&nbsp;&nbsp;포크숟가락&nbsp;&nbsp;&nbsp;
					</label>
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_4[]" value= "4">&nbsp;&nbsp;사용불가&nbsp;&nbsp;&nbsp;
					</label>
							
				</td>
			</tr>

			<tr>		 
				<td align="center"><b>배설양상</b></td>												
				<td align="left">
					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_5[]" value= "1">&nbsp;&nbsp;정상&nbsp;&nbsp;&nbsp;
					</label>
					
					<br>
					
					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_5[]" value= "2">&nbsp;&nbsp;설사/변비&nbsp;&nbsp;&nbsp;
					</label>	
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_5[]" value= "3">&nbsp;&nbsp;복부팽만&nbsp;&nbsp;&nbsp;
					</label>					
							
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