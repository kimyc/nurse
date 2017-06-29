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
	$max_mun = 15;

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
	<form name="form" action="ckList1_remainDB.php" method ="POST">

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
		<table width="100%" height="20" align="center" border="0" cellspacing="0"">
			<tr>
				<td width = "100%" height="40" align="left" bgcolor="85a6ff">&nbsp;&nbsp;&nbsp;
					<font color="white" size=4><b>잔존기능 체크리스트(환자이름 : <font color=white><?echo $p_name?></font>)</font></b>
				</td>			
			</tr>
		</table>
		
		<table width="100%" height="20" align="center" border="0" cellspacing="0"">
			<tr>
				<td>
					<br>
				</td>			
			</tr>
		</table>

		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">

			<tr>
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>번호</b></td>			
				<td width = "70%"  align="center" bgcolor="F9F9FB"><b>문항</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>그렇다</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>아니다</b></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>1</b></td>			
				<td width = "70%"  align="center"><b>기저귀 교환을 위해 지지해주면 누운상태에서 스스로 엉덩이를 드는 것 가능</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_1" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_1" value= "0"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>2</b></td>			
				<td width = "70%"  align="center"><b>침상 내 체위변경 시 다리에 힘을 주어 부분적으로 체중을 지지할 수 있음</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_2" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_2" value= "0"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>3</b></td>			
				<td width = "70%"  align="center"><b>침상 내 체위변경 시 팔의 힘으로 지지할 수 있음</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_3" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_3" value= "0"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>4</b></td>			
				<td width = "70%"  align="center"><b>침상에서 휠체어로 이동시 도우미의 도움을 받아 다리에 힘을 주어 디딜 수 있음</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_4" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_4" value= "0"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>5</b></td>			
				<td width = "70%"  align="center"><b>침상에서 휠체어로 이동시 도우미를 붙잡고 지지할 수 있음(팔의 지지)</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_5" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_5" value= "0"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>6</b></td>			
				<td width = "70%"  align="center"><b>1인의 보조로 독립적 보행이 가능-안전을 위해 보조 필요</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_6" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_6" value= "0"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>7</b></td>			
				<td width = "70%"  align="center"><b>노인 자신이 언어를 사용하여 의사소통 가능함</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_7" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_7" value= "0"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>8</b></td>			
				<td width = "70%"  align="center"><b>원하는 것에 대해 소리를 내거나 손짓을 하는 등 비언어적인 요구표현이 가능함</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_8" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_8" value= "0"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>9</b></td>			
				<td width = "70%"  align="center"><b>‘이름이 어떻게 되십니까?’에 자신의 이름을 대답함</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_9" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_9" value= "0"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>10</b></td>			
				<td width = "70%"  align="center"><b>자녀/배우자 등 친밀감을 느끼는 가족을 알아봄</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_10" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_10" value= "0"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>11</b></td>			
				<td width = "70%"  align="center"><b>간호사/보호사등 친밀감을 느끼는 주간호제공자를 알아봄</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_11" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_11" value= "0"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>12</b></td>			
				<td width = "70%"  align="center"><b>타인에게 신체적 공격을 함</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_12" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_12" value= "0"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>13</b></td>			
				<td width = "70%"  align="center"><b>자해(비위관/도뇨관 제거,불결행위,신체적 자해 포함)를 함</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_13" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_13" value= "1"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>14</b></td>			
				<td width = "70%"  align="center"><b>타인에게 언어적 공격을 함</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_14" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_14" value= "1"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>15</b></td>			
				<td width = "70%"  align="center"><b>간호사의 인사나 대화시도에 언어적,비언어적 반응이 없음</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_15" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_15" value= "1"></td>
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