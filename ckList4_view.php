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
	$max_mun = 30;

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
			case 12:
			case 13:
			case 14:
			case 15:
			case 16:
			case 17:
			case 18:
			case 19:
			case 20:
			case 21:
			case 22:
			case 23:
			case 24:
			case 25:
			case 26:
			case 27:
			case 28:
			case 29:
			case 30:
			
			
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
	<form name="form" action="ckList4_viewDB.php" method ="POST">

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
					<font color="black" size=4><b>4. 인지상태 욕구사정 (MMSE-K)</b></font>
				</td>			
			</tr>
		</table>
		
		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">
			<tr>
				<td width = "5%" height="20" align="center" bgcolor="F9F9FB"><b>번호</b></td>			
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>대분류</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>소분류</b></td>
				<td width = "70%"  align="center" bgcolor="F9F9FB"><b>내용</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>틀렸음(X)</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>맞았음(O)</b></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>1</b></td>			
				<td rowspan = "10" width = "10%"  align="center"><b>지남력<br>(+1)</b></td>
				<td rowspan = "5" width = "10%"  align="center"><b>시간</b></td>
				<td width = "70%"  align="center"><b>오늘은 몇 년입니까?</b></td>

				
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_1" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_1" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>2</b></td>	
				<td width = "70%"  align="center"><b>몇 월?</b></td>


				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_2" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_2" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>3</b></td>		
				<td width = "70%"  align="center"><b>몇 일?</b></td>


				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_3" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_3" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>4</b></td>			
				<td width = "70%"  align="center"><b>무슨 요일? </b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_4" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_4" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>5</b></td>		
				<td width = "70%"  align="center"><b>요즈음 어떤 계절입니까?</b></td>

				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_5" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_5" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>6</b></td>	
				<td rowspan = "5" width = "10%"  align="center"><b>장소</b></td>						
				<td width = "70%"  align="center"><b>당신은 무슨 시에 살고 있습니까?</b></td>

				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_6" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_6" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>7</b></td>					
				<td width = "70%"  align="center"><b>무슨 구?</b></td>
		
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_7" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_7" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>8</b></td>		
				<td width = "70%"  align="center"><b>무슨 동?</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_8" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_8" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>9</b></td>		
				<td width = "70%"  align="center"><b>여기가 어디입니까? (예: 병원, 요양원)</b></td>
		
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_9" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_9" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>10</b></td>			
				<td width = "70%"  align="center"><b>여기가 무엇을 하는 곳입니까? (예: 요양하는 곳, 치료받는 곳)</b></td>
		
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_10" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_10" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>11</b></td>		
				<td rowspan = "6" width = "10%"  align="center"><b>기억력</b></td>
				<td rowspan = "3"  width = "10%"  align="center"><b>기억등록</b></td>						
				<td width = "70%"  align="center"><b>세 가지 단어 즉시 따라하기(나무)</b></td>
			

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_11" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_11" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>12</b></td>						
				<td width = "70%"  align="center"><b>세 가지 단어 즉시 따라하기( 자동차)</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_12" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_12" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>13</b></td>			
				<td width = "70%"  align="center"><b>세 가지 단어 즉시 따라하기( 모자)</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_13" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_13" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>14</b></td>	
				<td rowspan = "3"  width = "10%"  align="center"><b>기억회상</b></td>	
				<td width = "70%"  align="center"><b>5분 후 "아까 말한 세 가지 단어를 생각해서 말씀 해주세요." (나무)</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_14" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_14" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>15</b></td>			
				<td width = "70%"  align="center"><b>5분 후 "아까 말한 세 가지 단어를 생각해서 말씀 해주세요." (자동차)</b></td>
		
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_15" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_15" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>16</b></td>										
				<td width = "70%"  align="center"><b>5분 후 "아까 말한 세 가지 단어를 생각해서 말씀 해주세요." (모자)</b></td>
		
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_16" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_16" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>


			<tr>
				<td width = "10%" height="20" align="center"><b>17</b></td>	
				<td rowspan = "5" width = "10%"  align="center"><b>주의집중<br>및 계산<br>(+2)</b></td>
				<td rowspan = "5" width = "10%"  align="center"><b>수리력</b></td>						
				<td width = "70%"  align="center"><b>100-7</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_17" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_17" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>18</b></td>			
				<td width = "70%"  align="center"><b>-7</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_18" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_18" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>19</b></td>		
				<td width = "70%"  align="center"><b>-7</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_19" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_19" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>20</b></td>			
				<td width = "70%"  align="center"><b>-7</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_20" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_20" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>21</b></td>			
				<td width = "70%"  align="center"><b>-7 또는 삼천리 강산을 거꾸로</b></td>
			

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_21" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_21" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>22</b></td>		
				<td rowspan = "7" width = "10%"  align="center"><b>언어 및<br>시공간 구성<br>(+1)</b></td>
				<td rowspan = "2" width = "10%"  align="center"><b>이름<br>맞추기</b></td>						
				<td width = "70%"  align="center"><b>이것을 무엇이라고 합니까?(연필)</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_22" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_22" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>23</b></td>		
				<td width = "70%"  align="center"><b>이것을 무엇이라고 합니까?(시계)</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_23" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_23" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>24</b></td>		
				<td rowspan = "3" width = "10%"  align="center"><b>3단계 명령</b></td>						
				<td width = "70%"  align="center"><b>"제가 지금 말씀드리는 것을 잘 들으시고 말씀드린대로 해보세요." <br>1. 오른 손으로 종이를 들어서  </b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_24" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_24" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>25</b></td>	
				<td width = "70%"  align="center"><b>"제가 지금 말씀드리는 것을 잘 들으시고 말씀드린대로 해보세요." <br> 2. 반으로 접어</b></td>
		
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_25" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_25" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>26</b></td>		
				<td width = "70%"  align="center"><b>"제가 지금 말씀드리는 것을 잘 들으시고 말씀드린대로 해보세요."  <br> 3. 무릎 위에 올려놓으세요.</b></td>
		
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_26" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_26" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>

			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>27</b></td>	
				<td width = "10%"  align="center"><b>복사</b></td>						
				<td width = "70%"  align="center"><b>오각형 두 개 겹쳐 그리기</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_27" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_27" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>28</b></td>
				<td width = "10%"  align="center"><b>반복</b></td>						
				<td width = "70%"  align="center"><b>"간장 공장 공장장" 따라하기</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_28" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_28" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>29</b></td>		
				<td rowspan = "2" width = "10%"  align="center"><b>이해 및 판단</b></td>
				<td width = "10%"  align="center"><b>이해</b></td>						
				<td width = "70%"  align="center"><b>" 왜 옷은 빨아서 입습니까?"</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_29" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_29" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>30</b></td>	
				<td width = "10%"  align="center"><b>판단</b></td>						
				<td width = "70%"  align="center"><b>"길에서 주민등록증을 주웠을 때 어떻게 하면 쉽게 주인에게 돌려줄 수 있습니까?"</b></td>
	
				
				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_30" value= "0">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
				
				

				<td width = "10%"  align="center">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_30" value= "1">
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>
				</td>
			</tr>
		</table>
		

		<table width="100%" height="40" align="center" border="0" cellspacing="0"">
			<tr>
				<td>
					<br>
				</td>			
			</tr>
		</table>

		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">
			<tr>
				<td colspan = "3" width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>무학/무명여부</b></td>
				<td colspan = "3">
					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_31" value= "0"><b>&nbsp;해당없음(+0점)</b>
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>

					<label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_31" value= "4"><b>&nbsp;무학/무명(+4점)</b>
						&nbsp;&nbsp;&nbsp;&nbsp;
					</label>

				</td>
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