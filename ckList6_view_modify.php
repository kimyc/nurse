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
				SELECT * FROM nurse2016_ck6_view where p_key = '$p_key';
			   ";
		$ck_result = @mysql_query($ck_sql, $db_info);
		
		for($i=0; $i<52; $i++)
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
	$max_mun = 23;

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
	<form name="form" action="ckList6_viewDB.php" method ="POST">

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
					<font color="black" size=4><b>6. ROM(신체관절가동범위) 측정</b></font>
				</td>			
			</tr>
		</table>
		
		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">
			<tr>
				<td width = "5%" height="20" align="center" bgcolor="F9F9FB"><b>번호</b></td>			
				<td width = "20%"  align="center" bgcolor="F9F9FB"><b>부위</b></td>
				<td width = "30%"  align="center" bgcolor="F9F9FB"><b>운동범위</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>정상범위각도</b></td>
				<td width = "35%"  align="center" bgcolor="F9F9FB"><b>정상/비정상<font color="red">(비정상의 경우 각도입력)</font></b></td>

			</tr>

			<!--=================================================================================================================-->
			<tr>
				<td width = "5%" height="20" align="center"><b>1</b></td>			
				<td rowspan="5"  width = "20%"  align="center"><b>어깨</b></td>
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>굴곡(flextion)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~180</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_1" value= "1" <? if($ck_db[5][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_1" value= "0" <? if($ck_db[5][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_1_txt" <? if($ck_db[6]) echo "value='$ck_db[6]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>2</b></td>
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>신전(extension)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~60</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_2" value= "1" <? if($ck_db[7][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_2" value= "0" <? if($ck_db[7][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_2_txt" <? if($ck_db[8]) echo "value='$ck_db[8]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>3</b></td>			
	
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>외전(abduction)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~180</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_3" value= "1" <? if($ck_db[9][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_3" value= "0" <? if($ck_db[9][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_3_txt" <? if($ck_db[10]) echo "value='$ck_db[10]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>4</b></td>			
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>내회전(internal Rotation)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~70</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_4" value= "1" <? if($ck_db[11][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_4" value= "0" <? if($ck_db[11][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_4_txt" <? if($ck_db[12]) echo "value='$ck_db[12]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>5</b></td>			
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>외회전(External Rotation)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~90</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_5" value= "1" <? if($ck_db[13][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_5" value= "0" <? if($ck_db[13][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_5_txt" <? if($ck_db[14]) echo "value='$ck_db[14]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>6</b></td>			
				<td rowspan="3" width = "20%"  align="center"><b>팔꿈치 및 전완</b></td>
	
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>굴곡-신전(flextion-extension)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~150</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_6" value= "1" <? if($ck_db[15][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_6" value= "0" <? if($ck_db[15][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_6_txt" <? if($ck_db[16]) echo "value='$ck_db[16]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>7</b></td>			
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>회외(supination)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~80</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_7" value= "1" <? if($ck_db[17][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_7" value= "0" <? if($ck_db[17][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_7_txt" <? if($ck_db[18]) echo "value='$ck_db[18]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>8</b></td>				
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>회내(pronation)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~80</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_8" value= "1" <? if($ck_db[19][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_8" value= "0" <? if($ck_db[19][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_8_txt" <? if($ck_db[20]) echo "value='$ck_db[20]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>9</b></td>			
				<td rowspan="4" width = "20%"  align="center"><b>손목</b></td>
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>굴곡(flextion)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~80</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_9" value= "1" <? if($ck_db[21][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_9" value= "0" <? if($ck_db[21][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_9_txt" <? if($ck_db[22]) echo "value='$ck_db[22]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>10</b></td>				
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>신전(extension)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~70</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_10" value= "1" <? if($ck_db[23][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_10" value= "0" <? if($ck_db[23][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_10_txt" <? if($ck_db[24]) echo "value='$ck_db[24]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>11</b></td>				
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>척골편향(ulna deviation)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~30</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_11" value= "1" <? if($ck_db[25][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_11" value= "0" <? if($ck_db[25][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_11_txt" <? if($ck_db[26]) echo "value='$ck_db[26]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>12</b></td>			
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>요골편향(Radial deviation)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~20</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_12" value= "1" <? if($ck_db[27][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_12" value= "0" <? if($ck_db[27][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_12_txt" <? if($ck_db[28]) echo "value='$ck_db[28]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>13</b></td>			
				<td rowspan="6" width = "20%"  align="center"><b>엉덩이 관절</b></td>
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>굴곡(flextion)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~120</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_13" value= "1" <? if($ck_db[29][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_13" value= "0" <? if($ck_db[29][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_13_txt" <? if($ck_db[30]) echo "value='$ck_db[30]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>14</b></td>	
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>신전(extension)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~30</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_14" value= "1" <? if($ck_db[31][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_14" value= "0" <? if($ck_db[31][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_14_txt" <? if($ck_db[32]) echo "value='$ck_db[32]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>15</b></td>	
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>외전(abduction)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~45</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_15" value= "1" <? if($ck_db[33][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_15" value= "0" <? if($ck_db[33][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_15_txt" <? if($ck_db[34]) echo "value='$ck_db[34]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>16</b></td>	
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>내전(adduction)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~30</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_16" value= "1" <? if($ck_db[35][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_16" value= "0" <? if($ck_db[35][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_16_txt" <? if($ck_db[36]) echo "value='$ck_db[36]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>17</b></td>	
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>내회전(internal Rotation)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~45</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_17" value= "1" <? if($ck_db[37][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_17" value= "0" <? if($ck_db[37][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_17_txt" <? if($ck_db[38]) echo "value='$ck_db[38]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>18</b></td>	
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>외회전(External Rotation)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~45</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_18" value= "1" <? if($ck_db[39][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_18" value= "0" <? if($ck_db[39][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_18_txt" <? if($ck_db[40]) echo "value='$ck_db[40]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>19</b></td>			
				<td width = "20%"  align="center"><b>무릎</b></td>
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>굴곡-신전(flextion-extension)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>135~0</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_19" value= "1" <? if($ck_db[41][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_19" value= "0" <? if($ck_db[41][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_19_txt" <? if($ck_db[42]) echo "value='$ck_db[42]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>20</b></td>			
				<td rowspan="4" width = "20%"  align="center"><b>발목</b></td>
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>족배굴곡(Dorsi Flexion)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~20</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_20" value= "1" <? if($ck_db[43][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_20" value= "0" <? if($ck_db[43][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_20_txt" <? if($ck_db[44]) echo "value='$ck_db[44]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>21</b></td>	
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>족저굴곡(Planter Flexion)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~50</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_21" value= "1" <? if($ck_db[45][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_21" value= "0" <? if($ck_db[45][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_21_txt" <? if($ck_db[46]) echo "value='$ck_db[46]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>22</b></td>		
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>내반(inversion)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~35</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_22" value= "1" <? if($ck_db[47][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_22" value= "0" <? if($ck_db[47][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_22_txt" <? if($ck_db[48]) echo "value='$ck_db[48]'"?>>&nbsp;
				</td>
			</tr>
			<!--=================================================================================================================-->

			<tr>
				<td width = "5%" height="20" align="center"><b>23</b></td>		
		
				
				<td width = "30%"  align="center">
					<label>
						<font color="black" size=3><b>외반(Eversion)</b></font>
					</label>
				</td>

				<td width = "10%"  align="center">
					<font color="black" size=3><b>0~15</b></font>
				</td>

				<td width = "35%"  align="center">
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_23" value= "1" <? if($ck_db[49][0] == "1") echo "checked"?>>
						&nbsp;정상
					</label>

					&nbsp;&nbsp;
					
					<label>
						<input type="radio" style="width:23px;height:23px;vertical-align: middle;" name="sur_23" value= "0" <? if($ck_db[49][0] == "0") echo "checked"?>>
						&nbsp;비정상
					</label>

					<input type="text" style="width:100px;height:30px;vertical-align: middle;"  name="sur_23_txt" <? if($ck_db[50]) echo "value='$ck_db[50]'"?>>&nbsp;
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