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


		//DB에 입력된 값 불러오기		
		$ck_rank_sql = "
				SELECT * FROM nurse2016_ck_rank where n_key != '$n_key' and p_key = '$p_key';
			   ";		
		$ck_rank_result = @mysql_query($ck_rank_sql,$db_info);


		//잔존기능에 따른 유형 불러오기		
		$ck_Remain_sql = "
				SELECT cKRemain_type FROM nurse2016_ck1_remain where p_key = '$p_key';
			   ";
		$ck_Remain_result = @mysql_query($ck_Remain_sql);
		$ck_RemainType = mysql_result($ck_Remain_result, 0);
		
		//echo "b=".$ck_RemainType;


		//유형이 없는 경우 경고 메시지
		if(!$ck_RemainType){
				echo "<script language='javaScript'>
					alert('해당 유형이 없습니다.\\n잔존기능을 입력해주세요');
					document.location.href='main.php';
					</script>";
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

	//문제리스트 개수 가져오기
	var pbList_count = form.pbList_count.value;

	//문제리스트 개수를 숫자로 변환
	var max_mun = parseInt(pbList_count);

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
	<form name="form" action="ckList_rankDB.php" method ="POST">

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
		<table width="100%" height="20" align="center" border="0" cellspacing="0"">
			<tr>
				<td width = "100%" height="40" align="left" bgcolor="85a6ff">&nbsp;&nbsp;&nbsp;
					<font color="white" size=4><b>우선 순위(환자이름 : <font color=white><?echo $p_name?><?echo " / "; 
						if($ck_RemainType==1) echo "신체기능과 인지기능 비교적 양호";
						if($ck_RemainType==2) echo "신체기능 양호하나 중등도 치매";
						if($ck_RemainType==3) echo "와상상태이나 인지기능 양호";
						if($ck_RemainType==4) echo "와상상태이면서 중등도 치매";?></font>)
					</font></b>
				</td>			
			</tr>
		</table>
		
		<table width="100%" height="40" align="center" border="0" cellspacing="0"">

			<tr>
				<td align="right">
					<br><font><b>*1순위(중요한 문제), 순위중복가능</b></font>
				</td>			
			</tr>

		</table>

		<!--문제리스트 불러오기(유형별)-->
		<?

		//사정 5번 항목의 체크 여부
		$view5_sql = "
				SELECT p_name, sur_ck5_1, sur_ck5_2 , sur_ck5_3 , sur_ck5_4 , sur_ck5_5 , sur_ck5_6 , sur_ck5_7 , sur_ck5_8 , sur_ck5_9 , sur_ck5_10 , sur_ck5_11  FROM nurse2016_ck5_view where p_key = '$p_key';
			   ";
		$view5_result = @mysql_query($view5_sql, $db_info);

		for($i=1; $i<12; $i++)
		{
	
			mysql_data_seek($view5_result, 0);
			$view5_db = mysql_fetch_array($view5_result);
			//echo $i."=".$view5_db[$i][0]."<br>";
		}

		//문제리스트의 총 개수를 저장하는 변수
		$pbList_count = 0;
		
		//사정 5번 항목에 따른 문제리스트 보이기/숨기기 위한 변수 설정
		if($view5_db[6][0] != 5){$pbList_num1 = 1; $pbList_count++;};
		if($view5_db[3][0] != 5){$pbList_num2 = 1; $pbList_count++;};
		if($view5_db[10][0] != 5){$pbList_num3 = 1; $pbList_count++;};
		if($view5_db[4][0] != 5){$pbList_num4 = 1; $pbList_count++;};
		if($view5_db[7][0] != 5){$pbList_num5 = 1; $pbList_count++;};
		if($view5_db[8][0] != 5){$pbList_num6 = 1; $pbList_count++;};
		if($view5_db[0][0] != 5){$pbList_num7 = 1; $pbList_count++;};
		if($view5_db[1][0] != 5){$pbList_num8 = 1; $pbList_count++;};
		if($view5_db[2][0] != 5){$pbList_num9 = 1; $pbList_count++;};
		if($view5_db[5][0] != 5){$pbList_num10 = 1; $pbList_count++;};
		if($view5_db[11][0] != 5){$pbList_num11 = 1; $pbList_count++;};
		if($view5_db[9][0] != 5){$pbList_num12 = 1; $pbList_count++;};

		/*
		echo "num1=".$pbList_num1."<br>";
		echo "num2=".$pbList_num2."<br>";
		echo "num3=".$pbList_num3."<br>";
		echo "num4=".$pbList_num4."<br>";
		echo "num5=".$pbList_num5."<br>";
		echo "num6=".$pbList_num6."<br>";
		echo "num7=".$pbList_num7."<br>";
		echo "num8=".$pbList_num8."<br>";
		echo "num9=".$pbList_num9."<br>";
		echo "num10=".$pbList_num10."<br>";
		echo "num11=".$pbList_num11."<br>";
		echo "num12=".$pbList_num12."<br>";
		echo "pbList_count=".$pbList_count;
		*/
		
		//사정 5번 항목에 따른 문제리스트 보이기/숨기기 위한 SQL구문에 사용할 변수 설정
		if($pbList_num1==1){$pbList_SQL1 = ' or pbList_num = 1';};
		if($pbList_num2==1){$pbList_SQL2 = ' or pbList_num = 2';};
		if($pbList_num3==1){$pbList_SQL3 = ' or pbList_num = 3';};
		if($pbList_num4==1){$pbList_SQL4 = ' or pbList_num = 4';};
		if($pbList_num5==1){$pbList_SQL5 = ' or pbList_num = 5';};
		if($pbList_num6==1){$pbList_SQL6 = ' or pbList_num = 6';};
		if($pbList_num7==1){$pbList_SQL7 = ' or pbList_num = 7';};
		if($pbList_num8==1){$pbList_SQL8 = ' or pbList_num = 8';};
		if($pbList_num9==1){$pbList_SQL9 = ' or pbList_num = 9';};
		if($pbList_num10==1){$pbList_SQL10 = ' or pbList_num = 10';};
		if($pbList_num11==1){$pbList_SQL11 = ' or pbList_num = 11';};
		if($pbList_num12==1){$pbList_SQL12 = ' or pbList_num = 12';};
		

		//사정 4번 항목의 체크 여부
		$view4_sql = "
				SELECT sur_ck4_sum FROM nurse2016_ck4_view where p_key = '$p_key';
			   ";
		$view4_result = @mysql_query($view4_sql, $db_info);

		for($i=1; $i<2; $i++)
		{
	
			mysql_data_seek($view4_result, 0);
			$view4_db = mysql_fetch_array($view4_result);
			//echo "aaa=".$view4_db['sur_ck4_sum']."<br>";
		}		

		//사정 4번 항목에 따른 문제리스트 보이기/숨기기 위한 SQL구문에 사용할 변수 설정
		if($view4_db['sur_ck4_sum']<=19){$pbList_num13 = 1; $pbList_count++;};
		
		if($pbList_num13==1){$pbList_SQL13 = ' or pbList_num = 13';};



		//사정 9번 항목의 체크 여부
		$view9_sql = "
				SELECT sur_ck9_2 FROM nurse2016_ck9_view where p_key = '$p_key';
			   ";
		$view9_result = @mysql_query($view9_sql, $db_info);

		for($i=1; $i<2; $i++)
		{
	
			mysql_data_seek($view9_result, 0);
			$view9_db = mysql_fetch_array($view9_result);
			//echo "aaa=".$view9_db['sur_ck9_2']."<br>";
		}		

		//사정 9번 항목에 따른 문제리스트 보이기/숨기기 위한 SQL구문에 사용할 변수 설정
		if($view9_db['sur_ck9_2']!=4){$pbList_num14 = 1; $pbList_count++;};
		
		if($pbList_num14==1){$pbList_SQL14 = ' or pbList_num = 14';};




		//사정 11번 항목의 체크 여부
		$view11_sql = "
				SELECT sur_ck11_5, sur_ck11_6, sur_ck11_7, sur_ck11_8 FROM nurse2016_ck11_view where p_key = '$p_key';
			   ";
		$view11_result = @mysql_query($view11_sql, $db_info);

		for($i=1; $i<2; $i++)
		{
	
			mysql_data_seek($view11_result, 0);
			$view11_db = mysql_fetch_array($view11_result);
			//echo "aaa=".$view11_db['sur_ck11_2']."<br>";
		}		


		//사정 11번 항목에 따른 문제리스트 보이기/숨기기 위한 SQL구문에 사용할 변수 설정
		if($view11_db['sur_ck11_5']<=2 || $view11_db['sur_ck11_7']<=2 || ($view11_db['sur_ck11_6']==2 || $view11_db['sur_ck11_6']==3) || ($view11_db['sur_ck11_8']==2 || $view11_db['sur_ck11_8']==3)){$pbList_num15 = 1; $pbList_count++;};
		
		if($pbList_num15==1){$pbList_SQL15 = ' or pbList_num = 15';};





		//사정 8번 항목의 체크 여부
		$view8_sql = "
				SELECT sur_ck8_3, sur_ck8_4, sur_ck8_6, sur_ck8_8, sur_ck8_10, sur_ck8_16, sur_ck8_17, sur_ck8_21 FROM nurse2016_ck8_view where p_key = '$p_key';
			   ";
		$view8_result = @mysql_query($view8_sql, $db_info);

		for($i=1; $i<2; $i++)
		{
	
			mysql_data_seek($view8_result, 0);
			$view8_db = mysql_fetch_array($view8_result);
			//echo "aaa=".$view8_db['sur_ck8_2']."<br>";
		}		

		$sur_ck8_sum = $view8_db['sur_ck8_3']+$view8_db['sur_ck8_4']+$view8_db['sur_ck8_6']+$view8_db['sur_ck8_8']+$view8_db['sur_ck8_10']+$view8_db['sur_ck8_16']+$view8_db['sur_ck8_17']+$view8_db['sur_ck8_21'];


		//사정 8번 항목에 따른 문제리스트 보이기/숨기기 위한 SQL구문에 사용할 변수 설정
		if($sur_ck8_sum!=0){$pbList_num16 = 1; $pbList_count++;};
		
		if($pbList_num16==1){$pbList_SQL16 = ' or pbList_num = 16';};






		//사정 11번 항목(3번)의 체크 여부
		$view11_sql = "
				SELECT sur_ck11_3 FROM nurse2016_ck11_view where p_key = '$p_key';
			   ";
		$view11_result = @mysql_query($view11_sql, $db_info);

		for($i=1; $i<2; $i++)
		{
	
			mysql_data_seek($view11_result, 0);
			$view11_db = mysql_fetch_array($view11_result);
			//echo "aaa=".$view11_db['sur_ck11_3']."<br>";
		}		


		//사정 11번 항목(3번)에 따른 문제리스트 보이기/숨기기 위한 SQL구문에 사용할 변수 설정
		if($view11_db['sur_ck11_3']==2 || $view11_db['sur_ck11_3']==3){$pbList_num17 = 1; $pbList_count++;};
		
		if($pbList_num17==1){$pbList_SQL17 = ' or pbList_num = 17';};





		//사정 1번 항목의 체크 여부
		$view2_sql = "
				SELECT sur_pain FROM nurse2016_ck2_view where p_key = '$p_key';
			   ";
		$view2_result = @mysql_query($view2_sql, $db_info);

		for($i=1; $i<2; $i++)
		{
	
			mysql_data_seek($view2_result, 0);
			$view2_db = mysql_fetch_array($view2_result);
			//echo "aaa=".$view2_db['sur_pain']."<br>";
		}		


		//사정 1번 항목에 따른 문제리스트 보이기/숨기기 위한 SQL구문에 사용할 변수 설정
		if($view2_db['sur_pain']=="유" || $view2_db['sur_pain']==3){$pbList_num18 = 1; $pbList_count++;};
		
		if($pbList_num18==1){$pbList_SQL18 = ' or pbList_num = 18';};







		//DB에 입력된 유형별 문제리스트 불러오기		
		$pbList_sql = "
				SELECT pbList_num, pbList_txt FROM nurse2016_pbListType where pbList_type = $ck_RemainType and (pbList_num = 100 $pbList_SQL1 $pbList_SQL2 $pbList_SQL3 $pbList_SQL4 $pbList_SQL5 $pbList_SQL6 $pbList_SQL7 $pbList_SQL8 $pbList_SQL9 $pbList_SQL10 $pbList_SQL11 $pbList_SQL12 $pbList_SQL13 $pbList_SQL14 $pbList_SQL15 $pbList_SQL16 $pbList_SQL17 $pbList_SQL18) order by rec_key asc
			   ";
		$pbList_result = @mysql_query($pbList_sql, $db_info);

		//echo "sql=".$pbList_sql."<br>";

		/*
		for($i=0; $i<$pbList_count; $i++)
		{	
			mysql_data_seek($pbList_result, $i);
			$pbList = mysql_fetch_array($pbList_result);
			echo $pbList['pbList_num'].$pbList['pbList_txt']."<br>";
		}
		*/

		//echo "<br>aa=".$pbList_count;

		?>
	


		<table width="100%" height="20" align="center" border="1" cellspacing="0" class="bbs_wm">		
			<tr>
				<td width = "10%" height="20" align="center" bgcolor="F9F9FB"><b>번호</b></td>			
				<td width = "70%"  align="center" bgcolor="F9F9FB"><b>내용</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>우선 순위</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>입력자1</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>입력자2</b></td>
				<td width = "10%"  align="center" bgcolor="F9F9FB"><b>평균순위</b></td>
			</tr>

			<?

			for($i=0; $i<$pbList_count; $i++)
			{	

			?>

				<tr>

					<td width = "10%" height="20" align="center"><b><?echo $i+1?></b></td>			
					<td width = "70%"  align="center">					
						<b>
							<?
								mysql_data_seek($pbList_result, $i);
								$pbList = mysql_fetch_array($pbList_result);
								echo $pbList['pbList_txt'];
							?>
						</b>				
					</td>
					
					<td width = "10%"  align="center">
						<select name="sur_rank_<?echo $pbList['pbList_num']?>" style="width:75px;height:30px"">
							<option value="">선택</option>
							
							<?
							for($j=1; $j<=$pbList_count; $j++)
							{
							?>
								<option value="<?echo $j?>"><?echo $j?>순위</option>
							<?
							}
							?>

						</select>&nbsp;&nbsp;
					</td>

					<td width = "10%"  align="center">
						<font>
							<?
								//입력자1의 입력내용
								mysql_data_seek($ck_rank_result, 0);
								$ck_rank1_db = mysql_fetch_array($ck_rank_result);
								$ckRankNum = 'ckRank_'.$pbList['pbList_num'];
								echo $ck_rank1_db[$ckRankNum];
							?>
						</font>
					</td>

					<td width = "10%"  align="center">
						<font>
							<?
								//입력자2의 입력내용
								mysql_data_seek($ck_rank_result, 1);
								$ck_rank2_db = mysql_fetch_array($ck_rank_result);
								$ckRankNum = 'ckRank_'.$pbList['pbList_num'];
								echo $ck_rank2_db[$ckRankNum];
							?>
						</font>
					</td>

					<td width = "10%"  align="center">
						<font><? $rank_avg = ($ck_rank1_db[$ckRankNum]+$ck_rank2_db[$ckRankNum])/2; echo round($rank_avg,2);?></font>
					</td>
				</tr>
			
			<?
			}
			?>

		<!--사정에서 선택한 항목만 보이도록 SQL 구문 계속 가져가기-->
		<input type="hidden" name="pbList_sql" size=5% value="<?=$pbList_sql?>">

		<input type="hidden" name="pbList_count" size=5% value="<?=$pbList_count?>">
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