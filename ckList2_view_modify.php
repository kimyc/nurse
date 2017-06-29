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
		$ck2_sql = "
				SELECT * FROM nurse2016_ck2_view where p_key = '$p_key';
			   ";		
		$ck2_result = @mysql_query($ck2_sql);
		
		for($i=0; $i<36; $i++)
		{
	
			@mysql_data_seek($ck2_result, 0);
			$ck2_db = @mysql_fetch_row($ck2_result);
			//echo $ck2_db[$i];			
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
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_gend" value= "남" <? if($ck2_db[5] == "남") echo "checked"?>>&nbsp;남자&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_gend" value= "여" <? if($ck2_db[5] == "여") echo "checked"?>>&nbsp;여자
				</td>
				
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>생년월일</b></td>	
				<td width = "35%"  align="center">
					<select name="sur_birth_y" id="sur_birth_y" style="width:100px;height:30px"">
						<option value="">연도 선택</option>
						<option value="1915" <? if($ck2_db[6] == "1915") echo "selected = 'selected'"?>>1915년</option>
						<option value="1916" <? if($ck2_db[6] == "1916") echo "selected = 'selected'"?>>1916년</option>
						<option value="1917" <? if($ck2_db[6] == "1917") echo "selected = 'selected'"?>>1917년</option>
						<option value="1918" <? if($ck2_db[6] == "1918") echo "selected = 'selected'"?>>1918년</option>
						<option value="1919" <? if($ck2_db[6] == "1919") echo "selected = 'selected'"?>>1919년</option>
						<option value="1920" <? if($ck2_db[6] == "1920") echo "selected = 'selected'"?>>1920년</option>
						<option value="1921" <? if($ck2_db[6] == "1921") echo "selected = 'selected'"?>>1921년</option>
						<option value="1922" <? if($ck2_db[6] == "1922") echo "selected = 'selected'"?>>1922년</option>
						<option value="1923" <? if($ck2_db[6] == "1923") echo "selected = 'selected'"?>>1923년</option>
						<option value="1924" <? if($ck2_db[6] == "1924") echo "selected = 'selected'"?>>1924년</option>
						<option value="1925" <? if($ck2_db[6] == "1925") echo "selected = 'selected'"?>>1925년</option>
						<option value="1926" <? if($ck2_db[6] == "1926") echo "selected = 'selected'"?>>1926년</option>
						<option value="1927" <? if($ck2_db[6] == "1927") echo "selected = 'selected'"?>>1927년</option>
						<option value="1928" <? if($ck2_db[6] == "1928") echo "selected = 'selected'"?>>1928년</option>
						<option value="1929" <? if($ck2_db[6] == "1929") echo "selected = 'selected'"?>>1929년</option>
						<option value="1930" <? if($ck2_db[6] == "1930") echo "selected = 'selected'"?>>1930년</option>
						<option value="1931" <? if($ck2_db[6] == "1931") echo "selected = 'selected'"?>>1931년</option>
						<option value="1932" <? if($ck2_db[6] == "1932") echo "selected = 'selected'"?>>1932년</option>
						<option value="1933" <? if($ck2_db[6] == "1933") echo "selected = 'selected'"?>>1933년</option>
						<option value="1934" <? if($ck2_db[6] == "1934") echo "selected = 'selected'"?>>1934년</option>
						<option value="1935" <? if($ck2_db[6] == "1935") echo "selected = 'selected'"?>>1935년</option>
						<option value="1936" <? if($ck2_db[6] == "1936") echo "selected = 'selected'"?>>1936년</option>
						<option value="1937" <? if($ck2_db[6] == "1937") echo "selected = 'selected'"?>>1937년</option>
						<option value="1938" <? if($ck2_db[6] == "1938") echo "selected = 'selected'"?>>1938년</option>
						<option value="1939" <? if($ck2_db[6] == "1939") echo "selected = 'selected'"?>>1939년</option>
						<option value="1940" <? if($ck2_db[6] == "1940") echo "selected = 'selected'"?>>1940년</option>
						<option value="1941" <? if($ck2_db[6] == "1941") echo "selected = 'selected'"?>>1941년</option>
						<option value="1942" <? if($ck2_db[6] == "1942") echo "selected = 'selected'"?>>1942년</option>
						<option value="1943" <? if($ck2_db[6] == "1943") echo "selected = 'selected'"?>>1943년</option>
						<option value="1944" <? if($ck2_db[6] == "1944") echo "selected = 'selected'"?>>1944년</option>
						<option value="1945" <? if($ck2_db[6] == "1945") echo "selected = 'selected'"?>>1945년</option>
						<option value="1946" <? if($ck2_db[6] == "1946") echo "selected = 'selected'"?>>1946년</option>
						<option value="1947" <? if($ck2_db[6] == "1947") echo "selected = 'selected'"?>>1947년</option>
						<option value="1948" <? if($ck2_db[6] == "1948") echo "selected = 'selected'"?>>1948년</option>
						<option value="1949" <? if($ck2_db[6] == "1949") echo "selected = 'selected'"?>>1949년</option>
						<option value="1950" <? if($ck2_db[6] == "1950") echo "selected = 'selected'"?>>1950년</option>
						<option value="1951" <? if($ck2_db[6] == "1951") echo "selected = 'selected'"?>>1951년</option>
						<option value="1952" <? if($ck2_db[6] == "1952") echo "selected = 'selected'"?>>1952년</option>
						<option value="1953" <? if($ck2_db[6] == "1953") echo "selected = 'selected'"?>>1953년</option>
						<option value="1954" <? if($ck2_db[6] == "1954") echo "selected = 'selected'"?>>1954년</option>
						<option value="1955" <? if($ck2_db[6] == "1955") echo "selected = 'selected'"?>>1955년</option>
						<option value="1956" <? if($ck2_db[6] == "1956") echo "selected = 'selected'"?>>1956년</option>
						<option value="1957" <? if($ck2_db[6] == "1957") echo "selected = 'selected'"?>>1957년</option>
						<option value="1958" <? if($ck2_db[6] == "1958") echo "selected = 'selected'"?>>1958년</option>
						<option value="1959" <? if($ck2_db[6] == "1959") echo "selected = 'selected'"?>>1959년</option>
						<option value="1960" <? if($ck2_db[6] == "1960") echo "selected = 'selected'"?>>1960년</option>
						<option value="1961" <? if($ck2_db[6] == "1961") echo "selected = 'selected'"?>>1961년</option>
						<option value="1962" <? if($ck2_db[6] == "1962") echo "selected = 'selected'"?>>1962년</option>
						<option value="1963" <? if($ck2_db[6] == "1963") echo "selected = 'selected'"?>>1963년</option>
						<option value="1964" <? if($ck2_db[6] == "1964") echo "selected = 'selected'"?>>1964년</option>
						<option value="1965" <? if($ck2_db[6] == "1965") echo "selected = 'selected'"?>>1965년</option>
						<option value="1966" <? if($ck2_db[6] == "1966") echo "selected = 'selected'"?>>1966년</option>
						<option value="1967" <? if($ck2_db[6] == "1967") echo "selected = 'selected'"?>>1967년</option>
						<option value="1968" <? if($ck2_db[6] == "1968") echo "selected = 'selected'"?>>1968년</option>
						<option value="1969" <? if($ck2_db[6] == "1969") echo "selected = 'selected'"?>>1969년</option>
						<option value="1970" <? if($ck2_db[6] == "1970") echo "selected = 'selected'"?>>1970년</option>
						<option value="1971" <? if($ck2_db[6] == "1971") echo "selected = 'selected'"?>>1971년</option>
						<option value="1972" <? if($ck2_db[6] == "1972") echo "selected = 'selected'"?>>1972년</option>
						<option value="1973" <? if($ck2_db[6] == "1973") echo "selected = 'selected'"?>>1973년</option>
						<option value="1974" <? if($ck2_db[6] == "1974") echo "selected = 'selected'"?>>1974년</option>
						<option value="1975" <? if($ck2_db[6] == "1975") echo "selected = 'selected'"?>>1975년</option>
						<option value="1976" <? if($ck2_db[6] == "1976") echo "selected = 'selected'"?>>1976년</option>
						<option value="1977" <? if($ck2_db[6] == "1977") echo "selected = 'selected'"?>>1977년</option>
						<option value="1978" <? if($ck2_db[6] == "1978") echo "selected = 'selected'"?>>1978년</option>
						<option value="1979" <? if($ck2_db[6] == "1979") echo "selected = 'selected'"?>>1979년</option>
						<option value="1980" <? if($ck2_db[6] == "1980") echo "selected = 'selected'"?>>1980년</option>
						<option value="1981" <? if($ck2_db[6] == "1981") echo "selected = 'selected'"?>>1981년</option>
						<option value="1982" <? if($ck2_db[6] == "1982") echo "selected = 'selected'"?>>1982년</option>
						<option value="1983" <? if($ck2_db[6] == "1983") echo "selected = 'selected'"?>>1983년</option>
						<option value="1984" <? if($ck2_db[6] == "1984") echo "selected = 'selected'"?>>1984년</option>
						<option value="1985" <? if($ck2_db[6] == "1985") echo "selected = 'selected'"?>>1985년</option>
						<option value="1986" <? if($ck2_db[6] == "1986") echo "selected = 'selected'"?>>1986년</option>
						<option value="1987" <? if($ck2_db[6] == "1987") echo "selected = 'selected'"?>>1987년</option>
						<option value="1988" <? if($ck2_db[6] == "1988") echo "selected = 'selected'"?>>1988년</option>
						<option value="1989" <? if($ck2_db[6] == "1989") echo "selected = 'selected'"?>>1989년</option>
						<option value="1990" <? if($ck2_db[6] == "1990") echo "selected = 'selected'"?>>1990년</option>
						<option value="1991" <? if($ck2_db[6] == "1991") echo "selected = 'selected'"?>>1991년</option>
						<option value="1992" <? if($ck2_db[6] == "1992") echo "selected = 'selected'"?>>1992년</option>
						<option value="1993" <? if($ck2_db[6] == "1993") echo "selected = 'selected'"?>>1993년</option>
						<option value="1994" <? if($ck2_db[6] == "1994") echo "selected = 'selected'"?>>1994년</option>
						<option value="1995" <? if($ck2_db[6] == "1995") echo "selected = 'selected'"?>>1995년</option>
						<option value="1996" <? if($ck2_db[6] == "1996") echo "selected = 'selected'"?>>1996년</option>						
						
					</select>&nbsp;&nbsp;

					<select name="sur_birth_m" style="width:75px;height:30px"">
						<option value="">월 선택</option>
						<option value="1" <? if($ck2_db[7] == "1") echo "selected = 'selected'"?>>1월</option>
						<option value="2" <? if($ck2_db[7] == "2") echo "selected = 'selected'"?>>2월</option>
						<option value="3" <? if($ck2_db[7] == "3") echo "selected = 'selected'"?>>3월</option>
						<option value="4" <? if($ck2_db[7] == "4") echo "selected = 'selected'"?>>4월</option>
						<option value="5" <? if($ck2_db[7] == "5") echo "selected = 'selected'"?>>5월</option>
						<option value="6" <? if($ck2_db[7] == "6") echo "selected = 'selected'"?>>6월</option>
						<option value="7" <? if($ck2_db[7] == "7") echo "selected = 'selected'"?>>7월</option>
						<option value="8" <? if($ck2_db[7] == "8") echo "selected = 'selected'"?>>8월</option>
						<option value="9" <? if($ck2_db[7] == "9") echo "selected = 'selected'"?>>9월</option>
						<option value="10" <? if($ck2_db[7] == "10") echo "selected = 'selected'"?>>10월</option>
						<option value="11" <? if($ck2_db[7] == "11") echo "selected = 'selected'"?>>11월</option>
						<option value="12" <? if($ck2_db[7] == "12") echo "selected = 'selected'"?>>12월</option>						
					</select>&nbsp;&nbsp;
					
					<select name="sur_birth_d" style="width:75px;height:30px" >
						<option value="">일 선택</option>
						<option value="1" <? if($ck2_db[8] == "1") echo "selected = 'selected'"?>>1일</option>
						<option value="2" <? if($ck2_db[8] == "2") echo "selected = 'selected'"?>>2일</option>
						<option value="3" <? if($ck2_db[8] == "3") echo "selected = 'selected'"?>>3일</option>
						<option value="4" <? if($ck2_db[8] == "4") echo "selected = 'selected'"?>>4일</option>
						<option value="5" <? if($ck2_db[8] == "5") echo "selected = 'selected'"?>>5일</option>
						<option value="6" <? if($ck2_db[8] == "6") echo "selected = 'selected'"?>>6일</option>
						<option value="7" <? if($ck2_db[8] == "7") echo "selected = 'selected'"?>>7일</option>
						<option value="8" <? if($ck2_db[8] == "8") echo "selected = 'selected'"?>>8일</option>
						<option value="9" <? if($ck2_db[8] == "9") echo "selected = 'selected'"?>>9일</option>
						<option value="10" <? if($ck2_db[8] == "10") echo "selected = 'selected'"?>>10일</option>
						<option value="11" <? if($ck2_db[8] == "11") echo "selected = 'selected'"?>>11일</option>
						<option value="12" <? if($ck2_db[8] == "12") echo "selected = 'selected'"?>>12일</option>
						<option value="13" <? if($ck2_db[8] == "13") echo "selected = 'selected'"?>>13일</option>
						<option value="14" <? if($ck2_db[8] == "14") echo "selected = 'selected'"?>>14일</option>
						<option value="15" <? if($ck2_db[8] == "15") echo "selected = 'selected'"?>>15일</option>
						<option value="16" <? if($ck2_db[8] == "16") echo "selected = 'selected'"?>>16일</option>
						<option value="17" <? if($ck2_db[8] == "17") echo "selected = 'selected'"?>>17일</option>
						<option value="18" <? if($ck2_db[8] == "18") echo "selected = 'selected'"?>>18일</option>
						<option value="19" <? if($ck2_db[8] == "19") echo "selected = 'selected'"?>>19일</option>
						<option value="20" <? if($ck2_db[8] == "20") echo "selected = 'selected'"?>>20일</option>
						<option value="21" <? if($ck2_db[8] == "21") echo "selected = 'selected'"?>>21일</option>
						<option value="22" <? if($ck2_db[8] == "22") echo "selected = 'selected'"?>>22일</option>
						<option value="23" <? if($ck2_db[8] == "23") echo "selected = 'selected'"?>>23일</option>
						<option value="24" <? if($ck2_db[8] == "24") echo "selected = 'selected'"?>>24일</option>
						<option value="25" <? if($ck2_db[8] == "25") echo "selected = 'selected'"?>>25일</option>
						<option value="26" <? if($ck2_db[8] == "26") echo "selected = 'selected'"?>>26일</option>
						<option value="27" <? if($ck2_db[8] == "27") echo "selected = 'selected'"?>>27일</option>
						<option value="28" <? if($ck2_db[8] == "28") echo "selected = 'selected'"?>>28일</option>
						<option value="29" <? if($ck2_db[8] == "29") echo "selected = 'selected'"?>>29일</option>
						<option value="30" <? if($ck2_db[8] == "30") echo "selected = 'selected'"?>>30일</option>
						<option value="31" <? if($ck2_db[8] == "31") echo "selected = 'selected'"?>>31일</option>
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
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_god" value= "기독교" <? if($ck2_db[10] == "기독교") echo "checked"?>>&nbsp;기독교&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_god" value= "불교" <? if($ck2_db[10] == "불교") echo "checked"?>>&nbsp;불교&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_god" value= "천주교" <? if($ck2_db[10] == "천주교") echo "checked"?>>&nbsp;천주교&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_god" value= "기타" <? if($ck2_db[10] == "기타") echo "checked"?>>&nbsp;기타&nbsp;
					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_god_txt" <? if($ck2_db[11]) echo "value='$ck2_db[11]'"?>>&nbsp;					
				</td>
				
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>최종학력</b></td>				
				<td colspan="3" width = "45%"  align="center" bgcolor="F9F9FB">
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_edu" value= "초졸" <? if($ck2_db[12] == "초졸") echo "checked"?>>&nbsp;초졸&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_edu" value= "중졸" <? if($ck2_db[12] == "중졸") echo "checked"?>>&nbsp;중졸&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_edu" value= "고졸" <? if($ck2_db[12] == "고졸") echo "checked"?>>&nbsp;고졸&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_edu" value= "대졸" <? if($ck2_db[12] == "대졸") echo "checked"?>>&nbsp;대졸&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_edu" value= "대학원이상" <? if($ck2_db[12] == "대학원이상") echo "checked"?>>&nbsp;대학원 이상&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_edu" value= "기타" <? if($ck2_db[12] == "기타") echo "checked"?>>&nbsp;기타&nbsp;
					<input type="text" style="width:65px;height:30px;vertical-align: middle;"  name="sur_edu_txt" <? if($ck2_db[13]) echo "value='$ck2_db[13]'"?>>				
				</td>
			</tr>
			
			<?
				//체크박스 항목을 불러와서 배열에 저장
				$ck_row1 = explode("&!#",$ck2_db[14]);
				
				/*
				$same = 0;
				for($i=0; $i<7; $i++)
				{
					if($ck_row[$i] == "없음") $same++;
				}
				if($same==1) echo "checked='checked'";
				*/
			?>

			<tr>		 
				<td rowspan = "3" width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>가족력</b></td>
				<td width = "4" height="20" align="center" bgcolor="F9F9FB"><b>부</b></td>
				<td colspan="6" width = "45%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "없음" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row1[$i] == "없음") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;없음&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "당뇨" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row1[$i] == "당뇨") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;당뇨&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "고혈압" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row1[$i] == "고혈압") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;고혈압&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "뇌졸증" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row1[$i] == "뇌졸증") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;뇌졸증&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "치매" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row1[$i] == "치매") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;치매&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "심장질환" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row1[$i] == "심장질환") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;심장질환&nbsp;&nbsp;&nbsp;			
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm1[]" value= "암" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row1[$i] == "암") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;암&nbsp;&nbsp;&nbsp;										
					기타&nbsp;&nbsp;<input type="text" style="width:300px;height:30px;vertical-align: middle;"  name="sur_fm1_txt" <? if($ck2_db[17]) echo "value='$ck2_db[15]'"?>>&nbsp;					
				</td>
			</tr>

			<?
				//체크박스 항목을 불러와서 배열에 저장
				$ck_row2 = explode("&!#",$ck2_db[16]);				
			?>
			
			<tr>
				<td width = "4" height="20" align="center" bgcolor="F9F9FB"><b>모</b></td>								
				<td colspan="6" width = "45%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "없음" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row2[$i] == "없음") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;없음&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "당뇨" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row2[$i] == "당뇨") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;당뇨&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "고혈압" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row2[$i] == "고혈압") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;고혈압&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "뇌졸증" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row2[$i] == "뇌졸증") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;뇌졸증&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "치매" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row2[$i] == "치매") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;치매&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "심장질환" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row2[$i] == "심장질환") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;심장질환&nbsp;&nbsp;&nbsp;			
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm2[]" value= "암" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row2[$i] == "암") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;암&nbsp;&nbsp;&nbsp;										
					기타&nbsp;&nbsp;<input type="text" style="width:300px;height:30px;vertical-align: middle;"  name="sur_fm2_txt" <? if($ck2_db[17]) echo "value='$ck2_db[17]'"?>>&nbsp;				
				</td>
			</tr>

			<?
				//체크박스 항목을 불러와서 배열에 저장
				$ck_row3 = explode("&!#",$ck2_db[18]);				
			?>
			
			<tr>
				<td width = "4" height="20" align="center" bgcolor="F9F9FB"><b>형제자매</b></td>								
				<td colspan="6" width = "45%"  align="left">&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "없음" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row3[$i] == "없음") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;없음&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "당뇨" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row3[$i] == "당뇨") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;당뇨&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "고혈압" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row3[$i] == "고혈압") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;고혈압&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "뇌졸증" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row3[$i] == "뇌졸증") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;뇌졸증&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "치매" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row3[$i] == "치매") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;치매&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "심장질환" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row3[$i] == "심장질환") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;심장질환&nbsp;&nbsp;&nbsp;			
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_fm3[]" value= "암" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row3[$i] == "암") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;암&nbsp;&nbsp;&nbsp;										
					기타&nbsp;&nbsp;<input type="text" style="width:300px;height:30px;vertical-align: middle;"  name="sur_fm3_txt" <? if($ck2_db[19]) echo "value='$ck2_db[19]'"?>>&nbsp;				

				</td>
			</tr>

			<tr>		 
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>활력징후</b></td>												
				<td colspan="7" width = "45%"  align="left">&nbsp;&nbsp;									
					혈압&nbsp;&nbsp;<input type="text" style="width:80px;height:30px;vertical-align: middle;"  name="sur_vigo1" <? if($ck2_db[20]) echo "value='$ck2_db[20]'"?>>&nbsp;mmHg&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					맥박&nbsp;&nbsp;<input type="text" style="width:80px;height:30px;vertical-align: middle;"  name="sur_vigo2" <? if($ck2_db[21]) echo "value='$ck2_db[21]'"?>>&nbsp;회/분&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					호흡&nbsp;&nbsp;<input type="text" style="width:80px;height:30px;vertical-align: middle;"  name="sur_vigo3" <? if($ck2_db[22]) echo "value='$ck2_db[22]'"?>>&nbsp;회/분&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					체온&nbsp;&nbsp;<input type="text" style="width:80px;height:30px;vertical-align: middle;"  name="sur_vigo4" <? if($ck2_db[23]) echo "value='$ck2_db[23]'"?>>&nbsp;℃					
				</td>
			</tr>

			<tr>		 
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>키/체중</b></td>												
				<td colspan="7" width = "45%"  align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;								
					 키&nbsp;&nbsp;<input type="text" style="width:80px;height:30px;vertical-align: middle;"  name="sur_height" <? if($ck2_db[24]) echo "value='$ck2_db[24]'"?>>&nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					체중&nbsp;&nbsp;<input type="text" style="width:80px;height:30px;vertical-align: middle;"  name="sur_weight" <? if($ck2_db[25]) echo "value='$ck2_db[25]'"?>>&nbsp;kg&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;										
				</td>
			</tr>

			<tr>		 
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>대상자 상태</b></td>								
				<td colspan="3" width = "45%"  align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_state" value= "와상" <? if($ck2_db[26] == "와상") echo "checked"?>>&nbsp;와상&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_state" value= "준와상" <? if($ck2_db[26] == "준와상") echo "checked"?>>&nbsp;준와상&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_state" value= "자립" <? if($ck2_db[26] == "자립") echo "checked"?>>&nbsp;자립										
				</td>
				
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>입소날짜</b></td>				
				<td width = "45%"  align="center">
					<select name="sur_enter_y" id="sur_enter_y" style="width:100px;height:30px"">
						<option value="">연도 선택</option>											
						<option value="2017" <? if($ck2_db[27] == "2017") echo "selected = 'selected'"?>>2017년</option>
						<option value="2016" <? if($ck2_db[27] == "2016") echo "selected = 'selected'"?>>2016년</option>
						<option value="2015" <? if($ck2_db[27] == "2015") echo "selected = 'selected'"?>>2015년</option>
						<option value="2014" <? if($ck2_db[27] == "2014") echo "selected = 'selected'"?>>2014년</option>
						<option value="2013" <? if($ck2_db[27] == "2013") echo "selected = 'selected'"?>>2013년</option>
						<option value="2012" <? if($ck2_db[27] == "2012") echo "selected = 'selected'"?>>2012년</option>
						<option value="2011" <? if($ck2_db[27] == "2011") echo "selected = 'selected'"?>>2011년</option>
						<option value="2010" <? if($ck2_db[27] == "2010") echo "selected = 'selected'"?>>2010년</option>
						<option value="2009" <? if($ck2_db[27] == "2009") echo "selected = 'selected'"?>>2009년</option>
						<option value="2008" <? if($ck2_db[27] == "2008") echo "selected = 'selected'"?>>2008년</option>
						<option value="2007" <? if($ck2_db[27] == "2007") echo "selected = 'selected'"?>>2007년</option>
						<option value="2006" <? if($ck2_db[27] == "2006") echo "selected = 'selected'"?>>2006년</option>
						<option value="2005" <? if($ck2_db[27] == "2005") echo "selected = 'selected'"?>>2005년</option>
						<option value="2004" <? if($ck2_db[27] == "2004") echo "selected = 'selected'"?>>2004년</option>
						<option value="2003" <? if($ck2_db[27] == "2003") echo "selected = 'selected'"?>>2003년</option>
						<option value="2002" <? if($ck2_db[27] == "2002") echo "selected = 'selected'"?>>2002년</option>
						<option value="2001" <? if($ck2_db[27] == "2001") echo "selected = 'selected'"?>>2001년</option>
						<option value="2000" <? if($ck2_db[27] == "2000") echo "selected = 'selected'"?>>2000년</option>
						<option value="1999" <? if($ck2_db[27] == "1999") echo "selected = 'selected'"?>>1999년</option>
						<option value="1998" <? if($ck2_db[27] == "1998") echo "selected = 'selected'"?>>1998년</option>
						<option value="1997" <? if($ck2_db[27] == "1997") echo "selected = 'selected'"?>>1997년</option>
						<option value="1996" <? if($ck2_db[27] == "1996") echo "selected = 'selected'"?>>1996년</option>
						<option value="1995" <? if($ck2_db[27] == "1995") echo "selected = 'selected'"?>>1995년</option>
						<option value="1994" <? if($ck2_db[27] == "1994") echo "selected = 'selected'"?>>1994년</option>
						<option value="1993" <? if($ck2_db[27] == "1993") echo "selected = 'selected'"?>>1993년</option>
						<option value="1992" <? if($ck2_db[27] == "1992") echo "selected = 'selected'"?>>1992년</option>
						<option value="1991" <? if($ck2_db[27] == "1991") echo "selected = 'selected'"?>>1991년</option>
						<option value="1990" <? if($ck2_db[27] == "1990") echo "selected = 'selected'"?>>1990년</option>
						<option value="1989" <? if($ck2_db[27] == "1989") echo "selected = 'selected'"?>>1989년</option>
						<option value="1988" <? if($ck2_db[27] == "1988") echo "selected = 'selected'"?>>1988년</option>
						<option value="1987" <? if($ck2_db[27] == "1987") echo "selected = 'selected'"?>>1987년</option>
						<option value="1986" <? if($ck2_db[27] == "1986") echo "selected = 'selected'"?>>1986년</option>
						<option value="1985" <? if($ck2_db[27] == "1985") echo "selected = 'selected'"?>>1985년</option>
						<option value="1984" <? if($ck2_db[27] == "1984") echo "selected = 'selected'"?>>1984년</option>
						<option value="1983" <? if($ck2_db[27] == "1983") echo "selected = 'selected'"?>>1983년</option>
						<option value="1982" <? if($ck2_db[27] == "1982") echo "selected = 'selected'"?>>1982년</option>
						<option value="1981" <? if($ck2_db[27] == "1981") echo "selected = 'selected'"?>>1981년</option>
						<option value="1980" <? if($ck2_db[27] == "1980") echo "selected = 'selected'"?>>1980년</option>
						<option value="1979" <? if($ck2_db[27] == "1979") echo "selected = 'selected'"?>>1979년</option>
						<option value="1978" <? if($ck2_db[27] == "1978") echo "selected = 'selected'"?>>1978년</option>
						<option value="1977" <? if($ck2_db[27] == "1977") echo "selected = 'selected'"?>>1977년</option>
						<option value="1976" <? if($ck2_db[27] == "1976") echo "selected = 'selected'"?>>1976년</option>
						<option value="1975" <? if($ck2_db[27] == "1975") echo "selected = 'selected'"?>>1975년</option>
						<option value="1974" <? if($ck2_db[27] == "1974") echo "selected = 'selected'"?>>1974년</option>
						<option value="1973" <? if($ck2_db[27] == "1973") echo "selected = 'selected'"?>>1973년</option>
						<option value="1972" <? if($ck2_db[27] == "1972") echo "selected = 'selected'"?>>1972년</option>
						<option value="1971" <? if($ck2_db[27] == "1971") echo "selected = 'selected'"?>>1971년</option>
						<option value="1970" <? if($ck2_db[27] == "1970") echo "selected = 'selected'"?>>1970년</option>
						<option value="1969" <? if($ck2_db[27] == "1969") echo "selected = 'selected'"?>>1969년</option>
					</select>&nbsp;&nbsp;
					
					<select name="sur_enter_m" id="sur_enter_m" style="width:75px;height:30px"">
						<option value="">월 선택</option>
						<option value="1" <? if($ck2_db[28] == "1") echo "selected = 'selected'"?>>1월</option>
						<option value="2" <? if($ck2_db[28] == "2") echo "selected = 'selected'"?>>2월</option>
						<option value="3" <? if($ck2_db[28] == "3") echo "selected = 'selected'"?>>3월</option>
						<option value="4" <? if($ck2_db[28] == "4") echo "selected = 'selected'"?>>4월</option>
						<option value="5" <? if($ck2_db[28] == "5") echo "selected = 'selected'"?>>5월</option>
						<option value="6" <? if($ck2_db[28] == "6") echo "selected = 'selected'"?>>6월</option>
						<option value="7" <? if($ck2_db[28] == "7") echo "selected = 'selected'"?>>7월</option>
						<option value="8" <? if($ck2_db[28] == "8") echo "selected = 'selected'"?>>8월</option>
						<option value="9" <? if($ck2_db[28] == "9") echo "selected = 'selected'"?>>9월</option>
						<option value="10" <? if($ck2_db[28] == "10") echo "selected = 'selected'"?>>10월</option>
						<option value="11" <? if($ck2_db[28] == "11") echo "selected = 'selected'"?>>11월</option>
						<option value="12" <? if($ck2_db[28] == "12") echo "selected = 'selected'"?>>12월</option>							
					</select>&nbsp;&nbsp;
					
					<select name="sur_enter_d" id="sur_enter_d" style="width:75px;height:30px" >
						<option value="">일 선택</option>
						<option value="1" <? if($ck2_db[29] == "1") echo "selected = 'selected'"?>>1일</option>
						<option value="2" <? if($ck2_db[29] == "2") echo "selected = 'selected'"?>>2일</option>
						<option value="3" <? if($ck2_db[29] == "3") echo "selected = 'selected'"?>>3일</option>
						<option value="4" <? if($ck2_db[29] == "4") echo "selected = 'selected'"?>>4일</option>
						<option value="5" <? if($ck2_db[29] == "5") echo "selected = 'selected'"?>>5일</option>
						<option value="6" <? if($ck2_db[29] == "6") echo "selected = 'selected'"?>>6일</option>
						<option value="7" <? if($ck2_db[29] == "7") echo "selected = 'selected'"?>>7일</option>
						<option value="8" <? if($ck2_db[29] == "8") echo "selected = 'selected'"?>>8일</option>
						<option value="9" <? if($ck2_db[29] == "9") echo "selected = 'selected'"?>>9일</option>
						<option value="10" <? if($ck2_db[29] == "10") echo "selected = 'selected'"?>>10일</option>
						<option value="11" <? if($ck2_db[29] == "11") echo "selected = 'selected'"?>>11일</option>
						<option value="12" <? if($ck2_db[29] == "12") echo "selected = 'selected'"?>>12일</option>
						<option value="13" <? if($ck2_db[29] == "13") echo "selected = 'selected'"?>>13일</option>
						<option value="14" <? if($ck2_db[29] == "14") echo "selected = 'selected'"?>>14일</option>
						<option value="15" <? if($ck2_db[29] == "15") echo "selected = 'selected'"?>>15일</option>
						<option value="16" <? if($ck2_db[29] == "16") echo "selected = 'selected'"?>>16일</option>
						<option value="17" <? if($ck2_db[29] == "17") echo "selected = 'selected'"?>>17일</option>
						<option value="18" <? if($ck2_db[29] == "18") echo "selected = 'selected'"?>>18일</option>
						<option value="19" <? if($ck2_db[29] == "19") echo "selected = 'selected'"?>>19일</option>
						<option value="20" <? if($ck2_db[29] == "20") echo "selected = 'selected'"?>>20일</option>
						<option value="21" <? if($ck2_db[29] == "21") echo "selected = 'selected'"?>>21일</option>
						<option value="22" <? if($ck2_db[29] == "22") echo "selected = 'selected'"?>>22일</option>
						<option value="23" <? if($ck2_db[29] == "23") echo "selected = 'selected'"?>>23일</option>
						<option value="24" <? if($ck2_db[29] == "24") echo "selected = 'selected'"?>>24일</option>
						<option value="25" <? if($ck2_db[29] == "25") echo "selected = 'selected'"?>>25일</option>
						<option value="26" <? if($ck2_db[29] == "26") echo "selected = 'selected'"?>>26일</option>
						<option value="27" <? if($ck2_db[29] == "27") echo "selected = 'selected'"?>>27일</option>
						<option value="28" <? if($ck2_db[29] == "28") echo "selected = 'selected'"?>>28일</option>
						<option value="29" <? if($ck2_db[29] == "29") echo "selected = 'selected'"?>>29일</option>
						<option value="30" <? if($ck2_db[29] == "30") echo "selected = 'selected'"?>>30일</option>
						<option value="31" <? if($ck2_db[29] == "31") echo "selected = 'selected'"?>>31일</option>
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
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_pain" value= "유"<? if($ck2_db[35] == "유") echo "checked"?>>&nbsp;유&nbsp;&nbsp;&nbsp;
					<input type="radio" style="width:23px;height:23px;vertical-align: middle;"  name="sur_pain" value= "무"<? if($ck2_db[35] == "무") echo "checked"?>>&nbsp;무&nbsp;&nbsp;&nbsp;

				</td>
				
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>NRS 점수</b></td>				
				<td colspan="3" width = "45%"  align="center" bgcolor="F9F9FB">
					<select name="sur_nrs" id="sur_nrs" style="width:120px;height:30px"">
						<option value="">점수선택</option>
						<option value="0" <? if($ck2_db[36] == "0") echo "selected = 'selected'"?>>0점</option>
						<option value="1" <? if($ck2_db[36] == "1") echo "selected = 'selected'"?>>1점</option>
						<option value="2" <? if($ck2_db[36] == "2") echo "selected = 'selected'"?>>2점</option>
						<option value="3" <? if($ck2_db[36] == "3") echo "selected = 'selected'"?>>3점</option>
						<option value="4" <? if($ck2_db[36] == "4") echo "selected = 'selected'"?>>4점</option>
						<option value="5" <? if($ck2_db[36] == "5") echo "selected = 'selected'"?>>5점</option>
						<option value="6" <? if($ck2_db[36] == "6") echo "selected = 'selected'"?>>6점</option>
						<option value="7" <? if($ck2_db[36] == "7") echo "selected = 'selected'"?>>7점</option>
						<option value="8" <? if($ck2_db[36] == "8") echo "selected = 'selected'"?>>8점</option>
						<option value="9" <? if($ck2_db[36] == "9") echo "selected = 'selected'"?>>9점</option>
						<option value="10" <? if($ck2_db[36] == "10") echo "selected = 'selected'"?>>10점</option>					
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
						
						
			<?
				//체크박스 항목을 불러와서 배열에 저장
				$ck_row4 = explode("&!#",$ck2_db[31]);				
			?>
									
			<tr>		 
				<td width = "8%" height="20" align="center" bgcolor="F9F9FB"><b>현재 병력</b></td>												
				<td width = "92%"  align="left">&nbsp;&nbsp;									
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "없음" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row4[$i] == "없음") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;없음&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "당뇨" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row4[$i] == "당뇨") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;당뇨&nbsp;&nbsp;&nbsp;					
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "뇌졸증" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row4[$i] == "뇌졸증") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;뇌졸증&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "관절염" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row4[$i] == "관절염") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;관절염&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "치매" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row4[$i] == "치매") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;치매&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "골절" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row4[$i] == "골절") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;골절&nbsp;&nbsp;&nbsp;			
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_1[]" value= "암" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row4[$i] == "암") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;암&nbsp;&nbsp;&nbsp;										
					기타&nbsp;&nbsp;<input type="text" style="width:300px;height:30px;vertical-align: middle;"  name="sur_ck2_1_txt" <? if($ck2_db[32]) echo "value='$ck2_db[32]'"?>>&nbsp;					
				</td>
			</tr>

			<?
				//체크박스 항목을 불러와서 배열에 저장
				$ck_row5 = explode("&!#",$ck2_db[33]);	
			?>
			
			<tr>		 
				<td width = "8%" height="20" align="center" bgcolor="F9F9FB"><b>과거 병력</b></td>												
				<td width = "92%"  align="left">&nbsp;&nbsp;									
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "없음" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row5[$i] == "없음") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;없음&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "당뇨" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row5[$i] == "당뇨") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;당뇨&nbsp;&nbsp;&nbsp;					
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "뇌졸증" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row5[$i] == "뇌졸증") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;뇌졸증&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "관절염" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row5[$i] == "관절염") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;관절염&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "치매" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row5[$i] == "치매") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;치매&nbsp;&nbsp;&nbsp;
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "골절" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row5[$i] == "골절") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;골절&nbsp;&nbsp;&nbsp;			
					<input type="checkbox" style="width:23px;height:23px;vertical-align: middle;"  name="sur_ck2_2[]" value= "암" <? $same = 0; for($i=0; $i<7; $i++){if($ck_row5[$i] == "암") $same++;}	if($same==1) echo "checked='checked'"; ?>>&nbsp;&nbsp;암&nbsp;&nbsp;&nbsp;										
					기타&nbsp;&nbsp;<input type="text" style="width:300px;height:30px;vertical-align: middle;"  name="sur_ck2_2_txt" <? if($ck2_db[34]) echo "value='$ck2_db[34]'"?>>&nbsp;						</td>
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