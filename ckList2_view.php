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
	//나이 자동계산 
	function Display_age() 
	{
	    //선택한 값
	    var num=document.getElementById("sur_birth_y").value;	    
	
		if(!form.sur_birth_y.value)
		{ 
			alert('출생년도를 선택해주세요.'); 
			return; 
		} 	

	
	    //결과값 보이기
	    document.getElementById("is_nums").innerHTML =eval(2016-num+1) + "세"; 
	}

	//거주일 자동계산 
	function Display_enter() 
	{
		//오늘 날짜 구하기
		var d = new Date();
		var today_y = d.getFullYear();
		var today_m = d.getMonth()+1;
		var today_d = d.getDate();
		
		//입력한 날짜 저장
		var enter_y = document.getElementById("sur_enter_y").value;
		var enter_m = document.getElementById("sur_enter_m").value;
		var enter_d = document.getElementById("sur_enter_d").value; 
		
		//날짜 계산하기
		var date_today = new Date(today_y, today_m, today_d);
		var date_enter = new Date(enter_y, enter_m, enter_d);
		
		var diff = date_today - date_enter;
		var currDay = 24 * 60 * 60 * 1000; //시 * 분 * 초 * 밀리세컨
		var currMonth = currDay * 30 //월 만듬
		var currYear = currMonth * 12 //년 만듬
					
	    //입소일자 계산
	    var enter_day = parseInt(diff/currDay);	    
		
		//입력확인 메시지
		if(!form.sur_enter_y.value)
		{ 
			alert('입소년도를 선택해주세요.'); 
			return; 
		} 	
		
		if(!form.sur_enter_m.value)
		{ 
			alert('입소월을 선택해주세요.'); 
			return;  
		} 	

		if(!form.sur_enter_d.value)
		{ 
			alert('입소일을 선택해주세요.'); 
			return; 
		} 	


	
	    //결과값 보이기
	    document.getElementById("enter_day").innerHTML =eval(enter_day) + "일째"; 
	}
		
	
