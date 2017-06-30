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
	$max_mun = 3;

	for($i=1; $i<=$max_mun; $i++)
	{		

		$sur="sur_".$i;

		switch($i) 
		{
			//라디오 버튼 문항
			case 1:
			case 2:
			case 3:
			
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



<!--==========================//입력여부 확인 함수 끝==========================-->		
	
	

</script>
	

<body>
	
<!-- 본 내용 //-->


<br>

	<!-- 설문내용 시작-->
	<table width="950" height="20" align="center" border="0" cellspacing="0">
	<form name="form" action="ckList9_viewDB.php" method ="POST">

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
					<font color="black" size=4><b>9. 의사소통</b></font>
				</td>
			</tr>
		</table>

		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">
			<tr>
				<td width = "20%" height="20" align="center" bgcolor="F9F9FB"><b>구분</b></td>			
				<td width = "80%"  align="center" bgcolor="F9F9FB"><b>확인</b></td>
			</tr>

			<tr>		 
				<td align="center"><b>청취능력</b></td>												
				<td align="left">
					<label>
						&nbsp;&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1" value= "1">&nbsp;&nbsp;들리는지 판단 불능 &nbsp;&nbsp;&nbsp;
					</label>

					<br>
					
					<label>
						&nbsp;&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1" value= "2">&nbsp;&nbsp;거의 들리지 않는다.&nbsp;&nbsp;&nbsp;
					</label>	
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1" value= "3">&nbsp;&nbsp;큰 소리는 들을 수 있다.&nbsp;&nbsp;&nbsp;
					</label>
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1" value= "4">&nbsp;&nbsp;보통의 소리를 듣기도 하고 못 듣기도 한다. &nbsp;&nbsp;&nbsp;
					</label>
					
					<br>

					<label>						
						&nbsp;&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_1" value= "5">&nbsp;&nbsp;정상(보청기 사용포함)&nbsp;&nbsp;&nbsp;
					</label>
							
				</td>
			</tr>

			<tr>		 
				<td align="center"><b>의사소통</b></td>												
				<td align="left">
					<label>
						&nbsp;&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2" value= "4">&nbsp;&nbsp;모두 이해하고 의사를 표현한다.   &nbsp;&nbsp;&nbsp;
					</label>
					
					<br>
					
					<label>
						&nbsp;&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2" value= "3">&nbsp;&nbsp;대부분 이해하고 의사를 표현한다.&nbsp;&nbsp;&nbsp;
					</label>	
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2" value= "2">&nbsp;&nbsp;가끔 이해하고 의사를 표현한다.&nbsp;&nbsp;&nbsp;
					</label>
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_2" value= "1">&nbsp;&nbsp;거의 이해하지 못하고 의사를 전달하지 못한다.&nbsp;&nbsp;&nbsp;
					</label>
							
				</td>
			</tr>

			<tr>		 
				<td align="center"><b>발음능력</b></td>												
				<td align="left">
					<label>
						&nbsp;&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3" value= "4">&nbsp;&nbsp;정확하게 발음이 가능하다. &nbsp;&nbsp;&nbsp;
					</label>
					
					<br>
					
					<label>
						&nbsp;&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3" value= "3">&nbsp;&nbsp;웅얼거리는 소리로만 한다.&nbsp;&nbsp;&nbsp;
					</label>	
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3" value= "2">&nbsp;&nbsp;간혹 어늘한 발음이 섞인다. &nbsp;&nbsp;&nbsp;
					</label>
					
					<br>

					<label>
						&nbsp;&nbsp;<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_3" value= "1">&nbsp;&nbsp;전혀 발음하지 못한다.&nbsp;&nbsp;&nbsp;
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