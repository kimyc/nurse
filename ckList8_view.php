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
	$max_mun = 22;

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
	<form name="form" action="ckList8_viewDB.php" method ="POST">

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
					<font color="black" size=4><b>8. 행동변화</b></font>
				</td>			
			</tr>
		</table>

		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">

			<tr>
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>번호</b></td>			
				<td width = "70%"  align="center" bgcolor="F9F9FB"><b>문항</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>그렇다</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>아니다</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>측정불능</b></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>1</b></td>			
				<td width = "70%"  align="center"><b>사람들이 무엇을 훔쳤다고 믿거나 자기를 해하려 한다고 잘못 믿고 있다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_1" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_1" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_1" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>2</b></td>			
				<td width = "70%"  align="center"><b>헛것을 보거나 환청을 듣는다</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_2" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_2" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_2" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>3</b></td>			
				<td width = "70%"  align="center"><b>슬퍼보이거나 기분이 처져 있으며 때로 울기도 한다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_3" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_3" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_3" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>4</b></td>			
				<td width = "70%"  align="center"><b>밤에 자다가 일어나 주위의 사람을 깨우거나 아침에 너무 일찍일어난다.<br>또는 낮에는 지나치게 잠을 자고 밤에는 잠을 이루지 못한다. </b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_4" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_4" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_4" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>5</b></td>			
				<td width = "70%"  align="center"><b>주위사람이 도와주려 할 때 도와주는 것에 저항한다. </b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_5" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_5" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_5" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>6</b></td>			
				<td width = "70%"  align="center"><b>한 군데 가만히 있지 못하고, 서성거리거나 왔다갔다 하며 안절부절 못한다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_6" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_6" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_6" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>7</b></td>			
				<td width = "70%"  align="center"><b>길을 잃거나 헤맨 적이 있다. 외출하면 집이나 병원, 시설로 혼자 들어 올 수 없다. </b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_7" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_7" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_7" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>8</b></td>			
				<td width = "70%"  align="center"><b>화를 내며 폭언이나 촉행을 하는 등 위협적인 행동을 보인다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_8" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_8" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_8" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>9</b></td>			
				<td width = "70%"  align="center"><b>혼자서 밖으로 나가려고 해서 눈을 뗄 수가 없다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_9" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_9" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_9" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>10</b></td>			
				<td width = "70%"  align="center"><b>물건을 망가트리거나 부순다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_10" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_10" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_10" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>11</b></td>			
				<td width = "70%"  align="center"><b>의미 없거나 부적절한 행동을 자주 보인다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_11" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_11" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_11" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>12</b></td>			
				<td width = "70%"  align="center"><b>돈이나 물건을 장롱같이 찾기 어려운 곳에 감춘다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_12" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_12" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_12" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>13</b></td>			
				<td width = "70%"  align="center"><b>옷을 부적절하게 입는다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_13" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_13" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_13" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>14</b></td>			
				<td width = "70%"  align="center"><b>대소변을 벽이나 옷에 바르는 등 행위를 한다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_14" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_14" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_14" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>15</b></td>			
				<td width = "70%"  align="center"><b>가스불이나 담뱃불, 연탄불과 같은 화기를 관리할 수 없다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_15" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_15" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_15" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>16</b></td>			
				<td width = "70%"  align="center"><b>혼자 있는 것을 두려워하여 누군가 옆에 있어야 한다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_16" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_16" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_16" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>17</b></td>			
				<td width = "70%"  align="center"><b>이유없이 크게 소리치고 고함을 친다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_17" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_17" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_17" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>18</b></td>			
				<td width = "70%"  align="center"><b>공공장소에서 부적절한 성적 행동을 한다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_18" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_18" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_18" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>19</b></td>			
				<td width = "70%"  align="center"><b>음식이 아닌 물건 등을 먹는다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_19" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_19" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_19" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>20</b></td>			
				<td width = "70%"  align="center"><b>쓸데 없이 간섭하거나 참견한다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_20" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_20" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_20" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>21</b></td>			
				<td width = "70%"  align="center"><b>식습관 및 식욕변화를 보이거나 이유없이 식사를 거부한다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_21" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_21" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_21" value= "N"></td>
			</tr>

			<tr>
				<td width = "10%" height="20" align="center"><b>22</b></td>			
				<td width = "70%"  align="center"><b>귀찮을 정도로 붙어 따라 다닌다.</b></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_22" value= "1"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_22" value= "0"></td>
				<td width = "10%"  align="center"><input type="radio" style="width:23px;height:23px"  name="sur_22" value= "N"></td>
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