//==========================//입력여부 확인 함수 시작==========================
function checkIt(form){
<?

	//text, select 항목의 입력 확인
	echo "
	
			//입력된 값 보여주기
			//alert(form.".std_gend.".length);
			//alert(form.".std_ages.".value);

			for(i=0; i < form.".sur_gend.".length; i++)
			{ 
				if(form.".sur_gend."[i].checked==true)
				{ 
					//alert(form.".sur_gend."[i].value);
					break; 
				} 
			}
			
			if(i== form.".sur_gend.".length)
			{ 
				alert('성별을 선택해주세요.'); 
				return; 
			}				

			
			if(!form.sur_birth_y.value)
			{ 
				alert('출생년도를 선택해주세요.'); 
				return; 
			} 	
		
		
			if(!form.sur_birth_m.value)
			{ 
				alert('출생월을 선택해주세요.'); 
				return; 
			} 

			if(!form.sur_birth_d.value)
			{ 
				alert('출생일을 선택해주세요.'); 
				return; 
			} 
			
			for(i=0; i < form.".sur_god.".length; i++)
			{ 
				if(form.".sur_god."[i].checked==true)
				{ 
					//alert(form.".sur_god."[i].value);
					break; 
				} 
			}			 			
			
			if(i== form.".sur_god.".length)
			{ 
				alert('종교를 선택해주세요.'); 
				return; 
			}			


			for(i=0; i < form.".sur_pain.".length; i++)
			{ 
				if(form.".sur_pain."[i].checked==true)
				{ 
					//alert(form.".sur_gend."[i].value);
					break; 
				} 
			}

			if(i== form.".sur_pain.".length)
			{ 
				alert('통증여부를 선택해주세요.'); 
				return; 
			}	

			if(!form.sur_nrs.value)
			{ 
				alert('NRS 점수를 선택해주세요.'); 
				return; 
			} 	

			for(i=0; i < form.".sur_edu.".length; i++)
			{ 
				if(form.".sur_edu."[i].checked==true)
				{ 
					//alert(form.".sur_edu."[i].value);
					break; 
				} 
			}			 			
			
			if(i== form.".sur_edu.".length)
			{ 
				alert('최종학력을 선택해주세요.'); 
				return; 
			}

 			if(!form.sur_vigo1.value)
			{
				alert('활력징후(혈압)를 입력해주세요.');
				return;
			} 
		
			if(!form.sur_vigo2.value)
			{
				alert('활력징후(맥박)를 입력해주세요.');
				return;
			} 

			if(!form.sur_vigo3.value)
			{
				alert('활력징후(호흡)를 입력해주세요.');
				return;
			} 

			if(!form.sur_vigo4.value)
			{
				alert('활력징후(체온)를 입력해주세요.');
				return;
			} 
			
			if(!form.sur_height.value)
			{
				alert('키를 입력해주세요.');
				return;
			} 
			
			if(!form.sur_weight.value)
			{
				alert('체중을 입력해주세요.');
				return;
			} 

			for(i=0; i < form.".sur_state.".length; i++)
			{ 
				if(form.".sur_state."[i].checked==true)
				{ 
					//alert(form.".sur_state."[i].value);
					break; 
				} 
			}			 			
			
			if(i== form.".sur_state.".length)
			{ 
				alert('대상자 상태를 선택해주세요.'); 
				return; 
			}
 
 
 			if(!form.sur_enter_y.value)
			{ 
				alert('입소년도를 선택해주세요.'); 
				return; 
			} 	
		
		
			if(!form.sur_enter_m.value)
			{ 
				alert('입소월을 선택해주세요.'); 
				return; 
			} 

			if(!form.sur_enter_d.value)
			{ 
				alert('입소일을 선택해주세요.'); 
				return; 
			} 
	"

?>



	//체크 개수 저장하는 변수 chk_count
	var sur_fm1_count = 0;
	
	var sur_fm1 = document.getElementsByName('sur_fm1[]'); 

	for(i=0;i<sur_fm1.length;i++)
	{ 
		if(sur_fm1[i].checked==true) 
		{ 
			sur_fm1_count++;
		} 
	} 

	//선택된 개수
	//alert(sur_fm1_count);

	//선택된 것이 없으면 에러 메시지
	if(sur_fm1_count==0)
	{
		alert("가족력(부) 질문에 답변을 해주세요.");
		return;
	}

<!--============================================-->

	//체크 개수 저장하는 변수 chk_count
	var sur_fm2_count = 0;
	
	var sur_fm2 = document.getElementsByName('sur_fm2[]'); 

	for(i=0;i<sur_fm2.length;i++)
	{ 
		if(sur_fm2[i].checked==true) 
		{ 
			sur_fm2_count++;
		} 
	} 

	//선택된 개수
	//alert(sur_fm2_count);

	//선택된 것이 없으면 에러 메시지
	if(sur_fm2_count==0)
	{
		alert("가족력(모) 질문에 답변을 해주세요.");
		return;
	}
	
<!--============================================-->

	//체크 개수 저장하는 변수 chk_count
	var sur_fm3_count = 0;
	
	var sur_fm3 = document.getElementsByName('sur_fm3[]'); 

	for(i=0;i<sur_fm3.length;i++)
	{ 
		if(sur_fm3[i].checked==true) 
		{ 
			sur_fm3_count++;
		} 
	} 

	//선택된 개수
	//alert(sur_fm3_count);

	//선택된 것이 없으면 에러 메시지
	if(sur_fm3_count==0)
	{
		alert("가족력(형제자매) 질문에 답변을 해주세요.");
		return;
	}

<!--============================================-->

	//체크 개수 저장하는 변수 chk_count
	var sur_ck2_1_count = 0;
	
	var sur_ck2_1 = document.getElementsByName('sur_ck2_1[]'); 

	for(i=0;i<sur_ck2_1.length;i++)
	{ 
		if(sur_ck2_1[i].checked==true) 
		{ 
			sur_ck2_1_count++;
		} 
	} 

	//선택된 것이 없으면 에러 메시지
	if(sur_ck2_1_count==0)
	{
		alert("2.질병상태(현재 병력) 질문에 답변을 해주세요.");
		return;
	}

<!--============================================-->

	//체크 개수 저장하는 변수 chk_count
	var sur_ck2_2_count = 0;
	
	var sur_ck2_2 = document.getElementsByName('sur_ck2_2[]'); 

	for(i=0;i<sur_ck2_2.length;i++)
	{ 
		if(sur_ck2_2[i].checked==true) 
		{ 
			sur_ck2_2_count++;
		} 
	} 

	//선택된 것이 없으면 에러 메시지
	if(sur_ck2_2_count==0)
	{
		alert("2.질병상태(과거 병력) 질문에 답변을 해주세요.");
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
	<form name="form" action="ckList2_viewDB.php" method ="POST">

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
					<font color="black" size=4><b>1. 일반적 정보</b></font>
				</td>
			</tr>
		</table>

		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">

			<tr>
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>이름</b></td>				
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b><?echo $p_name?></b></td>

				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>성별</b></td>			
				<td width = "20%"  align="center">
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_gend" value= "남">&nbsp;남자&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_gend" value= "여">&nbsp;여자
				</td>
				
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>생년월일</b></td>	
				<td width = "35%"  align="center">
					<select name="sur_birth_y" id="sur_birth_y" style="width:100px;height:30px"">
						<option value="">연도 선택</option>
						<option value="1915">1915년</option>
						<option value="1916">1916년</option>
						<option value="1917">1917년</option>
						<option value="1918">1918년</option>
						<option value="1919">1919년</option>
						<option value="1920">1920년</option>
						<option value="1921">1921년</option>
						<option value="1922">1922년</option>
						<option value="1923">1923년</option>
						<option value="1924">1924년</option>
						<option value="1925">1925년</option>
						<option value="1926">1926년</option>
						<option value="1927">1927년</option>
						<option value="1928">1928년</option>
						<option value="1929">1929년</option>
						<option value="1930">1930년</option>
						<option value="1931">1931년</option>
						<option value="1932">1932년</option>
						<option value="1933">1933년</option>
						<option value="1934">1934년</option>
						<option value="1935">1935년</option>
						<option value="1936">1936년</option>
						<option value="1937">1937년</option>
						<option value="1938">1938년</option>
						<option value="1939">1939년</option>
						<option value="1940">1940년</option>
						<option value="1941">1941년</option>
						<option value="1942">1942년</option>
						<option value="1943">1943년</option>
						<option value="1944">1944년</option>
						<option value="1945">1945년</option>
						<option value="1946">1946년</option>
						<option value="1947">1947년</option>
						<option value="1948">1948년</option>
						<option value="1949">1949년</option>
						<option value="1950">1950년</option>
						<option value="1951">1951년</option>
						<option value="1952">1952년</option>						
						<option value="1953">1953년</option>
						<option value="1954">1954년</option>
						<option value="1955">1955년</option>
						<option value="1956">1956년</option>
						<option value="1957">1957년</option>
						<option value="1958">1958년</option>
						<option value="1959">1959년</option>
						<option value="1960">1960년</option>
						<option value="1961">1961년</option>
						<option value="1962">1962년</option>
						<option value="1963">1963년</option>
						<option value="1964">1964년</option>
						<option value="1965">1965년</option>
						<option value="1966">1966년</option>
						<option value="1967">1967년</option>
						<option value="1968">1968년</option>
						<option value="1969">1969년</option>
						<option value="1970">1970년</option>
						<option value="1971">1971년</option>
						<option value="1972">1972년</option>
						<option value="1973">1973년</option>
						<option value="1974">1974년</option>
						<option value="1975">1975년</option>
						<option value="1976">1976년</option>
						<option value="1977">1977년</option>
						<option value="1978">1978년</option>
						<option value="1979">1979년</option>
						<option value="1980">1980년</option>
						<option value="1981">1981년</option>
						<option value="1982">1982년</option>
						<option value="1983">1983년</option>
						<option value="1984">1984년</option>
						<option value="1985">1985년</option>
						<option value="1986">1986년</option>
						<option value="1987">1987년</option>
						<option value="1988">1988년</option>
						<option value="1989">1989년</option>
						<option value="1990">1990년</option>
						<option value="1991">1991년</option>
						<option value="1992">1992년</option>
						<option value="1993">1993년</option>
						<option value="1994">1994년</option>
						<option value="1995">1995년</option>
						<option value="1996">1996년</option>
					</select>&nbsp;&nbsp;

					<select name="sur_birth_m" style="width:75px;height:30px"">
						<option value="">월 선택</option>
						<option value="1">1월</option>
						<option value="2">2월</option>
						<option value="3">3월</option>
						<option value="4">4월</option>
						<option value="5">5월</option>
						<option value="6">6월</option>
						<option value="7">7월</option>
						<option value="8">8월</option>
						<option value="9">9월</option>
						<option value="10">10월</option>
						<option value="11">11월</option>
						<option value="12">12월</option>						
					</select>&nbsp;&nbsp;
					
					<select name="sur_birth_d" style="width:75px;height:30px" >
						<option value="">일 선택</option>
						<option value="1">1일</option>
						<option value="2">2일</option>
						<option value="3">3일</option>
						<option value="4">4일</option>
						<option value="5">5일</option>
						<option value="6">6일</option>
						<option value="7">7일</option>
						<option value="8">8일</option>
						<option value="9">9일</option>
						<option value="10">10일</option>
						<option value="11">11일</option>
						<option value="12">12일</option>
						<option value="13">13일</option>
						<option value="14">14일</option>
						<option value="15">15일</option>
						<option value="16">16일</option>
						<option value="17">17일</option>
						<option value="18">18일</option>
						<option value="19">19일</option>
						<option value="20">20일</option>
						<option value="21">21일</option>
						<option value="22">22일</option>
						<option value="23">23일</option>
						<option value="24">24일</option>
						<option value="25">25일</option>
						<option value="26">26일</option>
						<option value="27">27일</option>
						<option value="28">28일</option>
						<option value="29">29일</option>
						<option value="30">30일</option>
						<option value="31">31일</option>
					</select>&nbsp;&nbsp;				
				</td>				
				
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b><a href="#" onclick="Display_age();return false;">나이<br><font color="red">(클릭해주세요)</font></a></b></td>	
				<td width = "10%"  align="center">						
					<div id="is_nums"></div>				
				</td>
			</tr>

			<tr>		 
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>종교</b></td>								
				<td colspan="3" width = "45%"  align="center">
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_god" value= "기독교">&nbsp;기독교&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_god" value= "불교">&nbsp;불교&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_god" value= "천주교">&nbsp;천주교&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_god" value= "기타">&nbsp;기타&nbsp;
					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_god_txt">&nbsp;					
				</td>
				
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>최종학력</b></td>				
				<td colspan="3" width = "45%"  align="center" bgcolor="F9F9FB">
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_edu" value= "초졸">&nbsp;초졸&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_edu" value= "중졸">&nbsp;중졸&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_edu" value= "고졸">&nbsp;고졸&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_edu" value= "대졸">&nbsp;대졸&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_edu" value= "대학원이상">&nbsp;대학원 이상&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_edu" value= "기타">&nbsp;기타&nbsp;
					<input type="text" style="width:65px;height:30px;vertical-align: middle;"  name="sur_edu_txt">				
				</td>
			</tr>
				
			<tr>		 
				<td rowspan = "3" width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>가족력</b></td>
				<td width = "4" height="20" align="center" bgcolor="F9F9FB"><b>부</b></td>
				<td colspan="6" width = "45%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "없음" id="ck_1_1"><label for="ck_1_1">&nbsp;&nbsp;없음&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "당뇨" id="ck_1_2"><label for="ck_1_2">&nbsp;&nbsp;당뇨&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "고혈압" id="ck_1_3"><label for="ck_1_3">&nbsp;&nbsp;고혈압&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "뇌졸증" id="ck_1_4"><label for="ck_1_4">&nbsp;&nbsp;뇌졸증&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "치매" id="ck_1_5"><label for="ck_1_5">&nbsp;&nbsp;치매&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "심장질환" id="ck_1_6"><label for="ck_1_6">&nbsp;&nbsp;심장질환&nbsp;&nbsp;&nbsp;</label>			
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "암" id="ck_1_7"><label for="ck_1_7">&nbsp;&nbsp;암&nbsp;&nbsp;&nbsp;</label>										
					기타&nbsp;&nbsp;<input type="text" style="width:300px;height:30px;vertical-align: middle;"  name="sur_fm1_txt">&nbsp;					
				</td>
			</tr>

			<tr>
				<td width = "4" height="20" align="center" bgcolor="F9F9FB"><b>모</b></td>								
				<td colspan="6" width = "45%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "없음" id="ck_2_1"><label for="ck_2_1">&nbsp;&nbsp;없음&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "당뇨" id="ck_2_2"><label for="ck_2_2">&nbsp;&nbsp;당뇨&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "고혈압" id="ck_2_3"><label for="ck_2_3">&nbsp;&nbsp;고혈압&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "뇌졸증" id="ck_2_4"><label for="ck_2_4">&nbsp;&nbsp;뇌졸증&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "치매" id="ck_2_5"><label for="ck_2_5">&nbsp;&nbsp;치매&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "심장질환" id="ck_2_6"><label for="ck_2_6">&nbsp;&nbsp;심장질환&nbsp;&nbsp;&nbsp;</label>			
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "암" id="ck_2_7"><label for="ck_2_7">&nbsp;&nbsp;암&nbsp;&nbsp;&nbsp;</label>										
					기타&nbsp;&nbsp;<input type="text" style="width:300px;height:30px;vertical-align: middle;"  name="sur_fm2_txt">&nbsp;					
				</td>
			</tr>

			<tr>
				<td width = "4" height="20" align="center" bgcolor="F9F9FB"><b>형제자매</b></td>								
				<td colspan="6" width = "45%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "없음" id="ck_3_1"><label for="ck_3_1">&nbsp;&nbsp;없음&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "당뇨" id="ck_3_2"><label for="ck_3_2">&nbsp;&nbsp;당뇨&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "고혈압" id="ck_3_3"><label for="ck_3_3">&nbsp;&nbsp;고혈압&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "뇌졸증" id="ck_3_4"><label for="ck_3_4">&nbsp;&nbsp;뇌졸증&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "치매" id="ck_3_5"><label for="ck_3_5">&nbsp;&nbsp;치매&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "심장질환" id="ck_3_6"><label for="ck_3_6">&nbsp;&nbsp;심장질환&nbsp;&nbsp;&nbsp;</label>			
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "암" id="ck_3_7"><label for="ck_3_7">&nbsp;&nbsp;암&nbsp;&nbsp;&nbsp;</label>
					기타&nbsp;&nbsp;<input type="text" style="width:300px;height:30px;vertical-align: middle;"  name="sur_fm3_txt">&nbsp;					
				</td>
			</tr>

			<tr>		 
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>활력징후</b></td>												
				<td colspan="7" width = "45%"  align="left">&nbsp;&nbsp;									
					혈압&nbsp;&nbsp;<input type="text" style="width:80px;height:30px;vertical-align: middle;"  name="sur_vigo1">&nbsp;mmHg&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					맥박&nbsp;&nbsp;<input type="text" style="width:80px;height:30px;vertical-align: middle;"  name="sur_vigo2">&nbsp;회/분&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					호흡&nbsp;&nbsp;<input type="text" style="width:80px;height:30px;vertical-align: middle;"  name="sur_vigo3">&nbsp;회/분&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					체온&nbsp;&nbsp;<input type="text" style="width:80px;height:30px;vertical-align: middle;"  name="sur_vigo4">&nbsp;℃					
				</td>
			</tr>

			<tr>		 
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>키/체중</b></td>												
				<td colspan="7" width = "45%"  align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;								
					 키&nbsp;&nbsp;<input type="text" style="width:80px;height:30px;vertical-align: middle;"  name="sur_height">&nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					체중&nbsp;&nbsp;<input type="text" style="width:80px;height:30px;vertical-align: middle;"  name="sur_weight">&nbsp;kg&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;										
				</td>
			</tr>

			<tr>		 
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>대상자 상태</b></td>								
				<td colspan="3" width = "45%"  align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_state" value= "와상">&nbsp;와상&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_state" value= "준와상">&nbsp;준와상&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_state" value= "자립">&nbsp;자립										
				</td>
				
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>입소날짜</b></td>				
				<td width = "45%"  align="center">
					<select name="sur_enter_y" id="sur_enter_y" style="width:100px;height:30px"">
						<option value="">연도 선택</option>												
						<option value="2017">2017년</option>				
						<option value="2016">2016년</option>
						<option value="2015">2015년</option>
						<option value="2014">2014년</option>
						<option value="2013">2013년</option>
						<option value="2012">2012년</option>
						<option value="2011">2011년</option>
						<option value="2010">2010년</option>
						<option value="2009">2009년</option>
						<option value="2008">2008년</option>
						<option value="2007">2007년</option>
						<option value="2006">2006년</option>
						<option value="2005">2005년</option>
						<option value="2004">2004년</option>
						<option value="2003">2003년</option>
						<option value="2002">2002년</option>
						<option value="2001">2001년</option>
						<option value="2000">2000년</option>
						<option value="1999">1999년</option>
						<option value="1998">1998년</option>
						<option value="1997">1997년</option>
						<option value="1996">1996년</option>
						<option value="1995">1995년</option>
						<option value="1994">1994년</option>
						<option value="1993">1993년</option>
						<option value="1992">1992년</option>
						<option value="1991">1991년</option>
						<option value="1990">1990년</option>
						<option value="1989">1989년</option>
						<option value="1988">1988년</option>
						<option value="1987">1987년</option>
						<option value="1986">1986년</option>
						<option value="1985">1985년</option>
						<option value="1984">1984년</option>
						<option value="1983">1983년</option>
						<option value="1982">1982년</option>
						<option value="1981">1981년</option>
						<option value="1980">1980년</option>
						<option value="1979">1979년</option>
						<option value="1978">1978년</option>
						<option value="1977">1977년</option>
						<option value="1976">1976년</option>
						<option value="1975">1975년</option>
						<option value="1974">1974년</option>
						<option value="1973">1973년</option>
						<option value="1972">1972년</option>
						<option value="1971">1971년</option>
						<option value="1970">1970년</option>
						<option value="1969">1969년</option>
					</select>&nbsp;&nbsp;
					
					<select name="sur_enter_m" id="sur_enter_m" style="width:75px;height:30px"">
						<option value="">월 선택</option>
						<option value="1">1월</option>
						<option value="2">2월</option>
						<option value="3">3월</option>
						<option value="4">4월</option>
						<option value="5">5월</option>
						<option value="6">6월</option>
						<option value="7">7월</option>
						<option value="8">8월</option>
						<option value="9">9월</option>
						<option value="10">10월</option>
						<option value="11">11월</option>
						<option value="12">12월</option>						
					</select>&nbsp;&nbsp;
					
					<select name="sur_enter_d" id="sur_enter_d" style="width:75px;height:30px" >
						<option value="">일 선택</option>
						<option value="1">1일</option>
						<option value="2">2일</option>
						<option value="3">3일</option>
						<option value="4">4일</option>
						<option value="5">5일</option>
						<option value="6">6일</option>
						<option value="7">7일</option>
						<option value="8">8일</option>
						<option value="9">9일</option>
						<option value="10">10일</option>
						<option value="11">11일</option>
						<option value="12">12일</option>
						<option value="13">13일</option>
						<option value="14">14일</option>
						<option value="15">15일</option>
						<option value="16">16일</option>
						<option value="17">17일</option>
						<option value="18">18일</option>
						<option value="19">19일</option>
						<option value="20">20일</option>
						<option value="21">21일</option>
						<option value="22">22일</option>
						<option value="23">23일</option>
						<option value="24">24일</option>
						<option value="25">25일</option>
						<option value="26">26일</option>
						<option value="27">27일</option>
						<option value="28">28일</option>
						<option value="29">29일</option>
						<option value="30">30일</option>
						<option value="31">31일</option>
					</select>&nbsp;&nbsp;									
				</td>
				
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b><a href="#" onclick="Display_enter();return false;">거주일<br><font color="red">(클릭해주세요)</font></a></b></td>	
				<td width = "10%"  align="center">						
					<div id="enter_day"></div>				
				</td>
			</tr>
			
			<tr>		 
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>통증</b></td>								
				<td colspan="3" width = "45%"  align="center">
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_pain" value= "유">&nbsp;유&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_pain" value= "무">&nbsp;무&nbsp;&nbsp;&nbsp;

				</td>
				
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>NRS 점수</b></td>				
				<td colspan="3" width = "45%"  align="center" bgcolor="F9F9FB">
					<select name="sur_nrs" id="sur_nrs" style="width:120px;height:30px"">
						<option value="">점수선택</option>
						<option value="0">0점</option>
						<option value="1">1점</option>
						<option value="2">2점</option>
						<option value="3">3점</option>
						<option value="4">4점</option>
						<option value="5">5점</option>
						<option value="6">6점</option>
						<option value="7">7점</option>
						<option value="8">8점</option>
						<option value="9">9점</option>
						<option value="10">10점</option>					
					</select>&nbsp;&nbsp;			
				</td>
			</tr>


		</table>

		<table width="100%" height="40" align="center" border="0" cellspacing="0"">
			<tr>
				<td>
					
				</td>			
			</tr>
		</table>

		<table width="100%" height="40" align="center" border="0" cellspacing="0"">
			<tr>
				<td width = "100%" height="20" align="left" bgcolor="FFFFFF">
					<font color="black" size=4><b>2. 질병상태</b></font>
				</td>			
			</tr>
		</table>

		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">
			<tr>		 
				<td width = "8%" height="20" align="center" bgcolor="F9F9FB"><b>현재 병력</b></td>												
				<td width = "92%"  align="left">&nbsp;&nbsp;									
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "없음" id="ck_4_1"><label for="ck_4_1">&nbsp;&nbsp;없음&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "당뇨" id="ck_4_2"><label for="ck_4_2">&nbsp;&nbsp;당뇨&nbsp;&nbsp;&nbsp;</label>					
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "뇌졸증" id="ck_4_3"><label for="ck_4_3">&nbsp;&nbsp;뇌졸증&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "관절염" id="ck_4_4"><label for="ck_4_4">&nbsp;&nbsp;관절염&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "치매" id="ck_4_5"><label for="ck_4_5">&nbsp;&nbsp;치매&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "골절" id="ck_4_6"><label for="ck_4_6">&nbsp;&nbsp;골절&nbsp;&nbsp;&nbsp;</label>			
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "암" id="ck_4_7"><label for="ck_4_7">&nbsp;&nbsp;암&nbsp;&nbsp;&nbsp;</label>										
					기타&nbsp;&nbsp;<input type="text" style="width:300px;height:30px;vertical-align: middle;"  name="sur_ck2_1_txt">&nbsp;					
				</td>
			</tr>
			
			<tr>		 
				<td width = "8%" height="20" align="center" bgcolor="F9F9FB"><b>과거 병력</b></td>												
				<td width = "92%"  align="left">&nbsp;&nbsp;									
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "없음" id="ck_5_1"><label for="ck_5_1">&nbsp;&nbsp;없음&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "당뇨" id="ck_5_2"><label for="ck_5_2">&nbsp;&nbsp;당뇨&nbsp;&nbsp;&nbsp;</label>					
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "뇌졸증" id="ck_5_3"><label for="ck_5_3">&nbsp;&nbsp;뇌졸증&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "관절염" id="ck_5_4"><label for="ck_5_4">&nbsp;&nbsp;관절염&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "치매" id="ck_5_5"><label for="ck_5_5">&nbsp;&nbsp;치매&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "골절" id="ck_5_6"><label for="ck_5_6">&nbsp;&nbsp;골절&nbsp;&nbsp;&nbsp;</label>			
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "암" id="ck_5_7"><label for="ck_5_7">&nbsp;&nbsp;암&nbsp;&nbsp;&nbsp;</label>										
					기타&nbsp;&nbsp;<input type="text" style="width:300px;height:30px;vertical-align: middle;"  name="sur_ck2_2_txt">&nbsp;					
				</td>
			</tr>	
		</table>
		

		<!--목록보기-->
		<table width="100%" height="50" align="center" border="0" cellspacing="0"">
			<tr>
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